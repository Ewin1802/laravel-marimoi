@extends('layouts.app')

@section('title', 'Diskon')

@section('content')

    <div class="page-header">

        <div class="page-header-left">

            <h2>Data Diskon</h2>

            <p>
                Kelola seluruh data diskon yang tersedia pada sistem.
            </p>

        </div>

        <div class="page-header-right">

            <a href="{{ route('discounts.create') }}" class="btn btn-primary">

                <i data-lucide="plus"></i>

                Tambah Diskon

            </a>

        </div>

    </div>


    @if (session('success'))
        <div class="alert alert-success">

            <i data-lucide="circle-check-big"></i>

            {{ session('success') }}

        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">

            <i data-lucide="triangle-alert"></i>

            {{ session('error') }}

        </div>
    @endif


    <div class="card">

        <div class="card-header">

            <form action="{{ route('discounts.index') }}" method="GET" class="table-toolbar">

                <div class="search-box">

                    <i data-lucide="search"></i>

                    <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama diskon...">

                </div>

                <button class="btn btn-light" type="submit">

                    <i data-lucide="search"></i>

                    Cari

                </button>

            </form>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th width="70">

                                No

                            </th>

                            <th>

                                Nama Diskon

                            </th>

                            <th>

                                Deskripsi

                            </th>

                            <th width="160" class="text-end">

                                Nilai

                            </th>

                            <th width="170" class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($discounts as $discount)
                            <tr>

                                <td>

                                    {{ $discounts->firstItem() + $loop->index }}

                                </td>

                                <td>

                                    <div class="table-title">

                                        {{ $discount->name }}

                                    </div>

                                </td>

                                <td>

                                    {{ $discount->description }}

                                </td>

                                <td class="text-end">

                                    <span class="badge badge-primary">

                                        {{ $discount->value }} %

                                    </span>

                                </td>

                                <td>

                                    <div class="table-action">

                                        <a href="{{ route('discounts.edit', $discount->id) }}"
                                            class="btn btn-warning btn-icon">

                                            <i data-lucide="pencil"></i>

                                        </a>

                                        <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus diskon ini?')">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-icon">

                                                <i data-lucide="trash-2"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5">

                                    <div class="empty-state">

                                        <i data-lucide="badge-percent"></i>

                                        <h4>

                                            Belum Ada Data Diskon

                                        </h4>

                                        <p>

                                            Silakan tambahkan data diskon pertama.

                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($discounts->hasPages())
            <div class="card-footer">

                {{ $discounts->withQueryString()->links() }}

            </div>
        @endif

    </div>

@endsection
