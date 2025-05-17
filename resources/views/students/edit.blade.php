@extends('layouts.app')

@section('title', 'Edit Student - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Student</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Students
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Account Information</h5>
                
                <x-form-input 
                    name="name" 
                    label="Username" 
                    required="true" 
                    placeholder="Enter username"
                    :value="$student->user->name"
                />
                
                <x-form-input 
                    name="email" 
                    label="Email Address" 
                    type="email" 
                    required="true" 
                    placeholder="Enter email address"
                    :value="$student->user->email"
                />
                
                <x-form-input 
                    name="password" 
                    label="Password" 
                    type="password" 
                    placeholder="Leave blank to keep current password"
                />
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Student Information</h5>
                
                <x-form-input 
                    name="nim" 
                    label="Student ID (NIM)" 
                    required="true" 
                    placeholder="Enter student ID"
                    :value="$student->nim"
                />
                
                <x-form-input 
                    name="full_name" 
                    label="Full Name" 
                    required="true" 
                    placeholder="Enter full name"
                    :value="$student->full_name"
                />
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="entry_year" 
                            label="Entry Year" 
                            required="true" 
                            placeholder="e.g. 2023"
                            :value="$student->entry_year"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="major" 
                            label="Major" 
                            required="true" 
                            placeholder="e.g. Computer Science"
                            :value="$student->major"
                        />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <h5 class="mb-3">Contact Information</h5>
                
                <x-form-input 
                    name="address" 
                    label="Address" 
                    type="textarea" 
                    placeholder="Enter address"
                    :value="$student->address"
                />
                
                <x-form-input 
                    name="phone_number" 
                    label="Phone Number" 
                    placeholder="Enter phone number"
                    :value="$student->phone_number"
                />
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Additional Information</h5>
                
                <x-form-input 
                    name="birth_date" 
                    label="Birth Date" 
                    type="date"
                    :value="$student->birth_date ? $student->birth_date->format('Y-m-d') : ''"
                />
                
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div class="d-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ $student->gender == 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ $student->gender == 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_female">Female</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('students.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Student
            </button>
        </div>
    </form>
</x-card>
@endsection