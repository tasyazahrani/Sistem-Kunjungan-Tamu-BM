@extends('layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')
    <h4 class="fw-bold mb-4">Dashboard Monitoring Kunjungan</h4>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Kunjungan Hari Ini</div>
                <div class="fs-3 fw-bold text-success">{{ $hariIni }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Minggu Ini</div>
                <div class="fs-3 fw-bold text-primary">{{ $mingguIni }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Bulan Ini</div>
                <div class="fs-3 fw-bold text-info">{{ $bulanIni }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Tahun Ini</div>
                <div class="fs-3 fw-bold text-dark">{{ $tahunIni }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card card-stat p-3 d-flex flex-row justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Menunggu Verifikasi</div>
                    <div class="fs-4 fw-bold text-warning">{{ $menungguVerifikasi }}</div>
                </div>
                <i class="bi bi-hourglass-split text-warning" style="font-size:2rem;"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stat p-3 d-flex flex-row justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Sedang Berkunjung</div>
                    <div class="fs-4 fw-bold text-primary">{{ $sedangBerkunjung }}</div>
                </div>
                <i class="bi bi-person-walking text-primary" style="font-size:2rem;"></i>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Tren Kunjungan 14 Hari Terakhir</div>
                <canvas id="chartTren" height="90"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Kunjungan Berdasarkan Status</div>
                <canvas id="chartStatus" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Kunjungan per Instansi</div>
                <canvas id="chartInstansi"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Kunjungan per Tujuan</div>
                <canvas id="chartTujuan"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Kunjungan per Bidang</div>
                <canvas id="chartBidang"></canvas>
            </div>
        </div>
    </div>

    <div class="card card-stat p-3">
        <div class="fw-semibold mb-3">Kunjungan Terbaru</div>
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead><tr><th>Waktu</th><th>Nama Tamu</th><th>Instansi</th><th>Tujuan</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($kunjunganTerbaru as $k)
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
const trenLabels = {!! json_encode($trenHarian->pluck('tanggal')) !!};
const trenData = {!! json_encode($trenHarian->pluck('jumlah')) !!};

new Chart(document.getElementById('chartTren'), {
    type: 'line',
    data: { labels: trenLabels, datasets: [{ label: 'Jumlah Kunjungan', data: trenData, borderColor:'#0b3d2e', backgroundColor:'rgba(11,61,46,.1)', fill:true, tension:.3 }] },
    options: { plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, ticks:{stepSize:1}}} }
});

const statusLabels = {!! json_encode($perStatus->map(fn($s) => \App\Models\Kunjungan::STATUS_LABELS[$s->status] ?? $s->status)) !!};
const statusData = {!! json_encode($perStatus->pluck('total')) !!};
new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: { labels: statusLabels, datasets: [{ data: statusData, backgroundColor:['#ffc107','#0dcaf0','#0d6efd','#198754','#dc3545'] }] },
});

function barChart(id, labels, data, color) {
    new Chart(document.getElementById(id), {
        type: 'bar',
        data: { labels: labels, datasets: [{ label:'Jumlah', data: data, backgroundColor: color }] },
        options: { indexAxis:'y', plugins:{legend:{display:false}}, scales:{x:{beginAtZero:true, ticks:{stepSize:1}}} }
    });
}
barChart('chartInstansi', {!! json_encode($perInstansi->pluck('label')) !!}, {!! json_encode($perInstansi->pluck('total')) !!}, '#145c44');
barChart('chartTujuan', {!! json_encode($perTujuan->pluck('label')) !!}, {!! json_encode($perTujuan->pluck('total')) !!}, '#0d6efd');
barChart('chartBidang', {!! json_encode($perBidang->pluck('label')) !!}, {!! json_encode($perBidang->pluck('total')) !!}, '#fd7e14');
</script>
@endpush
