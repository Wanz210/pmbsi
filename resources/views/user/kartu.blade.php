<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Ujian</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS Umum untuk Tampilan Layar */
        body {
            background-color: #f0f2f5; /* Latar belakang abu-abu muda */
        }
        .kartu-container {
            max-width: 850px;
            margin: 50px auto;
        }
        .kartu {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1); /* Shadow tebal 3D */
            padding: 30px;
            background-color: white;
            position: relative;
        }
        .kartu-header {
            background: linear-gradient(90deg, #3b5998, #4c69b2);
            color: white;
            padding: 1rem;
            margin: -30px -30px 20px -30px; /* Overlap margin */
            border-radius: 1rem 1rem 0 0;
            text-align: center;
        }
        .foto-peserta {
            width: 120px;
            height: 160px;
            object-fit: cover;
            border: 3px solid #3b5998;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th {
            color: #555;
            font-weight: 500;
            width: 35%;
        }
        td {
            font-weight: 600;
        }

        /* CSS untuk Print */
        @media print {
            .btn-print, .alert { display: none !important; }
            body { background: none; margin: 0; padding: 0; }
            .kartu-container { margin: 0; max-width: 100%; }
            .kartu {
                box-shadow: none;
                border: 1px dashed #555; /* Border cetak */
                padding: 15px;
                margin: 0.5cm;
                page-break-after: always;
            }
            .kartu-header {
                background: none;
                color: #333;
                border-bottom: 2px solid #333;
                margin: 0 0 10px 0;
                padding: 0.5rem;
            }
            .foto-peserta { border: 1px solid #333; box-shadow: none; }
            th { color: #333; font-weight: 500; }
            td { font-weight: 600; }
        }
    </style>
</head>
<body>

    @if($status == 'belum_siap')
        <div class="alert alert-danger w-50 mx-auto mt-5 text-center shadow-lg border-0">
            <h5 class="fw-bold"><i class="fas fa-times-circle me-2"></i> Kartu Ujian Belum Siap Dicetak!</h5>
            <p class="mb-3">Untuk mencetak, pastikan **Status Berkas Anda VALID** dan **Status Pembayaran Anda LUNAS**.</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    @else
        <div class="kartu-container">
            <div class="kartu">
                <div class="kartu-header">
                    <h4 class="fw-bold mb-0">KARTU PESERTA UJIAN PMB - {{ date('Y') }}</h4>
                </div>

                <div class="row mt-4 align-items-center">

                    <div class="col-8">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr><th><i class="fas fa-user-tag me-2"></i> Nama Peserta</th><td>: {{ $pendaftar->user->name }}</td></tr>
                                <tr><th><i class="fas fa-building me-2"></i> Asal Sekolah</th><td>: {{ $pendaftar->asal_sekolah }}</td></tr>
                                <tr><th><i class="fas fa-id-card-alt me-2"></i> NISN</th><td>: {{ $pendaftar->nisn }}</td></tr>
                                <tr><th><i class="fas fa-barcode me-2"></i> Kode Peserta</th><td>: <span class="text-danger fw-bolder">{{ $pendaftar->user->id }}.{{ $pendaftar->id }}</span></td></tr>
                                <tr><th><i class="fas fa-chalkboard me-2"></i> Ruang Ujian</th><td>: 201 (Simulasi)</td></tr>
                                <tr><th><i class="fas fa-clock me-2"></i> Waktu Ujian</th><td>: 10 Desember {{ date('Y') }}, Pukul 09.00 WIB</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-4 text-center">
                        <img src="{{ asset('storage/' . $pendaftar->path_foto) }}" alt="Foto Peserta" class="foto-peserta">
                        <small class="d-block mt-2 text-muted">Foto Resmi Peserta</small>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button class="btn btn-success btn-lg btn-print shadow" onclick="window.print()">
                        <i class="fas fa-print me-2"></i> Cetak Kartu Sekarang
                    </button>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-lg btn-print ms-2 shadow">
                        <i class="fas fa-home me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
