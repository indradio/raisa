<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Famday extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    // public function index()
    // {
    //     $data['sidemenu'] = 'Family Day';
    //     $data['sidesubmenu'] = 'Daftar & Vote';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $data['famday'] = $this->db->get_where('famday', ['npk' =>  $this->session->userdata('npk')])->result_array();
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('famday/index', $data);
    //     $this->load->view('templates/footer');
    // }

    public function vote1()
    {
        $data = [
            'npk' => $this->session->userdata('npk'),
            'ocean' => '1'
        ];
        $this->db->insert('famday_vote', $data);

        $this->session->set_flashdata('message', 'vote');
        redirect('dashboard');
    }

    public function vote2()
    {
        $data = [
            'npk' => $this->session->userdata('npk'),
            'safari' => '1'
        ];
        $this->db->insert('famday_vote', $data);

        $this->session->set_flashdata('message', 'vote');
        redirect('dashboard');
    }
}
