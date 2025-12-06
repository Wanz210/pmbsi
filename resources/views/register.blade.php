<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mahasiswa Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="card shadow-lg" style="width: 800px; border-radius: 15px;">
        <div class="card-header bg-white text-center py-4">
            <h3 class="fw-bold text-primary">Formulir Pendaftaran PMB</h3>
            <p class="text-muted mb-0">Lengkapi data di bawah ini untuk mendaftar akun & biodata</p>
        </div>
        <div class="card-body p-5">

            <form action="{{ route('register.proses') }}" method="POST">
                @csrf

                <h5 class="text-primary mb-3 border-bottom pb-2">1. Informasi Akun Login</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap (Sesuai Ijazah)</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email (Aktif)</label>
                        <input type="email" name="email" class="form-control" required placeholder="email@contoh.com">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                    </div>
                </div>

                <h5 class="text-primary mb-3 border-bottom pb-2">2. Biodata Pribadi & Sekolah</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NISN</label>
                        <input type="number" name="nisn" class="form-control" required placeholder="Nomor Induk Siswa Nasional">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" required placeholder="Contoh: SMA N 1 Jakarta">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">No. WhatsApp / HP</label>
                    <input type="number" name="no_hp" class="form-control" required placeholder="08xxxxxxxxxx">
                </div>

                <h5 class="text-primary mb-3 border-bottom pb-2">3. Data Orang Tua & Alamat</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Ayah Kandung</label>
                        <input type="text" name="nama_ayah" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Ibu Kandung</label>
                        <input type="text" name="nama_ibu" class="form-control" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Alamat Lengkap Rumah</label>
                    <textarea name="alamat" class="form-control" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan..."></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">Daftar Sekarang</button>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Sudah punya akun? Login di sini</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
