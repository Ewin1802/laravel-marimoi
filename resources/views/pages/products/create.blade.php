@extends('layouts.app')

@section('title','Tambah Produk')

@section('content')

<div class="page-header">

    <div class="page-header-left">

        <h2>Tambah Produk</h2>

        <p>

            Tambahkan produk baru.

        </p>

    </div>

</div>

<form
    action="{{ route('products.store') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    @include('pages.products._form')

</form>

@endsection
