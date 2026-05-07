<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin - Sistem Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .stat-card {
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .badge bg-danger { background-color: #cc482d !important; color: #211c1d !important; }
        .badge-pending { background-color: #e6ba33 !important; color: #211c1d !important; }
        .badge-verified { background-color: #da8630 !important; color: #211c1d !important; }
        .badge-resolved { background-color: #643d98 !important; color: #ffffff !important; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-search"></i> Lost & Found Admin</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-shield"></i> Admin: <?= $this->session->userdata('nama') ?>
                </span>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 dashboard-title"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-box fa-2x mb-2"></i>
                        <h4 class="card-title"><?= $total_barang ?? 0 ?></h4>
                        <p class="card-text">Total Laporan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card bg-warning text-dark">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h4 class="card-title"><?= $pending_verifikasi ?? 0 ?></h4>
                        <p class="card-text">Menunggu Verifikasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h4 class="card-title"><?= $selesai ?? 0 ?></h4>
                        <p class="card-text">Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-bolt"></i> Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?= base_url('barang/tambah') ?>" class="btn btn-success btn-lg w-100 mb-2">
                                    <i class="fas fa-plus"></i><br>Lapor Barang Baru
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="<?= base_url('dashboard/admin') ?>" class="btn btn-primary btn-lg w-100 mb-2">
                                    <i class="fas fa-refresh"></i><br>Refresh Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-clock"></i> Laporan Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <?php if(isset($recent_barang) && !empty($recent_barang)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tipe</th>
                                            <th>Nama Barang</th>
                                            <th>Lokasi</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach(array_slice($recent_barang, 0, 5) as $b): ?>
                                        <tr>
                                            <td>
                                                <?php if($b->tipe_laporan == 'Hilang'): ?>
                                                    <span class="badge bg-danger">Hilang</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $b->nama_barang ?></td>
                                            <td><?= $b->lokasi_ditemukan ?></td>
                                            <td>
                                                <?php
                                                $status_class = 'badge-pending';
                                                if($b->status == 'Selesai') $status_class = 'badge-resolved';
                                                elseif($b->status == 'Belum Ditemukan' || $b->status == 'Belum Diambil') $status_class = 'badge-verified';
                                                ?>
                                                <span class="badge <?= $status_class ?>"><?= $b->status ?></span>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($b->tanggal_ditemukan)) ?></td>
                                            <td>
                                                <a href="<?= base_url('barang/edit/'.$b->id_barang) ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('barang/hapus/'.$b->id_barang) ?>" class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Yakin hapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Belum ada laporan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-pie"></i> Ringkasan Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" width="100" height="200"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Simple chart for status distribution
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Selesai'],
                datasets: [{
                    data: [<?= $pending_verifikasi ?? 0 ?>, <?= $selesai ?? 0 ?>],
                    backgroundColor: ['#e6ba33', '#837c92']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</body>
</html>
