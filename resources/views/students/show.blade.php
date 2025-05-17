@extends('layouts.app')

@section('title', 'Student Details - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Student Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning me-2">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Students
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Student Profile</h5>
            </x-slot>
            
            <div class="text-center mb-4">
                <div class="avatar avatar-lg mb-3">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>
                <h4>{{ $student->full_name }}</h4>
                <p class="text-muted mb-1">{{ $student->nim }}</p>
                <p class="badge bg-primary">{{ $student->major }}</p>
            </div>
            
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope me-2"></i> Email</span>
                    <span>{{ $student->user->email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-phone me-2"></i> Phone</span>
                    <span>{{ $student->phone_number ?: 'Not set' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-map-marker-alt me-2"></i> Address</span>
                    <span>{{ $student->address ?: 'Not set' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar me-2"></i> Birth Date</span>
                    <span>{{ $student->birth_date ? $student->birth_date->format('d F Y') : 'Not set' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-venus-mars me-2"></i> Gender</span>
                    <span>{{ $student->gender ? ucfirst($student->gender) : 'Not set' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-alt me-2"></i> Entry Year</span>
                    <span>{{ $student->entry_year }}</span>
                </li>
            </ul>
        </x-card>
    </div>
    
    <div class="col-md-8">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Enrolled Courses</h5>
            </x-slot>
            
            <x-table>
                <x-slot name="header">
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Semester</th>
                    <th>Academic Year</th>
                    <th>Status</th>
                    <th>Grade</th>
                </x-slot>
                
                @forelse($student->enrollments()->with(['course', 'grade'])->latest()->get() as $enrollment)
                    <tr>
                        <td>{{ $enrollment->course->code }}</td>
                        <td>{{ $enrollment->course->name }}</td>
                        <td>{{ $enrollment->semester }}</td>
                        <td>{{ $enrollment->academic_year }}</td>
                        <td>
                            <span class="badge bg-{{ $enrollment->status == 'active' ? 'success' : ($enrollment->status == 'completed' ? 'primary' : 'warning') }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                        <td>
                            @if($enrollment->grade)
                                <span class="badge bg-{{ $enrollment->grade->grade_letter == 'A' || $enrollment->grade->grade_letter == 'A-' ? 'success' : ($enrollment->grade->grade_letter == 'B+' || $enrollment->grade->grade_letter == 'B' || $enrollment->grade->grade_letter == 'B-' ? 'primary' : ($enrollment->grade->grade_letter == 'C+' || $enrollment->grade->grade_letter == 'C' ? 'warning' : 'danger')) }}">
                                    {{ $enrollment->grade->grade_letter }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Not Graded</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No courses enrolled yet.</td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>
        
        <x-card class="mt-4">
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Academic Summary</h5>
            </x-slot>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted">Total Credits</h6>
                            <h3 class="mb-0">
                                @php
                                    $totalCredits = 0;
                                    foreach($student->enrollments()->with('course')->whereHas('grade')->get() as $enrollment) {
                                        $totalCredits += $enrollment->course->credits;
                                    }
                                    echo $totalCredits;
                                @endphp
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted">Courses Taken</h6>
                            <h3 class="mb-0">{{ $student->enrollments()->count() }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted">Completed</h6>
                            <h3 class="mb-0">{{ $student->enrollments()->where('status', 'completed')->count() }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted">GPA</h6>
                            <h3 class="mb-0">
                                @php
                                    $totalPoints = 0;
                                    $totalCredits = 0;
                                    
                                    foreach($student->enrollments()->with(['grade', 'course'])->whereHas('grade')->get() as $enrollment) {
                                        $gradePoints = 0;
                                        switch($enrollment->grade->grade_letter) {
                                            case 'A': $gradePoints = 4.0; break;
                                            case 'A-': $gradePoints = 3.7; break;
                                            case 'B+': $gradePoints = 3.3; break;
                                            case 'B': $gradePoints = 3.0; break;
                                            case 'B-': $gradePoints = 2.7; break;
                                            case 'C+': $gradePoints = 2.3; break;
                                            case 'C': $gradePoints = 2.0; break;
                                            case 'D': $gradePoints = 1.0; break;
                                            case 'E': $gradePoints = 0.0; break;
                                        }
                                        
                                        $totalPoints += $gradePoints * $enrollment->course->credits;
                                        $totalCredits += $enrollment->course->credits;
                                    }
                                    
                                    $gpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
                                    echo $gpa;
                                @endphp
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <h6>Grade Distribution</h6>
                <div class="progress" style="height: 25px;">
                    @php
                        $gradeDistribution = [
                            'A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 
                            'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0
                        ];
                        
                        $totalGrades = 0;
                        
                        foreach($student->enrollments()->with('grade')->whereHas('grade')->get() as $enrollment) {
                            if (isset($gradeDistribution[$enrollment->grade->grade_letter])) {
                                $gradeDistribution[$enrollment->grade->grade_letter]++;
                                $totalGrades++;
                            }
                        }
                    @endphp
                    
                    @if($totalGrades > 0)
                        @foreach($gradeDistribution as $grade => $count)
                            @if($count > 0)
                                @php
                                    $percentage = ($count / $totalGrades) * 100;
                                    $color = match(true) {
                                        $grade == 'A' || $grade == 'A-' => 'success',
                                        $grade == 'B+' || $grade == 'B' || $grade == 'B-' => 'primary',
                                        $grade == 'C+' || $grade == 'C' => 'warning',
                                        default => 'danger'
                                    };
                                @endphp
                                <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percentage }}%" 
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $grade }} ({{ $count }})
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" 
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                            No grades yet
                        </div>
                    @endif
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection