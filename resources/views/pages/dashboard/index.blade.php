@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="dashboard">

    @include('pages.dashboard.partials.header')

    @include('pages.dashboard.partials.statistics')

    @include('pages.dashboard.partials.chart')

    <div class="dashboard-grid-2">

        @include('pages.dashboard.partials.products')

        @include('pages.dashboard.partials.users')

    </div>

</div>

@endsection
