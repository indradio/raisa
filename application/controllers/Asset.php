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
        date_default_timezone_set('asia/jakarta');

        if (($this->input->post('status') == 2 or $this->input->post('status') == 3 or $this->input->post('status') == 4) and $this->input->post('catatan') == null) {
            $this->session->set_flashdata('message', 'gagalopname');
            redirect('asset/do_opname/' . $this->input->post('asset_no') . '/' . $this->input->post('asset_sub_no'));
        } else {
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $assetno = $this->input->post('asset_no');
            $assetsubno = $this->input->post('asset_sub_no');
            $queryCek = "SELECT COUNT(*)
                FROM `asset_opname`
                WHERE `asset_no` =  '$assetno' AND `asset_sub_no` =  '$assetsubno'
                ";
            $cek = $this->db->query($queryCek)->row_array();
            $ketemu = $cek['COUNT(*)'];
            if ($ketemu == 0) {

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
                    'status_opname' => '1',
                    'catatan' => $this->input->post('catatan'),
                    'dept_id' => $karyawan['dept_id']
                ];
                $this->db->insert('asset_opname', $data);


                $config['upload_path']          = './assets/img/asset/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size']             = 5120;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $this->db->set('asset_foto', $this->upload->data('file_name'));
                    $this->db->where('asset_no', $this->input->post('asset_no'));
                    $this->db->where('asset_sub_no', $this->input->post('asset_sub_no'));
                    $this->db->update('asset_opname');
                }

                $this->db->set('tglopname', date('Y-m-d H:i:s'));
                $this->db->set('status_opname', '2');
                $this->db->set('catatan', 'Sedang diverifikasi oleh Tim');
                $this->db->where('asset_no', $this->input->post('asset_no'));
                $this->db->where('asset_sub_no', $this->input->post('asset_sub_no'));
                $this->db->update('asset');

                $this->session->set_flashdata('message', 'berhasilopname');
                redirect('asset');
            } else {
                $this->db->set('tglopname', date('Y-m-d H:i:s'));
                $this->db->set('asset_deskripsi', $this->input->post('asset_deskripsi'));
                $this->db->set('lokasi', $this->input->post('lokasi'));
                $this->db->set('npk', $this->input->post('npk'));
                $this->db->set('status', $this->input->post('status'));
                $this->db->set('status_opname', '1');
                $this->db->set('catatan', $this->input->post('catatan'));
                $this->db->set('verifikasi', null);
                $this->db->set('ka_dept', null);
                $this->db->set('fin_dept', null);
                $this->db->where('asset_no', $this->input->post('asset_no'));
                $this->db->where('asset_sub_no', $this->input->post('asset_sub_no'));
                $this->db->update('asset_opname');

                $config['upload_path']          = './assets/img/asset/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size']             = 5120;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    $this->db->set('asset_foto', $this->upload->data('file_name'));
                    $this->db->where('asset_no', $this->input->post('asset_no'));
                    $this->db->where('asset_sub_no', $this->input->post('asset_sub_no'));
                    $this->db->update('asset_opname');
                }

                $this->db->set('tglopname', date('Y-m-d H:i:s'));
                $this->db->set('status_opname', '2');
                $this->db->set('catatan', 'Sedang diverifikasi oleh Tim');
                $this->db->where('asset_no', $this->input->post('asset_no'));
                $this->db->where('asset_sub_no', $this->input->post('asset_sub_no'));
                $this->db->update('asset');

                $this->session->set_flashdata('message', 'berhasilopname');
                redirect('asset');
            }
        }
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

    public function asset()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Asset Manajemen';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get('asset')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/asset', $data);
        $this->load->view('templates/footer');
    }
    public function opname1()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Asset Manajemen';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset', ['status_opname' =>  1])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/asset', $data);
        $this->load->view('templates/footer');
    }
    public function opname2()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Asset Manajemen';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset', ['status_opname' =>  2])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/asset', $data);
        $this->load->view('templates/footer');
    }
}
