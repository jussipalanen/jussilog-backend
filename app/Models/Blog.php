<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Blog post model with locale-keyed translatable fields.
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $blog_category_id
 * @property array $title Locale-keyed translations e.g. ['en' => '...', 'fi' => '...']
 * @property array $slug Locale-keyed slugs e.g. ['en' => 'my-post', 'fi' => 'minun-postaus']
 * @property array|null $excerpt Locale-keyed translations
 * @property array $content Locale-keyed translations
 * @property string|null $featured_image
 * @property array|null $featured_image_sizes
 * @property array|null $tags
 * @property bool $visibility
 */
class Blog extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_sizes',
        'tags',
        'visibility',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'title'                => 'array',
        'slug'                 => 'array',
        'excerpt'              => 'array',
        'content'              => 'array',
        'featured_image_sizes' => 'array',
        'tags'                 => 'array',
        'visibility'           => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Blog $model) {
            $slugs = [];
            foreach ($model->title as $locale => $localeTitle) {
                $slugs[$locale] = static::generateUniqueSlug($localeTitle, $locale);
            }
            $model->slug = $slugs;
        });

        static::updating(function (Blog $model) {
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
     * Generate a unique slug for the given locale.
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

    /** @param Builder<Blog> $query */
    public function scopeWithRelations(Builder $query): Builder
    {
        return $query->with(['author:id,first_name,last_name,name', 'category:id,name,slug']);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
