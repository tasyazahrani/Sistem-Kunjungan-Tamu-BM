@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <h4 class="fw-bold mb-4">Edit Pengguna — {{ $user->name }}</h4>

    <div class="card card-stat p-4" style="max-width:560px;">
        @if($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label small fw-semibold">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                    <option value="petugas" {{ $user->role=='petugas'?'selected':'' }}>Petugas</option>
                    <option value="pimpinan" {{ $user->role=='pimpinan'?'selected':'' }}>Pimpinan</option>
                </select>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="aktif" value="1" class="form-check-input" id="aktif" {{ $user->aktif ? 'checked' : '' }}>
                <label class="form-check-label small" for="aktif">Akun Aktif</label>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Kata Sandi Baru (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
@endsection
