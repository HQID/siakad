@extends('layouts.app')

@section('title', 'Detail Mata Kuliah - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Mata Kuliah</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning me-2">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('courses.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Mata Kuliah
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Informasi Mata Kuliah</h5>
            </x-slot>
            
            <div class="text-center mb-4">
                <div class="avatar avatar-lg mb-3">
                    <i class="fas fa-book-open fa-5x text-primary"></i>
                </div>
                <h4>{{ $course->name }}</h4>
                <p class="text-muted mb-1">{{ $course->code }}</p>
                <p class="badge bg-primary">{{ $course->credits }} SKS</p>
            </div>
            
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-alt me-2"></i> Semester</span>
                    <span>{{ $course->semester }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-chalkboard-teacher me-2"></i> Dosen</span>
                    <span>{{ $course->lecturer ? $course->lecturer->full_name : 'Belum Ditentukan' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-users me-2"></i> Mahasiswa Terdaftar</span>
                    <span>{{ $course->enrollments()->count() }}</span>
                </li>
            </ul>
            
            @if($course->description)
                <div class="mt-3">
                    <h6>Deskripsi</h6>
                    <p>{{ $course->description }}</p>
                </div>
            @endif
        </x-card>
        
        <x-card class="mt-4">
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Jadwal</h5>
            </x-slot>
            
            @if($course->schedules()->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($course->schedules as $schedule)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-calendar-day me-2"></i> {{ $schedule->day }}</span>
                                <span class="badge bg-info">{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span><i class="fas fa-map-marker-alt me-2"></i> Ruangan {{ $schedule->room }}</span>
                                <span class="badge bg-secondary">{{ $schedule->academic_year }}, {{ $schedule->semester }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p>Belum ada jadwal untuk mata kuliah ini.</p>
                </div>
            @endif
            
            @if(auth()->user()->isAdmin())
                <x-slot name="footer">
                    <a href="{{ route('schedules.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Jadwal
                    </a>
                </x-slot>
            @endif
        </x-card>
    </div>
    
    <div class="col-md-8">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i> Mahasiswa Terdaftar</h5>
            </x-slot>
            
            <x-table>
                <x-slot name="header">
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tahun Akademik</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Nilai</th>
                </x-slot>
                
                @forelse($course->enrollments()->with(['student', 'grade'])->get() as $enrollment)
                    <tr>
                        <td>{{ $enrollment->student->nim }}</td>
                        <td>{{ $enrollment->student->full_name }}</td>
                        <td>{{ $enrollment->academic_year }}</td>
                        <td>{{ $enrollment->semester }}</td>
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
                                <span class="badge bg-secondary">Belum Dinilai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada mahasiswa yang terdaftar.</td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>
        
        <x-card class="mt-4">
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Distribusi Nilai</h5>
            </x-slot>
            
            @php
                $gradeDistribution = [
                    'A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 
                    'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0
                ];
                
                $totalGrades = 0;
                
                foreach($course->enrollments()->with('grade')->whereHas('grade')->get() as $enrollment) {
                    if (isset($gradeDistribution[$enrollment->grade->grade_letter])) {
                        $gradeDistribution[$enrollment->grade->grade_letter]++;
                        $totalGrades++;
                    }
                }
            @endphp
            
            @if($totalGrades > 0)
                <div class="row">
                    <div class="col-md-8">
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
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title text-muted">Rata-rata Kelas</h6>
                                <h3 class="mb-0">
                                    @php
                                        $totalPoints = 0;
                                        $totalStudents = 0;
                                        
                                        foreach($course->enrollments()->with('grade')->whereHas('grade')->get() as $enrollment) {
                                            $totalPoints += $enrollment->grade->final_score;
                                            $totalStudents++;
                                        }
                                        
                                        $average = $totalStudents > 0 ? round($totalPoints / $totalStudents, 2) : 0;
                                        echo $average;
                                    @endphp
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <p>Belum ada nilai yang tercatat untuk mata kuliah ini.</p>
                </div>
            @endif
        </x-card>
    </div>
</div>
@endsection