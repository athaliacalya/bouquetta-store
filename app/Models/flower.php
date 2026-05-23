<?php
// app/Models/Flower.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    protected $fillable = [
        'slug', 'name', 'meaning', 'price',
        'color_primary', 'color_secondary', 'sort_order', 'is_active', 'image_path',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get the image URL for this flower.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return $this->image_path;
        }
        // fallback map by slug
        $map = [
            'anemone'    => '/images/flowers/anemonen.webp',
            'carnation'  => '/images/flowers/carnationn.webp',
            'daisy'      => '/images/flowers/daisyn.webp',
            'rose'       => '/images/flowers/rosen.webp',
            'sunflower'  => '/images/flowers/sunflowern.webp',
            'tulip'      => '/images/flowers/tulipn.webp',
            'orchid'     => '/images/flowers/orchidn.webp',
            'peony'      => '/images/flowers/peonyn.webp',
            'lily'       => '/images/flowers/lilyns.webp',
            'ranunculus' => '/images/flowers/ranunculusn.webp',
        ];
        return $map[$this->slug] ?? '/images/flowers/rosen.webp';
    }

    /**
     * Format price in IDR string.
     */
    public function getPriceFormattedAttribute(): string
    {
        return 'IDR ' . number_format($this->price, 0, ',', '.');
    }
}
