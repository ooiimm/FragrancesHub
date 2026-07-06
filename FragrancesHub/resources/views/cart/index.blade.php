@extends('layouts.app')
@section('title', 'Keranjang Belanja - FragrancesHub')

@section('content')
<div class="container py-5">
    <h2 class="section-heading mb-4">
        <i class="bi bi-bag me-2" style="font-size:1.4rem;"></i>Keranjang Belanja
    </h2>

    @if($cartItems->isEmpty())
    {{-- Keranjang Kosong --}}
    <div class="text-center py-5">
        <div style="font-size:6rem;opacity:.12;color:var(--green-mid);">
            <i class="bi bi-bag-x"></i>
        </div>
        <h5 class="mt-3 fw-600 text-muted">Keranjang masih kosong</h5>
        <p class="text-muted small">Yuk, mulai belanja parfum favorit kamu!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary-custom mt-2 px-4">
            <i class="bi bi-grid me-2"></i>Mulai Belanja
        </a>
    </div>

    @else
    <div class="row g-4">

        {{-- Kolom Kiri: List Item --}}
        <div class="col-lg-8">
            <div class="bg-white rounded-4 shadow-sm overflow-hidden">

                <div class="px-4 py-3" style="background:#f9f7f4;border-bottom:1px solid #e5e7eb;">
                    <span class="fw-600 small" style="color:var(--green-dark);">
                        {{ $cartItems->count() }} item di keranjang
                    </span>
                </div>

                @foreach($cartItems as $item)
                <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="d-flex align-items-start gap-3">

                        {{-- Foto Produk --}}
                        <a href="{{ route('products.show', $item->product->slug) }}" class="flex-shrink-0">
                            <div class="rounded-3 overflow-hidden"
                                 style="width:85px;height:85px;background:#f3f4f6;">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         alt="{{ $item->product->name }}"
                                         style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div style="width:100%;height:100%;
                                                background:linear-gradient(135deg,#e8f5e9,#c8e6c9);
                                                display:flex;align-items:center;justify-content:center;
                                                color:#14532d;font-size:2rem;">
                                        <i class="bi bi-droplet"></i>
                                    </div>
                                @endif
                            </div>
                        </a>

                        {{-- Info --}}
                        <div class="flex-grow-1">
                            <a href="{{ route('products.show', $item->product->slug) }}"
                               class="text-decoration-none">
                                <h6 class="mb-1 fw-700"
                                    style="font-family:'Playfair Display',serif;color:#0B3D2E;">
                                    {{ $item->product->name }}
                                </h6>
                            </a>
                            <div class="text-muted small mb-1">{{ $item->product->category->name }}</div>
                            <div class="fw-700" style="color:var(--green-mid);">
                                @if($item->product->is_on_sale)
                                    <span style="font-weight:700;color:#14532d;">{{ $item->product->formatted_discounted_price }}</span>
                                    <span style="text-decoration:line-through;color:#9ca3af;font-size:.8rem;margin-left:4px;">{{ $item->product->formatted_price }}</span>
                                    <span style="background:#dc2626;color:#fff;font-size:.65rem;font-weight:700;padding:1px 6px;border-radius:20px;margin-left:2px;">-{{ $item->product->discount_percent }}%</span>
                                @else
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                @endif
                            </div>
                            <div class="text-muted" style="font-size:.75rem;">
                                Stok: {{ $item->product->stock }} pcs
                            </div>
                        </div>

                        {{-- Kontrol qty + hapus --}}
                        <div class="d-flex flex-column align-items-end gap-2">

                            {{-- Form Update Qty --}}
                            <form action="{{ route('cart.update', $item->id) }}"
                                  method="POST" class="d-flex align-items-center gap-1">
                                @csrf

                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm px-2 py-1"
                                        onclick="changeQty({{ $item->id }}, -1, {{ $item->product->stock }})">
                                    <i class="bi bi-dash"></i>
                                </button>

                                <input type="number"
                                       id="qty-{{ $item->id }}"
                                       name="quantity"
                                       value="{{ $item->quantity }}"
                                       min="1"
                                       max="{{ $item->product->stock }}"
                                       class="form-control form-control-sm text-center px-1"
                                       style="width:52px;border-radius:8px;"
                                       onchange="this.form.submit()">

                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm px-2 py-1"
                                        onclick="changeQty({{ $item->id }}, 1, {{ $item->product->stock }})">
                                    <i class="bi bi-plus"></i>
                                </button>

                                {{-- Tombol centang simpan --}}
                                <button type="submit"
                                        class="btn btn-sm px-2 py-1"
                                        style="background:#14532d;color:#fff;border:none;border-radius:8px;"
                                        title="Simpan perubahan">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>

                            {{-- Subtotal --}}
                            <div class="fw-700" style="color:var(--green-dark);font-size:1rem;">
                                Rp {{ number_format($item->quantity * $item->product->discounted_price, 0, ',', '.') }}
                            </div>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm px-3 py-1"
                                        style="border:1.5px solid #ef4444;color:#ef4444;
                                               background:transparent;border-radius:8px;
                                               font-size:.82rem;font-weight:600;"
                                        onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                                        onmouseout="this.style.background='transparent';this.style.color='#ef4444'"
                                        onclick="return confirm('Hapus \'{{ addslashes($item->product->name) }}\' dari keranjang?')">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            {{-- Tombol Lanjut Belanja di bawah list --}}
            <div class="mt-3">
                <a href="{{ url('/products') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                </a>
            </div>
        </div>

        {{-- Kolom Kanan: Ringkasan --}}
        <div class="col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4 sticky-top" style="top:90px;">
                <h5 class="mb-4 fw-700" style="font-family:'Playfair Display',serif;color:var(--green-dark);">
                    Ringkasan Pesanan
                </h5>

                @foreach($cartItems as $item)
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">
                        {{ Str::limit($item->product->name, 25) }}
                        <span class="fw-600"> ×{{ $item->quantity }}</span>
                    </span>
                    <span class="fw-600">
                        Rp {{ number_format($item->quantity * $item->product->discounted_price, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach

                <hr class="my-3">

                <div class="d-flex justify-content-between mb-1 small text-muted">
                    <span>Subtotal ({{ $cartItems->count() }} produk)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 small text-muted">
                    <span>Ongkos Kirim</span>
                    <span class="fst-italic">Dihitung saat checkout</span>
                </div>

                <hr class="my-3">

                <div class="d-flex justify-content-between fw-700 mb-4"
                     style="color:var(--green-dark);font-size:1.1rem;">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                {{-- Tombol Checkout --}}
                <a href="{{ url('/checkout') }}"
                   class="btn btn-gold w-100 py-3 fw-700 mb-2"
                   style="font-size:1rem;border-radius:10px;">
                    <i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout
                </a>

                {{-- Tombol Lanjut Belanja di ringkasan --}}
                <a href="{{ url('/products') }}"
                   class="btn w-100 py-2 fw-600"
                   style="border:1.5px solid #14532d;color:#14532d;border-radius:10px;
                          background:transparent;font-size:.9rem;">
                    <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                </a>

            </div>
        </div>

    </div>
    @endif
</div>

@push('scripts')
<script>
function changeQty(itemId, delta, maxStock) {
    const input = document.getElementById('qty-' + itemId);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > maxStock) {
        alert('Maksimal stok tersedia: ' + maxStock + ' pcs.');
        val = maxStock;
    }
    input.value = val;
}
</script>
@endpush

@endsection
