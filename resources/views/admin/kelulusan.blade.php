<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelulusan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI TEMA MODERN */
        body {
            background-color: #f0f2f5;
        }
        .navbar-custom {
            background: linear-gradient(90deg, #3b5998, #4c69b2);
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
            background-color: #e6f0ff;
            border-left-color: #3b5998;
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="list-group list-group-custom shadow-lg">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-line me-2"></i> Dashboard Statistik
                    </a>
                    <a href="{{ route('admin.verifikasi') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-check me-2"></i> Verifikasi Berkas
                    </a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users-cog me-2"></i> Manajemen User
                    </a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt me-2"></i> Pengaturan Jadwal
                    </a>
                    <a href="{{ route('admin.kelulusan') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-award me-2"></i> Manajemen Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="main-content">
                    <h4 class="mb-4 text-primary-dark">
                        <i class="fas fa-tasks me-2"></i> Penentuan Status Kelulusan
                    </h4>

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white fw-bold">
                            <i class="fas fa-list me-1"></i> Daftar Pendaftar Siap Dinilai
                        </div>
                        <div class="card-body p-0">

                            @if($pendaftar_siap->isEmpty())
                                <p class="text-center text-muted my-4">🎉 Tidak ada pendaftar yang memenuhi syarat (Berkas **VALID** & Bayar **LUNAS**) untuk dinilai kelulusannya.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-custom align-middle mb-0">
                                        <thead class="table-custom">
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 30%;">Nama Pendaftar</th>
                                                <th style="width: 20%;">Jalur</th>
                                                <th style="width: 20%;">Status Kelulusan</th>
                                                <th style="width: 25%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendaftar_siap as $key => $data)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <strong class="text-primary-dark">{{ $data->user->name ?? 'User Dihapus' }}</strong><br>
                                                    <small class="text-muted">NISN: {{ $data->nisn }}</small>
                                                </td>
                                                <td>
                                                     <span class="badge bg-secondary">{{ $data->jalur ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge p-2
                                                        {{ $data->status_lulus == 'lulus' ? 'bg-success' :
                                                           ($data->status_lulus == 'tidak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                        {{ strtoupper($data->status_lulus) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($data->status_lulus == 'proses')
                                                        <div class="d-flex flex-column gap-2 btn-action-group">
                                                            <form action="{{ route('admin.kelulusan.proses', $data->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" name="aksi" value="lulus" class="btn btn-success btn-sm w-100" onclick="return confirm('Yakin nyatakan LULUS?')">
                                                                    <i class="fas fa-check"></i> LULUS
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.kelulusan.proses', $data->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" name="aksi" value="tidak" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin nyatakan TIDAK LULUS?')">
                                                                    <i class="fas fa-times"></i> TIDAK LULUS
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <span class="text-muted small fst-italic">Keputusan Final</span>
                                                    @endif
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
</body>
</html>
