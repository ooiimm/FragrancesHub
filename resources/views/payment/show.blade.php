@extends('layouts.app')
@section('title', 'Instruksi Pembayaran - FragrancesHub')

@section('content')
<div class="container py-5" style="max-width:700px;">
    <h2 class="section-heading mb-4">Instruksi Pembayaran</h2>

    {{-- Info Order --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="row">
            <div class="col-6">
                <div class="small text-muted">No. Pesanan</div>
                <div class="fw-700" style="color:var(--green-dark);font-size:1.1rem;">{{ $order->order_number }}</div>
            </div>
            <div class="col-6 text-end">
                <div class="small text-muted">Total Pembayaran</div>
                <div class="fw-700 fs-5" style="color:var(--green-mid);">{{ $order->formatted_total }}</div>
            </div>
        </div>
        <hr class="my-3">
        <div class="small">
            <div class="text-muted mb-1">Metode: <strong>{{ $order->payment_method_label }}</strong></div>
            <div class="text-muted">Status: 
                <span class="badge" style="background:{{ $order->payment->status_color === 'success' ? '#10b981' : ($order->payment->status_color === 'danger' ? '#ef4444' : '#f59e0b') }};color:#fff;">
                    {{ $order->payment->status_label }}
                </span>
            </div>
        </div>
    </div>

    {{-- Payment Instructions --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div style="font-size:3rem;text-align:center;margin-bottom:1rem;">{{ $paymentInstructions['icon'] }}</div>
        <h4 class="text-center mb-4" style="color:var(--green-dark);">{{ $paymentInstructions['title'] }}</h4>
        
        <div class="payment-steps">
            @foreach($paymentInstructions['steps'] as $index => $step)
                <div class="step-item mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="d-flex gap-3">
                        <div class="step-number" style="
                            width:32px;
                            height:32px;
                            border-radius:50%;
                            background:var(--green-mid);
                            color:#fff;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-weight:700;
                            flex-shrink:0;
                        ">{{ $index + 1 }}</div>
                        <div class="step-content" style="flex-grow:1;padding-top:2px;">
                            {{ $step }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($dummyQr)
    {{-- Dummy QR Payment --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <h6 class="mb-1" style="color:var(--green-dark);font-family:'Playfair Display',serif;">
                    <i class="bi bi-qr-code me-2"></i>QR Pembayaran Dummy
                </h6>
                <div class="small text-muted">Gunakan QR ini untuk melakukan pembayaran.</div>
            </div>
        </div>

        <div class="qr-payment-wrap">
            <div class="dummy-qr" role="img" aria-label="QR pembayaran {{ $dummyQr['reference'] }}">
                @foreach($dummyQr['matrix'] as $row)
                    @foreach($row as $cell)
                        <span class="{{ $cell ? 'is-dark' : '' }}"></span>
                    @endforeach
                @endforeach
            </div>

            <div class="qr-payment-info">
                <div class="small text-muted">Merchant</div>
                <div class="fw-700 mb-2" style="color:var(--green-dark);">{{ $dummyQr['merchant'] }}</div>

                <div class="small text-muted">Metode</div>
                <div class="fw-600 mb-2">{{ $dummyQr['method'] }}</div>

                <div class="small text-muted">Nominal</div>
                <div class="fw-700 mb-2" style="color:var(--green-mid);">{{ $dummyQr['amount'] }}</div>

                <div class="small text-muted">Referensi</div>
                <div class="fw-600" style="word-break:break-word;">{{ $dummyQr['reference'] }}</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Upload Bukti (untuk non-COD) --}}
    @if(in_array($order->payment_method, ['bank_transfer', 'ovo', 'gopay', 'dana']))
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <h6 class="mb-3" style="color:var(--green-dark);font-family:'Playfair Display',serif;">
            <i class="bi bi-cloud-upload me-2"></i>Upload Bukti Pembayaran
        </h6>

        @if($order->payment && $order->payment->proof_image)
            <div class="alert alert-info mb-3">
                <i class="bi bi-check-circle me-2"></i>Bukti pembayaran sudah diunggah.
                Status: <strong>{{ $order->payment->status_label }}</strong>
            </div>
            <img src="{{ $order->payment->proof_url }}" class="img-fluid rounded-3 mb-3" style="max-height:300px;">
        @endif

        <form action="{{ route('payment.upload', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih Gambar Bukti Pembayaran <span class="text-danger">*</span></label>
                <input type="file" name="proof_image" id="proofInput"
                       class="form-control @error('proof_image') is-invalid @enderror"
                       accept="image/jpg,image/jpeg,image/png">
                <div class="form-text">Format: JPG, JPEG, PNG. Maks 2MB.</div>
                @error('proof_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Preview --}}
            <div id="previewWrap" class="mb-3 d-none">
                <label class="form-label">Preview:</label>
                <img id="previewImg" class="img-fluid rounded-3" style="max-height:280px;border:2px solid #e5e7eb;">
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 py-3">
                <i class="bi bi-cloud-upload me-2"></i>Upload Bukti Pembayaran
            </button>
        </form>
    </div>
    @else
    {{-- COD Info --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="alert alert-success mb-0">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Pesanan akan dikirim segera!</strong> Pembayaran dilakukan saat barang tiba di tangan Anda.
        </div>
    </div>
    @endif

    {{-- Order Items Summary --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <h6 class="mb-3" style="color:var(--green-dark);">Detail Pesanan</h6>
        @foreach($order->orderItems as $item)
        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
            <div class="flex-grow-1">
                <div class="small fw-600">{{ $item->product_name }}
                    @if($item->variant_size)
                        <span style="color:#9ca3af;">({{ $item->variant_size }})</span>
                    @endif
                </div>
                <div class="small text-muted">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
            </div>
            <div class="small fw-700" style="color:var(--green-mid);white-space:nowrap;">
                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
            </div>
        </div>
        @endforeach
        <hr class="my-2">
        <div class="d-flex justify-content-between fw-700 fs-6">
            <span>Total</span>
            <span style="color:var(--green-mid);">{{ $order->formatted_total }}</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="row g-2">
        <div class="col-6">
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-green w-100">
                <i class="bi bi-arrow-left me-1"></i>Lihat Pesanan
            </a>
        </div>
        <div class="col-6">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-house me-1"></i>Beranda
            </a>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .qr-payment-wrap {
        display: grid;
        grid-template-columns: minmax(160px, 220px) 1fr;
        gap: 20px;
        align-items: center;
    }

    .dummy-qr {
        display: grid;
        grid-template-columns: repeat(21, 1fr);
        width: min(100%, 220px);
        aspect-ratio: 1;
        padding: 12px;
        background: #fff;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 10px 24px rgba(11,61,46,0.08);
    }

    .dummy-qr span {
        aspect-ratio: 1;
        background: #fff;
    }

    .dummy-qr span.is-dark {
        background: #0B3D2E;
    }

    .qr-payment-info {
        padding: 14px 16px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    @media (max-width: 575.98px) {
        .qr-payment-wrap {
            grid-template-columns: 1fr;
        }

        .dummy-qr {
            margin: 0 auto;
        }
    }
</style>
<script>
    function previewImage(input) {
        const wrap = document.getElementById('previewWrap');
        const img  = document.getElementById('previewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    const proofInput = document.getElementById('proofInput');
    if (proofInput) {
        proofInput.addEventListener('change', function() {
            previewImage(this);
        });
    }
</script>
@endpush
@endsection
