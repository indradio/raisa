<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
            $data['sidemenu'] = 'Pendapatan';
            $data['sidesubmenu'] = 'Laporan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['pendapatan'] = $this->db->get('pendapatan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('pendapatan/index', $data);
            $this->load->view('templates/footer');
    }

    public function data()
    {
            $data['sidemenu'] = 'Pendapatan';
            $data['sidesubmenu'] = 'Data';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['pendapatan'] = $this->db->get('pendapatan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('pendapatan/data', $data);
            $this->load->view('templates/footer');
    }

    public function revtambah()
    {
        $this->db->insert('pendapatan', ['nama' => $this->input->post('nama')]);
        redirect('pendapatan/data');
    }
    public function revhapus()
    {
        $this->db->delete('pendapatan', ['nama' => $this->input->post('nama')]);
        redirect('pendapatan/data');
    }
    public function revedit()
    {
        $total = $this->input->post('januari') + $this->input->post('februari') + $this->input->post('maret') + $this->input->post('april') + $this->input->post('mei') + $this->input->post('juni') + $this->input->post('juli') + $this->input->post('agustus') + $this->input->post('september') + $this->input->post('oktober') + $this->input->post('november') + $this->input->post('desember');
        $this->db->set('januari', $this->input->post('januari'));
        $this->db->set('februari', $this->input->post('februari'));
        $this->db->set('maret', $this->input->post('maret'));
        $this->db->set('april', $this->input->post('april'));
        $this->db->set('mei', $this->input->post('mei'));
        $this->db->set('juni', $this->input->post('juni'));
        $this->db->set('juli', $this->input->post('juli'));
        $this->db->set('agustus', $this->input->post('agustus'));
        $this->db->set('september', $this->input->post('september'));
        $this->db->set('oktober', $this->input->post('oktober'));
        $this->db->set('november', $this->input->post('november'));
        $this->db->set('desember', $this->input->post('desember'));
        $this->db->set('total', $total);
        $this->db->where('nama', $this->input->post('nama'));
        $this->db->update('pendapatan');

        redirect('pendapatan/data');
    }
}
