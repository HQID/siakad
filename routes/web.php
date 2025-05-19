<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

// Authentication Routes - These should NOT be inside the auth middleware
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout route (can be accessed by authenticated users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Student Routes
    Route::resource('students', StudentController::class);
    Route::get('/my-students', [StudentController::class, 'myStudents'])->name('students.my');
    
    // Lecturer Routes
    Route::resource('lecturers', LecturerController::class);
    
    // Course Routes
    Route::resource('courses', CourseController::class);
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('courses.my');
    
    // Grade Routes
    Route::resource('grades', GradeController::class);
    Route::get('/my-grades', [GradeController::class, 'myGrades'])->name('grades.my');
    Route::get('/lecturer-grades', [GradeController::class, 'lecturerIndex'])->name('grades.lecturer');
    
    // Schedule Routes
    Route::resource('schedules', ScheduleController::class);
    
    // Enrollment Routes
    Route::get('/my-enrollments', [EnrollmentController::class, 'myEnrollments'])->name('enrollments.my');
    Route::get('/course-registration', [EnrollmentController::class, 'registration'])->name('enrollments.registration');
    Route::post('/course-registration', [EnrollmentController::class, 'register'])->name('enrollments.register');
    Route::get('/enrollments/download-pdf', [EnrollmentController::class, 'downloadPdf'])->name('enrollments.downloadPdf');
});