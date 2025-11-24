<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajemen Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Manajemen Kampus PMB</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    Halo, {{ Auth::user()->name ?? 'Manajemen' }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('manajemen.dashboard') }}" class="list-group-item list-group-item-action active bg-dark border-dark text-white">
                        Dashboard Ringkasan
                    </a>

                    <a href="{{ route('manajemen.validasi') }}" class="list-group-item list-group-item-action">
                        Validasi Pembayaran
                    </a>

                    <a href="{{ route('manajemen.laporan.keuangan') }}" class="list-group-item list-group-item-action">
                        Laporan Keuangan
                    </a>
                    <a href="{{ route('manajemen.laporan.pendaftar') }}" class="list-group-item list-group-item-action">
                        Laporan Pendaftar
                    </a>
                    <a href="{{ route('manajemen.laporan.kelulusan') }}" class="list-group-item list-group-item-action">
                        Laporan Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white fw-bold">Statistik Gabungan Keuangan & Eksekutif</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Pendaftar</h5>
                                        <p class="card-text display-4">{{ $total_pendaftar ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Lulus Seleksi</h5>
                                        <p class="card-text display-4">{{ $lulus_seleksi ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card text-white bg-danger mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Perlu Validasi Bayar</h5>
                                        <p class="card-text display-4">{{ $belum_bayar ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card text-white bg-info mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Pembayaran Lunas</h5>
                                        <p class="card-text display-4">{{ $lunas ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
