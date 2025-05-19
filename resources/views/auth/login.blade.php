@extends('layouts.app')

@section('title', 'Masuk - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-4">
            <i class="fas fa-university fa-3x text-primary"></i>
            <h2 class="mt-2">Sistem Informasi Akademik Universitas Tadulako</h2>
            <p class="text-muted">Masuk untuk mengakses akun Anda</p>
        </div>
        
        <x-card>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <x-form-input 
                    name="email" 
                    label="Alamat Email" 
                    type="email" 
                    required="true" 
                    placeholder="Masukkan email Anda"
                    autofocus
                />
                
                <x-form-input 
                    name="password" 
                    label="Kata Sandi" 
                    type="password" 
                    required="true" 
                    placeholder="Masukkan kata sandi Anda"
                />
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>
                </div>
            </form>
        </x-card>
        
        <div class="text-center mt-3">
            <p class="text-muted">
                &copy; {{ date('Y') }} Sistem Informasi Akademik Universitas Tadulako. Semua hak dilindungi.
            </p>
        </div>
    </div>
</div>
@endsection