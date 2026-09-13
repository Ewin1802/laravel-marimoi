@extends('layouts.app')

@section('title','Informasi Member')

@section('content')

<div class="page-header">

    <div>

        <h2>Informasi Member</h2>

        <p>
            Kelola info/promo yang tampil di aplikasi member. Info yang diaktifkan otomatis mengirim notifikasi ke semua member.
        </p>

    </div>

    <a
        href="{{ route('announcements.create') }}"
        class="btn btn-primary">

        <i data-lucide="plus"></i>

        Tambah Informasi

    </a>

</div>

@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif

<div class="card">

    <div class="card-body">

        <div class="table-wrapper">

            <table class="table">

                <thead>

                    <tr>

                        <th width="70">No</th>

                        <th>Judul</th>

                        <th>Pesan</th>

                        <th width="120">Status</th>

                        <th width="160">Dipublikasikan</th>

                        <th width="140">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($announcements as $item)

                    <tr>

                        <td>
                            {{ $announcements->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <strong>{{ $item->title }}</strong>
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($item->message, 60) }}
                        </td>

                        <td>

                            @if($item->is_active)

                                <span class="badge badge-success">Aktif</span>

                            @else

                                <span class="badge badge-secondary">Nonaktif</span>

                            @endif

                        </td>

                        <td>
                            {{ optional($item->published_at)->format('d M Y, H:i') ?? '-' }}
                        </td>

                        <td>

                            <div class="btn-group">

                                <a
                                    href="{{ route('announcements.edit',$item->id) }}"
                                    class="btn btn-warning btn-sm">

                                    <i data-lucide="square-pen"></i>

                                </a>

                                <form
                                    action="{{ route('announcements.destroy',$item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus informasi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i data-lucide="trash"></i>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">Belum ada informasi.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $announcements->links() }}
        </div>

    </div>

</div>

@endsection
