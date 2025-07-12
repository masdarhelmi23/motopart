<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang belanja pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = Order::where('user_id', Auth::id())
                    ->where('status', 'cart')
                    ->with('orderItems.product')
                    ->first();

        $total = $cart ? $cart->total_price : 0;

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Menambahkan produk ke keranjang belanja pengguna.
     * Mengambil kuantitas dari request dan menambahkannya ke item keranjang.
     *
     * @param \App\Models\Product $product
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function addToCart(Product $product, Request $request)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Anda harus login untuk menambahkan produk ke keranjang.'], 401);
            }
            return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan produk ke keranjang.');
        }

        // Ambil kuantitas dari input form. Default ke 1 jika tidak ada atau tidak valid.
        $quantityToAdd = $request->input('quantity', 1);

        // Pastikan kuantitas adalah angka positif dan integer
        $quantityToAdd = max(1, (int) $quantityToAdd);

        // Batasi kuantitas maksimal (misal 10 atau sesuai stok produk)
        $maxAllowedPerItem = $product->stock ? min($product->stock, 10) : 10;

        $cart = Order::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'cart'],
            ['total_price' => 0]
        );

        $item = $cart->orderItems()->where('product_id', $product->id)->first();

        if ($item) {
            // Jika item sudah ada, perbarui kuantitasnya dengan menambahkan quantityToAdd
            $newQuantity = $item->quantity + $quantityToAdd;

            // Pastikan kuantitas baru tidak melebihi batas maksimal
            if ($newQuantity > $maxAllowedPerItem) {
                $newQuantity = $maxAllowedPerItem;
                // Opsional: tambahkan pesan peringatan ke session jika kuantitas disesuaikan
                // session()->flash('warning', 'Kuantitas disesuaikan dengan stok/maksimal pembelian per item.');
            }
            
            $item->quantity = $newQuantity;
            $item->unit_amount = $product->price; // Pastikan unit_amount selalu up-to-date
            $item->total_amount = $item->unit_amount * $item->quantity;
            $item->save();
        } else {
            // Jika item belum ada, buat yang baru dengan quantityToAdd
            $cart->orderItems()->create([
                'product_id'   => $product->id,
                'quantity'     => $quantityToAdd, // Gunakan kuantitas dari request
                'unit_amount'  => $product->price,
                'total_amount' => $product->price * $quantityToAdd, // Hitung total_amount berdasarkan quantityToAdd
            ]);
        }

        // Hitung ulang total harga keranjang secara keseluruhan
        $cart->total_price = $cart->orderItems->sum(function ($i) {
            return $i->unit_amount * $i->quantity;
        });
        $cart->save();

        // Jika request via AJAX, kembalikan data JSON
        if ($request->ajax()) {
            $itemCount = $cart->orderItems->sum('quantity'); // total item (bukan hanya jenis)
            return response()->json([
                'status' => 'success',
                'message' => 'Produk ditambahkan ke keranjang.',
                'count' => $itemCount
            ]);
        }

        // Jika bukan AJAX, redirect biasa
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /**
     * Memperbarui kuantitas item di keranjang.
     *
     * @param \App\Models\OrderItem $item
     * @param string $action 'increase' or 'decrease'
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuantity(OrderItem $item, $action)
    {
        // Pastikan item keranjang dimiliki oleh user yang sedang login
        if ($item->order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Batasi kuantitas maksimal (misal 10 atau sesuai stok produk)
        $maxAllowedPerItem = $item->product->stock ? min($item->product->stock, 10) : 10;

        if ($action === 'increase') {
            $item->quantity += 1;
            // Pastikan tidak melebihi batas maksimal
            if ($item->quantity > $maxAllowedPerItem) {
                $item->quantity = $maxAllowedPerItem;
            }
        } elseif ($action === 'decrease') {
            $item->quantity = max(1, $item->quantity - 1); // minimal 1
        }

        $item->total_amount = $item->quantity * $item->unit_amount;
        $item->save();

        // Update total harga di order (keranjang)
        $item->order->total_price = $item->order->orderItems->sum('total_amount');
        $item->order->save();

        return response()->json([
            'success' => true,
            'newQuantity' => $item->quantity,
            'newSubtotal' => number_format($item->total_amount, 0, ',', '.'), // Format untuk tampilan
            'newCartTotal' => number_format($item->order->total_price, 0, ',', '.'), // Tambahkan total keranjang
        ]);
    }

    // Anda mungkin memiliki metode lain seperti store, checkout, dll. di sini
    // ...
}
