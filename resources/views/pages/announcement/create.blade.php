@extends('layouts.app')

@section('title','Tambah Informasi')

@section('content')

<div class="page-header">

    <div>
        <h2>Tambah Informasi</h2>
        <p>Buat info/promo baru untuk ditampilkan di aplikasi member.</p>
    </div>

    <a href="{{ route('announcements.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card">

    <div class="card-body">

        <form method="POST" action="{{ route('announcements.store') }}" enctype="multipart/form-data">

            @csrf

            @include('pages.announcement._form')

            <div class="form-actions mt-4">

                <button type="submit" class="btn btn-primary">Simpan</button>

                <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Batal</a>

            </div>

        </form>

    </div>

</div>

@endsection
