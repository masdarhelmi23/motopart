<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Helpers\MidtransConfig;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show()
    {
        $cart = Order::where('user_id', auth()->id())
            ->where('status', 'cart')
            ->with('orderItems.product')
            ->first();

        if (!$cart || $cart->orderItems->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Keranjang Anda kosong.');
        }

        return view('payment.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
            'selected_shipping_method' => 'required|string',
            'total_with_shipping_and_tax' => 'required|numeric|min:0',
            'calculated_shipping_cost' => 'required|numeric|min:0',
            'calculated_tax_amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        $order->update([
            'payment_method' => $request->payment_method,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'notes' => $request->note,
            'shipping_method' => $request->selected_shipping_method,
            'total_price' => $request->total_with_shipping_and_tax, // sudah termasuk subtotal + pajak + ongkir
        ]);

        // Simpan ongkir dan pajak ke session agar bisa dipakai nanti di Midtrans
        session([
            'current_order_id' => $order->id,
            'shipping_cost' => $request->calculated_shipping_cost,
            'tax_amount' => $request->calculated_tax_amount,
        ]);

        return redirect()->route('payment.midtrans', ['order_id' => $order->id]);
    }

    public function payWithMidtrans(Request $request)
    {
        $orderId = $request->order_id ?? session('current_order_id');

        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada pesanan untuk diproses.');
        }

        $order = Order::with('orderItems.product')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        MidtransConfig::init();

        $items = [];
        foreach ($order->orderItems as $item) {
            $items[] = [
                'id' => $item->product->id,
                'price' => (int) $item->unit_amount,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        }

        // Tambahkan item ongkir dan pajak jika tersedia di session
        $shipping = session('shipping_cost', 0);
        $tax = session('tax_amount', 0);

        if ($shipping > 0) {
            $items[] = [
                'id' => 'shipping',
                'price' => (int) $shipping,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        if ($tax > 0) {
            $items[] = [
                'id' => 'tax',
                'price' => (int) $tax,
                'quantity' => 1,
                'name' => 'Pajak',
            ];
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => (int) $order->total_price,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone_number ?? '08123456789',
                'address' => Auth::user()->address ?? 'Alamat tidak tersedia',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);
            return view('payment.midtrans', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'payload' => $payload,
            ]);

            return redirect()->route('cart.index')->with('error', 'Gagal membuat token pembayaran Midtrans.');
        }
    }

    public function midtransCallback(Request $request)
    {
        MidtransConfig::init();
        $notif = new Notification();

        $orderId = (str_contains($notif->order_id, '-') 
                    ? explode('-', $notif->order_id)[1] 
                    : $notif->order_id);

        $order = Order::find($orderId);

        if (!$order) {
            Log::warning('Callback Midtrans: Order tidak ditemukan', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        if ($status === 'capture') {
            if ($fraud === 'challenge') {
                $order->update(['payment_status' => 'challenge', 'status' => 'pending']);
            } else {
                $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
            }
        } elseif ($status === 'settlement') {
            $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
        } elseif ($status === 'pending') {
            $order->update(['payment_status' => 'pending', 'status' => 'pending']);
        } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        }

        return response()->json(['message' => 'Callback diproses'], 200);
    }
}
