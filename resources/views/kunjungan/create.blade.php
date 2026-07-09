@extends('layouts.app')

@section('title', 'Input Kunjungan Manual')

@section('content')
    <h4 class="fw-bold mb-4">Input Kunjungan Manual</h4>
    <p class="text-muted small">Gunakan formulir ini bila tamu mengalami kesulitan mengisi buku tamu secara mandiri.</p>

    <div class="card card-stat p-4">
        <form method="POST" action="{{ route('kunjungan.store') }}">
            @csrf
            @include('kunjungan._form')
        </form>
    </div>
@endsection
