@extends('layouts.app')

@section('title', 'Data Master')

@section('content')
    <h4 class="fw-bold mb-4">Kelola Data Master</h4>

    <div class="row g-3">
        {{-- Instansi --}}
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Instansi</div>
                <form action="{{ route('master.instansi.store') }}" method="POST" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="nama_instansi" class="form-control form-control-sm" placeholder="Nama instansi baru" required>
                    <button class="btn btn-sm btn-success"><i class="bi bi-plus"></i></button>
                </form>
                <ul class="list-group list-group-flush">
                    @foreach($instansis as $i)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="small {{ !$i->aktif ? 'text-muted text-decoration-line-through' : '' }}">{{ $i->nama_instansi }}</span>
                            <div class="d-flex gap-1">
                                <form action="{{ route('master.instansi.toggle', $i) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-secondary">{{ $i->aktif ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                </form>
                                <form action="{{ route('master.instansi.destroy', $i) }}" method="POST" onsubmit="return confirm('Hapus instansi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Tujuan --}}
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Tujuan Kunjungan</div>
                <form action="{{ route('master.tujuan.store') }}" method="POST" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="nama_tujuan" class="form-control form-control-sm" placeholder="Tujuan baru" required>
                    <button class="btn btn-sm btn-success"><i class="bi bi-plus"></i></button>
                </form>
                <ul class="list-group list-group-flush">
                    @foreach($tujuans as $t)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="small {{ !$t->aktif ? 'text-muted text-decoration-line-through' : '' }}">{{ $t->nama_tujuan }}</span>
                            <div class="d-flex gap-1">
                                <form action="{{ route('master.tujuan.toggle', $t) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-secondary">{{ $t->aktif ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                </form>
                                <form action="{{ route('master.tujuan.destroy', $t) }}" method="POST" onsubmit="return confirm('Hapus tujuan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Bidang --}}
        <div class="col-lg-4">
            <div class="card card-stat p-3">
                <div class="fw-semibold mb-2">Bidang / Bagian</div>
                <form action="{{ route('master.bidang.store') }}" method="POST" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="nama_bidang" class="form-control form-control-sm" placeholder="Bidang baru" required>
                    <button class="btn btn-sm btn-success"><i class="bi bi-plus"></i></button>
                </form>
                <ul class="list-group list-group-flush">
                    @foreach($bidangs as $b)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="small {{ !$b->aktif ? 'text-muted text-decoration-line-through' : '' }}">{{ $b->nama_bidang }}</span>
                            <div class="d-flex gap-1">
                                <form action="{{ route('master.bidang.toggle', $b) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-secondary">{{ $b->aktif ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                </form>
                                <form action="{{ route('master.bidang.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus bidang ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
