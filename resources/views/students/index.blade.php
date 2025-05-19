@extends('layouts.app')

@section('title', 'Mahasiswa - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mahasiswa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Mahasiswa Baru
        </a>
    </div>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('students.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau NIM" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select name="major" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Program Studi</option>
                    @foreach(\App\Models\Student::select('major')->distinct()->pluck('major') as $major)
                        <option value="{{ $major }}" {{ request('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="entry_year" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Tahun Masuk</option>
                    @foreach(\App\Models\Student::select('entry_year')->distinct()->orderBy('entry_year', 'desc')->pluck('entry_year') as $year)
                        <option value="{{ $year }}" {{ request('entry_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <x-table>
        <x-slot name="header">
            <th>#</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Program Studi</th>
            <th>Tahun Masuk</th>
            <th>Aksi</th>
        </x-slot>
        
        @forelse($students as $index => $student)
            <tr>
                <td>{{ $students->firstItem() + $index }}</td>
                <td>{{ $student->nim }}</td>
                <td>{{ $student->full_name }}</td>
                <td>{{ $student->user->email }}</td>
                <td>{{ $student->major }}</td>
                <td>{{ $student->entry_year }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $student->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus mahasiswa <strong>{{ $student->full_name }}</strong>?
                                    <p class="text-danger mt-2">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST">
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
                <td colspan="7" class="text-center">Tidak ada mahasiswa ditemukan.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $students->links() }}
    </div>
</x-card>
@endsection