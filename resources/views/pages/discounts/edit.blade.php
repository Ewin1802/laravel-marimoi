@extends('layouts.app')

@section('title', 'Edit Diskon')

@section('content')

    <div class="page-header">

        <div class="page-header-left">

            <h2>Edit Diskon</h2>

            <p>

                Perbarui informasi diskon.

            </p>

        </div>

        <div class="page-header-right">

            <a href="{{ route('discounts.index') }}" class="btn btn-light">

                <i data-lucide="arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <form action="{{ route('discounts.update', $discount->id) }}" method="POST">

        @csrf

        @method('PUT')

        @include('pages.discounts._form')

    </form>

@endsection
