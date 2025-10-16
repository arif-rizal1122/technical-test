<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'pg_transaction_id',
        'amount',
        'method',
        'status',
        'pg_response_data',
    ];
    
    // Konversi kolom JSON menjadi array/objek saat diakses
    protected $casts = [
        'pg_response_data' => 'array',
    ];

    /**
     * Relasi: Payment dimiliki oleh Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}