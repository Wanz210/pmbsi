<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelulusan - Admin</title>
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
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">Dashboard Statistik</a>
                    <a href="{{ route('admin.verifikasi') }}" class="list-group-item list-group-item-action">Verifikasi Berkas</a>
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">Manajemen User</a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action">Pengaturan Jadwal</a>
                    <a href="{{ route('admin.kelulusan') }}" class="list-group-item list-group-item-action active bg-dark border-dark text-white">Manajemen Kelulusan</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Daftar Pendaftar Siap Dinilai Kelulusan</div>
                    <div class="card-body">

                        @if($pendaftar_siap->isEmpty())
                            <p class="text-center text-muted my-4">Tidak ada pendaftar yang memenuhi syarat (Berkas VALID & Bayar LUNAS) untuk dinilai kelulusannya.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Pendaftar</th>
                                            <th>Status Berkas & Bayar</th>
                                            <th>Keputusan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendaftar_siap as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <strong>{{ $data->user->name ?? 'User Dihapus' }}</strong><br>
                                                <small class="text-muted">NISN: {{ $data->nisn }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">BERKAS VALID</span><br>
                                                <span class="badge bg-primary">BAYAR LUNAS</span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $data->status_lulus == 'lulus' ? 'bg-success' : ($data->status_lulus == 'tidak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                    {{ strtoupper($data->status_lulus) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($data->status_lulus == 'proses')
                                                    <div class="d-flex flex-column gap-2">
                                                        <form action="{{ route('admin.kelulusan.proses', $data->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" name="aksi" value="lulus" class="btn btn-success btn-sm w-100" onclick="return confirm('Nyatakan LULUS?')">
                                                                LULUS
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.kelulusan.proses', $data->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" name="aksi" value="tidak" class="btn btn-danger btn-sm w-100" onclick="return confirm('Nyatakan TIDAK LULUS?')">
                                                                TIDAK LULUS
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Sudah Diputuskan</span>
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
</body>
</html>
