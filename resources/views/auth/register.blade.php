{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FragrancesHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-dark:#0B3D2E; --green-mid:#14532D; --gold:#C9A96E; --gold-light:#E8C98A;
            --gradient-main:linear-gradient(135deg,#0B3D2E,#14532D);
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            min-height: 100vh;
            background: var(--gradient-main);
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: #fff; border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%; max-width: 480px; overflow: hidden;
        }
        .auth-header {
            background: var(--gradient-main);
            padding: 28px 36px 24px; text-align: center;
        }
        .auth-header .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; font-weight: 700; color: #fff;
        }
        .auth-header .brand span { color: var(--gold-light); }
        .auth-header p { color: rgba(255,255,255,.75); font-size: .88rem; margin: 6px 0 0; }
        .auth-body { padding: 28px 36px; }
        .form-control {
            border-radius: 10px; border: 1.5px solid #D1D5DB;
            padding: 10px 14px; font-size: .9rem; transition: all .25s;
            font-family: 'Jost', sans-serif;
        }
        .form-control:focus { border-color: var(--green-mid); box-shadow: 0 0 0 3px rgba(20,83,45,.1); }
        label.form-label { font-weight: 600; font-size: .83rem; color: #374151; }
        .btn-register {
            background: var(--gradient-main); border: none; color: #fff;
            font-weight: 700; border-radius: 10px; padding: 12px;
            font-size: .96rem; transition: all .25s; width: 100%;
            font-family: 'Jost', sans-serif;
        }
        .btn-register:hover { box-shadow: 0 6px 20px rgba(11,61,46,.35); transform: translateY(-1px); color:#fff; }
        .link-green { color: var(--green-mid); font-weight: 600; text-decoration: none; }
        .link-green:hover { color: var(--green-dark); text-decoration: underline; }
        @media(max-width:480px) { .auth-header,.auth-body { padding: 20px 18px; } }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-header">
        <div class="brand text-center">
            <img src="{{ asset('images/logo.svg') }}" alt="FragrancesHub logo" style="height:48px; width:auto; display:block; margin:0 auto 10px;">
            <div>Fragrances<span style="color:#E8C98A;">Hub</span></div>
        </div>
        <p>Buat akun baru Anda</p>
    </div>
    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       placeholder="Nama lengkap Anda"
                       value="{{ old('name') }}" autofocus autocomplete="name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       placeholder="email@example.com"
                       value="{{ old('email') }}" autocomplete="username">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                       placeholder="08xxxxxxxxxx"
                       value="{{ old('phone') }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" rows="2"
                          class="form-control @error('address') is-invalid @enderror"
                          placeholder="Alamat lengkap Anda (opsional)">{{ old('address') }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter" autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Ulangi password" autocomplete="new-password">
            </div>

            <button type="submit" class="btn-register mb-3">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </button>

            <p class="text-center small text-muted mb-0">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="link-green">Login di sini</a>
            </p>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
