<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kadep extends CI_Controller
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
    public function lembur()
    {
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['rencana'] = $this->db->where('status', '2');
        $data['rencana'] = $this->db->or_where('status', '3');
        $data['rencana'] = $this->db->get('lembur')->result_array();
        $data['rencana_div'] = $this->db->get_where('lembur', ['status' =>  '10'])->result_array();
        $data['rencana_coo'] = $this->db->get_where('lembur', ['status' =>  '11'])->result_array();
        $data['realisasi'] = $this->db->where('status', '5');
        $data['realisasi'] = $this->db->or_where('status', '6');
        $data['realisasi'] = $this->db->get('lembur')->result_array();
        $data['realisasi_div'] = $this->db->get_where('lembur', ['status' =>  '12'])->result_array();
        $data['realisasi_coo'] = $this->db->get_where('lembur', ['status' =>  '13'])->result_array();
        $data['lembur'] = $this->db->where('status', '7');
        $data['lembur'] = $this->db->or_where('status', '9');
        $data['lembur'] = $this->db->get('lembur')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('kadep/lembur', $data);
        $this->load->view('templates/footer');
    }
}