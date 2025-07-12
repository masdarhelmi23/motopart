<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pesanan #<?php echo e($order->id); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 25px;
            border: 1px solid #eee;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
            position: relative; /* Added for absolute positioning of logo */
        }
        h1, h2, h3 {
            color: #4f46e5;
            margin-bottom: 10px;
        }
        .info, .items, .footer {
            margin-top: 30px;
        }
        .info p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-paid { background: #dcfce7; color: #16a34a; }
        .badge-pending { background: #fef9c3; color: #ca8a04; }
        .badge-cancelled { background: #fee2e2; color: #dc2626; }
        .logo {
            position: absolute;
            top: 25px; /* Adjust as needed */
            right: 25px; /* Adjust as needed */
            max-width: 150px; /* Adjust logo size */
            height: auto;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <!-- Logo added here, using Laravel's asset helper for public path -->
        <img src="<?php echo e(asset('images/logo-motopart.png')); ?>" alt="Motopart Logo" class="logo">

        <div class="flex justify-between items-center">
            <h1>🧾 Nota Pesanan</h1>
            <p><strong>#<?php echo e($order->id); ?></strong></p>
        </div>

        <div class="info">
            <p><strong>Nama Pelanggan:</strong> <?php echo e($order->user->name ?? '-'); ?></p>
            <p><strong>Tanggal Pesanan:</strong> <?php echo e($order->created_at->format('d M Y H:i')); ?></p>
            
            <p><strong>Metode Pembayaran:</strong> <?php echo e(ucfirst($order->payment_method ?? '-')); ?></p>
        </div>

        <div class="items">
            <h2>📦 Rincian Barang</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
    <?php if($order->orderItems): ?>
        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->product->name ?? '-'); ?></td>
                                <td class="text-center"><?php echo e($item->quantity); ?></td>
                                <td class="text-right">Rp <?php echo e(number_format($item->unit_amount, 0, ',', '.')); ?></td>
                                <td class="text-right">Rp <?php echo e(number_format($item->total_amount, 0, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">Tidak ada item pada pesanan ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td class="text-right"><strong>Rp <?php echo e(number_format($order->grand_total ?? $order->total_price, 0, ',', '.')); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <?php if($order->notes): ?>
            <div class="footer">
                <h3>📝 Catatan:</h3>
                <p><?php echo e($order->notes); ?></p>
            </div>
        <?php endif; ?>

        <div class="no-print text-center mt-6">
            <button onclick="window.print()" style="background: #4f46e5; color: white; padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer;">
                🖨️ Cetak Nota
            </button>
        </div>
    </div>

</body>
</html>
<?php /**PATH D:\software\MotoPart\resources\views/orders/invoice.blade.php ENDPATH**/ ?>