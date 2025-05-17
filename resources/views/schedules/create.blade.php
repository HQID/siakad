@extends('layouts.app')

@section('title', 'Add New Schedule - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Schedule</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('schedules.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Schedules
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Course Information</h5>
                
                <div class="mb-3">
                    <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                    <select name="course_id" id="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                        <option value="">Select Course</option>
                        @foreach(\App\Models\Course::orderBy('name')->get() as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="academic_year" 
                            label="Academic Year" 
                            required="true" 
                            placeholder="e.g. 2023/2024"
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
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Schedule Information</h5>
                
                <div class="mb-3">
                    <label for="day" class="form-label">Day <span class="text-danger">*</span></label>
                    <select name="day" id="day" class="form-select @error('day') is-invalid @enderror" required>
                        <option value="">Select Day</option>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('day')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="start_time" 
                            label="Start Time" 
                            type="time" 
                            required="true"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="end_time" 
                            label="End Time" 
                            type="time" 
                            required="true"
                        />
                    </div>
                </div>
                
                <x-form-input 
                    name="room" 
                    label="Room" 
                    required="true" 
                    placeholder="e.g. A101"
                />
            </div>
        </div>
        
        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle me-2"></i> Please ensure there are no scheduling conflicts with the selected room and time slot.
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <button type="reset" class="btn btn-secondary me-2">Reset</button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Schedule
            </button>
        </div>
    </form>
</x-card>
@endsection