@extends('layouts.app')

@section('title', 'Daftar - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        <div class="text-center mb-4">
            <i class="fas fa-university fa-3x text-primary"></i>
            <h2 class="mt-2">Sistem Informasi Akademik Universitas Tadulako</h2>
            <p class="text-muted">Buat akun baru</p>
        </div>
        
        <x-card>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="name" 
                            label="Nama" 
                            required="true" 
                            placeholder="Masukkan nama Anda"
                            autofocus
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="email" 
                            label="Alamat Email" 
                            type="email" 
                            required="true" 
                            placeholder="Masukkan email Anda"
                        />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="password" 
                            label="Kata Sandi" 
                            type="password" 
                            required="true" 
                            placeholder="Masukkan kata sandi Anda"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="password_confirmation" 
                            label="Konfirmasi Kata Sandi" 
                            type="password" 
                            required="true" 
                            placeholder="Konfirmasi kata sandi Anda"
                        />
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Peran</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role_student" value="student" checked>
                        <label class="form-check-label" for="role_student">
                            Mahasiswa
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role_lecturer" value="lecturer">
                        <label class="form-check-label" for="role_lecturer">
                            Dosen
                        </label>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i> Daftar
                    </button>
                </div>
            </form>
        </x-card>
        
        <div class="text-center mt-3">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </div>
</div>
@endsection