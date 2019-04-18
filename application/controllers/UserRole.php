<?php
defined('BASEPATH') or exit('No direct script access allowed');

class userRole  extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {

        $data['title'] = "Master Role - WIS EDP";
        $data['title_page'] = "Master Role";
        $data['tbrole'] = $this->db->get('tb_user_role')->result_array();
        $this->template->load('template/template_home', 'vUserRole', $data);
    }
    public function accessMenu()
    {
        $data['title'] = "Master Role - WIS EDP";
        $data['title_page'] = "Master Role";
        $data['tbmenu'] = $this->db->get('tb_menu')->result_array();
        $data['user_role'] = $this->db->get_where('tb_user_role', ['role_id' => $this->uri->segment(3)])->row_array();
        $this->template->load('template/template_home', 'vAccessMenu', $data);
    }

    public function changeAccess()
    {
        $id_menu = $this->input->post('idMenu');
        $id_level_user = $this->input->post('idRole');
        $data = ['id_menu' => $id_menu, 'id_level_user' => $id_level_user];
        $result = $this->db->get_where('tb_menu_role', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('tb_menu_role', $data);
        } else {
            $this->db->delete('tb_menu_role', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">
                INFO!! Access Changed
              </div>');
    }


    public function crud()
    {
        $aksi = $this->input->post('aksi');
        switch ($aksi) {
            case "get":
                $hasilget = $this->db->get_where('tb_user_role', ['role_id' => $this->input->post('role_id')])->row_array();
                echo json_encode($hasilget);
                break;

            case "new":

                $role_name = $this->input->post('role_name');
                $updid = $this->session->userdata('fullname');
                $this->db->query("INSERT INTO tb_user_role SET role_name='$role_name', updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
                if ($this->db->affected_rows()) {
                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">
                    INFO!! Data berhasil ditambahkan
                  </div>');
                    echo 'berhasil';
                } else {
                    echo 'gagal';
                }


                break;

            case "delete":
                $role_id = $this->input->post('key');
                $this->db->where('role_id', $role_id);
                $this->db->delete('tb_user_role');

                if ($this->db->affected_rows()) {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                    INFO!! Data berhasil dihapus
                  </div>');
                    echo 'berhasil';
                } else {
                    echo 'gagal';
                }

                break;

            case "edit":
                $role_id = $this->input->post('key');
                $role_name = $this->input->post('role_name');
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_user_role SET  role_name='$role_name', updtime=CURRENT_TIMESTAMP(), updid='$updid' WHERE role_id='$role_id' ");
                if ($this->db->affected_rows()) {
                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">
                INFO!! Data berhasil dipudate
              </div>');
                    echo 'berhasil';
                } else {
                    echo 'gagal';
                }
                break;
        }
    }
}
