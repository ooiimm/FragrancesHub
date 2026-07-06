@extends('layouts.admin')
@section('title', 'Data Pelanggan - Admin FragrancesHub')
@section('page-title', 'Data Pelanggan')

@section('content')

<div class="card card-admin">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6><i class="bi bi-people me-2"></i>Data Pelanggan</h6>
        <span class="small" style="opacity:.9">{{ $customers->total() }} pelanggan</span>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ url('/admin/customers') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-12 col-md-8">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama pelanggan...">
                </div>
                <div class="col-12 col-md-4 d-grid">
                    <button type="submit" class="btn btn-primary-custom">Cari</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-admin mb-0">

                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        <tr>
                            <td class="fw-600">{{ $c->name }}</td>
                            <td>{{ $c->email }}</td>
                            <td class="text-muted small">{{ $c->phone ?? '-' }}</td>
                            <td class="text-muted small" style="max-width:260px;">
                                {{ $c->address ?? '-' }}
                            </td>
                            <td class="text-muted small">{{ $c->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $customers->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

@endsection

