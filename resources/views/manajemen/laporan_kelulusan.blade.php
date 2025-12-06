<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kelulusan - Manajemen Kampus</title>
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

        /* MEDIA PRINT UNTUK LAPORAN */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
                margin: 0;
            }
            .container {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .main-content, .card {
                box-shadow: none !important;
                border: none !important;
                padding: 0;
                margin: 0;
            }
            .table-bordered th, .table-bordered td {
                border: 1px solid #333 !important;
            }
            .table-dark {
                background-color: #eee !important;
                color: #333 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5 no-print">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('manajemen.dashboard') }}">
                <i class="fas fa-chart-bar me-2"></i> Panel Laporan Eksekutif
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

            <div class="col-md-3 mb-4 no-print">
                <div class="list-group list-group-custom shadow-lg">
                    <a href="{{ route('manajemen.dashboard') }}" class="list-group-item list-group-item-action">
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
                    <a href="{{ route('manajemen.laporan.kelulusan') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-chart-pie me-2"></i> Laporan Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="main-content">

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                            <h4 class="mb-0 fw-bold text-primary-dark">
                                <i class="fas fa-trophy me-2"></i> Laporan Hasil Keputusan Kelulusan
                            </h4>
                            <button class="btn btn-primary btn-sm rounded-pill no-print" onclick="window.print()">
                                <i class="fas fa-print me-1"></i> Cetak Laporan
                            </button>
                        </div>
                        <div class="card-body">

                            <div class="d-none d-print-block text-center mb-4">
                                <h3 class="fw-bold">LAPORAN HASIL SELEKSI PMB</h3>
                                <h5>UNIVERSITAS MUSAMUS</h5>
                                <hr>
                            </div>

                            <div class="mb-3">
                                <p class="fw-bold mb-1">Periode Laporan: {{ date('F Y') }}</p>
                                <small>Total Data Diputuskan: <span class="fw-bold text-primary-dark">{{ $data_kelulusan->count() }}</span></small>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover align-middle table-custom">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 30%;">Nama Pendaftar</th>
                                            <th style="width: 20%;">Asal Sekolah</th>
                                            <th style="width: 15%;">Berkas</th>
                                            <th style="width: 15%;">Bayar</th>
                                            <th style="width: 15%;">Keputusan Lulus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data_kelulusan as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span class="fw-bold">{{ $data->user->name ?? 'User Dihapus' }}</span>
                                            </td>
                                            <td>{{ $data->asal_sekolah }}</td>
                                            <td>
                                                <span class="badge
                                                    {{ $data->status_berkas == 'valid' ? 'bg-success' : 'bg-danger' }} p-2">
                                                    {{ strtoupper($data->status_berkas) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge
                                                    {{ $data->status_bayar == 'lunas' ? 'bg-primary' : 'bg-warning text-dark' }} p-2">
                                                    {{ strtoupper($data->status_bayar) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($data->status_lulus == 'lulus')
                                                    <span class="badge bg-success p-2">LULUS</span>
                                                @elseif($data->status_lulus == 'tidak')
                                                    <span class="badge bg-danger p-2">TIDAK LULUS</span>
                                                @else
                                                    <span class="badge bg-secondary p-2">PROSES</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada data keputusan kelulusan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-5 text-end d-none d-print-block">
                                <p class="mb-5">Merauke, {{ date('d F Y') }}</p>
                                <p class="fw-bold text-decoration-underline mb-0">Rektor / Pimpinan</p>
                            </div>

                            <div class="text-end no-print pt-3 border-top">
                                <small class="text-muted">Laporan dicetak oleh: {{ Auth::user()->name ?? 'Manajemen' }}</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
