@extends('layouts.app')

@section('title', 'Tambah Diskon')

@section('content')

    <div class="page-header">

        <div class="page-header-left">

            <h2>Tambah Diskon</h2>

            <p>

                Tambahkan data diskon baru.

            </p>

        </div>

        <div class="page-header-right">

            <a href="{{ route('discounts.index') }}" class="btn btn-light">

                <i data-lucide="arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <form action="{{ route('discounts.store') }}" method="POST">

        @csrf

        @include('pages.discounts._form')

    </form>

@endsection
