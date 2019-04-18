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
                $hasilget = $this->db->get_where('tb_toko', ['kodetoko' => $this->input->post('id')])->row_array();
                echo json_encode($hasilget);
                break;

            case "new":

                $data = "";
                $list = ['KodeToko', 'NamaToko', 'tipe_koneksi_primary', 'tipe_koneksi_secondary', 'NoTelpToko', 'aspv', 'amgr', 'TypeToko24', 'TokoApka', 'isIkiosk'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("INSERT INTO tb_toko SET $data updtime=CURRENT_TIMESTAMP(),updid='$updid' ");
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
                $this->db->where('KodeToko', $id);
                $this->db->delete('tb_toko');

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
                $list = ['KodeToko', 'NamaToko', 'tipe_koneksi_primary', 'tipe_koneksi_secondary', 'NoTelpToko', 'aspv', 'amgr', 'TypeToko24', 'TokoApka', 'isIkiosk'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_toko SET $data updtime=CURRENT_TIMESTAMP(), updid='$updid' WHERE KodeToko='$id' ");
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
