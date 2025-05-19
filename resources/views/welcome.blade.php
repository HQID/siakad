<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Akademik Universitas Tadulako</title>
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
                <i class="fas fa-university me-2"></i>Sistem Informasi Akademik Universitas Tadulako
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-2" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Selamat Datang di Sistem Informasi Akademik Universitas Tadulako</h1>
            <p class="lead mb-5">Solusi lengkap untuk mengelola aktivitas akademik, data mahasiswa, dan informasi perkuliahan.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3">Masuk ke Dashboard</a>
            @else
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3">Daftar</a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Fitur Utama</h2>
                <p class="lead text-muted">Temukan apa yang dapat dilakukan sistem kami untuk Anda</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-user-graduate feature-icon"></i>
                            <h4>Manajemen Mahasiswa</h4>
                            <p class="text-muted">Profil mahasiswa lengkap, catatan akademik, dan manajemen pendaftaran.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-chalkboard-teacher feature-icon"></i>
                            <h4>Portal Dosen</h4>
                            <p class="text-muted">Alat bagi dosen untuk mengelola perkuliahan, jadwal, dan pengisian nilai.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-book feature-icon"></i>
                            <h4>Manajemen Mata Kuliah</h4>
                            <p class="text-muted">Buat dan kelola mata kuliah, pendaftaran, dan jadwal akademik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-calendar-alt feature-icon"></i>
                            <h4>Penjadwalan</h4>
                            <p class="text-muted">Sistem penjadwalan kelas dan alokasi ruangan yang efisien.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-chart-line feature-icon"></i>
                            <h4>Manajemen Nilai</h4>
                            <p class="text-muted">Catat, hitung, dan analisis nilai serta kinerja akademik mahasiswa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-clipboard-list feature-icon"></i>
                            <h4>Pendaftaran Mata Kuliah</h4>
                            <p class="text-muted">Pendaftaran mata kuliah dan manajemen pendaftaran secara online untuk mahasiswa.</p>
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
                    <h2 class="fw-bold mb-4">Tentang Sistem Kami</h2>
                    <p class="lead">Sistem Informasi Akademik dirancang untuk menyederhanakan proses akademik dan meningkatkan pengalaman pendidikan bagi mahasiswa, dosen, dan administrator.</p>
                    <p>Sistem kami menyediakan solusi komprehensif untuk mengelola semua aspek operasional akademik, mulai dari pendaftaran mahasiswa dan pendaftaran mata kuliah hingga manajemen nilai dan penjadwalan. Dengan antarmuka yang ramah pengguna dan fitur-fitur yang kuat, kami bertujuan untuk menyederhanakan tugas administratif dan meningkatkan komunikasi antara semua pemangku kepentingan dalam proses pendidikan.</p>
                    <p>Apakah Anda seorang mahasiswa yang memeriksa nilai, dosen yang mengelola perkuliahan, atau administrator yang mengawasi seluruh program akademik, sistem kami menyediakan alat yang Anda butuhkan untuk sukses.</p>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Manfaat Sistem</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Proses administratif yang lebih efisien</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Komunikasi yang lebih baik antara mahasiswa dan dosen</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Akses informasi akademik secara real-time</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Keamanan dan privasi data yang lebih baik</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Laporan dan analisis yang komprehensif</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <span>Antarmuka yang ramah pengguna untuk semua pemangku kepentingan</span>
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
                <h2 class="fw-bold">Hubungi Kami</h2>
                <p class="lead text-muted">Hubungi tim dukungan kami</p>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Kirim pesan kepada kami</h4>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" placeholder="Nama Anda">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email Anda">
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subjek</label>
                                    <input type="text" class="form-control" id="subject" placeholder="Subjek pesan">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" rows="4" placeholder="Pesan Anda"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Informasi Kontak</h4>
                            <ul class="list-unstyled">
                                <li class="d-flex mb-4">
                                    <i class="fas fa-map-marker-alt text-primary me-3 mt-1" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Alamat</h5>
                                        <p class="text-muted mb-0">123 University Avenue, Academic City, 12345</p>
                                    </div>
                                </li>
                                <li class="d-flex mb-4">
                                    <i class="fas fa-phone text-primary me-3 mt-1" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h5 class="mb-1">Telepon</h5>
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
                                        <h5 class="mb-1">Jam Kerja</h5>
                                        <p class="text-muted mb-0">Senin - Jumat: 8:00 AM - 5:00 PM</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <h5>Ikuti Kami</h5>
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
                    <h5><i class="fas fa-university me-2"></i>Sistem Informasi Akademik Universitas Tadulako</h5>
                    <p class="text-muted mt-3">Solusi lengkap untuk mengelola aktivitas akademik, data mahasiswa, dan informasi perkuliahan.</p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>Tautan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Beranda</a></li>
                        <li><a href="#features" class="text-muted">Fitur</a></li>
                        <li><a href="#about" class="text-muted">Tentang</a></li>
                        <li><a href="#contact" class="text-muted">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5>Sumber Daya</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-muted">Dokumentasi</a></li>
                        <li><a href="#" class="text-muted">API</a></li>
                        <li><a href="#" class="text-muted">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Newsletter</h5>
                    <p class="text-muted">Daftar ke newsletter kami untuk pembaruan</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email Anda">
                            <button class="btn btn-primary" type="submit">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="text-center">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} Sistem Informasi Akademik Universitas Tadulako. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>