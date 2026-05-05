<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark"><b>Edit Data Barang</b></div>
                <div class="card-body">
                    <form action="<?= base_url('barang/update') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_barang" value="<?= $barang->id_barang ?>">
                        
                        <div class="mb-3">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="<?= $barang->nama_barang ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Detail Lokasi</label>
                            <input type="text" name="lokasi_ditemukan" class="form-control" value="<?= $barang->lokasi_ditemukan ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Status Barang</label>
                            <select name="status" class="form-select">
								<option value="Belum Ditemukan" <?= ($barang->status == 'Belum Ditemukan') ? 'selected' : '' ?>>Belum Ditemukan</option>
								<option value="Belum Diambil" <?= ($barang->status == 'Belum Diambil') ? 'selected' : '' ?>>Belum Diambil</option>
								<option value="Selesai" <?= ($barang->status == 'Selesai') ? 'selected' : '' ?>>Selesai (Sudah Dikembalikan / Diambil)</option>
							</select>
                        </div>

                        <div class="mb-3">
                            <label>Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
                            <input type="file" name="foto_barang" class="form-control" accept="image/*">
                            <p class="mt-2 text-muted small">Foto saat ini: <br> <img src="<?= base_url('assets/uploads/'.$barang->foto_barang) ?>" width="100"></p>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">Update Data</button>
                            <a href="<?= base_url('barang') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
