@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

    <div class="page-header">

        <div class="page-header-left">

            <h2>Tambah User</h2>

            <p>
                Tambahkan pengguna baru ke dalam sistem.
            </p>

        </div>

        <div class="page-header-right">

            <a href="{{ route('users.index') }}" class="btn btn-light">

                <i data-lucide="arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <form action="{{ route('users.store') }}" method="POST">

        @csrf

        @include('pages.users._form')

        

    </form>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {

            button.addEventListener('click', function() {

                const target = document.getElementById(this.dataset.target);

                if (target.type === 'password') {

                    target.type = 'text';

                    this.innerHTML = '<i data-lucide="eye-off"></i>';

                } else {

                    target.type = 'password';

                    this.innerHTML = '<i data-lucide="eye"></i>';

                }

                lucide.createIcons();

            });

        });
    </script>
@endpush
