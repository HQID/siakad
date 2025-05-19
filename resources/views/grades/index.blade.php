@extends('layouts.app')

@section('title', 'Nilai - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Nilai</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if(auth()->user()->isLecturer())
            <a href="{{ route('grades.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Nilai Baru
            </a>
        @endif
    </div>
</div>

@if(auth()->user()->isAdmin())
    <x-card>
        <div class="mb-3">
            <form action="{{ route('grades.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan mahasiswa atau mata kuliah" name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="course_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Mata Kuliah</option>
                        @foreach(\App\Models\Course::orderBy('name')->get() as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="grade_letter" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Nilai</option>
                        @foreach(['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'E'] as $grade)
                            <option value="{{ $grade }}" {{ request('grade_letter') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>

        <x-table>
            <x-slot name="header">
                <th>#</th>
                <th>Mahasiswa</th>
                <th>Mata Kuliah</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
                <th>Huruf Mutu</th>
                <th>Aksi</th>
            </x-slot>
            
            @forelse($grades as $index => $grade)
                <tr>
                    <td>{{ $grades->firstItem() + $index }}</td>
                    <td>{{ $grade->enrollment->student->full_name }}</td>
                    <td>{{ $grade->enrollment->course->name }}</td>
                    <td>{{ $grade->assignment_score }}</td>
                    <td>{{ $grade->mid_exam_score }}</td>
                    <td>{{ $grade->final_exam_score }}</td>
                    <td>{{ $grade->final_score }}</td>
                    <td>
                        <span class="badge bg-{{ $grade->grade_letter == 'A' || $grade->grade_letter == 'A-' ? 'success' : ($grade->grade_letter == 'B+' || $grade->grade_letter == 'B' || $grade->grade_letter == 'B-' ? 'primary' : ($grade->grade_letter == 'C+' || $grade->grade_letter == 'C' ? 'warning' : 'danger')) }}">
                            {{ $grade->grade_letter }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada nilai ditemukan.</td>
                </tr>
            @endforelse
        </x-table>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $grades->links() }}
        </div>
    </x-card>
@elseif(auth()->user()->isLecturer())
    <x-card>
        <div class="mb-3">
            <form action="{{ route('grades.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama mahasiswa" name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-5">
                    <select name="course_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Mata Kuliah Saya</option>
                        @foreach(auth()->user()->lecturer->courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>

        <x-table>
            <x-slot name="header">
                <th>#</th>
                <th>Mahasiswa</th>
                <th>Mata Kuliah</th>
                <th>Status</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </x-slot>
            
            @forelse($enrollments as $index => $enrollment)
                <tr>
                    <td>{{ $enrollments->firstItem() + $index }}</td>
                    <td>{{ $enrollment->student->full_name }} ({{ $enrollment->student->nim }})</td>
                    <td>{{ $enrollment->course->name }}</td>
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
                            <span class="badge bg-secondary">Belum Dinilai</span>
                        @endif
                    </td>
                    <td>
                        @if($enrollment->grade)
                            <a href="{{ route('grades.edit', $enrollment->grade) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit Nilai
                            </a>
                        @else
                            <a href="{{ route('grades.create', ['enrollment_id' => $enrollment->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Tambah Nilai
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pendaftaran ditemukan.</td>
                </tr>
            @endforelse
        </x-table>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $enrollments->links() }}
        </div>
    </x-card>
@endif
@endsection