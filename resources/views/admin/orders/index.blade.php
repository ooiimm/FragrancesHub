@extends('layouts.admin')
@section('title', 'Pesanan - Admin')
@section('page-title', '    Data Pesanan')

@section('content')

{{-- Filter --}}
<form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
    <div class="row g-2">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari nomor pesanan..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                @foreach([
                    'pending'           => 'Menunggu',
                    'waiting_payment'   => 'Menunggu Pembayaran',
                    'payment_uploaded'  => 'Bukti Diunggah',
                    'processing'        => 'Diproses',
                    'shipped'           => 'Dikirim',
                    'delivered'         => 'Selesai',
                    'cancelled'         => 'Dibatalkan',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary-custom">Filter</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.orders.report', request()->all()) }}" class="btn btn-outline-primary">
                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
            </a>
        </div>
        @if(request('search') || request('status'))
        <div class="col-auto">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
        @endif
    </div>
</form>

<div class="card card-admin">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-600 small">{{ $order->order_number }}</td>
                        <td>
                            <div class="fw-600 small">{{ $order->user->name }}</div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $order->user->email }}</div>
                        </td>
                        <td class="fw-700" style="color:var(--green-mid);">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($order->payment)
                                <span class="badge badge-payment-{{ $order->payment->status }}">
                                    {{ $order->payment->status_label }}
                                </span>
                                @if($order->payment->proof_image)
                                    <br>
                                    <a href="{{ $order->payment->proof_url }}" target="_blank"
                                       class="small text-muted mt-1 d-inline-block">
                                        <i class="bi bi-image me-1"></i>Lihat Bukti
                                    </a>
                                @endif
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-status-{{ $order->status }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white border-top-0">
        {{ $orders->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
