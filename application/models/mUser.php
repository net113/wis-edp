<?php
class mUser extends CI_Model
{

    function get_all_user()
    {
        $this->datatables->select('username,fullname,email,phone,role_name,admin_menu,is_active');
        $this->datatables->from('tb_user');
        $this->datatables->join('tb_user_role', 'tb_user.`role_id`=tb_user_role.`role_id`', 'left');
        $this->datatables->add_column('view', '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit">
        <a href="javascript:void(0);" onClick="showModals($1)" class="btn btn-warning btn-circle btn-sm">
            <i class="fas fa-fw fa-edit"></i>
        </a>
    </span>
    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete">
        <a href="javascript:void(0);" onClick="deleteID($1)" class="btn btn-danger btn-circle btn-sm">
            <i class="fas fa-fw fa-trash-restore-alt"></i>
        </a>
    </span>
    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Reset Password">
        <a href="javascript:void(0);" onClick="resetPassword($1)" class="btn btn-success btn-circle btn-sm">
            <i class="fas fa-fw fa-key"></i>
        </a>
    </span>', 'username');
        return $this->datatables->generate();
    }

    function get_user_active()
    {
        $this->db->where('is_active', 'Y');
        return $this->db->get('tb_user')->num_rows();
    }
}
