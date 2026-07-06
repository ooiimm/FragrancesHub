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
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
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
                    <span id="productMainPrice" style="font-size:1.8rem;font-weight:700;color:var(--green-mid);">{{ $product->formatted_discounted_price }}</span>
                    <span style="text-decoration:line-through;color:#9ca3af;font-size:1.1rem;margin-left:10px;">{{ $product->formatted_price }}</span>
                    @php($hemat = (float) $product->price - (float) $product->discounted_price)
                    <div style="color:#dc2626;font-size:.85rem;font-weight:600;margin-top:4px;">
                        Hemat {{ 'Rp ' . number_format($hemat, 0, ',', '.') }}
                    </div>

                @else
                    <span id="productMainPrice" style="font-size:1.8rem;font-weight:700;color:var(--green-mid);">{{ $product->formatted_price }}</span>
                @endif
            </div>
            <p class="text-muted mb-4" style="line-height:1.8;">
                {{ $product->description ?? 'Parfum premium dengan aroma yang memukau.' }}
            </p>

            {{-- Stok --}}
            <div class="mb-4 p-3 rounded-3" style="background:var(--gray-light);">
                @if($product->variants->isNotEmpty())
                    <p class="mb-0 text-muted" style="font-size:0.85rem;">
                        <i class="bi bi-info-circle me-1"></i>Pilih varian untuk melihat stok
                    </p>
                @elseif($product->stock > 10)
                    <span class="text-success fw-600"><i class="bi bi-check-circle me-2"></i>Tersedia ({{ $product->stock }} pcs)</span>
                @elseif($product->stock > 0)
                    <span class="text-warning fw-600"><i class="bi bi-exclamation-circle me-2"></i>Stok Terbatas ({{ $product->stock }} tersisa)</span>
                @else
                    <span class="text-danger fw-600"><i class="bi bi-x-circle me-2"></i>Stok Habis</span>
                @endif
            </div>

            {{-- Pilih Varian --}}
            @if($product->variants->isNotEmpty())
            <div class="mb-4 p-4 rounded-3" style="background:#f9f9f9;border:2px solid #e5e7eb;">
                <label class="form-label fw-600 mb-3">
                    <i class="bi bi-droplet me-2" style="color:var(--green-mid);"></i>Pilih Ukuran Produk
                </label>
                <div class="d-flex gap-2 flex-wrap" id="variantsContainer">
                    {{-- Base Product Option --}}
                    <div class="flex-grow-1" style="min-width:140px;">
                        <label class="card variant-option" style="cursor:pointer;border:2px solid #e5e7eb;border-radius:12px;padding:12px;transition:all 0.3s;margin-bottom:0;">
                            <input type="radio" name="variant_id" value="0" 
                                   class="d-none variant-input" data-stock="{{ $product->stock }}" 
                                   data-price="{{ $product->is_on_sale ? $product->discounted_price : $product->price }}">
                            <div class="text-center">
                                <div class="fw-600" style="color:var(--green-dark);font-size:1rem;">
                                    Base Product
                                </div>
                                <div style="color:var(--green-mid);font-size:1.1rem;font-weight:700;margin-top:4px;">
                                    Rp {{ number_format($product->is_on_sale ? $product->discounted_price : $product->price, 0, ',', '.') }}
                                </div>
                                <div class="small text-muted" style="margin-top:4px;">
                                    @if($product->stock > 5)
                                        <i class="bi bi-check-circle-fill" style="color:#10b981;"></i> Tersedia
                                    @elseif($product->stock > 0)
                                        <i class="bi bi-exclamation-circle-fill" style="color:#f59e0b;"></i> Terbatas
                                    @else
                                        <i class="bi bi-x-circle-fill" style="color:#ef4444;"></i> Habis
                                    @endif
                                </div>
                            </div>
                        </label>
                    </div>
                    
                    {{-- Variant Options --}}
                    @foreach($product->variants as $variant)
                        <div class="flex-grow-1" style="min-width:140px;">
                            <label class="card variant-option" style="cursor:pointer;border:2px solid #e5e7eb;border-radius:12px;padding:12px;transition:all 0.3s;margin-bottom:0;">
                                <input type="radio" name="variant_id" value="{{ $variant->id }}" 
                                       class="d-none variant-input" data-stock="{{ $variant->stock }}" 
                                       data-price="{{ $variant->price }}">
                                <div class="text-center">
                                    <div class="fw-600" style="color:var(--green-dark);font-size:1rem;">
                                        {{ $variant->size }}
                                    </div>
                                    <div style="color:var(--green-mid);font-size:1.1rem;font-weight:700;margin-top:4px;">
                                        Rp {{ number_format($variant->price, 0, ',', '.') }}
                                    </div>
                                    <div class="small text-muted" style="margin-top:4px;">
                                        @if($variant->stock > 5)
                                            <i class="bi bi-check-circle-fill" style="color:#10b981;"></i> Tersedia
                                        @elseif($variant->stock > 0)
                                            <i class="bi bi-exclamation-circle-fill" style="color:#f59e0b;"></i> Terbatas
                                        @else
                                            <i class="bi bi-x-circle-fill" style="color:#ef4444;"></i> Habis
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                <div id="variantInfo" class="mt-3 alert alert-info d-none">
                    Stok: <span id="variantStock" class="fw-700"></span>
                </div>
            </div>
            @endif

            {{-- Form Tambah Keranjang --}}
            @auth
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    @if($product->variants->isNotEmpty())
                        <input type="hidden" name="variant_id" id="selectedVariantInput">
                    @endif
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
                            <button type="submit" class="btn btn-primary-custom w-100 py-2" id="addToCartBtn">
                                <i class="bi bi-bag-plus me-2"></i>Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </form>
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
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
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
<style>
    .variant-option {
        background: #fff !important;
    }

    .variant-option.is-selected {
        border-color: var(--green-mid) !important;
        box-shadow: 0 0 0 1px rgba(20,83,45,0.12);
        background: #fff !important;
    }

    .variant-option input:checked + div {
        background: transparent !important;
    }
    
    .variant-option:hover {
        border-color: var(--green-mid) !important;
        background: #fff !important;
    }
</style>
<script>
    const qty = document.getElementById('qtyInput');
    const maxDefault = {{ $product->stock }};
    let currentMax = maxDefault;

    function setAddToCartButtonText(text) {
        const btn = document.getElementById('addToCartBtn');
        if (!btn) return;

        const icon = document.createElement('i');
        icon.className = 'bi bi-bag-plus me-2';
        icon.setAttribute('aria-hidden', 'true');
        btn.replaceChildren(icon, document.createTextNode(text));
    }

    function updateSelectedVariantStyle() {
        document.querySelectorAll('.variant-option').forEach(option => {
            const input = option.querySelector('.variant-input');
            option.classList.toggle('is-selected', input?.checked);
        });
    }

    function formatRupiah(value) {
        return 'Rp ' + value.toLocaleString('id-ID', {maximumFractionDigits: 0});
    }

    function updateMainProductPrice(price) {
        const mainPrice = document.getElementById('productMainPrice');
        if (!mainPrice) return;

        mainPrice.textContent = formatRupiah(price);
    }
    
    function updateVariantInfo(radio) {
        radio = radio.target ?? radio;

        const stock = parseInt(radio.dataset.stock);
        const price = parseFloat(radio.dataset.price);
        currentMax = stock;
        
        // Update max quantity
        qty.max = stock;
        if (parseInt(qty.value) > stock) {
            qty.value = stock;
        }
        
        // Show variant info
        document.getElementById('variantInfo').classList.remove('d-none');
        document.getElementById('variantStock').textContent = stock + ' pcs';
        updateMainProductPrice(price);

        const selectedVariantInput = document.getElementById('selectedVariantInput');
        if (selectedVariantInput) {
            selectedVariantInput.value = radio.value;
        }

        updateSelectedVariantStyle();
        
        // Update button state
        updateAddToCartButton();
    }
    
    function updateAddToCartButton() {
        const btn = document.getElementById('addToCartBtn');
        const selectedVariant = document.querySelector('input.variant-input[name="variant_id"]:checked');
        const variants = document.querySelectorAll('input.variant-input[name="variant_id"]');
        
        if (variants.length > 0) {
            if (!selectedVariant) {
                btn.disabled = true;
                setAddToCartButtonText('Pilih varian terlebih dahulu');
            } else if (parseInt(selectedVariant.dataset.stock) === 0) {
                btn.disabled = true;
                setAddToCartButtonText('Stok tidak tersedia');
            } else {
                btn.disabled = false;
                setAddToCartButtonText('Tambah ke Keranjang');
            }
        }
    }
    
    // Event listeners
    document.querySelectorAll('input.variant-input[name="variant_id"]').forEach(radio => {
        radio.addEventListener('change', () => updateVariantInfo(radio));
    });
    
    document.getElementById('btnMinus').addEventListener('click', () => {
        if (parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1;
    });
    document.getElementById('btnPlus').addEventListener('click', () => {
        if (parseInt(qty.value) < currentMax) qty.value = parseInt(qty.value) + 1;
    });
    
    // Initialize button state
    updateSelectedVariantStyle();
    updateAddToCartButton();
</script>
@endpush
@endsection
