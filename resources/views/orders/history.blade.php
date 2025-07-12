<h2>Riwayat Pesanan</h2>

@forelse ($orders as $order)
    <div>
        <h4>Order #{{ $order->id }} - Status: {{ $order->status }}</h4>
        <ul>
            @foreach ($order->orderItems as $item)
                <li>{{ $item->product->name }} - {{ $item->quantity }} x Rp{{ number_format($item->price) }}</li>
            @endforeach
        </ul>
        <strong>Total: Rp{{ number_format($order->grand_total) }}</strong>
    </div>
    <hr>
@empty
    <p>Tidak ada riwayat pesanan</p>
@endforelse
