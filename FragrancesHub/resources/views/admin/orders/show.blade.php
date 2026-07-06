@extends('layouts.admin')
@section('title', 'Detail Pesanan - Admin')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Pesanan
    </a>
</div>

<div class="row g-4">
    {{-- Kiri: info pesanan --}}
    <div class="col-lg-8">

        {{-- Header Pesanan --}}
        <div class="card card-admin mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="bi bi-receipt me-2"></i>{{ $order->order_number }}</h6>
                <span class="badge badge-status-{{ $order->status }} fs-6">
                    {{ $order->status_label }}
                </span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="small text-muted">Pelanggan</div>
                        <div class="fw-600">{{ $order->user->name }}</div>
                        <div class="small text-muted">{{ $order->user->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted">Tanggal Pesanan</div>
                        <div class="fw-600">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted">No. Telepon</div>
                        <div class="fw-600">{{ $order->phone }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted">Total Pembayaran</div>
                        <div class="fw-700 fs-5" style="color:var(--green-mid);">
                            {{ $order->formatted_total }}
                        </div>
                    </div>
                </div>
                <div>
                    <div class="small text-muted">Alamat Pengiriman</div>
                    <div class="fw-600">{{ $order->shipping_address }}</div>
                </div>
                @if($order->notes)
                <div class="mt-2">
                    <div class="small text-muted">Catatan</div>
                    <div class="fst-italic text-muted small">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div class="card card-admin mb-4">
            <div class="card-header">
                <h6><i class="bi bi-box me-2"></i>Item Pesanan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-2 overflow-hidden flex-shrink-0"
                                             style="width:48px;height:48px;background:var(--gray-light);">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}"
                                                     style="width:100%;height:100%;object-fit:cover;">
                                            @else
                                                <div class="no-image-placeholder" style="height:100%;font-size:1.2rem;">
                                                    <i class="bi bi-droplet"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="fw-600 small">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end small">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end fw-700" style="color:var(--green-mid);">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:#f0fdf4;">
                                <td colspan="3" class="text-end fw-700">Total</td>
                                <td class="text-end fw-700 fs-6" style="color:var(--green-dark);">
                                    {{ $order->formatted_total }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Kanan: pembayaran & ubah status --}}
    <div class="col-lg-4">

        {{-- Ubah Status --}}
        <div class="card card-admin mb-4">
            <div class="card-header">
                <h6><i class="bi bi-arrow-repeat me-2"></i>Ubah Status Pesanan</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Status Baru</label>
                        <select name="status" class="form-select">
                            @foreach([
                                'pending'           => 'Menunggu',
                                'waiting_payment'   => 'Menunggu Pembayaran',
                                'payment_uploaded'  => 'Bukti Diunggah',
                                'processing'        => 'Diproses',
                                'shipped'           => 'Dikirim',
                                'delivered'         => 'Selesai',
                                'cancelled'         => 'Dibatalkan',
                            ] as $val => $label)
                                <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="bi bi-check-lg me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        {{-- Info Pembayaran --}}
        @if($order->payment)
        <div class="card card-admin">
            <div class="card-header">
                <h6><i class="bi bi-credit-card me-2"></i>Info Pembayaran</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-sm table-borderless small mb-3">
                    <tr>
                        <td class="text-muted">Bank</td>
                        <td class="fw-600">{{ $order->payment->bank_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. Rekening</td>
                        <td class="fw-600">{{ $order->payment->account_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jumlah</td>
                        <td class="fw-700" style="color:var(--green-mid);">
                            Rp {{ number_format($order->payment->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <span class="badge badge-payment-{{ $order->payment->status }}">
                                {{ $order->payment->status_label }}
                            </span>
                        </td>
                    </tr>
                </table>

                @if($order->payment->proof_image)
                    <div class="mb-3">
                        <div class="small text-muted fw-600 mb-2">Bukti Transfer:</div>
                        <a href="{{ $order->payment->proof_url }}" target="_blank">
                            <img src="{{ $order->payment->proof_url }}"
                                 class="img-fluid rounded-3"
                                 style="max-height:220px;border:2px solid #e5e7eb;cursor:zoom-in;">
                        </a>
                        <div class="small text-muted mt-1">Klik gambar untuk memperbesar</div>
                    </div>
                @else
                    <div class="text-center py-3 rounded-3" style="background:var(--gray-light);">
                        <i class="bi bi-image text-muted" style="font-size:2rem;opacity:.4;"></i>
                        <div class="small text-muted mt-1">Bukti transfer belum diunggah</div>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
