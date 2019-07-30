<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persetujuandl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        if ($this->session->userdata('posisi_id') < 7) {
            $data['sidemenu'] = 'Perjalanan Dinas';
            $data['sidesubmenu'] = 'Persetujuan DL';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('persetujuandl/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('auth/denied');
        }
    }

    public function setujudl()
    {
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($rsv['atasan1'] == $this->session->userdata['inisial'] and $rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('atasan2', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan1'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan2', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }
        //Ganti status : 1 = Reservasi baru, 2 = Reservasi disetujui seksi/koordinator, 3 = Reservasi disetujui Kadept/kadiv/coo
        if ($this->session->userdata['posisi_id'] == '1' or $this->session->userdata['posisi_id'] == '2' or $this->session->userdata['posisi_id'] == '3') {
            $this->db->set('status', '3');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($this->session->userdata['posisi_id'] == '4' or $this->session->userdata['posisi_id'] == '5' or $this->session->userdata['posisi_id'] == '6') {
            $this->db->set('status', '2');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }

        $this->session->set_flashdata('message', 'setujudl');
        redirect('persetujuandl/index');
    }
    public function bataldl()
    {
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($rsv['atasan1'] == $this->session->userdata['inisial'] and $rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->set('atasan2', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan1'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan2', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }

        $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan'));
        $this->db->set('status', '0');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('persetujuandl/index');
    }
}
