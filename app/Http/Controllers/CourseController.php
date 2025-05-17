<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('lecturer')->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $lecturers = Lecturer::all();
        return view('courses.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:courses',
            'name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'semester' => 'required|string',
            'lecturer_id' => 'nullable|exists:lecturers,id',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load('lecturer', 'schedules', 'enrollments.student');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $lecturers = Lecturer::all();
        return view('courses.edit', compact('course', 'lecturers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'semester' => 'required|string',
            'lecturer_id' => 'nullable|exists:lecturers,id',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function myCourses()
    {
        $user = auth()->user();
        $courses = Course::where('lecturer_id', $user->id)->with('lecturer')->paginate(10);

        return view('courses.my', compact('courses'));
    }
}