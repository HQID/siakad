<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        // For admin view
        if (auth()->user()->isAdmin()) {
            $grades = Grade::with('enrollment.student', 'enrollment.course')->paginate(15);
            return view('grades.index', compact('grades'));
        }
        
        // For lecturer view
        if (auth()->user()->isLecturer()) {
            $lecturer = auth()->user()->lecturer;
            $enrollments = Enrollment::whereHas('course', function ($query) use ($lecturer) {
                $query->where('lecturer_id', $lecturer->id);
            })->with('student', 'course', 'grade')->paginate(15);
            
            return view('grades.lecturer-index', compact('enrollments'));
        }
        
        // For student view
        if (auth()->user()->isStudent()) {
            $student = auth()->user()->student;
            $enrollments = $student->enrollments()->with('course', 'grade')->paginate(15);
            
            return view('grades.student-index', compact('enrollments'));
        }
    }

    public function create()
    {
        $lecturer = auth()->user()->lecturer;
        $enrollments = Enrollment::whereHas('course', function ($query) use ($lecturer) {
            $query->where('lecturer_id', $lecturer->id);
        })->whereDoesntHave('grade')
          ->with('student', 'course')
          ->get();
        
        return view('grades.create', compact('enrollments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'assignment_score' => 'nullable|numeric|min:0|max:100',
            'mid_exam_score' => 'nullable|numeric|min:0|max:100',
            'final_exam_score' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $grade = new Grade($request->all());
        
        // Calculate final score and grade letter
        if ($request->filled('assignment_score') && $request->filled('mid_exam_score') && $request->filled('final_exam_score')) {
            $grade->calculateFinalScore();
        }
        
        $grade->save();

        return redirect()->route('grades.index')
            ->with('success', 'Grade recorded successfully.');
    }

    public function edit(Grade $grade)
    {
        // Check if the authenticated lecturer is assigned to the course
        if (auth()->user()->isLecturer()) {
            $lecturer = auth()->user()->lecturer;
            $enrollment = $grade->enrollment;
            
            if ($enrollment->course->lecturer_id != $lecturer->id) {
                return redirect()->route('grades.index')
                    ->with('error', 'You are not authorized to edit this grade.');
            }
        }
        
        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'assignment_score' => 'nullable|numeric|min:0|max:100',
            'mid_exam_score' => 'nullable|numeric|min:0|max:100',
            'final_exam_score' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $grade->fill($request->all());
        
        // Calculate final score and grade letter
        if ($request->filled('assignment_score') && $request->filled('mid_exam_score') && $request->filled('final_exam_score')) {
            $grade->calculateFinalScore();
        }
        
        $grade->save();

        return redirect()->route('grades.index')
            ->with('success', 'Grade updated successfully.');
    }

    public function myGrades(Request $request)
    {
        $student = auth()->user()->student;

        $enrollments = $student->enrollments()
            ->with('course', 'grade')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('course', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->when($request->semester, function ($query, $semester) {
                $query->where('semester', $semester);
            })
            ->when($request->academic_year, function ($query, $academicYear) {
                $query->where('academic_year', $academicYear);
            })
            ->paginate(15);

        return view('grades.student-index', compact('enrollments'));
    }

    public function lecturerIndex(Request $request)
    {
        $lecturer = auth()->user()->lecturer;

        $enrollments = Enrollment::whereHas('course', function ($query) use ($lecturer) {
            $query->where('lecturer_id', $lecturer->id);
        })
        ->with('student', 'course', 'grade')
        ->when($request->search, function ($query, $search) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%");
            });
        })
        ->when($request->course_id, function ($query, $courseId) {
            $query->where('course_id', $courseId);
        })
        ->paginate(15);

        return view('grades.lecturer-index', compact('enrollments'));
    }
}