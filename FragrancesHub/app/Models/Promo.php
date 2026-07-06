<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Helper: cek apakah promo masih aktif berdasarkan tanggal
     */
    public function getIsCurrentlyActiveAttribute(): bool
    {
        $now = now();
        return $this->is_active && $now >= $this->start_date && $now <= $this->end_date;
    }

    /**
     * Helper: image URL
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
