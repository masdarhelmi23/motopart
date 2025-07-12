<x-app-layout>
    <div class="min-h-screen bg-gray-900 py-10 px-4">
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-12 space-y-6 mt-10">
            <h1 class="text-3xl font-bold text-gray-100 text-center mb-8">Konfirmasi Pembayaran</h1>

            <div class="space-y-2">
                <h2 class="text-lg font-semibold text-gray-200">Detail Pesanan</h2>
                @foreach ($cart->orderItems as $item)
                    <div class="flex justify-between text-sm text-gray-300">
                        <div>{{ $item->product->name }} x{{ $item->quantity }}</div>
                        <div>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</div>
                    </div>
                @endforeach
                <div class="border-t border-gray-700 pt-3 text-right">
                    <span class="font-bold text-gray-100">Total:</span>
                    <span class="text-lg font-bold text-green-500 ml-2">
                        Rp {{ number_format($cart->orderItems->sum('total_amount'), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <form action="{{ route('payment.process') }}" method="POST" class="space-y-4 mt-6">
                @csrf
                <input type="hidden" name="order_id" value="{{ $cart->id }}">

                {{-- ✅ Input hidden untuk shipping dan pajak --}}
                <input type="hidden" name="selected_shipping_method" value="standard">
                <input type="hidden" name="total_with_shipping_and_tax" value="{{ $cart->orderItems->sum('total_amount') }}">
                <input type="hidden" name="calculated_shipping_cost" value="0">
                <input type="hidden" name="calculated_tax_amount" value="0">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-200">Metode Pembayaran</label>
                    <select name="payment_method" required class="w-full rounded-md p-2 bg-gray-700 text-white">
                        <option value="midtrans">Midtrans (Virtual Account / QRIS)</option>
                        <option value="transfer_bank">Transfer Bank</option>
                        <option value="cod">COD (Bayar di Tempat)</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-200">Catatan</label>
                    <textarea name="note" rows="3" class="w-full rounded-md p-2 bg-gray-700 text-white" placeholder="Tambahkan catatan..."></textarea>
                </div>

                <div class="pt-4 text-center">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold text-sm px-6 py-3 rounded-full transition">
                        Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
