@extends('layouts.app')
@section('title', 'Koleksi Parfum - FragrancesHub')

@section('content')

<div class="py-4" style="background:var(--gradient-main);">
    <div class="container">
        <h1 class="text-white mb-1" style="font-family:'Playfair Display',serif;font-size:1.8rem;">
            <i class="bi bi-droplet me-2"></i>Koleksi Parfum
        </h1>
        <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:.9rem;">
            Temukan parfum sempurna dari koleksi premium kami
        </p>
    </div>
</div>

<div class="container py-4">

    {{-- SEARCH & FILTER --}}
    <form method="GET" action="{{ route('products.index') }}" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search"
                           class="form-control border-start-0"
                           placeholder="Cari parfum..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
            </div>
            @if(request('search') || request('category'))
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x me-1"></i>Reset
                </a>
            </div>
            @endif
        </div>
    </form>

    @if($products->total() > 0)
    <p class="text-muted small mb-3">
        Menampilkan <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
        dari <strong>{{ $products->total() }}</strong> produk
    </p>
    @endif

    {{-- DAFTAR PRODUK --}}
    @if($products->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:4rem;opacity:.2;">🔍</div>
            <h5 class="mt-3 text-muted">Produk tidak ditemukan</h5>
            <a href="{{ route('products.index') }}" class="btn btn-primary-custom mt-2">
                Lihat Semua Produk
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card card-product h-100">

                    {{-- Gambar --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="card-img-wrap" style="position:relative;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="bi bi-droplet"></i>
                                </div>
                            @endif
                            @if($product->stock == 0)
                                <div style="position:absolute;top:10px;right:10px;
                                            background:#ef4444;color:#fff;font-size:.7rem;
                                            font-weight:700;padding:3px 10px;border-radius:20px;">
                                    Habis
                                </div>
                            @elseif($product->stock < 5)
                                <div style="position:absolute;top:10px;right:10px;
                                            background:#f59e0b;color:#fff;font-size:.7rem;
                                            font-weight:700;padding:3px 10px;border-radius:20px;">
                                    Sisa {{ $product->stock }}
                                </div>
                            @endif
                            @if($product->is_on_sale)
                                <div style="position:absolute;top:10px;left:10px;background:#dc2626;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;">
                                    🏷️ -{{ $product->discount_percent }}%
                                </div>
                            @endif
                        </div>
                    </a>

                    <div class="card-body d-flex flex-column">
                        <span class="badge-cat mb-1">{{ $product->category->name }}</span>

                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                            <h6 class="product-name">{{ $product->name }}</h6>
                        </a>

                        @if($product->description)
                        <p class="text-muted mb-3" style="font-size:.81rem;line-height:1.5;">
                            {{ Str::limit($product->description, 65) }}
                        </p>
                        @endif

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    @if($product->is_on_sale)
                                        <div class="product-price">{{ $product->formatted_discounted_price }}</div>
                                        <div style="text-decoration:line-through;color:#9ca3af;font-size:.82rem;line-height:1;">{{ $product->formatted_price }}</div>
                                    @else
                                        <span class="product-price">{{ $product->formatted_price }}</span>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-box me-1"></i>{{ $product->stock }} pcs
                                </small>
                            </div>

                            {{-- Tombol Tambah Keranjang --}}
                            @auth
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary-custom w-100 btn-sm mb-1">
                                            <i class="bi bi-bag-plus me-1"></i>Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-secondary w-100 btn-sm mb-1" disabled>
                                        <i class="bi bi-x-circle me-1"></i>Stok Habis
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-green w-100 btn-sm mb-1">
                                    <i class="bi bi-bag-plus me-1"></i>Login untuk Beli
                                </a>
                            @endauth

                            {{-- Tombol Lihat Detail --}}
                            <a href="{{ route('products.show', $product->slug) }}"
                               class="btn w-100 btn-sm"
                               style="border:1.5px solid #14532d;color:#14532d;border-radius:8px;
                                      font-weight:600;background:transparent;">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex flex-column align-items-center mt-5 gap-2">
            <div style="font-size:.82rem;color:#9ca3af;font-weight:500;">
                Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }}
                dari <strong style="color:#374151;">{{ $products->total() }}</strong> produk
            </div>
            {{ $products->withQueryString()->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>
@endsection
