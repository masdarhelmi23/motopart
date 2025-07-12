<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan untuk pengguna yang sedang login.
     * Saat ini dikonfigurasi untuk menampilkan semua pesanan KECUALI yang berstatus 'cart'.
     * Ini berarti pesanan dengan payment_status 'paid', 'pending', 'unpaid', dll. akan ditampilkan,
     * selama status utamanya bukan 'cart'.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Memastikan pengguna sudah login sebelum mengambil pesanan
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat pesanan.');
        }

        // Mengambil pesanan untuk user yang sedang login
        // Filter: mengecualikan pesanan dengan status 'cart'.
        // Jika Anda ingin hanya menampilkan yang 'paid', ubah filter ini menjadi ->where('payment_status', 'paid')
        $orders = Order::where('user_id', Auth::id())
                        ->where('status', '!=', 'cart') // Filter ini mengecualikan pesanan dengan status 'cart'
                        ->latest()
                        ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan riwayat pesanan (tidak termasuk yang masih berstatus 'cart').
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        // Memastikan pengguna sudah login sebelum mengambil riwayat pesanan
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat riwayat pesanan.');
        }

        // Mengambil riwayat pesanan untuk user yang sedang login
        // Filter: tidak termasuk pesanan dengan status 'cart'
        $orders = Order::with('orderItems.product')
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'cart') // Filter ini sudah ada untuk mengecualikan 'cart'
            ->latest()
            ->get();

        return view('orders.history', compact('orders'));
    }

    /**
     * Mengkonfirmasi pembayaran pesanan secara manual.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pay(Order $order)
    {
        // Validasi kalau usernya yang punya order
        if ($order->user_id !== Auth::id()) {
            abort(403); // Akses ditolak jika bukan pemilik order
        }

        // Update status menjadi paid dan delivered/processing/shipped
        $order->update([
            'payment_method' => 'manual',
            'payment_status' => 'paid',
            'status' => 'delivered', // atau 'processing', atau 'shipped' tergantung alur kamu
        ]);

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    /**
     * Menghapus pesanan.
     * Hanya diizinkan jika status masih 'cart' atau 'pending'.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        // Cek apakah user yang login adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak menghapus pesanan ini.');
        }

        // Hanya izinkan hapus jika status masih cart atau pending
        if (!in_array($order->status, ['cart', 'pending'])) {
            return redirect()->route('orders.index')->with('error', 'Pesanan sudah diproses dan tidak dapat dihapus.');
        }

        $order->delete(); // Hapus pesanan dari database

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Menampilkan detail invoice untuk pesanan.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\View\View
     */
    public function invoice(Order $order)
    {
        // Cek apakah user yang login adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Eager load order items dan produk terkait, serta user
        $order->load(['orderItems.product', 'user']);

        return view('orders.invoice', compact('order'));
    }
}
