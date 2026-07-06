@extends('layouts.admin')
@section('title', 'Tambah Varian - Admin')
@section('page-title', 'Tambah Varian Produk')

@section('content')

<div class="mb-4 d-flex gap-2 align-items-center">
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <span class="text-muted small">/ Produk: <strong>{{ $product->name }}</strong></span>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-admin">
            <div class="card-header">
                <h6><i class="bi bi-plus-circle me-2"></i>Tambah Varian Baru</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.products.variants.store', $product->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">
                            Ukuran Varian <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="size" 
                               class="form-control @error('size') is-invalid @enderror"
                               placeholder="Contoh: 50ml, 100ml, 200ml"
                               value="{{ old('size') }}">
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-2">
                            Masukkan ukuran varian yang jelas dan konsisten
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Harga (Rp) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text fw-600">Rp</span>
                            <input type="number" name="price" 
                                   class="form-control @error('price') is-invalid @enderror"
                                   placeholder="0"
                                   min="0" step="1000"
                                   value="{{ old('price') }}"
                                   id="priceInput"
                                   onchange="updateDiscount()">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted d-block mt-2">
                            Harga spesifik untuk varian ini
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Stok <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" name="stock" 
                                   class="form-control @error('stock') is-invalid @enderror"
                                   placeholder="0"
                                   min="0"
                                   value="{{ old('stock', 0) }}">
                            <span class="input-group-text">pcs</span>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   id="isActive" style="width:2.5em;height:1.3em;"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 fw-600" for="isActive">
                                Varian Aktif
                            </label>
                            <div class="text-muted small mt-1">
                                Varian aktif akan tersedia untuk dibeli oleh customer
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-5">
                        <button type="submit" class="btn btn-primary-custom px-5 py-2">
                            <i class="bi bi-check-lg me-2"></i>Tambah Varian
                        </button>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-x me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-admin sticky-top" style="top:90px;">
            <div class="card-header">
                <h6><i class="bi bi-info-circle me-2"></i>Panduan</h6>
            </div>
            <div class="card-body p-4 small">
                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-1-circle-fill me-2" style="color:var(--gold);"></i>Ukuran
                    </div>
                    <div class="text-muted">Contoh: 50ml, 100ml, Travel Size, Full Size</div>
                </div>

                <div class="mb-3 pb-3 border-bottom">
                    <div class="fw-600 mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-2-circle-fill me-2" style="color:var(--gold);"></i>Harga Varian
                    </div>
                    <div class="text-muted">
                        Harga boleh berbeda per ukuran. Contoh:
                        <ul class="mb-0 mt-2">
                            <li>50ml: Rp 150.000</li>
                            <li>100ml: Rp 225.000</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="fw-600 mb-1" style="color:var(--green-dark);">
                        <i class="bi bi-3-circle-fill me-2" style="color:var(--gold);"></i>Stok Terpisah
                    </div>
                    <div class="text-muted">Setiap varian memiliki stok tersendiri. Atur sesuai ketersediaan.</div>
                </div>

                <hr>

                <div class="p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="fw-600 small mb-1" style="color:#065f46;">
                        <i class="bi bi-lightbulb me-1"></i>Tips
                    </div>
                    <small class="text-muted">
                        Gunakan varian untuk menawarkan ukuran berbeda dengan harga yang sesuai. Ini membantu customer memilih produk sesuai kebutuhan mereka.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
