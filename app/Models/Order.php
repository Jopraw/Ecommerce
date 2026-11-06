<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'total_price', 'status',
        'snap_token', 'shipping_name', 'shipping_phone', 'shipping_address',
        'tracking_number', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $today = now()->format('Ymd');
                $count = static::whereDate('created_at', today())->count() + 1;
                $order->order_number = 'AS-' . $today . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kedaluwarsa',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'text-yellow-400 bg-yellow-400/10',
            'paid' => 'text-blue-400 bg-blue-400/10',
            'processing' => 'text-cyan-400 bg-cyan-400/10',
            'shipped' => 'text-teal-400 bg-teal-400/10',
            'completed' => 'text-green-400 bg-green-400/10',
            'cancelled' => 'text-red-400 bg-red-400/10',
            'expired' => 'text-gray-400 bg-gray-400/10',
            default => 'text-gray-400 bg-gray-400/10',
        };
    }
}
