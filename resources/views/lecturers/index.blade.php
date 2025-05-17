@extends('layouts.app')

@section('title', 'Lecturers - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Lecturers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lecturers.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Lecturer
        </a>
    </div>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('lecturers.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by name or NIP" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <select name="specialization" class="form-select" onchange="this.form.submit()">
                    <option value="">All Specializations</option>
                    @foreach(\App\Models\Lecturer::select('specialization')->distinct()->whereNotNull('specialization')->pluck('specialization') as $specialization)
                        <option value="{{ $specialization }}" {{ request('specialization') == $specialization ? 'selected' : '' }}>{{ $specialization }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <a href="{{ route('lecturers.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <x-table>
        <x-slot name="header">
            <th>#</th>
            <th>NIP</th>
            <th>Name</th>
            <th>Email</th>
            <th>Specialization</th>
            <th>Courses</th>
            <th>Actions</th>
        </x-slot>
        
        @forelse($lecturers as $index => $lecturer)
            <tr>
                <td>{{ $lecturers->firstItem() + $index }}</td>
                <td>{{ $lecturer->nip }}</td>
                <td>{{ $lecturer->full_name }}</td>
                <td>{{ $lecturer->user->email }}</td>
                <td>{{ $lecturer->specialization ?: 'Not specified' }}</td>
                <td>{{ $lecturer->courses()->count() }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('lecturers.show', $lecturer) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('lecturers.edit', $lecturer) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $lecturer->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $lecturer->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $lecturer->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $lecturer->id }}">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete lecturer <strong>{{ $lecturer->full_name }}</strong>?
                                    <p class="text-danger mt-2">This action cannot be undone and will delete all related data.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('lecturers.destroy', $lecturer) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No lecturers found.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $lecturers->links() }}
    </div>
</x-card>
@endsection