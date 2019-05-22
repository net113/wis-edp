<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checklist extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['title'] = "Cheklist - WIS EDP";
        $data['title_page'] = "Checklist Server";
        $this->template->load('template/template_home', 'vChecklist', $data);
    }
    public function ambildata()
    {
        $periode = $this->input->post('periode');
        $kdgudang = $this->input->post('kdgudang');
        $query = "SELECT * FROM checklist_server where kdgudang='$kdgudang' and tanggal like '$periode%' ";
        $hasil = $this->db->query($query)->result_array();
        echo json_encode($hasil);
    }
    public function cekDetail()
    {
        $kdgudang = $this->input->post('kdgudang');
        $tanggal = $this->input->post('tanggal');
        $shift = $this->input->post('shift');
        $query = "SELECT checklist_server.`kdgudang`, tanggal,checklist$shift AS checklist,serverdc$shift AS serverdc,servernondc$shift AS servernondc,suhu$shift AS suhu,ups$shift AS ups,router1 AS router,modem1 AS modem,
        jmlexcel,jmlfotodc,jmlfotonondc,jmlfotoups,jmlfotosuhu,jmlfotorb,jmlfotomodem FROM checklist_server JOIN config_checklist USING(kdgudang) WHERE tanggal='$tanggal'AND checklist_server.`kdgudang`='$kdgudang'";

        $hasil = $this->db->query($query)->row_array();
        echo json_encode($hasil);
    }
}
