<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Students</h6>
                        <h2 class="mb-0">{{ \App\Models\Student::count() }}</h2>
                    </div>
                    <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('students.index') }}" class="text-white text-decoration-none small">View Details</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Lecturers</h6>
                        <h2 class="mb-0">{{ \App\Models\Lecturer::count() }}</h2>
                    </div>
                    <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('lecturers.index') }}" class="text-white text-decoration-none small">View Details</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Courses</h6>
                        <h2 class="mb-0">{{ \App\Models\Course::count() }}</h2>
                    </div>
                    <i class="fas fa-book fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('courses.index') }}" class="text-white text-decoration-none small">View Details</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Enrollments</h6>
                        <h2 class="mb-0">{{ \App\Models\Enrollment::count() }}</h2>
                    </div>
                    <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="#" class="text-white text-decoration-none small">View Details</a>
                <i class="fas fa-arrow-circle-right text-white"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i> Recent Students</h5>
            </x-slot>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Name</th>
                            <th>Major</th>
                            <th>Entry Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Student::latest()->take(5)->get() as $student)
                            <tr>
                                <td>{{ $student->nim }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->major }}</td>
                                <td>{{ $student->entry_year }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <x-slot name="footer">
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary">View All Students</a>
            </x-slot>
        </x-card>
    </div>
    
    <div class="col-md-6">
        <x-card>
            <x-slot name="header">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i> Recent Courses</h5>
            </x-slot>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Credits</th>
                            <th>Lecturer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Course::with('lecturer')->latest()->take(5)->get() as $course)
                            <tr>
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->credits }}</td>
                                <td>{{ $course->lecturer ? $course->lecturer->full_name : 'Not Assigned' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <x-slot name="footer">
                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-primary">View All Courses</a>
            </x-slot>
        </x-card>
    </div>
</div>