<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin</title>
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
        /* Style Khusus untuk Card Pending */
        .card-pending {
            border: 2px solid #f0ad4e; /* Border Oranye/Kuning */
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
                    <a href="{{ route('admin.verifikasi') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-check me-2"></i> Verifikasi Berkas
                    </a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action active">
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
                        <i class="fas fa-users-cog me-2"></i> Manajemen Pengguna Sistem
                    </h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-lg card-pending mb-5">
                        <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-exclamation-triangle me-1"></i> Permintaan Verifikasi Akun Baru</span>
                            <span class="badge bg-dark">{{ $users_pending->count() }} Menunggu</span>
                        </div>
                        <div class="card-body p-0">
                            @if($users_pending->isEmpty())
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-bell me-1"></i> Tidak ada pendaftar baru yang perlu diverifikasi.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 30%;">Nama Pendaftar</th>
                                                <th style="width: 30%;">Email</th>
                                                <th style="width: 15%;">Tgl Daftar</th>
                                                <th class="text-center" style="width: 20%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users_pending as $key => $pending)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="fw-bold">{{ $pending->name }}</td>
                                                <td>{{ $pending->email }}</td>
                                                <td>{{ $pending->created_at->format('d M Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.verifikasi.user', ['id' => $pending->id, 'status' => 'active']) }}"
                                                       class="btn btn-success btn-sm me-1"
                                                       onclick="return confirm('Apakah Anda yakin ingin mengaktifkan akun ini? Akun akan bisa login.')">
                                                        <i class="fas fa-check"></i> Terima
                                                    </a>
                                                    <a href="{{ route('admin.verifikasi.user', ['id' => $pending->id, 'status' => 'tolak']) }}"
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Apakah Anda yakin ingin MENOLAK dan MENGHAPUS akun ini?')">
                                                        <i class="fas fa-trash-alt"></i> Tolak
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white fw-bold">
                            <i class="fas fa-list-alt me-1"></i> Daftar Pengguna Sistem (Aktif)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 30%;">Nama Lengkap</th>
                                            <th style="width: 25%;">Email</th>
                                            <th style="width: 15%;">Role</th>
                                            <th style="width: 15%;">Terakhir Diperbarui</th>
                                            <th style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $key => $u)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="fw-bold">{{ $u->name }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>
                                                <span class="badge
                                                    {{ $u->role == 'admin' ? 'bg-danger' :
                                                       ($u->role == 'manajemen' ? 'bg-info' : 'bg-primary') }}
                                                    ">
                                                    {{ ucfirst($u->role) }}
                                                </span>
                                            </td>
                                            <td>{{ $u->updated_at->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($u->id != Auth::id())
                                                    <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini? Data pendaftarannya juga akan hilang.')" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" title="Hapus User">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted small fst-italic">Anda</span>
                                                @endif
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
