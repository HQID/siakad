@extends('layouts.app')

@section('title', 'Page Not Found - Academic Information System')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-exclamation-circle text-danger" style="font-size: 5rem;"></i>
            </div>
            <h1 class="display-4 fw-bold">404</h1>
            <h2 class="mb-4">Page Not Found</h2>
            <p class="lead mb-5">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Go Back
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i> Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection