<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .kartu {
            width: 800px;
            border: 3px solid #007bff;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        @media print {
            .btn-print { display: none; }
            .kartu { border: 1px solid #333; box-shadow: none; margin: 0; width: 100%; }
        }
    </style>
</head>
<body class="bg-light">

    @if($status == 'belum_siap')
        <div class="alert alert-danger w-50 mx-auto mt-5 text-center">
            <h5>Kartu Ujian Belum Siap Dicetak!</h5>
            <p>Pastikan **Status Berkas Anda VALID** dan **Status Pembayaran Anda LUNAS**.</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    @else
        <div class="kartu bg-white">
            <h4 class="text-primary text-center border-bottom pb-2">KARTU PESERTA UJIAN PMB - {{ date('Y') }}</h4>
            <div class="row mt-4">
                <div class="col-8">
                    <table class="table table-borderless table-sm">
                        <tr><th>Nama Peserta</th><td>: {{ $pendaftar->user->name }}</td></tr>
                        <tr><th>Asal Sekolah</th><td>: {{ $pendaftar->asal_sekolah }}</td></tr>
                        <tr><th>NISN</th><td>: {{ $pendaftar->nisn }}</td></tr>
                        <tr><th>Kode Peserta</th><td>: {{ $pendaftar->user->id }} / {{ $pendaftar->id }}</td></tr>
                        <tr><th>Ruang Ujian</th><td>: 201 (Simulasi)</td></tr>
                        <tr><th>Waktu Ujian</th><td>: 10 Desember 2025, Pukul 09.00 WIB</td></tr>
                    </table>
                </div>
                <div class="col-4 text-center">
                    <img src="{{ asset('storage/' . $pendaftar->path_foto) }}" alt="Foto Peserta" style="width: 120px; height: 160px; border: 1px solid #ccc;">
                </div>
            </div>
            <div class="text-center mt-4">
                <button class="btn btn-success btn-print" onclick="window.print()">Cetak Kartu Sekarang</button>
            </div>
        </div>
    @endif
</body>
</html>
