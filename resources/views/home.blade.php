<x-app-layout>
    {{-- Font Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    {{-- Custom Font AmazDooM --}}
    <style>
        @font-face {
            font-family: 'AmazDooM';
            src: url('{{ asset('fonts/AmazDooM.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        .font-amazdoom {
            font-family: 'AmazDooM', sans-serif;
        }
    </style>

    {{-- Hero Section - Gambar Full & Crop --}}
    <div class="relative h-[700  px] w-full">
        <img 
            src="{{ asset('storage/slider/slider1.jpeg') }}" 
            alt="Hero Background" 
            class="w-full h-full object-cover"
        >

        {{-- Teks Promosi di atas gambar --}}
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 px-4">
            <div class="max-w-3xl text-center">
                <h1 class="font-extrabold mb-6 font-amazdoom" 
                    style="
                        font-size: 90px; 
                        color: #facc15; 
                        text-shadow: 
                            3px 3px 0 #000, 
                           -3px -3px 0 #000, 
                           -3px 3px 0 #000, 
                            3px -3px 0 #000, 
                            0px 3px 0 #000, 
                            0px -3px 0 #000, 
                            3px 0px 0 #000, 
                           -3px 0px 0 #000;">
                    M O T O P A R T
                </h1>

                <p class="text-xl font-extrabold mb-8" 
                   style="
                       font-family: 'Poppins', sans-serif; 
                       color: #ffffff; 
                       text-shadow: 2px 2px 4px #000;">
                    MotoPart adalah tempat terbaik untuk menemukan kebutuhan suku cadang motor berkualitas, dengan harga terjangkau dan terpercaya.
                </p>
            </div>
        </div>
    </div>

    {{-- Produk List Section --}}
    <div id="produk" class="container mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold text-black text-center mb-10" style="font-family: 'Poppins', sans-serif;">
            Produk Terbaru 
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <div class="border rounded-lg p-4 bg-white shadow hover:shadow-lg transition">
                    {{-- Gambar --}}
                    @if(isset($product->images[0]) && $product->images[0])
                        <div class="w-full h-48 mb-4 overflow-hidden rounded">
                            <img 
                                src="{{ asset('storage/' . $product->images[0]) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded mb-4">
                            <span class="text-gray-500">Tidak ada gambar</span>
                        </div>
                    @endif

                    {{-- Nama Produk --}}
                    <h2 class="text-lg font-semibold mb-2">{{ $product->name }}</h2>

                    {{-- Deskripsi --}}
                    @if($product->short_description)
                        <p class="text-sm text-gray-500 mb-2">{{ $product->short_description }}</p>
                    @endif

                    {{-- Harga --}}
                    <p class="text-indigo-600 font-bold">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-400 text-center col-span-3">Tidak ada produk untuk ditampilkan.</p>
            @endforelse
        </div>
    </div>

    {{-- ✅ Spasi pemisah agar tidak berdempetan --}}
<div class="my-16"></div>

{{-- ✅ Kotak Promosi Full Width dengan warna kontras tinggi --}}
<div class="w-full bg-gray-900 py-12 px-6">
    <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-white mb-4" style="font-family: 'Poppins', sans-serif;">
            Upgrade Motor Impianmu di Sini!
        </h2>
        <p class="text-white text-lg md:text-xl leading-relaxed" style="font-family: 'Poppins', sans-serif;">
            Jelajahi koleksi aksesoris motor terlengkap dari Motopart. Kami menyediakan semua yang kamu butuhkan, mulai dari performa hingga gaya, dengan kualitas terjamin dan harga terbaik. Dapatkan aksesoris yang pas, hanya di sini!
        </p>
    </div>
</div>
</x-app-layout>
