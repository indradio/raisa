<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error404 extends CI_Controller
{
    public function __construct()
    {
        date_default_timezone_set('asia/jakarta');
        parent::__construct();
        is_logged_in();
        $this->load->helper('url');
        
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Page Not Found';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->Karyawan_model->getById();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('errors/index', $data);
        $this->load->view('templates/footer');
    }

}
