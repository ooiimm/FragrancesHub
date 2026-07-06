@extends('layouts.admin')
@section('title', 'Buat Promosi - Admin')
@section('page-title', 'Buat Siaran & Promosi Baru')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Promosi
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Informasi Dasar --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Promosi</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">
                            Judul Promosi <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Contoh: Diskon Akhir Tahun Fantastis"
                               value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Promosi</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Jelaskan detail promosi Anda...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Hindari jutaan karakter</small>
                    </div>
                </div>
            </div>

            {{-- Banner Promosi --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-image me-2"></i>Banner Promosi</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Upload Gambar Banner</label>
                        <input type="file" name="image" id="imageInput"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/jpg,image/png"
                               onchange="previewGambar(this)">
                        <div class="form-text">Format: JPG, PNG. Ukuran maksimal: 2MB. (Opsional)</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview --}}
                    <div id="previewWrap" class="d-none">
                        <label class="form-label">Preview Banner:</label>
                        <div class="rounded-3 overflow-hidden"
                             style="width:100%;max-height:300px;background:#f3f4f6;border:2px dashed #d1d5db;">
                            <img id="previewImg" src=""
                                 style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                onclick="hapusPreview()">
                            <i class="bi bi-x me-1"></i>Hapus Gambar
                        </button>
                    </div>

                    {{-- Placeholder --}}
                    <div id="placeholderWrap"
                         style="width:100%;height:200px;background:linear-gradient(135deg,#fff3cd,#ffeaa7);
                                border-radius:12px;display:flex;flex-direction:column;
                                align-items:center;justify-content:center;
                                border:2px dashed #ffc107;cursor:pointer;"
                         onclick="document.getElementById('imageInput').click()">
                        <i class="bi bi-cloud-upload" style="font-size:2.5rem;color:#856404;opacity:.5;"></i>
                        <div style="color:#856404;font-size:.8rem;opacity:.7;margin-top:8px;">Klik untuk pilih banner</div>
                    </div>
                </div>
            </div>

            {{-- Tanggal Berlaku --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-calendar me-2"></i>Tanggal Berlaku</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                Tanggal Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" name="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Tanggal Berakhir <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" name="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="card card-admin mb-4">
                <div class="card-body p-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active"
                               id="isActive" style="width:2.5em;height:1.3em;"
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label ms-2 fw-600" for="isActive">
                            <i class="bi bi-broadcast me-1"></i>Promosi Aktif
                        </label>
                        <div class="text-muted small mt-1">
                            Promosi aktif akan ditampilkan di homepage jika dalam periode berlaku.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary-custom px-5 py-2">
                    <i class="bi bi-check-lg me-2"></i>Buat Promosi
                </button>
                <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>

        </form>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        <div class="card card-admin sticky-top" style="top:90px;">
            <div class="card-header">
                <h6><i class="bi bi-lightbulb me-2"></i>Panduan Membuat Promosi</h6>
            </div>
            <div class="card-body p-4 small">
                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-1-circle-fill me-2" style="color:var(--gold);"></i>Judul Promosi
                    </div>
                    <div class="text-muted">Buat judul yang menarik dan jelas. Contoh: "Diskon Akhir Tahun Fantastis" atau "Grand Opening Promo"</div>
                </div>

                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-2-circle-fill me-2" style="color:var(--gold);"></i>Deskripsi
                    </div>
                    <div class="text-muted">Jelaskan detail promosi Anda dengan singkat dan jelas. Highlight benefit utama untuk customer.</div>
                </div>

                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-3-circle-fill me-2" style="color:var(--gold);"></i>Banner Promosi
                    </div>
                    <div class="text-muted">Upload gambar/banner yang menarik untuk menampilkan promosi di homepage.</div>
                </div>

                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-4-circle-fill me-2" style="color:var(--gold);"></i>Tanggal
                    </div>
                    <div class="text-muted">Tentukan kapan promosi dimulai dan berakhir. Sistem akan otomatis menampilkan status "Berlaku Sekarang" atau "Segera Hadir".</div>
                </div>

                <div class="p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="fw-600 small mb-1" style="color:#065f46;">
                        <i class="bi bi-star-fill me-1"></i>Tips
                    </div>
                    <small class="text-muted">
                        Promosi yang baik akan meningkatkan engagement customer. Update promosi secara berkala untuk menjaga freshness konten!
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewGambar(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewWrap').classList.remove('d-none');
            document.getElementById('placeholderWrap').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

function hapusPreview() {
    document.getElementById('imageInput').value = '';
    document.getElementById('previewWrap').classList.add('d-none');
    document.getElementById('placeholderWrap').style.display = 'flex';
}
</script>
@endpush

@endsection
