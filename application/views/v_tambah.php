<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Form Lapor Barang Ditemukan
                </div>
                <div class="card-body">
                    
                    <!-- PERHATIAN PENTING: Atribut enctype="multipart/form-data" WAJIB ADA untuk upload file! -->
                    <form action="<?= base_url('barang/simpan') ?>" method="POST" enctype="multipart/form-data">

						<!-- Tambahkan ID "tipeLaporan" dan event onchange -->
						<div class="mb-3">
							<label>Tipe Laporan</label>
							<select name="tipe_laporan" id="tipeLaporan" class="form-select" onchange="ubahLabel()" required>
								<option value="Ditemukan">SAYA MENEMUKAN BARANG</option>
								<option value="Hilang">SAYA KEHILANGAN BARANG</option>
							</select>
						</div>

						<div class="mb-3">
							<label>Nama Barang</label>
							<input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Kunci Motor Honda" required>
						</div>

						<div class="mb-3">
							<label>Deskripsi Detail</label>
							<textarea name="deskripsi" class="form-control" rows="3" placeholder="Warna, merk, ciri-ciri khusus..." required></textarea>
						</div>

						<div class="mb-3">
							<!-- Tambahkan ID "labelLokasi" -->
							<label id="labelLokasi">Lokasi Ditemukan</label>
							<input type="text" name="lokasi_ditemukan" class="form-control" placeholder="Contoh: Lab Komputer J1 / Kantin" required>
						</div>

						<div class="mb-3">
							<!-- Tambahkan ID "labelTanggal" -->
							<label id="labelTanggal">Tanggal Ditemukan</label>
							<input type="date" name="tanggal_ditemukan" class="form-control" required>
						</div>

						<div class="mb-3">
							<label>Upload Foto Barang</label>
							<input type="file" name="foto_barang" class="form-control" accept="image/*" required>
							<small class="text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB.</small>
						</div>

						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-success">Simpan Data & Upload Foto</button>
							<a href="<?= base_url('barang') ?>" class="btn btn-secondary">Batal</a>
						</div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function ubahLabel() {
        var tipe = document.getElementById("tipeLaporan").value;
        var labelLokasi = document.getElementById("labelLokasi");
        var labelTanggal = document.getElementById("labelTanggal");

        if (tipe === "Hilang") {
            labelLokasi.innerHTML = "Lokasi Terakhir Dilihat";
            labelTanggal.innerHTML = "Tanggal Kehilangan";
        } else {
            labelLokasi.innerHTML = "Lokasi Ditemukan";
            labelTanggal.innerHTML = "Tanggal Ditemukan";
        }
    }
</script>
</body>
</html>
