@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="page-header">

    <div class="page-header-left">

        <h2>Data Kategori</h2>

        <p>
            Kelola seluruh kategori produk pada sistem.
        </p>

    </div>

    <div class="page-header-right">

        <a
            href="{{ route('categories.create') }}"
            class="btn btn-primary">

            <i data-lucide="plus"></i>

            Tambah Kategori

        </a>

    </div>

</div>


@if(session('success'))

<div class="alert alert-success">

    <i data-lucide="circle-check-big"></i>

    {{ session('success') }}

</div>

@endif


@if(session('error'))

<div class="alert alert-danger">

    <i data-lucide="triangle-alert"></i>

    {{ session('error') }}

</div>

@endif


<div class="card">

    <div class="card-header">

        <form
            action="{{ route('categories.index') }}"
            method="GET"
            class="table-toolbar">

            <div class="search-box">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kategori...">

            </div>

            <button
                class="btn btn-light">

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

                        <th width="70">No</th>

                        <th width="90">Gambar</th>

                        <th>Nama Kategori</th>

                        <th>Deskripsi</th>

                        <th width="170" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($categories as $category)

                    <tr>

                        <td>

                            {{ $categories->firstItem() + $loop->index }}

                        </td>

                        <td>

                            @if($category->image)

                                <img
                                    src="{{ asset($category->image) }}"
                                    class="table-image">

                            @else

                                <div class="table-image-placeholder">

                                    <i data-lucide="image"></i>

                                </div>

                            @endif

                        </td>

                        <td>

                            <div class="table-title">

                                {{ $category->name }}

                            </div>

                        </td>

                        <td>

                            {{ $category->description ?: '-' }}

                        </td>

                        <td>

                            <div class="table-action">

                                <a
                                    href="{{ route('categories.edit',$category->id) }}"
                                    class="btn btn-warning btn-icon">

                                    <i data-lucide="pencil"></i>

                                </a>

                                <form
                                    action="{{ route('categories.destroy',$category->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus kategori ini?')">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-icon">

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

                                <i data-lucide="folder-open"></i>

                                <h4>

                                    Belum Ada Kategori

                                </h4>

                                <p>

                                    Silakan tambahkan kategori pertama.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($categories->hasPages())

    <div class="card-footer">

        {{ $categories->links() }}

    </div>

    @endif

</div>

@endsection
