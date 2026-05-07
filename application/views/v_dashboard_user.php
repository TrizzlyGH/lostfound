<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard User - Sistem Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .search-card {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
        }
        .item-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .badge-hilang { background-color: #cc482d !important; color: #211c1d !important; }
        .badge-ditemukan { background-color: #da8630 !important; color: #211c1d !important; }
        .badge-belum-ditemukan { background-color: #e6ba33 !important; color: #211c1d !important; }
        .badge-belum-diambil { background-color: #ebda34 !important; color: #211c1d !important; }
        .badge-selesai { background-color: #643d98 !important; }
        .card-footer { background-color: #ffffff !important; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-search"></i> Lost & Found</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user"></i> <?= $this->session->userdata('nama') ?>
                </span>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card search-card">
                    <div class="card-body text-center py-5">
                        <h2 class="card-title mb-3">
                            <i class="fas fa-search fa-2x mb-3"></i><br>
                            Temukan Barang Anda
                        </h2>
                        <p class="card-text mb-4">
                            Lihat daftar barang hilang dan ditemukan. Jika menemukan barang Anda, hubungi admin untuk informasi lebih lanjut.
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Cari nama barang...">
                                    <button class="btn btn-light" type="button" onclick="searchItems()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info for Reporting Lost Items -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Ingin Melapor Barang Hilang?</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-phone text-primary"></i> Hubungi Admin:</h6>
                                <p class="mb-1"><strong>Telepon:</strong> +62 812-3456-7890</p>
                                <p class="mb-1"><strong>Email:</strong> admin@lostfound.com</p>
                                <p class="mb-1"><strong>Jam Operasional:</strong> Senin-Jumat, 08:00-17:00 WIB</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-list-check text-success"></i> Siapkan Informasi:</h6>
                                <ul class="mb-0">
                                    <li>Nama barang yang hilang</li>
                                    <li>Deskripsi lengkap barang</li>
                                    <li>Lokasi terakhir kali dilihat</li>
                                    <li>Tanggal kehilangan</li>
                                    <li>Foto barang (jika ada)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-lightbulb"></i>
                            <strong>Info:</strong> Admin akan memverifikasi laporan Anda dan menginformasikan jika barang ditemukan oleh orang lain.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="btn-group w-100" role="group">
                    <input type="radio" class="btn-check" name="filter" id="all" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="all">
                        <i class="fas fa-list"></i> Semua (<?= count($barang ?? []) ?>)
                    </label>

                    <input type="radio" class="btn-check" name="filter" id="hilang" autocomplete="off">
                    <label class="btn btn-outline-danger" for="hilang">
                        <i class="fas fa-search"></i> Hilang (<?= count(array_filter($barang ?? [], function($b) { return $b->tipe_laporan == 'Hilang'; })) ?>)
                    </label>

                    <input type="radio" class="btn-check" name="filter" id="ditemukan" autocomplete="off">
                    <label class="btn btn-outline-success" for="ditemukan">
                        <i class="fas fa-check-circle"></i> Ditemukan (<?= count(array_filter($barang ?? [], function($b) { return $b->tipe_laporan == 'Ditemukan'; })) ?>)
                    </label>
                </div>
            </div>
        </div>

        <!-- Items Grid -->
        <div class="row" id="itemsContainer">
            <?php if(isset($barang) && !empty($barang)): ?>
                <?php foreach($barang as $b): ?>
                <div class="col-md-6 col-lg-4 mb-4 item-card-container" data-tipe="<?= $b->tipe_laporan ?>" data-nama="<?= strtolower($b->nama_barang) ?>">
                    <div class="card item-card h-100">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <?php if($b->tipe_laporan == 'Hilang'): ?>
                                    <span class="badge badge-hilang">
                                        <i class="fas fa-search"></i> Mencari (Hilang)
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-ditemukan">
                                        <i class="fas fa-check-circle"></i> Ditemukan
                                    </span>
                                <?php endif; ?>

                                <small class="text-muted">
                                    <?= date('d/m/Y', strtotime($b->tanggal_ditemukan)) ?>
                                </small>
                            </div>
                        </div>

                        <img src="<?= base_url('assets/uploads/'.$b->foto_barang) ?>"
                             class="card-img-top" alt="Foto Barang"
                             style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title"><?= $b->nama_barang ?></h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt text-muted"></i>
                                <strong>Lokasi:</strong> <?= $b->lokasi_ditemukan ?><br>
                                <i class="fas fa-info-circle text-muted"></i>
                                <strong>Deskripsi:</strong> <?= substr($b->deskripsi, 0, 100) ?>...
                            </p>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge
                                    <?php
                                    if($b->status == 'Belum Ditemukan') echo 'badge-belum-ditemukan';
                                    elseif($b->status == 'Belum Diambil') echo 'badge-belum-diambil';
                                    elseif($b->status == 'Selesai') echo 'badge-selesai';
                                    else echo 'badge-secondary';
                                    ?>">
                                    <?= $b->status ?>
                                </span>

                                <button class="btn btn-primary btn-sm" onclick="showContactModal(<?= $b->id_barang ?>, '<?= addslashes($b->nama_barang) ?>')">
                                    <i class="fas fa-phone"></i> Hubungi Admin
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada laporan barang</h4>
                            <p class="text-muted">Jadilah yang pertama melapor!</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-phone"></i> Hubungi Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Untuk informasi lebih detail tentang barang "<strong id="itemName"></strong>", silakan hubungi admin:</p>
                    <div class="alert alert-info">
                        <i class="fas fa-envelope"></i> <strong>Email:</strong> admin@lostfound.com<br>
                        <i class="fas fa-phone"></i> <strong>Telepon:</strong> +62 812-3456-7890<br>
                        <i class="fas fa-clock"></i> <strong>Jam Operasional:</strong> Senin-Jumat, 08:00-17:00 WIB
                    </div>
                    <p class="text-muted">
                        <small>Admin akan membantu menghubungkan Anda dengan pelapor atau pemilik barang.</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="mailto:admin@lostfound.com?subject=Informasi Barang" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Kirim Email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functionality
        document.querySelectorAll('input[name="filter"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const filterValue = this.id;
                const containers = document.querySelectorAll('.item-card-container');

                containers.forEach(container => {
                    if (filterValue === 'all' || container.dataset.tipe.toLowerCase() === filterValue) {
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                    }
                });
            });
        });

        // Search functionality
        function searchItems() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const containers = document.querySelectorAll('.item-card-container');

            containers.forEach(container => {
                const itemName = container.dataset.nama;
                if (itemName.includes(searchTerm)) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        }

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', searchItems);

        // Contact modal
        function showContactModal(itemId, itemName) {
            document.getElementById('itemName').textContent = itemName;
            new bootstrap.Modal(document.getElementById('contactModal')).show();
        }
    </script>
</body>
</html>