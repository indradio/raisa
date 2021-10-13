<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kadep extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
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
    public function lembur_status()
    {
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Status Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['rencana_ats'] = $this->db->where('status', '2');
        $data['rencana_ats'] = $this->db->or_where('status', '3');
        $data['rencana_ats'] = $this->db->order_by('dept_id', 'DESC');
        $data['rencana_ats'] = $this->db->order_by('status', 'ASC');
        $data['rencana_ats'] = $this->db->get('lembur')->result_array();
        // $data['rencana_div'] = $this->db->get_where('lembur', ['status' =>  '10'])->result_array();
        // $data['rencana_coo'] = $this->db->get_where('lembur', ['status' =>  '11'])->result_array();
        $data['realisasi'] = $this->db->order_by('tglselesai', 'ASC');
        $data['realisasi'] = $this->db->get_where('lembur', ['status' =>  '4'])->result_array();
        $data['realisasi_ats'] = $this->db->where('status', '5');
        $data['realisasi_ats'] = $this->db->or_where('status', '6');
        $data['realisasi_ats'] = $this->db->order_by('dept_id', 'DESC');
        $data['realisasi_ats'] = $this->db->order_by('status', 'ASC');
        $data['realisasi_ats'] = $this->db->get('lembur')->result_array();
        // $data['realisasi_div'] = $this->db->get_where('lembur', ['status' =>  '12'])->result_array();
        // $data['realisasi_coo'] = $this->db->get_where('lembur', ['status' =>  '13'])->result_array();
        $data['lembur'] = $this->db->where('status', '7');
        // $data['lembur'] = $this->db->or_where('status', '9');
        $data['lembur'] = $this->db->get('lembur')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/lp_lembur_persetujuan', $data);
        $this->load->view('templates/footer');
    }

    public function lembur()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan MH';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        
        $tglawal = date("Y-m-d 00:00:00", strtotime($this->input->post('tglawal')));
        $tglakhir = date("Y-m-d 23:59:00", strtotime($this->input->post('tglakhir')));
        $bulan = date('m');
        $tahun = date('Y');
        if ($this->input->post('tglawal') != null AND $this->input->post('tglakhir') != null)
        {
            $data['lembur'] = $this->db->where('tglmulai >=', $tglawal);
            $data['lembur'] = $this->db->where('tglmulai <=', $tglakhir);
            $data['lembur'] = $this->db->where('status', '9');
            $data['lembur'] = $this->db->get('lembur')->result_array();
        }else{
            $data['lembur'] = $this->db->where('year(tglmulai)', $tahun);
            $data['lembur'] = $this->db->where('month(tglmulai)', $bulan);
            $data['lembur'] = $this->db->where('status', '9');
            $data['lembur'] = $this->db->get('lembur')->result_array();
            $this->session->set_flashdata('pilihtgl', ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data yang TAMPIL adalah LEMBUR di BULAN INI. Silahkan PILIH tanggal untuk menemukan data yang dibutuhkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/lp_lembur', $data);
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

    public function project($menu)
    {
        if ($menu=='budget')
        {
            $data['sidemenu'] = 'Kepala Departemen';
            $data['sidesubmenu'] = 'Laporan Budget Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['project'] = $this->db->get_where('project', ['highlight' => 1])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/lp_project_budget', $data);
            $this->load->view('templates/footer');
        }
    }

    public function status($menu)
    {
        if ($menu=='jamkerja'){
            date_default_timezone_set('asia/jakarta');
            if (empty($this->input->post('month'))){
                $data['bulan'] = date('m');
            }else{
                $data['bulan'] = $this->input->post('month');
            }
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'Kepala Departemen';
            $data['sidesubmenu'] = 'Laporan Status JK';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('kadep/jamkerja_status', $data);
            $this->load->view('templates/footer');
        }
    }
    
}