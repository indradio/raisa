<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perjalanandl extends CI_Controller
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
    public function admindl()
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '3'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/admindl', $data);
        $this->load->view('templates/footer');
    }

    public function prosesdl($rsv_id)
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['id' =>  $rsv_id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/prosesdl', $data);
        $this->load->view('templates/footer');
    }
    public function gantikend($rsv_id)
    {
        if ($this->input->post('kepemilikan') == 'Operasional') {
            $queryCarinopol = "SELECT COUNT(*)
                FROM `kendaraan`
                WHERE `nopol` =  '{$this->input->post('nopol')}'
                ";
            $carinopol = $this->db->query($queryCarinopol)->row_array();
            $total = $carinopol['COUNT(*)'];
            if ($total == 0) {
                $this->session->set_flashdata('message', 'nopolsalah');
                redirect('perjalanandl/prosesdl/' . $rsv_id);
            } else {
                $this->db->set('nopol', $this->input->post('nopol'));
                $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
                $this->db->where('id', $rsv_id);
                $this->db->update('reservasi');
                redirect('perjalanandl/prosesdl/' . $rsv_id);
            }
        } else {
            $this->db->set('nopol', $this->input->post('nopol'));
            $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
            $this->db->where('id', $rsv_id);
            $this->db->update('reservasi');
            redirect('perjalanandl/prosesdl/' . $rsv_id);
        }
    }
    public function bataldl()
    {
        $this->db->set('status', '0');
        $this->db->set('catatan', $this->input->post('catatan'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('perjalanandl/admindl');
    }
}
