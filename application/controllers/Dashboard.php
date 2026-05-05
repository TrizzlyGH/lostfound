<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Barang_model');
        $this->load->model('User_model');
        $this->load->model('Notifikasi_model');

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Dashboard Admin
    public function admin() {
        // Cek role admin
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard/user');
        }

        // Ambil data statistik
        $data['total_barang'] = $this->Barang_model->count_all();
        $data['pending_verifikasi'] = $this->Barang_model->count_by_status('pending');
        $data['selesai'] = $this->Barang_model->count_by_status('resolved');

        // Ambil laporan terbaru
        $data['recent_barang'] = $this->Barang_model->get_recent(5);

        $this->load->view('v_dashboard_admin', $data);
    }

    // Dashboard User
    public function user() {
        // Cek role user
        if ($this->session->userdata('role') != 'user') {
            redirect('dashboard/admin');
        }

        // Ambil semua barang untuk ditampilkan
        $data['barang'] = $this->Barang_model->get_semua_barang();

        $this->load->view('v_dashboard_user', $data);
    }

    // Redirect berdasarkan role
    public function index() {
        if ($this->session->userdata('role') == 'admin') {
            redirect('dashboard/admin');
        } else {
            redirect('dashboard/user');
        }
    }
}