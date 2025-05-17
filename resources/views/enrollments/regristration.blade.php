@extends('layouts.app')

@section('title', 'Course Registration - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Course Registration</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('enrollments.my') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to My Enrollments
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Available Courses</h5>
            </x-slot>
            
            <div class="mb-3">
                <form action="{{ route('enrollments.registration') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by course name or code" name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select name="semester" class="form-select" onchange="this.form.submit()">
                            <option value="">All Semesters</option>
                            @foreach(\App\Models\Course::select('semester')->distinct()->pluck('semester') as $semester)
                                <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('enrollments.registration') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
            
            <form action="{{ route('enrollments.register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="academic_year" class="form-label">Academic Year <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('academic_year') is-invalid @enderror" id="academic_year" name="academic_year" value="{{ old('academic_year') }}" required>
                    @error('academic_year')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('semester') is-invalid @enderror" id="semester" name="semester" value="{{ old('semester') }}" required>
                    @error('semester')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">Select</th>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th>Credits</th>
                                <th>Lecturer</th>
                                <th>Schedule</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $student = auth()->user()->student;
                                $enrolledCourseIds = $student->enrollments()->pluck('course_id')->toArray();
                            @endphp
                            
                            @forelse($courses as $course)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="course_ids[]" value="{{ $course->id }}" id="course{{ $course->id }}" {{ in_array($course->id, $enrolledCourseIds) ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>{{ $course->code }}</td>
                                    <td>
                                        {{ $course->name }}
                                        @if(in_array($course->id, $enrolledCourseIds))
                                            <span class="badge bg-info">Already Enrolled</span>
                                        @endif
                                    </td>
                                    <td>{{ $course->credits }}</td>
                                    <td>{{ $course->lecturer ? $course->lecturer->full_name : 'Not Assigned' }}</td>
                                    <td>
                                        @if($course->schedules()->count() > 0)
                                            @foreach($course->schedules as $schedule)
                                                <div class="mb-1">
                                                    {{ $schedule->day }}, {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}, Room {{ $schedule->room }}
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No schedule yet</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No courses available for registration.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        {{ $courses->links() }}
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle me-1"></i> Register Selected Courses
                        </button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
    
    <div class="col-md-4">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Registration Information</h5>
            </x-slot>
            
            <div class="alert alert-info">
                <i class="fas fa-exclamation-circle me-2"></i> Please read the following instructions before registering for courses:
            </div>
            
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Current Semester</span>
                    <span class="badge bg-primary">{{ $currentSemester ?? 'N/A' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Maximum Credits</span>
                    <span class="badge bg-primary">24</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Current Credits</span>
                    <span class="badge bg-primary">
                        @php
                            $currentCredits = 0;
                            foreach(auth()->user()->student->enrollments()->where('status', 'active')->with('course')->get() as $enrollment) {
                                $currentCredits += $enrollment->course->credits;
                            }
                            echo $currentCredits;
                        @endphp
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Available Credits</span>
                    <span class="badge bg-success">{{ 24 - $currentCredits }}</span>
                </li>
            </ul>
            
            <h6>Registration Guidelines</h6>
            <ol>
                <li>You can register for courses up to a maximum of 24 credits per semester.</li>
                <li>Make sure there are no schedule conflicts between the courses you select.</li>
                <li>Some courses may have prerequisites that you must complete first.</li>
                <li>The registration period is limited, so register early to secure your spot.</li>
                <li>You can drop courses within the first two weeks of the semester.</li>
            </ol>
            
            <h6 class="mt-3">Current Enrollments</h6>
            <ul class="list-group list-group-flush">
                @forelse(auth()->user()->student->enrollments()->where('status', 'active')->with('course')->latest()->take(5)->get() as $enrollment)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $enrollment->course->name }}</span>
                        <span class="badge bg-primary">{{ $enrollment->course->credits }} credits</span>
                    </li>
                @empty
                    <li class="list-group-item text-center">No active enrollments.</li>
                @endforelse
            </ul>
        </x-card>
    </div>
</div>
@endsection