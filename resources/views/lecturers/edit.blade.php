@extends('layouts.app')

@section('title', 'Edit Lecturer - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Lecturer</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lecturers.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Lecturers
        </a>
    </div>
</div>

<x-card>
    <form action="{{ route('lecturers.update', $lecturer) }}" method="POST">
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
                    :value="$lecturer->user->name"
                />
                
                <x-form-input 
                    name="email" 
                    label="Email Address" 
                    type="email" 
                    required="true" 
                    placeholder="Enter email address"
                    :value="$lecturer->user->email"
                />
                
                <x-form-input 
                    name="password" 
                    label="Password" 
                    type="password" 
                    placeholder="Leave blank to keep current password"
                />
            </div>
            
            <div class="col-md-6">
                <h5 class="mb-3">Lecturer Information</h5>
                
                <x-form-input 
                    name="nip" 
                    label="Lecturer ID (NIP)" 
                    required="true" 
                    placeholder="Enter lecturer ID"
                    :value="$lecturer->nip"
                />
                
                <x-form-input 
                    name="full_name" 
                    label="Full Name" 
                    required="true" 
                    placeholder="Enter full name"
                    :value="$lecturer->full_name"
                />
                
                <div class="row">
                    <div class="col-md-6">
                        <x-form-input 
                            name="specialization" 
                            label="Specialization" 
                            placeholder="e.g. Database Systems"
                            :value="$lecturer->specialization"
                        />
                    </div>
                    
                    <div class="col-md-6">
                        <x-form-input 
                            name="academic_degree" 
                            label="Academic Degree" 
                            placeholder="e.g. Ph.D., M.Sc."
                            :value="$lecturer->academic_degree"
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
                    :value="$lecturer->address"
                />
                
                <x-form-input 
                    name="phone_number" 
                    label="Phone Number" 
                    placeholder="Enter phone number"
                    :value="$lecturer->phone_number"
                />
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('lecturers.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Lecturer
            </button>
        </div>
    </form>
</x-card>
@endsection