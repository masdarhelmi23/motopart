<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BrandPublicController;
use App\Http\Controllers\ProductPublicController;
use App\Http\Controllers\MidtransController;

// ============================
// ✅ HALAMAN UMUM
// ============================

// Landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard - Menampilkan semua produk
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ============================
// ✅ CART & CHECKOUT
// ============================

// Keranjang
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/ajax/add/{product}', [CartController::class, 'addToCart'])->name('cart.add.ajax');
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])
    ->middleware(['auth'])
    ->name('cart.add');
Route::post('/cart/item/{item}/{action}', [CartController::class, 'updateQuantity'])
    ->middleware('auth');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Checkout langsung dari produk
Route::get('/checkout/{product}', [CheckoutController::class, 'create'])
    ->middleware(['auth'])
    ->name('checkout');

// ============================
// ✅ PEMBAYARAN MIDTRANS
// ============================

// Menampilkan halaman ringkasan pesanan sebelum bayar
Route::get('/payment', [PaymentController::class, 'show'])
    ->middleware(['auth'])
    ->name('payment.show');

// Proses form pembayaran (POST)
Route::post('/payment', [PaymentController::class, 'process'])
    ->middleware(['auth'])
    ->name('payment.process');

// Menampilkan Snap Midtrans
Route::get('/payment/pay-midtrans/{order_id}', [PaymentController::class, 'payWithMidtrans'])
    ->middleware(['auth'])
    ->name('payment.midtrans');

// Callback dari Midtrans (webhook)
Route::post('/midtrans/callback', [PaymentController::class, 'midtransCallback']);

// (Opsional) Midtrans notification controller terpisah
// Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler']);

// (Opsional) Generate Snap token manual
// Route::post('/generate-token', [PaymentController::class, 'generateToken'])->name('payment.token');

// ============================
// ✅ PRODUK & BRAND PUBLIK
// ============================

Route::get('/produk/{product:slug}', [ProductPublicController::class, 'show'])->name('produk.show');
Route::get('/brands', [BrandPublicController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand:slug}', [BrandPublicController::class, 'show'])->name('brands.show');

// ============================
// ✅ PESANAN & INVOICE
// ============================

Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
});

// ============================
// ✅ PROFIL & PENGGUNA
// ============================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================
// ✅ REDIRECT PANEL ADMIN (FILAMENT)
// ============================

Route::get('/admin-redirect', function () {
    return redirect('/admin');
})->middleware('auth')->name('admin.redirect');

// ============================
// ✅ AUTH ROUTES
// ============================

require __DIR__ . '/auth.php';
