<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

        @if ($cart && $cart->orderItems->count())
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cart->orderItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                    <div class="w-16 h-16 overflow-hidden rounded mr-4">
                                        @if($item->product->images && isset($item->product->images[0]))
                                            <img src="{{ asset('storage/' . $item->product->images[0]) }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-sm text-gray-500">No Image</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center text-sm text-gray-700">
                                    Rp {{ number_format($item->unit_amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-center text-sm text-gray-700">
                                    <div class="flex justify-center items-center gap-2">
                                        <button data-id="{{ $item->id }}" class="btn-qty px-2 py-1 bg-gray-200 rounded text-gray-700" data-action="decrease">-</button>
                                        <span class="font-semibold" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                        <button data-id="{{ $item->id }}" class="btn-qty px-2 py-1 bg-gray-200 rounded text-gray-700" data-action="increase">+</button>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">Total:</td>
                            <td class="px-6 py-4 text-center font-bold text-indigo-600 text-lg">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{-- Tombol Bayar Sekarang --}}
                <div class="px-6 py-6 bg-gray-50 flex justify-end">
                    <a href="{{ route('payment') }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-md transition text-center">
                        Bayar Sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Keranjang Anda kosong.</p>
                <a href="{{ route('dashboard') }}" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Kembali Belanja
                </a>
            </div>
        @endif
    </div>

    {{-- Script Update Jumlah --}}
    <script>
        document.querySelectorAll('.btn-qty').forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.id;
                const action = this.dataset.action;

                fetch(`/cart/item/${itemId}/${action}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`qty-${itemId}`).textContent = data.newQuantity;
                        location.reload(); // Untuk update total dan subtotal
                    } else {
                        alert(data.message || 'Gagal memperbarui kuantitas.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan.');
                });
            });
        });
    </script>
</x-app-layout>
