@extends('layouts.app')

@section('title', 'Tambah Mahasiswa Baru - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Mahasiswa Baru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Mahasiswa
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('students.store') }}" method="POST">
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
                <h5 class="mb-3">Informasi Mahasiswa</h5>
                
                <x-form-input 
                    name="nim" 
                    label="NIM Mahasiswa" 
                    required="true" 
                    placeholder="Masukkan NIM mahasiswa"
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
                            name="entry_year" 
                            label="Tahun Masuk" 
                            required="true" 
                            placeholder="Contoh: 2023"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="major" 
                            label="Program Studi" 
                            required="true" 
                            placeholder="Contoh: Teknik Informatika"
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
            
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Tambahan</h5>
                
                <x-form-input 
                    name="birth_date" 
                    label="Tanggal Lahir" 
                    type="date"
                />
                
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male">
                            <label class="form-check-label" for="gender_male">Laki-laki</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female">
                            <label class="form-check-label" for="gender_female">Perempuan</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <button type="reset" class="btn btn-secondary me-2">Reset</button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan Mahasiswa
            </button>
        </div>
    </form>
</x-card>
@endsection