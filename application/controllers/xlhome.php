<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Xlhome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('datatables');
    }
    public function index()
    {
        $data['title'] = "XL Home - WIS EDP";
        $data['title_page'] = "XL Home";
        $this->template->load('template/template_home', 'vXlhome', $data);
    }
    public function get_data_json()
    { //data data produk by JSON object
        header('Content-Type: application/json');
        $this->datatables->select('sn_modem,stat_modem,no_kartu,stat_kartu,kdtk as KodeToko, get_nama_toko(kdtk) as NamaToko, tanggal,stat');
        $this->datatables->from('tb_xl');
        $this->datatables->add_column('view', '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
        <a href="javascript:void(0);" onClick="showModals(\'$1\')" class="admin-menu btn btn-warning btn-circle btn-sm">
            <i class="fas fa-fw fa-edit"></i>
        </a>
        </span>
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete">
        <a href="javascript:void(0);" onClick="deleteID(\'$1\')" class="admin-menu btn btn-danger btn-circle btn-sm">
            <i class="fas fa-fw fa-trash-restore-alt"></i>
        </a>
        </span>', 'sn_modem');
        echo $this->datatables->generate();
    }



    public function crud()
    {
        $aksi = $this->input->post('aksi');
        switch ($aksi) {
            case "get":
                $kdtk = $this->input->post('id');
                $hasilget = $this->db->query("SELECT kdtk as KodeToko, get_nama_toko(kdtk) as NamaToko,stat_modem,sn_modem,no_kartu,stat_kartu,tanggal,stat from tb_xl where sn_modem='$kdtk' ")->row_array();
                echo json_encode($hasilget);
                break;

            case "new":

                $data = "";
                $list =  ['sn_modem', 'stat_modem', 'no_kartu', 'stat_kartu', 'tanggal', 'stat'];
                foreach ($list as $l) {
                    if ($this->input->post($l) == '') {
                        $data .= $l . "=NULL,";
                    } else {
                        $data .= $l . "='" . $this->input->post($l) . "',";
                    }
                }
                $kdtk = $this->input->post('KodeToko');
                $updid = $this->session->userdata('fullname');
                $this->db->query("INSERT INTO tb_xl SET $data kdtk='$kdtk',updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
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
                $this->db->where('sn_modem', $id);
                $this->db->delete('tb_xl');

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
                $list =  ['sn_modem', 'stat_modem', 'no_kartu', 'stat_kartu', 'tanggal', 'stat',];
                foreach ($list as $l) {
                    if ($this->input->post($l) == '') {
                        $data .= $l . "=NULL,";
                    } else {
                        $data .= $l . "='" . $this->input->post($l) . "',";
                    }
                }
                $kdtk = ($this->input->post('KodeToko')) == '' ? 'NULL' : "'" . $this->input->post('KodeToko') . "'";
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_xl SET $data updtime=CURRENT_TIMESTAMP(), kdtk=$kdtk, updid='$updid' WHERE sn_modem='$id' ");
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
