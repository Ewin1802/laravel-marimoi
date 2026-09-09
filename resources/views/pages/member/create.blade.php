@extends('layouts.app')

@section('title','Tambah Member')

@section('content')

<div class="page-header">

    <div>

        <h2>Tambah Member</h2>

        <p>
            Daftarkan member baru beserta barcode dan diskonnya.
        </p>

    </div>

    <a
        href="{{ route('members.index') }}"
        class="btn btn-secondary">

        <i data-lucide="arrow-left"></i>

        Kembali

    </a>

</div>

<div class="card">

    <div class="card-body">

        <form
            method="POST"
            action="{{ route('members.store') }}">

            @csrf

            @include('members._form', ['member' => null])

            <div class="form-actions mt-4">

                <button
                    type="submit"
                    class="btn btn-primary">

                    Simpan

                </button>

                <a
                    href="{{ route('members.index') }}"
                    class="btn btn-secondary">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>
    document.getElementById('generateCodeBtn').addEventListener('click', function () {

        fetch("{{ route('members.generate-code') }}")

            .then(response => response.json())

            .then(data => {

                document.getElementById('code').value = data.code;

            });

    });
</script>

@endpush
