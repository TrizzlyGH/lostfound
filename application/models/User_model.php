<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // 1. COUNT: Menghitung total user
    public function count_all() {
        return $this->db->count_all('users');
    }

    // 2. GET BY ID: Mengambil data user berdasarkan ID
    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id_user' => $id])->row();
    }

    // 3. GET BY EMAIL: Mengambil data user berdasarkan email
    public function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    // 4. CREATE: Menyimpan user baru
    public function create_user($data) {
        return $this->db->insert('users', $data);
    }

    // 5. UPDATE: Mengupdate data user
    public function update_user($id, $data) {
        $this->db->where('id_user', $id);
        return $this->db->update('users', $data);
    }

    // 6. DELETE: Menghapus user
    public function delete_user($id) {
        $this->db->where('id_user', $id);
        return $this->db->delete('users');
    }

    // 7. GET ALL: Mengambil semua user
    public function get_all_users() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('users')->result();
    }

    // 8. VERIFY PASSWORD: Verifikasi password
    public function verify_password($email, $password) {
        $user = $this->get_user_by_email($email);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}