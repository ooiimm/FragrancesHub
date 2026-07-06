@php
    $siteName = config('app.name', 'FragrancesHub');
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pesanan - {{ $siteName }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#222 }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px }
        .title { font-size:18px; font-weight:700 }
        table { width:100%; border-collapse:collapse; font-size:12px }
        th, td { border:1px solid #ddd; padding:6px 8px; }
        th { background:#f5f5f5; text-align:left }
        .text-right { text-align:right }
        .muted { color:#666; font-size:11px }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">Laporan Pesanan</div>
            <div class="muted">Generated: {{ now()->format('d M Y H:i') }}</div>
        </div>
        <div style="text-align:right">
            <div>{{ $siteName }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Items</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name }}\n{{ $order->user->email }}</td>
                <td>
                    @foreach($order->orderItems as $item)
                        {{ $item->quantity }} x {{ $item->product_name }}@if($item->variant_size) ({{ $item->variant_size }})@endif@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td class="text-right">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                <td>
                    @if($order->payment)
                        {{ $order->payment->status_label }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $order->status_label }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="muted">Tidak ada pesanan untuk laporan ini</td>
            </tr>
            @endforelse
        </tbody>
        @if($orders->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalAmount,0,',','.') }}</strong></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>
