@extends('layouts.app')

@section('title', 'QR Code Buku Tamu')

@section('content')
    <h4 class="fw-bold mb-4">QR Code Buku Tamu</h4>

    <div class="card card-stat p-4 text-center" style="max-width:480px;">
        <p class="text-muted small">
            Tayangkan atau cetak QR Code berikut di meja resepsionis. Tamu tinggal
            memindai kode ini dengan kamera HP untuk mengisi buku tamu secara
            mandiri.
        </p>

        <div class="d-flex justify-content-center my-3">
            {{-- Membutuhkan package simplesoftwareio/simple-qrcode --}}
            {!! QrCode::size(260)->generate($url) !!}
        </div>

        <div class="small text-muted mb-3">{{ $url }}</div>

        <button class="btn btn-success" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak QR Code
        </button>
    </div>

    <div class="alert alert-light border mt-4 small" style="max-width:480px;">
        <strong>Catatan:</strong> Fitur ini menggunakan package
        <code>simplesoftwareio/simple-qrcode</code>. Pastikan sudah terpasang
        via Composer dan facade <code>QrCode</code> ter-alias otomatis
        (package ini mendukung auto-discovery Laravel).
    </div>
@endsection
