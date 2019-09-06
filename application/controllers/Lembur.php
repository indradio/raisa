<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lembur extends CI_Controller
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

    public function rencana()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Rencana';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/rencana', $data);
        $this->load->view('templates/footer');
    }

    public function realisasi()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Realisasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/realisasi', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

        $queryLembur = "SELECT COUNT(*)
        FROM `lembur`
        WHERE YEAR(tglpengajuan) = YEAR(CURDATE())
        ";
        $lembur = $this->db->query($queryLembur)->row_array();
        $totalLembur = $lembur['COUNT(*)'] + 1;

        $mulai = strtotime($this->input->post('tglmulai'));
        $selesai = strtotime($this->input->post('tglselesai'));
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        $data = [
            'id' => 'OT' . date('y') . $totalLembur,
            'tglpengajuan' => date('Y-m-d H:i:s'),
            'npk' => $this->session->userdata('npk'),
            'nama' => $karyawan['nama'],
            'tglmulai' => $this->input->post('tglmulai'),
            'tglselesai' => $this->input->post('tglselesai'),
            'atasan1_rencana' => $atasan1['inisial'],
            'atasan2_rencana' => $atasan2['inisial'],
            'durasi' => $jam . ':' . $menit . ':00',
            'status' => '1'
        ];
        $this->db->insert('lembur', $data);

        redirect('lembur/rencana');
        // redirect('lembur/rencana_aktivitas/' . $data['id']);
    }

    public function rencana_aktivitas($id)
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Rencana';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('jamkerja_aktivitas', ['aktivitas_id' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/rencana_aktivitas', $data);
        $this->load->view('templates/footer');
    }
}
