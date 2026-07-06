<?php
// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'product_variant_id', 'quantity', 'variant_size'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Helper: hitung subtotal item
    public function getSubtotalAttribute(): float
    {
        if ($this->product_variant_id) {
            return $this->quantity * $this->variant->price;
        }
        return $this->quantity * $this->product->discounted_price;
    }
}
