@extends('layouts.app')

@section('title','Edit Informasi')

@section('content')

<div class="page-header">

    <div>
        <h2>Edit Informasi</h2>
        <p>{{ $announcement->title }}</p>
    </div>

    <a href="{{ route('announcements.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card">

    <div class="card-body">

        <form method="POST" action="{{ route('announcements.update',$announcement->id) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            @include('pages.announcement._form')

            <div class="form-actions mt-4">

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Batal</a>

            </div>

        </form>

    </div>

</div>

@endsection
