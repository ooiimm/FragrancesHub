<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - FragrancesHub')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    {{-- Reuse style from main layout --}}
    <style>
        :root {
            --green-dark:#0B3D2E;--green-mid:#14532D;--green-light:#166534;--green-deep:#1B4332;
            --gold:#C9A96E;--gold-light:#E8C98A;--white-soft:#F9F7F4;--black-soft:#1A1A1A;
            --gray-light:#F3F4F6;--gradient-main:linear-gradient(135deg,#0B3D2E,#14532D);
            --shadow-soft:0 4px 20px rgba(11,61,46,.12);--shadow-hover:0 8px 30px rgba(11,61,46,.22);
            --radius:12px;--radius-lg:20px;--transition:all .3s ease;
        }
        * { box-sizing: border-box; }
        body { font-family:'Jost',sans-serif; background:var(--gray-light); color:var(--black-soft); }
        h1,h2,h3,h4,.font-serif { font-family:'Playfair Display',serif; }

        /* Sidebar */
        .admin-sidebar {
            background:var(--gradient-main);
            min-height:100vh; width:255px; position:fixed;
            left:0; top:0; z-index:100;
            box-shadow:2px 0 20px rgba(0,0,0,.2);
        }
        .admin-sidebar .brand { padding:22px 20px; border-bottom:1px solid rgba(255,255,255,.1); }
        .admin-sidebar .brand h5 { font-family:'Playfair Display',serif; color:#fff; margin:0; font-size:1.15rem; }
        .admin-sidebar .brand small { color:var(--gold-light); font-size:.73rem; }
        .admin-sidebar .nav-link {
            color:rgba(255,255,255,.78); padding:11px 20px;
            font-weight:500; font-size:.88rem; transition:var(--transition);
            display:flex; align-items:center; gap:10px; border-left:3px solid transparent;
        }
        .admin-sidebar .nav-link:hover,.admin-sidebar .nav-link.active {
            background:rgba(255,255,255,.12); color:#fff;
            border-left-color:var(--gold-light);
        }
        .admin-sidebar .nav-link i { font-size:1.05rem; }
        .admin-sidebar .nav-section {
            font-size:.68rem; text-transform:uppercase; letter-spacing:1.5px;
            color:rgba(255,255,255,.4); padding:14px 20px 4px;
        }

        /* Content */
        .admin-content { margin-left:255px; min-height:100vh; }
        .admin-topbar {
            background:#fff; padding:14px 28px;
            box-shadow:0 2px 12px rgba(0,0,0,.06);
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:99;
        }
        .admin-topbar .page-title {
            font-family:'Playfair Display',serif; font-size:1.25rem;
            color:var(--green-dark); margin:0;
        }
        .admin-body { padding:28px; }

        /* Cards */
        .card-admin { border:none; border-radius:var(--radius-lg); box-shadow:var(--shadow-soft); background:#fff; }
        .card-admin .card-header {
            background:var(--gradient-main); color:#fff;
            border-radius:var(--radius-lg) var(--radius-lg) 0 0 !important;
            padding:16px 22px; border:none;
        }
        .card-admin .card-header h6 { font-family:'Playfair Display',serif; margin:0; font-size:1rem; }

        /* Stat Cards */
        .stat-card {
            border-radius:var(--radius-lg); padding:24px; color:#fff;
            position:relative; overflow:hidden; border:none; transition:var(--transition);
        }
        .stat-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-hover); }
        .stat-card .stat-icon { font-size:2.5rem; opacity:.25; position:absolute; top:16px; right:20px; }
        .stat-card .stat-value { font-size:1.85rem; font-weight:700; font-family:'Playfair Display',serif; }
        .stat-card .stat-label { font-size:.8rem; opacity:.82; margin-top:4px; }

        /* Table */
        .table-admin th {
            background:var(--gradient-main); color:#fff;
            font-weight:600; font-size:.82rem; letter-spacing:.3px; border:none;
        }
        .table-admin td { vertical-align:middle; border-color:#E5E7EB; font-size:.88rem; }
        .table-admin tbody tr:hover { background:#f0fdf4; }

        /* Buttons */
        .btn-primary-custom { background:var(--gradient-main); border:none; color:#fff; font-weight:600; border-radius:8px; padding:9px 20px; transition:var(--transition); }
        .btn-primary-custom:hover { color:#fff; box-shadow:var(--shadow-hover); transform:translateY(-1px); }
        .btn-gold { background:linear-gradient(135deg,#C9A96E,#E8C98A); border:none; color:var(--green-dark); font-weight:700; border-radius:8px; padding:9px 20px; transition:var(--transition); }
        .btn-gold:hover { color:var(--green-dark); box-shadow:0 4px 15px rgba(201,169,110,.4); transform:translateY(-1px); }

        /* Forms */
        .form-control,.form-select { border-radius:8px; border:1.5px solid #D1D5DB; padding:10px 14px; font-size:.9rem; transition:var(--transition); }
        .form-control:focus,.form-select:focus { border-color:var(--green-mid); box-shadow:0 0 0 3px rgba(20,83,45,.1); }
        label.form-label { font-weight:600; font-size:.86rem; color:#374151; }

        /* Alert */
        .alert { border-radius:var(--radius); border:none; }
        .alert-success { background:#d1fae5; color:#065f46; }
        .alert-danger  { background:#fee2e2; color:#991b1b; }
        .alert-warning { background:#fef9c3; color:#854d0e; }

        /* Badges */
        .badge { border-radius:20px; padding:5px 12px; font-size:.74rem; font-weight:600; }
        .badge-status-pending         { background:#FEF3C7; color:#92400E; }
        .badge-status-waiting_payment { background:#FEF3C7; color:#92400E; }
        .badge-status-payment_uploaded{ background:#DBEAFE; color:#1E40AF; }
        .badge-status-processing      { background:#D1FAE5; color:#065F46; }
        .badge-status-shipped         { background:#D1FAE5; color:#065F46; }
        .badge-status-delivered       { background:#DCFCE7; color:#14532D; }
        .badge-status-cancelled       { background:#FEE2E2; color:#991B1B; }

        /* Status Pembayaran — warna sama dengan status pesanan */
        .badge-payment-pending        { background:#FEF3C7; color:#92400E; }
        .badge-payment-verified       { background:#DCFCE7; color:#14532D; }
        .badge-payment-rejected       { background:#FEE2E2; color:#991B1B; }

        .no-image-placeholder { width:100%;height:100%;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--green-mid); }
        @media(max-width:768px){.admin-sidebar{display:none;}.admin-content{margin-left:0;}}
    </style>
    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ───────────────────────────────────────── --}}
<aside class="admin-sidebar">
    <div class="brand">
        <h5><i class="bi bi-droplet-fill me-2"></i>FragrancesHub</h5>
        <small>Admin Panel</small>
    </div>
    <nav class="pt-2">
        <div class="nav-section">Dashboard</div>
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Katalog</div>
        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
           href="{{ route('admin.products.index') }}">
            <i class="bi bi-droplet"></i> Produk
        </a>
        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
           href="{{ route('admin.categories.index') }}">
            <i class="bi bi-tags"></i> Kategori
        </a>

        <div class="nav-section">Transaksi</div>
        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
           href="{{ route('admin.orders.index') }}">
            <i class="bi bi-receipt"></i> Pesanan
        </a>

        <div class="nav-section">Akun</div>
        <a class="nav-link" href="{{ route('home') }}" target="_blank">
            <i class="bi bi-shop"></i> Lihat Toko
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0"
                    style="background:transparent;cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</aside>

{{-- ── CONTENT ───────────────────────────────────────── --}}
<div class="admin-content">
    <div class="admin-topbar">
        <h6 class="page-title">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-1"
                 style="width:34px;height:34px;background:var(--gradient-main);color:#fff;font-size:.85rem;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <div class="fw-600 small">{{ auth()->user()->name }}</div>
                <div style="font-size:.72rem;color:var(--green-mid);">Administrator</div>
            </div>
        </div>
    </div>
    <div class="admin-body">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
