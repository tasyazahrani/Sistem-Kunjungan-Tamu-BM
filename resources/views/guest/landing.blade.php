{{-- resources/views/guest/landing.blade.php --}}
@extends('layouts.guest')

@section('title', 'Beranda - SIMANTAP Bener Meriah')

@section('content')

{{-- HERO SECTION WITH VIDEO BACKGROUND          --}}
<section class="hero-video">
    {{-- Video Background - TANPA WATERMARK --}}
    <div class="hero-video-wrapper">
        <video class="hero-video-bg" autoplay muted loop playsinline>
            {{-- Ganti 'hero-bg.mp4' dengan nama file video Anda --}}
            <source src="{{ asset('videos/hero-bg.mp4') }}" type="video/mp4">
            <source src="{{ asset('videos/hero-bg.webm') }}" type="video/webm">
            {{-- Fallback jika video tidak bisa diputar --}}
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Background" style="width:100%;height:100%;object-fit:cover;">
        </video>
    </div>

    {{-- Konten --}}
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center fade-in-up">

                <span class="badge bg-light text-dark mb-3 px-4 py-2 rounded-pill" style="font-weight: 600;">
                    <i class="bi bi-star-fill text-warning me-1"></i> Sistem Terpercaya
                </span>

                <h1 class="hero-title">
                    Sistem Monitoring <br>
                    <span>Kunjungan Tamu</span> Terpadu
                </h1>

                <p class="hero-subtitle mx-auto my-4" style="max-width: 600px;">
                    Pantau dan kelola kunjungan tamu secara real-time dengan
                    dashboard interaktif dan analitik lengkap.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center mb-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 fw-semibold">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('guest.form') }}" class="btn btn-light btn-lg px-5 fw-semibold">
                            <i class="bi bi-book me-2"></i>Buku Tamu
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </a>
                    @endauth
                </div>

                {{-- Stats --}}
                <div class="hero-stats d-flex flex-wrap gap-3 justify-content-center">
                    <div class="stat-item">
                        <div class="number">{{ $totalKunjungan ?? 0 }}</div>
                        <div class="label">Total Kunjungan</div>
                    </div>
                    <div class="stat-item">
                        <div class="number">{{ $totalInstansi ?? 0 }}</div>
                        <div class="label">Instansi</div>
                    </div>
                    <div class="stat-item">
                        <div class="number">{{ $hariIni ?? 0 }}</div>
                        <div class="label">Hari Ini</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- STATISTIK SECTION                           --}}
<section id="statistik" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Statistik Kunjungan</h2>
            <p class="text-muted mt-3">Data kunjungan terkini dari sistem</p>
        </div>

        <div class="row g-4">
            {{-- Card 1: Total Kunjungan --}}
            <div class="col-lg-3 col-md-6 col-6">
                <div class="card-stat">
                    <div class="icon" style="background: rgba(25, 135, 84, 0.1); color: #198754;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="number" style="color: #198754;">{{ number_format($totalKunjungan ?? 0) }}</div>
                    <div class="label">Total Kunjungan</div>
                </div>
            </div>

            {{-- Card 2: Instansi --}}
            <div class="col-lg-3 col-md-6 col-6">
                <div class="card-stat">
                    <div class="icon" style="background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="number" style="color: #0d6efd;">{{ number_format($totalInstansi ?? 0) }}</div>
                    <div class="label">Instansi Terdaftar</div>
                </div>
            </div>

            {{-- Card 3: Hari Ini --}}
            <div class="col-lg-3 col-md-6 col-6">
                <div class="card-stat">
                    <div class="icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div class="number" style="color: #ffc107;">{{ number_format($hariIni ?? 0) }}</div>
                    <div class="label">Kunjungan Hari Ini</div>
                </div>
            </div>

            {{-- Card 4: Rating --}}
            <div class="col-lg-3 col-md-6 col-6">
                <div class="card-stat">
                    <div class="icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="number" style="color: #dc3545;">{{ number_format($ratingRata ?? 0, 1) }}</div>
                    <div class="label">Rating Kepuasan</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TREN SECTION                                --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h3 class="fw-bold">Tren Kunjungan</h3>
                <p class="text-muted">Grafik 7 hari terakhir untuk memantau aktivitas.</p>
                <div class="d-flex gap-3 mt-3 flex-wrap">
                    <div class="bg-white rounded-3 px-4 py-2 shadow-sm">
                        <div class="fw-bold fs-4 text-success">+{{ $persentaseNaik ?? 0 }}%</div>
                        <div class="small text-muted">Dibanding minggu lalu</div>
                    </div>
                    <div class="bg-white rounded-3 px-4 py-2 shadow-sm">
                        <div class="fw-bold fs-4 text-primary">{{ $rataRataHarian ?? 0 }}</div>
                        <div class="small text-muted">Rata-rata per hari</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <canvas id="chartTrenLanding" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FITUR SECTION                               --}}
<section id="fitur" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Fitur Unggulan</h2>
            <p class="text-muted mt-3">Kemudahan dalam mengelola kunjungan tamu</p>
        </div>

        <div class="row g-4">
            @php
                $features = [
                    ['icon' => 'speedometer2', 'title' => 'Dashboard Real-time', 'desc' => 'Lihat statistik kunjungan secara langsung dengan grafik interaktif dan visualisasi data.'],
                    ['icon' => 'qr-code', 'title' => 'QR Code Check-in', 'desc' => 'Scan QR code untuk akses cepat dan verifikasi kunjungan secara otomatis.'],
                    ['icon' => 'file-earmark-pdf', 'title' => 'Ekspor Laporan', 'desc' => 'Unduh laporan kunjungan dalam format PDF, Excel, atau CSV dengan mudah.'],
                    ['icon' => 'bell', 'title' => 'Notifikasi Otomatis', 'desc' => 'Dapatkan notifikasi real-time untuk setiap kunjungan baru atau perubahan status.'],
                    ['icon' => 'graph-up', 'title' => 'Analitik Lengkap', 'desc' => 'Analisis data kunjungan dengan berbagai filter dan dimensi yang fleksibel.'],
                    ['icon' => 'shield-check', 'title' => 'Keamanan Terjamin', 'desc' => 'Sistem aman dengan autentikasi dan otorisasi untuk setiap pengguna.'],
                ];
            @endphp

            @foreach ($features as $feature)
                <div class="col-lg-4 col-md-6">
                    <div class="card-feature">
                        <div class="icon"><i class="bi bi-{{ $feature['icon'] }}"></i></div>
                        <h5>{{ $feature['title'] }}</h5>
                        <p>{{ $feature['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA SECTION                                 --}}
<section class="cta-section">
    <div class="container">
        <h2>Siap Memantau Kunjungan Anda?</h2>
        <p class="mb-4">Bergabung sekarang dan nikmati kemudahan sistem monitoring terpadu.</p>

        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 fw-semibold">
                <i class="bi bi-speedometer2 me-2"></i>Buka Dashboard
            </a>
        @else
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('guest.form') }}" class="btn btn-light btn-lg px-5 fw-semibold">
                    <i class="bi bi-book me-2"></i>Buku Tamu
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </a>
            </div>
        @endauth
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart untuk tren kunjungan
        const labels = {!! json_encode($trenLanding->pluck('tanggal') ?? []) !!};
        const data = {!! json_encode($trenLanding->pluck('jumlah') ?? []) !!};

        if (labels.length > 0 && document.getElementById('chartTrenLanding')) {
            new Chart(document.getElementById('chartTrenLanding'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kunjungan',
                        data: data,
                        borderColor: '#0b3d2e',
                        backgroundColor: 'rgba(11,61,46,0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0b3d2e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                stepSize: 1,
                                font: { size: 11 }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11 }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }
    });
</script>
@endpush