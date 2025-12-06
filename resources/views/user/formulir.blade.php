<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran PMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        📝 Formulir Lengkap Pendaftaran Mahasiswa Baru
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('user.formulir.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-3 text-primary border-bottom pb-2">I. Data Pribadi Calon Mahasiswa</h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">NISN <span class="text-danger">*</span></label>
                                    <input type="number" name="nisn" class="form-control" placeholder="Nomor Induk Siswa Nasional" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama Sekolah Asal" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota Kelahiran" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-select">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
                                <input type="number" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap Rumah</label>
                                <textarea name="alamat" class="form-control" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"></textarea>
                            </div>

                            <h5 class="mb-3 mt-4 text-primary border-bottom pb-2">II. Data Orang Tua / Wali</h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control" placeholder="Nama Lengkap Ayah">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" placeholder="Pekerjaan Ayah">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ibu Kandung <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_ibu" class="form-control" placeholder="Nama Lengkap Ibu" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" placeholder="Pekerjaan Ibu">
                                </div>
                            </div>

                            <h5 class="mb-3 mt-4 text-primary border-bottom pb-2">III. Upload Dokumen</h5>

                            <div class="mb-3">
                                <label class="form-label">Pas Foto Formal (3x4) <span class="text-danger">*</span></label>
                                <input type="file" name="foto" class="form-control" accept="image/*" required>
                                <small class="text-muted">Format: JPG/PNG. Wajah terlihat jelas.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Scan Ijazah / SKL (PDF/Gambar) <span class="text-danger">*</span></label>
                                <input type="file" name="ijazah" class="form-control" accept=".pdf,image/*" required>
                                <small class="text-muted">Pastikan tulisan terbaca jelas.</small>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                                <button type="submit" class="btn btn-primary fw-bold">💾 Simpan Formulir Pendaftaran</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
