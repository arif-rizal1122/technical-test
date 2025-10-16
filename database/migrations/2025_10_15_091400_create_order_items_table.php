<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel orders
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); 
            
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict'); 
            
            $table->integer('quantity');
            $table->unsignedBigInteger('price_at_order'); 
            $table->unsignedBigInteger('subtotal');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
