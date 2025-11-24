<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pembayaran - Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
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
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('keuangan.dashboard') }}" class="list-group-item list-group-item-action">Dashboard Ringkasan</a>
                    <a href="{{ route('keuangan.validasi') }}" class="list-group-item list-group-item-action active bg-success border-success text-white">Validasi Pembayaran</a>
                    <a href="{{ route('keuangan.laporan') }}" class="list-group-item list-group-item-action">Laporan Keuangan</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white fw-bold">Daftar Pendaftar Belum Bayar</div>
                    <div class="card-body">

                        @if($pendaftar_belum_bayar->isEmpty())
                            <p class="text-center text-muted my-4">Semua pembayaran sudah diverifikasi.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Pendaftar</th>
                                            <th>Status Berkas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendaftar_belum_bayar as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->user->name ?? 'User Hapus' }}</td>
                                            <td>
                                                <span class="badge {{ $data->status_berkas == 'valid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ strtoupper($data->status_berkas) }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('keuangan.validasi.proses', $data->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Konfirmasi pembayaran LUNAS?')">
                                                        Konfirmasi Lunas
                                                    </button>
                                                </form>
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
</body>
</html>
