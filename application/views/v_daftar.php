<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sistem Lost and Found</title>
    <!-- Memanggil CSS Bootstrap agar rapi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Daftar Barang Hilang & Ditemukan</h2>
    
    <!-- Tombol untuk menuju halaman tambah data -->
    <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary mb-3">+ Lapor Barang</a>
    
    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
            <tr>
				<th>Tipe</th>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Barang</th>
                <th>Detail Lokasi</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($barang as $b): ?>
            <tr>
				<td>
					<?php if($b->tipe_laporan == 'Hilang'): ?>
						<span class="badge bg-danger">Mencari (Hilang)</span>
					<?php else: ?>
						<span class="badge bg-success">Ditemukan</span>
					<?php endif; ?>
				</td>
                <td><?= $no++ ?></td>
                <td>
                    <!-- Menampilkan gambar dari folder uploads -->
                    <img src="<?= base_url('assets/uploads/'.$b->foto_barang) ?>" width="100" class="img-thumbnail" alt="Foto Barang">
                </td>
                <td><?= $b->nama_barang ?></td>
                <td><?= $b->lokasi_ditemukan ?></td>
                <td><?= $b->tanggal_ditemukan ?></td>
                <td>
					<?php if($b->status == 'Belum Ditemukan'): ?>
						<span class="badge bg-danger">Belum Ditemukan</span>
					<?php elseif($b->status == 'Belum Diambil'): ?>
						<span class="badge bg-warning text-dark">Belum Diambil</span>
					<?php else: ?>
						<span class="badge bg-success">Selesai</span>
					<?php endif; ?>
				</td>
                <td>
					<a href="<?= base_url('barang/edit/'.$b->id_barang) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <!-- Tombol Hapus -->
                    <a href="<?= base_url('barang/hapus/'.$b->id_barang) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini beserta fotonya?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
