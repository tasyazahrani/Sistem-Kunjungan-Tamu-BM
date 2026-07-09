@extends('layouts.guest')

@section('title', 'Terima Kasih')

@section('content')
    <div class="text-center py-3">
        <i class="bi bi-check-circle-fill text-success" style="font-size:3.5rem;"></i>
        <h5 class="fw-bold mt-3">Data Kunjungan Berhasil Dikirim</h5>
        <p class="text-muted small">
            Terima kasih. Data Anda sedang menunggu verifikasi dari petugas.
            Silakan tunggu di ruang tunggu, petugas akan memanggil Anda.
        </p>

        @if($kunjungan)
            <div class="border rounded p-3 bg-light text-start small mt-3">
                <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                    <span class="text-muted">Kode Kunjungan</span>
                    <strong>{{ $kunjungan->kode_kunjungan }}</strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                    <span class="text-muted">Nama</span>
                    <strong>{{ $kunjungan->nama_tamu }}</strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                    <span class="text-muted">No. HP</span>
                    <strong>{{ $kunjungan->no_hp }}</strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                    <span class="text-muted">Jumlah Tamu</span>
                    <strong>{{ $kunjungan->jumlah_tamu }} orang</strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                    <span class="text-muted">Instansi</span>
                    <strong>{{ $kunjungan->nama_instansi }}</strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                    <span class="text-muted">Tujuan</span>
                    <strong>{{ $kunjungan->nama_tujuan }}</strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                    <span class="text-muted">Bidang</span>
                    <strong>{{ $kunjungan->nama_bidang }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Status</span>
                    <span class="badge bg-{{ $kunjungan->status_color }}">
                        {{ $kunjungan->status_label }}
                    </span>
                </div>
            </div>
        @endif

        <a href="{{ route('guest.form') }}" class="btn btn-outline-success mt-4">
            <i class="bi bi-plus-circle"></i> Isi Kunjungan Baru
        </a>
    </div>
@endsection