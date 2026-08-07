<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; }
        h2 { margin: 0 0 2px; font-size: 15px; }
        .sub { color:#555; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 4px 5px; text-align: left; word-wrap: break-word; }
        th { background: #0b3d2e; color: #fff; font-size: 9px; }
        tr:nth-child(even) { background: #f4f6f9; }
        .footer { margin-top: 20px; font-size: 10px; color: #555; }
        
        /* Pengaturan agar tabel muat */
        td, th {
            font-size: 8.5px; 
        }
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
            <th style="width: 4%;">No</th>
            <th style="width: 8%;">Kode</th>
            <th style="width: 10%;">Waktu</th>
            <th style="width: 13%;">Nama Tamu</th>
            <th style="width: 10%;">No. Telepon</th>
            <th style="width: 10%;">Email</th>
            <th style="width: 8%;">Pekerjaan/Jabatan</th>
            <th style="width: 10%;">Asal Instansi</th>
            <th style="width: 11%;">Maksud Kunjungan</th>
            <th style="width: 14%;">Bidang/Pejabat Tujuan</th>
        </tr>
        </thead>
        <tbody>
        @forelse($kunjungans as $i => $k)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $k->kode_kunjungan }}</td>
                <td>{{ optional($k->waktu_kunjungan)->format('d-m-Y H:i') }}</td>
                <td>{{ $k->nama_tamu }}</td>
                <td>{{ $k->no_hp ?? '-' }}</td>
                <td>{{ $k->email ?? '-' }}</td>
                <td>{{ $k->pekerjaan ?? '-' }}</td>
                <td>{{ $k->instansi->nama_instansi ?? $k->instansi_lainnya ?? '-' }}</td>
                <td>{{ $k->tujuanKunjungan->nama_tujuan ?? $k->tujuan_lainnya ?? '-' }}</td>
                <td>
                    {{ $k->bidang->nama_bidang ?? '-' }} 
                    @if($k->nama_pejabat_dituju)
                        <br><small>({{ $k->nama_pejabat_dituju }})</small>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="11" style="text-align:center;">Tidak ada data pada periode ini.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="footer">Total data: {{ $kunjungans->count() }} kunjungan.</div>
</body>
</html>