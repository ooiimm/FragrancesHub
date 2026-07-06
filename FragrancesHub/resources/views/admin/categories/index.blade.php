{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Kategori - Admin')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </a>
</div>

<div class="card card-admin" style="max-width:760px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Jumlah Produk</th>
                        <th>Deskripsi</th>
                        <th style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td class="fw-600">{{ $category->name }}</td>
                        <td><code class="small">{{ $category->slug }}</code></td>
                        <td>
                            <span class="badge" style="background:rgba(20,83,45,.1);color:var(--green-mid);">
                                {{ $category->products_count }} produk
                            </span>
                        </td>
                        <td class="text-muted small">{{ Str::limit($category->description, 50) ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-gold">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus kategori ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white border-top-0">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
