<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Formulir Biodata Calon Mahasiswa</h5>
                    </div>
                    <div class="card-body">

                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf

                            <h6 class="text-muted mb-3">Data Pribadi</h6>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                <small class="text-muted">Nama sesuai akun login.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama SMA/SMK" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor HP / WhatsApp</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="0812..." required>
                            </div>

                            <hr>
                            <h6 class="text-muted mb-3">Upload Berkas</h6>

                            <div class="mb-3">
                                <label class="form-label">Pas Foto (Formal)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" required>
                                <small class="text-danger">*Format JPG/PNG, Wajah terlihat jelas.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Scan Ijazah / SKL</label>
                                <input type="file" name="ijazah" class="form-control" accept=".pdf,.jpg,.jpeg" required>
                                <small class="text-danger">*Format PDF atau JPG.</small>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-success">Simpan Pendaftaran</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
