@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

    <div class="page-header">

        <div class="page-header-left">

            <h2>Edit Kategori</h2>

            <p>

                Perbarui informasi kategori.

            </p>

        </div>

        <div class="page-header-right">

            <a href="{{ route('categories.index') }}" class="btn btn-light">

                <i data-lucide="arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">

        @csrf

        @method('PUT')

        @include('pages.categories._form')

    </form>

@endsection
