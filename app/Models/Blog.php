<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

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

    protected $casts = [
        'featured_image_sizes' => 'array',
        'tags'                 => 'array',
        'visibility'           => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Blog $model) {
            $model->slug = static::generateUniqueSlug($model->title);
        });

        static::updating(function (Blog $model) {
            if ($model->isDirty('title')) {
                $model->slug = static::generateUniqueSlug($model->title, $model->id);
            }
        });
    }

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
