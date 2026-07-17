<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIMANTAP - Bener Meriah')</title>
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #0b3d2e;
            --secondary: #145c44;
            --light-bg: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #ffffff;
            color: #212529;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-guest {
            background: rgba(11, 61, 46, 0.92) !important;
            padding: 0.8rem 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: relative;
            z-index: 10;
        }

        .navbar-guest .navbar-brand {
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff !important;
        }

        .navbar-guest .navbar-brand small {
            font-weight: 400;
            font-size: 0.65rem;
            opacity: 0.8;
            display: block;
        }

        .navbar-guest .navbar-brand i {
            font-size: 1.5rem;
        }

        .navbar-guest .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .navbar-guest .nav-link:hover {
            color: #fff !important;
        }

        .navbar-guest .btn-light {
            color: var(--primary);
            font-weight: 600;
        }

        .navbar-guest .btn-light:hover {
            background: #e8f5e9;
            border-color: #e8f5e9;
        }

        .navbar-guest .btn-outline-light:hover {
            background: #fff;
            color: var(--primary) !important;
        }

        /* ===== HERO WITH VIDEO BACKGROUND ===== */
        .hero-video {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 6rem 0 4rem;
            margin-top: -1px;
        }

        .hero-video-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        /* Video Background - TANPA WATERMARK */
        .hero-video-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            z-index: 0;
        }

        /* Overlay Gradient - BUKAN HIJAU SOLID */
        .hero-video-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(11, 61, 46, 0.7) 0%, rgba(20, 92, 68, 0.5) 50%, rgba(11, 61, 46, 0.3) 100%);
            z-index: 1;
        }

        .hero-video .container {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            text-shadow: 0 2px 30px rgba(0,0,0,0.3);
        }

        .hero-title span {
            color: #a5d6a7;
            text-shadow: 0 2px 20px rgba(165, 214, 167, 0.3);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 500px;
            color: rgba(255,255,255,0.9);
            text-shadow: 0 1px 20px rgba(0,0,0,0.2);
        }

        .hero-stats .stat-item {
            background: rgba(255,255,255,0.1);
            padding: 0.6rem 1.5rem;
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.08);
            transition: all 0.3s ease;
        }

        .hero-stats .stat-item:hover {
            background: rgba(255,255,255,0.18);
            transform: translateY(-2px);
        }

        .hero-stats .stat-item .number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
        }

        .hero-stats .stat-item .label {
            font-size: 0.75rem;
            opacity: 0.7;
            color: rgba(255,255,255,0.8);
        }

        /* ===== SECTION ===== */
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary);
            border-radius: 10px;
        }

        /* ===== CARDS ===== */
        .card-stat {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            background: #fff;
            padding: 1.5rem;
            text-align: center;
            height: 100%;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .card-stat .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .card-stat .number {
            font-size: 2rem;
            font-weight: 700;
        }

        .card-stat .label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .card-feature {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            background: #fff;
            padding: 2rem 1.5rem;
            text-align: center;
            height: 100%;
        }

        .card-feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .card-feature .icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: rgba(11, 61, 46, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            color: var(--primary);
        }

        .card-feature h5 {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .card-feature p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, #0b3d2e 0%, #1a6b4a 100%);
            color: #fff;
            padding: 4rem 0;
            text-align: center;
        }

        .cta-section h2 {
            font-weight: 700;
            font-size: 2.2rem;
        }

        .cta-section p {
            opacity: 0.8;
            font-size: 1.1rem;
        }

        .cta-section .btn-light {
            color: var(--primary);
            font-weight: 600;
        }

        .cta-section .btn-light:hover {
            background: #e8f5e9;
        }

        .cta-section .btn-outline-light:hover {
            background: #fff;
            color: var(--primary) !important;
        }

        /* ===== FOOTER ===== */
        .footer-guest {
            background: var(--primary);
            color: #fff;
            padding: 2rem 0 1rem;
        }

        .footer-guest a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-guest a:hover {
            color: #fff;
        }

        .footer-guest .social-icon {
            display: inline-flex;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all 0.3s;
        }

        .footer-guest .social-icon:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-3px);
        }

        /* ===== ANIMATIONS ===== */
        .hero-video-wrapper {
            animation: videoFadeIn 1.5s ease;
        }

        @keyframes videoFadeIn {
            from {
                opacity: 0;
                transform: scale(1.05);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        .fade-in-up-delay-1 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .fade-in-up-delay-2 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.8rem;
            }
            .hero-video {
                min-height: auto;
                padding: 5rem 0 3rem;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .hero-subtitle {
                font-size: 1rem;
            }
            .section-title {
                font-size: 1.5rem;
            }
            .card-stat .number {
                font-size: 1.5rem;
            }
            .cta-section h2 {
                font-size: 1.5rem;
            }
            .hero-stats .stat-item .number {
                font-size: 1.3rem;
            }
            .hero-stats .stat-item {
                padding: 0.4rem 1rem;
            }
            .hero-video {
                padding: 4rem 0 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }
            .hero-subtitle {
                font-size: 0.95rem;
            }
            .card-stat {
                padding: 1rem;
            }
            .card-feature {
                padding: 1.5rem 1rem;
            }
            .hero-stats .stat-item {
                padding: 0.3rem 0.8rem;
            }
            .hero-stats .stat-item .number {
                font-size: 1rem;
            }
            .hero-stats .stat-item .label {
                font-size: 0.65rem;
            }
            .hero-video {
                padding: 3rem 0 1.5rem;
                min-height: auto;
            }
        }

        /* ===== FLASH MESSAGES ===== */
        .alert-guest {
            border-radius: 12px;
            border: none;
            padding: 0.8rem 1.2rem;
            margin-bottom: 1rem;
        }

        .alert-guest .btn-close {
            font-size: 0.7rem;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        /* ===== FORM GUEST ===== */
        .form-control-lg,
        .form-select-lg {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus,
        .form-select-lg:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(11, 61, 46, 0.12);
        }

        .form-control-lg.is-invalid:focus,
        .form-select-lg.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.12);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        .form-label .text-danger {
            font-weight: 700;
        }

        .form-label .text-muted {
            font-weight: 400;
        }

        .btn-success {
            background: var(--primary);
            border-color: var(--primary);
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(11, 61, 46, 0.3);
        }

        .btn-outline-secondary {
            border-radius: 10px;
            font-weight: 600;
            border-width: 1.5px;
        }

        .btn-outline-secondary:hover {
            transform: translateY(-2px);
        }

        /* Alert styling */
        .alert {
            border-radius: 12px;
            border: none;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-danger ul {
            list-style: none;
            padding-left: 0;
        }

        .alert-danger ul li::before {
            content: '• ';
            color: #dc3545;
        }

        /* Responsive form */
        @media (max-width: 576px) {
            .form-control-lg,
            .form-select-lg {
                font-size: 0.9rem;
                padding: 0.5rem 0.8rem;
            }
            
            .guest-body {
                padding: 1.2rem !important;
            }
            
            .btn-success,
            .btn-outline-secondary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-lg navbar-guest sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <i class="bi bi-clipboard-data me-2"></i>SIMANTAP
                <small>Sekda Kabupaten Bener Meriah</small>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#guestNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="guestNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#statistik">Statistik</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-light btn-sm px-3" type="submit">
                                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('guest.form') }}" class="btn btn-light btn-sm px-3">
                                <i class="bi bi-book me-1"></i>Buku Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success'))
        <div class="container mt-3" style="position: relative; z-index: 10;">
            <div class="alert alert-success alert-guest alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3" style="position: relative; z-index: 10;">
            <div class="alert alert-danger alert-guest alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- ===== CONTENT ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer-guest">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-6 text-center text-md-start">
                    <span class="small opacity-75">
                        &copy; {{ date('Y') }} SIMANTAP - Sekda Kabupaten Bener Meriah
                    </span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex justify-content-center justify-content-md-end gap-2">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>