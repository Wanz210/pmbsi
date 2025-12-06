<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Calon Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI TEMA MODERN (Sama seperti Login/Register) */
        body {
            /* Gradasi latar belakang yang memudar */
            background: linear-gradient(135deg, #a8c0ff 0%, #3e5fbc 100%);
            min-height: 100vh;
        }
        .navbar-custom {
            background: linear-gradient(90deg, #3b5998, #4c69b2); /* Gradasi pada Navbar */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .main-content-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .card {
            border-radius: 0.75rem !important; /* Membuat semua card lebih bulat */
            border: none;
        }
        .list-group-item.active {
            background-color: #3b5998 !important;
            border-color: #3b5998 !important;
            font-weight: bold;
        }
        .text-primary-dark {
            color: #3b5998 !important;
        }
        .border-box-status {
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            transition: transform 0.2s;
        }
        .border-box-status:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-university me-2"></i> PMB Sistem Informasi
            </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    Halo, <span class="fw-bold">{{ Auth::user()->name ?? 'Mahasiswa' }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="list-group shadow-lg">
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard & Jadwal
                    </a>

                    <a href="{{ route('user.kartu') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-print me-2"></i> Cetak Kartu Ujian
                    </a>

                    <a href="{{ route('user.kelulusan') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-award me-2"></i> Status Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="main-content-card">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                            <strong>Perhatian!</strong> {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-primary-dark mb-3">
                                <i class="fas fa-info-circle me-2"></i> Status Pendaftaran Anda
                            </h5>
                            <div class="row text-center g-3">

                                <div class="col-md-4">
                                    <div class="border-box-status p-3 bg-white h-100">
                                        <small class="text-muted d-block mb-1">Status Berkas</small>
                                        @if(isset($data_pendaftar))
                                            @if($data_pendaftar->status_berkas == 'valid')
                                                <span class="badge bg-success fs-6">VALID</span>
                                            @elseif($data_pendaftar->status_berkas == 'invalid')
                                                <span class="badge bg-danger fs-6">DITOLAK</span>
                                            @else
                                                <span class="badge bg-warning text-dark fs-6">MENUNGGU</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary fs-6">BELUM DAFTAR</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border-box-status p-3 bg-white h-100">
                                        <small class="text-muted d-block mb-1">Pembayaran</small>
                                        @if(isset($data_pendaftar))
                                            <span class="badge {{ $data_pendaftar->status_bayar == 'lunas' ? 'bg-primary' : 'bg-danger' }} fs-6">
                                                {{ strtoupper($data_pendaftar->status_bayar) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary fs-6">-</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border-box-status p-3 bg-white h-100">
                                        <small class="text-muted d-block mb-1">Kelulusan</small>
                                        @if(isset($data_pendaftar))
                                            @if($data_pendaftar->status_lulus == 'lulus')
                                                <span class="badge bg-success fs-6">LULUS</span>
                                            @elseif($data_pendaftar->status_lulus == 'tidak')
                                                <span class="badge bg-danger fs-6">TIDAK LULUS</span>
                                            @else
                                                <span class="badge bg-info text-dark fs-6">PROSES SELEKSI</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary fs-6">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($data_pendaftar))
                    <div class="card shadow-sm mb-4 border-box-status">
                        <div class="card-header bg-light fw-bold text-primary-dark">
                            <i class="fas fa-id-card-alt me-2"></i> Detail Biodata & Dokumen
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mb-4">
                                    <img src="{{ asset('storage/' . $data_pendaftar->path_foto) }}" alt="Foto Profil" class="img-thumbnail rounded-circle mb-2" style="max-height: 120px; width: 120px; object-fit: cover; border: 3px solid #3b5998;">
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <small class="text-muted d-block">{{ strtoupper($data_pendaftar->jalur ?? 'Jalur Tidak Ada') }}</small>
                                </div>
                                <div class="col-md-9">
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            <tr>
                                                <td width="30%" class="text-muted">NISN / Sekolah</td>
                                                <td>:</td>
                                                <td><span class="fw-bold">{{ $data_pendaftar->nisn }}</span> | {{ $data_pendaftar->asal_sekolah }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tempat, Tgl Lahir</td>
                                                <td>:</td>
                                                <td>{{ $data_pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($data_pendaftar->tanggal_lahir)->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Jenis Kelamin / HP</td>
                                                <td>:</td>
                                                <td>{{ $data_pendaftar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} | {{ $data_pendaftar->no_hp }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Orang Tua</td>
                                                <td>:</td>
                                                <td>Ayah: {{ $data_pendaftar->nama_ayah }} | Ibu: <span class="fw-bold text-primary-dark">{{ $data_pendaftar->nama_ibu }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Alamat</td>
                                                <td>:</td>
                                                <td>{{ $data_pendaftar->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">File Ijazah</td>
                                                <td>:</td>
                                                <td><a href="{{ asset('storage/' . $data_pendaftar->path_ijazah) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-file-pdf me-1"></i> Lihat Dokumen</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="card shadow-sm border-box-status">
                        <div class="card-header bg-light fw-bold text-primary-dark">
                            <i class="fas fa-calendar-alt me-2"></i> Jadwal Penting PMB
                        </div>
                        <ul class="list-group list-group-flush">
                            @if(isset($jadwals) && $jadwals->count() > 0)
                                @foreach($jadwals as $j)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $j->judul }}</span>
                                    <span class="badge bg-primary rounded-pill py-2 px-3">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
