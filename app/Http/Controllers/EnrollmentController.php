<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;

class EnrollmentController extends Controller
{
    public function myEnrollments(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        $query = $student->enrollments()->with('course', 'grade')->latest();

        if ($request->has('search')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->paginate(10);

        return view('enrollments.my', compact('enrollments'));
    }

    public function registration(Request $request)
    {
        $query = Course::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        $courses = $query->paginate(10);
        $currentSemester = now()->format('Y') . ' / ' . (now()->month > 6 ? 'Odd' : 'Even');

        return view('enrollments.registration', compact('courses', 'currentSemester'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string',
            'semester' => 'required|string',
            'course_ids' => 'required|array',
        ]);

        $student = auth()->user()->student;

        foreach ($request->course_ids as $courseId) {
            $student->enrollments()->create([
                'course_id' => $courseId,
                'academic_year' => $request->academic_year,
                'semester' => $request->semester,
                'status' => 'active',
            ]);
        }

        return redirect()->route('enrollments.my')->with('success', 'Courses registered successfully.');
    }

    public function downloadPdf()
    {
        $enrollments = auth()->user()->student->enrollments()->with('course', 'grade')->get();

        $pdf = Pdf::loadView('enrollments.pdf', compact('enrollments'));
        return $pdf->download('my_enrollments.pdf');
    }
}
