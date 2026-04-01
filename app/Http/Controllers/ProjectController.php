<?php

namespace App\Http\Controllers;

use App\Enums\ProjectVisibility;
use App\Models\Project;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Handles portfolio project endpoints.
 */
class ProjectController extends Controller
{
    /** @var list<string> */
    private const SUPPORTED_LOCALES = ['en', 'fi'];

    /**
     * List published projects (public).
     *
     * @group Projects
     *
     * @queryParam lang     string Locale for translatable fields. Enum: en, fi. Default: en.
     * @queryParam per_page int    Items per page (1–100). Default: 15.
     * @queryParam sort_by  string Sort field. Enum: id, created_at. Default: created_at.
     * @queryParam sort_dir string Sort direction. Enum: asc, desc. Default: desc.
     */
    public function index(Request $request): JsonResponse
    {
        $locale  = $this->resolveLocale($request);
        $perPage = max(1, min(100, (int) $request->query('per_page', 15)));
        $sortBy  = in_array($request->query('sort_by'), ['id', 'created_at'], true)
            ? $request->query('sort_by') : 'created_at';
        $sortDir = $request->query('sort_dir') === 'asc' ? 'asc' : 'desc';

        $projects = Project::with(['categories', 'tags'])
            ->where('visibility', ProjectVisibility::SHOW)
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        $projects->through(fn ($project) => $this->formatProject($project, $locale));

        return response()->json($projects);
    }

    /**
     * Show a single published project (public).
     *
     * @group Projects
     *
     * @urlParam idOrSlug string required The project ID or locale slug. Example: my-project
     *
     * @queryParam lang string Locale for translatable fields. Enum: en, fi. Default: en.
     */
    public function show(Request $request, string $idOrSlug): JsonResponse
    {
        $locale = $this->resolveLocale($request);

        $query = Project::with(['categories', 'tags'])->where('visibility', ProjectVisibility::SHOW);

        $project = is_numeric($idOrSlug)
            ? $query->findOrFail((int) $idOrSlug)
            : $query->where("slug->{$locale}", $idOrSlug)->firstOrFail();

        return response()->json($this->formatProject($project, $locale));
    }

    /**
     * List all projects for admin (including hidden).
     *
     * @group         Projects
     *
     * @authenticated
     *
     * @queryParam lang     string Locale for translatable fields. Enum: en, fi. Default: en.
     * @queryParam per_page int    Items per page (1–100). Default: 15.
     * @queryParam sort_by  string Sort field. Enum: id, created_at, visibility. Default: created_at.
     * @queryParam sort_dir string Sort direction. Enum: asc, desc. Default: desc.
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $locale  = $this->resolveLocale($request);
        $perPage = max(1, min(100, (int) $request->query('per_page', 15)));
        $sortBy  = in_array($request->query('sort_by'), ['id', 'created_at', 'visibility'], true)
            ? $request->query('sort_by') : 'created_at';
        $sortDir = $request->query('sort_dir') === 'asc' ? 'asc' : 'desc';

        $projects = Project::with(['categories', 'tags'])
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        $projects->through(fn ($project) => $this->formatProject($project, $locale));

        return response()->json($projects);
    }

    /**
     * Show a single project for admin (including hidden).
     *
     * @group         Projects
     *
     * @authenticated
     *
     * @urlParam id   integer required The project ID. Example: 1
     *
     * @queryParam lang string Locale for translatable fields. Enum: en, fi. Default: en.
     */
    public function adminShow(Request $request, int $id): JsonResponse
    {
        $locale  = $this->resolveLocale($request);
        $project = Project::with(['categories', 'tags'])->findOrFail($id);

        return response()->json($this->formatProject($project, $locale));
    }

    /**
     * Create a project.
     *
     * @group         Projects
     *
     * @authenticated
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'                => 'required|array',
            'title.en'             => 'required|string|max:255',
            'title.fi'             => 'nullable|string|max:255',
            'short_description'    => 'nullable|array',
            'short_description.en' => 'nullable|string',
            'short_description.fi' => 'nullable|string',
            'long_description'     => 'nullable|array',
            'long_description.en'  => 'nullable|string',
            'long_description.fi'  => 'nullable|string',
            'tag_ids'              => 'nullable|array',
            'tag_ids.*'            => 'integer|exists:project_tags,id',
            'feature_image'        => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'images'               => 'nullable|array',
            'images.*'             => 'file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'visibility'           => 'nullable|in:show,hide',
            'live_url'             => 'nullable|url|max:255',
            'github_url'           => 'nullable|url|max:255',
            'category_ids'         => 'nullable|array',
            'category_ids.*'       => 'integer|exists:project_categories,id',
        ]);

        $categoryIds = $data['category_ids'] ?? [];
        $tagIds      = $data['tag_ids'] ?? [];
        unset($data['category_ids'], $data['tag_ids'], $data['feature_image'], $data['images']);

        $project = Project::create($data);

        if ($request->hasFile('feature_image')) {
            $project->feature_image = $this->storeImage($request->file('feature_image'), $project->id, 'feature');
            $project->save();
        }

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $index => $file) {
                $paths[] = $this->storeImage($file, $project->id, "image_{$index}");
            }
            $project->images = $paths;
            $project->save();
        }

        if ($categoryIds) {
            $project->categories()->sync($categoryIds);
        }

        if ($tagIds) {
            $project->tags()->sync($tagIds);
        }

        $project->load(['categories', 'tags']);

        return response()->json($this->formatProject($project, 'en'), 201);
    }

    /**
     * Update a project.
     *
     * @group         Projects
     *
     * @authenticated
     *
     * @urlParam id integer required The project ID. Example: 1
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $data = $request->validate([
            'title'                => 'sometimes|required|array',
            'title.en'             => 'sometimes|required|string|max:255',
            'title.fi'             => 'nullable|string|max:255',
            'short_description'    => 'nullable|array',
            'short_description.en' => 'nullable|string',
            'short_description.fi' => 'nullable|string',
            'long_description'     => 'nullable|array',
            'long_description.en'  => 'nullable|string',
            'long_description.fi'  => 'nullable|string',
            'tag_ids'              => 'nullable|array',
            'tag_ids.*'            => 'integer|exists:project_tags,id',
            'feature_image'        => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'images'               => 'nullable|array',
            'images.*'             => 'file|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'visibility'           => 'nullable|in:show,hide',
            'live_url'             => 'nullable|url|max:255',
            'github_url'           => 'nullable|url|max:255',
            'category_ids'         => 'nullable|array',
            'category_ids.*'       => 'integer|exists:project_categories,id',
        ]);

        $categoryIds = array_key_exists('category_ids', $data) ? $data['category_ids'] : null;
        $tagIds      = array_key_exists('tag_ids', $data) ? $data['tag_ids'] : null;
        unset($data['category_ids'], $data['tag_ids'], $data['feature_image'], $data['images']);

        if ($request->hasFile('feature_image')) {
            if ($project->feature_image) {
                $this->storageDisk()->delete($project->feature_image);
            }
            $data['feature_image'] = $this->storeImage($request->file('feature_image'), $project->id, 'feature');
        } elseif ($request->exists('feature_image') && empty($request->input('feature_image'))) {
            if ($project->feature_image) {
                $this->storageDisk()->delete($project->feature_image);
            }
            $data['feature_image'] = null;
        }

        if ($request->hasFile('images')) {
            if ($project->images) {
                foreach ($project->images as $path) {
                    $this->storageDisk()->delete($path);
                }
            }
            $paths = [];
            foreach ($request->file('images') as $index => $file) {
                $paths[] = $this->storeImage($file, $project->id, "image_{$index}");
            }
            $data['images'] = $paths;
        } elseif ($request->exists('images') && empty($request->input('images'))) {
            if ($project->images) {
                foreach ($project->images as $path) {
                    $this->storageDisk()->delete($path);
                }
            }
            $data['images'] = null;
        }

        $project->update($data);

        if ($categoryIds !== null) {
            $project->categories()->sync($categoryIds);
        }

        if ($tagIds !== null) {
            $project->tags()->sync($tagIds);
        }

        $project->load(['categories', 'tags']);

        return response()->json($this->formatProject($project, 'en'));
    }

    /**
     * Delete a project.
     *
     * @group         Projects
     *
     * @authenticated
     *
     * @urlParam id integer required The project ID. Example: 1
     */
    public function destroy(int $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        if ($project->feature_image) {
            $this->storageDisk()->delete($project->feature_image);
        }

        if ($project->images) {
            foreach ($project->images as $path) {
                $this->storageDisk()->delete($path);
            }
        }

        $project->delete();

        return response()->json(null, 204);
    }

    /**
     * Resolve the requested locale from the query string.
     *
     * Falls back to English if the locale is missing or unsupported.
     */
    private function resolveLocale(Request $request): string
    {
        $lang = $request->query('lang');

        return in_array($lang, self::SUPPORTED_LOCALES, true) ? $lang : 'en';
    }

    /**
     * Format a project for the API response, resolving translatable fields to the given locale.
     *
     * @return array<string, mixed>
     */
    private function formatProject(Project $project, string $locale): array
    {
        return [
            'id'                => $project->id,
            'title'             => $project->title[$locale] ?? $project->title['en'] ?? null,
            'slug'              => $project->slug[$locale] ?? $project->slug['en'] ?? null,
            'short_description' => $project->short_description[$locale] ?? $project->short_description['en'] ?? null,
            'long_description'  => $project->long_description[$locale] ?? $project->long_description['en'] ?? null,
            'tags'              => $project->tags,
            'feature_image'     => $project->feature_image,
            'images'            => $project->images ?? [],
            'visibility'        => $project->visibility,
            'live_url'          => $project->live_url,
            'github_url'        => $project->github_url,
            'categories'        => $project->categories,
            'created_at'        => $project->created_at,
            'updated_at'        => $project->updated_at,
        ];
    }

    /**
     * Get the configured storage disk instance.
     *
     * @return Filesystem
     */
    private function storageDisk()
    {
        return Storage::disk((string) config('filesystems.default'));
    }

    /**
     * Store a single project image and return its storage path.
     *
     * @param  string  $name  Filename prefix (e.g. "feature", "image_0").
     */
    private function storeImage(UploadedFile $file, int $projectId, string $name): string
    {
        $filename = "{$name}_".time().'.'.$file->getClientOriginalExtension();

        return $file->storeAs("projects/{$projectId}", $filename, (string) config('filesystems.default'));
    }
}
