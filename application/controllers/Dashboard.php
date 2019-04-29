<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['title'] = "Home - WIS EDP";
        $data['title_page'] = "Dashboard";
        $this->template->load('template/template_home', 'vDashboard', $data);
    }
    public function getToko()
    {
        $kdtk = $this->input->post('kdtk');
        $query = "SELECT KodeToko,NamaToko,NoTelpToko,aspv,amgr,TypeToko24,TokoApka,isIkiosk,AlamatToko,tipe_koneksi_primary,tipe_koneksi_secondary,TOK_KELURAHAN,TOK_KECAMATAN,KotaToko,sid,ip_wan,
        CONCAT(fullname,' - ', phone) AS personil,ip_router, ip_backup, ip_induk, ip_anak1, ip_apka, ip_ikios, ip_stb, ip_router_edc, ip_anak2, ip_anak3, ip_anak4, ip_anak5, ip_anak6, ip_anak7, ip_pointcafe, ip_telemetri
        FROM tb_toko JOIN tb_user ON tb_toko.`pic_maintenance`=tb_user.`username` LEFT JOIN tb_astinet ON tb_toko.`KodeToko`= tb_astinet.kdtk  JOIN master_ip ON tb_toko.`KodeToko`=master_ip.`kdtk` WHERE tb_toko.Kodetoko='$kdtk'";
        $hasil = $this->db->query($query)->row_array();
        echo json_encode($hasil);
    }
}
