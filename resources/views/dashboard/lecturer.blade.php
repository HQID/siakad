@php
    $lecturer = auth()->user()->lecturer;
    $courseCount = $lecturer ? $lecturer->courses()->count() : 0;
    $studentCount = $lecturer ? \App\Models\Enrollment::whereHas('course', function($query) use ($lecturer) {
        $query->where('lecturer_id', $lecturer->id);
    })->distinct('student_id')->count('student_id') : 0;
@endphp

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Mata Kuliah Saya</h6>
                        <h2 class="mb-0">{{ $courseCount }}</h2>
                    </div>
                    <i class="fas fa-book fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('courses.my') }}" class="text-white text-decoration-none small">Lihat Detail</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Mahasiswa Saya</h6>
                        <h2 class="mb-0">{{ $studentCount }}</h2>
                    </div>
                    <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('students.my') }}" class="text-white text-decoration-none small">Lihat Detail</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Nilai Belum Diberikan</h6>
                        <h2 class="mb-0">
                            {{ $lecturer ? \App\Models\Enrollment::whereHas('course', function($query) use ($lecturer) {
                                $query->where('lecturer_id', $lecturer->id);
                            })->whereDoesntHave('grade')->count() : 0 }}
                        </h2>
                    </div>
                    <i class="fas fa-star fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('grades.index') }}" class="text-white text-decoration-none small">Lihat Detail</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Mata Kuliah Saya</h5>
            </x-slot>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Mahasiswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($lecturer)
                            @foreach($lecturer->courses()->withCount('enrollments')->latest()->take(5)->get() as $course)
                                <tr>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->credits }}</td>
                                    <td>{{ $course->semester }}</td>
                                    <td>{{ $course->enrollments_count }}</td>
                                    <td>
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Belum ada mata kuliah yang ditugaskan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <x-slot name="footer">
                <a href="{{ route('courses.my') }}" class="btn btn-sm btn-primary">Lihat Semua Mata Kuliah Saya</a>
            </x-slot>
        </x-card>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
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
                        </tr>
                    </thead>
                    <tbody>
                        @if($lecturer)
                            @php
                                $todaySchedules = \App\Models\Schedule::whereHas('course', function($query) use ($lecturer) {
                                    $query->where('lecturer_id', $lecturer->id);
                                })->where('day', now()->format('l'))->orderBy('start_time')->get();
                            @endphp
                            
                            @forelse($todaySchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                    <td>{{ $schedule->room }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada jadwal untuk hari ini.</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="3" class="text-center">Profil dosen tidak ditemukan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>