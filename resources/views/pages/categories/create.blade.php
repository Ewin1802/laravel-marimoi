@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

    <div class="page-header">

        <div class="page-header-left">

            <h2>Tambah Kategori</h2>

            <p>

                Tambahkan kategori produk baru.

            </p>

        </div>

        <div class="page-header-right">

            <a href="{{ route('categories.index') }}" class="btn btn-light">

                <i data-lucide="arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        @include('pages.categories._form')

    </form>

@endsection
