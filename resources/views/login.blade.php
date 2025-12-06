<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PMB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS DARI MOCKUP & EFEK 3D (Sama seperti register.blade.php) */
        body {
            /* Gradasi latar belakang yang memudar */
            background: linear-gradient(135deg, #a8c0ff 0%, #3e5fbc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card-container {
            /* Kontainer utama dengan efek melayang 3D */
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1.5rem;
            max-width: 450px; /* Lebih kecil dari form register */
            width: 95%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 0, 0, 0.05);
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
            padding: 2.5rem;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
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
    </style>
</head>
<body>

    <div class="card-container">
        <div class="card-header-custom">
            <h3 class="fw-bolder mb-1 text-shadow">Sistem PMB</h3>
            <p class="text-white-50 mb-0">Login Calon Mahasiswa & Staf</p>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success shadow-sm border-0" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required autofocus placeholder="Masukkan email terdaftar" value="{{ old('email') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow">
                        <i class="fas fa-sign-in-alt me-2"></i> LOGIN
                    </button>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary mt-2">
                        Belum Punya Akun? Daftar di sini
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
