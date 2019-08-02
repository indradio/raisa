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
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'PerjalananKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/index', $data);
        $this->load->view('templates/footer');
    }
    public function admindl()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '3'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/admindl', $data);
        $this->load->view('templates/footer');
    }

    public function prosesdl1($rsv_id)
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['id' =>  $rsv_id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/prosesdl', $data);
        $this->load->view('templates/footer');
    }

    public function prosesdl2()
    {
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->input->post('npk')])->row_array();

        $this->db->where('posisi_id', '3');
        $this->db->where('dept_id', $karyawan['dept_id']);
        $ka_dept = $this->db->get('karyawan')->row_array();

        $queryDl = "SELECT COUNT(*)
        FROM `perjalanan`
        WHERE YEAR(tglberangkat) = YEAR(CURDATE())
        ";
        $dl = $this->db->query($queryDl)->row_array();
        $totalDl = $dl['COUNT(*)'] + 1;

        $data = [
            'id' => 'DL' . date('y') . $totalDl,
            'npk' => $this->input->post('npk'),
            'nama' => $this->input->post('nama'),
            'tujuan' => $this->input->post('tujuan'),
            'keperluan' => $this->input->post('keperluan'),
            'anggota' => $this->input->post('anggota'),
            'tglberangkat' => $this->input->post('tglberangkat'),
            'jamberangkat' => $this->input->post('jamberangkat'),
            'kmberangkat' => '0',
            'cekberangkat' => null,
            'tglkembali' => $this->input->post('tglkembali'),
            'jamkembali' => $this->input->post('jamkembali'),
            'kmkembali' => '0',
            'cekkembali' => null,
            'nopol' => $this->input->post('nopol'),
            'kepemilikan' => $this->input->post('kepemilikan'),
            'tunai' => $this->input->post('tunai'),
            'admin_ga' => $this->session->userdata('inisial'),
            'catatan_ga' => $this->input->post('catatan'),
            'ka_dept' => $ka_dept['nama'],
            'kmtotal' => '0',
            'reservasi_id' => $this->input->post('id'),
            'status' => '1'
        ];
        $this->db->insert('perjalanan', $data);

        // update table anggota perjalanan
        $this->db->set('perjalanan_id', $data['id']);
        $this->db->where('reservasi_id', $this->input->post('id'));
        $this->db->update('perjalanan_tujuan');

        // update table anggota perjalanan
        $this->db->set('perjalanan_id', $data['id']);
        $this->db->where('reservasi_id', $this->input->post('id'));
        $this->db->update('perjalanan_anggota');

        $this->db->set('admin_ga', $this->session->userdata('inisial'));
        $this->db->set('status', '4');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'barudl');
        redirect('perjalanandl/admindl');
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
                redirect('perjalanandl/prosesdl1/' . $rsv_id);
            } else {
                $this->db->set('nopol', $this->input->post('nopol'));
                $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
                $this->db->where('id', $rsv_id);
                $this->db->update('reservasi');
                redirect('perjalanandl/prosesdl1/' . $rsv_id);
            }
        } else {
            $this->db->set('nopol', $this->input->post('nopol'));
            $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
            $this->db->where('id', $rsv_id);
            $this->db->update('reservasi');
            redirect('perjalanandl/prosesdl1/' . $rsv_id);
        }
    }

    public function bataldl()
    {
        $this->db->set('status', '0');
        $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('perjalanandl/admindl');
    }
}
