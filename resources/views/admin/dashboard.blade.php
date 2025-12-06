<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI TEMA MODERN */
        body {
            background-color: #f0f2f5; /* Latar belakang abu-abu muda */
        }
        .navbar-custom {
            background: linear-gradient(90deg, #3b5998, #4c69b2); /* Gradasi pada Navbar */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .main-content {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        .list-group-custom .list-group-item {
            border: none;
            border-left: 5px solid transparent;
            font-weight: 500;
        }
        .list-group-custom .list-group-item.active {
            background-color: #e6f0ff; /* Light blue background for active */
            border-left-color: #3b5998; /* Blue accent bar */
            color: #3b5998;
            font-weight: 700;
        }
        /* Style untuk Statistik Card */
        .stat-card {
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.7;
            position: absolute;
            right: 15px;
            top: 15px;
        }
        .bg-card-primary { background: #3b5998 !important; }
        .bg-card-warning { background: #f0ad4e !important; }
        .bg-card-info { background: #5bc0de !important; }
        .bg-card-success { background: #5cb85c !important; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-cogs me-2"></i> Administrator PMB
            </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    Halo, <span class="fw-bold">{{ Auth::user()->name ?? 'Admin' }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-light btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="list-group list-group-custom shadow-lg">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-chart-line me-2"></i> Dashboard Statistik
                    </a>
                    <a href="{{ route('admin.verifikasi') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-check me-2"></i> Verifikasi Berkas
                    </a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users-cog me-2"></i> Manajemen User
                    </a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt me-2"></i> Pengaturan Jadwal
                    </a>
                    <a href="{{ route('admin.kelulusan') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-award me-2"></i> Manajemen Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="main-content">
                    <h4 class="mb-4 text-secondary"><i class="fas fa-chart-pie me-2"></i> Ringkasan Data Pendaftar</h4>

                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-card-primary stat-card">
                                <div class="card-body position-relative">
                                    <h6 class="card-title fw-bold">Total Pendaftar</h6>
                                    <p class="card-text display-4 mb-0">{{ $total_pendaftar ?? 0 }}</p>
                                    <i class="fas fa-user-graduate stat-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-white bg-card-warning stat-card">
                                <div class="card-body position-relative">
                                    <h6 class="card-title fw-bold">Perlu Verifikasi</h6>
                                    <p class="card-text display-4 mb-0">{{ $perlu_verifikasi ?? 0 }}</p>
                                    <i class="fas fa-hourglass-half stat-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-white bg-card-info stat-card">
                                <div class="card-body position-relative">
                                    <h6 class="card-title fw-bold">Siap Dinilai</h6>
                                    <p class="card-text display-4 mb-0">{{ $siap_nilai ?? 0 }}</p>
                                    <i class="fas fa-clipboard-check stat-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card text-white bg-card-success stat-card">
                                <div class="card-body position-relative">
                                    <h6 class="card-title fw-bold">Lulus Seleksi</h6>
                                    <p class="card-text display-4 mb-0">{{ $lulus_seleksi ?? 0 }}</p>
                                    <i class="fas fa-trophy stat-icon"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mt-5 shadow-sm">
                        <div class="card-header fw-bold bg-light">
                            <i class="fas fa-history me-1"></i> Aktivitas Terbaru Pendaftaran
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0">Belum ada data aktivitas terbaru pendaftar. (Anda bisa menambahkan daftar pendaftar terbaru di sini)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
