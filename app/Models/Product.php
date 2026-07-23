<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name', 'brand', 'slug', 'category', 'price', 'original_price',
        'description', 'features', 'specifications', 'image',
        'rating_total', 'rating_count', 'stock', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'features'       => 'array',
        'specifications' => 'array',
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
    ];

    // Tự sinh slug từ tên
    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
            }
        });
    }

    // Rating trung bình
    public function getRatingAttribute(): float
    {
        if ($this->rating_count === 0) return 0;
        return round($this->rating_total / $this->rating_count, 1);
    }

    // % giảm giá
    public function getDiscountPercentAttribute(): int
    {
        if (!$this->original_price || $this->original_price <= $this->price) return 0;
        return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    // Còn hàng không
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    // URL ảnh sản phẩm (đặt ảnh vào public/images/products/<tên-file>)
    // Dùng trong blade: asset('images/products/' . $product->image)
    public function getImageUrlAttribute(): string
    {
        return asset('images/products/' . $this->image);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}