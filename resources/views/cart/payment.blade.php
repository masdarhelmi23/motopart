<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Pembayaran</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

            <table class="min-w-full divide-y divide-gray-200 mb-6">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cart->orderItems as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-center">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="2" class="px-4 py-2 text-right font-bold text-gray-900">Total:</td>
                        <td class="px-4 py-2 text-center font-bold text-indigo-600 text-lg">
                            Rp {{ number_format($cart->orderItems->sum('total_amount'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <form action="{{ route('payment.process') }}" method="POST" class="space-y-4">
                @csrf

                <input type="hidden" name="order_id" value="{{ $cart->id }}">

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select id="payment_method" name="payment_method" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Metode --</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="cod">Bayar di Tempat</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <div>
                    <label for="note" class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
                    <textarea id="note" name="note" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-md transition">
                        Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
