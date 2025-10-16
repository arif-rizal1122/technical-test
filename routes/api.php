<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController; // Untuk Webhook

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| 
|
*/


Route::middleware('access.key')->group(function () {


    Route::prefix('auth')->controller(UserController::class)->group(function () {
        // 1. Register API
        Route::post('register', 'postSignup'); 
        // 2. Login API
        Route::post('login', 'postSignin');    
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('products', 'index');
        Route::get('products/{id}', 'show');
    });



    Route::middleware('auth:sanctum')->group(function () {
        
        Route::post('auth/logout', [UserController::class, 'getLogout']);
        // 5. Checkout API
        Route::post('checkout', [OrderController::class, 'checkout']);

        // 6. Payment API (Memulai transaksi dengan PG)
        Route::post('payment/{order_number}', [OrderController::class, 'processPayment']);

        // 7. Riwayat Pemesanan API
        Route::get('orders/history', [OrderController::class, 'history']);
        
    });


    
});


// ====================================================================
// GROUP 3: Route Webhook (TIDAK Membutuhkan API Key atau Auth Sanctum)
// ====================================================================
// Webhook harus terbuka untuk notifikasi dari Payment Gateway, diamankan dengan Signature Verification internal.
// 4. Integrasi Payment Gateway sampai Webhook
Route::post('webhook/payment', [PaymentController::class, 'handleWebhook']);