@extends('layouts.app')

@section('title', 'Detail Dosen - Sistem Informasi Akademik Universitas Tadulako')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Dosen</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lecturers.edit', $lecturer) }}" class="btn btn-sm btn-warning me-2">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('lecturers.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Dosen
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i> Profil Dosen</h5>
            </x-slot>
            
            <div class="text-center mb-4">
                <div class="avatar avatar-lg mb-3">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>
                <h4>{{ $lecturer->full_name }}</h4>
                <p class="text-muted mb-1">{{ $lecturer->nip }}</p>
                <p class="badge bg-primary">{{ $lecturer->academic_degree ?: 'Tidak Ada Gelar' }}</p>
            </div>
            
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope me-2"></i> Email</span>
                    <span>{{ $lecturer->user->email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-phone me-2"></i> Telepon</span>
                    <span>{{ $lecturer->phone_number ?: 'Belum diatur' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-map-marker-alt me-2"></i> Alamat</span>
                    <span>{{ $lecturer->address ?: 'Belum diatur' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-book me-2"></i> Spesialisasi</span>
                    <span>{{ $lecturer->specialization ?: 'Tidak ditentukan' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-graduation-cap me-2"></i> Gelar Akademik</span>
                    <span>{{ $lecturer->academic_degree ?: 'Tidak ditentukan' }}</span>
                </li>
            </ul>
        </x-card>
    </div>
    
    <div class="col-md-8">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Mata Kuliah yang Diampu</h5>
            </x-slot>
            
            <x-table>
                <x-slot name="header">
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Mahasiswa</th>
                    <th>Aksi</th>
                </x-slot>
                
                @forelse($lecturer->courses()->withCount('enrollments')->get() as $course)
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
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada mata kuliah yang diampu.</td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>
        
        <x-card class="mt-4">
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Jadwal</h5>
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
                            
                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                            
                            $schedules = \App\Models\Schedule::whereHas('course', function($query) use ($lecturer) {
                                $query->where('lecturer_id', $lecturer->id);
                            })->get()->groupBy('day');
                        @endphp
                        
                        @foreach($timeSlots as $timeSlot)
                            <tr>
                                <td class="table-light">{{ $timeSlot }}</td>
                                @foreach($days as $day)
                                    <td>
                                        @if(isset($schedules[$day]))
                                            @foreach($schedules[$day] as $schedule)
                                                @php
                                                    $scheduleStart = $schedule->start_time->format('H:i');
                                                    $scheduleEnd = $schedule->end_time->format('H:i');
                                                    $slotStart = explode(' - ', $timeSlot)[0];
                                                    $slotEnd = explode(' - ', $timeSlot)[1];
                                                @endphp
                                                
                                                @if($scheduleStart >= $slotStart && $scheduleEnd <= $slotEnd)
                                                    <div class="p-2 bg-primary text-white rounded">
                                                        <strong>{{ $schedule->course->code }}</strong><br>
                                                        {{ $scheduleStart }} - {{ $scheduleEnd }}<br>
                                                        Ruang: {{ $schedule->room }}
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
    </div>
</div>
@endsection