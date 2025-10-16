<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController; 

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
        Route::post('register', 'postSignup'); 
        Route::post('login', 'postSignin');    
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('products', 'index');
        Route::get('products/{id}', 'show');
    });



    Route::middleware('auth:sanctum')->group(function () {
        
        Route::post('auth/logout', [UserController::class, 'getLogout']);
        Route::post('checkout', [OrderController::class, 'checkout']);
        Route::post('payment/{order_number}', [OrderController::class, 'processPayment']);
        Route::get('orders/history', [OrderController::class, 'history']);
        
    });


    
});

Route::post('webhook/payment', [PaymentController::class, 'handleWebhook']);