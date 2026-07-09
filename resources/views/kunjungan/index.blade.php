@extends('layouts.app')

@section('title', 'Verifikasi Kunjungan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Verifikasi & Kelola Kunjungan</h4>
        <a href="{{ route('kunjungan.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i> Input Manual
        </a>
    </div>

    {{-- Filter --}}
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
                <label class="form-label small">Cari Nama/Kode/HP</label>
                <input type="text" name="cari" class="form-control form-control-sm" value="{{ $filters['cari'] ?? '' }}">
            </div>
            <div class="col-12 mt-2">
                <button class="btn btn-sm btn-success"><i class="bi bi-search"></i> Terapkan Filter</button>
                <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card card-stat p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                <tr>
                    <th>Kode</th><th>Waktu</th><th>Nama Tamu</th><th>Instansi</th><th>Tujuan</th><th>Status</th><th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($kunjungans as $k)
                    <tr>
                        <td class="small">{{ $k->kode_kunjungan }}</td>
                        <td class="small">{{ $k->waktu_kunjungan->format('d-m-Y H:i') }}</td>
                        <td>{{ $k->nama_tamu }} @if($k->input_manual)<span class="badge bg-secondary">manual</span>@endif</td>
                        <td class="small">{{ $k->nama_instansi }}</td>
                        <td class="small">{{ $k->nama_tujuan }}</td>
                        <td><span class="badge bg-{{ $k->status_color }} badge-status">{{ $k->status_label }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#verifModal{{ $k->id }}" title="Verifikasi">
                                    <i class="bi bi-check2-square"></i>
                                </button>
                                <a href="{{ route('kunjungan.edit', $k) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('kunjungan.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus data kunjungan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Modal Verifikasi --}}
                    <div class="modal fade" id="verifModal{{ $k->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('kunjungan.verifikasi', $k) }}" class="modal-content">
                                @csrf @method('PATCH')
                                <div class="modal-header">
                                    <h6 class="modal-title">Verifikasi: {{ $k->nama_tamu }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small text-muted">
                                        Kode: {{ $k->kode_kunjungan }}<br>
                                        Keperluan: {{ $k->keperluan }}
                                    </p>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Status</label>
                                        <select name="status" class="form-select" required>
                                            @foreach($statusList as $key => $label)
                                                <option value="{{ $key }}" {{ $k->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Catatan Petugas (opsional)</label>
                                        <textarea name="catatan_petugas" class="form-control" rows="2">{{ $k->catatan_petugas }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data kunjungan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $kunjungans->links() }}
    </div>
@endsection
