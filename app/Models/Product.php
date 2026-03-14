<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'price',
        'sale_price',
        'tax_code',
        'tax_rate',
        'quantity',
        'featured_image',
        'featured_image_sizes',
        'images',
        'images_sizes',
        'visibility',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price'                => 'decimal:2',
        'sale_price'           => 'decimal:2',
        'tax_rate'             => 'decimal:4',
        'quantity'             => 'integer',
        'images'               => 'array',
        'images_sizes'         => 'array',
        'featured_image_sizes' => 'array',
        'visibility'           => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['featured_image_url', 'featured_image_sizes_urls', 'images_urls', 'images_sizes_urls'];

    /**
     * Get the full URL for the featured image.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        return $this->resolveImageUrl($this->featured_image);
    }

    /**
     * Get the full URLs for the featured image thumbnails.
     */
    public function getFeaturedImageSizesUrlsAttribute(): array
    {
        if (! $this->featured_image_sizes) {
            return [];
        }

        return array_map(fn ($path) => $path ? $this->resolveImageUrl($path) : '', $this->featured_image_sizes);
    }

    /**
     * Get the full URLs for the images.
     */
    public function getImagesUrlsAttribute(): array
    {
        if (! $this->images) {
            return [];
        }

        return array_map(function ($path) {
            return $this->resolveImageUrl($path);
        }, $this->images);
    }

    /**
     * Get the full URLs for all photo thumbnails (parallel array to images).
     */
    public function getImagesSizesUrlsAttribute(): array
    {
        if (! $this->images_sizes) {
            return [];
        }

        return array_map(function ($sizes) {
            if (! is_array($sizes)) {
                return [];
            }

            return array_map(fn ($path) => $path ? $this->resolveImageUrl($path) : '', $sizes);
        }, $this->images_sizes);
    }

    private function resolveImageUrl(string $path): string
    {
        $diskName = (string) config('filesystems.default');
        $disk     = Storage::disk($diskName);
        if (method_exists($disk, 'temporaryUrl')) {
            return $disk->temporaryUrl($path, now()->addHour());
        }

        $url = $disk->url($path);
        if (is_string($url) && str_starts_with($url, '/')) {
            $url = url($url);
        }

        return $url;
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
