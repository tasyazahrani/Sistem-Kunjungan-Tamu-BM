@extends('layouts.guest')

@section('title', 'Isi Buku Tamu')

@section('content')
    <p class="text-muted small mb-4">
        Selamat datang. Mohon isi formulir kunjungan berikut dengan lengkap dan benar.
        Data Anda akan diverifikasi oleh petugas resepsionis sebelum kunjungan diproses.
    </p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('guest.store') }}">
        @csrf
        {{-- honeypot anti-spam, disembunyikan dari tamu --}}
        <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_tamu" class="form-control" value="{{ old('nama_tamu') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">No. HP / WhatsApp <span class="text-danger">*</span></label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Email (opsional)</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Jumlah Tamu <span class="text-danger">*</span></label>
                <input type="number" min="1" max="50" name="jumlah_tamu" class="form-control" value="{{ old('jumlah_tamu', 1) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Instansi / Asal</label>
                <select name="instansi_id" id="instansi_id" class="form-select">
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($instansis as $i)
                        <option value="{{ $i->id }}" {{ old('instansi_id') == $i->id ? 'selected' : '' }}>{{ $i->nama_instansi }}</option>
                    @endforeach
                    <option value="" data-lainnya="1">Lainnya (isi manual)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Sebutkan Instansi (jika "Lainnya")</label>
                <input type="text" name="instansi_lainnya" class="form-control" value="{{ old('instansi_lainnya') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Tujuan Kunjungan</label>
                <select name="tujuan_kunjungan_id" class="form-select">
                    <option value="">-- Pilih Tujuan --</option>
                    @foreach($tujuans as $t)
                        <option value="{{ $t->id }}" {{ old('tujuan_kunjungan_id') == $t->id ? 'selected' : '' }}>{{ $t->nama_tujuan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Sebutkan Tujuan Lainnya</label>
                <input type="text" name="tujuan_lainnya" class="form-control" value="{{ old('tujuan_lainnya') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Bidang / Bagian yang Dituju</label>
                <select name="bidang_id" class="form-select">
                    <option value="">-- Pilih Bidang --</option>
                    @foreach($bidangs as $b)
                        <option value="{{ $b->id }}" {{ old('bidang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_bidang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Pejabat yang Dituju</label>
                <input type="text" name="nama_pejabat_dituju" class="form-control" value="{{ old('nama_pejabat_dituju') }}">
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold small">Keperluan <span class="text-danger">*</span></label>
                <textarea name="keperluan" rows="3" class="form-control" required>{{ old('keperluan') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-4 py-2">
            <i class="bi bi-send"></i> Kirim Data Kunjungan
        </button>
    </form>
@endsection
