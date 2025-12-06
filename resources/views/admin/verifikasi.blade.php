<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berkas - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI TEMA MODERN */
        body {
            background-color: #f0f2f5; /* Latar belakang abu-abu muda */
        }
        .navbar-custom {
            background: linear-gradient(90deg, #3b5998, #4c69b2); /* Gradasi pada Navbar */
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
            background-color: #e6f0ff; /* Light blue background for active */
            border-left-color: #3b5998; /* Blue accent bar */
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
        .btn-action-group .btn {
            border-radius: 0.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-cogs me-2"></i> Administrator PMB
            </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    Halo, <span class="fw-bold">{{ Auth::user()->name ?? 'Admin' }}</span>
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

            <div class="col-md-3 mb-4">
                <div class="list-group list-group-custom shadow-lg">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-line me-2"></i> Dashboard Statistik
                    </a>
                    <a href="{{ route('admin.verifikasi') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-file-check me-2"></i> Verifikasi Berkas
                    </a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users-cog me-2"></i> Manajemen User
                    </a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt me-2"></i> Pengaturan Jadwal
                    </a>
                    <a href="{{ route('admin.kelulusan') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-award me-2"></i> Manajemen Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="main-content">
                    <h4 class="mb-4 text-primary-dark">
                        <i class="fas fa-clipboard-list me-2"></i> Verifikasi Berkas Pendaftar
                    </h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-warning text-dark fw-bold">
                            <i class="fas fa-exclamation-triangle me-1"></i> Daftar Berkas Perlu Verifikasi ({{ $pendaftar->count() }})
                        </div>
                        <div class="card-body">

                            @if($pendaftar->isEmpty())
                                <p class="text-center text-muted my-4">🎉 Tidak ada berkas yang perlu diverifikasi saat ini. Semua berkas sudah *Valid* atau *Ditolak*.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-custom align-middle">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 25%;">Nama Pendaftar</th>
                                                <th style="width: 20%;">Asal Sekolah</th>
                                                <th style="width: 15%;">Jalur</th>
                                                <th style="width: 20%;">Dokumen</th>
                                                <th style="width: 15%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendaftar as $key => $data)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>
                                                    <strong class="text-primary-dark">{{ $data->user->name ?? 'User Dihapus' }}</strong><br>
                                                    <small class="text-muted">NISN: {{ $data->nisn }}</small>
                                                </td>
                                                <td>{{ $data->asal_sekolah }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary">{{ $data->jalur ?? 'N/A' }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-grid gap-1">
                                                        <a href="{{ asset('storage/' . $data->path_foto) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-image me-1"></i> Lihat Foto
                                                        </a>
                                                        <a href="{{ asset('storage/' . $data->path_ijazah) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-file-pdf me-1"></i> Lihat Ijazah
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-grid gap-2 btn-action-group">
                                                        <form action="{{ route('admin.verifikasi.proses', $data->id) }}" method="POST">
                                                            @csrf
                                                            @method('post') <button type="submit" name="aksi" value="valid" class="btn btn-success btn-sm w-100" onclick="return confirm('Yakin berkas VALID? Langkah ini akan membuat status berkas menjadi valid.')">
                                                                <i class="fas fa-check"></i> Valid
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('admin.verifikasi.proses', $data->id) }}" method="POST">
                                                            @csrf
                                                            @method('post') <button type="submit" name="aksi" value="tolak" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin MENOLAK berkas ini?')">
                                                                <i class="fas fa-times"></i> Tolak
                                                            </button>
                                                        </form>
                                                    </div>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
