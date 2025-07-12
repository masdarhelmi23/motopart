<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create(Product $product = null) // Mengubah $product menjadi opsional
    {
        // Ambil item dari session cart
        $cartItems = session('cart', []);

        // Jika keranjang kosong, kembalikan dengan pesan error
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        // Hitung total harga dari item di keranjang
        $total = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        
        // Buat pesanan baru
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => $total,
            'items' => json_encode($cartItems),
        ]);

        // Simpan setiap item keranjang ke dalam pesanan
        foreach ($cartItems as $item) {
            $order->items()->create([ // Asumsi ada relasi 'items' di model Order
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Kosongkan keranjang setelah pesanan dibuat
        session()->forget('cart');

        // Simpan order_id di session untuk referensi pembayaran
        session(['current_order_id' => $order->id]);

        // Redirect ke halaman pembayaran
        return redirect()->route('payment')->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }
}
