<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'total_amount',
        'shipping_address', 'phone', 'notes', 'status', 'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Helper: label dan warna badge status
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'          => 'Menunggu',
            'waiting_payment'  => 'Menunggu Pembayaran',
            'payment_uploaded' => 'Bukti Diunggah',
            'processing'       => 'Diproses',
            'shipped'          => 'Dikirim',
            'delivered'        => 'Selesai',
            'cancelled'        => 'Dibatalkan',
            default            => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'          => 'secondary',
            'waiting_payment'  => 'warning',
            'payment_uploaded' => 'info',
            'processing'       => 'primary',
            'shipped'          => 'success',
            'delivered'        => 'success',
            'cancelled'        => 'danger',
            default            => 'secondary',
        };
    }

    // Helper: format total
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    // Helper: payment method label
    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'bank_transfer' => 'Transfer Bank',
            'ovo' => 'OVO',
            'gopay' => 'GoPay',
            'dana' => 'Dana',
            'cod' => 'Cash On Delivery (COD)',
            default => ucfirst(str_replace('_', ' ', $this->payment_method)),
        };
    }
}
