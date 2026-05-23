<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'bouquet_id', 'customer_name', 'customer_email',
        'customer_phone', 'delivery_address', 'subtotal', 'delivery_fee',
        'total', 'status', 'notes',
    ];

    protected $casts = [
        'subtotal'     => 'integer',
        'delivery_fee' => 'integer',
        'total'        => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = 'BQT-' . strtoupper(Str::random(8));
            }
        });
    }

    public function bouquet()
    {
        return $this->belongsTo(Bouquet::class);
    }

    public function getTotalFormattedAttribute(): string
    {
        return 'IDR ' . number_format($this->total, 0, ',', '.');
    }
}