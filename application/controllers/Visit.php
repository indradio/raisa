<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'Daftar Tamu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('visit/index', $data);
        $this->load->view('templates/footer');
    }

    public function guest()
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Kunjungan Tamu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->where('status', '1');
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/visit', $data);
        $this->load->view('templates/footer');
    }

    public function check()
    {
        date_default_timezone_set('asia/jakarta');
        if ($this->input->post('kategori') == 'LAINNYA') {
            $kategori = $this->input->post('kategori_lain');
        } else {
            $kategori = $this->input->post('kategori');
        }
        $this->db->set('pic', $this->input->post('pic'));
        $this->db->set('kategori', $kategori);
        $this->db->set('suhu', $this->input->post('suhu'));
        $this->db->set('hasil', $this->input->post('hasil'));
        $this->db->set('check_by', $this->session->userdata('inisial'));
        $this->db->set('check_at', date("Y-m-d H:i:s"));
        $this->db->set('status', '2');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('visit');

        $this->session->set_flashdata('message', 'terimakasih');
        redirect('visit/guest');
    }

    public function batal($id)
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('hasil', 'DIBATALKAN');
        $this->db->set('catatan', 'TIDAK ADA KUNJUNGAN');
        $this->db->set('check_by', $this->session->userdata('inisial'));
        $this->db->set('check_at', date("Y-m-d H:i:s"));
        $this->db->set('status', '0');
        $this->db->where('id', $id);
        $this->db->update('visit');

        redirect('visit/guest');
    }
}
