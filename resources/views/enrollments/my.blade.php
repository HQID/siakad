@extends('layouts.app')

@section('title', 'Pendaftaran Saya - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pendaftaran Saya</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('enrollments.registration') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Daftar Mata Kuliah
        </a>
        <a href="{{ route('enrollments.downloadPdf') }}" class="btn btn-sm btn-secondary ms-2">
            <i class="fas fa-file-pdf me-1"></i> Unduh PDF
        </a>
    </div>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('enrollments.my') }}" method="GET" class="row g-3">
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
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dibatalkan</option>
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
            <th>Kode Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Dosen</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Nilai</th>
        </x-slot>
        
        @forelse($enrollments as $index => $enrollment)
            <tr>
                <td>{{ $enrollments->firstItem() + $index }}</td>
                <td>{{ $enrollment->course->code }}</td>
                <td>{{ $enrollment->course->name }}</td>
                <td>{{ $enrollment->course->credits }}</td>
                <td>{{ $enrollment->course->lecturer ? $enrollment->course->lecturer->full_name : 'Belum Ditentukan' }}</td>
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
                        <span class="badge bg-secondary">Belum Dinilai</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada pendaftaran ditemukan.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $enrollments->links() }}
    </div>
</x-card>
@endsection