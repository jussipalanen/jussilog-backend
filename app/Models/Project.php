<?php

namespace App\Models;

use App\Enums\ProjectVisibility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * Represents a portfolio project entry.
 *
 * @property int $id
 * @property array $title  Locale-keyed translations e.g. ['en' => '...', 'fi' => '...']
 * @property array $slug   Locale-keyed slugs e.g. ['en' => 'my-project', 'fi' => 'minun-projektini']
 * @property array|null $short_description  Locale-keyed translations
 * @property array|null $long_description   Locale-keyed translations
 * @property string|null $feature_image
 * @property array|null $images
 * @property ProjectVisibility $visibility
 * @property string|null $live_url
 * @property string|null $github_url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'feature_image',
        'images',
        'visibility',
        'live_url',
        'github_url',
    ];

    /**
     * The attribute casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title'             => 'array',
        'slug'              => 'array',
        'short_description' => 'array',
        'long_description'  => 'array',
        'images'            => 'array',
        'visibility'        => ProjectVisibility::class,
    ];

    /**
     * Register model lifecycle hooks.
     *
     * Auto-generates a unique slug from the title on create and on title change.
     */
    protected static function booted(): void
    {
        static::creating(function (Project $model) {
            $slugs = [];
            foreach ($model->title as $locale => $localeTitle) {
                $slugs[$locale] = static::generateUniqueSlug($localeTitle, $locale);
            }
            $model->slug = $slugs;
        });

        static::updating(function (Project $model) {
            if ($model->isDirty('title')) {
                $slugs = $model->slug ?? [];
                foreach ($model->title as $locale => $localeTitle) {
                    $slugs[$locale] = static::generateUniqueSlug($localeTitle, $locale, $model->id);
                }
                $model->slug = $slugs;
            }
        });
    }

    /**
     * Generate a unique URL-safe slug from a title.
     *
     * Appends an incrementing counter suffix if the base slug is already taken.
     *
     * @param  string   $title     The title string to slugify.
     * @param  string   $locale    The locale key to check uniqueness against (e.g. 'en', 'fi').
     * @param  int|null $excludeId Row ID to exclude from uniqueness check (used on update).
     */
    public static function generateUniqueSlug(string $title, string $locale, ?int $excludeId = null): string
    {
        $base    = Str::slug($title);
        $slug    = $base;
        $counter = 1;

        while (
            static::where("slug->{$locale}", $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }

    /**
     * The categories that belong to this project.
     *
     * @return BelongsToMany<ProjectCategory>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_project_category');
    }

    /**
     * The tags that belong to this project.
     *
     * @return BelongsToMany<ProjectTag>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ProjectTag::class, 'project_project_tag');
    }
}
