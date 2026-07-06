@extends('layouts.admin')
@section('title', 'Edit Varian - Admin')
@section('page-title', 'Edit Varian Produk')

@section('content')

<div class="mb-4 d-flex gap-2 align-items-center">
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <span class="text-muted small">/ Produk: <strong>{{ $product->name }}</strong> / Varian: <strong>{{ $variant->size }}</strong></span>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-admin">
            <div class="card-header">
                <h6><i class="bi bi-pencil me-2"></i>Edit Varian</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.products.variants.update', [$product->id, $variant->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">
                            Ukuran Varian <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="size" 
                               class="form-control @error('size') is-invalid @enderror"
                               placeholder="Contoh: 50ml, 100ml, 200ml"
                               value="{{ old('size', $variant->size) }}">
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
                                   value="{{ old('price', $variant->price) }}"
                                   id="priceInput">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted d-block mt-2">
                            Rp {{ number_format($variant->price, 0, ',', '.') }}
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
                                   value="{{ old('stock', $variant->stock) }}">
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
                                   {{ old('is_active', $variant->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 fw-600" for="isActive">
                                Varian Aktif
                            </label>
                            <div class="text-muted small mt-1">
                                Nonaktifkan jika varian tidak tersedia
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-5">
                        <button type="submit" class="btn btn-primary-custom px-5 py-2">
                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
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
                <h6><i class="bi bi-info-circle me-2"></i>Info Varian</h6>
            </div>
            <div class="card-body p-4 small">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted">Dibuat</td>
                        <td class="fw-600">{{ $variant->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Diupdate</td>
                        <td class="fw-600">{{ $variant->updated_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($variant->is_active)
                                <span class="badge" style="background:#d1fae5;color:#065f46;">Aktif</span>
                            @else
                                <span class="badge" style="background:#fee2e2;color:#991b1b;">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="fw-600 small mb-1" style="color:#065f46;">
                        <i class="bi bi-lightbulb me-1"></i>Info
                    </div>
                    <small class="text-muted">
                        Edit harga dan stok varian sesuai dengan ketersediaan dan strategi pricing Anda.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
