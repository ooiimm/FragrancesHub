@extends('layouts.app')
@section('title', $product->name . ' - FragrancesHub')

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color:var(--green-mid)">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none" style="color:var(--green-mid)">Produk</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Gambar Produk --}}
        <div class="col-lg-5">
            <div class="rounded-4 overflow-hidden shadow" style="aspect-ratio:1;background:var(--gray-light);display:flex;align-items:center;justify-content:center;">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                         class="w-100 h-100" style="object-fit:cover;">
                @else
                    <div class="no-image-placeholder" style="height:100%;font-size:6rem;">
                        <i class="bi bi-droplet"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="col-lg-7">
            <span class="badge mb-3" style="background:rgba(20,83,45,.1);color:var(--green-mid);font-size:.8rem;">
                {{ $product->category->name }}
            </span>
            <h1 class="mb-3" style="font-family:'Playfair Display',serif;font-size:2rem;color:var(--black-soft);">
                {{ $product->name }}
            </h1>
            <div class="mb-4">
                @if($product->is_on_sale)
                    <div style="display:inline-block;background:#dc2626;color:#fff;font-size:.78rem;font-weight:700;padding:4px 12px;border-radius:20px;margin-bottom:8px;">
                        🏷️ PROMO -{{ $product->discount_percent }}% OFF
                    </div><br>
                    <span style="font-size:1.8rem;font-weight:700;color:var(--green-mid);">{{ $product->formatted_discounted_price }}</span>
                    <span style="text-decoration:line-through;color:#9ca3af;font-size:1.1rem;margin-left:10px;">{{ $product->formatted_price }}</span>
                    <div style="color:#dc2626;font-size:.85rem;font-weight:600;margin-top:4px;">
                        Hemat {{ $product->formatted_price }} → {{ $product->formatted_discounted_price }}
                    </div>
                @else
                    <span style="font-size:1.8rem;font-weight:700;color:var(--green-mid);">{{ $product->formatted_price }}</span>
                @endif
            </div>
            <p class="text-muted mb-4" style="line-height:1.8;">
                {{ $product->description ?? 'Parfum premium dengan aroma yang memukau.' }}
            </p>

            {{-- Stok --}}
            <div class="mb-4 p-3 rounded-3" style="background:var(--gray-light);">
                @if($product->stock > 10)
                    <span class="text-success fw-600"><i class="bi bi-check-circle me-2"></i>Tersedia ({{ $product->stock }} pcs)</span>
                @elseif($product->stock > 0)
                    <span class="text-warning fw-600"><i class="bi bi-exclamation-circle me-2"></i>Stok Terbatas ({{ $product->stock }} tersisa)</span>
                @else
                    <span class="text-danger fw-600"><i class="bi bi-x-circle me-2"></i>Stok Habis</span>
                @endif
            </div>

            {{-- Form Tambah Keranjang --}}
            @auth
                @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-auto">
                            <label class="form-label">Jumlah</label>
                            <div class="input-group" style="width:130px;">
                                <button type="button" class="btn btn-outline-secondary" id="btnMinus">-</button>
                                <input type="number" name="quantity" id="qtyInput"
                                       class="form-control text-center" value="1"
                                       min="1" max="{{ $product->stock }}">
                                <button type="button" class="btn btn-outline-secondary" id="btnPlus">+</button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary-custom w-100 py-2">
                                <i class="bi bi-bag-plus me-2"></i>Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </form>
                @else
                    <button class="btn btn-secondary w-100 py-2" disabled>Stok Habis</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary-custom w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Membeli
                </a>
            @endauth
        </div>
    </div>

    {{-- Produk Terkait --}}
    @if($related->isNotEmpty())
    <div class="mt-6 pt-4 border-top">
        <h3 class="section-heading mb-4">Produk Terkait</h3>
        <div class="row g-4">
            @foreach($related as $item)
            <div class="col-lg-3 col-md-6">
                <div class="card card-product h-100">
                    <a href="{{ route('products.show', $item->slug) }}">
                        <div class="card-img-wrap">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}">
                            @else
                                <div class="no-image-placeholder"><i class="bi bi-droplet"></i></div>
                            @endif
                        </div>
                    </a>
                    <div class="card-body">
                        <h6 class="product-name">{{ $item->name }}</h6>
                        <span class="product-price">{{ $item->formatted_price }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    const qty = document.getElementById('qtyInput');
    const max = {{ $product->stock }};
    document.getElementById('btnMinus').addEventListener('click', () => {
        if (parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1;
    });
    document.getElementById('btnPlus').addEventListener('click', () => {
        if (parseInt(qty.value) < max) qty.value = parseInt(qty.value) + 1;
    });
</script>
@endpush
@endsection
