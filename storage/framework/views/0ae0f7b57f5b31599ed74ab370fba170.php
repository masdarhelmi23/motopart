<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <div class="bg-gray-900 min-h-screen">
        
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-white mb-4">Semua Produk</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    
                    <div x-data="{ open: false, qty: 1 }" class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 p-4 flex flex-col h-full">

                        
                        <a href="<?php echo e(route('produk.show', $product->slug)); ?>" class="block w-full h-64 mb-3 overflow-hidden rounded">
                            <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>"
                                alt="<?php echo e($product->name); ?>"
                                class="w-full h-full object-cover object-center">
                        </a>

                        
                        <h2 class="text-lg font-semibold text-gray-800 mb-1"><?php echo e($product->name); ?></h2>

                        
                        <p class="text-sm text-gray-600 mb-2 line-clamp-2 overflow-hidden">
                            <?php echo e($product->short_description ?? \Illuminate\Support\Str::limit(strip_tags($product->description), 100)); ?>

                        </p>

                        
                        <p class="text-indigo-600 font-semibold mb-3">
                            Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                        </p>

                        
                        <div class="mt-auto flex gap-2">
                            
                            <form method="POST" action="<?php echo e(route('cart.add', $product->id)); ?>"
                                    class="w-12 ajax-add-to-cart" data-product-id="<?php echo e($product->id); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="quantity" value="1"> 
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white p-2 rounded w-full h-full flex justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7a1 1 0 00.9 1.5h12.2a1 1 0 00.9-1.5L17 13M7 13V6h10v7M12 8v4m0 0h4m-4 0H8"/>
                                    </svg>
                                </button>
                            </form>

                            
                            <form method="POST" action="<?php echo e(route('cart.add', $product->id)); ?>" class="flex-1">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="quantity" value="1"> 
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded text-center w-full">
                                    Checkout
                                </button>
                            </form>
                        </div>

                        
                        <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black/60 p-4">
                            <div class="bg-white rounded-lg overflow-hidden max-w-4xl w-full shadow-lg relative">
                                
                                <button @click="open = false"
                                        class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">×
                                </button>

                                <div class="flex flex-col md:flex-row gap-6 p-6">
                                    
                                    <div class="w-full md:w-1/2">
                                        <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>"
                                                alt="<?php echo e($product->name); ?>"
                                                class="w-full h-auto object-cover rounded">
                                    </div>

                                    
                                    <div class="w-full md:w-1/2 space-y-3 text-sm">
                                        <h3 class="text-2xl font-bold text-gray-900"><?php echo e($product->name); ?></h3>

                                        <div class="flex items-center space-x-2">
                                            <span class="inline-block bg-green-500 text-white text-xs font-semibold px-2 py-0.5 rounded">
                                                JAMINAN KEASLIAN
                                            </span>
                                            <span class="text-xs text-purple-600 font-bold">100%</span>
                                        </div>

                                        <p class="text-indigo-600 font-bold text-lg">
                                            Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                                        </p>

                                        <?php if($product->short_description): ?>
                                            <p><strong>Tags:</strong> <?php echo e($product->short_description); ?></p>
                                        <?php endif; ?>

                                        <?php if($product->code ?? false): ?>
                                            <p><strong>No. Part:</strong> <?php echo e($product->code); ?></p>
                                        <?php endif; ?>

                                        <?php if(isset($product->stock)): ?>
                                            <p><strong>Stok:</strong> <?php echo e($product->stock); ?></p>
                                        <?php endif; ?>

                                        <?php if($product->category): ?>
                                            <p><strong>Kategori:</strong> <?php echo e($product->category->name); ?></p>
                                        <?php endif; ?>

                                        <?php if($product->description): ?>
                                            <div>
                                                <p class="font-semibold mb-1">Deskripsi:</p>
                                                <div class="text-gray-600 text-sm max-h-32 overflow-y-auto leading-snug prose">
                                                    <?php echo $product->description; ?>

                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        
                                        <form method="POST" action="<?php echo e(route('cart.add', $product->id)); ?>" class="mt-4">
                                            <?php echo csrf_field(); ?>
                                            <div class="flex items-center gap-2">
                                                <input type="number" name="quantity" x-model="qty" min="1" max="10"
                                                        class="border rounded px-2 py-1 w-16 text-center text-sm"
                                                        required>

                                                <button type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                                                    Tambah ke Keranjang
                                                </button>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                *Maksimal pembelian 10 pcs per transaksi.
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-300">Tidak ada produk.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div id="custom-alert-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-xs w-full mx-4 transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
            <div class="text-center">
                <svg id="alert-icon-success" class="mx-auto h-12 w-12 text-green-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <svg id="alert-icon-error" class="mx-auto h-12 w-12 text-red-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 id="alert-title" class="text-lg leading-6 font-medium text-gray-900 mt-3"></h3>
                <div class="mt-2">
                    <p id="alert-message" class="text-sm text-gray-500"></p>
                </div>
            </div>
            <div class="mt-5 sm:mt-6">
                <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm" onclick="closeCustomAlert()">
                    OK
                </button>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Fungsi untuk menampilkan pop-up notifikasi kustom
        function showCustomAlert(message, type = 'success', title = '') {
            const modal = document.getElementById('custom-alert-modal');
            const iconSuccess = document.getElementById('alert-icon-success');
            const iconError = document.getElementById('alert-icon-error');
            const alertTitle = document.getElementById('alert-title');
            const alertMessage = document.getElementById('alert-message');

            alertMessage.textContent = message;
            
            // Atur ikon dan judul berdasarkan tipe (success atau error)
            if (type === 'success') {
                iconSuccess.classList.remove('hidden');
                iconError.classList.add('hidden');
                alertTitle.textContent = title || 'Berhasil!';
                alertTitle.classList.remove('text-red-700');
                alertTitle.classList.add('text-green-700');
            } else { // default ke error
                iconError.classList.remove('hidden');
                iconSuccess.classList.add('hidden');
                alertTitle.textContent = title || 'Terjadi Kesalahan!';
                alertTitle.classList.remove('text-green-700');
                alertTitle.classList.add('text-red-700');
            }

            modal.classList.remove('hidden'); // Tampilkan modal
        }

        // Fungsi untuk menutup pop-up notifikasi kustom
        function closeCustomAlert() {
            document.getElementById('custom-alert-modal').classList.add('hidden');
        }

        // Event listener untuk semua form "Tambah ke Keranjang" (AJAX)
        document.querySelectorAll('.ajax-add-to-cart').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Mencegah submit form secara default

                const productId = this.dataset.productId;
                const url = this.action;
                const token = this.querySelector('input[name="_token"]').value;
                const quantity = this.querySelector('input[name="quantity"]').value; // Ambil kuantitas dari input hidden

                axios.post(url, { quantity: quantity }, { // Kirim kuantitas dalam payload POST
                    headers: { 'X-CSRF-TOKEN': token }
                }).then(res => {
                    // Tampilkan pop-up sukses
                    showCustomAlert(res.data.message || 'Produk berhasil ditambahkan ke keranjang!', 'success', 'Berhasil!');
                    const badge = document.getElementById('cart-count');
                    if (badge && res.data.count !== undefined) {
                        badge.textContent = res.data.count; // Perbarui angka di badge keranjang (jika ada)
                    }
                }).catch(err => {
                    console.error(err);
                    // Tampilkan pop-up error
                    showCustomAlert(err.response?.data?.message || 'Gagal menambahkan ke keranjang.', 'error', 'Gagal!');
                });
            });
        });

        // Event listener untuk tombol "Checkout" yang juga memanggil cart.add
        document.querySelectorAll('form.flex-1').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Mencegah submit form secara default

                const url = this.action;
                const token = this.querySelector('input[name="_token"]').value;
                const quantity = this.querySelector('input[name="quantity"]').value; // Ambil kuantitas dari input hidden

                axios.post(url, { quantity: quantity }, { // Kirim kuantitas dalam payload POST
                    headers: { 'X-CSRF-TOKEN': token }
                }).then(res => {
                    // Tampilkan pop-up sukses
                    showCustomAlert(res.data.message || 'Produk berhasil ditambahkan ke keranjang!', 'success', 'Berhasil!');
                    const badge = document.getElementById('cart-count');
                    if (badge && res.data.count !== undefined) {
                        badge.textContent = res.data.count; // Perbarui angka di badge keranjang (jika ada)
                    }
                    // Redirect ke halaman keranjang/checkout setelah menambahkan
                    window.location.href = '<?php echo e(route('cart.index')); ?>'; // Atau route checkout yang sesuai
                }).catch(err => {
                    console.error(err);
                    // Tampilkan pop-up error
                    showCustomAlert(err.response?.data?.message || 'Gagal menambahkan ke keranjang.', 'error', 'Gagal!');
                });
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\software\MotoPart\resources\views/dashboard.blade.php ENDPATH**/ ?>