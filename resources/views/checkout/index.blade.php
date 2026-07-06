@extends('layouts.app')
@section('title', 'Checkout - FragrancesHub')

@section('content')
<div class="container py-5">
    <h2 class="section-heading mb-4">Checkout</h2>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- Form Pengiriman --}}
            <div class="col-lg-7">
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <h5 class="mb-4" style="font-family:'Playfair Display',serif;color:var(--green-dark);">
                        <i class="bi bi-geo-alt me-2"></i>Informasi Pengiriman
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               placeholder="Contoh: 08123456789"
                               value="{{ old('phone', auth()->user()->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman Lengkap <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" rows="4"
                                  class="form-control @error('shipping_address') is-invalid @enderror"
                                  placeholder="Masukkan alamat lengkap termasuk kota dan kode pos">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="form-control"
                                  placeholder="Catatan untuk penjual...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- Info Pembayaran --}}
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <h5 class="mb-4" style="font-family:'Playfair Display',serif;color:var(--green-dark);">
                        <i class="bi bi-wallet2 me-2"></i>Pilih Metode Pembayaran
                    </h5>

                    @error('payment_method')
                        <div class="alert alert-danger mb-3">{{ $message }}</div>
                    @enderror

                    <div class="row g-2" id="paymentMethods">
                        <!-- Bank Transfer -->
                        <div class="col-6 col-md-12">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer" class="d-none" 
                                       {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}
                                       onchange="updatePaymentDisplay()">
                                <div class="payment-option-content">
                                    <div class="payment-icon" style="background:#fff3cd;color:#856404;">
                                        <i class="bi bi-bank"></i>
                                    </div>
                                    <div class="payment-text">
                                        <div class="payment-title">Transfer Bank</div>
                                        <div class="payment-desc">BCA, Mandiri, BNI, dll</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- OVO -->
                        <div class="col-6 col-md-12">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="ovo" class="d-none"
                                       {{ old('payment_method') == 'ovo' ? 'checked' : '' }}
                                       onchange="updatePaymentDisplay()">
                                <div class="payment-option-content">
                                    <div class="payment-icon" style="background:#e8f4f8;color:#0066cc;">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div class="payment-text">
                                        <div class="payment-title">OVO</div>
                                        <div class="payment-desc">E-Wallet</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- GoPay -->
                        <div class="col-6 col-md-12">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="gopay" class="d-none"
                                       {{ old('payment_method') == 'gopay' ? 'checked' : '' }}
                                       onchange="updatePaymentDisplay()">
                                <div class="payment-option-content">
                                    <div class="payment-icon" style="background:#e8f8e8;color:#00aa44;">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div class="payment-text">
                                        <div class="payment-title">GoPay</div>
                                        <div class="payment-desc">E-Wallet</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Dana -->
                        <div class="col-6 col-md-12">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="dana" class="d-none"
                                       {{ old('payment_method') == 'dana' ? 'checked' : '' }}
                                       onchange="updatePaymentDisplay()">
                                <div class="payment-option-content">
                                    <div class="payment-icon" style="background:#f0e8ff;color:#7c3aed;">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div class="payment-text">
                                        <div class="payment-title">Dana</div>
                                        <div class="payment-desc">E-Wallet</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- COD -->
                        <div class="col-6 col-md-12">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod" class="d-none"
                                       {{ old('payment_method') == 'cod' ? 'checked' : '' }}
                                       onchange="updatePaymentDisplay()">
                                <div class="payment-option-content">
                                    <div class="payment-icon" style="background:#f0fdf4;color:#16a34a;">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                    <div class="payment-text">
                                        <div class="payment-title">COD</div>
                                        <div class="payment-desc">Bayar di tempat</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- E-Wallet Phone Number Input -->
                    <div id="ewalletPhoneDiv" class="mt-4" style="display:none;">
                        <label class="form-label">Nomor Telepon E-Wallet <span class="text-danger">*</span></label>
                        <input type="text" name="ewallet_phone" id="ewalletPhoneInput"
                               class="form-control @error('ewallet_phone') is-invalid @enderror"
                               placeholder="Contoh: 08123456789 (nomor yang terdaftar di aplikasi)"
                               value="{{ old('ewallet_phone') }}">
                        @error('ewallet_phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Gunakan nomor telepon yang terdaftar di aplikasi OVO/GoPay/Dana Anda untuk menerima instruksi pembayaran.
                        </small>
                    </div>

                    <!-- Payment Info Display -->
                    <div id="paymentInfo" class="p-3 rounded-3 mt-4" style="background:#f0fdf4;border:1.5px solid #bbf7d0;display:none;">
                        <div id="infoContent"></div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-5">
                <div class="bg-white rounded-4 shadow-sm p-4 sticky-top" style="top:90px;">
                    <h5 class="mb-4" style="font-family:'Playfair Display',serif;color:var(--green-dark);">
                        Ringkasan Pesanan
                    </h5>
                    @foreach($cartItems as $item)
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-2 overflow-hidden me-3 flex-shrink-0"
                             style="width:55px;height:55px;background:var(--gray-light);">
                            @if($item->product->image)
                                <img src="{{ $item->product->image_url }}"
                                     style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <div class="no-image-placeholder" style="height:100%;font-size:1.5rem;">
                                    <i class="bi bi-droplet"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="small fw-600">{{ $item->product->name }}
                                @if($item->variant_size)
                                    <span style="color:#9ca3af;">({{ $item->variant_size }})</span>
                                @endif
                            </div>
                            <div class="small text-muted">
                                {{ $item->quantity }}x
                                @php
                                    $itemPrice = $item->product_variant_id ? $item->variant->price : $item->product->discounted_price;
                                    $formattedPrice = 'Rp ' . number_format($itemPrice, 0, ',', '.');
                                @endphp
                                <span style="font-weight:600;color:#14532d;">{{ $formattedPrice }}</span>
                            </div>
                        </div>
                        <div class="small fw-700" style="color:var(--green-mid);">
                            Rp {{ number_format($item->quantity * $itemPrice, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between fw-700 fs-5 mb-4"
                         style="color:var(--green-dark);">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="btn btn-gold w-100 py-3 fs-6">
                        <i class="bi bi-bag-check me-2"></i>Buat Pesanan
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-green w-100 mt-2">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<style>
    .payment-option {
        cursor: pointer;
        display: block;
        margin-bottom: 0;
    }

    .payment-option input:checked + .payment-option-content {
        background: linear-gradient(135deg, #14532d 0%, #1a6b3a 100%);
        border-color: var(--green-mid) !important;
        color: white;
    }

    .payment-option-content {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        transition: all 0.3s;
        background: #fff;
    }

    .payment-option:hover .payment-option-content {
        border-color: var(--green-mid);
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .payment-option input:checked + .payment-option-content .payment-icon {
        background: rgba(255,255,255,0.2) !important;
        color: white !important;
    }

    .payment-text {
        flex-grow: 1;
    }

    .payment-title {
        font-weight: 600;
        font-size: 0.95rem;
    }

    .payment-desc {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    .payment-option input:checked + .payment-option-content .payment-title,
    .payment-option input:checked + .payment-option-content .payment-desc {
        color: white;
    }
</style>

<script>
function updatePaymentDisplay() {
    const selected = document.querySelector('input[name="payment_method"]:checked');
    const infoDiv = document.getElementById('paymentInfo');
    const infoContent = document.getElementById('infoContent');
    const ewalletPhoneDiv = document.getElementById('ewalletPhoneDiv');
    const ewalletPhoneInput = document.getElementById('ewalletPhoneInput');
    
    // Show/hide e-wallet phone input
    if (selected && ['ovo', 'gopay', 'dana'].includes(selected.value)) {
        ewalletPhoneDiv.style.display = 'block';
        ewalletPhoneInput.required = true;
    } else {
        ewalletPhoneDiv.style.display = 'none';
        ewalletPhoneInput.required = false;
    }
    
    if (!selected) {
        infoDiv.style.display = 'none';
        return;
    }
    
    infoDiv.style.display = 'block';
    
    const method = selected.value;
    const total = '{{ number_format($total, 0, ",", ".") }}';
    
    const messages = {
        'bank_transfer': `
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                <strong>Transfer Bank</strong>
            </div>
            <div class="small ms-4">
                <p class="mb-2">Silakan transfer ke rekening berikut setelah membuat pesanan:</p>
                <table class="table table-sm table-borderless mb-2">
                    <tr><td class="text-muted" style="width:120px;">Bank</td><td><strong>BCA</strong></td></tr>
                    <tr><td class="text-muted">No. Rekening</td><td><strong>6801397384</strong></td></tr>
                    <tr><td class="text-muted">Atas Nama</td><td><strong>FragrancesHub Store</strong></td></tr>
                    <tr><td class="text-muted">Nominal</td><td><strong>Rp ${total}</strong></td></tr>
                </table>
                <p class="mb-0 text-muted"><i class="bi bi-info-circle me-1"></i>Setelah transfer, upload bukti di halaman pesanan Anda.</p>
            </div>
        `,
        'ovo': `
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                <strong>OVO</strong>
            </div>
            <div class="small ms-4">
                <p class="mb-2">Nominal pembayaran: <strong>Rp ${total}</strong></p>
                <p class="mb-2">Kirim pembayaran ke merchant FragrancesHub Store di aplikasi OVO Anda.</p>
                <p class="mb-0 text-muted"><i class="bi bi-info-circle me-1"></i>Setelah pembayaran selesai, upload bukti di halaman pesanan.</p>
            </div>
        `,
        'gopay': `
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                <strong>GoPay</strong>
            </div>
            <div class="small ms-4">
                <p class="mb-2">Nominal pembayaran: <strong>Rp ${total}</strong></p>
                <p class="mb-2">Kirim pembayaran ke merchant FragrancesHub Store di aplikasi GoPay Anda.</p>
                <p class="mb-0 text-muted"><i class="bi bi-info-circle me-1"></i>Setelah pembayaran selesai, upload bukti di halaman pesanan.</p>
            </div>
        `,
        'dana': `
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                <strong>Dana</strong>
            </div>
            <div class="small ms-4">
                <p class="mb-2">Nominal pembayaran: <strong>Rp ${total}</strong></p>
                <p class="mb-2">Kirim pembayaran ke merchant FragrancesHub Store di aplikasi Dana Anda.</p>
                <p class="mb-0 text-muted"><i class="bi bi-info-circle me-1"></i>Setelah pembayaran selesai, upload bukti di halaman pesanan.</p>
            </div>
        `,
        'cod': `
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                <strong>Cash On Delivery (COD)</strong>
            </div>
            <div class="small ms-4">
                <p class="mb-2">Nominal pembayaran: <strong>Rp ${total}</strong></p>
                <p class="mb-2">Pembayaran dilakukan saat paket barang tiba di alamat Anda.</p>
                <p class="mb-0 text-muted"><i class="bi bi-info-circle me-1"></i>Pastikan siap dengan uang cash pada saat kurir tiba.</p>
            </div>
        `
    };
    
    infoContent.innerHTML = messages[method] || '';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePaymentDisplay();
});
</script>
@endpush
