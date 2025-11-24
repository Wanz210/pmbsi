<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin</title>
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
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action active bg-dark border-dark">Manajemen User</a>
                    <a href="{{ route('admin.jadwal') }}" class="list-group-item list-group-item-action">Pengaturan Jadwal</a>
                    <a href="{{ route('admin.kelulusan') }}" class="list-group-item list-group-item-action">Manajemen Kelulusan</a>
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
                    <div class="card-header bg-secondary text-white fw-bold">Daftar Pengguna Sistem</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $u)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>
                                            <span class="badge {{ $u->role == 'admin' ? 'bg-danger' : ($u->role == 'user' ? 'bg-primary' : 'bg-info') }}">
                                                {{ ucfirst($u->role) }}
                                            </span>
                                        </td>
                                        <td>{{ $u->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($u->id != Auth::id())
                                                <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini? Data pendaftarannya juga akan hilang.')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Akun Anda</span>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
