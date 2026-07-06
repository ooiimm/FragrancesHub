@extends('layouts.admin')
@section('title', 'Manajemen Produk - Admin')
@section('page-title', 'Manajemen Produk')

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0 small">
        Total: <strong style="color:var(--green-dark);">{{ $products->total() }} produk</strong>
    </p>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i>Tambah Produk
    </a>
</div>

{{-- Form Pencarian --}}
<form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search"
                       class="form-control border-start-0 ps-1"
                       placeholder="Cari nama produk..."
                       value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary-custom px-4">Cari</button>
        </div>
        @if(request('search'))
        <div class="col-auto">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-lg me-1"></i>Reset
            </a>
        </div>
        @endif
    </div>
</form>

{{-- Tabel --}}
<div class="card card-admin">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead>
                    <tr>
                        <th style="width:55px;">Foto</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center" style="width:155px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        {{-- Foto --}}
                        <td>
                            <div class="rounded-2 overflow-hidden flex-shrink-0"
                                 style="width:48px;height:48px;background:#f3f4f6;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div style="width:100%;height:100%;display:flex;align-items:center;
                                                justify-content:center;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);
                                                color:#14532d;font-size:1.3rem;">
                                        <i class="bi bi-droplet"></i>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Nama + deskripsi singkat --}}
                        <td>
                            <div class="fw-600" style="font-size:.92rem;">{{ $product->name }}</div>
                            @if($product->description)
                            <div class="text-muted" style="font-size:.76rem;line-height:1.4;">
                                {{ Str::limit($product->description, 50) }}
                            </div>
                            @endif
                        </td>

                        {{-- Kategori --}}
                        <td>
                            <span style="background:rgba(20,83,45,.1);color:#14532d;
                                         border-radius:20px;padding:3px 11px;font-size:.76rem;font-weight:600;">
                                {{ $product->category->name }}
                            </span>
                        </td>

                        {{-- Harga --}}
                        <td style="white-space:nowrap;">
                            @if($product->is_on_sale)
                                <div class="fw-700" style="color:#14532d;font-size:.92rem;">
                                    {{ $product->formatted_discounted_price }}
                                </div>
                                <div style="text-decoration:line-through;color:#9ca3af;font-size:.78rem;">
                                    {{ $product->formatted_price }}
                                </div>
                                <span style="background:#dc2626;color:#fff;font-size:.65rem;font-weight:700;padding:2px 7px;border-radius:20px;">
                                    -{{ $product->discount_percent }}%
                                </span>
                            @else
                                <span class="fw-700" style="color:#14532d;font-size:.92rem;">
                                    {{ $product->formatted_price }}
                                </span>
                            @endif
                        </td>

                        {{-- Stok --}}
                        <td>
                            @if($product->stock == 0)
                                <span class="badge" style="background:#fee2e2;color:#991b1b;">Habis</span>
                            @elseif($product->stock < 5)
                                <span class="fw-700 text-danger">{{ $product->stock }}</span>
                                <div class="text-muted" style="font-size:.7rem;">menipis</div>
                            @elseif($product->stock < 15)
                                <span class="fw-700 text-warning">{{ $product->stock }}</span>
                            @else
                                <span class="fw-700 text-success">{{ $product->stock }}</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($product->is_active)
                                <span class="badge" style="background:#d1fae5;color:#065f46;">
                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge" style="background:#fee2e2;color:#991b1b;">
                                    <i class="bi bi-x-circle me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- ✅ TOMBOL AKSI: Lihat | Edit | Hapus --}}
                        <td>
                            <div class="d-flex gap-1 justify-content-center flex-wrap">

                                {{-- Tombol LIHAT --}}
                                <a href="{{ route('admin.products.show', $product->id) }}"
                                   class="btn btn-sm"
                                   style="background:#dbeafe;color:#1d4ed8;border:none;border-radius:7px;"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye me-1"></i>Lihat
                                </a>

                                {{-- Tombol EDIT --}}
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-sm btn-gold"
                                   style="border-radius:7px;"
                                   title="Edit Produk">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>

                                {{-- Tombol HAPUS --}}
                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            style="border-radius:7px;"
                                            title="Hapus Produk"
                                            onclick="return confirm('Yakin hapus produk \'{{ addslashes($product->name) }}\'?\n\nTindakan ini tidak dapat dibatalkan.')">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div style="font-size:3.5rem;opacity:.15;color:var(--green-mid);">
                                <i class="bi bi-droplet"></i>
                            </div>
                            <div class="fw-600 mt-2" style="color:#6b7280;">
                                @if(request('search'))
                                    Produk "{{ request('search') }}" tidak ditemukan
                                @else
                                    Belum ada produk
                                @endif
                            </div>
                            <div class="mt-2">
                                @if(request('search'))
                                    <a href="{{ route('admin.products.index') }}"
                                       class="btn btn-sm btn-outline-secondary me-2">Lihat Semua</a>
                                @endif
                                <a href="{{ route('admin.products.create') }}"
                                   class="btn btn-sm btn-primary-custom">
                                    <i class="bi bi-plus me-1"></i>Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center px-4 py-3"
         style="border-radius:0 0 20px 20px;">
        <div class="text-muted small">
            Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }}
            dari {{ $products->total() }} produk
        </div>
        <div>{{ $products->withQueryString()->links() }}</div>
    </div>
    @endif
</div>

@endsection
