<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'transaction_id', 'payment_type',
        'gross_amount', 'transaction_status', 'payment_time', 'raw_response',
    ];

    protected function casts(): array
    {
        return [
            'gross_amount' => 'decimal:2',
            'payment_time' => 'datetime',
            'raw_response' => 'array',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->transaction_status) {
            'capture', 'settlement' => 'Berhasil',
            'pending' => 'Menunggu',
            'deny' => 'Ditolak',
            'cancel' => 'Dibatalkan',
            'expire' => 'Kedaluwarsa',
            default => ucfirst($this->transaction_status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->transaction_status) {
            'capture', 'settlement' => 'text-green-400 bg-green-400/10',
            'pending' => 'text-yellow-400 bg-yellow-400/10',
            'deny', 'cancel' => 'text-red-400 bg-red-400/10',
            'expire' => 'text-gray-400 bg-gray-400/10',
            default => 'text-gray-400 bg-gray-400/10',
        };
    }
}
