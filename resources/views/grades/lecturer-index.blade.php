@extends('layouts.app')

@section('title', 'Nilai Dosen - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nilai Dosen</h1>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('grades.lecturer') }}" method="GET" class="row g-3">
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
                <a href="{{ route('grades.lecturer') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
@endsection
