@extends('layouts.app')
@section('title', 'Promo & Siaran - FragrancesHub')

@section('content')

{{-- ── HERO PROMO ──────────────────────────────────────── --}}
<section style="background:linear-gradient(135deg,#7f1d1d,#dc2626,#ef4444);padding:60px 0;position:relative;overflow:hidden;">
    {{-- Decorative circles --}}
    <div style="position:absolute;top:-80px;right:-80px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,0.05);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-60px;left:-60px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,0.05);pointer-events:none;"></div>

    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div style="display:inline-block;background:rgba(255,255,255,0.15);color:#fff;font-size:.78rem;font-weight:700;padding:5px 16px;border-radius:20px;letter-spacing:1.5px;margin-bottom:14px;">
                    <i class="bi bi-megaphone-fill me-1"></i>SIARAN & PROMOSI
                </div>
                <h1 style="font-family:'Playfair Display',serif;font-size:2.8rem;font-weight:700;color:#fff;line-height:1.2;margin-bottom:12px;">
                    Promo <span style="color:#fde68a;">Terbaik</span> Kami
                </h1>
                <p style="color:rgba(255,255,255,0.85);font-size:1.05rem;font-weight:300;margin-bottom:0;">
                    Dapatkan penawaran eksklusif dan siaran promosi terbaru dari FragrancesHub.<br>
                    Jangan lewatkan kesempatan emas ini!
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div style="font-size:7rem;opacity:.2;line-height:1;">🎉</div>
            </div>
        </div>
    </div>
</section>

{{-- ── SIARAN PROMOSI ────────────────────────────────────── --}}
@if($promos->isNotEmpty())
<section class="py-5" style="background:linear-gradient(135deg, #fff3cd 0%, #f9e7b3 100%);">
    <div class="container">
        <h2 class="section-heading mb-4" style="color:#856404;">
            📢 Siaran & Pengumuman Terbaru
        </h2>
        <div class="row g-4">
            @foreach($promos as $promo)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm rounded-4 overflow-hidden" style="border:none;transition:all .3s;">
                    @if($promo->image)
                    <div style="height:240px;overflow:hidden;background:#f0f0f0;">
                        <img src="{{ $promo->image_url }}" alt="{{ $promo->title }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    @else
                    <div style="height:240px;background:linear-gradient(135deg, #14532d 0%, #1a6b3a 100%);display:flex;align-items:center;justify-content:center;color:white;font-size:3rem;">
                        <i class="bi bi-megaphone"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title" style="color:#856404;font-family:'Playfair Display',serif;">
                            {{ $promo->title }}
                        </h5>
                        <p class="card-text text-muted small mb-3">
                            {{ Str::limit($promo->description, 120) }}
                        </p>
                        <div class="small text-muted mb-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $promo->start_date->format('d M Y') }} - {{ $promo->end_date->format('d M Y') }}
                        </div>
                        @if($promo->is_currently_active)
                        <span class="badge" style="background:#dc2626;color:white;">
                            <i class="bi bi-lightning-charge-fill me-1"></i>Berlaku Sekarang
                        </span>
                        @else
                        <span class="badge" style="background:#9ca3af;color:white;">
                            <i class="bi bi-clock me-1"></i>Segera Hadir
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination for promos --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $promos->links('vendor.pagination.custom') }}
        </div>
    </div>
</section>
@endif

{{-- ── FILTER & SORT PRODUK ────────────────────────────────── --}}
<div style="background:#fff;border-bottom:1px solid #f3f4f6;padding:16px 0;">
    <div class="container">
        <form method="GET" action="{{ route('promo.index') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="category" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-select form-select-sm">
                    <option value="discount_high" {{ request('sort','discount_high') == 'discount_high' ? 'selected' : '' }}>Diskon Terbesar</option>
                    <option value="discount_low"  {{ request('sort') == 'discount_low'  ? 'selected' : '' }}>Diskon Terkecil</option>
                    <option value="price_low"     {{ request('sort') == 'price_low'     ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_high"    {{ request('sort') == 'price_high'    ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary-custom px-3">Terapkan</button>
            </div>
            @if(request('category') || request('sort'))
            <div class="col-auto">
                <a href="{{ route('promo.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
            @endif
        </form>
    </div>
</div>

{{-- ── PRODUK DENGAN DISKON ─────────────────────────────────── --}}
<section class="py-5" style="background:var(--gray-light);">
    <div class="container">
        <h2 class="section-heading mb-4">
            <i class="bi bi-tag me-2"></i>Produk Diskon Terbaik ({{ $totalPromo }})
        </h2>

        @if($products->isEmpty())
        {{-- Kosong --}}
        <div class="text-center py-5">
            <div style="font-size:5rem;opacity:.3;">🏷️</div>
            <h4 style="color:#9ca3af;font-family:'Playfair Display',serif;">Belum Ada Produk Diskon</h4>
            <p class="text-muted">Pantau terus halaman ini untuk penawaran menarik!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary-custom mt-2">Lihat Semua Produk</a>
        </div>

        @else
        <div class="row g-4 mb-4">
            @foreach($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card card-product h-100" style="position:relative;">

                    {{-- Badge diskon besar --}}
                    <div style="position:absolute;top:12px;left:12px;z-index:3;">
                        <div style="background:#dc2626;color:#fff;font-size:.75rem;font-weight:800;padding:5px 12px;border-radius:20px;box-shadow:0 2px 8px rgba(220,38,38,0.4);">
                            -{{ $product->discount_percent }}%
                        </div>
                    </div>

                    {{-- Stok badge --}}
                    @if($product->stock == 0)
                    <div style="position:absolute;top:12px;right:12px;z-index:3;background:#6b7280;color:#fff;font-size:.7rem;font-weight:700;padding:4px 10px;border-radius:20px;">
                        Habis
                    </div>
                    @elseif($product->stock < 5)
                    <div style="position:absolute;top:12px;right:12px;z-index:3;background:#f59e0b;color:#fff;font-size:.7rem;font-weight:700;padding:4px 10px;border-radius:20px;">
                        Sisa {{ $product->stock }}
                    </div>
                    @endif

                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="card-img-wrap">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                     alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="bi bi-droplet"></i>
                                </div>
                            @endif
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <span class="badge-cat mb-1">{{ $product->category->name }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                            <h6 class="product-name">{{ $product->name }}</h6>
                        </a>
                        <p class="text-muted small mb-3" style="font-size:.82rem;line-height:1.5;">
                            {{ Str::limit($product->description, 60) }}
                        </p>
                        <div class="mt-auto">
                            <div class="mb-3">
                                <div class="product-price" style="font-size:1.3rem;color:var(--green-mid);">
                                    {{ $product->formatted_discounted_price }}
                                </div>
                                <div style="font-size:.75rem;color:#dc2626;font-weight:600;margin-top:4px;">
                                    Hemat: Rp {{ number_format((float) $product->price - (float) $product->discounted_price, 0, ',', '.') }}
                                </div>

                                <div style="text-decoration:line-through;color:#9ca3af;font-size:.9rem;">
                                    {{ $product->formatted_price }}
                                </div>

                            </div>
                            @auth
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary-custom w-100 btn-sm"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-bag-plus me-1"></i>
                                        {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-green w-100 btn-sm">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex flex-column align-items-center gap-2">
            <div style="font-size:.82rem;color:#9ca3af;font-weight:500;">
                Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }}
                dari <strong style="color:#374151;">{{ $products->total() }}</strong> produk
            </div>
            {{ $products->withQueryString()->links('vendor.pagination.custom') }}
        </div>
        @endif
    </div>
</section>

@endsection
