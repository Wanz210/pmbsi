<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Jadwal - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Administrator PMB</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">Halo, Admin</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">Dashboard Statistik</a>
                    <a href="{{ route('admin.verifikasi') }}" class="list-group-item list-group-item-action">Verifikasi Berkas</a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">Manajemen User</a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action active bg-dark border-dark">
                        Pengaturan Jadwal
                    </a>
                    <a href="{{ route('admin.kelulusan') }}" class="list-group-item list-group-item-action">
                        Manajemen Kelulusan
                    </a>
                </div>
            </div>

            <div class="col-md-9">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white fw-bold">Pengaturan Jadwal & Informasi</div>
                    <div class="card-body">

                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                            Tambah Jadwal Baru
                        </button>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($jadwals->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada jadwal yang tersimpan.</td>
                                        </tr>
                                    @else
                                        @foreach($jadwals as $key => $j)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $j->judul }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($j->tanggal_mulai)->format('d M Y') }}
                                                @if($j->tanggal_selesai)
                                                    - {{ \Carbon\Carbon::parse($j->tanggal_selesai)->format('d M Y') }}
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning text-white btn-edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tambahJadwalModal"
                                                    data-id="{{ $j->id }}"
                                                    data-judul="{{ $j->judul }}"
                                                    data-deskripsi="{{ $j->deskripsi }}"
                                                    data-mulai="{{ $j->tanggal_mulai }}"
                                                    data-selesai="{{ $j->tanggal_selesai }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.jadwal.delete', $j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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

    <div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahJadwalModalLabel">Formulir Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.jadwal.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Kegiatan</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
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
                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('tambahJadwalModal');
            const form = modal.querySelector('form');
            const modalTitle = modal.querySelector('.modal-title');
            const storeRoute = "{{ route('admin.jadwal.store') }}"; // Route untuk Tambah

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Cek apakah tombol Edit yang diklik
                if (button.classList.contains('btn-edit')) {
                    // Mode Edit
                    const id = button.getAttribute('data-id');
                    const updateRoute = "{{ url('admin/jadwal') }}/" + id; // Buat route update dinamis

                    // Ubah judul modal dan action form
                    modalTitle.textContent = 'Formulir Edit Jadwal';
                    form.setAttribute('action', updateRoute);

                    // Tambahkan metode PUT/PATCH (Wajib untuk Update Laravel)
                    if (!form.querySelector('input[name="_method"]')) {
                        form.insertAdjacentHTML('afterbegin', '<input type="hidden" name="_method" value="PUT">');
                    }

                    // Isi field dengan data lama
                    document.getElementById('judul').value = button.getAttribute('data-judul');
                    document.getElementById('deskripsi').value = button.getAttribute('data-deskripsi');
                    document.getElementById('tanggal_mulai').value = button.getAttribute('data-mulai');
                    document.getElementById('tanggal_selesai').value = button.getAttribute('data-selesai');

                } else {
                    // Mode Tambah Baru (Reset Form)
                    modalTitle.textContent = 'Formulir Tambah Jadwal';
                    form.setAttribute('action', storeRoute);
                    form.reset();

                    // Hapus input _method jika ada (karena mode Tambah Baru)
                    const methodInput = form.querySelector('input[name="_method"]');
                    if (methodInput) {
                        methodInput.remove();
                    }
                }
            });
        });
    </script>
</body>
</html>
