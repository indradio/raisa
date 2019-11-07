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
        $data['rencana_ats'] = $this->db->where('status', '2');
        $data['rencana_ats'] = $this->db->or_where('status', '3');
        $data['rencana_ats'] = $this->db->order_by('status', 'DESC');
        $data['rencana_ats'] = $this->db->get('lembur')->result_array();
        // $data['rencana_div'] = $this->db->get_where('lembur', ['status' =>  '10'])->result_array();
        // $data['rencana_coo'] = $this->db->get_where('lembur', ['status' =>  '11'])->result_array();
        $data['realisasi'] = $this->db->order_by('nama', 'ASC');
        $data['realisasi'] = $this->db->get_where('lembur', ['status' =>  '4'])->result_array();
        $data['realisasi_ats'] = $this->db->where('status', '5');
        $data['realisasi_ats'] = $this->db->or_where('status', '6');
        $data['realisasi_ats'] = $this->db->order_by('status', 'DESC');
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

    public function lembur_detail($id)
    {
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/lp_lembur_detail', $data);
        $this->load->view('templates/footer');
    }

    public function lembur_batalkan($id)
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        //Update status lembur DIBATALKAN
        $this->db->set('catatan', "Waktu REALISASI kamu telah selesai. - Dibatalkan oleh : " . $this->session->userdata['inisial'] ." Pada " . date('d-m-Y - H:i'));
        $this->db->set('status', '0');
        $this->db->set('durasi', '00:00:00');
        $this->db->set('durasi_aktual', '00:00:00');
        $this->db->where('id', $id);
        $this->db->update('lembur');
        // Hapus AKTIVITAS Lembur
        $this->db->set('aktivitas');
        $this->db->where('link_aktivitas', $id);
        $this->db->delete('aktivitas');

        redirect('kadep/lembur/');
    }
    
}