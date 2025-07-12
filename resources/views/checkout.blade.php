<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-gray-500 text-sm mb-4">
            <a href="{{ url('/') }}" class="hover:underline">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('dashboard') }}" class="hover:underline">Semua Produk</a>
            <span class="mx-2">/</span>
            <span>Checkout</span>
        </nav>

        <!-- Checkout Card -->
        <div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-4">Checkout Produk</h1>

            <!-- Detail Produk -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                @if($product->images)
                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                         alt="{{ $product->name }}"
                         class="w-full md:w-48 h-48 object-cover rounded">
                @endif

                <div>
                    <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-600 mb-2">{{ $product->short_description }}</p>
                    <p class="text-indigo-600 font-bold text-lg mb-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Stok: {{ $product->stock ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Form Pembelian -->
            <form action="{{ route('cart.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jumlah
                    </label>
                    <input type="number"
                           name="quantity"
                           value="1"
                           min="1"
                           class="w-24 border rounded px-2 py-1 focus:outline-none focus:ring focus:border-indigo-400">
                </div>

                <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded">
                    Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
