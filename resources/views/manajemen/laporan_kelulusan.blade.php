<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kelulusan - Manajemen Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            .card { border: none !important; shadow: none !important; }
            .badge { border: 1px solid #000000; color: #000000; }
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 no-print">
        <div class="container">
            <a class="navbar-brand" href="#">Panel Laporan Eksekutif</a>
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
            <div class="col-md-3 mb-4 no-print">
                <div class="list-group shadow-sm">
                    <a href="{{ route('manajemen.dashboard') }}" class="list-group-item list-group-item-action">
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
                    <a href="{{ route('manajemen.laporan.kelulusan') }}" class="list-group-item list-group-item-action active bg-dark border-dark">
                        Laporan Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Laporan Hasil Keputusan Kelulusan</h5>
                        <button class="btn btn-sm btn-dark no-print" onclick="window.print()">
                            Cetak Laporan (PDF)
                        </button>
                    </div>
                    <div class="card-body">

                        <div class="d-none d-print-block text-center mb-4">
                            <h3>LAPORAN HASIL SELEKSI PMB</h3>
                            <h5>UNIVERSITAS MUSAMUS</h5>
                            <hr>
                        </div>

                        <div class="mb-3">
                            <strong>Total Data Diputuskan: {{ $data_kelulusan->count() }}</strong>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pendaftar</th>
                                        <th>Status Berkas</th>
                                        <th>Status Bayar</th>
                                        <th>Keputusan Lulus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_kelulusan as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->user->name ?? 'User Dihapus' }}</td>
                                        <td>
                                            <span class="badge {{ $data->status_berkas == 'valid' ? 'bg-success' : 'bg-danger' }}">
                                                {{ strtoupper($data->status_berkas) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $data->status_bayar == 'lunas' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                                {{ strtoupper($data->status_bayar) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($data->status_lulus == 'lulus')
                                                <span class="badge bg-success">LULUS</span>
                                            @elseif($data->status_lulus == 'tidak')
                                                <span class="badge bg-danger">TIDAK LULUS</span>
                                            @else
                                                <span class="badge bg-secondary">PROSES</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data keputusan kelulusan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-none d-print-block mt-5 text-end">
                            <p>Merauke, {{ date('d F Y') }}</p>
                            <br><br><br>
                            <p class="fw-bold text-decoration-underline">Rektor / Pimpinan</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
