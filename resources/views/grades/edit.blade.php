@extends('layouts.app')

@section('title', 'Edit Nilai - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Nilai</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('grades.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Nilai
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('grades.update', $grade) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Mahasiswa & Mata Kuliah</h5>
                
                <div class="mb-3">
                    <label class="form-label">Mahasiswa</label>
                    <input type="text" class="form-control" value="{{ $grade->enrollment->student->full_name }} ({{ $grade->enrollment->student->nim }})" readonly>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Mata Kuliah</label>
                    <input type="text" class="form-control" value="{{ $grade->enrollment->course->name }} ({{ $grade->enrollment->course->code }})" readonly>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Tahun Akademik & Semester</label>
                    <input type="text" class="form-control" value="{{ $grade->enrollment->academic_year }}, {{ $grade->enrollment->semester }}" readonly>
                </div>
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Informasi Nilai</h5>
                
                <div class="row">
                    <div class="col-md-4">
                        <x-form-input 
                            name="assignment_score" 
                            label="Nilai Tugas" 
                            type="number" 
                            placeholder="0-100"
                            min="0"
                            max="100"
                            step="0.01"
                            :value="$grade->assignment_score"
                        />
                    </div>
                    
                    <div class="col-md-4">
                        <x-form-input 
                            name="mid_exam_score" 
                            label="Nilai UTS" 
                            type="number" 
                            placeholder="0-100"
                            min="0"
                            max="100"
                            step="0.01"
                            :value="$grade->mid_exam_score"
                        />
                    </div>
                    
                    <div class="col-md-4">
                        <x-form-input 
                            name="final_exam_score" 
                            label="Nilai UAS" 
                            type="number" 
                            placeholder="0-100"
                            min="0"
                            max="100"
                            step="0.01"
                            :value="$grade->final_exam_score"
                        />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nilai Akhir</label>
                            <input type="text" class="form-control" value="{{ $grade->final_score }}" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Huruf Mutu</label>
                            <input type="text" class="form-control" value="{{ $grade->grade_letter }}" readonly>
                        </div>
                    </div>
                </div>
                
                <x-form-input 
                    name="notes" 
                    label="Catatan" 
                    type="textarea" 
                    placeholder="Catatan tambahan tentang kinerja mahasiswa"
                    rows="3"
                    :value="$grade->notes"
                />
            </div>
        </div>
        
        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle me-2"></i> Nilai akhir dan huruf mutu akan dihitung ulang secara otomatis berdasarkan formula: 30% Tugas + 30% UTS + 40% UAS.
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('grades.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Perbarui Nilai
            </button>
        </div>
    </form>
</x-card>
@endsection