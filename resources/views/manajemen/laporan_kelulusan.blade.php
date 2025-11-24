<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kelulusan - Pimpinan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .navbar, .col-md-3, .btn-info { display: none !important; }
            .col-md-9 { width: 100% !important; flex: none; margin-top: -30px; padding: 0 15px; }
            .report-header { display: block !important; text-align: center; margin-bottom: 20px; }
            .card { border: none; box-shadow: none; }
            .badge { background: none !important; color: black !important; border: 1px solid #ccc; }
        }
        .report-header { display: none; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Panel Pimpinan PMB</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">Halo, Pimpinan</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <header class="report-header">
            <h2>LAPORAN HASIL KEPUTUSAN KELULUSAN</h2>
            <h4>PMB UNIVERSITAS MUSAMUS</h4>
            <hr>
        </header>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('pimpinan.dashboard') }}" class="list-group-item list-group-item-action">Dashboard Eksekutif</a>
                    <a href="{{ route('pimpinan.laporan.pendaftar') }}" class="list-group-item list-group-item-action">Laporan Pendaftar</a>
                    <a href="{{ route('pimpinan.laporan.kelulusan') }}" class="list-group-item list-group-item-action active bg-danger border-danger text-white">Laporan Kelulusan</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white fw-bold">Data Hasil Keputusan Kelulusan</div>
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mt-2">Total Data (Sudah Diputuskan): {{ $data_kelulusan->count() }}</h6>
                            <button class="btn btn-sm btn-info text-white" onclick="window.print()">Cetak Laporan</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pendaftar</th>
                                        <th>Status Berkas</th>
                                        <th>Status Bayar</th>
                                        <th>Status Kelulusan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_kelulusan as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->user->name ?? 'User Dihapus' }}</td>
                                        <td>
                                            <span class="badge {{ $data->status_berkas == 'valid' ? 'bg-success' : 'bg-danger' }}">
                                                {{ strtoupper($data->status_berkas) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $data->status_bayar == 'lunas' ? 'bg-primary' : 'bg-danger' }}">
                                                {{ strtoupper($data->status_bayar) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $data->status_lulus == 'lulus' ? 'bg-success' : 'bg-danger' }}">
                                                {{ strtoupper($data->status_lulus) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
