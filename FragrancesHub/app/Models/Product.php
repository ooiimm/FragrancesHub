<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'discount_percent', 'stock', 'image', 'is_active',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'price'            => 'decimal:2',
        'discount_percent' => 'integer',
    ];

    // Slug di-set oleh controller saat create/update
    protected static function boot()
    {
        parent::boot();
    }

    // Relasi: produk milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: produk ada di banyak cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi: produk ada di banyak order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper: format harga asli ke Rupiah
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Helper: harga setelah diskon
    public function getDiscountedPriceAttribute(): float
    {
        if ((int) $this->discount_percent > 0) {
            return (float) $this->price * (1 - $this->discount_percent / 100);
        }
        return (float) $this->price;
    }

    // Helper: apakah sedang promo?
    public function getIsOnSaleAttribute(): bool
    {
        return (int) $this->discount_percent > 0;
    }

    // Helper: format harga diskon ke Rupiah
    public function getFormattedDiscountedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->discounted_price, 0, ',', '.');
    }

    // Helper: URL gambar produk
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/no-image.png');
    }
}
