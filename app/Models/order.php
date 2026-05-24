<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Bouquet;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'bouquet_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'delivery_city',
        'delivery_notes',
        'personal_letter',
        'subtotal',
        'delivery_fee',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'notes',
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

    // RELASI KE BOUQUET
    public function bouquet()
    {
        return $this->belongsTo(Bouquet::class);
    }

    // RELASI KE USER (INI YANG KURANG SEBELUMNYA)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // FORMAT TOTAL
    public function getTotalFormattedAttribute(): string
    {
        return 'IDR ' . number_format($this->total, 0, ',', '.');
    }
}