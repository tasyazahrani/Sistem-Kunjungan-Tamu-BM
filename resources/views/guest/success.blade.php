@extends('layouts.guest')

@section('title', 'Terima Kasih - SIMANTAP Bener Meriah')

@section('content')
<div class="px-3 px-sm-4 px-md-5 py-3">
    <div class="text-center mb-4">
        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" 
             style="width: 80px; height: 80px;">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
        </div>
        <h4 class="fw-bold mt-3 mb-2" style="color: var(--primary);">
            Data Kunjungan Berhasil Dikirim
        </h4>
        <p class="text-muted small mb-0" style="max-width: 450px; margin: 0 auto; line-height: 1.6;">
            Terima kasih. Data Anda sedang menunggu verifikasi dari petugas.
            Silakan tunggu di ruang tunggu, petugas akan memanggil Anda.
        </p>
    </div>

    @if($kunjungan)
        <div class="border rounded-3 p-3 p-sm-4 bg-light" style="max-width: 600px; margin: 0 auto;">
            <div class="row g-2">
                {{-- Kode Kunjungan --}}
                <div class="col-5 text-muted small">Kode Kunjungan</div>
                <div class="col-7 text-end fw-semibold">{{ $kunjungan->kode_kunjungan }}</div>

                {{-- Nama --}}
                <div class="col-5 text-muted small">Nama</div>
                <div class="col-7 text-end">{{ $kunjungan->nama_tamu }}</div>

                {{-- No HP --}}
                <div class="col-5 text-muted small">No. HP</div>
                <div class="col-7 text-end">{{ $kunjungan->no_hp }}</div>

                {{-- Jumlah Tamu --}}
                <div class="col-5 text-muted small">Jumlah Tamu</div>
                <div class="col-7 text-end">{{ $kunjungan->jumlah_tamu }} orang</div>

                {{-- Instansi --}}
                <div class="col-5 text-muted small">Instansi</div>
                <div class="col-7 text-end">{{ $kunjungan->nama_instansi }}</div>

                {{-- Tujuan --}}
                <div class="col-5 text-muted small">Tujuan</div>
                <div class="col-7 text-end">{{ $kunjungan->nama_tujuan }}</div>

                {{-- Bidang --}}
                <div class="col-5 text-muted small">Bidang</div>
                <div class="col-7 text-end">{{ $kunjungan->nama_bidang }}</div>

                {{-- Status --}}
                <div class="col-5 text-muted small">Status</div>
                <div class="col-7 text-end">
                    <span class="badge bg-{{ $kunjungan->status_color }} badge-status">
                        {{ $kunjungan->status_label }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('guest.form') }}" class="btn btn-success px-4 py-2">
            <i class="bi bi-plus-circle me-2"></i>Isi Kunjungan Baru
        </a>
    </div>
</div>
@endsection