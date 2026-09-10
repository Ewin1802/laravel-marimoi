@extends('layouts.app')

@section('title', 'Member Management')

@section('content')

    <div class="page-header">

        <div>

            <h2>Member Management</h2>

            <p>
                Kelola seluruh data member cafe. Pemberian Diskon (% atau Rp) bisa dilakukan per orang/member. Sehingga setiap member bisa berbeda penerapan Diskon saat membayar.
            </p>

        </div>

        <a href="{{ route('members.create') }}" class="btn btn-primary">

            <i data-lucide="plus"></i>

            Tambah Member

        </a>

    </div>

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <form method="GET" action="{{ route('members.index') }}" class="table-toolbar">

                <div class="search-box">

                    <i data-lucide="search"></i>

                    <input type="text" name="name" value="{{ request('name') }}"
                        placeholder="Cari nama, email, atau kode barcode...">

                </div>

                <button class="btn btn-primary">

                    Cari

                </button>

            </form>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th width="60">No</th>

                            <th>Nama</th>

                            <th>Email</th>
                            <th>No. HP</th>

                            <th>Kode Barcode</th>

                            <th width="120">Stamp</th>

                            <th width="140">Diskon</th>

                            <th width="110">Status</th>

                            <th width="160">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($members as $member)
                            <tr>

                                <td>

                                    {{ $members->firstItem() + $loop->index }}

                                </td>

                                <td>

                                    <strong>

                                        {{ $member->user->name ?? '-' }}

                                    </strong>

                                </td>

                                <td>{{ $member->user->email ?? '-' }}</td>
                                <td>{{ $member->user->phone_number ?? '-' }}</td>

                                <td>

                                    <code>{{ $member->code }}</code>

                                </td>

                                <td>

                                    {{ $member->stamp_count }} / {{ $member->stamp_target }}

                                </td>

                                <td>

                                    {{ $member->discount_label }}

                                </td>

                                <td>

                                    @if ($member->is_active)
                                        <span class="badge badge-success">

                                            Aktif

                                        </span>
                                    @else
                                        <span class="badge badge-secondary">

                                            Nonaktif

                                        </span>
                                    @endif

                                </td>

                                <td>

                                    <div class="btn-group">

                                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm">

                                            <i data-lucide="square-pen"></i>

                                        </a>

                                        <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus member ini?')">

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

                                <td colspan="9" class="text-center">

                                    Tidak ada data member.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $members->withQueryString()->links() }}

            </div>

        </div>

    </div>

@endsection
