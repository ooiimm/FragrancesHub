@extends('layouts.admin')
@section('title', 'Edit Promosi - Admin')
@section('page-title', 'Edit Siaran & Promosi')

@section('content')

<div class="mb-4 d-flex gap-2 align-items-center">
    <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <span class="text-muted small">/ Edit: <strong>{{ $promo->title }}</strong></span>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                               value="{{ old('title', $promo->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Promosi</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Jelaskan detail promosi Anda...">{{ old('description', $promo->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Banner Promosi --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-image me-2"></i>Banner Promosi</h6>
                </div>
                <div class="card-body p-4">
                    {{-- Gambar Saat Ini --}}
                    @if($promo->image)
                    <div class="mb-4 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                        <div class="small fw-600 mb-2" style="color:#14532d;">
                            <i class="bi bi-image me-1"></i>Banner Saat Ini:
                        </div>
                        <img src="{{ asset('storage/' . $promo->image) }}"
                             alt="{{ $promo->title }}"
                             class="rounded-3"
                             style="max-height:200px;max-width:100%;object-fit:cover;border:2px solid #d1fae5;">
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">
                            {{ $promo->image ? 'Ganti Banner (opsional)' : 'Upload Banner' }}
                        </label>
                        <input type="file" name="image" id="imageInput"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/jpg,image/png"
                               onchange="previewGambar(this)">
                        <div class="form-text">
                            {{ $promo->image ? 'Kosongkan jika tidak ingin mengganti banner.' : '' }}
                            Format: JPG, PNG. Maks 2MB.
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview --}}
                    <div id="previewWrap" class="d-none">
                        <label class="form-label">Preview Banner Baru:</label>
                        <br>
                        <img id="previewImg" src="" class="rounded-3"
                             style="max-height:200px;max-width:100%;border:2px solid #e5e7eb;">
                        <br>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                onclick="hapusPreview()">
                            <i class="bi bi-x me-1"></i>Batal Ganti Banner
                        </button>
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
                                   value="{{ old('start_date', $promo->start_date->format('Y-m-d\TH:i')) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                {{ $promo->start_date->format('d M Y, H:i') }}
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Tanggal Berakhir <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" name="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date', $promo->end_date->format('Y-m-d\TH:i')) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                {{ $promo->end_date->format('d M Y, H:i') }}
                            </small>
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
                               {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label ms-2 fw-600" for="isActive">
                            <i class="bi bi-broadcast me-1"></i>Promosi Aktif
                        </label>
                        <div class="text-muted small mt-1">
                            Nonaktifkan untuk menyembunyikan promosi dari homepage.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary-custom px-5 py-2">
                    <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
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
                <h6><i class="bi bi-info-circle me-2"></i>Info Promosi</h6>
            </div>
            <div class="card-body p-4 small">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted" style="width:100px;">ID Promo</td>
                        <td><code>#{{ $promo->id }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dibuat</td>
                        <td>{{ $promo->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Diupdate</td>
                        <td>{{ $promo->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($promo->is_active && $promo->start_date <= now() && $promo->end_date >= now())
                                <span class="badge" style="background:#d1fae5;color:#065f46;">Berlaku Sekarang</span>
                            @elseif($promo->is_active && $promo->start_date > now())
                                <span class="badge" style="background:#fef3c7;color:#92400e;">Segera Hadir</span>
                            @elseif($promo->is_active && $promo->end_date < now())
                                <span class="badge" style="background:#f3e8ff;color:#5b21b6;">Berakhir</span>
                            @else
                                <span class="badge" style="background:#f3f4f6;color:#6b7280;">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="fw-600 small mb-1" style="color:#065f46;">
                        <i class="bi bi-lightbulb me-1"></i>Catatan
                    </div>
                    <small class="text-muted">
                        Sistem akan otomatis menampilkan/menyembunyikan promosi berdasarkan tanggal berlaku dan status aktif.
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
        };
        reader.readAsDataURL(file);
    }
}

function hapusPreview() {
    document.getElementById('imageInput').value = '';
    document.getElementById('previewWrap').classList.add('d-none');
}
</script>
@endpush

@endsection
