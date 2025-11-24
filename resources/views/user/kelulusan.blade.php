<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Kelulusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Pengumuman Hasil Seleksi Penerimaan Mahasiswa Baru</h4>
                    </div>
                    <div class="card-body p-5">
                        <p>Yth. Saudara/i **{{ $pendaftar->user->name ?? 'Calon Peserta' }}**</p>
                        <p>Berdasarkan hasil seleksi dan verifikasi yang telah dilakukan panitia PMB, berikut adalah status kelulusan Anda:</p>

                        <div class="text-center mt-5 mb-5">
                            @if($pendaftar && $pendaftar->status_lulus == 'lulus')
                                <h1 class="display-4 text-success fw-bold">SELAMAT! ANDA DINYATAKAN LULUS.</h1>
                                <p class="lead mt-3">Silakan lakukan registrasi ulang sesuai jadwal yang tertera di menu Dashboard.</p>
                            @elseif($pendaftar && $pendaftar->status_lulus == 'tidak')
                                <h1 class="display-4 text-danger fw-bold">MOHON MAAF. ANDA DINYATAKAN TIDAK LULUS.</h1>
                                <p class="lead mt-3">Terima kasih atas partisipasi Anda.</p>
                            @else
                                <h1 class="display-4 text-warning fw-bold">STATUS: PROSES SELEKSI</h1>
                                <p class="lead mt-3">Hasil kelulusan akan diumumkan setelah Ujian Seleksi dan Proses Verifikasi Panitia selesai.</p>
                            @endif
                        </div>

                        <div class="mt-4 border-top pt-3 text-muted small">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
