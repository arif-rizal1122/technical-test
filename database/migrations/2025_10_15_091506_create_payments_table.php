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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); 
            
            $table->string('pg_transaction_id')->unique()->nullable(); 
            
            $table->unsignedBigInteger('amount');
            $table->string('method'); 
            
            $table->enum('status', ['pending', 'success', 'failed', 'expired']);
            
            $table->json('pg_response_data')->nullable(); 
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
