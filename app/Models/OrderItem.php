<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'featured_image',
        'images',
        'featured_image_url',
        'images_urls',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_title',
        'quantity',
        'unit_price',
        'sale_price',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'subtotal'   => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the effective price (sale price if available, otherwise unit price).
     */
    public function getEffectivePriceAttribute(): string
    {
        $price = $this->sale_price ?? $this->unit_price;

        return number_format((float) $price, 2);
    }

    /**
     * Get the formatted subtotal.
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return '$'.number_format((float) $this->subtotal, 2);
    }

    /**
     * Get the related product featured image path.
     */
    public function getFeaturedImageAttribute(): ?string
    {
        return $this->product?->featured_image;
    }

    /**
     * Get the related product image paths.
     *
     * @return array<int, string>
     */
    public function getImagesAttribute(): array
    {
        $images = $this->product?->images;

        return is_array($images) ? $images : [];
    }

    /**
     * Get the related product featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->product?->featured_image_url;
    }

    /**
     * Get the related product image URLs.
     *
     * @return array<int, string>
     */
    public function getImagesUrlsAttribute(): array
    {
        $imageUrls = $this->product?->images_urls;

        return is_array($imageUrls) ? $imageUrls : [];
    }
}
