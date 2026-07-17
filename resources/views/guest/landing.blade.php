{{-- resources/views/guest/landing.blade.php --}}
@extends('layouts.guest')

@section('title', 'Beranda - SIMANTAP Bener Meriah')

@section('content')

{{-- ============================================ --}}
{{-- HERO SECTION                                 --}}
{{-- ============================================ --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">

            {{-- Kiri: Teks --}}
            <div class="col-lg-7">
                <span class="badge bg-light text-dark mb-3 px-4 py-2 rounded-pill">
                    <i class="bi bi-star-fill text-warning me-1"></i> Sistem Terpercaya
                </span>

                <h1 class="hero-title">
                    Sistem Monitoring <br>
                    <span>Kunjungan</span> Terpadu
                </h1>

                <p class="hero-subtitle my-4">
                    Pantau dan kelola kunjungan tamu secara real-time dengan
                    dashboard interaktif dan analitik lengkap.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">
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
                <div class="hero-stats d-flex flex-wrap gap-3">
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

            {{-- Kanan: Ilustrasi --}}
            <div class="col-lg-5 text-center">
                <div class="bg-white bg-opacity-10 rounded-4 p-5" style="backdrop-filter: blur(10px);">
                    <i class="bi bi-clipboard-data" style="font-size: 7rem; color: rgba(255,255,255,0.3);"></i>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- STATISTIK SECTION                           --}}
{{-- ============================================ --}}
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

{{-- ============================================ --}}
{{-- TREN SECTION                                --}}
{{-- ============================================ --}}
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

{{-- ============================================ --}}
{{-- FITUR SECTION                               --}}
{{-- ============================================ --}}
<section id="fitur" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Fitur Unggulan</h2>
            <p class="text-muted mt-3">Kemudahan dalam mengelola kunjungan tamu</p>
        </div>

        <div class="row g-4">
            {{-- Fitur 1 --}}
            <div class="col-lg-4 col-md-6">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-speedometer2"></i></div>
                    <h5>Dashboard Real-time</h5>
                    <p>Lihat statistik kunjungan secara langsung dengan grafik interaktif.</p>
                </div>
            </div>

            {{-- Fitur 2 --}}
            <div class="col-lg-4 col-md-6">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-qr-code"></i></div>
                    <h5>QR Code Check-in</h5>
                    <p>Scan QR code untuk akses cepat dan verifikasi otomatis.</p>
                </div>
            </div>

            {{-- Fitur 3 --}}
            <div class="col-lg-4 col-md-6">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-file-earmark-pdf"></i></div>
                    <h5>Ekspor Laporan</h5>
                    <p>Unduh laporan kunjungan dalam format PDF, Excel, atau CSV.</p>
                </div>
            </div>

            {{-- Fitur 4 --}}
            <div class="col-lg-4 col-md-6">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-bell"></i></div>
                    <h5>Notifikasi Otomatis</h5>
                    <p>Dapatkan notifikasi real-time setiap kunjungan baru.</p>
                </div>
            </div>

            {{-- Fitur 5 --}}
            <div class="col-lg-4 col-md-6">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-graph-up"></i></div>
                    <h5>Analitik Lengkap</h5>
                    <p>Analisis data dengan berbagai filter dan dimensi fleksibel.</p>
                </div>
            </div>

            {{-- Fitur 6 --}}
            <div class="col-lg-4 col-md-6">
                <div class="card-feature">
                    <div class="icon"><i class="bi bi-shield-check"></i></div>
                    <h5>Keamanan Terjamin</h5>
                    <p>Sistem aman dengan autentikasi dan otorisasi pengguna.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- CTA SECTION                                 --}}
{{-- ============================================ --}}
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
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush