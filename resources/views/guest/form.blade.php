@extends('layouts.guest')

@section('title', 'Isi Buku Tamu - SIMANTAP Bener Meriah')

@section('content')
<div class="px-2 px-sm-3 px-md-4 pt-2 pt-sm-3 pt-md-4">
    {{-- Header --}}
    <div class="text-center mb-4 pb-3">
        <h4 class="fw-bold mb-2" style="color: var(--primary);">
            <i class="bi bi-book me-2"></i>Isi Buku Tamu
        </h4>
        <p class="text-muted small mb-0" style="max-width: 480px; margin: 0 auto; line-height: 1.5;">
            Mohon isi formulir kunjungan dengan lengkap dan benar.
            Data Anda akan diverifikasi oleh petugas resepsionis.
        </p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1 ps-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('guest.store') }}" class="needs-validation" novalidate>
        @csrf
        {{-- Honeypot anti-spam --}}
        <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">

        <div class="row g-3">
            {{-- Nama Lengkap --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input type="text" name="nama_tamu" class="form-control" 
                       value="{{ old('nama_tamu') }}" placeholder="Masukkan nama lengkap" required>
            </div>

            {{-- No HP --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    No. HP / WhatsApp <span class="text-danger">*</span>
                </label>
                <input type="text" name="no_hp" class="form-control" 
                       value="{{ old('no_hp') }}" placeholder="Contoh: 0812-3456-7890" required>
            </div>

            {{-- Email --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Email <span class="text-muted">(opsional)</span>
                </label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email') }}" placeholder="email@domain.com">
            </div>

            {{-- Jumlah Tamu --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Jumlah Tamu <span class="text-danger">*</span>
                </label>
                <input type="number" min="1" max="50" name="jumlah_tamu" class="form-control" 
                       value="{{ old('jumlah_tamu', 1) }}" required>
            </div>

            {{-- Instansi --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Instansi / Asal
                </label>
                <select name="instansi_id" id="instansi_id" class="form-select">
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($instansis as $i)
                        <option value="{{ $i->id }}" {{ old('instansi_id') == $i->id ? 'selected' : '' }}>
                            {{ $i->nama_instansi }}
                        </option>
                    @endforeach
                    <option value="" data-lainnya="1">Lainnya (isi manual)</option>
                </select>
            </div>

            {{-- Instansi Lainnya --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Instansi Lainnya <span class="text-muted">(jika pilih "Lainnya")</span>
                </label>
                <input type="text" name="instansi_lainnya" class="form-control" 
                       value="{{ old('instansi_lainnya') }}" placeholder="Sebutkan instansi Anda">
            </div>

            {{-- Tujuan Kunjungan --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Tujuan Kunjungan
                </label>
                <select name="tujuan_kunjungan_id" class="form-select">
                    <option value="">-- Pilih Tujuan --</option>
                    @foreach($tujuans as $t)
                        <option value="{{ $t->id }}" {{ old('tujuan_kunjungan_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->nama_tujuan }}
                        </option>
                    @endforeach
                    <option value="" data-lainnya="1">Lainnya</option>
                </select>
            </div>

            {{-- Tujuan Lainnya --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Tujuan Lainnya <span class="text-muted">(jika pilih "Lainnya")</span>
                </label>
                <input type="text" name="tujuan_lainnya" class="form-control" 
                       value="{{ old('tujuan_lainnya') }}" placeholder="Sebutkan tujuan kunjungan">
            </div>

            {{-- Bidang --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Bidang / Bagian yang Dituju
                </label>
                <select name="bidang_id" class="form-select">
                    <option value="">-- Pilih Bidang --</option>
                    @foreach($bidangs as $b)
                        <option value="{{ $b->id }}" {{ old('bidang_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_bidang }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Pejabat --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold small">
                    Nama Pejabat yang Dituju
                </label>
                <input type="text" name="nama_pejabat_dituju" class="form-control" 
                       value="{{ old('nama_pejabat_dituju') }}" placeholder="Nama pejabat/pegawai">
            </div>

            {{-- Keperluan --}}
            <div class="col-12">
                <label class="form-label fw-semibold small">
                    Keperluan / Detail Kunjungan <span class="text-danger">*</span>
                </label>
                <textarea name="keperluan" rows="3" class="form-control" 
                          placeholder="Jelaskan keperluan kunjungan Anda" required>{{ old('keperluan') }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="col-12 mt-2">
                <div class="d-flex flex-wrap gap-2 justify-content-end">
                    <button type="reset" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-success px-5">
                        <i class="bi bi-send me-2"></i>Kirim
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Footer Info --}}
    <div class="text-center mt-4 pt-3 border-top">
        <small class="text-muted">
            <i class="bi bi-shield-check me-1"></i>
            Data Anda aman untuk keperluan administrasi kunjungan.
        </small>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle untuk instansi lainnya
        const instansiSelect = document.getElementById('instansi_id');
        const instansiLainnya = document.querySelector('input[name="instansi_lainnya"]');
        
        if (instansiSelect && instansiLainnya) {
            instansiSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.dataset.lainnya === '1') {
                    instansiLainnya.style.display = 'block';
                } else {
                    instansiLainnya.style.display = 'block';
                }
            });
        }
    });
</script>
@endpush