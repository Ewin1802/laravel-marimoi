@extends('layouts.app')

@section('title', 'Edit Setoran Pajak')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/tax-payments.css') }}">
@endpush

@section('content')

    <div class="page-header">
        <div>
            <h2>Edit Setoran Pajak</h2>
            <p>Catat setoran pajak dan unggah bukti pembayarannya.</p>
        </div>

        <a href="{{ route('tax-payments.index') }}" class="btn btn-light">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('tax-payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('pages.tax-payments._form')
    </form>

@endsection
