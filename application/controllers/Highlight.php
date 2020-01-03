<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Highlight extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
    }

    public function idcard()
    {
        $data['sidemenu'] = 'Highlight';
        $data['sidesubmenu'] = 'Desain ID CARD';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['idcard'] = $this->db->get('idcard')->result_array();
        $data['total_like'] = $this->db->get_where('idcard_like', ['npk' => $this->session->userdata('npk')]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/idcard', $data);
        $this->load->view('templates/footer');
    }

    public function like($design)
    {
        $total_like = $this->db->get_where('idcard_like', ['npk' => $this->session->userdata('npk')]);
        if ($total_like->num_rows()<4){
            $data = [
                'npk' => $this->session->userdata('npk'),
                'design' => $design
            ];
            $this->db->insert('idcard_like', $data);
            redirect('highlight/idcard');
        }else{
            redirect('highlight/idcard');
        }
    }

    public function wivi()
    {
        redirect('http://10.14.14.14/wivi');
    }
}
