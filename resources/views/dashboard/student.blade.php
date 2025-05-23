@php
    $student = auth()->user()->student;
    $enrollmentCount = $student ? $student->enrollments()->count() : 0;
    $completedCourses = $student ? $student->enrollments()->where('status', 'completed')->count() : 0;
    $currentSemester = $student ? $student->enrollments()->max('semester') : 'N/A';
@endphp

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Mata Kuliah</h6>
                        <h2 class="mb-0">{{ $enrollmentCount }}</h2>
                    </div>
                    <i class="fas fa-book fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('enrollments.my') }}" class="text-white text-decoration-none small">Lihat Detail</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Selesai</h6>
                        <h2 class="mb-0">{{ $completedCourses }}</h2>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('enrollments.my') }}" class="text-white text-decoration-none small">Lihat Detail</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Semester Saat Ini</h6>
                        <h2 class="mb-0">{{ $currentSemester }}</h2>
                    </div>
                    <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-white text-decoration-none small">Kemajuan Akademik</span>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">IPK</h6>
                        <h2 class="mb-0">
                            @if($student && $student->enrollments()->whereHas('grade')->count() > 0)
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
                            @else
                                N/A
                            @endif
                        </h2>
                    </div>
                    <i class="fas fa-star fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('grades.my') }}" class="text-white text-decoration-none small">Lihat Nilai</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <x-card>
            <x-slot name="header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Jadwal Hari Ini</h5>
                    <span class="badge bg-primary">{{ now()->format('l, d F Y') }}</span>
                </div>
            </x-slot>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Waktu</th>
                            <th>Ruangan</th>
                            <th>Dosen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($student)
                            @php
                                $todaySchedules = \App\Models\Schedule::whereHas('course.enrollments', function($query) use ($student) {
                                    $query->where('student_id', $student->id);
                                })->where('day', now()->format('l'))->orderBy('start_time')->get();
                            @endphp
                            
                            @forelse($todaySchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                    <td>{{ $schedule->room }}</td>
                                    <td>{{ $schedule->course->lecturer ? $schedule->course->lecturer->full_name : 'Belum Ditentukan' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada jadwal untuk hari ini.</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="4" class="text-center">Profil mahasiswa tidak ditemukan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </x-card>
        
        <x-card class="mt-4">
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Pendaftaran Saat Ini</h5>
            </x-slot>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Dosen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($student)
                            @php
                                $currentEnrollments = $student->enrollments()
                                    ->with(['course.lecturer'])
                                    ->where('status', 'active')
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp
                            
                            @forelse($currentEnrollments as $enrollment)
                                <tr>
                                    <td>{{ $enrollment->course->code }}</td>
                                    <td>{{ $enrollment->course->name }}</td>
                                    <td>{{ $enrollment->course->credits }}</td>
                                    <td>{{ $enrollment->course->lecturer ? $enrollment->course->lecturer->full_name : 'Belum Ditentukan' }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ ucfirst($enrollment->status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada pendaftaran aktif ditemukan.</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Profil mahasiswa tidak ditemukan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <x-slot name="footer">
                <a href="{{ route('enrollments.my') }}" class="btn btn-sm btn-primary">Lihat Semua Pendaftaran</a>
            </x-slot>
        </x-card>
    </div>
    
    <div class="col-md-4">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Profil Mahasiswa</h5>
            </x-slot>
            
            @if($student)
                <div class="text-center mb-4">
                    <div class="avatar avatar-lg mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h5>{{ $student->full_name }}</h5>
                    <p class="text-muted mb-1">{{ $student->nim }}</p>
                    <p class="text-muted mb-0">{{ $student->major }}</p>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-envelope me-2"></i> Email</span>
                        <span>{{ auth()->user()->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-phone me-2"></i> Telepon</span>
                        <span>{{ $student->phone_number ?: 'Belum diatur' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-calendar me-2"></i> Tahun Masuk</span>
                        <span>{{ $student->entry_year }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-venus-mars me-2"></i> Jenis Kelamin</span>
                        <span>{{ $student->gender ? ucfirst($student->gender) : 'Belum diatur' }}</span>
                    </li>
                </ul>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Profil mahasiswa tidak ditemukan. Silakan hubungi administrator.
                </div>
            @endif
            
            <x-slot name="footer">
                <a href="#" class="btn btn-sm btn-primary">Edit Profil</a>
            </x-slot>
        </x-card>
        
        <x-card class="mt-4">
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-star me-2"></i> Nilai Terbaru</h5>
            </x-slot>
            
            @if($student)
                @php
                    $recentGrades = $student->enrollments()
                        ->with(['course', 'grade'])
                        ->whereHas('grade')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp
                
                @if($recentGrades->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($recentGrades as $enrollment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $enrollment->course->name }}</span>
                                <span class="badge bg-{{ $enrollment->grade->grade_letter == 'A' || $enrollment->grade->grade_letter == 'A-' ? 'success' : ($enrollment->grade->grade_letter == 'B+' || $enrollment->grade->grade_letter == 'B' || $enrollment->grade->grade_letter == 'B-' ? 'primary' : ($enrollment->grade->grade_letter == 'C+' || $enrollment->grade->grade_letter == 'C' ? 'warning' : 'danger')) }}">
                                    {{ $enrollment->grade->grade_letter }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <p>Belum ada nilai tersedia.</p>
                    </div>
                @endif
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> Profil mahasiswa tidak ditemukan.
                </div>
            @endif
            
            <x-slot name="footer">
                <a href="{{ route('grades.my') }}" class="btn btn-sm btn-primary">Lihat Semua Nilai</a>
            </x-slot>
        </x-card>
    </div>
</div>