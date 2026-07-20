<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SIMANTAP Bener Meriah</title>
    
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    {{-- Custom CSS --}}
    <style>
        :root {
            --primary-green: #0b3d2e;
            --secondary-green: #145c44;
            --light-bg: #f4f6f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--light-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* ============================================ */
        /* SIDEBAR                                      */
        /* ============================================ */
        .sidebar {
            min-height: 100vh;
            background: var(--primary-green);
            color: #fff;
            width: 250px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .sidebar .brand {
            padding: 1.2rem 1.1rem;
            font-weight: 700;
            font-size: 1.05rem;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }

        .sidebar .brand small {
            display: block;
            font-weight: 400;
            opacity: .75;
            font-size: .75rem;
            margin-top: 2px;
        }

        .sidebar a {
            color: #dbe9e2;
            text-decoration: none;
            display: block;
            padding: .65rem 1.1rem;
            border-radius: .4rem;
            margin: .15rem .6rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: var(--secondary-green);
            color: #fff;
            transform: translateX(3px);
        }

        .sidebar a.active {
            font-weight: 600;
            box-shadow: inset 3px 0 0 rgba(255,255,255,0.5);
        }

        /* ============================================ */
        /* MAIN CONTENT                                 */
        /* ============================================ */
        .main-content {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ============================================ */
        /* TOPBAR                                       */
        /* ============================================ */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: .75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .topbar .user-info .badge {
            font-size: 0.65rem;
            padding: 0.3rem 0.6rem;
        }

        /* ============================================ */
        /* CARDS                                        */
        /* ============================================ */
        .card-stat {
            border: none;
            border-radius: .9rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.05);
            transition: all 0.3s ease;
            background: #fff;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        /* ============================================ */
        /* CHART WRAPPER - AGAR SEJAJAR                 */
        /* ============================================ */
        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 220px;
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 220px;
        }

        /* Untuk chart yang lebih tinggi (seperti tren) */
        .chart-wrapper-tall {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 250px;
        }

        .chart-wrapper-tall canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 250px;
        }

        /* ============================================ */
        /* BADGE STATUS                                 */
        /* ============================================ */
        .badge-status {
            font-size: .75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
        }

        /* ============================================ */
        /* TABLE                                        */
        /* ============================================ */
        .table thead th {
            font-size: .78rem;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom-width: 1px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .table tbody td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        /* ============================================ */
        /* CARD BODY PADDING UNIFORM                    */
        /* ============================================ */
        .card-stat .card-body {
            padding: 1.25rem;
        }

        .card-stat .card-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .card-stat .card-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        /* ============================================ */
        /* RESPONSIVE                                   */
        /* ============================================ */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .chart-wrapper,
            .chart-wrapper-tall {
                min-height: 180px;
            }

            .chart-wrapper canvas,
            .chart-wrapper-tall canvas {
                max-height: 180px;
            }
        }

        @media (max-width: 576px) {
            .chart-wrapper,
            .chart-wrapper-tall {
                min-height: 150px;
            }

            .chart-wrapper canvas,
            .chart-wrapper-tall canvas {
                max-height: 150px;
            }

            .card-stat .card-value {
                font-size: 1.25rem;
            }

            .topbar {
                padding: 0.5rem 1rem;
            }

            .main-content .p-3.p-md-4 {
                padding: 0.75rem !important;
            }
        }

        /* ============================================ */
        /* UTILITY                                      */
        /* ============================================ */
        .text-primary-green {
            color: var(--primary-green);
        }
        .bg-primary-green {
            background: var(--primary-green);
        }
        .btn-primary-green {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: #fff;
        }
        .btn-primary-green:hover {
            background: var(--secondary-green);
            border-color: var(--secondary-green);
            color: #fff;
        }

        /* ============================================ */
        /* SCROLLBAR GLOBAL                             */
        /* ============================================ */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary-green);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-green);
        }

        /* ============================================ */
        /* FLASH MESSAGES                               */
        /* ============================================ */
        .alert-custom {
            border-radius: 0.75rem;
            border: none;
            padding: 0.85rem 1.25rem;
        }

        .alert-custom .btn-close {
            font-size: 0.7rem;
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="d-flex">
    {{-- SIDEBAR OVERLAY (Mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- SIDEBAR --}}
    <nav class="sidebar" id="sidebar">
        <div class="brand">
            SIMANTAP
            <small>Sekda Kabupaten Bener Meriah</small>
        </div>
        <div class="p-2">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            
            @auth
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
            @endauth
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <div class="main-content">
        {{-- TOPBAR --}}
        <div class="topbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                {{-- Toggle Sidebar Mobile --}}
                <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-bold d-lg-none text-primary-green">SIMANTAP</span>
            </div>
            
            @auth
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small user-info d-none d-sm-inline">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ auth()->user()->name }}
                    <span class="badge bg-secondary text-uppercase ms-1">{{ auth()->user()->role }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline">Keluar</span>
                    </button>
                </form>
            </div>
            @endauth
        </div>

        {{-- CONTENT --}}
        <div class="p-3 p-md-4 flex-grow-1">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-custom alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-custom alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-custom alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

        {{-- FOOTER --}}
        <footer class="text-center text-muted py-3 border-top bg-white small">
            &copy; {{ date('Y') }} SIMANTAP - Sekda Kabupaten Bener Meriah
        </footer>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Script untuk Sidebar Mobile --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        // Auto close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991.98 && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>