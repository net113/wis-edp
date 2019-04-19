<?php
defined('BASEPATH') or exit('No direct script access allowed');

class iptoko extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('datatables');
    }
    public function index()
    {
        $data['title'] = "IP Toko - WIS EDP";
        $data['title_page'] = "IP Toko";
        $this->template->load('template/template_home', 'vIpToko', $data);
    }
    public function get_data_json()
    { //data data produk by JSON object
        header('Content-Type: application/json');

        $this->datatables->select('KodeToko,get_nama_toko(KodeToko) as NamaToko,ip_router,ip_induk,ip_anak1,ip_anak2,ip_anak3,ip_ikios,ip_stb,ip_router_edc');
        $this->datatables->from('master_ip');
        $this->datatables->add_column('view', '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Detail">
        <a href="javascript:void(0);" onClick="viewModals(\'$1\')" class=" btn btn-info btn-circle btn-sm">
            <i class="fas fa-fw fa-search-plus"></i>
        </a>
        </span>
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
        <a href="javascript:void(0);" onClick="showModals(\'$1\')" class="admin-menu btn btn-warning btn-circle btn-sm">
            <i class="fas fa-fw fa-edit"></i>
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
                $hasilget = $this->db->query("SELECT * FROM tb_toko JOIN master_ip USING(KodeToko) WHERE kodetoko='$kdtk';")->row_array();
                echo json_encode($hasilget);
                break;

            
            case "edit":
                $id = $this->input->post('key');
                $data = "";
                $list = [ 'tipe_koneksi_primary', 'tipe_koneksi_secondary', 'ip_router', 'ip_backup', 'ip_induk', 'ip_anak1', 'ip_apka', 'ip_ikios', 'ip_stb', 'ip_router_edc','ip_anak2','ip_anak3','ip_anak4','ip_anak5','ip_anak6','ip_anak7','ip_pointcafe','ip_telemetri' ];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_toko INNER JOIN master_ip ON tb_toko.KodeToko=master_ip.KodeToko SET $data master_ip.updtime=CURRENT_TIMESTAMP(), master_ip.updid='$updid' WHERE master_ip.KodeToko='$id' ");
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

    public function downloadMaster()
    {
        
        $str= "SELECT kodetoko,namatoko,(SELECT kode FROM tb_tipe_koneksi WHERE jenis=t.`tipe_koneksi_primary`) as koneksi_utama,tipe_koneksi_primary as ket_utama,ip_router AS ip_utama,
        (select kode from tb_tipe_koneksi where jenis=t.`tipe_koneksi_secondary`) as koneksi_backup,tipe_koneksi_Secondary as ket_backup, ip_backup, IF(TypeToko24='Y',24,15) AS jambuka
         from tb_toko t left join master_ip using(KodeToko)";        
        $namafile = "master_koneksi_";
        dowloadSQLtoCSV($str, $namafile);

    }
}
