<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    /**
     * Kolom yang dapat diisi mass assignment (untuk Products API)
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock', 
        'image_path',
    ];

    /**
     * Relasi: Product dimiliki oleh banyak OrderItem
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}