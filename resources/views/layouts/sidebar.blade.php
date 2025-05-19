<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Beranda
            </a>
        </li>

        @if(auth()->user()->isAdmin())
            <li class="nav-item">
                <a class="nav-link {{ request()->is('students*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                    <i class="fas fa-user-graduate"></i> Mahasiswa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('lecturers*') ? 'active' : '' }}" href="{{ route('lecturers.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i> Dosen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('courses*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                    <i class="fas fa-book"></i> Mata Kuliah
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('schedules*') ? 'active' : '' }}" href="{{ route('schedules.index') }}">
                    <i class="fas fa-calendar-alt"></i> Jadwal
                </a>
            </li>
        @endif

        @if(auth()->user()->isLecturer())
            <li class="nav-item">
                <a class="nav-link {{ request()->is('my-courses*') ? 'active' : '' }}" href="{{ route('courses.my') }}">
                    <i class="fas fa-book"></i> Mata Kuliah Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('my-students*') ? 'active' : '' }}" href="{{ route('students.my') }}">
                    <i class="fas fa-user-graduate"></i> Mahasiswa Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('grades*') ? 'active' : '' }}" href="{{ route('grades.index') }}">
                    <i class="fas fa-star"></i> Nilai
                </a>
            </li>
        @endif

        @if(auth()->user()->isStudent())
            <li class="nav-item">
                <a class="nav-link {{ request()->is('my-enrollments*') ? 'active' : '' }}" href="{{ route('enrollments.my') }}">
                    <i class="fas fa-clipboard-list"></i> Pendaftaran Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('my-grades*') ? 'active' : '' }}" href="{{ route('grades.my') }}">
                    <i class="fas fa-star"></i> Nilai Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('course-registration*') ? 'active' : '' }}" href="{{ route('enrollments.registration') }}">
                    <i class="fas fa-plus-circle"></i> Registrasi Mata Kuliah
                </a>
            </li>
        @endif
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Sistem</span>
    </h6>
    <ul class="nav flex-column mb-2">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </li>
    </ul>
</div>