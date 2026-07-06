<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminProductVariantController;
use App\Http\Controllers\Admin\AdminAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ──────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');

// ── AUTH (Breeze) ────────────────────────────────────────────
require __DIR__.'/auth.php';

// ── USER (harus login) ───────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Profile — pakai controller custom (bukan bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Pembayaran
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/upload', [PaymentController::class, 'upload'])->name('payment.upload');
});

// ── ADMIN ────────────────────────────────────────────────────
Route::middleware(['guest'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthenticatedSessionController::class, 'store'])->name('login.submit');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('promos', AdminPromoController::class);

    // Pelanggan
    Route::get('/customers', [
        \App\Http\Controllers\Admin\DashboardController::class,
        'customers'
    ])->name('admin.customers.index');



    
    // Product Variants
    Route::prefix('products/{product}/variants')->name('products.variants.')->group(function () {
        Route::get('create', [AdminProductVariantController::class, 'create'])->name('create');
        Route::post('/', [AdminProductVariantController::class, 'store'])->name('store');
        Route::get('{variant}/edit', [AdminProductVariantController::class, 'edit'])->name('edit');
        Route::put('{variant}', [AdminProductVariantController::class, 'update'])->name('update');
        Route::delete('{variant}', [AdminProductVariantController::class, 'destroy'])->name('destroy');
    });
    
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/report', [AdminOrderController::class, 'reportPdf'])->name('orders.report');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});
