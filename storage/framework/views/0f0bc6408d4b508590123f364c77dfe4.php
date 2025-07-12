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
    
    <div class="container mx-auto px-4 py-8 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Checkout Pesanan</h1> 

        <?php if($cart && $cart->orderItems->count()): ?>
            
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">

                
                <div class="lg:col-span-2 space-y-6">

                    
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Alamat Pengiriman</h2>
                        <div id="selected-address-display">
                            <?php if(auth()->guard()->check()): ?>
                                <p class="text-gray-700 dark:text-gray-300"><strong><?php echo e(Auth::user()->name); ?></strong></p>
                                
                                <p class="text-gray-600 dark:text-gray-400"><?php echo e(Auth::user()->address ?? 'Alamat belum diatur. Silakan atur di profil Anda.'); ?></p>
                                
                                
                                <button type="button" class="text-blue-600 dark:text-blue-400 hover:underline mt-3 text-sm">Ganti/Tambah Alamat</button>
                            <?php else: ?>
                                <p class="text-gray-600 dark:text-gray-400">Silakan login untuk melihat dan memilih alamat pengiriman Anda.</p>
                            <?php endif; ?>
                        </div>
                        
                    </div>

                    
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Metode Pengiriman</h2>
                        <form id="shipping-method-form" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <label class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="flex items-center">
                                    <input type="radio" name="shipping_method" value="regular" data-cost="15000" class="form-radio text-blue-600 h-5 w-5" checked>
                                    <div class="ml-3">
                                        <span class="text-gray-800 dark:text-gray-200 font-medium">Regular (5-7 hari)</span>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">Pengiriman standar</p>
                                    </div>
                                </div>
                                <span class="text-gray-800 dark:text-gray-200 font-semibold">Rp 15.000</span>
                            </label>
                            <label class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="flex items-center">
                                    <input type="radio" name="shipping_method" value="express" data-cost="25000" class="form-radio text-blue-600 h-5 w-5">
                                    <div class="ml-3">
                                        <span class="text-gray-800 dark:text-gray-200 font-medium">Express (2-3 hari)</span>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">Pengiriman cepat</p>
                                    </div>
                                </div>
                                <span class="text-gray-800 dark:text-gray-200 font-semibold">Rp 25.000</span>
                            </label>
                            <label class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="flex items-center">
                                    <input type="radio" name="shipping_method" value="same_day" data-cost="35000" class="form-radio text-blue-600 h-5 w-5">
                                    <div class="ml-3">
                                        <span class="text-gray-800 dark:text-gray-200 font-medium">Same Day (Hari ini)</span>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">Khusus area tertentu</p>
                                    </div>
                                </div>
                                <span class="text-gray-800 dark:text-gray-200 font-semibold">Rp 35.000</span>
                            </label>
                        </form>
                    </div>

                    
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white p-6 pb-0">Detail Barang</h2>
                        
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="detail-barang-table">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__currentLoopData = $cart->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                            <div class="w-16 h-16 overflow-hidden rounded mr-4">
                                                <?php if($item->product->images && isset($item->product->images[0])): ?>
                                                    <img src="<?php echo e(asset('storage/' . $item->product->images[0])); ?>"
                                                        alt="<?php echo e($item->product->name); ?>"
                                                        class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm text-gray-500 dark:text-gray-400">No Image</div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e($item->product->name); ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                            Rp <?php echo e(number_format($item->unit_amount, 0, ',', '.')); ?>

                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                            <div class="flex justify-center items-center gap-2">
                                                <button data-id="<?php echo e($item->id); ?>" class="btn-qty px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded text-gray-700 dark:text-gray-300" data-action="decrease">-</button>
                                                <span class="font-semibold" id="qty-<?php echo e($item->id); ?>"><?php echo e($item->quantity); ?></span>
                                                <button data-id="<?php echo e($item->id); ?>" class="btn-qty px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded text-gray-700 dark:text-gray-300" data-action="increase">+</button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            Rp <?php echo e(number_format($item->total_amount, 0, ',', '.')); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div> 

                
                <div class="lg:col-span-1 mt-8 lg:mt-0 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Pesanan</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal (<?php echo e($cart->orderItems->sum('quantity')); ?> item)</span>
                                
                                <span class="text-gray-800 dark:text-gray-200" id="summary-subtotal-display">Rp <?php echo e(number_format($cart->total_amount ?? 0, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Ongkos Kirim</span>
                                <span class="text-gray-800 dark:text-gray-200" id="shipping-cost-display">Rp 0</span> 
                            </div>
                            <div class="flex justify-between">
                                
                                <span class="text-gray-600 dark:text-gray-400">Pajak (3%)</span>
                                <span class="text-gray-800 dark:text-gray-200" id="tax-display">Rp 0</span> 
                            </div>
                        </div>
                        <hr class="my-4 border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span class="text-gray-900 dark:text-white">Total</span>
                            <span class="text-blue-600 dark:text-blue-400" id="final-total-amount">Rp <?php echo e(number_format($cart->total_amount ?? 0, 0, ',', '.')); ?></span> 
                        </div>

                        <div class="mt-6">
                            <form action="<?php echo e(route('payment.process')); ?>" method="POST" id="checkout-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="order_id" value="<?php echo e($cart->id); ?>">
                                <input type="hidden" name="payment_method" value="midtrans">
                                
                                <input type="hidden" name="selected_shipping_method" id="selected-shipping-method-input">
                                
                                <input type="hidden" name="total_with_shipping_and_tax" id="total-with-shipping-and-tax-input">
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded shadow-md transition duration-300 text-lg">
                                    Lanjut ke Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>

                    
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center text-sm text-gray-600 dark:text-gray-400">
                        <p class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pembayaran Aman
                        </p>
                        <p>Diproses oleh Midtrans dengan enkripsi SSL</p>
                    </div>
                </div> 

            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">Keranjang Anda kosong.</p>
                <a href="<?php echo e(route('dashboard')); ?>" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md transition">
                    Kembali Belanja
                </a>
            </div>
        <?php endif; ?>
    </div>

<script>
    // Variabel untuk menyimpan biaya pengiriman yang dipilih
    let currentShippingCost = 0;
    const TAX_RATE = 0.03; // PERBAIKAN DI SINI: Contoh: 3%

    // Fungsi untuk memformat angka menjadi Rupiah
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Fungsi untuk menghitung ulang total pesanan
    function calculateTotal() {
        let subtotal = 0;
        // Hitung subtotal dengan menjumlahkan total_amount dari setiap item di tabel "Detail Barang"
        document.querySelectorAll('#detail-barang-table tbody tr').forEach(row => {
            const subtotalText = row.querySelector('td:last-child').textContent; // Mengambil teks seperti "Rp 4.000.000"
            // Hapus "Rp", spasi, dan titik ribuan, lalu konversi ke integer
            const itemSubtotal = parseInt(subtotalText.replace(/[^0-9]/g, ''));
            if (!isNaN(itemSubtotal)) { // Pastikan nilai yang diambil adalah angka valid
                subtotal += itemSubtotal;
            }
        });
        
        const taxAmount = subtotal * TAX_RATE;
        const finalTotal = subtotal + currentShippingCost + taxAmount;

        // Perbarui tampilan di halaman
        document.getElementById('summary-subtotal-display').textContent = formatRupiah(subtotal);
        document.getElementById('shipping-cost-display').textContent = formatRupiah(currentShippingCost);
        document.getElementById('tax-display').textContent = formatRupiah(taxAmount);
        document.getElementById('final-total-amount').textContent = formatRupiah(finalTotal);

        // Perbarui input tersembunyi agar data dikirim saat form disubmit
        document.getElementById('total-with-shipping-and-tax-input').value = finalTotal;
    }

    // Event listeners untuk tombol kuantitas
    document.querySelectorAll('.btn-qty').forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.dataset.id;
            const action = this.dataset.action;

            fetch(`/cart/item/${itemId}/${action}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`qty-${itemId}`).textContent = data.newQuantity;
                    const subtotalCell = this.closest('tr').querySelector('td:last-child');
                    subtotalCell.textContent = formatRupiah(data.newSubtotal); // Perbarui subtotal per item dengan format Rupiah
                    
                    // Panggil kembali calculateTotal untuk memperbarui total akhir dan pajak
                    calculateTotal(); 
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

    // Event listener untuk pemilihan metode pengiriman
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            currentShippingCost = parseInt(this.dataset.cost); // Ambil biaya dari data-cost
            document.getElementById('selected-shipping-method-input').value = this.value; // Simpan nilai metode yang dipilih
            calculateTotal(); // Hitung ulang total
        });
    });

    // Inisialisasi: Hitung total saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', () => {
        // Atur biaya pengiriman awal berdasarkan radio button yang tercentang default
        const initialCheckedShipping = document.querySelector('input[name="shipping_method"]:checked');
        if (initialCheckedShipping) {
            currentShippingCost = parseInt(initialCheckedShipping.dataset.cost);
            document.getElementById('selected-shipping-method-input').value = initialCheckedShipping.value;
        }
        calculateTotal(); // Panggil perhitungan total awal
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
<?php endif; ?><?php /**PATH D:\software\MotoPart\resources\views/cart/index.blade.php ENDPATH**/ ?>