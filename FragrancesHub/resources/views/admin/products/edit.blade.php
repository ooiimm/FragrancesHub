@extends('layouts.admin')
@section('title', 'Edit Produk - Admin')
@section('page-title', 'Edit Produk')

@section('content')

<div class="mb-4 d-flex gap-2 align-items-center">
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <span class="text-muted small">/ Edit: <strong>{{ $product->name }}</strong></span>
</div>

<div class="row g-4">
    {{-- Form Utama --}}
    <div class="col-lg-8">
        <form action="{{ route('admin.products.update', $product->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Info Dasar --}}
            <div class="card card-admin mb-4">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Produk</h6>
                </div>
                <div class="card-body p-4">

                    <div class="mb-3">
                        <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $product->name) }}"
                               placeholder="Nama produk parfum">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Deskripsi produk...">{{ old('description', $product->description) }}</textarea>
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
                            <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text fw-600">Rp</span>
                                <input type="number" name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       min="0" step="1000"
                                       value="{{ old('price', $product->price) }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text" style="color:#14532d;font-weight:600;">
                                = Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            @php $terjual = $product->orderItems()->sum('quantity'); @endphp
                            <div class="input-group">
                                <input type="number" name="stock"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       min="0"
                                       value="{{ old('stock', $product->stock) }}">
                                <span class="input-group-text">pcs</span>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text mt-1">
                                <span style="color:#6b7280;">Terjual: <strong>{{ $terjual }} pcs</strong></span>
                                &nbsp;·&nbsp;
                                <span style="color:#14532d;font-weight:600;">Stok saat ini: {{ $product->stock }} pcs</span>
                            </div>
                            <div class="form-text" style="color:#92400e;">
                                <i class="bi bi-info-circle me-1"></i>Angka yang Anda masukkan akan langsung menggantikan stok saat ini.
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
                                       value="{{ old('discount_percent', $product->discount_percent ?? 0) }}"
                                       id="discountInput">
                                <span class="input-group-text">%</span>
                                @error('discount_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if(($product->discount_percent ?? 0) > 0)
                            <div class="form-text" style="color:#dc2626;font-weight:600;">
                                🏷️ Harga promo saat ini: <strong>{{ $product->formatted_discounted_price }}</strong>
                                (diskon {{ $product->discount_percent }}%)
                            </div>
                            @endif
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

                    {{-- Gambar saat ini --}}
                    @if($product->image)
                    <div class="mb-4 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                        <div class="small fw-600 mb-2" style="color:#14532d;">
                            <i class="bi bi-image me-1"></i>Foto Saat Ini:
                        </div>
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="rounded-3"
                             style="max-height:180px;max-width:100%;object-fit:cover;border:2px solid #d1fae5;">
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">
                            {{ $product->image ? 'Ganti Foto (opsional)' : 'Upload Foto' }}
                        </label>
                        <input type="file" name="image" id="imageInput"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/jpg,image/png,image/webp"
                               onchange="previewGambar(this)">
                        <div class="form-text">
                            {{ $product->image ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}
                            Format: JPG, PNG, WebP. Maks 2MB.
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="previewWrap" class="d-none">
                        <label class="form-label small fw-600">Preview Foto Baru:</label>
                        <br>
                        <img id="previewImg" src="" class="rounded-3"
                             style="max-height:180px;max-width:100%;border:2px solid #e5e7eb;">
                        <br>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                onclick="hapusPreview()">
                            <i class="bi bi-x me-1"></i>Batal Ganti Foto
                        </button>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="card card-admin mb-4">
                <div class="card-body p-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active"
                               id="isActive" style="width:2.5em;height:1.3em;"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label ms-2 fw-600" for="isActive">
                            Produk Aktif
                        </label>
                        <div class="text-muted small mt-1">
                            Nonaktifkan untuk menyembunyikan produk dari halaman toko.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary-custom px-5 py-2">
                    <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.products.show', $product->id) }}"
                   class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-eye me-1"></i>Lihat Detail
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-x me-1"></i>Batal
                </a>
            </div>

        </form>
    </div>

    {{-- Sidebar Info --}}
    <div class="col-lg-4">
        <div class="card card-admin sticky-top" style="top:90px;">
            <div class="card-header">
                <h6><i class="bi bi-clock-history me-2"></i>Info Produk</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-sm table-borderless small">
                    <tr>
                        <td class="text-muted" style="width:100px;">ID Produk</td>
                        <td><code>#{{ $product->id }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dibuat</td>
                        <td>{{ $product->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Diupdate</td>
                        <td>{{ $product->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($product->is_active)
                                <span class="badge" style="background:#d1fae5;color:#065f46;">Aktif</span>
                            @else
                                <span class="badge" style="background:#fee2e2;color:#991b1b;">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                </table>
                <hr>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-outline-danger btn-sm w-100"
                            onclick="return confirm('Yakin hapus produk \'{{ addslashes($product->name) }}\'?\nTindakan ini tidak dapat dibatalkan.')">
                        <i class="bi bi-trash me-2"></i>Hapus Produk Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
    document.querySelector('input[name="price"]').addEventListener('input', updateDiscountPreview);
    updateDiscountPreview();
    function previewGambar(input) {
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

    function hapusPreview() {
        document.getElementById('previewWrap').classList.add('d-none');
        document.getElementById('imageInput').value = '';
    }
</script>
@endpush

@endsection
