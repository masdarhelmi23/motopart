<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 text-white px-4">
        <div class="bg-gray-800 p-10 rounded-lg text-center shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Bayar Sekarang</h2>
            <p class="mb-6">Klik tombol di bawah untuk menyelesaikan pembayaran.</p>
            <button id="pay-button"
                class="bg-green-500 px-6 py-3 rounded-full font-semibold hover:bg-green-600">
                Bayar dengan Midtrans
            </button>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    alert('Pembayaran berhasil!');
                    window.location.href = "{{ route('orders.index') }}";
                },
                onPending: function (result) {
                    alert('Menunggu pembayaran.');
                },
                onError: function (result) {
                    alert('Pembayaran gagal!');
                },
                onClose: function () {
                    alert('Kamu menutup tanpa menyelesaikan pembayaran!');
                }
            });
        });
    </script>
</x-app-layout>
