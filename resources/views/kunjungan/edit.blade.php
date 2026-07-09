@extends('layouts.app')

@section('title', 'Edit Kunjungan')

@section('content')
    <h4 class="fw-bold mb-4">Edit Data Kunjungan — {{ $kunjungan->kode_kunjungan }}</h4>

    <div class="card card-stat p-4">
        <form method="POST" action="{{ route('kunjungan.update', $kunjungan) }}">
            @csrf
            @method('PUT')
            @include('kunjungan._form')
        </form>
    </div>
@endsection
