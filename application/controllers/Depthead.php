<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Depthead extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/index', $data);
        $this->load->view('templates/footer');
    }

    public function presensi()
    {
        date_default_timezone_set('asia/jakarta');
        $fr = date('Y-m-d 00:00:00', strtotime($this->input->post('datefr')));
        $to = date('Y-m-d 23:59:59', strtotime($this->input->post('dateto')));
        if ($this->input->post('datefr') != null or $this->input->post('dateto') != null) {
            $this->db->where('time >=', $fr);
            $this->db->where('time <=', $to);
            $this->db->where('dept_id', $this->session->userdata('dept_id'));
            $data['presensi'] = $this->db->get('presensi')->result_array();
            $data['fr'] = date('d M Y', strtotime($this->input->post('datefr')));
            $data['to'] = date('d M Y', strtotime($this->input->post('dateto')));
        } else {
            $this->db->where('time >=', date('Y-m-d 00:00:00'));
            $this->db->where('time <=', date('Y-m-d 23:59:59'));
            $this->db->where('dept_id', $this->session->userdata('dept_id'));
            $data['presensi'] = $this->db->get('presensi')->result_array();
            $data['fr'] = date('d M Y');
            $data['to'] = date('d M Y');
        }
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('depthead/presensi', $data);
        $this->load->view('templates/footer');
    }

    public function laporan($parameter)
    {
        if ($parameter == 'kesehatan') {
            $data['sidemenu'] = 'Kepala Departemen';
            $data['sidesubmenu'] = 'Laporan Kesehatan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['kesehatan'] = $this->db->get_where('kesehatan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dirumahaja/data_kesehatan', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('dashboard');
        }
    }
}
