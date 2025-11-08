<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\AuthController;

Route::get('/products', [ProductController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

  
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);       
        Route::post('/add', [CartController::class, 'add']);      
        Route::post('/remove/{id}', [CartController::class, 'remove']); 
        Route::post('/checkout', [CartController::class, 'checkout']); 
    });

});
