@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<div class="page-header">

    <div class="page-header-left">

        <h2>Produk</h2>

        <p>
            Kelola seluruh produk yang tersedia pada sistem.
        </p>

    </div>

    <div class="page-header-right">

        <a href="{{ route('products.create') }}" class="btn btn-primary">

            <i data-lucide="plus"></i>

            Tambah Produk

        </a>

    </div>

</div>


<div class="card">

    <div class="card-header">

        <form
            method="GET"
            action="{{ route('products.index') }}"
            class="table-toolbar">

            <div class="search-box">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="name"
                    value="{{ request('name') }}"
                    placeholder="Cari nama produk...">

            </div>

            <button class="btn btn-light">

                <i data-lucide="filter"></i>

                Cari

            </button>

        </form>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th width="70">Foto</th>

                        <th>Produk</th>

                        <th>Kategori</th>

                        <th class="text-end">Harga</th>

                        <th class="text-center">Stok</th>

                        <th class="text-center">Status</th>

                        <th class="text-center">Favorite</th>

                        <th width="170" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>

                            <td>

                                @if($product->image)

                                    <img
                                        src="{{ asset($product->image) }}"
                                        class="table-image">

                                @else

                                    <div class="table-image-placeholder">

                                        <i data-lucide="image"></i>

                                    </div>

                                @endif

                            </td>

                            <td>

                                <div class="table-title">

                                    {{ $product->name }}

                                </div>

                                <small>

                                    {{ Str::limit($product->description,50) }}

                                </small>

                            </td>

                            <td>

                                {{ $product->category_name }}

                            </td>

                            <td class="text-end">

                                Rp {{ number_format($product->price,0,',','.') }}

                            </td>

                            <td class="text-center">

                                @if($product->stock > 10)

                                    <span class="badge badge-success">

                                        {{ $product->stock }}

                                    </span>

                                @elseif($product->stock > 0)

                                    <span class="badge badge-warning">

                                        {{ $product->stock }}

                                    </span>

                                @else

                                    <span class="badge badge-danger">

                                        Habis

                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                @if($product->status)

                                    <span class="badge badge-success">

                                        Aktif

                                    </span>

                                @else

                                    <span class="badge badge-danger">

                                        Nonaktif

                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                @if($product->is_favorite)

                                    <i
                                        data-lucide="heart"
                                        class="favorite-icon">

                                    </i>

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                <div class="table-action">

                                    <a
                                        href="{{ route('products.edit',$product->id) }}"
                                        class="btn btn-warning btn-icon">

                                        <i data-lucide="pencil"></i>

                                    </a>

                                    <form
                                        action="{{ route('products.destroy',$product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus produk ini?')">

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

                            <td colspan="8">

                                <div class="empty-state">

                                    <i data-lucide="package-search"></i>

                                    <h4>

                                        Belum ada produk

                                    </h4>

                                    <p>

                                        Tambahkan produk pertama Anda.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($products->hasPages())

        <div class="card-footer">

            {{ $products->withQueryString()->links() }}

        </div>

    @endif

</div>

@endsection
