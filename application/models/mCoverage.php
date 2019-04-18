<?php
class mCoverage extends CI_Model
{

    function get_all()
    {

        $this->datatables->select('KodeToko,NamaToko, pic_maintenance, get_user_name(pic_maintenance) as personil');
        $this->datatables->from('tb_toko');
        $this->datatables->add_column('view', '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
        <a href="javascript:void(0);" onClick="showModals(\'$1\')" class="btn btn-warning btn-circle btn-sm">
            <i class="fas fa-fw fa-edit"></i>
        </a>
    </span>', 'KodeToko');
        return $this->datatables->generate();
    }
}
