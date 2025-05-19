@extends('layouts.app')

@section('title', 'Daftar Jadwal - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Jadwal</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Jadwal Baru
        </a>
    </div>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('schedules.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="day" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Hari</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                        <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
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
                <select name="room" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Ruangan</option>
                    @foreach(\App\Models\Schedule::select('room')->distinct()->pluck('room') as $room)
                        <option value="{{ $room }}" {{ request('room') == $room ? 'selected' : '' }}>{{ $room }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <x-table>
        <x-slot name="header">
            <th>#</th>
            <th>Mata Kuliah</th>
            <th>Hari</th>
            <th>Waktu</th>
            <th>Ruangan</th>
            <th>Dosen</th>
            <th>Tahun Akademik</th>
            <th>Aksi</th>
        </x-slot>
        
        @forelse($schedules as $index => $schedule)
            <tr>
                <td>{{ $schedules->firstItem() + $index }}</td>
                <td>{{ $schedule->course->name }} ({{ $schedule->course->code }})</td>
                <td>{{ $schedule->day }}</td>
                <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                <td>{{ $schedule->room }}</td>
                <td>{{ $schedule->course->lecturer ? $schedule->course->lecturer->full_name : 'Belum Ditentukan' }}</td>
                <td>{{ $schedule->academic_year }}, {{ $schedule->semester }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $schedule->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $schedule->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $schedule->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $schedule->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus jadwal ini?
                                    <p class="text-danger mt-2">Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST">
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
                <td colspan="8" class="text-center">Tidak ada jadwal ditemukan.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $schedules->links() }}
    </div>
</x-card>

<x-card class="mt-4">
    <x-slot name="header">
        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Jadwal Mingguan</h5>
    </x-slot>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="15%">Waktu / Hari</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $timeSlots = [
                        '08:00 - 09:40',
                        '10:00 - 11:40',
                        '13:00 - 14:40',
                        '15:00 - 16:40'
                    ];
                    
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                    
                    $allSchedules = \App\Models\Schedule::with('course.lecturer')->get()->groupBy('day');
                @endphp
                
                @foreach($timeSlots as $timeSlot)
                    <tr>
                        <td class="table-light">{{ $timeSlot }}</td>
                        @foreach($days as $day)
                            <td>
                                @if(isset($allSchedules[$day]))
                                    @foreach($allSchedules[$day] as $schedule)
                                        @php
                                            $scheduleStart = $schedule->start_time->format('H:i');
                                            $scheduleEnd = $schedule->end_time->format('H:i');
                                            $slotStart = explode(' - ', $timeSlot)[0];
                                            $slotEnd = explode(' - ', $timeSlot)[1];
                                        @endphp
                                        
                                        @if($scheduleStart >= $slotStart && $scheduleEnd <= $slotEnd)
                                            <div class="p-2 bg-primary text-white rounded mb-1">
                                                <strong>{{ $schedule->course->code }}</strong><br>
                                                {{ $scheduleStart }} - {{ $scheduleEnd }}<br>
                                                Ruangan: {{ $schedule->room }}<br>
                                                <small>{{ $schedule->course->lecturer ? $schedule->course->lecturer->full_name : 'Belum Ditentukan' }}</small>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>
@endsection