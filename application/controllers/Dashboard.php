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
}
