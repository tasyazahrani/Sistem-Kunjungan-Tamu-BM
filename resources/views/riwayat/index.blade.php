@extends('layouts.app')

@section('title', 'Riwayat Kunjungan')

@section('content')
    <h4 class="fw-bold mb-4">Riwayat Kunjungan</h4>

    <div class="card card-stat p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-2">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ $filters['tanggal_mulai'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="tanggal_akhir" class="form-control form-control-sm" value="{{ $filters['tanggal_akhir'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Instansi</label>
                <select name="instansi_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($instansis as $i)
                        <option value="{{ $i->id }}" {{ ($filters['instansi_id'] ?? '') == $i->id ? 'selected' : '' }}>{{ $i->nama_instansi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Tujuan</label>
                <select name="tujuan_kunjungan_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($tujuans as $t)
                        <option value="{{ $t->id }}" {{ ($filters['tujuan_kunjungan_id'] ?? '') == $t->id ? 'selected' : '' }}>{{ $t->nama_tujuan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($statusList as $key => $label)
                        <option value="{{ $key }}" {{ ($filters['status'] ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Cari</label>
                <input type="text" name="cari" class="form-control form-control-sm" value="{{ $filters['cari'] ?? '' }}" placeholder="Nama/Kode/HP">
            </div>
            <div class="col-12 mt-2">
                <button class="btn btn-sm btn-success"><i class="bi bi-search"></i> Terapkan Filter</button>
                <a href="{{ route('riwayat.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card card-stat p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                <tr><th>Kode</th><th>Waktu</th><th>Nama Tamu</th><th>Instansi</th><th>Tujuan</th><th>Bidang</th><th>Status</th></tr>
                </thead>
                <tbody>
                @forelse($kunjungans as $k)
                    <tr>
                        <td class="small">{{ $k->kode_kunjungan }}</td>
                        <td class="small">{{ $k->waktu_kunjungan->format('d-m-Y H:i') }}</td>
                        <td>{{ $k->nama_tamu }}</td>
                        <td class="small">{{ $k->nama_instansi }}</td>
                        <td class="small">{{ $k->nama_tujuan }}</td>
                        <td class="small">{{ $k->bidang->nama_bidang ?? '-' }}</td>
                        <td><span class="badge bg-{{ $k->status_color }} badge-status">{{ $k->status_label }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada riwayat kunjungan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $kunjungans->links() }}
    </div>
@endsection
