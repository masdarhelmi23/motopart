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
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600"> Pesanan Terselesaikan</h1>

        
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
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
            ?>

            
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6 border-l-4 <?php echo e($borderColor); ?> hover:shadow-xl transition">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">🧾 No. Order: <?php echo e($order->id); ?></h2>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <p>💰 <span class="font-medium">Total:</span> Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></p>
                        
                        <p>🗓️ <span class="font-medium">Tanggal:</span> <?php echo e($order->created_at->format('d M Y H:i')); ?></p>
                    </div>
                </div>

                
                <div class="flex items-center gap-3 mt-4">
                    
                    
                    
                    <a href="<?php echo e(route('orders.invoice', $order->id)); ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm shadow">
                        Detail
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            
            <p class="text-center text-gray-500">🔍 Belum ada pesanan yang sudah dibayar.</p>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\software\MotoPart\resources\views/orders/index.blade.php ENDPATH**/ ?>