<?php
// app/Models/Bouquet.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bouquet extends Model
{
    protected $fillable = [
        'code', 'flower_ids', 'message',
        'recipient', 'sender', 'total_price', 'status', 'ip_address',
    ];

    protected $casts = [
        'flower_ids'  => 'array',
        'total_price' => 'integer',
    ];

    /**
     * Generate a unique share code before creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Bouquet $bouquet) {
            if (empty($bouquet->code)) {
                $bouquet->code = strtoupper(Str::random(8));
            }
        });
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Calculate total price based on flowers.
     */
    public function calculatePrice(): int
    {
        $flowers = Flower::whereIn('slug', $this->flower_ids ?? [])->get();
        $perFlower = $flowers->sum('price');
        return $perFlower;
    }

    public function getTotalFormattedAttribute(): string
    {
        return 'IDR ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getShareUrlAttribute(): string
    {
        return route('bouquet.view', $this->code);
    }
}