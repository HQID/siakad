@extends('layouts.app')

@section('title', 'Pendaftaran Mata Kuliah - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pendaftaran Mata Kuliah</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('enrollments.my') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Pendaftaran Saya
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Mata Kuliah Tersedia</h5>
            </x-slot>
            
            <div class="mb-3">
                <form action="{{ route('enrollments.registration') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau kode mata kuliah" name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select name="semester" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Semester</option>
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
                    <label for="academic_year" class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
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
                                <th width="5%">Pilih</th>
                                <th>Kode</th>
                                <th>Nama Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Dosen</th>
                                <th>Jadwal</th>
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
                                            <span class="badge bg-info">Sudah Terdaftar</span>
                                        @endif
                                    </td>
                                    <td>{{ $course->credits }}</td>
                                    <td>{{ $course->lecturer ? $course->lecturer->full_name : 'Belum Ditentukan' }}</td>
                                    <td>
                                        @if($course->schedules()->count() > 0)
                                            @foreach($course->schedules as $schedule)
                                                <div class="mb-1">
                                                    {{ $schedule->day }}, {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}, Ruangan {{ $schedule->room }}
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Belum ada jadwal</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada mata kuliah yang tersedia untuk pendaftaran.</td>
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
                            <i class="fas fa-check-circle me-1"></i> Daftarkan Mata Kuliah Terpilih
                        </button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
    
    <div class="col-md-4">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Informasi Pendaftaran</h5>
            </x-slot>
            
            <div class="alert alert-info">
                <i class="fas fa-exclamation-circle me-2"></i> Silakan baca petunjuk berikut sebelum mendaftar mata kuliah:
            </div>
            
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Semester Saat Ini</span>
                    <span class="badge bg-primary">{{ $currentSemester ?? 'N/A' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>SKS Maksimum</span>
                    <span class="badge bg-primary">24</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>SKS Saat Ini</span>
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
                    <span>SKS Tersedia</span>
                    <span class="badge bg-success">{{ 24 - $currentCredits }}</span>
                </li>
            </ul>
            
            <h6>Petunjuk Pendaftaran</h6>
            <ol>
                <li>Anda dapat mendaftar hingga maksimum 24 SKS per semester.</li>
                <li>Pastikan tidak ada konflik jadwal antara mata kuliah yang Anda pilih.</li>
                <li>Beberapa mata kuliah mungkin memiliki prasyarat yang harus Anda penuhi terlebih dahulu.</li>
                <li>Periode pendaftaran terbatas, jadi daftarlah lebih awal untuk mengamankan tempat Anda.</li>
                <li>Anda dapat membatalkan mata kuliah dalam dua minggu pertama semester.</li>
            </ol>
            
            <h6 class="mt-3">Pendaftaran Saat Ini</h6>
            <ul class="list-group list-group-flush">
                @forelse(auth()->user()->student->enrollments()->where('status', 'active')->with('course')->latest()->take(5)->get() as $enrollment)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $enrollment->course->name }}</span>
                        <span class="badge bg-primary">{{ $enrollment->course->credits }} SKS</span>
                    </li>
                @empty
                    <li class="list-group-item text-center">Belum ada pendaftaran aktif.</li>
                @endforelse
            </ul>
        </x-card>
    </div>
</div>
@endsection