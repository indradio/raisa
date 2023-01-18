<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
    }

    public function index()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'AssetKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('wbs/index', $data);
        $this->load->view('templates/footer');
    }

    public function perjalanan()
    {
        $data['sidemenu'] = 'Laporan';
        $data['sidesubmenu'] = 'Laporan Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if (empty($this->input->post('tahun')))
        {
            $data['tahun'] = date('Y');
            $data['bulan'] = date('m');
        }else{
            $data['tahun'] = $this->input->post('tahun');
            $data['bulan'] = $this->input->post('bulan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanan/laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function lembur($params)
    {
        date_default_timezone_set('asia/jakarta');
        if ($params=='top'){

            if (empty($this->input->post('from')))
            {
                $data['from'] = date('Y-m-d');
                $data['to'] = date('Y-m-d');
            }else{
                $data['from'] = date('Y-m-d', strtotime($this->input->post('from')));
                $data['to'] = date('Y-m-d', strtotime($this->input->post('to')));
            }

            $data['sidemenu'] = 'Laporan';
            $data['sidesubmenu'] = 'Laporan Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/laporan/top_overtime', $data);
            $this->load->view('templates/footer');
        }
        elseif ($params=='se'){
            $data['sidemenu'] = 'Sales Engineering';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['liststatus'] = $this->db->get_where("project_status", ['id !=' => '1'])->result();
            $data['listcustomer'] = $this->db->get("customer")->result();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/index_se', $data);
            $this->load->view('templates/footer');
        }
        elseif ($params=='eng'){
            $data['sidemenu'] = 'Engineering';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['liststatus'] = $this->db->get_where("project_status", ['id !=' => '1'])->result();
            $data['listcustomer'] = $this->db->get("customer")->result();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/index_eng', $data);
            $this->load->view('templates/footer');
        }
        elseif ($params=='pch'){
            $data['sidemenu'] = 'Purchase';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['liststatus'] = $this->db->get_where("project_status", ['id !=' => '1'])->result();
            $data['listcustomer'] = $this->db->get("customer")->result();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/index_pch', $data);
            $this->load->view('templates/footer');
        }
    }

    public function leadtime($params)
    {
        if ($params=='lembur'){
            $data['sidemenu'] = 'Laporan';
            $data['sidesubmenu'] = 'Leadtime Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
            if (empty($this->input->post('tahun')))
            {
                $data['tahun'] = date('Y');
                $data['bulan'] = date('m');
            }else{
                $data['tahun'] = $this->input->post('tahun');
                $data['bulan'] = $this->input->post('bulan');
            }
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/laporan/leadtime', $data);
            $this->load->view('templates/footer');
        }
    }

}
