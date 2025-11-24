<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Manajemen Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            .card { border: none !important; shadow: none !important; }
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 no-print">
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
            <div class="col-md-3 mb-4 no-print">
                <div class="list-group shadow-sm">
                    <a href="{{ route('manajemen.dashboard') }}" class="list-group-item list-group-item-action">
                        Dashboard Ringkasan
                    </a>
                    <a href="{{ route('manajemen.validasi') }}" class="list-group-item list-group-item-action">
                        Validasi Pembayaran
                    </a>
                    <a href="{{ route('manajemen.laporan.keuangan') }}" class="list-group-item list-group-item-action active bg-dark border-dark">
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
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Laporan Status Pembayaran Pendaftar</h5>
                        <button onclick="window.print()" class="btn btn-primary btn-sm no-print">
                            Cetak Laporan (PDF)
                        </button>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <strong>Total Data: {{ $data_laporan->count() }}</strong>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pendaftar</th>
                                        <th>Asal Sekolah</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Berkas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_laporan as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->user->name ?? 'User Terhapus' }}</td>
                                        <td>{{ $data->asal_sekolah }}</td>
                                        <td>
                                            @if($data->status_bayar == 'lunas')
                                                <span class="badge bg-success">LUNAS</span>
                                            @else
                                                <span class="badge bg-danger">BELUM BAYAR</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ strtoupper($data->status_berkas) }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data transaksi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5 text-end">
                            <p>Merauke, {{ date('d F Y') }}</p>
                            <br><br>
                            <p class="fw-bold text-decoration-underline">Bagian Keuangan</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
