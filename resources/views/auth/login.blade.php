@extends('layouts.app')

@section('title', 'Login - Academic Information System')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-4">
            <i class="fas fa-university fa-3x text-primary"></i>
            <h2 class="mt-2">Academic Information System</h2>
            <p class="text-muted">Sign in to access your account</p>
        </div>
        
        <x-card>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <x-form-input 
                    name="email" 
                    label="Email Address" 
                    type="email" 
                    required="true" 
                    placeholder="Enter your email"
                    autofocus
                />
                
                <x-form-input 
                    name="password" 
                    label="Password" 
                    type="password" 
                    required="true" 
                    placeholder="Enter your password"
                />
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </div>
            </form>
        </x-card>
        
        <div class="text-center mt-3">
            <p class="text-muted">
                &copy; {{ date('Y') }} Academic Information System. All rights reserved.
            </p>
        </div>
    </div>
</div>
@endsection