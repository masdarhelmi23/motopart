<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\BuyerDashboardPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// 👇 Halaman depan (opsional)
Route::get('/', function () {
    return view('welcome');
});

// 👇 Laravel Auth (login, register, password reset)
Auth::routes();

// 👇 Buyer Dashboard
Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/dashboard', BuyerDashboardPage::class)->name('buyer.dashboard');
});

/*
|--------------------------------------------------------------------------
| Tambahan route lain jika perlu
|--------------------------------------------------------------------------
|
| Misalnya profil Buyer, order history Buyer, dll.
|
| Route::middleware(['auth', 'role:buyer'])->group(function () {
|     Route::get('/orders', [OrderController::class, 'index'])->name('buyer.orders');
| });
|
*/

