<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600"> Pesanan Terselesaikan</h1>

        {{-- Loop melalui setiap pesanan. Variabel $orders ini diasumsikan sudah difilter oleh controller
             sehingga hanya berisi pesanan dengan payment_status 'paid' dan tidak ada yang berstatus 'cart'. --}}
        @forelse($orders as $order)
            @php
                // Determine if the order is paid
                $isPaid = $order->payment_status === 'paid';

                // Determine border color based on payment status
                $borderColor = match ($order->payment_status) {
                    'paid' => 'border-green-500',    // Green for 'paid' status
                    'pending' => 'border-yellow-500', // Yellow for 'pending' status
                    default => 'border-red-500'       // Red for other statuses (e.g., 'failed', 'expire', etc.)
                };

                // Determine badge class for payment status (this part is no longer displayed but kept for consistency if needed elsewhere)
                $badgeClass = match ($order->payment_status) {
                    'paid' => 'bg-green-100 text-green-800',    // Light green for 'paid' status
                    'pending' => 'bg-yellow-100 text-yellow-800', // Light yellow for 'pending' status
                    default => 'bg-red-100 text-red-800'       // Light red for other statuses
                };
            @endphp

            {{-- Card for each order --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6 border-l-4 {{ $borderColor }} hover:shadow-xl transition">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">🧾 No. Order: {{ $order->id }}</h2>
                </div>

                {{-- Order details --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <p>💰 <span class="font-medium">Total:</span> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        {{-- Removed "Status Pembayaran" display as requested --}}
                        <p>🗓️ <span class="font-medium">Tanggal:</span> {{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                {{-- Action buttons section --}}
                <div class="flex items-center gap-3 mt-4">
                    {{-- The "Hapus" (Delete) button and its logic are removed as requested --}}
                    
                    {{-- "Cetak Nota" (Print Invoice) button is now always displayed --}}
                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm shadow">
                        Detail
                    </a>
                </div>
            </div>
        @empty
            {{-- Message if no orders are found after filtering --}}
            <p class="text-center text-gray-500">🔍 Belum ada pesanan yang sudah dibayar.</p>
        @endforelse
    </div>
</x-app-layout>
