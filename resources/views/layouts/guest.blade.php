{{-- resources/views/layouts/guest.blade.php --}}
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
            background: var(--primary) !important;
            padding: 0.8rem 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
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

        .navbar-guest .btn-outline-light:hover {
            background: #fff;
            color: var(--primary) !important;
        }

        /* ===== HERO ===== */
        .hero-section {
            background: linear-gradient(135deg, #0b3d2e 0%, #1a6b4a 100%);
            color: white;
            padding: 5rem 0 4rem;
            min-height: 85vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero-title span {
            color: #a5d6a7;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.85;
            max-width: 500px;
        }

        .hero-stats .stat-item {
            background: rgba(255,255,255,0.1);
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            text-align: center;
        }

        .hero-stats .stat-item .number {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .hero-stats .stat-item .label {
            font-size: 0.75rem;
            opacity: 0.7;
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

        .section-title-left::after {
            left: 0;
            transform: none;
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            .hero-section {
                padding: 3rem 0 2rem;
                min-height: auto;
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
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.6rem;
            }
            .hero-subtitle {
                font-size: 1rem;
            }
            .card-stat {
                padding: 1rem;
            }
            .card-feature {
                padding: 1.5rem 1rem;
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>