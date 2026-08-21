@extends('layouts.app')

@section('title','Edit Produk')

@section('content')

<div class="page-header">

    <div class="page-header-left">

        <h2>Edit Produk</h2>

        <p>

            Perbarui informasi produk.

        </p>

    </div>

</div>

<form
    action="{{ route('products.update',$product->id) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    @method('PUT')

    @include('pages.products._form')

</form>

@endsection
