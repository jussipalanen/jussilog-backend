<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\Resume;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ThumbnailService
{
    // ─── Size presets ────────────────────────────────────────────────────────

    public function resumeSizes(): array
    {
        return [
            'thumb'  => [80,  80],
            'small'  => [200, 200],
            'medium' => [400, 400],
        ];
    }

    public function productSizes(): array
    {
        return [
            'thumb'  => [150, 150],
            'small'  => [400, 400],
            'medium' => [800, 800],
        ];
    }

    // ─── Regenerate ──────────────────────────────────────────────────────────

    /**
     * Regenerate thumbnails for all resumes (or a single one) that have a photo.
     *
     * @return array{processed: int, skipped: int, errors: list<string>}
     */
    public function regenerateResumes(?Resume $single = null): array
    {
        $processed = 0;
        $skipped   = 0;
        $errors    = [];

        $query = $single
            ? collect([$single])
            : Resume::whereNotNull('photo')->cursor();

        $query->each(function (Resume $resume) use (&$processed, &$skipped, &$errors) {
            if (! $resume->photo) {
                $skipped++;

                return;
            }

            try {
                $this->deletePaths(array_values(array_filter((array) ($resume->photo_sizes ?? []))));

                $resume->photo_sizes = $this->generateFromStoragePath(
                    $resume->photo,
                    "resumes/{$resume->id}",
                    $this->resumeSizes()
                );
                $resume->saveQuietly();
                $processed++;
            } catch (\Throwable $e) {
                $errors[] = "Resume #{$resume->id}: {$e->getMessage()}";
                $skipped++;
            }
        });

        return compact('processed', 'skipped', 'errors');
    }

    /**
     * Regenerate thumbnails for all products (or a single one).
     *
     * @return array{processed: int, skipped: int, errors: list<string>}
     */
    public function regenerateProducts(?Product $single = null): array
    {
        $processed = 0;
        $skipped   = 0;
        $errors    = [];

        $query = $single
            ? collect([$single])
            : Product::cursor();

        $query->each(function (Product $product) use (&$processed, &$skipped, &$errors) {
            $changed = false;

            // Featured image
            if ($product->featured_image) {
                try {
                    $this->deletePaths(array_values(array_filter((array) ($product->featured_image_sizes ?? []))));
                    $product->featured_image_sizes = $this->generateFromStoragePath(
                        $product->featured_image,
                        "products/{$product->id}",
                        $this->productSizes()
                    );
                    $changed = true;
                } catch (\Throwable $e) {
                    $errors[] = "Product #{$product->id} featured_image: {$e->getMessage()}";
                }
            }

            // Gallery images (parallel array)
            if (is_array($product->images) && count($product->images) > 0) {
                $newSizes = [];
                foreach ($product->images as $i => $path) {
                    try {
                        $this->deletePaths(array_values(array_filter((array) ($product->images_sizes[$i] ?? []))));
                        $newSizes[] = $this->generateFromStoragePath(
                            $path,
                            "products/{$product->id}",
                            $this->productSizes()
                        );
                        $changed = true;
                    } catch (\Throwable $e) {
                        $newSizes[] = $product->images_sizes[$i] ?? null;
                        $errors[]   = "Product #{$product->id} image[{$i}]: {$e->getMessage()}";
                    }
                }
                $product->images_sizes = $newSizes;
            }

            if ($changed) {
                $product->saveQuietly();
                $processed++;
            } else {
                $skipped++;
            }
        });

        return compact('processed', 'skipped', 'errors');
    }

    // ─── Purge ───────────────────────────────────────────────────────────────

    /**
     * Delete all resume thumbnails (or a single resume's) without touching originals.
     *
     * @return array{deleted: int}
     */
    public function purgeResumeThumbnails(?Resume $single = null): array
    {
        $deleted = 0;

        $query = $single
            ? collect([$single])
            : Resume::whereNotNull('photo_sizes')->cursor();

        $query->each(function (Resume $resume) use (&$deleted) {
            $paths = array_values(array_filter((array) ($resume->photo_sizes ?? [])));
            if ($paths) {
                $this->deletePaths($paths);
                $deleted += count($paths);
            }
            $resume->photo_sizes = null;
            $resume->saveQuietly();
        });

        return compact('deleted');
    }

    /**
     * Delete all product thumbnails (or a single product's) without touching originals.
     *
     * @return array{deleted: int}
     */
    public function purgeProductThumbnails(?Product $single = null): array
    {
        $deleted = 0;

        $query = $single
            ? collect([$single])
            : Product::cursor();

        $query->each(function (Product $product) use (&$deleted) {
            $paths = [];

            foreach (array_values(array_filter((array) ($product->featured_image_sizes ?? []))) as $p) {
                $paths[] = $p;
            }

            foreach ((array) ($product->images_sizes ?? []) as $sizes) {
                foreach (array_values(array_filter((array) $sizes)) as $p) {
                    $paths[] = $p;
                }
            }

            if ($paths) {
                $this->deletePaths($paths);
                $deleted += count($paths);
            }

            $product->featured_image_sizes = null;
            $product->images_sizes         = null;
            $product->saveQuietly();
        });

        return compact('deleted');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Read a file from the default storage disk, generate thumbnails and store them.
     *
     * @param  array<string, array{0: int, 1: int}>  $sizes
     * @return array<string, string>
     */
    public function generateFromStoragePath(string $sourcePath, string $dir, array $sizes): array
    {
        $disk    = Storage::disk($this->diskName());
        $raw     = $disk->get($sourcePath);
        $manager = new ImageManager(new Driver);
        $base    = uniqid('', true);
        $ext     = 'jpg';
        $paths   = [];

        foreach ($sizes as $name => [$w, $h]) {
            $encoded = $manager->read($raw)
                ->cover($w, $h)
                ->toJpeg(85);

            $path = "{$dir}/{$base}_{$name}.{$ext}";
            $disk->put($path, (string) $encoded);
            $paths[$name] = $path;
        }

        return $paths;
    }

    private function deletePaths(array $paths): void
    {
        if ($paths) {
            Storage::disk($this->diskName())->delete($paths);
        }
    }

    private function diskName(): string
    {
        return (string) config('filesystems.default');
    }
}
