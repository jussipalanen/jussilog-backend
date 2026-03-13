<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Resume;
use App\Services\ThumbnailService;
use Illuminate\Console\Command;

class ThumbnailsRegenerate extends Command
{
    protected $signature = 'thumbnails:regenerate
                            {--type=all : Which model to process: products, resumes, or all}
                            {--id=      : Only process a single record by ID (requires --type=products or --type=resumes)}
                            {--purge   : Delete thumbnails instead of regenerating them}';

    protected $description = 'Regenerate (or purge) thumbnail images for products and/or resumes.';

    public function handle(ThumbnailService $service): int
    {
        $type  = strtolower((string) $this->option('type'));
        $purge = (bool) $this->option('purge');
        $id    = $this->option('id') !== null ? (int) $this->option('id') : null;

        if (!in_array($type, ['all', 'products', 'resumes'], true)) {
            $this->error("Invalid --type value \"{$type}\". Use: products, resumes, or all.");
            return self::FAILURE;
        }

        if ($id !== null && $type === 'all') {
            $this->error('--id requires --type=products or --type=resumes (not "all").');
            return self::FAILURE;
        }

        $action = $purge ? 'Purging' : 'Regenerating';
        $suffix = $id !== null ? " (ID: {$id})" : '';
        $this->info("{$action} thumbnails (type: {$type}){$suffix}…");

        if (in_array($type, ['all', 'resumes'], true)) {
            $this->line('');
            $this->info('→ Resumes');

            $resume = null;
            if ($id !== null) {
                $resume = Resume::find($id);
                if (!$resume) {
                    $this->error("Resume #{$id} not found.");
                    return self::FAILURE;
                }
            }

            if ($purge) {
                $result = $service->purgeResumeThumbnails($resume);
                $this->line("  Deleted files : {$result['deleted']}");
            } else {
                $result = $service->regenerateResumes($resume);
                $this->line("  Processed : {$result['processed']}");
                $this->line("  Skipped   : {$result['skipped']}");
                $this->printErrors($result['errors']);
            }
        }

        if (in_array($type, ['all', 'products'], true)) {
            $this->line('');
            $this->info('→ Products');

            $product = null;
            if ($id !== null) {
                $product = Product::find($id);
                if (!$product) {
                    $this->error("Product #{$id} not found.");
                    return self::FAILURE;
                }
            }

            if ($purge) {
                $result = $service->purgeProductThumbnails($product);
                $this->line("  Deleted files : {$result['deleted']}");
            } else {
                $result = $service->regenerateProducts($product);
                $this->line("  Processed : {$result['processed']}");
                $this->line("  Skipped   : {$result['skipped']}");
                $this->printErrors($result['errors']);
            }
        }

        $this->line('');
        $this->info('Done.');

        return self::SUCCESS;
    }

    private function printErrors(array $errors): void
    {
        if (empty($errors)) {
            return;
        }
        $this->warn('  Errors (' . count($errors) . '):');
        foreach ($errors as $msg) {
            $this->warn("    - {$msg}");
        }
    }
}
