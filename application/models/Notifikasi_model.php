<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {

    // 1. CREATE: Membuat notifikasi baru
    public function create_notifikasi($data) {
        return $this->db->insert('notifikasi', $data);
    }

    // 2. GET BY USER: Mengambil notifikasi berdasarkan user
    public function get_notifikasi_by_user($user_id, $limit = null) {
        $this->db->where('id_user', $user_id);
        $this->db->order_by('created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get('notifikasi')->result();
    }

    // 3. GET UNREAD: Mengambil notifikasi yang belum dibaca
    public function get_unread_by_user($user_id) {
        $this->db->where('id_user', $user_id);
        $this->db->where('dibaca', false);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('notifikasi')->result();
    }

    // 4. MARK AS READ: Menandai notifikasi sudah dibaca
    public function mark_as_read($notifikasi_id, $user_id) {
        $this->db->where('id_notifikasi', $notifikasi_id);
        $this->db->where('id_user', $user_id);
        return $this->db->update('notifikasi', ['dibaca' => true]);
    }

    // 5. MARK ALL AS READ: Menandai semua notifikasi user sudah dibaca
    public function mark_all_as_read($user_id) {
        $this->db->where('id_user', $user_id);
        return $this->db->update('notifikasi', ['dibaca' => true]);
    }

    // 6. GET RECENT: Mengambil notifikasi terbaru untuk admin
    public function get_recent($limit = 5) {
        $this->db->select('notifikasi.*, users.nama as nama_user');
        $this->db->from('notifikasi');
        $this->db->join('users', 'notifikasi.id_user = users.id_user');
        $this->db->order_by('notifikasi.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // 7. COUNT UNREAD: Menghitung notifikasi yang belum dibaca
    public function count_unread($user_id) {
        $this->db->where('id_user', $user_id);
        $this->db->where('dibaca', false);
        return $this->db->count_all_results('notifikasi');
    }

    // 8. DELETE: Menghapus notifikasi
    public function delete_notifikasi($id) {
        $this->db->where('id_notifikasi', $id);
        return $this->db->delete('notifikasi');
    }
}