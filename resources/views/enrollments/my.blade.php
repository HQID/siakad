@extends('layouts.app')

@section('title', 'My Enrollments - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Enrollments</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('enrollments.registration') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Register for Courses
        </a>
    </div>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('enrollments.my') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by course name" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select name="semester" class="form-select" onchange="this.form.submit()">
                    <option value="">All Semesters</option>
                    @foreach(auth()->user()->student->enrollments()->select('semester')->distinct()->pluck('semester') as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('enrollments.my') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <x-table>
        <x-slot name="header">
            <th>#</th>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Credits</th>
            <th>Lecturer</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Grade</th>
        </x-slot>
        
        @forelse($enrollments as $index => $enrollment)
            <tr>
                <td>{{ $enrollments->firstItem() + $index }}</td>
                <td>{{ $enrollment->course->code }}</td>
                <td>{{ $enrollment->course->name }}</td>
                <td>{{ $enrollment->course->credits }}</td>
                <td>{{ $enrollment->course->lecturer ? $enrollment->course->lecturer->full_name : 'Not Assigned' }}</td>
                <td>{{ $enrollment->semester }} ({{ $enrollment->academic_year }})</td>
                <td>
                    <span class="badge bg-{{ $enrollment->status == 'active' ? 'success' : ($enrollment->status == 'completed' ? 'primary' : 'warning') }}">
                        {{ ucfirst($enrollment->status) }}
                    </span>
                </td>
                <td>
                    @if($enrollment->grade)
                        <span class="badge bg-{{ $enrollment->grade->grade_letter == 'A' || $enrollment->grade->grade_letter == 'A-' ? 'success' : ($enrollment->grade->grade_letter == 'B+' || $enrollment->grade->grade_letter == 'B' || $enrollment->grade->grade_letter == 'B-' ? 'primary' : ($enrollment->grade->grade_letter == 'C+' || $enrollment->grade->grade_letter == 'C' ? 'warning' : 'danger')) }}">
                            {{ $enrollment->grade->grade_letter }} ({{ $enrollment->grade->final_score }})
                        </span>
                    @else
                        <span class="badge bg-secondary">Not Graded</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No enrollments found.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $enrollments->links() }}
    </div>
</x-card>
@endsection