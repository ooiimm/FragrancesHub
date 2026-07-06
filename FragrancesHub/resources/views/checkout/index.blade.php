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
                    <h5 class="mb-3" style="font-family:'Playfair Display',serif;color:var(--green-dark);">
                        <i class="bi bi-bank me-2"></i>Metode Pembayaran
                    </h5>

                    {{-- Tab Metode --}}
                    <ul class="nav nav-pills mb-3 gap-2" id="paymentTab">
                        <li class="nav-item">
                            <button type="button" id="btn-transfer" onclick="switchTab('transfer')"
                                    class="nav-link active px-3 py-2"
                                    style="font-size:.85rem;border-radius:8px;background:#14532d;color:#fff;">
                                <i class="bi bi-bank me-1"></i>Transfer Bank
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" id="btn-qris" onclick="switchTab('qris')"
                                    class="nav-link px-3 py-2"
                                    style="font-size:.85rem;border-radius:8px;">
                                <i class="bi bi-qr-code me-1"></i>QRIS
                            </button>
                        </li>
                    </ul>

                    {{-- Transfer Bank --}}
                    <div id="tab-transfer" class="p-3 rounded-3" style="background:#f0fdf4;border:1.5px solid #bbf7d0;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                            <strong>Transfer Bank Manual</strong>
                        </div>
                        <div class="ms-4 small">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted" style="width:130px;">Bank</td><td><strong>BCA</strong></td></tr>
                                <tr><td class="text-muted">No. Rekening</td><td>
                                    <strong id="norek">6801397384</strong>
                                    <button type="button" onclick="copyRek()"
                                            style="background:#e6f4ea;color:#14532d;border:none;font-size:.7rem;padding:2px 8px;border-radius:6px;cursor:pointer;margin-left:6px;">
                                        <i class="bi bi-copy me-1"></i>Salin
                                    </button>
                                </td></tr>
                                <tr><td class="text-muted">Atas Nama</td><td><strong>FragrancesHub Store</strong></td></tr>
                            </table>
                        </div>
                        <p class="text-muted small mb-0 mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Setelah order dibuat, upload bukti transfer di halaman pesanan.
                        </p>
                    </div>

                    {{-- QRIS --}}
                    <div id="tab-qris" class="p-3 rounded-3 text-center" style="background:#f0f4ff;border:1.5px solid #c7d2fe;display:none;">
                        <div class="d-flex align-items-center justify-content-center mb-3 gap-2">
                            <i class="bi bi-qr-code-scan fs-5" style="color:#4f46e5;"></i>
                            <strong style="color:#3730a3;">Bayar via QRIS</strong>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
                            <div style="background:#fff;padding:14px;border-radius:14px;box-shadow:0 2px 16px rgba(0,0,0,0.1);display:inline-block;">
                                <div id="qrcode-div"></div>
                            </div>
                        </div>
                        <div class="small text-muted mb-1">
                            <i class="bi bi-phone me-1"></i>Scan dengan <strong>GoPay, OVO, DANA, ShopeePay</strong> atau m-banking
                        </div>
                        <div class="small fw-600 mt-1" style="color:#4f46e5;">
                            Total: Rp {{ number_format($total, 0, ',', '.') }}
                        </div>
                        <p class="text-muted small mb-0 mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Screenshot bukti bayar, upload di halaman pesanan.
                        </p>
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
                                <img src="{{ asset('storage/'.$item->product->image) }}"
                                     style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <div class="no-image-placeholder" style="height:100%;font-size:1.5rem;">
                                    <i class="bi bi-droplet"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="small fw-600">{{ $item->product->name }}</div>
                            <div class="small text-muted">
                                {{ $item->quantity }}x
                                @if($item->product->is_on_sale)
                                    <span style="font-weight:600;color:#14532d;">{{ $item->product->formatted_discounted_price }}</span>
                                    <span style="text-decoration:line-through;color:#9ca3af;font-size:.78rem;margin-left:3px;">{{ $item->product->formatted_price }}</span>
                                    <span style="background:#dc2626;color:#fff;font-size:.62rem;font-weight:700;padding:1px 5px;border-radius:20px;margin-left:2px;">-{{ $item->product->discount_percent }}%</span>
                                @else
                                    {{ $item->product->formatted_price }}
                                @endif
                            </div>
                        </div>
                        <div class="small fw-700" style="color:var(--green-mid);">
                            Rp {{ number_format($item->quantity * $item->product->discounted_price, 0, ',', '.') }}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
var qrGenerated = false;

function switchTab(tab) {
    document.getElementById('tab-transfer').style.display = tab === 'transfer' ? 'block' : 'none';
    document.getElementById('tab-qris').style.display     = tab === 'qris'     ? 'block' : 'none';

    ['transfer', 'qris'].forEach(function(t) {
        var btn = document.getElementById('btn-' + t);
        if (t === tab) {
            btn.style.background = '#14532d';
            btn.style.color = '#fff';
            btn.classList.add('active');
        } else {
            btn.style.background = '';
            btn.style.color = '';
            btn.classList.remove('active');
        }
    });

    if (tab === 'qris' && !qrGenerated) {
        // Ganti string ini dengan QRIS resmi dari bank/penyedia Anda
        var qrisData = "00020101021226590014ID.CO.BCA.WWW011893600503000000000002021520040000005802ID5916FragrancesHub6007Jakarta6105123456304ABCD";
        document.getElementById('qrcode-div').innerHTML = '';
        new QRCode(document.getElementById('qrcode-div'), {
            text:         qrisData,
            width:        190,
            height:       190,
            colorDark:    "#000000",
            colorLight:   "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
        });
        qrGenerated = true;
    }
}

function copyRek() {
    var norek = document.getElementById('norek').innerText;
    navigator.clipboard.writeText(norek).then(function() {
        var btn = document.querySelector('[onclick="copyRek()"]');
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-1"></i>Tersalin!';
        setTimeout(function() { btn.innerHTML = original; }, 2000);
    });
}
</script>
@endpush
