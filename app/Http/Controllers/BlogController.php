<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Handles blog post endpoints.
 */
class BlogController extends Controller
{
    /** @var list<string> */
    private const SUPPORTED_LOCALES = ['en', 'fi'];

    /**
     * List published blog posts (public).
     *
     * @group Blog
     *
     * @queryParam lang string Locale: en or fi. Defaults to en. Example: en
     */
    public function index(Request $request): JsonResponse
    {
        $locale  = $this->resolveLocale($request);
        $perPage = max(1, min(100, (int) $request->query('per_page', 15)));
        $sortBy  = in_array($request->query('sort_by'), ['id', 'created_at'], true)
            ? $request->query('sort_by') : 'created_at';
        $sortDir = $request->query('sort_dir') === 'asc' ? 'asc' : 'desc';

        $blogs = Blog::withRelations()
            ->where('visibility', true)
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        $blogs->setCollection(
            $blogs->getCollection()->map(fn (Blog $blog) => $this->formatBlog($blog, $locale))
        );

        return response()->json($blogs);
    }

    /**
     * Show a single published blog post (public).
     *
     * @group Blog
     *
     * @queryParam lang string Locale: en or fi. Defaults to en. Example: en
     */
    public function show(Request $request, string $idOrSlug): JsonResponse
    {
        $locale = $this->resolveLocale($request);
        $query  = Blog::withRelations()->where('visibility', true);

        $blog = is_numeric($idOrSlug)
            ? $query->findOrFail((int) $idOrSlug)
            : $query->where("slug->{$locale}", $idOrSlug)->firstOrFail();

        return response()->json($this->formatBlog($blog, $locale));
    }

    /**
     * List all blog posts for admin (including hidden).
     *
     * @group         Blog
     *
     * @authenticated
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $perPage = max(1, min(100, (int) $request->query('per_page', 15)));
        $sortBy  = in_array($request->query('sort_by'), ['id', 'created_at', 'visibility'], true)
            ? $request->query('sort_by') : 'created_at';
        $sortDir = $request->query('sort_dir') === 'asc' ? 'asc' : 'desc';

        $blogs = Blog::withRelations()
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        return response()->json($blogs);
    }

    /**
     * Create a blog post.
     *
     * @group         Blog
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'            => 'required|array',
            'title.en'         => 'required|string|max:255',
            'title.fi'         => 'nullable|string|max:255',
            'excerpt'          => 'nullable|array',
            'excerpt.en'       => 'nullable|string',
            'excerpt.fi'       => 'nullable|string',
            'content'          => 'required|array',
            'content.en'       => 'required|string',
            'content.fi'       => 'nullable|string',
            'blog_category_id' => 'nullable|integer|exists:blog_categories,id',
            'featured_image'   => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string|max:100',
            'visibility'       => 'boolean',
        ]);

        $data['user_id'] = $request->user()->id;
        unset($data['featured_image']);

        $blog = Blog::create($data);

        if ($request->hasFile('featured_image')) {
            $file                       = $request->file('featured_image');
            $blog->featured_image       = $this->storeBlogImage($file, $blog->id);
            $blog->featured_image_sizes = $this->generateThumbnails($file, $blog->id);
            $blog->save();
        }

        $blog->load(['author:id,first_name,last_name,name', 'category:id,name,slug']);

        return response()->json($blog, 201);
    }

    /**
     * Update a blog post.
     *
     * @group         Blog
     *
     * @authenticated
     *
     * @urlParam id integer required The blog ID. Example: 1
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title'            => 'sometimes|required|array',
            'title.en'         => 'sometimes|required|string|max:255',
            'title.fi'         => 'nullable|string|max:255',
            'excerpt'          => 'nullable|array',
            'excerpt.en'       => 'nullable|string',
            'excerpt.fi'       => 'nullable|string',
            'content'          => 'sometimes|required|array',
            'content.en'       => 'sometimes|required|string',
            'content.fi'       => 'nullable|string',
            'blog_category_id' => 'nullable|integer|exists:blog_categories,id',
            'featured_image'   => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string|max:100',
            'visibility'       => 'boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                $this->storageDisk()->delete($blog->featured_image);
            }
            if ($blog->featured_image_sizes) {
                $this->deleteThumbnails($blog->featured_image_sizes);
            }
            $file                         = $request->file('featured_image');
            $data['featured_image']       = $this->storeBlogImage($file, $blog->id);
            $data['featured_image_sizes'] = $this->generateThumbnails($file, $blog->id);
        } elseif ($request->exists('featured_image') && empty($request->input('featured_image'))) {
            if ($blog->featured_image) {
                $this->storageDisk()->delete($blog->featured_image);
            }
            if ($blog->featured_image_sizes) {
                $this->deleteThumbnails($blog->featured_image_sizes);
            }
            $data['featured_image']       = null;
            $data['featured_image_sizes'] = null;
        } else {
            unset($data['featured_image']);
        }

        $blog->update($data);
        $blog->load(['author:id,first_name,last_name,name', 'category:id,name,slug']);

        return response()->json($blog);
    }

    /**
     * Delete a blog post.
     *
     * @group         Blog
     *
     * @authenticated
     *
     * @urlParam id integer required The blog ID. Example: 1
     */
    public function destroy(int $id): JsonResponse
    {
        $blog = Blog::findOrFail($id);

        if ($blog->featured_image) {
            $this->storageDisk()->delete($blog->featured_image);
        }
        if ($blog->featured_image_sizes) {
            $this->deleteThumbnails($blog->featured_image_sizes);
        }

        $blog->delete();

        return response()->json(null, 204);
    }

    /**
     * Resolve the requested locale from the query string, defaulting to 'en'.
     */
    private function resolveLocale(Request $request): string
    {
        $lang = $request->query('lang');

        return in_array($lang, self::SUPPORTED_LOCALES, true) ? $lang : 'en';
    }

    /**
     * Format a blog post to a single resolved locale for public responses.
     *
     * @return array<string, mixed>
     */
    private function formatBlog(Blog $blog, string $locale): array
    {
        return [
            'id'                   => $blog->id,
            'user_id'              => $blog->user_id,
            'blog_category_id'     => $blog->blog_category_id,
            'title'                => $blog->title[$locale] ?? $blog->title['en'] ?? null,
            'slug'                 => $blog->slug[$locale] ?? $blog->slug['en'] ?? null,
            'excerpt'              => isset($blog->excerpt) ? ($blog->excerpt[$locale] ?? $blog->excerpt['en'] ?? null) : null,
            'content'              => $blog->content[$locale] ?? $blog->content['en'] ?? null,
            'featured_image'       => $blog->featured_image,
            'featured_image_sizes' => $blog->featured_image_sizes,
            'tags'                 => $blog->tags,
            'visibility'           => $blog->visibility,
            'created_at'           => $blog->created_at,
            'updated_at'           => $blog->updated_at,
            'author'               => $blog->relationLoaded('author') ? $blog->author : null,
            'category'             => $blog->relationLoaded('category') ? $blog->category : null,
        ];
    }

    private function storageDiskName(): string
    {
        return (string) config('filesystems.default');
    }

    private function storageDisk(): Filesystem
    {
        return Storage::disk($this->storageDiskName());
    }

    private function storeBlogImage(UploadedFile $file, int $blogId): string
    {
        $filename = 'featured_image_'.time().'.'.$file->getClientOriginalExtension();

        return $file->storeAs("blogs/{$blogId}", $filename, $this->storageDiskName());
    }

    private function generateThumbnails(UploadedFile $file, int $blogId): array
    {
        $manager = new ImageManager(new Driver);
        $disk    = $this->storageDisk();
        $base    = time();
        $ext     = 'jpg';
        $paths   = [];

        foreach ($this->imageSizes() as $name => [$w, $h]) {
            $encoded = $manager->read($file->getPathname())
                ->cover($w, $h)
                ->toJpeg(85);

            $path = "blogs/{$blogId}/{$base}_{$name}.{$ext}";
            $disk->put($path, (string) $encoded);
            $paths[$name] = $path;
        }

        return $paths;
    }

    private function deleteThumbnails(array $imageSizes): void
    {
        $disk = $this->storageDisk();

        foreach ($imageSizes as $path) {
            if ($path) {
                $disk->delete($path);
            }
        }
    }

    /** @return array<string, array{int, int}> */
    private function imageSizes(): array
    {
        return [
            'thumb'  => [400,  225],
            'medium' => [800,  450],
            'large'  => [1200, 675],
        ];
    }
}
