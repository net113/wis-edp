<?php
class mToko extends CI_Model
{

    function get_all()
    {
        $this->datatables->select('KodeToko,NamaToko,tipe_koneksi_primary,tipe_koneksi_secondary,TypeToko24,isIkiosk,TokoApka,NoTelpToko,aspv,amgr');
        $this->datatables->from('tb_toko');
        $this->datatables->add_column('view', '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
        <a href="javascript:void(0);" onClick="showModals(\'$1\')" class="btn btn-warning btn-circle btn-sm">
            <i class="fas fa-fw fa-edit"></i>
        </a>
    </span>
    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete">
        <a href="javascript:void(0);" onClick="deleteID(\'$1\')" class="btn btn-danger btn-circle btn-sm">
            <i class="fas fa-fw fa-trash-restore-alt"></i>
        </a>
    </span>', 'KodeToko');
        return $this->datatables->generate();
    }

    function get_user_active()
    {
        $this->db->where('is_active', 1);
        return $this->db->get('tb_user')->num_rows();
    }
}
