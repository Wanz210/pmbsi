<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Jadwal - Admin</title>
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
        .modal-header-custom {
            background: linear-gradient(45deg, #4c69b2, #3b5998);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0;
            border-bottom: none;
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
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-users-cog me-2"></i> Manajemen User
                    </a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action active">
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
                        <i class="fas fa-clipboard-list me-2"></i> Manajemen Jadwal Penting
                    </h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
                            <span>Daftar Semua Kegiatan</span>
                            <button class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                                <i class="fas fa-plus me-1"></i> Tambah Jadwal Baru
                            </button>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-custom align-middle mb-0">
                                    <thead class="table-custom">
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 35%;">Judul Kegiatan</th>
                                            <th style="width: 35%;">Tanggal</th>
                                            <th style="width: 25%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($jadwals->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">Belum ada jadwal yang tersimpan.</td>
                                            </tr>
                                        @else
                                            @foreach($jadwals as $key => $j)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <span class="fw-bold">{{ $j->judul }}</span><br>
                                                    <small class="text-muted">{{ Str::limit($j->deskripsi, 50) }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') }}
                                                        @if($j->tanggal_selesai)
                                                            - {{ \Carbon\Carbon::parse($j->tanggal_selesai)->format('d M Y') }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning text-white btn-edit me-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#tambahJadwalModal"
                                                        data-id="{{ $j->id }}"
                                                        data-judul="{{ $j->judul }}"
                                                        data-deskripsi="{{ $j->deskripsi }}"
                                                        data-mulai="{{ $j->tanggal_mulai }}"
                                                        data-selesai="{{ $j->tanggal_selesai }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="{{ route('admin.jadwal.delete', $j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash-alt"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title text-white" id="tambahJadwalModalLabel">Formulir Tambah Jadwal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.jadwal.store') }}" method="POST" id="jadwalForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Kegiatan</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi / Keterangan</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('tambahJadwalModal');
            const form = modal.querySelector('form');
            const modalTitle = modal.querySelector('.modal-title');
            const storeRoute = "{{ route('admin.jadwal.store') }}";

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const methodInput = form.querySelector('input[name="_method"]');

                // Mode Tambah Baru (Default)
                modalTitle.textContent = 'Formulir Tambah Jadwal Baru';
                form.setAttribute('action', storeRoute);
                form.reset();
                if (methodInput) methodInput.remove();


                // Cek jika tombol Edit yang diklik
                if (button.classList.contains('btn-edit')) {
                    // Mode Edit
                    const id = button.getAttribute('data-id');
                    const updateRoute = "/admin/jadwal/" + id; // Sesuaikan dengan URL Anda

                    // Ubah judul modal dan action form
                    modalTitle.textContent = 'Formulir Edit Jadwal';
                    form.setAttribute('action', updateRoute);

                    // Tambahkan input _method=PUT
                    if (!form.querySelector('input[name="_method"]')) {
                        form.insertAdjacentHTML('afterbegin', '<input type="hidden" name="_method" value="PUT">');
                    }

                    // Isi field dengan data lama
                    document.getElementById('judul').value = button.getAttribute('data-judul');
                    document.getElementById('deskripsi').value = button.getAttribute('data-deskripsi');
                    document.getElementById('tanggal_mulai').value = button.getAttribute('data-mulai');
                    document.getElementById('tanggal_selesai').value = button.getAttribute('data-selesai');
                }
            });
        });
    </script>
</body>
</html>
