<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pembayaran - Manajemen Kampus</title>
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
        .table th, .table td {
            vertical-align: middle;
        }
        .table-custom thead th {
            background-color: #3b5998;
            color: white;
            font-weight: 600;
        }
        .bg-danger-light {
            background-color: #f8d7da !important;
        }
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

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-times-circle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="list-group list-group-custom shadow-lg">
                    <a href="{{ route('manajemen.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-home me-2"></i> Dashboard Ringkasan
                    </a>
                    <a href="{{ route('manajemen.validasi') }}" class="list-group-item list-group-item-action active">
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
                        <i class="fas fa-hand-holding-usd me-2"></i> Validasi Pembayaran Uang Pendaftaran
                    </h4>

                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white fw-bold">
                            <i class="fas fa-exclamation-circle me-1"></i> Daftar Pendaftar Belum Bayar
                        </div>
                        <div class="card-body p-0">

                            @if($pendaftar_belum_bayar->isEmpty())
                                <p class="text-center text-muted my-4">🎉 Semua pembayaran sudah diverifikasi.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-custom align-middle mb-0">
                                        <thead class="table-custom">
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 35%;">Nama Pendaftar</th>
                                                <th style="width: 20%;">Jalur</th>
                                                <th style="width: 20%;">Status Berkas</th>
                                                <th style="width: 20%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendaftar_belum_bayar as $key => $data)
                                            <tr class="{{ $data->status_berkas != 'valid' ? 'bg-danger-light' : '' }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <strong class="text-primary-dark">{{ $data->user->name ?? 'User Hapus' }}</strong><br>
                                                    <small class="text-muted">NISN: {{ $data->nisn }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $data->jalur ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge
                                                        {{ $data->status_berkas == 'valid' ? 'bg-success' :
                                                           ($data->status_berkas == 'invalid' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                        {{ strtoupper($data->status_berkas) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($data->status_berkas == 'valid')
                                                        <form action="{{ route('manajemen.validasi.proses', $data->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Konfirmasi pembayaran LUNAS? Tindakan ini akan mengaktifkan Kartu Ujian pendaftar.')">
                                                                <i class="fas fa-receipt me-1"></i> Konfirmasi Lunas
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-danger small fst-italic">Berkas Belum Valid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
