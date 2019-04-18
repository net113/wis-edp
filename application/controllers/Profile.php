<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = "My Profile - WIS EDP";
            $data['title_page'] = "My Profile";
            $username =  $this->session->userdata('username');
            $data['user'] = $this->db->get_where('tb_user', ['username' => $username])->row_array();
            $this->template->load('template/template_home', 'vProfile', $data);
        } else {
            $images = $_FILES['pict_profile'];
            if ($images['name']) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['file_name'] = $this->input->post('username');
                $config['overwrite'] = true;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('pict_profile')) {
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('pict_profile', $new_image);
                } else {

                    $this->upload->display_errors();
                }
            }
            $this->db->set('fullname', $this->input->post('fullname'));
            $this->db->set('email', $this->input->post('email'));
            $this->db->set('phone', $this->input->post('phone'));
            $this->db->where('username', $this->input->post('username'));
            if ($this->db->update('tb_user')) {
                $this->session->set_flashdata('message', '<div class="my-2 alert alert-success" role="alert">
                      INFO!! Your Profile has been updated
                    </div>');
                redirect('profile');
            }
        }
    }

    public function changePassword()
    {
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|differs[current_password]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Repeat Password', 'required|trim|matches[new_password1]');
        if ($this->form_validation->run() == false) {

            $data['title'] = "Change Password - WIS EDP";
            $data['title_page'] = "Change Password";
            $this->template->load('template/template_home', 'vChangePassword', $data);
        } else {
            $old_pass = $this->db->get_where('tb_user', ['username' => $_SESSION['username']])->row_array();
            $current_pass = md5($this->input->post('current_password'));
            $new_pass = $this->input->post('new_password1');
            if ($old_pass['password'] == $current_pass) {
                $this->db->set('password', md5($new_pass));
                $this->db->where('username', $_SESSION['username']);
                if ($this->db->update('tb_user')) {
                    $this->session->set_flashdata('message', '<div class="my-2 alert alert-success" role="alert">
                      INFO!! Your password has been changed
                    </div>');
                    redirect('profile/changePassword');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="my-2 alert alert-warning" role="alert">
                      WARNING!! Your Current Password is invalid
                    </div>');
                redirect('profile/changePassword');
            }
        }
    }
}
