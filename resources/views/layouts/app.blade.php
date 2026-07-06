<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FragrancesHub - Premium Perfume Store')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --green-dark:    #0B3D2E;
            --green-mid:     #14532D;
            --green-light:   #166534;
            --green-deep:    #1B4332;
            --gold:          #C9A96E;
            --gold-light:    #E8C98A;
            --white-soft:    #F9F7F4;
            --black-soft:    #1A1A1A;
            --gray-light:    #F3F4F6;
            --gradient-main: linear-gradient(135deg, #0B3D2E, #14532D);
            --shadow-soft:   0 4px 20px rgba(11,61,46,0.12);
            --shadow-hover:  0 8px 30px rgba(11,61,46,0.22);
            --radius:        12px;
            --radius-lg:     20px;
            --transition:    all 0.3s ease;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            background: var(--white-soft);
            color: var(--black-soft);
            min-height: 100vh;
        }
        h1,h2,h3,h4,.font-serif { font-family: 'Playfair Display', serif; }

        /* ── NAVBAR ──────────────────────────────────────── */
        .navbar-main {
            background: var(--gradient-main);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: none;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #fff !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .navbar-brand img {
            height: 56px;
            width: auto;
            object-fit: contain;
            border-radius: 8px;
            display: inline-block;
        }
        .navbar-brand .brand-accent { color: var(--gold-light); }

        /* Nav links — pastikan pointer-events aktif */
        .navbar-main .nav-link {
            color: rgba(255,255,255,0.88) !important;
            font-weight: 500;
            font-size: 0.92rem;
            padding: 7px 14px !important;
            border-radius: 8px;
            transition: var(--transition);
            letter-spacing: 0.3px;
            cursor: pointer;
            pointer-events: auto !important;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none !important;
        }
        .navbar-main .nav-link:hover {
            color: #fff !important;
            background: rgba(255,255,255,0.15);
            text-decoration: none;
        }
        .navbar-main .nav-link.active-link {
            color: var(--gold-light) !important;
            background: rgba(201,169,110,0.18);
        }
        .navbar-toggler { border-color: rgba(255,255,255,0.4); }
        .navbar-toggler-icon { filter: invert(1); }

        /* Cart badge */
        .cart-badge {
            background: var(--gold);
            color: #fff;
            font-size: 0.62rem;
            padding: 1px 5px;
            border-radius: 20px;
            font-weight: 700;
            position: absolute;
            top: 2px;
            right: 2px;
            pointer-events: none;
        }

        /* ── BUTTONS ─────────────────────────────────────── */
        .btn-primary-custom {
            background: var(--gradient-main);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 24px;
            transition: var(--transition);
            cursor: pointer;
        }
        .btn-primary-custom:hover {
            color: #fff;
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }
        .btn-gold {
            background: linear-gradient(135deg, #C9A96E, #E8C98A);
            border: none;
            color: var(--green-dark);
            font-weight: 700;
            border-radius: 8px;
            padding: 10px 24px;
            transition: var(--transition);
            cursor: pointer;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #B8924A, #C9A96E);
            color: var(--green-dark);
            box-shadow: 0 4px 15px rgba(201,169,110,0.4);
            transform: translateY(-1px);
        }
        .btn-outline-green {
            border: 2px solid var(--green-mid);
            color: var(--green-mid);
            background: transparent;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            transition: var(--transition);
        }
        .btn-outline-green:hover {
            background: var(--green-mid);
            color: #fff;
        }

        /* ── PRODUCT CARDS ───────────────────────────────── */
        .card-product {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            overflow: hidden;
            background: #fff;
        }
        .card-product:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }
        .card-product .card-img-wrap {
            height: 220px;
            overflow: hidden;
            background: var(--gray-light);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .card-product .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .card-product:hover .card-img-wrap img { transform: scale(1.05); }
        .card-product .card-body { padding: 1.1rem; }
        .badge-cat {
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(20,83,45,0.1);
            color: var(--green-mid);
            border-radius: 20px;
            padding: 3px 10px;
            display: inline-block;
        }
        .product-name {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--black-soft);
            margin: 5px 0 3px;
        }
        .product-price {
            color: var(--green-mid);
            font-weight: 700;
            font-size: 1rem;
        }

        /* ── HERO ────────────────────────────────────────── */
        .hero-section {
            background: var(--gradient-main);
            padding: 80px 0 70px;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(201,169,110,0.07);
            pointer-events: none;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }
        .hero-title span { color: var(--gold-light); }
        .hero-sub {
            color: rgba(255,255,255,0.8);
            font-size: 1.05rem;
            font-weight: 300;
            line-height: 1.7;
        }

        /* ── SECTION HEADING ─────────────────────────────── */
        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--green-dark);
            position: relative;
            padding-bottom: 10px;
        }
        .section-heading::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 48px; height: 3px;
            background: var(--gold);
            border-radius: 2px;
        }

        /* ── ALERTS ──────────────────────────────────────── */
        .alert { border-radius: var(--radius); border: none; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }
        .alert-info    { background: #dbeafe; color: #1e40af; }
        .alert-warning { background: #fef9c3; color: #854d0e; }

        /* ── FORMS ───────────────────────────────────────── */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid #D1D5DB;
            padding: 10px 14px;
            font-size: 0.92rem;
            transition: var(--transition);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--green-mid);
            box-shadow: 0 0 0 3px rgba(20,83,45,0.1);
        }
        label.form-label { font-weight: 600; font-size: 0.88rem; color: #374151; }

        /* ── NO IMAGE ────────────────────────────────────── */
        .no-image-placeholder {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--green-mid);
        }

        /* ── FOOTER ──────────────────────────────────────── */
        .footer-main {
            background: var(--gradient-main);
            color: rgba(255,255,255,0.85);
            padding: 50px 0 24px;
            margin-top: 80px;
        }
        .footer-main .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            color: #fff;
            font-weight: 700;
        }
        .footer-main .footer-brand span { color: var(--gold-light); }
        .footer-main a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: var(--transition);
        }
        .footer-main a:hover { color: var(--gold-light); }
        .footer-divider { border-color: rgba(255,255,255,0.15); }


        .badge { border-radius: 20px; padding: 4px 12px; font-size: 0.76rem; font-weight: 600; }
        .badge-status-pending          { background: #FEF3C7; color: #92400E; }
        .badge-status-waiting_payment  { background: #FEF3C7; color: #92400E; }
        .badge-status-payment_uploaded { background: #DBEAFE; color: #1E40AF; }
        .badge-status-processing       { background: #D1FAE5; color: #065F46; }
        .badge-status-shipped          { background: #D1FAE5; color: #065F46; }
        .badge-status-delivered        { background: #DCFCE7; color: #14532D; }
        .badge-status-cancelled        { background: #FEE2E2; color: #991B1B; }

        /* Status Pembayaran — warna sama dengan status pesanan */
        .badge-payment-pending         { background: #FEF3C7; color: #92400E; }
        .badge-payment-verified        { background: #DCFCE7; color: #14532D; }
        .badge-payment-rejected        { background: #FEE2E2; color: #991B1B; }

        /* ── ADMIN SIDEBAR (keep) ────────────────────────── */
        .admin-sidebar {
            background: var(--gradient-main);
            min-height: 100vh;
            width: 255px;
            position: fixed;
            left: 0; top: 0;
            z-index: 100;
            box-shadow: 2px 0 20px rgba(0,0,0,.2);
        }
        .admin-content { margin-left: 255px; min-height: 100vh; background: var(--gray-light); }

        @media (max-width: 991px) {
            .navbar-brand { font-size: 1.5rem; }
            .navbar-brand img { width: 44px; height:44px; }
        }

        @media (max-width: 768px) {
            .admin-sidebar { display: none; }
            .admin-content { margin-left: 0; }
            .hero-title { font-size: 2rem; }
            .navbar-brand { font-size: 1.25rem; }
            .navbar-brand img { width: 40px; height:40px; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ═══════════════════════════════════════════════════════
     NAVBAR — hanya untuk halaman non-admin
═══════════════════════════════════════════════════════ --}}
@unless(request()->is('admin*'))
<nav class="navbar navbar-main navbar-expand-lg">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="FragrancesHub logo">
            <span>Fragrances<span class="brand-accent">Hub</span></span>
        </a>

        {{-- Toggler mobile --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMain"
                aria-controls="navMain" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">

            {{-- Nav Kiri --}}
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active-link' : '' }}"
                       href="{{ url('/') }}">
                        Beranda
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('products*') || request()->is('promo*') ? 'active-link' : '' }}"
                       href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Produk
                    </a>
                    <ul class="dropdown-menu shadow border-0"
                        style="background:#fff;border-radius:12px;min-width:200px;padding:8px;margin-top:8px;">
                        <li>
                            <a class="dropdown-item rounded-3 py-2 {{ request()->is('products*') ? 'active' : '' }}"
                               href="{{ url('/products') }}"
                               style="font-size:.9rem;">
                                <i class="bi bi-grid me-2" style="color:#14532d;"></i>Semua Produk
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            @php $promoCount = \App\Models\Product::where('is_active',1)->where('discount_percent','>',0)->count(); @endphp
                            <a class="dropdown-item rounded-3 py-2 d-flex align-items-center justify-content-between {{ request()->is('promo*') ? 'active' : '' }}"
                               href="{{ route('promo.index') }}"
                               style="font-size:.9rem;">
                                <span><i class="bi bi-tags-fill me-2" style="color:#dc2626;"></i>Promo & Diskon</span>
                                @if($promoCount > 0)
                                <span style="background:#dc2626;color:#fff;font-size:.65rem;font-weight:700;padding:2px 7px;border-radius:20px;">
                                    {{ $promoCount }}
                                </span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            {{-- Nav Kanan --}}
            <ul class="navbar-nav align-items-center gap-1">
                @auth
                    {{-- Keranjang --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative px-3"
                           href="{{ url('/cart') }}"
                           style="font-size:1.2rem;">
                            <i class="bi bi-bag"></i>
                            @php $cartCount = auth()->user()->carts()->count(); @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    {{-- Dropdown user --}}
                    <li class="nav-item dropdown">
                        @php
                            $orderCount = auth()->user()->orders()
                                ->whereNotIn('status', ['delivered','cancelled'])
                                ->count();
                        @endphp
                        <a class="nav-link dropdown-toggle position-relative" href="#"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- Avatar inisial --}}
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle me-1"
                                  style="width:28px;height:28px;background:rgba(255,255,255,0.2);
                                         font-size:.75rem;font-weight:700;color:#fff;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            {{ auth()->user()->name }}
                            {{-- Badge notif pesanan aktif --}}
                            @if($orderCount > 0)
                                <span style="position:absolute;top:2px;right:2px;
                                             background:#ef4444;color:#fff;
                                             font-size:.58rem;font-weight:700;
                                             width:16px;height:16px;border-radius:50%;
                                             display:flex;align-items:center;justify-content:center;
                                             pointer-events:none;">
                                    {{ $orderCount > 9 ? '9+' : $orderCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow"
                            style="border-radius:14px;border:none;min-width:230px;padding:8px;">

                            {{-- Info user --}}
                            <li class="px-3 py-2 mb-1"
                                style="background:#f9fafb;border-radius:10px;">
                                <div class="fw-700 small" style="color:#0B3D2E;">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    {{ auth()->user()->email }}
                                </div>
                            </li>

                            {{-- Edit Profil --}}
                            <li>
                                <a class="dropdown-item py-2 rounded-3" href="{{ url('/profile') }}"
                                   style="font-size:.88rem;">
                                    <i class="bi bi-person-gear me-2" style="color:#14532d;"></i>
                                    Edit Profil
                                </a>
                            </li>

                            {{-- Pesanan Saya + badge --}}
                            <li>
                                <a class="dropdown-item py-2 rounded-3 d-flex align-items-center justify-content-between"
                                   href="{{ url('/orders') }}" style="font-size:.88rem;">
                                    <span>
                                        <i class="bi bi-receipt me-2" style="color:#14532d;"></i>
                                        Pesanan Saya
                                    </span>
                                    @if($orderCount > 0)
                                        <span style="background:#ef4444;color:#fff;
                                                     font-size:.68rem;font-weight:700;
                                                     padding:2px 7px;border-radius:20px;
                                                     min-width:20px;text-align:center;">
                                            {{ $orderCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item py-2 rounded-3" href="{{ url('/admin/dashboard') }}"
                                       style="font-size:.88rem;">
                                        <i class="bi bi-speedometer2 me-2 text-success"></i>
                                        Dashboard Admin
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider my-1"></li>

                            {{-- Logout --}}
                            <li>
                                <form method="POST" action="{{ url('/logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="dropdown-item py-2 rounded-3 text-danger"
                                            style="font-size:.88rem;">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-gold btn-sm ms-1 px-3" href="{{ url('/register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>
@endunless

{{-- ═══════════════════════════════════════════════════════
     FLASH MESSAGES
═══════════════════════════════════════════════════════ --}}
@unless(request()->is('admin*'))
@if(session('success') || session('error') || session('warning'))
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>
@endif
@endunless

{{-- ═══════════════════════════════════════════════════════
     KONTEN HALAMAN
═══════════════════════════════════════════════════════ --}}
@yield('content')

{{-- ═══════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════ --}}
@unless(request()->is('admin*'))
<footer class="footer-main">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-5">
                <div class="footer-brand mb-2">
                    Fragrances<span>Hub</span>
                </div>
                <p class="small opacity-75 mb-0">
                    Toko parfum premium dengan koleksi eksklusif dari berbagai brand ternama dunia dan lokal terbaik Indonesia.
                </p>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white mb-3 fw-600">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ url('/') }}"><i class="bi bi-house me-2"></i>Beranda</a></li>
                    <li class="mb-2"><a href="{{ url('/products') }}"><i class="bi bi-grid me-2"></i>Produk</a></li>
                    @auth
                    <li class="mb-2"><a href="{{ url('/cart') }}"><i class="bi bi-bag me-2"></i>Keranjang</a></li>
                    <li class="mb-2"><a href="{{ url('/orders') }}"><i class="bi bi-receipt me-2"></i>Pesanan Saya</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="text-white mb-3">Hubungi Kami</h6>
                <div class="small opacity-80">
                    <p class="mb-1"><i class="bi bi-envelope me-2"></i>hello@fragranceshub.com</p>
                    <p class="mb-1"><i class="bi bi-whatsapp me-2"></i>+62 819-0863-4683</p>
                    <p class="mb-0"><i class="bi bi-instagram me-2"></i>@fragranceshub</p>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <p class="text-center small opacity-60 mb-0">
            &copy; {{ date('Y') }} FragrancesHub. All rights reserved.
            Made By</i> Indonesia.
        </p>
    </div>
</footer>
@endunless

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

@unless(request()->is('admin*'))
{{-- ═══════════════════════════════════════════
     TOMBOL WHATSAPP FLOATING
═══════════════════════════════════════════ --}}
<a href="https://wa.me/6281908634683?text=Halo%20FragrancesHub%2C%20saya%20ingin%20bertanya%20tentang%20produk%20parfum%20Anda."
   target="_blank" rel="noopener"
   id="wa-float-btn"
   title="Chat WhatsApp"
   style="
       position: fixed;
       bottom: 28px;
       right: 28px;
       z-index: 9999;
       width: 58px;
       height: 58px;
       background: #25D366;
       color: #fff;
       border-radius: 50%;
       display: flex;
       align-items: center;
       justify-content: center;
       font-size: 1.7rem;
       box-shadow: 0 4px 20px rgba(37,211,102,0.5);
       text-decoration: none;
       transition: transform 0.2s ease, box-shadow 0.2s ease;
   "
   onmouseover="this.style.transform='scale(1.12)';this.style.boxShadow='0 6px 28px rgba(37,211,102,0.65)';"
   onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 20px rgba(37,211,102,0.5)';">
    <i class="bi bi-whatsapp"></i>
</a>

{{-- Tooltip bubble WA --}}
<div id="wa-tooltip"
     style="
         position:fixed;
         bottom:36px;
         right:96px;
         z-index:9998;
         background:#fff;
         color:#1a1a1a;
         padding:8px 14px;
         border-radius:20px;
         font-size:.82rem;
         font-weight:600;
         box-shadow:0 4px 16px rgba(0,0,0,0.12);
         white-space:nowrap;
         animation: waPopIn 0.4s ease 1.5s both;
         display:none;
     ">
    💬 Ada yang bisa kami bantu?
    <span style="position:absolute;right:-8px;top:50%;transform:translateY(-50%);
                 width:0;height:0;border-top:7px solid transparent;
                 border-bottom:7px solid transparent;border-left:8px solid #fff;"></span>
</div>
<style>
@keyframes waPopIn {
    from { opacity:0; transform:translateX(10px); }
    to   { opacity:1; transform:translateX(0); }
}
</style>
<script>
    // Tampilkan tooltip WA setelah 2 detik
    setTimeout(function() {
        var t = document.getElementById('wa-tooltip');
        if(t) { t.style.display = 'block'; }
        // Sembunyikan lagi setelah 5 detik
        setTimeout(function() {
            if(t) { t.style.display = 'none'; }
        }, 5000);
    }, 2000);
</script>

{{-- ═══════════════════════════════════════════
     HISTATS — STATISTIK PENGUNJUNG
     Ganti YOUR_HISTATS_ID dengan ID akun Histats Anda
     Daftar gratis di: https://www.histats.com
═══════════════════════════════════════════ --}}
<script type="text/javascript">
var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,YOUR_HISTATS_ID,4,0,0,0,00000000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
    var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
    hs.src = ('//s10.histats.com/js15_as.js');
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();
</script>
<noscript>
    <a href="/" target="_blank">
        <img src="//sstatic1.histats.com/0.gif?YOUR_HISTATS_ID&101" alt="free web stats" border="0">
    </a>
</noscript>
@endunless

</body>
</html>
