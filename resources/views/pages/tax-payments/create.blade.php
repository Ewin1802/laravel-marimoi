@extends('layouts.app')

@section('title', 'Setor Pajak')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/tax-payments.css') }}">
@endpush

@section('content')

    <div class="page-header">
        <div>
            <h2>Setor Pajak</h2>
            <p>Catat setoran pajak dan unggah bukti pembayarannya.</p>
        </div>

        <a href="{{ route('tax-payments.index') }}" class="btn btn-light">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('tax-payments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @include('pages.tax-payments._form', ['payment' => null])
    </form>

@endsection
