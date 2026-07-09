<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SIMANTAP Bener Meriah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg,#0b3d2e,#145c44); min-height:100vh; display:flex; align-items:center; font-family:'Segoe UI',system-ui,sans-serif; }
        .login-card { max-width:420px; margin:auto; background:#fff; border-radius:1rem; box-shadow:0 10px 35px rgba(0,0,0,.3); padding:2.25rem; }
    </style>
</head>
<body>
<div class="login-card w-100">
    <div class="text-center mb-4">
        <h4 class="fw-bold text-success-emphasis mb-0">SIMANTAP</h4>
        <small class="text-muted">Sistem Informasi Manajemen Kunjungan Tamu<br>Setda Kabupaten Bener Meriah</small>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label small fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-semibold">Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Ingat saya</label>
        </div>
        <button type="submit" class="btn btn-success w-100">Masuk</button>
    </form>

    <hr>
    <p class="text-center small text-muted mb-0">
        Tamu tidak perlu login. Silakan scan QR Code di meja resepsionis
        untuk mengisi buku tamu.
    </p>
</div>
</body>
</html>
