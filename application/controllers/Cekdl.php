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
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Keberangkatan / Keluar';
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
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Keberangkatan / Keluar';
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
        $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
        $this->db->set('cekberangkat', $this->session->userdata('inisial'));
        $this->db->set('kmberangkat', $this->input->post('kmberangkat'));
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', '2');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        if ($this->input->post('jamberangkat') <= $um['um1']) {
            $this->db->set('um1', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };
        if ($this->input->post('jamberangkat') <= $um['um2']) {
            $this->db->set('um2', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };

        $this->session->set_flashdata('message', 'berangkat');
        redirect('cekdl/berangkat');
    }

    public function kembali()
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Kembali / Masuk';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '2'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/kembali', $data);
        $this->load->view('templates/footer');
    }

    public function cekkembali($dl)
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Kembali / Masuk';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/cekkembali', $data);
        $this->load->view('templates/footer');
    }

    public function cekkembali_proses()
    {
        $kmtotal = $this->input->post('kmkembali') - $this->input->post('kmberangkat');
        $this->db->set('jamkembali', $this->input->post('jamkembali'));
        $this->db->set('cekkembali', $this->session->userdata('inisial'));
        $this->db->set('kmkembali', $this->input->post('kmkembali'));
        $this->db->set('kmtotal', $kmtotal);
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', '9');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        if ($this->input->post('jamberangkat') <= $um['um3'] and $this->input->post('jamkembali') >= $um['um3']) {
            $this->db->set('um3', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };
        if ($this->input->post('jamkembali') >= $um['um4']) {
            $this->db->set('um4', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };

        redirect('cekdl/kembali');
    }
}
