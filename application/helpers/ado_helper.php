<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->has_userdata('username')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        $alowed = ['', 'profile'];
        if (in_array($menu, $alowed)) {
            $menu = 'dashboard';
        }

        $querymenu = "SELECT tb_menu_role.*,link FROM tb_menu_role JOIN tb_menu 
        ON tb_menu_role.`id_menu`=tb_menu.id WHERE id_level_user='$role_id' AND link ='$menu'";
        $cekMenuAkses = $ci->db->query($querymenu)->num_rows();
        if ($cekMenuAkses < 1) {
            redirect('auth/blocked');
        }
    }
}

function cekAkses($role_id, $menu_id)
{
    $ci = get_instance();
    $result = $ci->db->get_where('tb_menu_role', ['id_level_user' => $role_id, 'id_menu' => $menu_id]);

    if ($result->num_rows() > 0) {
        return 'checked="checked"';
    }
}
function getFullname()
{
    $ci = get_instance();
    $fullname =     $ci->db->get_where('tb_user', ['username' => $ci->session->userdata['username']])->row_array();
    return $fullname['fullname'];
}
function getPictProfile()
{
    $ci = get_instance();
    $fullname =     $ci->db->get_where('tb_user', ['username' => $ci->session->userdata['username']])->row_array();
    return $fullname['pict_profile'];
}

function getTotalUser()
{
    $ci = get_instance();
    $totalUser =     $ci->db->get_where('tb_user', ['is_active' => 1])->num_rows();
    return $totalUser;
}

function getTotalToko()
{
    $ci = get_instance();

    $totalToko =     $ci->db->get('tb_toko');
    if ($totalToko) {
        return $totalToko->num_rows();
    } else {
        return $ci->db->error()['message'];
    }
}

function getTokoVsat()
{
    $ci = get_instance();
    $totalTokoVsat =     $ci->db->get_where('tb_toko', ['tipe_koneksi_primary' => 'vsat']);
    if ($totalTokoVsat) {
        return $totalTokoVsat->num_rows();
    } else {
        return $ci->db->error()['message'];
    }
}

function getTokoFO()
{
    $ci = get_instance();
    $totalTokoFO =     $ci->db->query('SELECT * FROM tb_toko WHERE tipe_koneksi_primary!="vsat"');
    if ($totalTokoFO) {
        return $totalTokoFO->num_rows();
    } else {
        return $ci->db->error()['message'];
    }
}

function getTipeToko($KD)
{
    $ci = get_instance();
    $query = 'SELECT * FROM tb_toko WHERE left(KodeToko,1)="' . $KD . '"';
    $totalTokoKoneksi =     $ci->db->query($query);
    if ($totalTokoKoneksi) {
        return $totalTokoKoneksi->num_rows();
        //return $query;
    } else {
        return $ci->db->error()['message'];
    }
}


function getTokoKoneksi($jeniskoneksi)
{
    $ci = get_instance();
    $query = 'SELECT * FROM tb_toko WHERE tipe_koneksi_primary="' . $jeniskoneksi . '"';
    $totalTokoKoneksi =     $ci->db->query($query);
    if ($totalTokoKoneksi) {
        return $totalTokoKoneksi->num_rows();
        //return $query;
    } else {
        return $ci->db->error()['message'];
    }
}

function getWitel($tipewitel)
{
    $ci = get_instance();
    $query = 'SELECT * FROM tb_astinet WHERE witel="' . $tipewitel . '"';
    $totalTokoKoneksi =     $ci->db->query($query);
    if ($totalTokoKoneksi) {
        return $totalTokoKoneksi->num_rows();
        //return $query;
    } else {
        return $ci->db->error()['message'];
    }
}

function getXLstat($stat)
{
    $ci = get_instance();
    $query = 'SELECT * FROM tb_xl WHERE stat="' . $stat . '"';
    $totalTokoKoneksi =     $ci->db->query($query);
    if ($totalTokoKoneksi) {
        return $totalTokoKoneksi->num_rows();
        //return $query;
    } else {
        return $ci->db->error()['message'];
    }
}

function dowloadSQLtoCSV($strquery, $strnama)
{
    $ci = get_instance();
    $ci->load->dbutil();
    $ci->load->helper('file');
    $ci->load->helper('download');
    $query = $ci->db->query($strquery);
    $delimiter = ",";
    $newline = "\r\n";
    $data = $ci->dbutil->csv_from_result($query, $delimiter, $newline);
    $namafile = $strnama . date("d-m-Y") . ".csv";
    force_download($namafile, $data);
}
