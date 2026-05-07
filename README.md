# Sistem Lost & Found - CodeIgniter

Sistem manajemen barang hilang dan ditemukan berbasis web menggunakan CodeIgniter 3.

## 🎯 Fitur Utama

### Admin Dashboard

- ✅ **Statistik Lengkap**: Total laporan, pending verifikasi, terverifikasi, total user
- ✅ **Manajemen Laporan**: Create, Read, Update, Delete (CRUD) lengkap
- ✅ **Tracking Pelapor**: Catat siapa yang melapor barang
- ✅ **Sistem Notifikasi**: Kirim pesan ke user
- ✅ **Chart & Visualisasi**: Dashboard dengan grafik status laporan

### User Dashboard

- ✅ **Lapor Barang**: Form laporan barang hilang/ditemukan
- ✅ **Browse Barang**: Lihat semua laporan dengan filter & search
- ✅ **Hubungi Admin**: Modal contact untuk informasi lebih lanjut
- ✅ **Responsive Design**: Tampilan mobile-friendly

### Sistem Autentikasi

- ✅ **Multi-Role**: Admin & User dengan akses berbeda
- ✅ **Session Management**: Login/logout dengan session
- ✅ **Password Hashing**: Keamanan password dengan bcrypt
- ✅ **Form Validation**: Validasi input lengkap

## 📋 Struktur Database

### Tabel `users`

```sql
- id_user (Primary Key)
- nama
- email (Unique)
- password (Hashed)
- role (admin/user)
- nomor_hp
- created_at
```

### Tabel `barang` (Updated)

```sql
- id_barang (Primary Key)
- tipe_laporan (Hilang/Ditemukan)
- nama_barang
- deskripsi
- lokasi_ditemukan
- tanggal_ditemukan
- foto_barang
- status (Belum Ditemukan/Belum Diambil/Selesai)
- id_user (Foreign Key)
- status_verifikasi (pending/verified/resolved)
- catatan_admin
```

### Tabel `notifikasi`

```sql
- id_notifikasi (Primary Key)
- id_user (Foreign Key)
- pesan
- link_barang (Foreign Key)
- dibaca (Boolean)
- created_at
```

## 🚀 Cara Setup

### 1. Setup Database Otomatis

Buka browser dan akses: `http://localhost/lostfound/setup_database.php`

**ATAU** Import manual dengan file `database_migration.sql` di phpMyAdmin.

### 2. Konfigurasi Database (Opsional)

Jika perlu mengubah konfigurasi, edit file `application/config/database.php`:

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_lostfound',
    // ... konfigurasi lainnya
);
```

### 3. Akses Sistem

- **URL**: `http://localhost/lostfound/`
- **Admin Login**: <admin@lostfound.com> / admin123
- **User Login**: <user@lostfound.com> / user123

## 📱 Cara Penggunaan

### Untuk Admin

1. Login dengan akun admin
2. Kelola laporan di Dashboard Admin
3. Verifikasi laporan masuk
4. Kirim notifikasi ke pelapor
5. Update status barang

### Untuk User

1. Register akun baru atau login
2. Lapor barang hilang/ditemukan
3. Browse daftar barang lainnya
4. Hubungi admin jika menemukan barang Anda

## 🛠️ Teknologi

- **Framework**: CodeIgniter 3.1.13
- **Frontend**: Bootstrap 5.3.0 + Font Awesome 6
- **Database**: MySQL
- **Charts**: Chart.js
- **Authentication**: Session-based

## 📂 Struktur File

lostfound/
├── application/
│   ├── controllers/
│   │   ├── Auth.php          # Controller autentikasi
│   │   ├── Barang.php        # Controller CRUD barang
│   │   └── Dashboard.php     # Controller dashboard
│   ├── models/
│   │   ├── Auth_model.php    # Model autentikasi
│   │   ├── Barang_model.php  # Model barang
│   │   ├── User_model.php    # Model user
│   │   └── Notifikasi_model.php # Model notifikasi
│   └── views/
│       ├── v_login.php       # View login
│       ├── v_register.php    # View register
│       ├── v_dashboard_admin.php # Dashboard admin
│       ├── v_dashboard_user.php  # Dashboard user
│       ├── v_daftar.php      # Daftar barang (admin)
│       ├── v_tambah.php      # Form tambah barang
│       └── v_edit.php        # Form edit barang
├── assets/
│   └── uploads/              # Folder upload gambar
├── database_migration.sql    # Script database
└── system/                   # CodeIgniter core

## 🔧 Development Notes

### Password Hashing

Password menggunakan `password_hash()` dengan algoritma bcrypt. Password demo sudah di-hash.

### File Upload

- Format: GIF, JPG, PNG, JPEG
- Max size: 2MB
- Path: `assets/uploads/`

### Session Configuration

Session menggunakan database untuk persistence. Konfigurasi di `config.php`.

## 📞 Support

Untuk pertanyaan atau masalah, silakan buat issue di repository atau hubungi developer.

## Selamat Coding! 🎉
