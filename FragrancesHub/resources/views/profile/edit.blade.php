@extends('layouts.app')
@section('title', 'Edit Profil - FragrancesHub')

@section('content')
<div class="container py-5" style="max-width:820px;">

    <div class="mb-4">
        <h2 class="section-heading mb-1">Profil Saya</h2>
        <p class="text-muted small">Kelola informasi akun dan data pengiriman Anda</p>
    </div>

    <div class="row g-4">

        {{-- ── KOLOM KIRI: Kartu Info ─────────────────── --}}
        <div class="col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4 text-center sticky-top" style="top:90px;">

                {{-- Avatar inisial --}}
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                     style="width:88px;height:88px;
                            background:linear-gradient(135deg,#0B3D2E,#14532D);
                            font-size:2.2rem;font-weight:700;color:#fff;
                            font-family:'Playfair Display',serif;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <h5 class="fw-700 mb-1" style="font-family:'Playfair Display',serif;color:#0B3D2E;">
                    {{ auth()->user()->name }}
                </h5>
                <div class="text-muted small mb-3">{{ auth()->user()->email }}</div>

                <span class="badge"
                      style="background:{{ auth()->user()->role === 'admin' ? '#fee2e2' : '#d1fae5' }};
                             color:{{ auth()->user()->role === 'admin' ? '#991b1b' : '#065f46' }};
                             font-size:.78rem;padding:5px 14px;border-radius:20px;">
                    {{ auth()->user()->role === 'admin' ? '👑 Admin' : '👤 Member' }}
                </span>

                <hr class="my-3">

                {{-- Info ringkas --}}
                <div class="text-start">
                    <div class="d-flex align-items-start gap-2 mb-2 small">
                        <i class="bi bi-telephone-fill mt-1 flex-shrink-0"
                           style="color:#14532d;font-size:.85rem;"></i>
                        <span class="text-muted">
                            {{ auth()->user()->phone ?? 'Nomor HP belum diisi' }}
                        </span>
                    </div>
                    <div class="d-flex align-items-start gap-2 small">
                        <i class="bi bi-geo-alt-fill mt-1 flex-shrink-0"
                           style="color:#14532d;font-size:.85rem;"></i>
                        <span class="text-muted">
                            {{ auth()->user()->address ?? 'Alamat belum diisi' }}
                        </span>
                    </div>
                </div>

                <hr class="my-3">
                <div class="text-muted" style="font-size:.72rem;">
                    <i class="bi bi-calendar3 me-1"></i>
                    Bergabung {{ auth()->user()->created_at->format('d M Y') }}
                </div>
            </div>
        </div>

        {{-- ── KOLOM KANAN: Form ──────────────────────── --}}
        <div class="col-lg-8">

            {{-- ① Edit Data Diri --}}
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <h5 class="mb-4 fw-700" style="font-family:'Playfair Display',serif;color:#0B3D2E;">
                    <i class="bi bi-person-gear me-2" style="color:#C9A96E;"></i>
                    Edit Informasi Profil
                </h5>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-person text-muted"></i>
                            </span>
                            <input type="text" name="name"
                                   class="form-control border-start-0 @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   placeholder="Nama lengkap Anda">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email (disabled) --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0"
                                   value="{{ auth()->user()->email }}"
                                   style="background:#f9fafb;" disabled>
                        </div>
                        <div class="form-text text-muted">Email tidak dapat diubah.</div>
                    </div>

                    {{-- Nomor HP --}}
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-telephone me-1" style="color:#14532d;"></i>
                            Nomor HP / WhatsApp
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-telephone text-muted"></i>
                            </span>
                            <input type="text" name="phone"
                                   class="form-control border-start-0 @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   placeholder="Contoh: 08123456789">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text text-muted">Digunakan untuk konfirmasi pesanan.</div>
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-geo-alt me-1" style="color:#14532d;"></i>
                            Alamat Pengiriman
                        </label>
                        <textarea name="address" rows="3"
                                  class="form-control @error('address') is-invalid @enderror"
                                  placeholder="Contoh: Jl. Merdeka No. 10, Bandung, Jawa Barat 40111">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            Alamat ini otomatis terisi saat checkout.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom px-5 py-2">
                        <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- ② Ganti Password --}}
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h5 class="mb-4 fw-700" style="font-family:'Playfair Display',serif;color:#0B3D2E;">
                    <i class="bi bi-shield-lock me-2" style="color:#C9A96E;"></i>
                    Ganti Password
                </h5>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Password Saat Ini <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" name="current_password" id="pass0"
                                   class="form-control border-start-0"
                                   placeholder="Masukkan password saat ini">
                            <button type="button" class="input-group-text bg-white"
                                    onclick="togglePass('pass0',this)" style="cursor:pointer;">
                                <i class="bi bi-eye text-muted"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-lock-fill text-muted"></i>
                            </span>
                            <input type="password" name="password" id="pass1"
                                   class="form-control border-start-0"
                                   placeholder="Minimal 8 karakter">
                            <button type="button" class="input-group-text bg-white"
                                    onclick="togglePass('pass1',this)" style="cursor:pointer;">
                                <i class="bi bi-eye text-muted"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Konfirmasi Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-lock-fill text-muted"></i>
                            </span>
                            <input type="password" name="password_confirmation" id="pass2"
                                   class="form-control border-start-0"
                                   placeholder="Ulangi password baru">
                            <button type="button" class="input-group-text bg-white"
                                    onclick="togglePass('pass2',this)" style="cursor:pointer;">
                                <i class="bi bi-eye text-muted"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-outline-secondary px-5 py-2">
                        <i class="bi bi-shield-check me-2"></i>Ganti Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePass(id, btn) {
    const inp  = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.className = 'bi bi-eye-slash text-muted';
    } else {
        inp.type = 'password';
        icon.className = 'bi bi-eye text-muted';
    }
}
</script>
@endpush
@endsection
