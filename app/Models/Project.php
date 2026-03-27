<?php

namespace App\Models;

use App\Enums\ProjectVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * Represents a portfolio project entry.
 *
 * @property int                   $id
 * @property string                $title
 * @property string                $slug
 * @property string|null           $short_description
 * @property string|null           $long_description
 * @property array|null            $tags              Each tag: ['name' => string, 'color' => string]
 * @property string|null           $feature_image
 * @property array|null            $images
 * @property ProjectVisibility     $visibility
 * @property string|null           $live_url
 * @property string|null           $github_url
 * @property \Carbon\Carbon        $created_at
 * @property \Carbon\Carbon        $updated_at
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
        'tags',
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
        'tags'       => 'array',
        'images'     => 'array',
        'visibility' => ProjectVisibility::class,
    ];

    /**
     * Register model lifecycle hooks.
     *
     * Auto-generates a unique slug from the title on create and on title change.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Project $model) {
            $model->slug = static::generateUniqueSlug($model->title);
        });

        static::updating(function (Project $model) {
            if ($model->isDirty('title')) {
                $model->slug = static::generateUniqueSlug($model->title, $model->id);
            }
        });
    }

    /**
     * Generate a unique URL-safe slug from a title.
     *
     * Appends an incrementing counter suffix if the base slug is already taken.
     *
     * @param  string   $title     The source title to slugify.
     * @param  int|null $excludeId Row ID to exclude from uniqueness check (used on update).
     * @return string
     */
    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base    = Str::slug($title);
        $slug    = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
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
}
