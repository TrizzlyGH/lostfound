<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model agar bisa digunakan di semua fungsi
        $this->load->model('Barang_model');
    }

    // 1. Menampilkan Daftar Barang
    public function index() {
        $data['barang'] = $this->Barang_model->get_semua_barang();
        $this->load->view('v_daftar', $data);
    }

    // 2. Menampilkan Form Tambah
    public function tambah() {
        $this->load->view('v_tambah');
    }

    // 3. Proses Simpan Data & Upload Gambar
    public function simpan() {
        // Konfigurasi Upload Gambar
        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // Maksimal 2MB
        $config['file_name']     = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_barang')) {
            // Jika upload berhasil
            $fileData = $this->upload->data();
			// Tangkap tipe laporan
            $tipe = $this->input->post('tipe_laporan');
            // Tentukan status awal secara cerdas berdasarkan tipe laporan
            $status_awal = ($tipe == 'Hilang') ? 'Belum Ditemukan' : 'Belum Diambil';
            $data = [
                'tipe_laporan'      => $tipe,
                'nama_barang'       => $this->input->post('nama_barang'),
                'deskripsi'         => $this->input->post('deskripsi'),
                'lokasi_ditemukan'  => $this->input->post('lokasi_ditemukan'),
                'tanggal_ditemukan' => $this->input->post('tanggal_ditemukan'),
                'foto_barang'       => $fileData['file_name'],
                'status'            => $status_awal // <--- Status otomatis menyesuaikan
            ];

            $this->Barang_model->tambah_barang($data);
            redirect('barang');
        } else {
            // Jika upload gagal, tampilkan error
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];
        }
    }

    // 4. Proses Hapus Data & File Fisik
    public function hapus($id) {
        $barang = $this->Barang_model->get_barang_by_id($id);
        
        // Hapus file gambar di folder assets/uploads/
        if ($barang->foto_barang != "") {
            unlink('./assets/uploads/' . $barang->foto_barang);
        }

        $this->Barang_model->hapus_barang($id);
        redirect('barang');
    }

	// Menampilkan Form Edit
    public function edit($id) {
        $data['barang'] = $this->Barang_model->get_barang_by_id($id);
        $this->load->view('v_edit', $data);
    }

    // Memproses Perubahan Data
    public function update() {
        $id = $this->input->post('id_barang');
        
        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048;
        $config['file_name']     = 'item-edit-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

        $this->load->library('upload', $config);

        // Data awal yang akan diupdate (Tanpa foto dulu)
        $data = [
            'nama_barang'       => $this->input->post('nama_barang'),
            'lokasi_ditemukan'  => $this->input->post('lokasi_ditemukan'),
            'status'            => $this->input->post('status') // Status harus mengambil dari form, jangan dipatenkan
        ];

        // Logika: Jika user mengupload foto baru
        if ($this->upload->do_upload('foto_barang')) {
            // Hapus foto lama agar folder tidak penuh
            $old_data = $this->Barang_model->get_barang_by_id($id);
            if ($old_data->foto_barang != "") {
                unlink('./assets/uploads/' . $old_data->foto_barang);
            }
            // Simpan nama foto baru ke array $data
            $fileData = $this->upload->data();
            $data['foto_barang'] = $fileData['file_name'];
        }

        $this->Barang_model->update_barang($id, $data);
        redirect('barang');
    }
}
