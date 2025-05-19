@extends('layouts.app')

@section('title', 'Tambah Dosen Baru - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Dosen Baru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lecturers.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Dosen
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('lecturers.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Akun</h5>
                
                <x-form-input 
                    name="name" 
                    label="Nama Pengguna" 
                    required="true" 
                    placeholder="Masukkan nama pengguna"
                />
                
                <x-form-input 
                    name="email" 
                    label="Alamat Email" 
                    type="email" 
                    required="true" 
                    placeholder="Masukkan alamat email"
                />
                
                <x-form-input 
                    name="password" 
                    label="Kata Sandi" 
                    type="password" 
                    required="true" 
                    placeholder="Masukkan kata sandi"
                />
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Dosen</h5>
                
                <x-form-input 
                    name="nip" 
                    label="NIP Dosen" 
                    required="true" 
                    placeholder="Masukkan NIP dosen"
                />
                
                <x-form-input 
                    name="full_name" 
                    label="Nama Lengkap" 
                    required="true" 
                    placeholder="Masukkan nama lengkap"
                />
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="specialization" 
                            label="Spesialisasi" 
                            placeholder="Contoh: Sistem Basis Data"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="academic_degree" 
                            label="Gelar Akademik" 
                            placeholder="Contoh: Ph.D., M.Sc."
                        />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Kontak</h5>
                
                <x-form-input 
                    name="address" 
                    label="Alamat" 
                    type="textarea" 
                    placeholder="Masukkan alamat"
                />
                
                <x-form-input 
                    name="phone_number" 
                    label="Nomor Telepon" 
                    placeholder="Masukkan nomor telepon"
                />
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <button type="reset" class="btn btn-secondary me-2">Reset</button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan Dosen
            </button>
        </div>
    </form>
</x-card>
@endsection