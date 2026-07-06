@extends('layouts.admin')
@section('title', 'Promosi - Admin')
@section('page-title', 'Kelola Siaran & Promosi')

@section('content')

<div class="mb-4 d-flex gap-2 justify-content-between align-items-center">
    <div>
        @if(request('search'))
            <span class="text-muted small">Hasil pencarian: <strong>"{{ request('search') }}"</strong></span>
        @endif
    </div>
    <a href="{{ route('admin.promos.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i>Buat Promo Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card card-admin">
    <div class="card-body p-4">
        @if($promos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background:#f3f4f6;">
                        <tr>
                            <th>Judul Promosi</th>
                            <th>Tanggal Berlaku</th>
                            <th>Status</th>
                            <th style="width:150px;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promos as $promo)
                        <tr>
                            <td>
                                <div class="fw-600">{{ $promo->title }}</div>
                                <small class="text-muted">{{ Str::limit($promo->description, 50) }}</small>
                            </td>
                            <td>
                                <small>
                                    {{ $promo->start_date->format('d M Y') }} - {{ $promo->end_date->format('d M Y') }}
                                </small>
                            </td>
                            <td>
                                @if($promo->is_active && $promo->start_date <= now() && $promo->end_date >= now())
                                    <span class="badge" style="background:#d1fae5;color:#065f46;">
                                        <i class="bi bi-check-circle me-1"></i>Berlaku Sekarang
                                    </span>
                                @elseif($promo->is_active && $promo->start_date > now())
                                    <span class="badge" style="background:#fef3c7;color:#92400e;">
                                        <i class="bi bi-clock me-1"></i>Segera Hadir
                                    </span>
                                @elseif($promo->is_active && $promo->end_date < now())
                                    <span class="badge" style="background:#f3e8ff;color:#5b21b6;">
                                        <i class="bi bi-archive me-1"></i>Berakhir
                                    </span>
                                @else
                                    <span class="badge" style="background:#f3f4f6;color:#6b7280;">
                                        <i class="bi bi-x-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.promos.edit', $promo->id) }}"
                                   class="btn btn-xs btn-warning me-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.promos.destroy', $promo->id) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($promos->hasPages())
            <div class="mt-4">
                {{ $promos->links() }}
            </div>
            @endif
        @else
            <div class="text-center py-8" style="color:#9ca3af;">
                <i class="bi bi-inbox" style="font-size:3rem;opacity:.5;"></i>
                <p class="mt-3 mb-0 fw-600">Belum ada promosi</p>
                <small>Mulai buat siaran & promosi untuk customer Anda</small>
                <br>
                <a href="{{ route('admin.promos.create') }}" class="btn btn-primary-custom mt-3 btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Buat Promosi Pertama
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
