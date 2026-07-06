@extends('layouts.admin')
@section('title', 'Detail Produk - Admin')
@section('page-title', 'Detail Produk')

@section('content')

<div class="mb-4 d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-gold btn-sm">
        <i class="bi bi-pencil me-1"></i>Edit Produk
    </a>
    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm"
                onclick="return confirm('Yakin hapus produk ini?')">
            <i class="bi bi-trash me-1"></i>Hapus
        </button>
    </form>
</div>

<div class="row g-4">

    {{-- Kolom Kiri: Foto & Info Utama --}}
    <div class="col-lg-5">
        <div class="card card-admin">
            <div class="card-body p-4">

                {{-- Foto Produk --}}
                <div class="rounded-4 overflow-hidden mb-4"
                     style="aspect-ratio:1;background:#f3f4f6;max-width:100%;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div style="width:100%;height:100%;min-height:280px;
                                    background:linear-gradient(135deg,#e8f5e9,#c8e6c9);
                                    display:flex;flex-direction:column;
                                    align-items:center;justify-content:center;
                                    color:#14532d;">
                            <i class="bi bi-droplet" style="font-size:5rem;opacity:.3;"></i>
                            <div class="small opacity-50 mt-2">Tidak ada foto</div>
                        </div>
                    @endif
                </div>

                {{-- Badge Kategori --}}
                <span style="background:rgba(20,83,45,.1);color:#14532d;
                             border-radius:20px;padding:4px 14px;font-size:.78rem;font-weight:600;">
                    <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                </span>

                {{-- Nama --}}
                <h3 class="mt-3 mb-2" style="font-family:'Playfair Display',serif;color:#0B3D2E;">
                    {{ $product->name }}
                </h3>

                {{-- Harga --}}
                <div class="mb-3" style="font-size:1.9rem;font-weight:700;color:#14532d;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                {{-- Status Stok --}}
                @if($product->stock == 0)
                    <div class="alert mb-3 py-2" style="background:#fee2e2;color:#991b1b;border:none;border-radius:8px;">
                        <i class="bi bi-x-circle me-2"></i>Stok Habis
                    </div>
                @elseif($product->stock < 5)
                    <div class="alert mb-3 py-2" style="background:#fef9c3;color:#854d0e;border:none;border-radius:8px;">
                        <i class="bi bi-exclamation-triangle me-2"></i>Stok menipis: <strong>{{ $product->stock }} pcs</strong>
                    </div>
                @else
                    <div class="alert mb-3 py-2" style="background:#d1fae5;color:#065f46;border:none;border-radius:8px;">
                        <i class="bi bi-check-circle me-2"></i>Tersedia: <strong>{{ $product->stock }} pcs</strong>
                    </div>
                @endif

                {{-- Status Aktif --}}
                @if($product->is_active)
                    <span class="badge" style="background:#d1fae5;color:#065f46;font-size:.85rem;padding:6px 14px;">
                        <i class="bi bi-eye me-1"></i>Ditampilkan di Toko
                    </span>
                @else
                    <span class="badge" style="background:#fee2e2;color:#991b1b;font-size:.85rem;padding:6px 14px;">
                        <i class="bi bi-eye-slash me-1"></i>Disembunyikan dari Toko
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Detail & Statistik --}}
    <div class="col-lg-7">

        {{-- Deskripsi --}}
        <div class="card card-admin mb-4">
            <div class="card-header">
                <h6><i class="bi bi-file-text me-2"></i>Deskripsi Produk</h6>
            </div>
            <div class="card-body p-4">
                @if($product->description)
                    <p style="line-height:1.8;color:#374151;">{{ $product->description }}</p>
                @else
                    <p class="text-muted fst-italic">Belum ada deskripsi untuk produk ini.</p>
                @endif
            </div>
        </div>

        {{-- Detail Info --}}
        <div class="card card-admin mb-4">
            <div class="card-header">
                <h6><i class="bi bi-list-ul me-2"></i>Informasi Detail</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-borderless mb-0" style="font-size:.9rem;">
                    <tbody>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4" style="width:140px;">ID Produk</td>
                            <td><code>#{{ $product->id }}</code></td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4">Nama</td>
                            <td class="fw-600">{{ $product->name }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4">Kategori</td>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4">Harga</td>
                            <td class="fw-700" style="color:#14532d;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4">Stok</td>
                            <td>
                                <span class="fw-700 {{ $product->stock == 0 ? 'text-danger' : ($product->stock < 5 ? 'text-warning' : 'text-success') }}">
                                    {{ $product->stock }} pcs
                                </span>
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4">Status</td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge" style="background:#d1fae5;color:#065f46;">Aktif</span>
                                @else
                                    <span class="badge" style="background:#fee2e2;color:#991b1b;">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4">Slug</td>
                            <td><code style="font-size:.78rem;">{{ $product->slug }}</code></td>
                        </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td class="text-muted fw-600 ps-4">Dibuat</td>
                            <td>{{ $product->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-600 ps-4">Diperbarui</td>
                            <td>{{ $product->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="card card-admin">
            <div class="card-body p-4">
                <h6 class="mb-3" style="color:#0B3D2E;">Aksi Cepat</h6>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="btn btn-primary-custom">
                        <i class="bi bi-pencil me-2"></i>Edit Produk
                    </a>
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Lihat di Toko
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
