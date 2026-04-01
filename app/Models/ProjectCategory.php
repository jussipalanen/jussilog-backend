<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * Represents a project category used to classify portfolio projects.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ProjectCategory extends Model
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
    ];

    /**
     * Register model lifecycle hooks.
     *
     * Auto-generates a unique slug from the title on create and on title change.
     */
    protected static function booted(): void
    {
        static::creating(function (ProjectCategory $model) {
            $model->slug = static::generateUniqueSlug($model->title);
        });

        static::updating(function (ProjectCategory $model) {
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
     * @param  string  $title  The source title to slugify.
     * @param  int|null  $excludeId  Row ID to exclude from uniqueness check (used on update).
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
     * The projects that belong to this category.
     *
     * @return BelongsToMany<Project>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_project_category');
    }
}
