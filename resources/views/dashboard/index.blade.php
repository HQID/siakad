@extends('layouts.app')

@section('title', 'Dashboard - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

@if(auth()->user()->isAdmin())
    @include('dashboard.admin')
@elseif(auth()->user()->isLecturer())
    @include('dashboard.lecturer')
@else
    @include('dashboard.student')
@endif
@endsection