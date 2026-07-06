<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card card-product h-100">
        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
            <div class="card-img-wrap" style="position:relative;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}" loading="lazy"
                         style="{{ $product->stock == 0 ? 'filter: grayscale(0.65) brightness(0.55) contrast(0.9);' : '' }}">
                @else
                    <div class="no-image-placeholder" style="{{ $product->stock == 0 ? 'filter: grayscale(0.65) brightness(0.55) contrast(0.9);' : '' }}">
                        <i class="bi bi-droplet"></i>
                    </div>
                @endif
                @if($product->stock == 0)
                    <div style="position:absolute;inset:0;background:rgba(0,0,0,0.28);pointer-events:none;"></div>
                    <div style="position:absolute;top:10px;right:10px;background:#ef4444;color:#fff;font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:20px;">
                        Habis
                    </div>
                @elseif($product->stock < 5)
                    <div style="position:absolute;top:10px;right:10px;background:#f59e0b;color:#fff;font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:20px;">
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

                <a href="{{ route('products.show', $product->slug) }}"
                   class="btn w-100 btn-sm"
                   style="border:1.5px solid #14532d;color:#14532d;border-radius:8px;font-weight:600;background:transparent;">
                    <i class="bi bi-eye me-1"></i>Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div>
