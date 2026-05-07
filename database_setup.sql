-- Membuat database
CREATE DATABASE IF NOT EXISTS db_lostfound CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_lostfound;

-- Tabel users
CREATE TABLE IF NOT EXISTS users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    nomor_hp VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel barang
CREATE TABLE IF NOT EXISTS barang (
    id_barang INT PRIMARY KEY AUTO_INCREMENT,
    tipe_laporan ENUM('Hilang', 'Ditemukan') NOT NULL,
    nama_barang VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    lokasi_ditemukan VARCHAR(255),
    tanggal_ditemukan DATE,
    foto_barang VARCHAR(255),
    status ENUM('Belum Ditemukan', 'Belum Diambil', 'Selesai') DEFAULT 'Belum Ditemukan',
    id_user INT,
    status_verifikasi ENUM('pending', 'verified', 'resolved') DEFAULT 'pending',
    catatan_admin TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel notifikasi
CREATE TABLE IF NOT EXISTS notifikasi (
    id_notifikasi INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    pesan TEXT NOT NULL,
    link_barang INT,
    dibaca BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (link_barang) REFERENCES barang(id_barang) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data admin
INSERT INTO users (nama, email, password, role, nomor_hp) VALUES
('Administrator', 'admin@lostfound.com', '$2y$12$TtlGSDWE8zq7K4Zfy.jaR.B8R.1J7KGAK/s0OIF6scQeI6e7R.oPC', 'admin', '081234567890');

-- Insert data user demo
INSERT INTO users (nama, email, password, role, nomor_hp) VALUES
('User Demo', 'user@lostfound.com', '$2y$12$7G4vQO4bxryGNxlA7psF6OTyjyOsIqjZ0owHd71UJ7uVrg48/0iXW', 'user', '081987654321');
