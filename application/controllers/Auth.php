<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller

{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if ($this->session->has_userdata('username')) {
            redirect();
        }
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {

            $data['title'] = "Login - WIS EDP";
            $this->template->load('template/template_auth', 'auth/vLogin', $data);
        } else {
            $this->_login();
        }
    }
    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('tb_user', ['username' => $username])->row_array();
        if ($user) {
            if (md5($password) == $user['password']) {
                if ($user['is_active'] == 'Y') {
                    $this->session->set_userdata('username', $user['username']);
                    if ($user['admin_menu'] == 'Y') {
                        $this->session->set_userdata('admin_menu', $user['admin_menu']);
                    }
                    $this->session->set_userdata('role_id', $user['role_id']);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                WARNING!! User Anda tidak aktif
              </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                ERROR!! Password salah
              </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            ERROR!! Username tidak terdaftar
          </div>');
            redirect('auth');
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('admin_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">
        INFO!! You have been logged out
      </div>');
        redirect('auth');
    }
    public function blocked()
    {
        $data['title'] = "Blocked - WIS EDP";
        $data['title_page'] = "Blocked";
        $this->template->load('template/template_home', 'vblocked', $data);
    }
}
