<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SIMANTAP Bener Meriah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background:#f4f6f9; font-family: 'Segoe UI', system-ui, sans-serif; }
        .sidebar { min-height:100vh; background:#0b3d2e; color:#fff; width:250px; }
        .sidebar a { color:#dbe9e2; text-decoration:none; display:block; padding:.65rem 1.1rem; border-radius:.4rem; margin:.15rem .6rem; }
        .sidebar a.active, .sidebar a:hover { background:#145c44; color:#fff; }
        .sidebar .brand { padding:1.2rem 1.1rem; font-weight:700; font-size:1.05rem; border-bottom:1px solid rgba(255,255,255,.15); }
        .sidebar .brand small { display:block; font-weight:400; opacity:.75; font-size:.75rem; }
        .main-content { flex:1; }
        .topbar { background:#fff; border-bottom:1px solid #e5e7eb; padding:.75rem 1.25rem; }
        .card-stat { border:none; border-radius:.9rem; box-shadow:0 2px 10px rgba(0,0,0,.05); }
        .badge-status { font-size:.75rem; }
        .table thead th { font-size:.78rem; text-transform:uppercase; color:#6b7280; border-bottom-width:1px; }
    </style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <nav class="sidebar d-none d-lg-block">
        <div class="brand">
            SIMANTAP
            <small>Setda Kabupaten Bener Meriah</small>
        </div>
        <div class="p-2">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            @if(in_array(auth()->user()->role, ['admin','petugas']))
            <a href="{{ route('qrcode.show') }}" class="{{ request()->routeIs('qrcode.show') ? 'active' : '' }}">
                <i class="bi bi-qr-code me-2"></i> QR Code Buku Tamu
            </a>
            <a href="{{ route('kunjungan.index') }}" class="{{ request()->routeIs('kunjungan.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check me-2"></i> Verifikasi Kunjungan
            </a>
            @endif
            <a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i> Riwayat Kunjungan
            </a>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan
            </a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('master.index') }}" class="{{ request()->routeIs('master.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3 me-2"></i> Data Master
            </a>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i> Kelola Pengguna
            </a>
            @endif
        </div>
    </nav>

    <div class="main-content">
        <div class="topbar d-flex justify-content-between align-items-center">
            <div class="d-lg-none fw-bold">SIMANTAP</div>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-muted small">
                    <i class="bi bi-person-circle"></i>
                    {{ auth()->user()->name }}
                    <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                </form>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
