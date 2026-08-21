@extends('layouts.app')

@section('title','User Management')

@section('content')

<div class="page-header">

    <div>

        <h2>User Management</h2>

        <p>
            Kelola seluruh data pengguna sistem.
        </p>

    </div>

    <a
        href="{{ route('users.create') }}"
        class="btn btn-primary">

        <i data-lucide="plus"></i>

        Tambah User

    </a>

</div>

<div class="card">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('users.index') }}"
            class="table-toolbar">

            <div class="search-box">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="name"
                    value="{{ request('name') }}"
                    placeholder="Cari nama atau email...">

            </div>

            <button
                class="btn btn-primary">

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

                        <th width="70">No</th>

                        <th>Nama</th>

                        <th>Email</th>

                        <th width="150">Role</th>

                        <th width="160">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>

                            {{ $users->firstItem() + $loop->index }}

                        </td>

                        <td>

                            <strong>

                                {{ $user->name }}

                            </strong>

                        </td>

                        <td>

                            {{ $user->email }}

                        </td>

                        <td>

                            @if($user->role=='admin')

                                <span class="badge badge-danger">

                                    Admin

                                </span>

                            @elseif($user->role=='staff')

                                <span class="badge badge-success">

                                    Staff

                                </span>

                            @else

                                <span class="badge badge-secondary">

                                    User

                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="btn-group">

                                <a
                                    href="{{ route('users.edit',$user->id) }}"
                                    class="btn btn-warning btn-sm">

                                    <i data-lucide="square-pen"></i>

                                </a>

                                <form
                                    action="{{ route('users.destroy',$user->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm">

                                        <i data-lucide="trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="text-center">

                            Tidak ada data user.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div
            class="mt-4">

            {{ $users->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection
