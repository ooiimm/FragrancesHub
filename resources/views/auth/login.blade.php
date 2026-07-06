{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FragrancesHub</title>
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
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%; max-width: 440px;
            overflow: hidden;
        }
        .auth-header {
            background: var(--gradient-main);
            padding: 32px 36px 28px;
            text-align: center;
        }
        .auth-header .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; font-weight: 700; color: #fff;
        }
        .auth-header .brand span { color: var(--gold-light); }
        .auth-header p { color: rgba(255,255,255,.75); font-size: .88rem; margin: 6px 0 0; }
        .auth-body { padding: 32px 36px; }
        .form-control {
            border-radius: 10px; border: 1.5px solid #D1D5DB;
            padding: 11px 14px; font-size: .92rem; transition: all .25s;
            font-family: 'Jost', sans-serif;
        }
        .form-control:focus {
            border-color: var(--green-mid);
            box-shadow: 0 0 0 3px rgba(20,83,45,.1);
        }
        label.form-label { font-weight: 600; font-size: .85rem; color: #374151; }
        .btn-login {
            background: var(--gradient-main); border: none; color: #fff;
            font-weight: 700; border-radius: 10px; padding: 13px;
            font-size: 1rem; transition: all .25s; width: 100%;
            font-family: 'Jost', sans-serif; letter-spacing: .3px;
        }
        .btn-login:hover {
            box-shadow: 0 6px 20px rgba(11,61,46,.35); transform: translateY(-1px); color: #fff;
        }
        .link-green { color: var(--green-mid); font-weight: 600; text-decoration: none; }
        .link-green:hover { color: var(--green-dark); text-decoration: underline; }
        .alert { border-radius: 10px; border: none; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        .input-group-text { border-radius: 10px 0 0 10px; background: #F9FAFB; border-color: #D1D5DB; }
        .input-group .form-control { border-radius: 0 10px 10px 0; }
        .input-group .form-control:focus { border-left-color: var(--green-mid); }
        @media(max-width:480px) { .auth-header,.auth-body { padding: 24px 20px; } }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-header">
        <div class="brand text-center">
            <img src="{{ asset('images/logo.svg') }}" alt="FragrancesHub logo" style="height:48px; width:auto; display:block; margin:0 auto 10px;">
            <div>Fragrances<span style="color:#E8C98A;">Hub</span></div>
        </div>
        <p>Masuk ke akun Anda</p>
    </div>
    <div class="auth-body">

        @if(session('status'))
            <div class="alert alert-success mb-3 small">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="email@example.com"
                           value="{{ old('email') }}" autofocus autocomplete="email">
                </div>
                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" autocomplete="current-password">
                    <button type="button" class="btn btn-outline-secondary" style="border-radius:0 10px 10px 0;" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            
            <script>
                function togglePassword() {
                    const input = document.getElementById('password');
                    const icon = document.getElementById('toggleIcon');
                    if (!input || !icon) return;

                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';

                    // ikon: ganti bi-eye <-> bi-eye-slash
                    if (isHidden) {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                }
            </script>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-green small">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>

            <p class="text-center small text-muted mb-0">
                Belum punya akun?
                <a href="{{ route('register') }}" class="link-green">Daftar sekarang</a>
            </p>

            <div class="mt-3 text-center">
                    <a href="{{ url('/admin/login') }}" class="link-green small" style="text-decoration:underline;">
                        Login sebagai Admin
                    </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
