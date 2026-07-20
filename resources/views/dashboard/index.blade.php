@extends('layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')
    <h4 class="fw-bold mb-4">Dashboard Monitoring Kunjungan</h4>

    {{-- STATISTIK CARD --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Kunjungan Hari Ini</div>
                <div class="fs-3 fw-bold text-success">{{ $hariIni ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Minggu Ini</div>
                <div class="fs-3 fw-bold text-primary">{{ $mingguIni ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Bulan Ini</div>
                <div class="fs-3 fw-bold text-info">{{ $bulanIni ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Tahun Ini</div>
                <div class="fs-3 fw-bold text-dark">{{ $tahunIni ?? 0 }}</div>
            </div>
        </div>
    </div>

    {{-- STATUS CARD --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card card-stat p-3 d-flex flex-row justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Menunggu Verifikasi</div>
                    <div class="fs-4 fw-bold text-warning">{{ $menungguVerifikasi ?? 0 }}</div>
                </div>
                <i class="bi bi-hourglass-split text-warning" style="font-size:2rem;"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stat p-3 d-flex flex-row justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Sedang Berkunjung</div>
                    <div class="fs-4 fw-bold text-primary">{{ $sedangBerkunjung ?? 0 }}</div>
                </div>
                <i class="bi bi-person-walking text-primary" style="font-size:2rem;"></i>
            </div>
        </div>
    </div>

    {{-- GRAFIK TREN & STATUS --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card card-stat p-3 h-100">
                <div class="fw-semibold mb-2">Tren Kunjungan 14 Hari Terakhir</div>
                <div class="chart-wrapper-tall">
                    <canvas id="chartTren"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-stat p-3 h-100">
                <div class="fw-semibold mb-2">Kunjungan Berdasarkan Status</div>
                <div class="chart-wrapper">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK BAR --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card card-stat p-3 h-100">
                <div class="fw-semibold mb-2">Kunjungan per Instansi</div>
                <div class="chart-wrapper">
                    <canvas id="chartInstansi"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-stat p-3 h-100">
                <div class="fw-semibold mb-2">Kunjungan per Tujuan</div>
                <div class="chart-wrapper">
                    <canvas id="chartTujuan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-stat p-3 h-100">
                <div class="fw-semibold mb-2">Kunjungan per Bidang</div>
                <div class="chart-wrapper">
                    <canvas id="chartBidang"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL KUNJUNGAN TERBARU --}}
    <div class="card card-stat p-3">
        <div class="fw-semibold mb-3">Kunjungan Terbaru</div>
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Nama Tamu</th>
                        <th>Instansi</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($kunjunganTerbaru ?? [] as $k)
                    <tr>
                        <td class="small">{{ $k->waktu_kunjungan->format('d-m-Y H:i') }}</td>
                        <td>{{ $k->nama_tamu }}</td>
                        <td class="small">{{ $k->nama_instansi }}</td>
                        <td class="small">{{ $k->nama_tujuan }}</td>
                        <td><span class="badge bg-{{ $k->status_color }} badge-status">{{ $k->status_label }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data kunjungan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // 1. GRAFIK TREN KUNJUNGAN 14 HARI
    // =============================================
    const trenLabels = {!! json_encode($trenHarian->pluck('tanggal') ?? []) !!};
    const trenData = {!! json_encode($trenHarian->pluck('jumlah') ?? []) !!};

    if (trenLabels.length > 0 && document.getElementById('chartTren')) {
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: trenLabels,
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: trenData,
                    borderColor: '#0b3d2e',
                    backgroundColor: 'rgba(11,61,46,0.1)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#0b3d2e',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1.5,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            font: { size: 10 }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 9 },
                            maxRotation: 45,
                            minRotation: 0
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

    // =============================================
    // 2. GRAFIK KUNJUNGAN BERDASARKAN STATUS
    // =============================================
    const statusLabels = {!! json_encode($perStatus->map(fn($s) => \App\Models\Kunjungan::STATUS_LABELS[$s->status] ?? $s->status) ?? []) !!};
    const statusData = {!! json_encode($perStatus->pluck('total') ?? []) !!};

    if (statusLabels.length > 0 && document.getElementById('chartStatus')) {
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#ffc107', '#0dcaf0', '#0d6efd', '#198754', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 10 }
                        }
                    }
                },
                cutout: '55%'
            }
        });
    }

    // =============================================
    // 3. GRAFIK BAR (Instansi, Tujuan, Bidang)
    // =============================================
    function barChart(id, labels, data, color) {
        const canvas = document.getElementById(id);
        if (!canvas) return;
        
        if (!labels || labels.length === 0) {
            canvas.parentElement.innerHTML = '<p class="text-muted text-center small mt-3">Belum ada data</p>';
            return;
        }

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah',
                    data: data,
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 8,
                        cornerRadius: 6
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            font: { size: 9 }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 9 }
                        }
                    }
                }
            }
        });
    }

    // Panggil fungsi bar chart
    barChart('chartInstansi', 
        {!! json_encode($perInstansi->pluck('label') ?? []) !!}, 
        {!! json_encode($perInstansi->pluck('total') ?? []) !!}, 
        '#145c44'
    );
    
    barChart('chartTujuan', 
        {!! json_encode($perTujuan->pluck('label') ?? []) !!}, 
        {!! json_encode($perTujuan->pluck('total') ?? []) !!}, 
        '#0d6efd'
    );
    
    barChart('chartBidang', 
        {!! json_encode($perBidang->pluck('label') ?? []) !!}, 
        {!! json_encode($perBidang->pluck('total') ?? []) !!}, 
        '#fd7e14'
    );
});
</script>
@endpush