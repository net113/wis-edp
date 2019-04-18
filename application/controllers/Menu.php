<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['title'] = "Menu Mangement - WIS EDP";
        $data['title_page'] = "Menu Management";
        $query = "SELECT id, nama_menu, link,icon,ifNULL((select nama_menu from tb_menu where id=a.`is_main_menu`),'-') as menu_parent,urutan_menu from  tb_menu a";
        $data['tbmenu'] = $this->db->query($query)->result_array();
        $this->template->load('template/template_home', 'vMenu', $data);
    }

    public function crud()
    {
        $aksi = $this->input->post('aksi');
        switch ($aksi) {
            case "get":
                $hasilget = $this->db->get_where('tb_menu', ['id' => $this->input->post('id')])->row_array();
                echo json_encode($hasilget);
                break;

            case "new":

                $data = "";
                $list = ['nama_menu', 'link', 'urutan_menu', 'icon', 'is_main_menu'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("INSERT INTO tb_menu SET $data updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
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
                $is = $this->input->post('key');
                $this->db->where('id', $id);
                $this->db->delete('tb_menu');

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
                $list = ['nama_menu', 'link', 'urutan_menu', 'icon', 'is_main_menu'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_menu SET $data updtime=CURRENT_TIMESTAMP(), updid='$updid' WHERE id='$id' ");
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
