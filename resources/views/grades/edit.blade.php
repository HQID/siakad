@extends('layouts.app')

@section('title', 'Edit Grade - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Grade</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('grades.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Grades
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('grades.update', $grade) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Student & Course Information</h5>
                
                <div class="mb-3">
                    <label class="form-label">Student</label>
                    <input type="text" class="form-control" value="{{ $grade->enrollment->student->full_name }} ({{ $grade->enrollment->student->nim }})" readonly>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" class="form-control" value="{{ $grade->enrollment->course->name }} ({{ $grade->enrollment->course->code }})" readonly>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Academic Year & Semester</label>
                    <input type="text" class="form-control" value="{{ $grade->enrollment->academic_year }}, {{ $grade->enrollment->semester }}" readonly>
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
                            :value="$grade->assignment_score"
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
                            :value="$grade->mid_exam_score"
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
                            :value="$grade->final_exam_score"
                        />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Final Score</label>
                            <input type="text" class="form-control" value="{{ $grade->final_score }}" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Grade Letter</label>
                            <input type="text" class="form-control" value="{{ $grade->grade_letter }}" readonly>
                        </div>
                    </div>
                </div>
                
                <x-form-input 
                    name="notes" 
                    label="Notes" 
                    type="textarea" 
                    placeholder="Additional notes about the student's performance"
                    rows="3"
                    :value="$grade->notes"
                />
            </div>
        </div>
        
        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle me-2"></i> The final score and grade letter will be recalculated automatically based on the formula: 30% Assignment + 30% Mid Exam + 40% Final Exam.
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('grades.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Grade
            </button>
        </div>
    </form>
</x-card>
@endsection