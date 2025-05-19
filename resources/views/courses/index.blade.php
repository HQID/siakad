@extends('layouts.app')

@section('title', 'Daftar Mata Kuliah - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Mata Kuliah</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('courses.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Mata Kuliah Baru
        </a>
    </div>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('courses.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau kode" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select name="semester" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Semester</option>
                    @foreach(\App\Models\Course::select('semester')->distinct()->pluck('semester') as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="lecturer_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Dosen</option>
                    @foreach(\App\Models\Lecturer::orderBy('full_name')->get() as $lecturer)
                        <option value="{{ $lecturer->id }}" {{ request('lecturer_id') == $lecturer->id ? 'selected' : '' }}>{{ $lecturer->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <x-table>
        <x-slot name="header">
            <th>#</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Dosen</th>
            <th>Mahasiswa</th>
            <th>Aksi</th>
        </x-slot>
        
        @forelse($courses as $index => $course)
            <tr>
                <td>{{ $courses->firstItem() + $index }}</td>
                <td>{{ $course->code }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->credits }}</td>
                <td>{{ $course->semester }}</td>
                <td>{{ $course->lecturer ? $course->lecturer->full_name : 'Belum Ditentukan' }}</td>
                <td>{{ $course->enrollments_count ?? 0 }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $course->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $course->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $course->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $course->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus mata kuliah <strong>{{ $course->name }}</strong>?
                                    <p class="text-danger mt-2">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada mata kuliah ditemukan.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $courses->links() }}
    </div>
</x-card>
@endsection