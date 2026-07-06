<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'payment_method', 'phone_number', 'recipient_name',
        'recipient_account', 'amount', 'proof_image', 'status', 'payment_notes',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }

    public function getProofUrlAttribute(): ?string
    {
        return $this->proof_image
            ? Storage::disk(config('filesystems.default'))->url($this->proof_image)
            : null;
    }
}
