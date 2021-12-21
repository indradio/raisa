<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = '';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        if (empty($this->input->post('user_role'))){
            $data['role'] = $this->db->get('user_access_menu')->result_array();
        }else{
            $data['role'] = $this->db->get_where('user_access_menu', ['role_id' => $this->input->post('user_role')])->result_array();

        }
        $data['user_role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('role/index', $data);
        $this->load->view('templates/footer');
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_access_menu');

        redirect('role');
    }
}
