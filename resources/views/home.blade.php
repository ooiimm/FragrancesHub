@extends('layouts.app')
@section('title', 'FragrancesHub - Toko Parfum Premium')

@section('content')

{{-- ── HERO REDESIGN ──────────────────────────────────── --}}
<section style="
    background: linear-gradient(135deg, #0B3D2E 0%, #14532D 60%, #1a6b3a 100%);
    min-height: 520px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
">
    {{-- Ornamen lingkaran besar kanan atas --}}
    <div style="position:absolute;top:-120px;right:-120px;width:480px;height:480px;border-radius:50%;border:2px solid rgba(212,175,55,0.15);pointer-events:none;"></div>
    <div style="position:absolute;top:-60px;right:-60px;width:360px;height:360px;border-radius:50%;border:1.5px solid rgba(212,175,55,0.1);pointer-events:none;"></div>

    {{-- Ornamen bunga SVG kanan --}}
    <div style="position:absolute;right:0;top:0;bottom:0;width:45%;pointer-events:none;overflow:hidden;" class="d-none d-lg-block">
        {{-- Ornamen lingkaran motif --}}
        <svg viewBox="0 0 500 520" xmlns="http://www.w3.org/2000/svg"
             style="position:absolute;right:-40px;top:0;height:100%;opacity:.18;">
            <circle cx="320" cy="100" r="180" fill="none" stroke="#D4AF37" stroke-width="1.5"/>
            <circle cx="320" cy="100" r="140" fill="none" stroke="#D4AF37" stroke-width="1"/>
            <!-- Motif batik dalam lingkaran -->
            <g transform="translate(320,100)">
                @for($i=0;$i<8;$i++)
                <line x1="0" y1="-180" x2="0" y2="180" stroke="#D4AF37" stroke-width=".8" transform="rotate({{ $i*22.5 }})"/>
                @endfor
                @for($j=0;$j<6;$j++)
                <ellipse cx="0" cy="-110" rx="25" ry="45" fill="none" stroke="#D4AF37" stroke-width="1" transform="rotate({{ $j*60 }})"/>
                @endfor
            </g>
            <circle cx="420" cy="380" r="120" fill="none" stroke="#D4AF37" stroke-width="1"/>
        </svg>

        {{-- Bunga emas --}}
        <svg viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg"
             style="position:absolute;right:60px;top:50%;transform:translateY(-50%);width:220px;opacity:.85;">
            <g transform="translate(150,150)">
                <!-- Kelopak bunga -->
                @for($k=0;$k<5;$k++)
                <ellipse cx="0" cy="-70" rx="28" ry="55"
                         fill="#D4AF37" opacity=".9"
                         transform="rotate({{ $k*72 }})"/>
                @endfor
                <!-- Kelopak dalam -->
                @for($l=0;$l<5;$l++)
                <ellipse cx="0" cy="-45" rx="16" ry="32"
                         fill="#C9982A" opacity=".7"
                         transform="rotate({{ $l*72+36 }})"/>
                @endfor
                <circle cx="0" cy="0" r="22" fill="#D4AF37"/>
                <circle cx="0" cy="0" r="14" fill="#B8860B"/>
            </g>
        </svg>

        {{-- Bunga kecil pojok kanan bawah --}}
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"
             style="position:absolute;right:0;bottom:20px;width:130px;opacity:.5;">
            <g transform="translate(100,100)">
                @for($m=0;$m<5;$m++)
                <ellipse cx="0" cy="-45" rx="18" ry="36"
                         fill="#D4AF37"
                         transform="rotate({{ $m*72 }})"/>
                @endfor
                <circle cx="0" cy="0" r="14" fill="#D4AF37"/>
            </g>
        </svg>
    </div>

    {{-- Ornamen kiri bawah --}}
    <div style="position:absolute;bottom:-80px;left:-80px;width:250px;height:250px;border-radius:50%;border:1px solid rgba(212,175,55,0.1);pointer-events:none;"></div>

    <div class="container position-relative" style="z-index:2;padding:80px 0;">
        <div class="row align-items-center">
            <div class="col-lg-6">
                {{-- Label --}}
                <div class="mb-3 d-flex align-items-center gap-2">
                    <span style="color:#D4AF37;letter-spacing:2.5px;font-size:.75rem;font-weight:700;text-transform:uppercase;">
                        Premium Fragrance Collection
                    </span>
                </div>

                {{-- Judul --}}
                <h1 style="
                    font-family:'Playfair Display',serif;
                    font-size:clamp(2.2rem,5vw,3.4rem);
                    font-weight:700;
                    color:#fff;
                    line-height:1.2;
                    margin-bottom:1.2rem;
                ">
                    Temukan Aroma<br>
                    <span style="color:#D4AF37;">Sempurna</span> Untuk Anda
                </h1>

                {{-- Sub --}}
                <p style="color:rgba(255,255,255,0.75);font-size:1rem;line-height:1.7;margin-bottom:2rem;max-width:480px;">
                    Koleksi parfum eksklusif dari brand ternama dunia dan lokal terbaik.
                    Ekspresikan kepribadian Anda melalui wewangian pilihan.
                </p>

                {{-- Tombol --}}
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}"
                       style="
                           display:inline-flex;align-items:center;gap:8px;
                           background:#D4AF37;color:#0B3D2E;
                           font-weight:700;font-size:.95rem;
                           padding:12px 28px;border-radius:8px;
                           text-decoration:none;
                           transition:all .2s ease;
                           box-shadow:0 4px 16px rgba(212,175,55,0.35);
                       "
                       onmouseover="this.style.background='#C9982A';this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='#D4AF37';this.style.transform='translateY(0)';">
                        <i class="bi bi-bag-fill"></i> Belanja Sekarang
                    </a>
                    <a href="{{ route('promo.index') }}"
                       style="
                           display:inline-flex;align-items:center;gap:8px;
                           background:transparent;color:#fff;
                           font-weight:600;font-size:.95rem;
                           padding:12px 28px;border-radius:8px;
                           text-decoration:none;
                           border:1.5px solid rgba(255,255,255,0.4);
                           transition:all .2s ease;
                       "
                       onmouseover="this.style.borderColor='#D4AF37';this.style.color='#D4AF37';"
                       onmouseout="this.style.borderColor='rgba(255,255,255,0.4)';this.style.color='#fff';">
                        <i class="bi bi-tags-fill"></i> Lihat Promo
                    </a>
                    @auth
                    <a href="{{ route('products.index') }}"
                       style="
                           display:inline-flex;align-items:center;gap:8px;
                           background:transparent;color:#fff;
                           font-weight:600;font-size:.95rem;
                           padding:12px 28px;border-radius:8px;
                           text-decoration:none;
                           border:1.5px solid rgba(255,255,255,0.4);
                           transition:all .2s ease;
                       "
                       onmouseover="this.style.borderColor='#D4AF37';this.style.color='#D4AF37';"
                       onmouseout="this.style.borderColor='rgba(255,255,255,0.4)';this.style.color='#fff';">
                        <i class="bi bi-grid"></i> Jelajahi Koleksi
                    </a>
                    @else
                    @endauth
                </div>

                {{-- Stats --}}
                <div class="d-flex gap-4 mt-4 pt-2">
                    <div>
                        <div style="font-size:1.4rem;font-weight:700;color:#D4AF37;font-family:'Playfair Display',serif;">100+</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,0.6);">Koleksi Parfum</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.15);"></div>
                    <div>
                        <div style="font-size:1.4rem;font-weight:700;color:#D4AF37;font-family:'Playfair Display',serif;">1000+</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,0.6);">Pelanggan Puas</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.15);"></div>
                    <div>
                        <div style="font-size:1.4rem;font-weight:700;color:#D4AF37;font-family:'Playfair Display',serif;">100%</div>
                        <div style="font-size:.75rem;color:rgba(255,255,255,0.6);">Produk Original</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── SEARCH & FILTER ────────────────────────────────── --}}
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <form method="GET" action="{{ route('home') }}" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                        placeholder="Cari parfum favorit Anda..."
                        value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary-custom w-100">Cari</button>
            </div>
            @if(request('search') || request('category'))
            <div class="col-md-1">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100" title="Reset">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            @endif
        </form>
    </div>
</section>

{{-- ── PROMOS (BANNER INFORMASI) ────────────────────────── --}}
@if($promos->isNotEmpty())
<section class="py-5" style="background:linear-gradient(135deg, #fff3cd 0%, #f9e7b3 100%);">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4 gap-3 flex-wrap">
            <h2 class="section-heading mb-0" style="color:#856404;">
                <i class="bi bi-megaphone-fill me-2"></i>Siaran & Promosi Terbaru
            </h2>
            <a href="{{ route('promo.index') }}" class="btn btn-outline-dark btn-sm">
                Lihat Semua Promosi <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @php($firstPromo = $promos->first())
        <div class="row g-4 align-items-stretch mb-4">
            <div class="col-lg-7">
                <div class="card shadow-sm rounded-4 overflow-hidden" style="border:none;">
                    @if($firstPromo && $firstPromo->image)
                        <div style="height:320px;overflow:hidden;background:#f0f0f0;">
                            <img src="{{ $firstPromo->image_url }}" alt="{{ $firstPromo->title }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    @else
                        <div style="height:320px; background:linear-gradient(135deg, #14532d 0%, #1a6b3a 100%); display:flex; align-items:center; justify-content:center; color:#fff;">
                            <div class="text-center">
                                <div style="font-size:3.5rem;opacity:.9;">📣</div>
                                <div style="font-weight:800;font-family:'Playfair Display',serif;">{{ $firstPromo?->title ?? 'Promo Terbaru' }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="card-body" style="background:rgba(255,255,255,.92);">
                        <h3 class="card-title" style="color:#856404;font-family:'Playfair Display',serif;font-weight:800;">
                            {{ $firstPromo?->title }}
                        </h3>
                        <p class="card-text text-muted mb-3" style="max-width:560px;">
                            {{ Str::limit($firstPromo?->description, 160) }}
                        </p>
                        <div class="small text-muted mb-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $firstPromo?->start_date?->format('d M Y') }} - {{ $firstPromo?->end_date?->format('d M Y') }}
                        </div>
                        <a href="{{ route('promo.index') }}" class="btn btn-gold">
                            Lihat Detail Promo <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="row g-4">
                    @foreach($promos->slice(1,3) as $promo)
                        <div class="col-12">
                            <div class="card h-100 shadow-sm rounded-4 overflow-hidden" style="border:none;">
                                @if($promo->image)
                                    <div style="height:160px;overflow:hidden;background:#f0f0f0;">
                                        <img src="{{ $promo->image_url }}" alt="{{ $promo->title }}"
                                             style="width:100%;height:100%;object-fit:cover;">
                                    </div>
                                @else
                                    <div style="height:160px;background:linear-gradient(135deg,#7f1d1d,#dc2626,#ef4444);display:flex;align-items:center;justify-content:center;color:#fff;">
                                        <i class="bi bi-megaphone-fill" style="font-size:2.4rem;"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title" style="color:#856404;font-family:'Playfair Display',serif;">
                                        {{ $promo->title }}
                                    </h5>
                                    <p class="card-text text-muted small mb-2">
                                        {{ Str::limit($promo->description, 90) }}
                                    </p>
                                    <div class="small text-muted mb-3">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $promo->start_date->format('d M Y') }} - {{ $promo->end_date->format('d M Y') }}
                                    </div>
                                    <a href="{{ route('promo.index') }}" class="btn btn-sm" style="background:#856404;color:#fff;border-radius:8px;">
                                        Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── BEST SELLER ───────────────────────────────────────── --}}
@if(isset($bestSellers) && $bestSellers->isNotEmpty())
<section class="py-5" style="background:#fff;">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4 gap-3 flex-wrap">
            <h2 class="section-heading mb-0">
                <i class="bi bi-fire" style="color:#f59e0b;" class="me-2"></i>
                Best Seller
            </h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-green btn-sm">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($bestSellers as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-product h-100">
                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                            <div class="card-img-wrap" style="position:relative;">
                                @if($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div class="no-image-placeholder"><i class="bi bi-droplet"></i></div>
                                @endif

                                <div style="position:absolute;top:10px;left:10px;background:#fbbf24;color:#000;font-size:.78rem;font-weight:800;padding:6px 12px;border-radius:20px;z-index:2;">
                                    🔥 Best Seller
                                </div>

                                @if($product->stock == 0)
                                    <div style="position:absolute;top:10px;right:10px;background:#ef4444;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">Habis</div>
                                @elseif($product->stock < 5)
                                    <div style="position:absolute;top:10px;right:10px;background:#f59e0b;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">Sisa {{ $product->stock }}</div>
                                @endif

                                @if($product->is_on_sale)
                                    <div style="position:absolute;bottom:10px;left:10px;background:#dc2626;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">-{{ $product->discount_percent }}%</div>
                                @endif
                            </div>
                        </a>

                        <div class="card-body d-flex flex-column">
                            <span class="badge-cat mb-1">{{ $product->category?->name }}</span>
                            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                                <h6 class="product-name">{{ $product->name }}</h6>
                            </a>
                            <p class="text-muted small mb-3" style="font-size:.82rem;line-height:1.5;">
                                {{ Str::limit($product->description, 60) }}
                            </p>

                            <div class="mt-auto">
                                @if($product->is_on_sale)
                                    <div class="product-price">{{ $product->formatted_discounted_price }}</div>
                                    <div style="text-decoration:line-through;color:#9ca3af;font-size:.82rem;line-height:1;">{{ $product->formatted_price }}</div>
                                @else
                                    <span class="product-price">{{ $product->formatted_price }}</span>
                                @endif

                                @auth
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary-custom w-100 btn-sm mt-3" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-eye me-1"></i>
                                        {{ $product->stock == 0 ? 'Stok Habis' : 'Lihat Detail' }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-green w-100 btn-sm mt-3">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>Login untuk Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── PRODUK UNGGULAN ──────────────────────────────────── --}}
@if($featured->isNotEmpty())
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-heading mb-0">
                <i class="bi bi-star-fill me-2" style="color:#fbbf24;"></i>Produk Unggulan
            </h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-green btn-sm">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featured as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card card-product h-100">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <div class="card-img-wrap" style="position:relative;">
                            @if($product->image)
                                <img src="{{ $product->image_url }}"
                                     alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="bi bi-droplet"></i>
                                </div>
                            @endif
                            <div style="position:absolute;top:10px;left:10px;background:#fbbf24;color:#000;font-size:.78rem;font-weight:700;padding:6px 12px;border-radius:20px;z-index:2;">
                                ⭐ Unggulan
                            </div>
                            @if($product->stock == 0)
                            <div style="position:absolute;top:10px;right:10px;background:#ef4444;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">
                                Habis
                            </div>
                            @elseif($product->stock < 5)
                            <div style="position:absolute;top:10px;right:10px;background:#f59e0b;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">
                                Sisa {{ $product->stock }}
                            </div>
                            @endif
                            @if($product->is_on_sale)
                            <div style="position:absolute;bottom:10px;left:10px;background:#dc2626;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">
                                -{{ $product->discount_percent }}%
                            </div>
                            @endif
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <span class="badge-cat mb-1">{{ $product->category->name }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                            <h6 class="product-name">{{ $product->name }}</h6>
                        </a>
                        @if($product->variants->isNotEmpty())
                        <div class="small text-muted mb-2">
                            <i class="bi bi-droplet-half me-1"></i>
                            {{ $product->variants->count() }} varian tersedia
                        </div>
                        @endif
                        <p class="text-muted small mb-3" style="font-size:.82rem;line-height:1.5;">
                            {{ Str::limit($product->description, 60) }}
                        </p>
                        <div class="mt-auto">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    @if($product->is_on_sale)
                                        <div class="product-price">{{ $product->formatted_discounted_price }}</div>
                                        <div style="text-decoration:line-through;color:#9ca3af;font-size:.82rem;line-height:1;">{{ $product->formatted_price }}</div>
                                    @else
                                        <span class="product-price">{{ $product->formatted_price }}</span>
                                    @endif
                                </div>
                            </div>
                            @auth
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary-custom w-100 btn-sm"
                                   {{ $product->stock == 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-eye me-1"></i>
                                    {{ $product->stock == 0 ? 'Stok Habis' : 'Lihat Detail' }}
                                </a>
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
    </div>
</section>
@endif

{{-- ── PRODUK ──────────────────────────────────────────── --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-heading mb-0">
                @if(request('search'))
                    Hasil Pencarian: "{{ request('search') }}"
                @else
                    Koleksi Terbaru
                @endif
            </h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-green btn-sm">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5">
                <div style="font-size:4rem;opacity:.3">🔍</div>
                <h5 class="mt-3 text-muted">Produk tidak ditemukan</h5>
                <p class="text-muted small">Coba kata kunci lain atau lihat semua koleksi kami</p>
                <a href="{{ route('home') }}" class="btn btn-primary-custom mt-2">Lihat Semua Produk</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card card-product h-100">
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
                                @if($product->stock == 0)
                                <div style="position:absolute;top:10px;right:10px;background:#ef4444;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">
                                    Habis
                                </div>
                                @elseif($product->stock < 5)
                                <div style="position:absolute;top:10px;right:10px;background:#f59e0b;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">
                                    Sisa {{ $product->stock }}
                                </div>
                                @endif
                                @if($product->is_on_sale)
                                <div style="position:absolute;top:10px;left:10px;background:#dc2626;color:#fff;font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:20px;z-index:2;">
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
                            <p class="text-muted small mb-3" style="font-size:.82rem;line-height:1.5;">
                                {{ Str::limit($product->description, 60) }}
                            </p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        @if($product->is_on_sale)
                                            <div class="product-price">{{ $product->formatted_discounted_price }}</div>
                                            <div style="text-decoration:line-through;color:#9ca3af;font-size:.82rem;line-height:1;">{{ $product->formatted_price }}</div>
                                        @else
                                            <span class="product-price">{{ $product->formatted_price }}</span>
                                        @endif
                                    </div>
                                    <span class="small text-muted">
                                        <i class="bi bi-box me-1"></i>{{ $product->stock }} pcs
                                    </span>
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
                    dari <strong style="color:#374151;">{{ $products->total() }}</strong> produk
                </div>
                {{ $products->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</section>

{{-- ── KEUNGGULAN ──────────────────────────────────────── --}}
<section class="py-5" style="background:white;">
    <div class="container">
        <h2 class="section-heading text-center mb-2" style="text-align:center !important;">
            Mengapa Memilih FragrancesHub?
        </h2>
        <p class="text-center text-muted mb-5">Kami berkomitmen memberikan pengalaman belanja terbaik</p>
        <div class="row g-4 text-center">
            @foreach([
                ['bi-shield-check','Produk Original','100% produk asli bergaransi keaslian dari distributor resmi.'],
                ['bi-truck','Pengiriman Cepat','Pengiriman ke seluruh Indonesia dengan packaging aman dan rapi.'],
                ['bi-headset','CS 24/7','Tim customer service siap membantu Anda kapan saja.'],
                ['bi-arrow-counterclockwise','Retur Mudah','Garansi retur 7 hari jika produk bermasalah atau tidak sesuai.'],
            ] as [$icon, $title, $desc])
            <div class="col-md-3 col-6">
                <div class="p-4 rounded-3 h-100" style="background:var(--gray-light);transition:all .3s" 
                     onmouseover="this.style.background='#d1fae5'" onmouseout="this.style.background='var(--gray-light)'">
                    <div class="mb-3" style="font-size:2.2rem;color:var(--green-mid)">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <h6 class="fw-700 mb-2" style="font-family:'Playfair Display',serif;">{{ $title }}</h6>
                    <p class="text-muted small mb-0">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
