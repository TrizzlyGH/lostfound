<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register - Sistem Lost & Found</title>
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
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #e6ba33 0%, #da8630 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-control:focus {
            border-color: #e6ba33;
            box-shadow: 0 0 0 0.2rem rgba(230, 186, 51, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #e6ba33 0%, #da8630 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 61, 152, 0.4);
        }
        .password-strength {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .strength-weak { color: #cc482d; }
        .strength-medium { color: #ebda34; }
        .strength-strong { color: #211c1d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus fa-3x mb-3"></i>
                        <h3>Daftar Akun Baru</h3>
                        <p>Bergabung dengan komunitas Lost & Found</p>
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

                        <form action="<?= base_url('auth/proses_register') ?>" method="post" id="registerForm">
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                       placeholder="Masukkan nama lengkap Anda" required
                                       value="<?= set_value('nama') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Masukkan email aktif Anda" required
                                       value="<?= set_value('email') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="nomor_hp" class="form-label">
                                    <i class="fas fa-phone"></i> Nomor HP
                                </label>
                                <input type="tel" class="form-control" id="nomor_hp" name="nomor_hp"
                                       placeholder="Contoh: 081234567890" required
                                       value="<?= set_value('nomor_hp') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Minimal 6 karakter" required>
                                <div id="passwordStrength" class="password-strength"></div>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">
                                    <i class="fas fa-lock"></i> Konfirmasi Password
                                </label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                       placeholder="Ulangi password Anda" required>
                                <div id="passwordMatch" class="password-strength"></div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agree" required>
                                <label class="form-check-label" for="agree">
                                    Saya setuju dengan <a href="#" class="text-decoration-none">Syarat & Ketentuan</a>
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-register">
                                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">Sudah punya akun?
                                <a href="<?= base_url('auth/login') ?>" class="text-decoration-none">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('passwordStrength');

            if (password.length === 0) {
                strengthIndicator.textContent = '';
                return;
            }

            let strength = 0;
            let feedback = [];

            if (password.length >= 6) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            switch(strength) {
                case 0:
                case 1:
                    strengthIndicator.innerHTML = '<span class="strength-weak">Lemah</span>';
                    break;
                case 2:
                case 3:
                    strengthIndicator.innerHTML = '<span class="strength-medium">Sedang</span>';
                    break;
                case 4:
                case 5:
                    strengthIndicator.innerHTML = '<span class="strength-strong">Kuat</span>';
                    break;
            }
        });

        // Password confirmation checker
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const matchIndicator = document.getElementById('passwordMatch');

            if (confirmPassword.length === 0) {
                matchIndicator.textContent = '';
                return;
            }

            if (password === confirmPassword) {
                matchIndicator.innerHTML = '<span class="strength-strong">Password cocok</span>';
            } else {
                matchIndicator.innerHTML = '<span class="strength-weak">Password tidak cocok</span>';
            }
        });

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }
        });
    </script>
</body>
</html>