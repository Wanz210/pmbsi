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

                    <a href="{{ route('user.formulir') }}" class="list-group-item list-group-item-action">
                        Isi Formulir Pendaftaran
                    </a>

                    <a href="{{ route('user.cetak') }}" class="list-group-item list-group-item-action">
                        Cetak Kartu Ujian
                    </a>

                    <a href="{{ route('user.kelulusan') }}" class="list-group-item list-group-item-action">
                        Status Kelulusan
                    </a>
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
                                <div class="border p-3 rounded bg-white h-100">
                                    <h6 class="text-muted mb-2">Status Pendaftaran</h6>
                                    @if(isset($data_pendaftar))
                                        @if($data_pendaftar->status_berkas == 'valid')
                                            <span class="badge bg-success fs-6">VALID</span>
                                        @elseif($data_pendaftar->status_berkas == 'invalid')
                                            <span class="badge bg-danger fs-6">DITOLAK</span>
                                        @else
                                            <span class="badge bg-warning text-dark fs-6">MENUNGGU</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">BELUM MENDAFTAR</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border p-3 rounded bg-white h-100">
                                    <h6 class="text-muted mb-2">Status Pembayaran</h6>
                                    @if(isset($data_pendaftar))
                                        <span class="badge {{ $data_pendaftar->status_bayar == 'lunas' ? 'bg-primary' : 'bg-danger' }} fs-6">
                                            {{ strtoupper($data_pendaftar->status_bayar) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border p-3 rounded bg-white h-100">
                                    <h6 class="text-muted mb-2">Status Kelulusan</h6>
                                    @if(isset($data_pendaftar))
                                        @if($data_pendaftar->status_lulus == 'lulus')
                                            <span class="badge bg-success fs-6">LULUS</span>
                                        @elseif($data_pendaftar->status_lulus == 'tidak')
                                            <span class="badge bg-danger fs-6">TIDAK LULUS</span>
                                        @else
                                            <span class="badge bg-info text-dark fs-6">PROSES SELEKSI</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">-</span>
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
                            <li class="list-group-item text-center text-muted py-3">Belum ada jadwal yang diumumkan.</li>
                        @elseif(isset($jadwals))
                            @foreach($jadwals as $j)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $j->judul }}</span>
                                <span class="badge bg-primary rounded-pill">
                                    {{ \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') }}
                                    @if($j->tanggal_selesai)
                                        - {{ \Carbon\Carbon::parse($j->tanggal_selesai)->format('d M Y') }}
                                    @endif
                                </span>
                            </li>
                            @endforeach
                        @else
                            <li class="list-group-item text-center text-danger">Data jadwal tidak ditemukan.</li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
