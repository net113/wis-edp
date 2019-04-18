<?php
defined('BASEPATH') or exit('No direct script access allowed');

class coverage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('datatables');
        $this->load->model('mCoverage');
    }
    public function index()
    {
        $data['title'] = "Area Coverage - WIS EDP";
        $data['title_page'] = "Area Coverage";
        $this->template->load('template/template_home', 'vCoverage', $data);
    }
    public function get_data_json()
    { //data data produk by JSON object
        header('Content-Type: application/json');
        echo $this->mCoverage->get_all();
    }



    public function crud()
    {
        $aksi = $this->input->post('aksi');
        switch ($aksi) {
            case "get":
                $hasilget = $this->db->get_where('tb_toko', ['kodetoko' => $this->input->post('id')])->row_array();
                echo json_encode($hasilget);
                break;


            case "edit":
                $id = $this->input->post('key');
                $data = "";
                $list = ['pic_maintenance'];
                foreach ($list as $l) {
                    $data .= $l . "='" . $this->input->post($l) . "',";
                }
                $updid = $this->session->userdata('fullname');
                $this->db->query("UPDATE tb_toko SET $data updtime=CURRENT_TIMESTAMP(), updid='$updid' WHERE kodetoko='$id' ");
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
