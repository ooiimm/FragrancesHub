<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'price',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: varian milik satu produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Helper: format harga ke Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Helper: combine product name dengan variant size
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->product->name} ({$this->size})";
    }
}
