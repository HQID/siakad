<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Information System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/images/campus.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-university me-2"></i>Academic Information System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-2" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Welcome to Academic Information System</h1>
            <p class="lead mb-5">A comprehensive solution for managing academic activities, student records, and course information.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3">Go to Dashboard</a>
            @else
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3">Register</a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Key Features</h2>
                <p class="lead text-muted">Discover what our system can do for you</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-user-graduate feature-icon"></i>
                            <h4>Student Management</h4>
                            <p class="text-muted">Comprehensive student profiles, academic records, and enrollment management.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-chalkboard-teacher feature-icon"></i>
                            <h4>Faculty Portal</h4>
                            <p class="text-muted">Tools for lecturers to manage courses, schedules, and grade submissions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-book feature-icon"></i>
                            <h4>Course Management</h4>
                            <p class="text-muted">Create and manage courses, enrollments, and academic schedules.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-calendar-alt feature-icon"></i>
                            <h4>Scheduling</h4>
                            <p class="text-muted">Efficient class scheduling and room allocation system.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-chart-line feature-icon"></i>
                            <h4>Grade Management</h4>
                            <p class="text-muted">Record, calculate, and analyze student grades and academic performance.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-clipboard-list feature-icon"></i>
                            <h4>Course Registration</h4>
                            <p class="text-muted">Online course registration and enrollment management for students.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 bg-light" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-4">About Our System</h2>
                    <p class="lead">The Academic Information System is designed to streamline academic processes and enhance the educational experience for students, faculty, and administrators.</p>
                    <p>Our system provides a comprehensive solution for managing all aspects of academic operations, from student enrollment and course registration to grade management and scheduling. With a user-friendly interface and powerful features, we aim to simplify administrative tasks and improve communication between all stakeholders in the educational process.</p>
                    <p>Whether you're a student checking your grades, a lecturer managing your courses, or an administrator overseeing the entire academic program, our system provides the tools you need to succeed.</p>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">System Benefits</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Streamlined administrative processes</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Improved communication between students and faculty</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Real-time access to academic information</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Enhanced data security and privacy</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Comprehensive reporting and analytics</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>User-friendly interface for all stakeholders</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Contact Us</h2>
                <p class="lead text-muted">Get in touch with our support team</p>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Send us a message</h4>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Your name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Your email">
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" placeholder="Message subject">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="4" placeholder="Your message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Contact Information</h4>
                            <ul class="list-unstyled">
                                <li class="d-flex mb-4">
                                    <i class="fas fa-map-marker-alt text-primary me-3 mt-1" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Address</h5>
                                        <p class="text-muted mb-0">123 University Avenue, Academic City, 12345</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-4">
                                    <i class="fas fa-phone text-primary me-3 mt-1" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Phone</h5>
                                        <p class="text-muted mb-0">+1 (123) 456-7890</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-4">
                                    <i class="fas fa-envelope text-primary me-3 mt-1" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Email</h5>
                                        <p class="text-muted mb-0">support@academicsystem.edu</p>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <i class="fas fa-clock text-primary me-3 mt-1" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Working Hours</h5>
                                        <p class="text-muted mb-0">Monday - Friday: 8:00 AM - 5:00 PM</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <h5>Follow Us</h5>
                                <div class="d-flex gap-3 mt-3">
                                    <a href="#" class="text-primary fs-4"><i class="fab fa-facebook"></i></a>
                                    <a href="#" class="text-info fs-4"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="text-danger fs-4"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="text-primary fs-4"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5><i class="fas fa-university me-2"></i>Academic Information System</h5>
                    <p class="text-muted mt-3">A comprehensive solution for managing academic activities, student records, and course information.</p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Home</a></li>
                        <li><a href="#features" class="text-muted">Features</a></li>
                        <li><a href="#about" class="text-muted">About</a></li>
                        <li><a href="#contact" class="text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Help Center</a></li>
                        <li><a href="#" class="text-muted">Documentation</a></li>
                        <li><a href="#" class="text-muted">API</a></li>
                        <li><a href="#" class="text-muted">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Newsletter</h5>
                    <p class="text-muted">Subscribe to our newsletter for updates</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="text-center">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} Academic Information System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>