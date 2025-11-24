<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berkas - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Administrator PMB</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">Halo, Admin</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                        Dashboard Statistik
                    </a>
                    <a href="{{ route('admin.verifikasi') }}" class="list-group-item list-group-item-action active bg-dark border-dark">
                        Verifikasi Berkas
                    </a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action">
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
                    <div class="card-header bg-warning text-dark fw-bold">
                        Daftar Berkas Perlu Verifikasi
                    </div>
                    <div class="card-body">

                        @if($pendaftar->isEmpty())
                            <p class="text-center text-muted my-4">Tidak ada berkas yang perlu diverifikasi saat ini.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 30%;">Nama Pendaftar</th>
                                            <th style="width: 25%;">Asal Sekolah</th>
                                            <th style="width: 20%;">Berkas</th>
                                            <th style="width: 20%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendaftar as $key => $data)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>
                                                <strong>{{ $data->user->name ?? 'User Hapus' }}</strong><br>
                                                <small class="text-muted">NISN: {{ $data->nisn }}</small>
                                            </td>
                                            <td>{{ $data->asal_sekolah }}</td>
                                            <td>
                                                <div class="d-grid gap-2">
                                                    <a href="{{ asset('storage/' . $data->path_foto) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                        Lihat Foto
                                                    </a>
                                                    <a href="{{ asset('storage/' . $data->path_ijazah) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                        Lihat Ijazah
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column gap-2">

                                                    <form action="{{ route('admin.verifikasi.proses', $data->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" name="aksi" value="valid" class="btn btn-success btn-sm w-100" onclick="return confirm('Yakin berkas ini VALID?')">
                                                            Valid
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.verifikasi.proses', $data->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" name="aksi" value="tolak" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin MENOLAK berkas ini?')">
                                                            Tolak
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
