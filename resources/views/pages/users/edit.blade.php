@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<form action="{{ route('users.update', $user) }}" method="POST">

    @csrf
    @method('PUT')

    @include('pages.users._form')

</form>

@endsection
