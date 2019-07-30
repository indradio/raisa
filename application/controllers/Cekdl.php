<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cekdl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('persetujuandl/index', $data);
        $this->load->view('templates/footer');
    }

    public function berangkat()
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '1'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/berangkat', $data);
        $this->load->view('templates/footer');
    }

    public function cekberangkat($dl)
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/cekberangkat', $data);
        $this->load->view('templates/footer');
    }

    public function hapus_anggota($dl, $inisial)
    {
        $this->db->where('perjalanan_id', $dl);
        $this->db->where('karyawan_inisial', $inisial);
        $this->db->delete('perjalanan_anggota');

        $anggota = $this->db->where('perjalanan_id', $dl);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $dl);
        $this->db->update('perjalanan');

        $perjalanan = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        redirect('cekdl/cekberangkat/' . $dl);
    }

    public function cekberangkat_proses()
    {
        $this->db->set('kmberangkat', $this->input->post('kmberangkat'));
        $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
        $this->db->set('cekberangkat', $this->session->userdata('inisial'));
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', '2');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        redirect('cekdl/berangkat');
    }
}
