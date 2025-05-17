@extends('layouts.app')

@section('title', 'Add New Grade - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Grade</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('grades.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Grades
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Student & Course Information</h5>
                
                <div class="mb-3">
                    <label for="enrollment_id" class="form-label">Student & Course <span class="text-danger">*</span></label>
                    <select name="enrollment_id" id="enrollment_id" class="form-select @error('enrollment_id') is-invalid @enderror" required>
                        <option value="">Select Student & Course</option>
                        @foreach($enrollments as $enrollment)
                            <option value="{{ $enrollment->id }}" {{ old('enrollment_id', request('enrollment_id')) == $enrollment->id ? 'selected' : '' }}>
                                {{ $enrollment->student->full_name }} ({{ $enrollment->student->nim }}) - {{ $enrollment->course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('enrollment_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Grade Information</h5>
                
                <div class="row">
                    <div class="col-md-4">
                        <x-form-input 
                            name="assignment_score" 
                            label="Assignment Score" 
                            type="number" 
                            placeholder="0-100"
                            min="0"
                            max="100"
                            step="0.01"
                        />
                    </div>
                    
                    <div class="col-md-4">
                        <x-form-input 
                            name="mid_exam_score" 
                            label="Mid Exam Score" 
                            type="number" 
                            placeholder="0-100"
                            min="0"
                            max="100"
                            step="0.01"
                        />
                    </div>
                    
                    <div class="col-md-4">
                        <x-form-input 
                            name="final_exam_score" 
                            label="Final Exam Score" 
                            type="number" 
                            placeholder="0-100"
                            min="0"
                            max="100"
                            step="0.01"
                        />
                    </div>
                </div>
                
                <x-form-input 
                    name="notes" 
                    label="Notes" 
                    type="textarea" 
                    placeholder="Additional notes about the student's performance"
                    rows="3"
                />
            </div>
        </div>
        
        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle me-2"></i> The final score and grade letter will be calculated automatically based on the formula: 30% Assignment + 30% Mid Exam + 40% Final Exam.
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <button type="reset" class="btn btn-secondary me-2">Reset</button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Grade
            </button>
        </div>
    </form>
</x-card>
@endsection