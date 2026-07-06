@extends('layouts.admin')
@section('title', 'Tambah Produk - Admin')
@section('page-title', 'Tambah Produk Baru')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Produk
    </a>
</div>

<div class="row g-4">
    {{-- Form Utama --}}
    <div class="col-lg-8">
        <form action="{{ route('admin.products.store') }}" method="POST"
              enctype="multipart/form-data" id="formTambahProduk">
            @csrf

            {{-- Info Dasar --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Produk</h6>
                </div>
                <div class="card-body p-4">

                    {{-- Nama Produk --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Contoh: Sauvage Dior EDP 100ml"
                               value="{{ old('name') }}" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($categories->isEmpty())
                            <div class="form-text text-danger">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum ada kategori.
                                <a href="{{ route('admin.categories.create') }}" class="text-danger fw-600">
                                    Buat kategori dulu
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-0">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Jelaskan aroma, keunikan, dan keunggulan parfum ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Harga & Stok --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-tag me-2"></i>Harga & Stok</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                Harga (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text fw-600">Rp</span>
                                <input type="number" name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       placeholder="Contoh: 850000"
                                       min="0" step="1000"
                                       value="{{ old('price') }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text" id="pricePreview"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                Stok <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="stock"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       placeholder="Jumlah stok"
                                       min="0"
                                       value="{{ old('stock', 0) }}">
                                <span class="input-group-text">pcs</span>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Diskon Promo --}}
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-tags me-1 text-danger"></i>Diskon Promo
                                <span class="text-muted fw-400">(opsional)</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="discount_percent"
                                       class="form-control @error('discount_percent') is-invalid @enderror"
                                       placeholder="0"
                                       min="0" max="99"
                                       value="{{ old('discount_percent', 0) }}"
                                       id="discountInput">
                                <span class="input-group-text">%</span>
                                @error('discount_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text" id="discountPreview" style="color:#dc2626;font-weight:600;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gambar --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-image me-2"></i>Foto Produk</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Upload Gambar</label>
                        <input type="file" name="image" id="imageInput"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               onchange="previewGambar(this)">
                        <div class="form-text">Format: JPG, PNG, WebP. Ukuran maksimal: 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview gambar --}}
                    <div id="previewWrap" class="d-none">
                        <label class="form-label">Preview Gambar:</label>
                        <div class="rounded-3 overflow-hidden"
                             style="width:200px;height:200px;background:#f3f4f6;border:2px dashed #d1d5db;">
                            <img id="previewImg" src=""
                                 style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                onclick="hapusPreview()">
                            <i class="bi bi-x me-1"></i>Hapus Gambar
                        </button>
                    </div>

                    {{-- Placeholder jika belum ada gambar --}}
                    <div id="placeholderWrap"
                         style="width:200px;height:200px;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);
                                border-radius:12px;display:flex;flex-direction:column;
                                align-items:center;justify-content:center;
                                border:2px dashed #a7d7a9;cursor:pointer;"
                         onclick="document.getElementById('imageInput').click()">
                        <i class="bi bi-cloud-upload" style="font-size:2.5rem;color:#14532d;opacity:.5;"></i>
                        <div style="color:#14532d;font-size:.8rem;opacity:.7;margin-top:8px;">Klik untuk pilih foto</div>
                    </div>
                </div>
            </div>

            {{-- Status & Featured --}}
            <div class="card card-admin mb-4">
                <div class="card-body p-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_featured"
                               id="isFeatured" style="width:2.5em;height:1.3em;"
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label ms-2 fw-600" for="isFeatured">
                            <i class="bi bi-star-fill" style="color:var(--gold);"></i>Tandai sebagai Produk Unggulan
                        </label>
                        <div class="text-muted small mt-1">
                            Produk unggulan akan ditampilkan di homepage dalam section "Produk Unggulan".
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active"
                               id="isActive" style="width:2.5em;height:1.3em;"
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label ms-2 fw-600" for="isActive">
                            Produk Aktif
                        </label>
                        <div class="text-muted small mt-1">
                            Produk aktif akan ditampilkan di halaman toko.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary-custom px-5 py-2">
                    <i class="bi bi-check-lg me-2"></i>Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>

        </form>
    </div>

    {{-- Sidebar Panduan --}}
    <div class="col-lg-4">
        <div class="card card-admin sticky-top" style="top:90px;">
            <div class="card-header">
                <h6><i class="bi bi-lightbulb me-2"></i>Panduan Pengisian</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 small mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-1-circle-fill me-2" style="color:var(--gold);"></i>Nama Produk
                    </div>
                    <div class="text-muted small">Tulis nama lengkap parfum beserta ukurannya. Contoh: <em>Sauvage Dior EDP 100ml</em></div>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 small mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-2-circle-fill me-2" style="color:var(--gold);"></i>Kategori
                    </div>
                    <div class="text-muted small">Pilih kategori yang sesuai. Jika belum ada, buat di menu Kategori terlebih dahulu.</div>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 small mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-3-circle-fill me-2" style="color:var(--gold);"></i>Harga
                    </div>
                    <div class="text-muted small">Masukkan harga dalam Rupiah tanpa titik atau koma. Contoh: <em>850000</em></div>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 small mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-4-circle-fill me-2" style="color:var(--gold);"></i>Stok
                    </div>
                    <div class="text-muted small">Jumlah unit yang tersedia. Produk otomatis tidak bisa dibeli jika stok = 0.</div>
                </div>
                <div>
                    <div class="fw-600 small mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-5-circle-fill me-2" style="color:var(--gold);"></i>Foto Produk
                    </div>
                    <div class="text-muted small">Gunakan foto berkualitas baik dengan rasio 1:1 (persegi). Format JPG/PNG, maks 2MB.</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview gambar sebelum upload
    function previewGambar(input) {
        const wrap       = document.getElementById('previewWrap');
        const img        = document.getElementById('previewImg');
        const placeholder = document.getElementById('placeholderWrap');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Hapus preview
    function hapusPreview() {
        const wrap        = document.getElementById('previewWrap');
        const placeholder = document.getElementById('placeholderWrap');
        const input       = document.getElementById('imageInput');

        wrap.classList.add('d-none');
        placeholder.style.display = 'flex';
        input.value = '';
    }

    // Preview diskon
    function updateDiscountPreview() {
        const price = parseFloat(document.querySelector('input[name="price"]').value) || 0;
        const disc  = parseInt(document.getElementById('discountInput').value) || 0;
        const preview = document.getElementById('discountPreview');
        if (disc > 0 && price > 0) {
            const final = price * (1 - disc/100);
            preview.innerHTML = '🏷️ Harga jadi: <strong>Rp ' + Math.round(final).toLocaleString('id-ID') + '</strong>';
        } else {
            preview.innerHTML = '';
        }
    }
    document.getElementById('discountInput').addEventListener('input', updateDiscountPreview);

    // Preview harga dalam format Rupiah
    document.querySelector('input[name="price"]').addEventListener('input', function() {
        const preview = document.getElementById('pricePreview');
        const val = parseInt(this.value);
        if (!isNaN(val) && val > 0) {
            preview.innerHTML = '<span style="color:#14532d;font-weight:600;">= Rp ' +
                val.toLocaleString('id-ID') + '</span>';
        } else {
            preview.innerHTML = '';
        }
        updateDiscountPreview();
    });
</script>
@endpush

@endsection
