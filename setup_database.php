<?php
// Script setup database otomatis - Enhanced Version
echo "<!DOCTYPE html><html><head><title>Database Setup - Lost & Found</title></head><body>";
echo "<h1>🚀 Database Setup untuk Lost & Found</h1>";
echo "<p><strong>Status:</strong> <span id='status'>Memulai setup...</span></p>";
echo "<div id='progress' style='width: 100%; background-color: #f0f0f0; border-radius: 5px; margin: 10px 0;'><div id='progress-bar' style='width: 0%; height: 20px; background-color: #4CAF50; border-radius: 5px; transition: width 0.3s;'></div></div>";
echo "<div id='log'></div>";
echo "<hr>";

// Flush output untuk real-time update
ob_implicit_flush(true);
ob_end_flush();

function updateProgress($percentage, $message) {
    echo "<script>
        document.getElementById('progress-bar').style.width = '$percentage%';
        document.getElementById('status').innerHTML = '$message';
        document.getElementById('log').innerHTML += '<p style=\"margin: 5px 0;\">✓ $message</p>';
        window.scrollTo(0, document.body.scrollHeight);
    </script>";
    flush();
}

function logError($message) {
    echo "<script>
        document.getElementById('log').innerHTML += '<p style=\"color: red; margin: 5px 0;\">❌ $message</p>';
        window.scrollTo(0, document.body.scrollHeight);
    </script>";
    flush();
}

// Konfigurasi database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_lostfound';

try {
    updateProgress(10, "Mencoba koneksi ke MySQL...");

    // Koneksi ke MySQL
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    updateProgress(20, "Koneksi MySQL berhasil");

    // Cek apakah database sudah ada
    $result = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    $dbExists = $result->rowCount() > 0;

    if (!$dbExists) {
        updateProgress(30, "Membuat database $dbname...");
        $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        updateProgress(40, "Database $dbname berhasil dibuat");
    } else {
        updateProgress(40, "Database $dbname sudah ada, menggunakan yang existing");
    }

    // Pilih database
    $pdo->exec("USE `$dbname`");

    // Buat tabel users
    updateProgress(50, "Membuat tabel users...");
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            `id_user` INT PRIMARY KEY AUTO_INCREMENT,
            `nama` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `role` ENUM('admin', 'user') DEFAULT 'user',
            `nomor_hp` VARCHAR(15),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    updateProgress(60, "Tabel users berhasil dibuat");

    // Buat tabel barang (jika belum ada)
    updateProgress(65, "Membuat tabel barang...");
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `barang` (
            `id_barang` INT PRIMARY KEY AUTO_INCREMENT,
            `tipe_laporan` ENUM('Hilang', 'Ditemukan') NOT NULL,
            `nama_barang` VARCHAR(255) NOT NULL,
            `deskripsi` TEXT,
            `lokasi_ditemukan` VARCHAR(255) NOT NULL,
            `tanggal_ditemukan` DATE NOT NULL,
            `foto_barang` VARCHAR(255),
            `status` ENUM('Belum Ditemukan', 'Belum Diambil', 'Selesai') DEFAULT 'Belum Ditemukan',
            `id_user` INT,
            `status_verifikasi` ENUM('pending', 'verified', 'resolved') DEFAULT 'pending',
            `catatan_admin` TEXT,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    updateProgress(70, "Tabel barang berhasil dibuat");

    // Buat tabel notifikasi
    updateProgress(75, "Membuat tabel notifikasi...");
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `notifikasi` (
            `id_notifikasi` INT PRIMARY KEY AUTO_INCREMENT,
            `id_user` INT NOT NULL,
            `pesan` TEXT NOT NULL,
            `link_barang` INT,
            `dibaca` BOOLEAN DEFAULT FALSE,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE CASCADE,
            FOREIGN KEY (`link_barang`) REFERENCES `barang`(`id_barang`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    updateProgress(80, "Tabel notifikasi berhasil dibuat");

    // Insert data admin default
    updateProgress(85, "Insert data admin...");
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("
        INSERT IGNORE INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `nomor_hp`) VALUES
        (1, 'Administrator', 'admin@lostfound.com', '$admin_password', 'admin', '081234567890')
    ");
    updateProgress(90, "Data admin berhasil di-insert");

    // Insert data user demo
    updateProgress(95, "Insert data user demo...");
    $user_password = password_hash('user123', PASSWORD_DEFAULT);
    $pdo->exec("
        INSERT IGNORE INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `nomor_hp`) VALUES
        (2, 'User Demo', 'user@lostfound.com', '$user_password', 'user', '081987654321')
    ");
    updateProgress(100, "Data user demo berhasil di-insert");

    echo "<script>
        document.getElementById('status').innerHTML = '<span style=\"color: green; font-weight: bold;\">🎉 Setup Database Berhasil!</span>';
        document.getElementById('log').innerHTML += '<hr><h3 style=\"color: green;\">✅ Setup Selesai!</h3>';
        document.getElementById('log').innerHTML += '<p><strong>Akun untuk testing:</strong></p>';
        document.getElementById('log').innerHTML += '<ul>';
        document.getElementById('log').innerHTML += '<li><strong>Admin:</strong> admin@lostfound.com / admin123</li>';
        document.getElementById('log').innerHTML += '<li><strong>User:</strong> user@lostfound.com / user123</li>';
        document.getElementById('log').innerHTML += '</ul>';
        document.getElementById('log').innerHTML += '<p><a href=\"../\" style=\"color: blue; text-decoration: none; font-weight: bold;\">← Kembali ke aplikasi</a></p>';
    </script>";

} catch(PDOException $e) {
    logError("Database Error: " . $e->getMessage());
    echo "<script>
        document.getElementById('status').innerHTML = '<span style=\"color: red; font-weight: bold;\">❌ Setup Gagal</span>';
        document.getElementById('log').innerHTML += '<hr><h4 style=\"color: red;\">🔧 Troubleshooting:</h4>';
        document.getElementById('log').innerHTML += '<ul>';
        document.getElementById('log').innerHTML += '<li>Pastikan XAMPP MySQL sudah running</li>';
        document.getElementById('log').innerHTML += '<li>Cek username/password MySQL (default: root / kosong)</li>';
        document.getElementById('log').innerHTML += '<li>Coba restart XAMPP</li>';
        document.getElementById('log').innerHTML += '<li>Jika masih error, hubungi administrator</li>';
        document.getElementById('log').innerHTML += '</ul>';
    </script>";
}

echo "</body></html>";
?>