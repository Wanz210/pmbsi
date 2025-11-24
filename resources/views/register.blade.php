<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - PMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0d6efd; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .register-card { width: 100%; max-width: 500px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="card register-card bg-white">
        <div class="card-body p-5">
            <h3 class="text-center text-primary mb-2">Daftar Akun PMB</h3>
            <p class="text-center text-muted mb-4">Buat akun untuk Calon Mahasiswa</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.proses') }}" method="POST">
                @csrf <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control bg-light" placeholder="Nama Sesuai Ijazah" required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email (Sebagai Username)</label>
                    <input type="email" name="email" class="form-control bg-light" placeholder="contoh@email.com" required value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control bg-light" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control bg-light" placeholder="Ulangi Password" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Daftar Akun</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <small>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></small>
            </div>
        </div>
    </div>
</body>
</html>
