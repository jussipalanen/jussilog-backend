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
        'quantity',
        'featured_image',
        'images',
        'visibility',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'quantity' => 'integer',
        'images' => 'array',
        'visibility' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['featured_image_url', 'images_urls'];

    /**
     * Get the full URL for the featured image.
     *
     * @return string|null
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (!$this->featured_image) {
            return null;
        }

        return $this->resolveImageUrl($this->featured_image);
    }

    /**
     * Get the full URLs for the images.
     *
     * @return array
     */
    public function getImagesUrlsAttribute(): array
    {
        if (!$this->images || !is_array($this->images)) {
            return [];
        }

        return array_map(function ($path) {
            return $this->resolveImageUrl($path) ?? '';
        }, $this->images);
    }

    private function resolveImageUrl(string $path): ?string
    {
        $diskName = (string) config('filesystems.default');
        $disk = Storage::disk($diskName);
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