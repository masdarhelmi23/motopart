<x-app-layout>
    <div class="bg-gray-900 min-h-screen"> {{-- Latar belakang gelap --}}
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold mb-6 text-center text-white">Daftar Brand</h1>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach($brands as $brand)
                    <a href="{{ route('brands.show', $brand->slug) }}" class="hover:shadow-lg transition">
                        <div class="bg-white rounded shadow p-4 flex flex-col items-center">
                            @if($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" class="h-16 object-contain mb-2">
                            @endif
                            <h2 class="text-lg font-semibold text-gray-800">{{ ucfirst($brand->name) }}</h2>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
