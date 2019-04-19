<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Indiehome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('datatables');
    }
    public function index()
    {
        $data['title'] = "Indiehome - WIS EDP";
        $data['title_page'] = "Indiehome";
        $this->template->load('template/template_home', 'vIndiehome', $data);
    }
    public function get_data_json()
    { //data data produk by JSON object
        header('Content-Type: application/json');
        $this->datatables->select('kdtk as KodeToko, get_nama_toko(kdtk) as NamaToko, tanggal,id_pel,pass, stat');
        $this->datatables->from('tb_indiehome');
        $this->datatables->add_column('view', '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
        <a href="javascript:void(0);" onClick="showModals(\'$1\')" class="admin-menu btn btn-warning btn-circle btn-sm">
            <i class="fas fa-fw fa-edit"></i>
        </a>
        </span>
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete">
        <a href="javascript:void(0);" onClick="deleteID(\'$1\')" class="admin-menu btn btn-danger btn-circle btn-sm">
            <i class="fas fa-fw fa-trash-restore-alt"></i>
        </a>
        </span>', 'KodeToko');
        echo $this->datatables->generate();
    }



    public function crud()
    {
        $aksi = $this->input->post('aksi');
        switch ($aksi) {
            case "get":
                $kdtk = $this->input->post('id');
                $hasilget = $this->db->query("SELECT kdtk as KodeToko, get_nama_toko(kdtk) as NamaToko, tanggal,id_pel,pass, stat from tb_indiehome where kdtk='$kdtk' ")->row_array();
                echo json_encode($hasilget);
                break;

            case "new":

                $data = "";
                $list =  ['id_pel', 'pass', 'tanggal', 'stat'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $kdtk = $this->input->post('KodeToko');
                $updid = $this->session->userdata('fullname');
                $this->db->query("INSERT INTO tb_indiehome SET $data kdtk='$kdtk',updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
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
                $this->db->where('kdtk', $id);
                $this->db->delete('tb_indiehome');

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
                $list =  ['id_pel', 'pass', 'tanggal', 'stat'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_indiehome SET $data updtime=CURRENT_TIMESTAMP(), updid='$updid' WHERE kdtk='$id' ");
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
