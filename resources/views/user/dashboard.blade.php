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

                    <a href="{{ route('user.kartu') }}" class="list-group-item list-group-item-action">
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
                        <h5 class="card-title text-primary mb-3">Status Pendaftaran Anda</h5>
                        <div class="row text-center g-3">

                            <div class="col-md-4">
                                <div class="border p-3 rounded bg-white h-100">
                                    <small class="text-muted d-block mb-1">Status Berkas</small>
                                    @if(isset($data_pendaftar))
                                        @if($data_pendaftar->status_berkas == 'valid')
                                            <span class="badge bg-success">VALID</span>
                                        @elseif($data_pendaftar->status_berkas == 'invalid')
                                            <span class="badge bg-danger">DITOLAK</span>
                                        @else
                                            <span class="badge bg-warning text-dark">MENUNGGU VERIFIKASI</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">BELUM DAFTAR</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="border p-3 rounded bg-white h-100">
                                    <small class="text-muted d-block mb-1">Pembayaran</small>
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
                                <div class="border p-3 rounded bg-white h-100">
                                    <small class="text-muted d-block mb-1">Kelulusan</small>
                                    @if(isset($data_pendaftar))
                                        @if($data_pendaftar->status_lulus == 'lulus')
                                            <span class="badge bg-success">LULUS</span>
                                        @elseif($data_pendaftar->status_lulus == 'tidak')
                                            <span class="badge bg-danger">TIDAK LULUS</span>
                                        @else
                                            <span class="badge bg-info text-dark">PROSES SELEKSI</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($data_pendaftar))
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">
                        📋 Biodata Lengkap Pendaftar
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center mb-3">
                                <img src="{{ asset('storage/' . $data_pendaftar->path_foto) }}" alt="Foto Profil" class="img-thumbnail rounded" style="max-height: 150px;">
                                <div class="mt-2 fw-bold">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="col-md-9">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="30%" class="text-muted">NISN</td>
                                        <td width="2%">:</td>
                                        <td class="fw-bold">{{ $data_pendaftar->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Asal Sekolah</td>
                                        <td>:</td>
                                        <td>{{ $data_pendaftar->asal_sekolah }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tempat, Tgl Lahir</td>
                                        <td>:</td>
                                        <td>{{ $data_pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($data_pendaftar->tanggal_lahir)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Jenis Kelamin</td>
                                        <td>:</td>
                                        <td>{{ $data_pendaftar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">No. WhatsApp</td>
                                        <td>:</td>
                                        <td>{{ $data_pendaftar->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><hr class="my-1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nama Ayah</td>
                                        <td>:</td>
                                        <td>{{ $data_pendaftar->nama_ayah }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nama Ibu Kandung</td>
                                        <td>:</td>
                                        <td class="fw-bold text-primary">{{ $data_pendaftar->nama_ibu }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Alamat Rumah</td>
                                        <td>:</td>
                                        <td>{{ $data_pendaftar->alamat }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">
                        🗓️ Jadwal Penting
                    </div>
                    <ul class="list-group list-group-flush">
                        @if(isset($jadwals) && $jadwals->count() > 0)
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
                            <li class="list-group-item text-center text-muted py-3">Belum ada jadwal yang diumumkan.</li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
