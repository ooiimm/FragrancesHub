@extends('layouts.app')
@section('title', 'Upload Bukti Pembayaran - FragrancesHub')

@section('content')
<div class="container py-5" style="max-width:680px;">
    <h2 class="section-heading mb-4">Upload Bukti Pembayaran</h2>

    {{-- Info Order --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <div class="small text-muted">No. Pesanan</div>
                <div class="fw-700" style="color:var(--green-dark);">{{ $order->order_number }}</div>
            </div>
            <div class="text-end">
                <div class="small text-muted">Total</div>
                <div class="fw-700 fs-5" style="color:var(--green-mid);">{{ $order->formatted_total }}</div>
            </div>
        </div>
    </div>
    </div>

    {{-- Upload Form --}}
    <div class="bg-white rounded-4 shadow-sm p-4">
        <h6 class="mb-3" style="color:var(--green-dark);font-family:'Playfair Display',serif;">
            Upload Bukti Transfer
        </h6>
        @if($order->payment && $order->payment->proof_image)
            <div class="mb-3">
                <div class="alert alert-info">
                    <i class="bi bi-check-circle me-2"></i>Bukti transfer sudah diupload.
                    Status: <strong>{{ $order->payment->status_label }}</strong>
                </div>
                <img src="{{ $order->payment->proof_url }}" class="img-fluid rounded-3" style="max-height:300px;">
            </div>
        @endif

        <form action="{{ route('payment.upload', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih Gambar Bukti Transfer <span class="text-danger">*</span></label>
                <input type="file" name="proof_image" id="proofInput"
                       class="form-control @error('proof_image') is-invalid @enderror"
                       accept="image/jpg,image/jpeg,image/png"
                       onchange="previewImage(this)">
                <div class="form-text">Format: JPG, JPEG, PNG. Maks 2MB.</div>
                @error('proof_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Preview Gambar --}}
            <div id="previewWrap" class="mb-3 d-none">
                <label class="form-label">Preview:</label>
                <img id="previewImg" class="img-fluid rounded-3" style="max-height:280px;border:2px solid #e5e7eb;">
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 py-3">
                <i class="bi bi-cloud-upload me-2"></i>Upload Bukti Pembayaran
            </button>
        </form>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('orders.index') }}" class="text-decoration-none" style="color:var(--green-mid);">
            <i class="bi bi-arrow-left me-1"></i>Lihat Semua Pesanan
        </a>
    </div>
</div>

@push('scripts')
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
    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => alert('Nomor rekening disalin!'));
    }
</script>
@endpush
@endsection
