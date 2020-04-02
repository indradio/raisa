<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('presensi_model', 'presensi');
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
            if (empty($this->input->post('month'))){
                $data['bulan'] = date('m');
            }else{
                $data['bulan'] = $this->input->post('month');
            }
            $data['tahun'] = date('Y');
        $data['sidemenu'] = 'Presensi';
        $data['sidesubmenu'] = 'Presensi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/index', $data);
        $this->load->view('templates/footer');
    }
}