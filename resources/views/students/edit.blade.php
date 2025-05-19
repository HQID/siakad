@extends('layouts.app')

@section('title', 'Edit Mahasiswa - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Mahasiswa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Mahasiswa
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Akun</h5>
                
                <x-form-input 
                    name="name" 
                    label="Nama Pengguna" 
                    required="true" 
                    placeholder="Masukkan nama pengguna"
                    :value="$student->user->name"
                />
                
                <x-form-input 
                    name="email" 
                    label="Alamat Email" 
                    type="email" 
                    required="true" 
                    placeholder="Masukkan alamat email"
                    :value="$student->user->email"
                />
                
                <x-form-input 
                    name="password" 
                    label="Kata Sandi" 
                    type="password" 
                    placeholder="Kosongkan jika tidak ingin mengubah kata sandi"
                />
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Mahasiswa</h5>
                
                <x-form-input 
                    name="nim" 
                    label="NIM Mahasiswa" 
                    required="true" 
                    placeholder="Masukkan NIM mahasiswa"
                    :value="$student->nim"
                />
                
                <x-form-input 
                    name="full_name" 
                    label="Nama Lengkap" 
                    required="true" 
                    placeholder="Masukkan nama lengkap"
                    :value="$student->full_name"
                />
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="entry_year" 
                            label="Tahun Masuk" 
                            required="true" 
                            placeholder="Contoh: 2023"
                            :value="$student->entry_year"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="major" 
                            label="Program Studi" 
                            required="true" 
                            placeholder="Contoh: Teknik Informatika"
                            :value="$student->major"
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
                    :value="$student->address"
                />
                
                <x-form-input 
                    name="phone_number" 
                    label="Nomor Telepon" 
                    placeholder="Masukkan nomor telepon"
                    :value="$student->phone_number"
                />
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Tambahan</h5>
                
                <x-form-input 
                    name="birth_date" 
                    label="Tanggal Lahir" 
                    type="date"
                    :value="$student->birth_date ? $student->birth_date->format('Y-m-d') : ''"
                />
                
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ $student->gender == 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_male">Laki-laki</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ $student->gender == 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_female">Perempuan</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('students.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Perbarui Mahasiswa
            </button>
        </div>
    </form>
</x-card>
@endsection