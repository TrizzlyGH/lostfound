<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    // 1. READ: Menampilkan semua data barang (diurutkan dari yang terbaru)
    public function get_semua_barang() {
        $this->db->order_by('tanggal_ditemukan', 'DESC');
        return $this->db->get('barang')->result();
    }

    // 2. CREATE: Menyimpan data barang baru ke database
    public function tambah_barang($data) {
        return $this->db->insert('barang', $data);
    }

    // 3. READ BY ID: Mengambil 1 data spesifik (berguna saat mau edit data)
    public function get_barang_by_id($id) {
        return $this->db->get_where('barang', ['id_barang' => $id])->row();
    }

    // 4. UPDATE: Menyimpan perubahan data barang
    public function update_barang($id, $data) {
        $this->db->where('id_barang', $id);
        return $this->db->update('barang', $data);
    }

    // 5. DELETE: Menghapus data barang
    public function hapus_barang($id) {
        $this->db->where('id_barang', $id);
        return $this->db->delete('barang');
    }
}
