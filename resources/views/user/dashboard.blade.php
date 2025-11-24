<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Calon Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">PMB Sistem Informasi</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    Halo, {{ Auth::user()->name ?? 'Mahasiswa' }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="list-group shadow-sm">
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action active" aria-current="true">
                        Dashboard & Jadwal
                    </a>
                    <a href="{{ route('user.form') }}" class="list-group-item list-group-item-action">
                        Isi Formulir Pendaftaran
                    </a>
                    <a href="{{ route('user.kartu') }}" class="list-group-item list-group-item-action">Cetak Kartu Ujian</a>
                    <a href="{{ route('user.kelulusan') }}" class="list-group-item list-group-item-action">Status Kelulusan</a>
                </div>
            </div>

            <div class="col-md-9">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Perhatian!</strong> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Selamat Datang di Portal PMB!</h4>
                        <p class="card-text">
                            Silakan lengkapi biodata Anda pada menu <strong>Isi Formulir Pendaftaran</strong> sebelum tanggal penutupan.
                        </p>
                        <hr>

                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="border p-3 rounded bg-white">
                                    <h6 class="text-muted">Status Pendaftaran</h6>
                                    @if(isset($data_pendaftar))
                                        <span class="badge {{ $data_pendaftar->status_berkas == 'valid' ? 'bg-success' : ($data_pendaftar->status_berkas == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ strtoupper($data_pendaftar->status_berkas) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">BELUM MENDAFTAR</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border p-3 rounded bg-white">
                                    <h6 class="text-muted">Status Pembayaran</h6>
                                    @if(isset($data_pendaftar))
                                        <span class="badge {{ $data_pendaftar->status_bayar == 'lunas' ? 'bg-primary' : 'bg-danger' }}">
                                            {{ strtoupper($data_pendaftar->status_bayar) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border p-3 rounded bg-white">
                                    <h6 class="text-muted">Status Kelulusan</h6>
                                    @if(isset($data_pendaftar))
                                        <strong>
                                            {{ strtoupper($data_pendaftar->status_lulus) }}
                                        </strong>
                                    @else
                                        <strong>-</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">
                        Jadwal Penting
                    </div>
                    <ul class="list-group list-group-flush">
                        @if(isset($jadwals) && $jadwals->isEmpty())
                            <li class="list-group-item text-center text-muted">Belum ada jadwal yang diumumkan.</li>
                        @elseif(isset($jadwals))
                            @foreach($jadwals as $j)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $j->judul }}
                                <span class="badge bg-primary rounded-pill">
                                    {{ \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') }}
                                    @if($j->tanggal_selesai)
                                        - {{ \Carbon\Carbon::parse($j->tanggal_selesai)->format('d M Y') }}
                                    @endif
                                </span>
                            </li>
                            @endforeach
                        @else
                            <li class="list-group-item text-center text-danger">Terjadi kesalahan pemuatan jadwal.</li>
                        @endif
                        </ul>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
