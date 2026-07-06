@extends('layouts.app')
@section('title', 'Koleksi Parfum - FragrancesHub')

@section('content')

<div class="py-4" style="background:var(--gradient-main);">
    <div class="container">
        <h1 class="text-white mb-1" style="font-family:'Playfair Display',serif;font-size:1.8rem;">
            Koleksi Parfum
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
        @php
            $availableProducts = $products->filter(fn($product) => (int) $product->stock > 0);
            $soldOutProducts = $products->filter(fn($product) => (int) $product->stock === 0);
        @endphp

        <div class="row g-4">
            @foreach($availableProducts as $product)
                @include('products.partials.product-card', ['product' => $product])
            @endforeach
        </div>

        @if($soldOutProducts->isNotEmpty())
            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" style="color:#374151;">Produk Habis</h5>
                    <span class="small text-muted">{{ $soldOutProducts->count() }} produk</span>
                </div>
                <div class="row g-4">
                    @foreach($soldOutProducts as $product)
                        @include('products.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @endif

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
