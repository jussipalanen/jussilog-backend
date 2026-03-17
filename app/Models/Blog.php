<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'excerpt',
        'content',
        'feature_image',
        'tags',
        'visibility',
    ];

    protected $casts = [
        'tags'       => 'array',
        'visibility' => 'boolean',
    ];

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
