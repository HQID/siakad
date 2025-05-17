@extends('layouts.app')

@section('title', 'Schedules - Academic Information System')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Schedules</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Schedule
        </a>
    </div>
</div>

<x-card>
    <div class="mb-3">
        <form action="{{ route('schedules.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="day" class="form-select" onchange="this.form.submit()">
                    <option value="">All Days</option>
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="course_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Courses</option>
                    @foreach(\App\Models\Course::orderBy('name')->get() as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="room" class="form-select" onchange="this.form.submit()">
                    <option value="">All Rooms</option>
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
            <th>Course</th>
            <th>Day</th>
            <th>Time</th>
            <th>Room</th>
            <th>Lecturer</th>
            <th>Academic Year</th>
            <th>Actions</th>
        </x-slot>
        
        @forelse($schedules as $index => $schedule)
            <tr>
                <td>{{ $schedules->firstItem() + $index }}</td>
                <td>{{ $schedule->course->name }} ({{ $schedule->course->code }})</td>
                <td>{{ $schedule->day }}</td>
                <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                <td>{{ $schedule->room }}</td>
                <td>{{ $schedule->course->lecturer ? $schedule->course->lecturer->full_name : 'Not Assigned' }}</td>
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
                                    <h5 class="modal-title" id="deleteModalLabel{{ $schedule->id }}">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this schedule?
                                    <p class="text-danger mt-2">This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST">
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
                <td colspan="8" class="text-center">No schedules found.</td>
            </tr>
        @endforelse
    </x-table>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $schedules->links() }}
    </div>
</x-card>

<x-card class="mt-4">
    <x-slot name="header">
        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Weekly Schedule</h5>
    </x-slot>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="15%">Time / Day</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
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
                                                Room: {{ $schedule->room }}<br>
                                                <small>{{ $schedule->course->lecturer ? $schedule->course->lecturer->full_name : 'No Lecturer' }}</small>
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