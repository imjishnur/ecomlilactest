<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CartController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('frontend.products.index');

Route::get('/order-success/{orderId}', [CartController::class, 'orderSuccess'])->name('order.success');

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware(['auth', 'role:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)
            ->except(['show']);
    });

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return redirect()->route('admin.products.index');
})->name('dashboard');




Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
