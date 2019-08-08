<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'AssetKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/index', $data);
        $this->load->view('templates/footer');
    }

    public function opname()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'Opname Asset';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset_opname', ['npklama' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/opname', $data);
        $this->load->view('templates/footer');
    }

    public function do_opname($no, $sub)
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'Opname Asset';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $data['asset'] = $this->db->where('asset_no', $no);
        $data['asset'] = $this->db->where('asset_sub_no', $sub);
        $data['asset'] = $this->db->get('asset')->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/do_opname', $data);
        $this->load->view('templates/footer');
    }

    public function opname_proses()
    {
        $data = [
            'tglopname' => date('Y-m-d H:i:s'),
            'asset_no' => $this->input->post('asset_no'),
            'asset_sub_no' => $this->input->post('asset_sub_no'),
            'asset_deskripsi' => $this->input->post('asset_deskripsi'),
            'kategori' => $this->input->post('kategori'),
            'lokasi' => $this->input->post('lokasi'),
            'first_acq' => $this->input->post('first_acq'),
            'value_acq' => $this->input->post('value_acq'),
            'cost_center' => $this->input->post('cost_center'),
            'npklama' => $this->input->post('npklama'),
            'npk' => $this->input->post('npk'),
            'status' => $this->input->post('status'),
            'catatan' => $this->input->post('catatan')
        ];
        $this->db->insert('asset_opname', $data);

        $config['upload_path']          = './assets/img/asset/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 2048;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto')) {
            $this->db->set('asset_foto', $this->upload->data('file_name'));
            $this->db->where('asset_no', $this->input->post('asset_no'));
            $this->db->where('asset_sub_no', $this->input->post('asset_sub_no'));
            $this->db->update('asset_opname');
        } else {
            echo $this->upload->display_errors();
        }
        redirect('asset/opname');
    }

    public function verifikasi()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Opname Verifikasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get('asset_opname')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/opname_verifikasi', $data);
        $this->load->view('templates/footer');
    }
}
