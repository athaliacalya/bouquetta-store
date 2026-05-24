<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bouquet extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'name',
        'type',          // custom | ready
        'flower_ids',
        'message',
        'ip_address',
        'total_price',
        'total_stems',
        'status',        // draft | pending | ordered | delivered
    ];

    protected $casts = [
        'flower_ids'  => 'array',
        'total_price' => 'integer',
        'total_stems' => 'integer',
    ];

    // ─────────────────────────────────────────────────────────────
    // Relations
    // ─────────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi bunga dalam bouquet
     * Menggunakan pivot quantity
     */
    public function flowers(): BelongsToMany
    {
        return $this->belongsToMany(Flower::class, 'bouquet_flowers')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Relasi cart items
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Relasi order
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    // ─────────────────────────────────────────────────────────────
    // Accessors
    // ─────────────────────────────────────────────────────────────

    /**
     * Format harga rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Ringkasan isi bunga
     * contoh: Rose ×2, Lily ×3
     */
    public function getFlowerSummaryAttribute(): string
    {
        // Jika memakai relasi flowers
        if ($this->relationLoaded('flowers') || $this->flowers()->exists()) {
            return $this->flowers
                ->map(fn($f) => $f->name . ' ×' . $f->pivot->quantity)
                ->implode(', ');
        }

        // Fallback jika hanya memakai flower_ids
        if (is_array($this->flower_ids)) {
            return implode(', ', $this->flower_ids);
        }

        return '-';
    }

    /**
     * Badge status untuk UI
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'draft'     => 'secondary',
            'pending'   => 'warning',
            'ordered'   => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }
}