@extends('layouts.app')
@section('title', 'Detail Pesanan - FragrancesHub')

@section('content')
<div class="container py-5">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-green btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i>Semua Pesanan
    </a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 style="font-family:'Playfair Display',serif;color:var(--green-dark);">
                            {{ $order->order_number }}
                        </h5>
                        <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                    </div>
                    <span class="badge badge-status-{{ $order->status }} fs-6">
                        {{ $order->status_label }}
                    </span>
                </div>
                <hr>
                {{-- Items --}}
                @foreach($order->orderItems as $item)
                <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                    <div class="rounded-3 overflow-hidden me-3 flex-shrink-0"
                         style="width:65px;height:65px;background:var(--gray-light);">
                        @if($item->product && $item->product->image)
                            <img src="{{ $item->product->image_url }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div class="no-image-placeholder" style="height:100%;font-size:1.8rem;">
                                <i class="bi bi-droplet"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-600">{{ $item->product_name }}</div>
                        @if($item->variant_size)
                            <div class="small" style="color:var(--green-mid);font-weight:600;">
                                Ukuran: {{ $item->variant_size }}
                            </div>
                        @endif
                        <div class="small text-muted">
                            {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="fw-700" style="color:var(--green-mid);">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-700 fs-5" style="color:var(--green-dark);">
                    <span>Total</span>
                    <span>{{ $order->formatted_total }}</span>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h6 class="mb-3" style="color:var(--green-dark);">
                    <i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman
                </h6>
                <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                <p class="mb-1 text-muted">{{ $order->phone }}</p>
                <p class="mb-0 text-muted">{{ $order->shipping_address }}</p>
                @if($order->notes)
                    <hr>
                    <small class="text-muted"><i class="bi bi-chat-text me-1"></i>{{ $order->notes }}</small>
                @endif
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h6 class="mb-3" style="color:var(--green-dark);font-family:'Playfair Display',serif;">
                    <i class="bi bi-credit-card me-2"></i>Info Pembayaran
                </h6>
                
                {{-- Payment Method --}}
                <div class="mb-3 pb-3 border-bottom">
                    <div class="small text-muted mb-2">Metode Pembayaran</div>
                    <div class="fw-600" style="color:var(--green-mid);">
                        @if($order->payment_method === 'bank_transfer')
                            🏦 Transfer Bank
                        @elseif($order->payment_method === 'ovo')
                            📱 OVO
                        @elseif($order->payment_method === 'gopay')
                            📱 GoPay
                        @elseif($order->payment_method === 'dana')
                            📱 Dana
                        @elseif($order->payment_method === 'cod')
                            🚚 Cash On Delivery (COD)
                        @else
                            {{ $order->payment_method_label }}
                        @endif
                    </div>
                </div>

                {{-- Payment Method Details --}}
                @if($order->payment_method === 'bank_transfer' && $order->payment)
                    <div class="mb-3 pb-3 border-bottom">
                        <table class="table table-sm table-borderless small">
                            <tr>
                                <td class="text-muted">Rekening Tujuan</td>
                                <td class="fw-600">{{ $order->payment->recipient_account ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Atas Nama</td>
                                <td class="fw-600">{{ $order->payment->recipient_name ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Payment Notes untuk Transfer Bank --}}
                    @if($order->payment->payment_notes)
                        <div class="alert alert-info small mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            {!! nl2br(e($order->payment->payment_notes)) !!}
                        </div>
                    @endif

                @elseif(in_array($order->payment_method, ['ovo', 'gopay', 'dana']) && $order->payment)
                    <div class="mb-3 pb-3 border-bottom">
                        <table class="table table-sm table-borderless small">
                            <tr>
                                <td class="text-muted">Nomor</td>
                                <td class="fw-600">{{ $order->payment->phone_number ?? $order->payment->recipient_account ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Payment Notes untuk E-Wallet --}}
                    @if($order->payment->payment_notes)
                        <div class="alert alert-info small mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            {!! nl2br(e($order->payment->payment_notes)) !!}
                        </div>
                    @endif

                @elseif($order->payment_method === 'cod')
                    <div class="alert alert-warning small mb-3">
                        <i class="bi bi-truck me-2"></i>
                        <strong>Pembayaran Tunai</strong><br>
                        Bayar langsung kepada kurir saat barang tiba di tangan Anda.
                    </div>
                @endif

                {{-- Status Pembayaran --}}
                <div class="mb-3 pb-3 border-bottom">
                    <div class="small text-muted mb-2">Status Pembayaran</div>
                    @if($order->payment)
                        <span class="badge badge-payment-{{ $order->payment->status }}">
                            {{ $order->payment->status_label }}
                        </span>
                    @else
                        <span class="badge bg-warning">Belum Dibayar</span>
                    @endif
                </div>

                {{-- Proof Image Display --}}
                @if($order->payment && $order->payment->proof_image)
                    <div class="mb-3">
                        <div class="small text-muted mb-2">
                            <i class="bi bi-image me-1"></i>Bukti Pembayaran:
                        </div>
                        <img src="{{ $order->payment->proof_url }}"
                             class="img-fluid rounded-3" style="max-height:220px;border:1px solid #e5e7eb;">
                    </div>
                @endif

                {{-- Action Buttons --}}
                @if($order->status === 'waiting_payment' && in_array($order->payment_method, ['bank_transfer', 'ovo', 'gopay', 'dana']))
                    <a href="{{ route('payment.show', $order) }}" class="btn btn-gold w-100">
                        <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                    </a>
                @elseif($order->status === 'waiting_payment' && $order->payment_method === 'cod')
                    <div class="alert alert-info mb-0 text-center">
                        <small>Tunggu kurir menghubungi Anda</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
