<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'session_id', 'user_id', 'product_name',
        'flower_ids', 'personal_message', 'price', 'quantity',
    ];

    protected $casts = [
        'flower_ids' => 'array',
        'price'      => 'integer',
        'quantity'   => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubtotalAttribute(): int
    {
        return $this->price * $this->quantity;
    }

    public function getSubtotalFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}