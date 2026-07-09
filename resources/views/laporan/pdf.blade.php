<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; }
        h2 { margin: 0 0 2px; font-size: 15px; }
        .sub { color:#555; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 5px 6px; text-align: left; }
        th { background: #0b3d2e; color: #fff; }
        tr:nth-child(even) { background: #f4f6f9; }
        .footer { margin-top: 20px; font-size: 10px; color: #555; }
    </style>
</head>
<body>
    <h2>Laporan Kunjungan Tamu</h2>
    <div class="sub">
        Sekretariat Daerah Kabupaten Bener Meriah<br>
        Dicetak oleh: {{ $dicetakOleh->name ?? '-' }} | Tanggal cetak: {{ $tanggalCetak->format('d-m-Y H:i') }}<br>
        Periode: {{ $filters['tanggal_mulai'] ?? 'Semua' }} s/d {{ $filters['tanggal_akhir'] ?? 'Semua' }}
    </div>

    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Waktu</th>
            <th>Nama Tamu</th>
            <th>Instansi</th>
            <th>Tujuan</th>
            <th>Bidang</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @forelse($kunjungans as $i => $k)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $k->kode_kunjungan }}</td>
                <td>{{ optional($k->waktu_kunjungan)->format('d-m-Y H:i') }}</td>
                <td>{{ $k->nama_tamu }}</td>
                <td>{{ $k->nama_instansi }}</td>
                <td>{{ $k->nama_tujuan }}</td>
                <td>{{ $k->bidang->nama_bidang ?? '-' }}</td>
                <td>{{ $k->status_label }}</td>
            </tr>
        @empty
            <tr><td colspan="8" style="text-align:center;">Tidak ada data pada periode ini.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="footer">Total data: {{ $kunjungans->count() }} kunjungan.</div>
</body>
</html>
