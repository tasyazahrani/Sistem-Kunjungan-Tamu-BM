@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <h4 class="fw-bold mb-4">Tambah Pengguna</h4>

    <div class="card card-stat p-4" style="max-width:560px;">
        @if($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
                    <option value="petugas" {{ old('role')=='petugas'?'selected':'' }}>Petugas</option>
                    <option value="pimpinan" {{ old('role')=='pimpinan'?'selected':'' }}>Pimpinan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
@endsection
