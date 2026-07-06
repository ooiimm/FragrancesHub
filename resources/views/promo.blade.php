@extends('layouts.app')
@section('title', 'Promo & Diskon - FragrancesHub')

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
                    🏷️ PENAWARAN TERBATAS
                </div>
                <h1 style="font-family:'Playfair Display',serif;font-size:2.8rem;font-weight:700;color:#fff;line-height:1.2;margin-bottom:12px;">
                    Promo <span style="color:#fde68a;">Spesial</span> Parfum
                </h1>
                <p style="color:rgba(255,255,255,0.85);font-size:1.05rem;font-weight:300;margin-bottom:0;">
                    Dapatkan parfum impian Anda dengan harga terbaik.<br>
                    Jangan sampai kehabisan 
                    stok terbatas!
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div style="font-size:7rem;opacity:.2;line-height:1;">🏷️</div>
            </div>
        </div>

        
    </div>
</section>

{{-- ── FILTER & SORT ────────────────────────────────────── --}}
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

{{-- ── PRODUK PROMO ─────────────────────────────────────── --}}
<section class="py-5" style="background:var(--gray-light);">
    <div class="container">

        @if($products->isEmpty())
        {{-- Kosong --}}
        <div class="text-center py-5">
            <div style="font-size:5rem;opacity:.3;">🏷️</div>
            <h4 style="color:#9ca3af;font-family:'Playfair Display',serif;">Belum Ada Produk Promo</h4>
            <p class="text-muted">Pantau terus halaman ini untuk penawaran menarik!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary-custom mt-2">Lihat Semua Produk</a>
        </div>

        @else
        <div class="row g-4">
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

                    {{-- Gambar --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="card-img-wrap">
                            @if($product->image)
                                <img src="{{ $product->image_url }}"
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
                            {{ Str::limit($product->description, 65) }}
                        </p>

                        <div class="mt-auto">
                            {{-- Harga --}}
                            <div class="mb-3">
                                <div style="font-size:1.15rem;font-weight:700;color:#14532d;">
                                    {{ $product->formatted_discounted_price }}
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span style="text-decoration:line-through;color:#9ca3af;font-size:.85rem;">
                                        {{ $product->formatted_price }}
                                    </span>
                                    <span style="background:#fee2e2;color:#dc2626;font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:20px;">
                                        Hemat Rp {{ number_format($product->price - $product->discounted_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            @auth
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary-custom w-100 btn-sm">
                                            <i class="bi bi-bag-plus me-1"></i>Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="btn btn-secondary w-100 btn-sm">
                                        <i class="bi bi-x-circle me-1"></i>Stok Habis
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-green w-100 btn-sm">
                                    <i class="bi bi-bag-plus me-1"></i>Login untuk Beli
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex flex-column align-items-center mt-5 gap-2">
            <div style="font-size:.82rem;color:#9ca3af;font-weight:500;">
                Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }}
                dari <strong style="color:#374151;">{{ $products->total() }}</strong> produk promo
            </div>
            {{ $products->withQueryString()->links('vendor.pagination.custom') }}
        </div>
        @endif

    </div>
</section>

@endsection
