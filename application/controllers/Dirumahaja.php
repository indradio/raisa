<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dirumahaja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = '#DiRumahAja';
        $data['sidesubmenu'] = 'Form';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $kesehatan = $this->db->get_where('kesehatan', ['npk' => $this->session->userdata('npk')])->row_array();
        if (empty($kesehatan)) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dirumahaja/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data['kesehatan'] = $this->db->get_where('kesehatan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dirumahaja/hasil', $data);
            $this->load->view('templates/footer');
        }
    }

    public function submit()
    {
        date_default_timezone_set('asia/jakarta');
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

        $data = [
            'id' => time(),
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'a1' => $this->input->post('a1'),
            'a2' => $this->input->post('a2'),
            'a3' => $this->input->post('a3'),
            'b1' => $this->input->post('b1'),
            'b2' => $this->input->post('b2'),
            'b3' => $this->input->post('b3'),
            'b4' => $this->input->post('b4'),
            'b5' => $this->input->post('b5'),
            'catatan' => $this->input->post('catatan'),
            'create_at' => date('Y-m-d H:i:s'),
            'status' => '9'
        ];
        $this->db->insert('kesehatan', $data);
        redirect('dirumahaja');
    }

    public function izin()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'Izin Operasional';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/suratizin', $data);
        $this->load->view('templates/footer');
    }

    public function uptodate()
    {
        $data['sidemenu'] = 'DiRumahAja';
        $data['sidesubmenu'] = 'Informasi Terbaru';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/informasi', $data);
        $this->load->view('templates/footer');
    }

    public function medcare()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'E-Claim Medcare';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/medcare', $data);
        $this->load->view('templates/footer');
    }

    public function protokol()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'Protokol';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/protokol', $data);
        $this->load->view('templates/footer');
    }

    public function tamu()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'Daftar Tamu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/tamu', $data);
        $this->load->view('templates/footer');
    }
}
