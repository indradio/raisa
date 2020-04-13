<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koordinator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Jam Kerja';
        $data['sidesubmenu'] = 'Laporan Kerja Harian';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['aktivitas'] = $this->jamkerja_model->get_aktivitas();
        $data['project'] = $this->jamkerja_model->fetch_project();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/index', $data);
        $this->load->view('templates/footer');
    }
    public function project()
    {
        $data['sidemenu'] = 'Koordinator';
        $data['sidesubmenu'] = 'Project';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->get_where('project', ['status' =>  'OPEN'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pmd/project', $data);
        $this->load->view('templates/footer');
    }
    public function aktivitas($copro)
    {
        $data['sidemenu'] = 'Koordinator';
        $data['sidesubmenu'] = 'Project';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['aktivitas'] = $this->db->get_where('project_aktivitas', ['copro' =>  $copro])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pmd/aktivitas', $data);
        $this->load->view('templates/footer');
    }

    public function lembur_status()
    {
        $data['sidemenu'] = 'Koordinator';
        $data['sidesubmenu'] = 'Laporan Status Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['rencana_ats'] = $this->db->where('status', '2');
        $data['rencana_ats'] = $this->db->where('sect_id', $this->session->userdata('sect_id'));
        $data['rencana_ats'] = $this->db->or_where('status', '3');
        $data['rencana_ats'] = $this->db->where('sect_id', $this->session->userdata('sect_id'));
        $data['rencana_ats'] = $this->db->order_by('dept_id', 'DESC');
        $data['rencana_ats'] = $this->db->order_by('status', 'ASC');
        $data['rencana_ats'] = $this->db->get('lembur')->result_array();
        // $data['rencana_div'] = $this->db->get_where('lembur', ['status' =>  '10'])->result_array();
        // $data['rencana_coo'] = $this->db->get_where('lembur', ['status' =>  '11'])->result_array();
        $data['realisasi'] = $this->db->where('status', '4');
        $data['realisasi'] = $this->db->where('sect_id', $this->session->userdata('sect_id'));
        $data['realisasi'] = $this->db->order_by('tglselesai', 'ASC');
        $data['realisasi'] = $this->db->get('lembur')->result_array();
        $data['realisasi_ats'] = $this->db->where('status', '5');
        $data['realisasi_ats'] = $this->db->where('sect_id', $this->session->userdata('sect_id'));
        $data['realisasi_ats'] = $this->db->or_where('status', '6');
        $data['realisasi_ats'] = $this->db->where('sect_id', $this->session->userdata('sect_id'));
        $data['realisasi_ats'] = $this->db->order_by('dept_id', 'DESC');
        $data['realisasi_ats'] = $this->db->order_by('status', 'ASC');
        $data['realisasi_ats'] = $this->db->get('lembur')->result_array();
        // $data['realisasi_div'] = $this->db->get_where('lembur', ['status' =>  '12'])->result_array();
        // $data['realisasi_coo'] = $this->db->get_where('lembur', ['status' =>  '13'])->result_array();
        $data['lembur'] = $this->db->where('status', '7');
        $data['lembur'] = $this->db->or_where('status', '9');
        $data['lembur'] = $this->db->get('lembur')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/lp_lembur_persetujuan', $data);
        $this->load->view('templates/footer');
    }

    public function presensi()
    {
        date_default_timezone_set('asia/jakarta');
        if (empty($this->input->post('month'))) {
            $data['bulan'] = date('m');
        } else {
            $data['bulan'] = $this->input->post('month');
        }
        $data['tahun'] = date('Y');
        $data['sidemenu'] = 'Koordinator';
        $data['sidesubmenu'] = 'Laporan Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('koordinator/presensi', $data);
        $this->load->view('templates/footer');
    }
}
