<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Course;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::with('course.lecturer')
            ->when($request->day, fn($query) => $query->where('day', $request->day))
            ->when($request->course_id, fn($query) => $query->where('course_id', $request->course_id))
            ->when($request->room, fn($query) => $query->where('room', $request->room))
            ->paginate(10);

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|string',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|string',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
