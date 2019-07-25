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
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('persetujuandl/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data['karyawan'] = $this->Karyawan_model->getById();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('persetujuandl/tolakakses', $data);
            $this->load->view('templates/footer');
        }
    }

    public function setujudl()
    { 
        $this->session->set_flashdata('swal_dlsuccess','');
        redirect('persetujuandl/index');
    }
    public function tolakdl()
    { 
        redirect('persetujuandl/index');
    }
}
