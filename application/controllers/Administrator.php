<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdministratorAdmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        phpinfo();
    }

    public function active()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['user'] = $this->db->get_where('karyawan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/active', $data);
        $this->load->view('templates/footer');
    }

    public function alldata()
    {
        // $output = array(
        //     "data" => $this->db->get('idcard')->result()
        // );

        $data = $this->db->get('idcard')->result_array();
        foreach ($data as $row) {
                $output['data'][] = array(
                    $row['id'],
                    $row['npk'],
                    $row['nama']
                );
        }
		//output to json format
        echo json_encode($output);
    }
}