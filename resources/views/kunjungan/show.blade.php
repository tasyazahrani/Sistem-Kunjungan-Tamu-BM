@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
    <h4 class="fw-bold mb-4">Detail Kunjungan — {{ $kunjungan->kode_kunjungan }}</h4>

    <div class="card card-stat p-4" style="max-width:700px;">
        <table class="table table-sm table-borderless mb-0">
            <tr><td class="text-muted" width="220">Nama Tamu</td><td>{{ $kunjungan->nama_tamu }}</td></tr>
            <tr><td class="text-muted">No. HP</td><td>{{ $kunjungan->no_hp }}</td></tr>
            <tr><td class="text-muted">Email</td><td>{{ $kunjungan->email ?: '-' }}</td></tr>
            <tr><td class="text-muted">Instansi</td><td>{{ $kunjungan->nama_instansi }}</td></tr>
            <tr><td class="text-muted">Jumlah Tamu</td><td>{{ $kunjungan->jumlah_tamu }}</td></tr>
            <tr><td class="text-muted">Tujuan</td><td>{{ $kunjungan->nama_tujuan }}</td></tr>
            <tr><td class="text-muted">Bidang</td><td>{{ $kunjungan->bidang->nama_bidang ?? '-' }}</td></tr>
            <tr><td class="text-muted">Pejabat Dituju</td><td>{{ $kunjungan->nama_pejabat_dituju ?: '-' }}</td></tr>
            <tr><td class="text-muted">Keperluan</td><td>{{ $kunjungan->keperluan }}</td></tr>
            <tr><td class="text-muted">Status</td><td><span class="badge bg-{{ $kunjungan->status_color }}">{{ $kunjungan->status_label }}</span></td></tr>
            <tr><td class="text-muted">Catatan Petugas</td><td>{{ $kunjungan->catatan_petugas ?: '-' }}</td></tr>
            <tr><td class="text-muted">Waktu Kunjungan</td><td>{{ $kunjungan->waktu_kunjungan->format('d-m-Y H:i') }}</td></tr>
            <tr><td class="text-muted">Diverifikasi Oleh</td><td>{{ $kunjungan->petugasVerifikasi->name ?? '-' }}</td></tr>
            <tr><td class="text-muted">Diinput Manual</td><td>{{ $kunjungan->input_manual ? 'Ya, oleh '.($kunjungan->petugasInput->name ?? '-') : 'Tidak (self check-in)' }}</td></tr>
        </table>
    </div>

    <a href="{{ route('kunjungan.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
@endsection
