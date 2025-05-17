@extends('layouts.app')

@section('title', 'Add New Course - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Course</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('courses.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Courses
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Course Information</h5>
                
                <x-form-input 
                    name="code" 
                    label="Course Code" 
                    required="true" 
                    placeholder="e.g. CS101"
                />
                
                <x-form-input 
                    name="name" 
                    label="Course Name" 
                    required="true" 
                    placeholder="e.g. Introduction to Programming"
                />
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="credits" 
                            label="Credits" 
                            type="number" 
                            required="true" 
                            placeholder="e.g. 3"
                            min="1"
                            max="6"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="semester" 
                            label="Semester" 
                            required="true" 
                            placeholder="e.g. Fall 2023"
                        />
                    </div>
                </div>
                
                <x-form-input 
                    name="description" 
                    label="Description" 
                    type="textarea" 
                    placeholder="Enter course description"
                    rows="4"
                />
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Lecturer Assignment</h5>
                
                <div class="mb-3">
                    <label for="lecturer_id" class="form-label">Lecturer</label>
                    <select name="lecturer_id" id="lecturer_id" class="form-select @error('lecturer_id') is-invalid @enderror">
                        <option value="">Select Lecturer (Optional)</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->full_name }} ({{ $lecturer->nip }})
                            </option>
                        @endforeach
                    </select>
                    @error('lecturer_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <button type="reset" class="btn btn-secondary me-2">Reset</button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Course
            </button>
        </div>
    </form>
</x-card>
@endsection