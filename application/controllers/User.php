<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('datatables');
        $this->load->model('mUser');
    }
    public function index()
    {
        $data['title'] = "User - WIS EDP";
        $data['title_page'] = "User Management";
        $this->template->load('template/template_home', 'vUser', $data);
    }
    public function get_data_json()
    { //data data produk by JSON object
        header('Content-Type: application/json');
        echo $this->mUser->get_all_user();
    }

    public function reset()
    {
        $username = $this->input->post('username');
        $updid = $this->session->userdata('fullname');
        $this->db->query("UPDATE tb_user SET password=md5('$username'), updtime=CURRENT_TIMESTAMP(),updid='$updid' WHERE username=$username");
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('message', '<div class="my-0 alert alert-success" role="alert">
              INFO!! Password Berhasil di reset
            </div>');
            echo 'berhasil';
        } else {
            echo 'gagal';
        }
    }


    public function crud()
    {
        $aksi = $this->input->post('aksi');
        switch ($aksi) {
            case "get":
                $hasilget = $this->db->get_where('tb_user', ['username' => $this->input->post('id')])->row_array();
                echo json_encode($hasilget);
                break;

            case "new":

                $data = "";
                $list = ['username', 'fullname', 'email', 'phone', 'role_id', 'is_active', 'admin_menu'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("INSERT INTO tb_user SET $data updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
                if ($this->db->affected_rows()) {
                    $this->session->set_flashdata('message', '<div class="my-0 alert alert-info" role="alert">
                      INFO!! Data berhasil ditambahkan
                    </div>');
                    echo 'berhasil';
                } else {
                    echo 'gagal';
                }


                break;

            case "delete":
                $id = $this->input->post('key');
                $this->db->where('username', $id);
                $this->db->delete('tb_user');

                if ($this->db->affected_rows()) {
                    $this->session->set_flashdata('message', '<div class="my-0 alert alert-warning" role="alert">
                      INFO!! Data berhasil dihapus
                    </div>');
                    echo 'berhasil';
                } else {
                    echo 'gagal';
                }

                break;

            case "edit":
                $id = $this->input->post('key');
                $data = "";
                $list = ['username', 'fullname', 'email', 'phone', 'role_id', 'is_active', 'admin_menu'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_user SET $data updtime=CURRENT_TIMESTAMP(), updid='$updid' WHERE username='$id' ");
                if ($this->db->affected_rows()) {
                    $this->session->set_flashdata('message', '<div class="my-0 alert alert-info" role="alert">
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
