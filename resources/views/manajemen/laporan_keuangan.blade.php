<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - PMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* CSS Umum untuk Web View */
        .badge-lunas { background-color: #007bff; color: white; }
        .badge-belum { background-color: #dc3545; color: white; }
        .badge-valid { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: #333; }

        /* Media Print: Menyembunyikan elemen non-data dan merapikan layout */
        @media print {
            .navbar, .col-md-3, .aksi-web {
                display: none !important; /* Sembunyikan Nav dan Sidebar */
            }
            .col-md-9 {
                width: 100% !important; /* Konten full-width */
                padding: 0 15px;
                margin-top: -30px; /* Geser ke atas */
                flex: none;
            }
            .report-header {
                display: block !important;
                text-align: center;
                margin-bottom: 20px;
            }
            .card {
                border: none;
                box-shadow: none;
            }
            /* Style tabel untuk cetak */
            table {
                font-size: 10pt;
            }
            .badge-lunas, .badge-belum, .badge-valid, .badge-warning {
                background: none !important;
                border: 1px solid #aaa;
                color: black !important;
                padding: 3px 6px;
            }
            .report-title {
                margin-top: 15px;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4 aksi-web">
        <div class="container">
            <a class="navbar-brand" href="#">Panel Keuangan PMB</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">Halo, Keuangan</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <header class="report-header" style="display:none;">
            <h2>LAPORAN STATUS PEMBAYARAN PENDAFTAR</h2>
            <h4>UNIVERSITAS MUSAMUS</h4>
            <hr>
        </header>

        <div class="row">
            <div class="col-md-3 mb-4 aksi-web">
                <div class="list-group">
                    <a href="{{ route('keuangan.dashboard') }}" class="list-group-item list-group-item-action">Dashboard Ringkasan</a>
                    <a href="{{ route('keuangan.validasi') }}" class="list-group-item list-group-item-action">Validasi Pembayaran</a>
                    <a href="{{ route('keuangan.laporan') }}" class="list-group-item list-group-item-action active bg-success border-success text-white">Laporan Keuangan</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white fw-bold report-title">Laporan Status Pembayaran Pendaftar</div>
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3 aksi-web">
                            <h6 class="mt-2">Total Data: {{ $data_laporan->count() }}</h6>
                            <button class="btn btn-sm btn-info text-white" onclick="window.print()">Cetak Laporan</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pendaftar</th>
                                        <th>Asal Sekolah</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Berkas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_laporan as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->user->name ?? 'User Dihapus' }}</td>
                                        <td>{{ $data->asal_sekolah }}</td>
                                        <td>
                                            <span class="badge {{ $data->status_bayar == 'lunas' ? 'badge-lunas' : 'badge-belum' }}">
                                                {{ strtoupper($data->status_bayar) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $data->status_berkas == 'valid' ? 'badge-valid' : 'badge-warning' }}">
                                                {{ strtoupper($data->status_berkas) }}
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
