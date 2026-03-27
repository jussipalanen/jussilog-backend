<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * Represents a technology/stack tag that can be assigned to portfolio projects.
 *
 * @property int            $id
 * @property string         $title
 * @property string         $slug
 * @property string         $color  Hex or named colour for the badge, e.g. "#FF2D20"
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ProjectTag extends Model
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
        'color',
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
        static::creating(function (ProjectTag $model) {
            $model->slug = static::generateUniqueSlug($model->title);
        });

        static::updating(function (ProjectTag $model) {
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
     * The projects that have this tag.
     *
     * @return BelongsToMany<Project>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_project_tag');
    }
}
