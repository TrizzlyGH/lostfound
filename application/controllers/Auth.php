<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // Halaman login
    public function login() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('v_login');
    }

    // Proses login
    public function proses_login() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->verify_password($email, $password);

            if ($user) {
                // Set session data
                $session_data = [
                    'id_user' => $user->id_user,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'role' => $user->role,
                    'logged_in' => TRUE
                ];

                $this->session->set_userdata($session_data);

                // Redirect berdasarkan role
                if ($user->role == 'admin') {
                    redirect('dashboard/admin');
                } else {
                    redirect('dashboard/user');
                }
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah');
                redirect('auth/login');
            }
        }
    }

    // Halaman register
    public function register() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('v_register');
    }

    // Proses register
    public function proses_register() {
        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('nomor_hp', 'Nomor HP', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nomor_hp' => $this->input->post('nomor_hp'),
                'role' => 'user' // Default role adalah user
            ];

            if ($this->User_model->create_user($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal. Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }

    // Logout
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}