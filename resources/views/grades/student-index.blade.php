@extends('layouts.app')

@section('title', 'Nilai Saya - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nilai Saya</h1>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('grades.my') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama mata kuliah" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select name="semester" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Semester</option>
                    @foreach(auth()->user()->student->enrollments()->select('semester')->distinct()->pluck('semester') as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="academic_year" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Tahun Akademik</option>
                    @foreach(auth()->user()->student->enrollments()->select('academic_year')->distinct()->pluck('academic_year') as $year)
                        <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('grades.my') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <x-table>
        <x-slot name="header">
            <th>#</th>
            <th>Mata Kuliah</th>
            <th>Semester</th>
            <th>Tahun Akademik</th>
            <th>Tugas</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>Nilai Akhir</th>
            <th>Huruf Mutu</th>
        </x-slot>
        
        @forelse($enrollments as $index => $enrollment)
            <tr>
                <td>{{ $enrollments->firstItem() + $index }}</td>
                <td>{{ $enrollment->course->name }} ({{ $enrollment->course->code }})</td>
                <td>{{ $enrollment->semester }}</td>
                <td>{{ $enrollment->academic_year }}</td>
                <td>{{ $enrollment->grade->assignment_score ?? 'N/A' }}</td>
                <td>{{ $enrollment->grade->mid_exam_score ?? 'N/A' }}</td>
                <td>{{ $enrollment->grade->final_exam_score ?? 'N/A' }}</td>
                <td>{{ $enrollment->grade->final_score ?? 'N/A' }}</td>
                <td>
                    @if($enrollment->grade)
                        <span class="badge bg-{{ $enrollment->grade->grade_letter == 'A' || $enrollment->grade->grade_letter == 'A-' ? 'success' : ($enrollment->grade->grade_letter == 'B+' || $enrollment->grade->grade_letter == 'B' || $enrollment->grade->grade_letter == 'B-' ? 'primary' : ($enrollment->grade->grade_letter == 'C+' || $enrollment->grade->grade_letter == 'C' ? 'warning' : 'danger')) }}">
                            {{ $enrollment->grade->grade_letter }}
                        </span>
                    @else
                        <span class="badge bg-secondary">Belum Dinilai</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada nilai ditemukan.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $enrollments->links() }}
    </div>
</x-card>

<div class="row mt-4">
    <div class="col-md-6">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Perhitungan IPK</h5>
            </x-slot>
            
            @php
                $totalPoints = 0;
                $totalCredits = 0;
                
                foreach(auth()->user()->student->enrollments()->with(['grade', 'course'])->whereHas('grade')->get() as $enrollment) {
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
            @endphp
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted">Total SKS</h6>
                            <h3 class="mb-0">{{ $totalCredits }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-title text-muted">Mata Kuliah Selesai</h6>
                            <h3 class="mb-0">{{ auth()->user()->student->enrollments()->whereHas('grade')->count() }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h6 class="card-title">IPK</h6>
                            <h3 class="mb-0">{{ $gpa }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
    
    <div class="col-md-6">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Distribusi Nilai</h5>
            </x-slot>
            
            @php
                $gradeDistribution = [
                    'A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 
                    'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0
                ];
                
                $totalGrades = 0;
                
                foreach(auth()->user()->student->enrollments()->with('grade')->whereHas('grade')->get() as $enrollment) {
                    if (isset($gradeDistribution[$enrollment->grade->grade_letter])) {
                        $gradeDistribution[$enrollment->grade->grade_letter]++;
                        $totalGrades++;
                    }
                }
            @endphp
            
            @if($totalGrades > 0)
                <div class="mt-3">
                    <div class="progress" style="height: 25px;">
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
                    </div>
                </div>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <p>Belum ada nilai yang tercatat.</p>
                </div>
            @endif
        </x-card>
    </div>
</div>
@endsection