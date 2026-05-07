<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Sistem Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #643d98 0%, #837c92 35%, #211c1d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #e6ba33 0%, #da8630 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-control:focus {
            border-color: #e6ba33;
            box-shadow: 0 0 0 0.2rem rgba(230, 186, 51, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #e6ba33 0%, #da8630 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 61, 152, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h3>Sistem Lost & Found</h3>
                        <p>Masuk ke akun Anda</p>
                    </div>
                    <div class="card-body p-4">

                        <!-- Flash Messages -->
                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-triangle"></i>
                                <?= $this->session->flashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle"></i>
                                <?= $this->session->flashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('auth/proses_login') ?>" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Masukkan email Anda" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Masukkan password Anda" required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-login">
                                    <i class="fas fa-sign-in-alt"></i> Masuk
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">Belum punya akun?
                                <a href="<?= base_url('auth/register') ?>" class="text-decoration-none">
                                    Daftar di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Demo Accounts Info -->
                <div class="card mt-3 border-warning">
                    <div class="card-body">
                        <h6 class="card-title text-warning">
                            <i class="fas fa-info-circle"></i> Akun Demo
                        </h6>
                        <small class="text-muted">
                            <strong>Admin:</strong> admin@lostfound.com / admin123<br>
                            <strong>User:</strong> user@lostfound.com / user123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>