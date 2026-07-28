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
            z-index: 1050;
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
            width: 100%;
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
        /* NOTIFICATION DROPDOWN                        */
        /* ============================================ */
        .notif-btn {
            position: relative;
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 0.25rem 0.5rem;
            font-size: 1.2rem;
            transition: color 0.2s;
        }

        .notif-btn:hover {
            color: var(--primary-green);
        }

        .notif-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            font-size: 0.55rem;
            padding: 0.15rem 0.4rem;
            min-width: 18px;
            text-align: center;
            border: 2px solid #fff;
            display: none;
        }

        .notif-badge.show {
            display: block;
        }

        .notif-dropdown {
            min-width: 380px;
            max-height: 450px;
            overflow-y: auto;
            padding: 0;
        }

        .notif-dropdown .dropdown-header {
            padding: 0.75rem 1rem;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .notif-dropdown .dropdown-item {
            padding: 0.65rem 1rem;
            border-bottom: 1px solid #f1f3f5;
            cursor: pointer;
            white-space: normal;
            word-wrap: break-word;
        }

        .notif-dropdown .dropdown-item:last-child {
            border-bottom: none;
        }

        .notif-dropdown .dropdown-item:hover {
            background: #f8f9fa;
        }

        .notif-dropdown .dropdown-item.unread {
            background: #f0fdf4;
        }

        .notif-dropdown .dropdown-item.unread:hover {
            background: #dcfce7;
        }

        .notif-dropdown .notif-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notif-dropdown .notif-text {
            flex: 1;
            min-width: 0;
        }

        .notif-dropdown .notif-text .notif-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 2px;
        }

        .notif-dropdown .notif-text .notif-title.bold {
            font-weight: 700;
        }

        .notif-dropdown .notif-text .notif-message {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 2px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notif-dropdown .notif-text .notif-time {
            font-size: 0.65rem;
            color: #adb5bd;
        }

        .notif-dropdown .notif-mark-read {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 0.7rem;
            padding: 0 4px;
            flex-shrink: 0;
        }

        .notif-dropdown .notif-mark-read:hover {
            color: var(--primary-green);
        }

        .notif-dropdown .notif-footer {
            padding: 0.5rem 1rem;
            text-align: center;
            border-top: 1px solid #f1f3f5;
            background: #f8f9fa;
            border-radius: 0 0 8px 8px;
            position: sticky;
            bottom: 0;
            z-index: 1;
        }

        .notif-dropdown .notif-footer a {
            font-size: 0.8rem;
            color: var(--primary-green);
            text-decoration: none;
        }

        .notif-dropdown .notif-footer a:hover {
            text-decoration: underline;
        }

        .notif-dropdown .notif-empty {
            padding: 2rem 1rem;
            text-align: center;
            color: #adb5bd;
        }

        .notif-dropdown .notif-empty i {
            font-size: 2rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .notif-dropdown .notif-empty p {
            font-size: 0.85rem;
            margin: 0;
        }

        /* ============================================ */
        /* AJAX BUTTON LOADING STATE                    */
        /* ============================================ */
        .btn-loading {
            pointer-events: none !important;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-loading .btn-text {
            visibility: hidden;
        }

        .btn-loading .spinner-border-sm {
            display: inline-block !important;
        }

        .btn .spinner-border-sm {
            display: none;
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
        /* TOAST NOTIFICATION                           */
        /* ============================================ */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            max-width: 380px;
            width: 100%;
        }

        .toast-custom {
            background: #fff;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-left: 4px solid var(--primary-green);
            animation: slideInRight 0.4s ease forwards;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            position: relative;
        }

        .toast-custom.toast-success {
            border-left-color: #198754;
        }

        .toast-custom.toast-error {
            border-left-color: #dc3545;
        }

        .toast-custom.toast-warning {
            border-left-color: #ffc107;
        }

        .toast-custom .toast-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .toast-custom .toast-content {
            flex: 1;
        }

        .toast-custom .toast-content .toast-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: #212529;
        }

        .toast-custom .toast-content .toast-message {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 2px;
        }

        .toast-custom .toast-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #adb5bd;
            cursor: pointer;
            padding: 0 4px;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .toast-custom .toast-close:hover {
            color: #212529;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100px);
            }
        }

        .toast-custom.hiding {
            animation: slideOutRight 0.3s ease forwards;
        }

        /* ============================================ */
        /* MODAL                                        */
        /* ============================================ */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }

        .modal-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.25rem;
            background: #f8f9fa;
            border-radius: 12px 12px 0 0;
        }

        .modal-header .modal-title {
            font-size: 1rem;
            color: var(--primary-green);
            font-weight: 600;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
            padding: 0.75rem 1.25rem;
            background: #f8f9fa;
            border-radius: 0 0 12px 12px;
        }

        .modal-body {
            padding: 1.25rem;
        }

        .modal-body .form-control {
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            padding: 0.5rem 0.8rem;
            font-size: 0.9rem;
        }

        .modal-body .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(11, 61, 46, 0.1);
        }

        /* ============================================ */
        /* LOADING SPINNER                              */
        /* ============================================ */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.7);
            z-index: 9998;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .spinner-overlay.show {
            display: flex;
        }

        .spinner-border-custom {
            width: 3rem;
            height: 3rem;
            border: 4px solid #e5e7eb;
            border-top-color: var(--primary-green);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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

            .toast-container {
                top: 70px;
                right: 10px;
                left: 10px;
                max-width: 100%;
            }

            .notif-dropdown {
                min-width: 320px;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                padding: 0.5rem 1rem;
            }
            .main-content .p-3.p-md-4 {
                padding: 0.75rem !important;
            }
            .toast-container {
                top: 60px;
                right: 8px;
                left: 8px;
            }
            .toast-custom {
                padding: 0.75rem 1rem;
            }
            .toast-custom .toast-icon {
                font-size: 1.2rem;
            }
            .notif-dropdown {
                min-width: 280px;
                max-width: 90vw;
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

        .btn-sm {
            padding: 0.25rem 0.6rem;
            font-size: 0.8rem;
        }

        /* List group item */
        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 0.6rem 0;
        }

        .list-group-item:first-child {
            border-top: none;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* ============================================ */
        /* SCROLLBAR                                    */
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

        /* Flash messages dihapus, pake toast */
        .alert-custom {
            display: none;
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- LOADING SPINNER --}}
<div class="spinner-overlay" id="spinnerOverlay">
    <div class="spinner-border-custom"></div>
</div>

{{-- TOAST CONTAINER --}}
<div class="toast-container" id="toastContainer"></div>

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
                <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-bold d-lg-none text-primary-green">SIMANTAP</span>
            </div>
            
            @auth
            <div class="d-flex align-items-center gap-3">
                {{-- ============================================ --}}
                {{-- NOTIFICATION DROPDOWN                       --}}
                {{-- ============================================ --}}
                <div class="dropdown">
                    <button class="notif-btn" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <span class="notif-badge" id="notifBadge">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end notif-dropdown" id="notifList" aria-labelledby="notifDropdown">
                        <li class="dropdown-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Notifikasi</span>
                            <button class="btn btn-sm btn-link p-0 text-primary-green" onclick="markAllAsRead()" style="font-size:0.75rem; text-decoration:none;">
                                Tandai semua dibaca
                            </button>
                        </li>
                        <li class="notif-empty" id="notifEmpty">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada notifikasi</p>
                        </li>
                        <li class="notif-footer">
                            <a href="{{ route('notifications.index') }}">Lihat semua notifikasi</a>
                        </li>
                    </ul>
                </div>

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

{{-- Global Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // SIDEBAR TOGGLE
        // ============================================
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

        window.addEventListener('resize', function() {
            if (window.innerWidth > 991.98 && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // ============================================
        // TOAST NOTIFICATION
        // ============================================
        window.showToast = function(message, type = 'success', title = null) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const icons = {
                success: 'bi-check-circle-fill text-success',
                error: 'bi-exclamation-circle-fill text-danger',
                warning: 'bi-exclamation-triangle-fill text-warning',
                info: 'bi-info-circle-fill text-info'
            };

            const titles = {
                success: 'Berhasil!',
                error: 'Gagal!',
                warning: 'Peringatan!',
                info: 'Informasi'
            };

            const toast = document.createElement('div');
            toast.className = `toast-custom toast-${type}`;
            toast.innerHTML = `
                <div class="toast-icon">
                    <i class="bi ${icons[type] || icons.info}"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${title || titles[type] || 'Info'}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-custom').remove()">
                    <i class="bi bi-x"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(function() {
                if (toast.parentNode) {
                    toast.classList.add('hiding');
                    setTimeout(function() {
                        if (toast.parentNode) toast.remove();
                    }, 300);
                }
            }, 4000);

            toast.addEventListener('click', function(e) {
                if (e.target.closest('.toast-close')) return;
                toast.classList.add('hiding');
                setTimeout(function() {
                    if (toast.parentNode) toast.remove();
                }, 300);
            });
        };

        // ============================================
        // LOADING SPINNER
        // ============================================
        window.showLoading = function(show = true) {
            const spinner = document.getElementById('spinnerOverlay');
            if (spinner) {
                spinner.classList.toggle('show', show);
            }
        };

        // ============================================
        // CSRF TOKEN
        // ============================================
        window.getCsrfToken = function() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        };

        // ============================================
        // AJAX FETCH HELPER
        // ============================================
        window.fetchAjax = function(url, options = {}) {
            const defaults = {
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            };

            return fetch(url, { ...defaults, ...options });
        };

        // ============================================
        // AJAX BUTTON HANDLER - TANPA RELOAD
        // ============================================
        document.addEventListener('click', function(e) {
            // Cari tombol AJAX
            const btn = e.target.closest('.btn-ajax, [data-ajax="true"]');
            if (!btn) return;
            
            // Cegah default
            e.preventDefault();
            e.stopPropagation();
            
            // Ambil data dari tombol
            const url = btn.getAttribute('data-url') || btn.getAttribute('action') || btn.href;
            const method = btn.getAttribute('data-method') || 'POST';
            const confirmMsg = btn.getAttribute('data-confirm');
            const reload = btn.getAttribute('data-reload') === 'true';
            const targetId = btn.getAttribute('data-target');
            
            // Konfirmasi jika ada
            if (confirmMsg && !confirm(confirmMsg)) return;
            
            // Simpan HTML asli
            const originalHtml = btn.innerHTML;
            const originalClass = btn.className;
            
            // Tampilkan loading
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
            btn.classList.add('btn-loading');
            btn.disabled = true;
            
            // Kirim request
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: method !== 'GET' ? JSON.stringify({}) : null,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                // Kembalikan tombol
                btn.innerHTML = originalHtml;
                btn.className = originalClass;
                btn.disabled = false;
                
                if (data.success) {
                    if (window.showToast) {
                        window.showToast(data.message || 'Berhasil!', 'success');
                    }
                    
                    // Update target element jika ada
                    if (targetId) {
                        const target = document.getElementById(targetId);
                        if (target) {
                            if (target.classList.contains('badge') || target.classList.contains('notif-badge')) {
                                target.textContent = data.count || 0;
                            } else {
                                // Reload konten target via AJAX
                                fetchTargetContent(targetId);
                            }
                        }
                    }
                    
                    // Trigger event custom
                    document.dispatchEvent(new CustomEvent('ajax:success', { 
                        detail: { data, btn, targetId } 
                    }));
                    
                    // Reload halaman jika diperlukan
                    if (reload) {
                        setTimeout(() => window.location.reload(), 1500);
                    }
                } else {
                    if (window.showToast) {
                        window.showToast(data.message || 'Gagal!', 'error');
                    }
                }
            })
            .catch(error => {
                btn.innerHTML = originalHtml;
                btn.className = originalClass;
                btn.disabled = false;
                if (window.showToast) {
                    window.showToast('Terjadi kesalahan pada server.', 'error');
                }
                console.error('AJAX Error:', error);
            });
        });

        // Fungsi untuk fetch target content
        function fetchTargetContent(targetId) {
            const target = document.getElementById(targetId);
            if (!target) return;
            
            const url = target.getAttribute('data-url') || window.location.href;
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    target.innerHTML = data.html;
                }
            })
            .catch(error => console.error('Error fetching target:', error));
        }

        // ============================================
        // NOTIFICATION SYSTEM
        // ============================================
        let lastCheck = Date.now();
        let isNotificationOpen = false;

        // Fungsi update badge
        function updateBadge() {
            fetch('/api/notifications/unread-count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notifBadge');
                    if (badge) {
                        badge.textContent = data.count;
                        badge.classList.toggle('show', data.count > 0);
                    }
                })
                .catch(error => console.error('Error updating badge:', error));
        }

        // Fungsi update dropdown
        function updateDropdown() {
            fetch('/api/notifications/latest?limit=5')
                .then(response => response.json())
                .then(notifications => {
                    const dropdown = document.getElementById('notifList');
                    const emptyMessage = document.getElementById('notifEmpty');
                    
                    if (!dropdown) return;

                    // Hapus semua item notifikasi (bukan header/footer)
                    const items = dropdown.querySelectorAll('.dropdown-item:not(.notif-empty):not(.notif-footer)');
                    items.forEach(item => item.remove());

                    if (notifications.length === 0) {
                        if (emptyMessage) emptyMessage.style.display = 'block';
                        return;
                    }

                    if (emptyMessage) emptyMessage.style.display = 'none';

                    // Tambahkan notifikasi ke dropdown
                    notifications.forEach((notif, index) => {
                        const li = document.createElement('li');
                        li.className = `dropdown-item ${!notif.is_read ? 'unread' : ''}`;
                        li.dataset.index = index;
                        
                        const iconColor = notif.color || 'secondary';
                        const iconName = notif.icon || 'bi-bell';
                        
                        li.innerHTML = `
                            <div class="d-flex align-items-start gap-2">
                                <div class="notif-icon bg-${iconColor}-subtle text-${iconColor}">
                                    <i class="bi ${iconName}"></i>
                                </div>
                                <div class="notif-text">
                                    <div class="notif-title ${!notif.is_read ? 'bold' : ''}">${notif.title}</div>
                                    <div class="notif-message">${notif.message}</div>
                                    <div class="notif-time">${notif.time_ago}</div>
                                </div>
                                ${!notif.is_read ? `
                                    <button class="notif-mark-read" onclick="event.stopPropagation(); markAsRead('${notif.id}')">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                ` : ''}
                            </div>
                        `;

                        // Klik untuk redirect ke link
                        if (notif.link) {
                            li.addEventListener('click', function() {
                                window.location.href = notif.link;
                            });
                        }

                        dropdown.insertBefore(li, dropdown.lastElementChild);
                    });

                    updateBadge();
                })
                .catch(error => console.error('Error updating dropdown:', error));
        }

        // Fungsi mark as read
        window.markAsRead = function(id) {
            fetch(`/api/notifications/${id}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateDropdown();
                    updateBadge();
                }
            });
        };

        // Fungsi mark all as read
        window.markAllAsRead = function() {
            fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateDropdown();
                    updateBadge();
                }
            });
        };

        // Track dropdown state
        const dropdownElement = document.getElementById('notifDropdown');
        if (dropdownElement) {
            dropdownElement.addEventListener('show.bs.dropdown', function() {
                isNotificationOpen = true;
                updateDropdown();
            });
            dropdownElement.addEventListener('hide.bs.dropdown', function() {
                isNotificationOpen = false;
            });
        }

        // Inisialisasi
        updateBadge();
        updateDropdown();

        // Polling setiap 10 detik
        setInterval(function() {
            if (!isNotificationOpen) {
                updateBadge();
            }
        }, 10000);

        // Browser notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    });
</script>

@stack('scripts')
</body>
</html>