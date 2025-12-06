<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Kelulusan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI TEMA MODERN */
        body {
            /* Gradasi latar belakang yang memudar */
            background: linear-gradient(135deg, #a8c0ff 0%, #3e5fbc 100%);
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 1.5rem;
            overflow: hidden; /* Memastikan header gradasi rapi */
        }
        .card-header-custom {
            background: linear-gradient(45deg, #4c69b2, #3b5998);
            color: white;
            padding: 1.5rem;
        }
        .result-box {
            padding: 2.5rem;
            border-radius: 1rem;
            margin-top: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        /* Style Spesifik untuk Hasil */
        .result-lulus {
            background-color: #e6f7e9; /* Light Green */
            border: 2px solid #5cb85c;
            color: #387638;
        }
        .result-tidak-lulus {
            background-color: #fae6e6; /* Light Red */
            border: 2px solid #d9534f;
            color: #b94a48;
        }
        .result-proses {
            background-color: #fff8e1; /* Light Yellow */
            border: 2px solid #f0ad4e;
            color: #c07a00;
        }
        .btn-success { background-color: #5cb85c; border-color: #5cb85c; }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-lg">

                    <div class="card-header-custom text-center">
                        <h3 class="mb-0 fw-bold">
                            <i class="fas fa-bullhorn me-2"></i> Pengumuman Hasil Seleksi PMB
                        </h3>
                    </div>

                    <div class="card-body p-5">

                        <p class="lead">Yth. Saudara/i **{{ $pendaftar->user->name ?? 'Calon Peserta' }}**</p>
                        <p>Dengan hormat, berdasarkan hasil seleksi dan verifikasi berkas yang telah dilakukan panitia PMB, berikut adalah status kelulusan Anda:</p>

                        <div class="text-center">
                            @if($pendaftar && $pendaftar->status_lulus == 'lulus')
                                <div class="result-box result-lulus">
                                    <h1 class="display-3 fw-bold mb-3">
                                        <i class="fas fa-check-circle me-2"></i> SELAMAT!
                                    </h1>
                                    <h2 class="fw-bolder">ANDA DINYATAKAN LULUS.</h2>
                                    <p class="lead mt-3">Silakan lakukan registrasi ulang dan pembayaran UKT sesuai jadwal yang tertera di menu Dashboard.</p>
                                </div>
                            @elseif($pendaftar && $pendaftar->status_lulus == 'tidak')
                                <div class="result-box result-tidak-lulus">
                                    <h1 class="display-3 fw-bold mb-3">
                                        <i class="fas fa-times-circle me-2"></i> MOHON MAAF.
                                    </h1>
                                    <h2 class="fw-bolder">ANDA DINYATAKAN TIDAK LULUS.</h2>
                                    <p class="lead mt-3">Terima kasih atas partisipasi dan minat Anda. Anda masih bisa mencoba jalur pendaftaran berikutnya.</p>
                                </div>
                            @else
                                <div class="result-box result-proses">
                                    <h1 class="display-3 fw-bold mb-3">
                                        <i class="fas fa-spinner fa-spin me-2"></i> PROSES SELEKSI
                                    </h1>
                                    <h2 class="fw-bolder">STATUS: MENUNGGU PENGUMUMAN</h2>
                                    <p class="lead mt-3">Hasil kelulusan akan diumumkan setelah Ujian Seleksi dan semua proses verifikasi panitia selesai.</p>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 border-top pt-3 d-flex justify-content-between align-items-center">
                            <small class="text-muted">Status diperbarui pada: {{ $pendaftar->updated_at ?? '-' }}</small>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
