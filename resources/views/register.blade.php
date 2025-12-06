<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mahasiswa Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI MOCKUP & EFEK 3D */
        body {
            /* Gradasi latar belakang yang memudar */
            background: linear-gradient(135deg, #a8c0ff 0%, #3e5fbc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 0;
        }
        .card-container {
            /* Kontainer utama dengan efek melayang 3D */
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1.5rem;
            max-width: 900px;
            width: 95%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 0, 0, 0.05); /* Shadow lebih tebal */
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: transform 0.3s ease;
        }
        .card-container:hover {
            transform: translateY(-5px);
        }
        .card-header-custom {
            background: linear-gradient(45deg, #4c69b2, #3b5998);
            color: white;
            border-radius: 1.5rem 1.5rem 0 0;
            padding: 1.5rem;
            text-align: center;
        }
        .card-body {
            padding: 3rem;
        }
        .form-section-header {
            font-weight: 700;
            color: #3b5998;
            margin-top: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e0e0e0;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
        }
        .btn-primary {
            background-color: #3b5998;
            border-color: #3b5998;
            border-radius: 0.75rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #4c69b2;
            border-color: #4c69b2;
        }
        .input-group-text-custom {
            background-color: #f8f9fa;
            border-right: none;
            color: #3b5998;
        }
    </style>
</head>
<body>

    <div class="card-container">
        <div class="card-header-custom">
            <h2 class="fw-bolder mb-1 text-shadow">Formulir Pendaftaran Mahasiswa Baru</h2>
            <p class="text-white-50 mb-0">Lengkapi data dengan teliti dan siapkan dokumen yang diperlukan.</p>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0" role="alert">
                    <p class="fw-bold mb-1">
                        <i class="fas fa-exclamation-triangle me-2"></i> Mohon periksa kesalahan berikut:
                    </p>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.proses') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h4 class="form-section-header">
                    <i class="fas fa-user-lock me-2"></i> 1. Akun & Keamanan
                </h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required placeholder="Sesuai Ijazah" value="{{ old('name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Aktif</label>
                        <input type="email" name="email" class="form-control" required placeholder="email@contoh.com" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                    </div>
                </div>

                <h4 class="form-section-header">
                    <i class="fas fa-graduation-cap me-2"></i> 2. Data Pendidikan & Jalur Pendaftaran
                </h4>
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NISN</label>
                            <input type="number" name="nisn" class="form-control" required placeholder="Nomor Induk Siswa Nasional" value="{{ old('nisn') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" class="form-control" required placeholder="Contoh: SMA N 1 Jakarta" value="{{ old('asal_sekolah') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jalur Pendaftaran</label>
                            <select name="jalur" class="form-select" required>
                                <option value="">-- Pilih Jalur --</option>
                                <option value="SNBP" {{ old('jalur') == 'SNBP' ? 'selected' : '' }}>SNBP (Undangan)</option>
                                <option value="SNBT" {{ old('jalur') == 'SNBT' ? 'selected' : '' }}>SNBT (Tes Tulis)</option>
                                <option value="Mandiri" {{ old('jalur') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="Lainnya" {{ old('jalur') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <h4 class="form-section-header">
                    <i class="fas fa-home me-2"></i> 3. Kontak & Keluarga
                </h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Ayah Kandung</label>
                            <input type="text" name="nama_ayah" class="form-control" required value="{{ old('nama_ayah') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Ibu Kandung</label>
                            <input type="text" name="nama_ibu" class="form-control" required value="{{ old('nama_ibu') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. WhatsApp / HP</label>
                            <input type="number" name="no_hp" class="form-control" required placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap Rumah</label>
                            <textarea name="alamat" class="form-control" rows="8" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan...">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>

                <h4 class="form-section-header">
                    <i class="fas fa-file-upload me-2"></i> 4. Dokumen Persyaratan
                </h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Pas Foto Formal (3x4) *</label>
                        <input type="file" name="foto" class="form-control" accept="image/*" required>
                        <small class="text-muted d-block">Max 2MB. Format: JPG/PNG.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Scan Ijazah / SKL *</label>
                        <input type="file" name="ijazah" class="form-control" accept=".pdf,image/*" required>
                        <small class="text-muted d-block">Max 2MB. Format: PDF/JPG/PNG.</small>
                    </div>
                </div>

                <div class="d-grid gap-2 pt-3">
                    <button type="submit" class="btn btn-primary btn-lg shadow">
                        <i class="fas fa-check-circle me-2"></i> Daftar Sekarang
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Sudah punya akun? Login di sini</a>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
