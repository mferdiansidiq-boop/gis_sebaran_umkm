<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .btn-umkm {
            background: #2563eb;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 12px;
            border: none;
            width: 100%;
            transition: 0.3s;
        }
        .btn-umkm:hover { background: #1d4ed8; }
        .form-control {
            border-radius: 12px;
            padding: 12px;
            background: #f1f5f9;
            border: none;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <!-- Logo UMKM -->
        <img src="<?= base_url('AdminLTE/dist/img/user1.png') ?>" width="80" class="mb-3 rounded-circle shadow-sm">
        <h4 class="fw-bold">Selamat Datang</h4>
        <p class="text-muted small">Sistem Informasi GIS UMKM</p>
    </div>

    <form action="<?= base_url('auth/CekLogin') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label text-secondary small fw-bold">E-MAIL</label>
            <input type="email" name="email" class="form-control" placeholder="nama@umkm.com" required>
        </div>
        <div class="mb-4">
            <label class="form-label text-secondary small fw-bold">PASSWORD</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-umkm">MASUK KE SISTEM</button>
    </form>
</div>

</body>
</html>