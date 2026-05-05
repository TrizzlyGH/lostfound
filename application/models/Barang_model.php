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

    // 6. COUNT: Menghitung total barang
    public function count_all() {
        return $this->db->count_all('barang');
    }

    // 7. COUNT BY STATUS: Menghitung barang berdasarkan status
    public function count_by_status($status) {
        if ($status == 'pending') {
            $this->db->where_in('status', ['Belum Ditemukan', 'Belum Diambil']);
        } elseif ($status == 'verified') {
            $this->db->where('status !=', 'Selesai');
        } elseif ($status == 'resolved') {
            $this->db->where('status', 'Selesai');
        }
        return $this->db->count_all_results('barang');
    }

    // 8. GET RECENT: Mengambil laporan terbaru
    public function get_recent($limit = 5) {
        $this->db->order_by('tanggal_ditemukan', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('barang')->result();
    }
}
