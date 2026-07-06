@extends('layouts.admin')
@section('title', 'Dashboard - Admin FragrancesHub')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#0B3D2E,#166534);">
            <div class="stat-icon"><i class="bi bi-droplet"></i></div>
            <div class="stat-value">{{ $stats['total_products'] }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#C9A96E,#B8924A);">
            <div class="stat-icon"><i class="bi bi-receipt"></i></div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#1d4ed8,#2563eb);">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Pelanggan</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#7c3aed,#8b5cf6);">
            <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-value" style="font-size:1.3rem;">
                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
            </div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>
</div>

@if($stats['pending_orders'] > 0)
<div class="alert alert-warning d-flex align-items-center mb-4">
    <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
    <div>
        Ada <strong>{{ $stats['pending_orders'] }} pesanan</strong> dengan bukti transfer yang perlu diverifikasi.
        <a href="{{ route('admin.orders.index', ['status' => 'payment_uploaded']) }}" class="alert-link ms-2">
            Lihat sekarang →
        </a>
    </div>
</div>
@endif

{{-- Sales Chart --}}
<div class="row g-4 mb-5">
    <div class="col-lg-12">
        <div class="card card-admin h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="bi bi-graph-up me-2"></i>Penjualan per Bulan</h6>
                <span class="small" style="opacity:.9">12 bulan terakhir</span>
            </div>
            <div class="card-body">
                <div style="height:360px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="card card-admin">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6><i class="bi bi-clock-history me-2"></i>Pesanan Terbaru</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-gold">Lihat Semua</a>
    </div>
</div>

{{-- Recent Orders --}}
<div class="card card-admin">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="fw-600">{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td class="fw-600" style="color:var(--green-mid);">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
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
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const labels = @json($labels ?? []);
        const sales = @json($monthlySalesSeries ?? []);

        if (!document.getElementById('salesChart')) return;
        const ctx = document.getElementById('salesChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan',
                    data: sales,
                    borderColor: '#14532D',
                    backgroundColor: 'rgba(20,83,45,0.15)',
                    pointBackgroundColor: '#14532D',
                    pointRadius: 4,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y || 0;
                                return ' Rp ' + Number(value).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + Number(value).toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    })();
</script>
@endpush

@endsection
