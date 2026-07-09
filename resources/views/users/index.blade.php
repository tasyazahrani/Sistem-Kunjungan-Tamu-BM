@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kelola Pengguna</h4>
        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i> Tambah Pengguna</a>
    </div>

    <div class="card card-stat p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td><span class="badge bg-dark text-uppercase">{{ $u->role }}</span></td>
                        <td>
                            @if($u->aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                @if($u->id !== auth()->id())
                                <form action="{{ route('users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
@endsection
