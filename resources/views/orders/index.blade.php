{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Pesanan Saya - FragrancesHub')

@section('content')
<div class="container py-5">
    <h2 class="section-heading mb-4">Pesanan Saya</h2>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:4rem;opacity:.2"><i class="bi bi-receipt-cutoff"></i></div>
            <h5 class="mt-3 text-muted">Belum ada pesanan</h5>
            <a href="{{ route('products.index') }}" class="btn btn-primary-custom mt-3">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-3">
            @foreach($orders as $order)
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                    <div>
                        <div class="small text-muted mb-1">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        <div class="fw-700" style="color:var(--green-dark);font-size:1rem;">
                            {{ $order->order_number }}
                        </div>
                    </div>
                    <span class="badge badge-status-{{ $order->status }}">
                        {{ $order->status_label }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">Total: </span>
                        <span class="fw-700" style="color:var(--green-mid);">{{ $order->formatted_total }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        @if($order->status === 'waiting_payment')
                            <a href="{{ route('payment.show', $order) }}" class="btn btn-gold btn-sm">
                                <i class="bi bi-upload me-1"></i>Upload Bukti
                            </a>
                        @endif
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-green btn-sm">
                            Detail <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
