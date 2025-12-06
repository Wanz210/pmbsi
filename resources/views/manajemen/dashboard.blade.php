<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajemen Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI TEMA MODERN */
        body {
            background-color: #f0f2f5;
        }
        .navbar-custom {
            background: linear-gradient(90deg, #3b5998, #4c69b2);
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
            background-color: #e6f0ff;
            border-left-color: #3b5998;
            color: #3b5998;
            font-weight: 700;
        }
        .text-primary-dark {
            color: #3b5998 !important;
        }
        /* Style untuk Statistik Card */
        .stat-card {
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            position: relative;
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
        .bg-card-danger { background: #d9534f !important; } /* Merah untuk perlu tindakan */
        .bg-card-info { background: #5bc0de !important; }
        .bg-card-success { background: #5cb85c !important; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('manajemen.dashboard') }}">
                <i class="fas fa-chart-bar me-2"></i> Dashboard Manajemen Kampus
            </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    Halo, <span class="fw-bold">{{ Auth::user()->name ?? 'Manajemen' }}</span>
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
                    <a href="{{ route('manajemen.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home me-2"></i> Dashboard Ringkasan
                    </a>

                    <a href="{{ route('manajemen.validasi') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-money-check-alt me-2"></i> Validasi Pembayaran
                    </a>

                    <a href="{{ route('manajemen.laporan.keuangan') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan
                    </a>
                    <a href="{{ route('manajemen.laporan.pendaftar') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i> Laporan Pendaftar
                    </a>
                    <a href="{{ route('manajemen.laporan.kelulusan') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-pie me-2"></i> Laporan Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="main-content">
                    <h4 class="mb-4 text-primary-dark">
                        <i class="fas fa-cogs me-2"></i> Statistik Gabungan Keuangan & Eksekutif
                    </h4>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="card text-white bg-card-primary stat-card">
                                <div class="card-body position-relative">
                                    <h5 class="card-title fw-bold">Total Pendaftar</h5>
                                    <p class="card-text display-4 mb-0">{{ $total_pendaftar ?? 0 }}</p>
                                    <i class="fas fa-user-graduate stat-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card text-white bg-card-success stat-card">
                                <div class="card-body position-relative">
                                    <h5 class="card-title fw-bold">Lulus Seleksi</h5>
                                    <p class="card-text display-4 mb-0">{{ $lulus_seleksi ?? 0 }}</p>
                                    <i class="fas fa-award stat-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card text-white bg-card-danger stat-card">
                                <div class="card-body position-relative">
                                    <h5 class="card-title fw-bold">Perlu Validasi Bayar</h5>
                                    <p class="card-text display-4 mb-0">{{ $belum_bayar ?? 0 }}</p>
                                    <i class="fas fa-hand-holding-usd stat-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card text-white bg-card-info stat-card">
                                <div class="card-body position-relative">
                                    <h5 class="card-title fw-bold">Pembayaran Lunas</h5>
                                    <p class="card-text display-4 mb-0">{{ $lunas ?? 0 }}</p>
                                    <i class="fas fa-receipt stat-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-5 shadow-sm">
                        <div class="card-header fw-bold bg-light">
                            <i class="fas fa-chart-area me-1"></i> Tren Pendaftaran Berdasarkan Jalur
                        </div>
                        <div class="card-body py-5 text-center text-muted">
                            <p class="lead mb-0">Area untuk menampilkan Grafik Pendaftar (perlu library Chart.js atau sejenisnya).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
