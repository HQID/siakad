@extends('layouts.app')

@section('title', 'Register - Academic Information System')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        <div class="text-center mb-4">
            <i class="fas fa-university fa-3x text-primary"></i>
            <h2 class="mt-2">Academic Information System</h2>
            <p class="text-muted">Create a new account</p>
        </div>
        
        <x-card>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="name" 
                            label="Name" 
                            required="true" 
                            placeholder="Enter your name"
                            autofocus
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="email" 
                            label="Email Address" 
                            type="email" 
                            required="true" 
                            placeholder="Enter your email"
                        />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="password" 
                            label="Password" 
                            type="password" 
                            required="true" 
                            placeholder="Enter your password"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="password_confirmation" 
                            label="Confirm Password" 
                            type="password" 
                            required="true" 
                            placeholder="Confirm your password"
                        />
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role_student" value="student" checked>
                        <label class="form-check-label" for="role_student">
                            Student
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role_lecturer" value="lecturer">
                        <label class="form-check-label" for="role_lecturer">
                            Lecturer
                        </label>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i> Register
                    </button>
                </div>
            </form>
        </x-card>
        
        <div class="text-center mt-3">
            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
</div>
@endsection