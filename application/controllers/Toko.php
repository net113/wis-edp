<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('datatables');
        $this->load->model('mToko');
    }
    public function index()
    {
        $data['title'] = "Toko - WIS EDP";
        $data['title_page'] = "Toko";
        $this->template->load('template/template_home', 'vToko', $data);
    }
    public function get_data_json()
    { //data data produk by JSON object
        header('Content-Type: application/json');
        echo $this->mToko->get_all();
    }



    public function crud()
    {
        $aksi = $this->input->post('aksi');
        switch ($aksi) {
            case "get":
                $hasilget = $this->db->get_where('tb_toko', ['kodetoko' => $this->input->post('id')])->row_array();
                echo json_encode($hasilget);
                break;

            case "new":

                $data = "";
                $list = ['KodeToko', 'NamaToko', 'tipe_koneksi_primary', 'tipe_koneksi_secondary', 'NoTelpToko', 'aspv', 'amgr', 'TypeToko24', 'TokoApka', 'isIkiosk'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $kdtk = $this->input->post('KodeToko');
                $updid = $this->session->userdata('fullname');
                $this->db->query("INSERT INTO tb_toko SET $data updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
                $this->db->query("INSERT INTO master_ip SET kdtk='$kdtk', updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
                if ($this->db->affected_rows()  >= 0) {
                    $hasil  = array("tipe" => "success", "data" => "Data Berhasil ditambahkan");
                    echo json_encode($hasil);
                } else {
                    $hasil  = array("tipe" => "error", "data" => $this->db->error()['message']);
                    echo json_encode($hasil);
                }


                break;

            case "delete":
                $id = $this->input->post('key');
                $this->db->where('KodeToko', $id);
                $this->db->delete('tb_toko');

                if ($this->db->affected_rows()  >= 0) {
                    $hasil  = array("tipe" => "success", "data" => "Data Dihapus!!!!");
                    echo json_encode($hasil);
                } else {
                    $hasil  = array("tipe" => "error", "data" => $this->db->error()['message']);
                    echo json_encode($hasil);
                }

                break;

            case "edit":
                $id = $this->input->post('key');
                $data = "";
                $list = ['KodeToko', 'NamaToko', 'tipe_koneksi_primary', 'tipe_koneksi_secondary', 'NoTelpToko', 'aspv', 'amgr', 'TypeToko24', 'TokoApka', 'isIkiosk'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_toko SET $data updtime=CURRENT_TIMESTAMP(), updid='$updid' WHERE KodeToko='$id' ");
                if ($this->db->affected_rows()  >= 0) {
                    $hasil  = array("tipe" => "success", "data" => "Data sudah di Update");
                    echo json_encode($hasil);
                } else {
                    $hasil  = array("tipe" => "error", "data" => $this->db->error()['message']);
                    echo json_encode($hasil);
                }
                break;
        }
    }
}
