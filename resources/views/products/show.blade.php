<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-4">Produk dari Brand: {{ $brand->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded shadow p-4 flex flex-col h-full">
                    @if ($product->images && count($product->images) > 0)
                        <div class="w-full h-64 mb-3 overflow-hidden rounded">
                            <img src="{{ asset('storage/' . $product->images[0]) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover object-center">
                        </div>
                    @endif

                    <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $product->name }}</h2>

                    <p class="text-sm text-gray-600 mb-2 line-clamp-2 overflow-hidden">
                        {{ $product->short_description ?? \Illuminate\Support\Str::limit(strip_tags($product->description), 100) }}
                    </p>

                    <p class="text-indigo-600 font-semibold mb-3">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="mt-auto flex gap-2">
                        <!-- Tombol AJAX Tambah ke Keranjang -->
                        <form method="POST" action="{{ route('cart.add', $product->id) }}"
                              class="w-12 ajax-add-to-cart" data-product-id="{{ $product->id }}">
                            @csrf
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white p-2 rounded w-full h-full flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7a1 1 0 00.9 1.5h12.2a1 1 0 00.9-1.5L17 13M7 13V6h10v7M12 8v4m0 0h4m-4 0H8"/>
                                </svg>
                            </button>
                        </form>

                        <!-- Tombol Checkout -->
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded text-center w-full">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-300">Tidak ada produk untuk brand ini.</p>
            @endforelse
        </div>
    </div>
@foreach ($products as $product)
    <pre>{{ var_dump($product->images) }}</pre>
@endforeach
    {{-- Script AJAX --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.querySelectorAll('.ajax-add-to-cart').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const productId = this.dataset.productId;
                const url = this.action;
                const token = this.querySelector('input[name="_token"]').value;

                axios.post(url, {}, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                }).then(res => {
                    alert('Produk berhasil ditambahkan ke keranjang!');
                    const badge = document.getElementById('cart-count');
                    if (badge && res.data.count !== undefined) {
                        badge.textContent = res.data.count;
                    }
                }).catch(err => {
                    alert('Gagal menambahkan ke keranjang.');
                    console.error(err);
                });
            });
        });
    </script>
</x-app-layout>
