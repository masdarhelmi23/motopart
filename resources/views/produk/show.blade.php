<x-app-layout>
    {{-- Ini adalah div utama yang membungkus seluruh konten detail produk --}}
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 mt-8"> 
        {{-- Card utama untuk seluruh detail produk, dengan background, shadow, dan padding --}}
        <div class="flex flex-col md:flex-row gap-8 lg:gap-12 bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 md:p-8">
            
            {{-- Bagian Gambar Produk --}}
            <div class="md:w-1/2 lg:w-2/5 flex flex-col items-center">
                {{-- Gambar utama dengan rasio 3:4 (mirip screenshot Honda) dan shadow --}}
                <div class="w-full h-90 overflow-hidden rounded-lg">
                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover object-center">
                </div>
                
                {{-- Thumbnails (jika ada gambar lain) --}}
                @if(count($product->images) > 1)
                <div class="flex gap-2 mt-4 justify-center">
                    @foreach($product->images as $index => $image)
                        @if($index < 3) {{-- Tampilkan maksimal 3 thumbnail, contoh seperti di screenshot --}}
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden border border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 transition duration-150 ease-in-out">
                            <img src="{{ asset('storage/' . $image) }}" 
                                alt="{{ $product->name }} thumbnail {{ $index + 1 }}" 
                                class="object-cover w-full h-full">
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Bagian Informasi Produk --}}
            <div class="md:w-1/2 lg:w-3/5 space-y-4 text-gray-800 dark:text-gray-200">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-gray-100">
                    {{ $product->name }}
                </h1>

                {{-- Jaminan Keaslian Badge --}}
                <div class="flex items-center space-x-3 mb-2">
                    <span class="inline-block bg-green-600 text-white text-xs lg:text-sm font-bold px-3 py-1 rounded-full shadow-sm">
                        JAMINAN KEASLIAN
                    </span>
                    <span class="text-xs lg:text-sm text-purple-600 font-bold">100%</span>
                </div>

                <p class="text-3xl lg:text-4xl font-extrabold text-blue-600 dark:text-blue-400 mt-4 mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                {{-- Detail Produk --}}
                <div class="text-sm lg:text-base space-y-2">
                    @if($product->short_description)
                        <p><strong>Tags:</strong> <span class="text-gray-600 dark:text-gray-300">{{ $product->short_description }}</span></p>
                    @endif

                    @if($product->code)
                        <p><strong>No. Part:</strong> <span class="text-gray-600 dark:text-gray-300">{{ $product->code }}</span></p>
                    @endif

                    @if($product->stock)
                        <p><strong>Stok:</strong> <span class="text-gray-600 dark:text-gray-300">{{ $product->stock }}</span></p>
                    @endif

                    @if($product->category)
                        <p><strong>Kategori:</strong> <span class="text-gray-600 dark:text-gray-300">{{ $product->category->name }}</span></p>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="mt-4">
                    <p class="font-semibold text-base lg:text-lg mb-2">Deskripsi Produk:</p>
                    <div class="text-gray-600 dark:text-gray-300 prose dark:prose-invert max-w-none text-sm lg:text-base">
                        {!! $product->description !!}
                    </div>
                </div>

                {{-- Tombol Keranjang dan Kuantitas --}}
                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex items-center gap-4 mt-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    {{-- Kontrol Kuantitas --}}
                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md">
                        {{-- Tombol '-' dihapus --}}
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock ? min($product->stock, 10) : 10 }}" 
                               class="w-24 text-center focus:outline-none focus:ring-0 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-1 rounded-md"
                               id="quantity-input">
                        {{-- Tombol '+' dihapus --}}
                    </div>

                    {{-- Tombol "Tambah ke Keranjang" --}}
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-md text-base font-semibold shadow-md transition duration-150 ease-in-out">
                        Tambah ke Keranjang
                    </button>
                </form>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                    *Maksimal pembelian 10 pcs per transaksi.
                </p>
            </div>
        </div>
    </div>

    {{-- Script untuk Kuantitas --}}
    @push('scripts') {{-- Pastikan layout utama Anda memiliki @stack('scripts') --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity-input');
            // const decreaseBtn = document.getElementById('decrease-qty'); // Dihapus
            // const increaseBtn = document.getElementById('increase-qty'); // Dihapus

            if (quantityInput) { // Perbarui kondisi if
                let currentQuantity = parseInt(quantityInput.value);
                if (isNaN(currentQuantity)) {
                    currentQuantity = 1;
                    quantityInput.value = 1;
                }

                const maxAllowed = parseInt(quantityInput.max) || 10; 
                console.log('Max quantity allowed:', maxAllowed);

                // Logic untuk decreaseBtn dan increaseBtn dihapus karena tombolnya sudah dihapus.
                // Input type="number" akan menangani panah naik/turun bawaan.

                quantityInput.addEventListener('change', function() {
                    let typedValue = parseInt(quantityInput.value);
                    if (isNaN(typedValue) || typedValue < 1) {
                        quantityInput.value = 1;
                    } else if (typedValue > maxAllowed) {
                        quantityInput.value = maxAllowed;
                    }
                });
            } else {
                console.error('One or more quantity elements not found.');
            }
        });
    </script>
    @endpush
</x-app-layout>
