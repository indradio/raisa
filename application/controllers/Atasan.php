<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Atasan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $karyawan = $this->db->get_where('karyawan')->result_array();
        foreach ($karyawan as $k) :

            $atasan1 = $k['posisi_id'] - 1;
            $atasan2 = $k['posisi_id'] - 2;

            $this->db->set('atasan1', $atasan1);
            $this->db->set('atasan2', $atasan2);
            $this->db->where('npk', $k['npk']);
            $this->db->update('karyawan');

        endforeach;
        redirect('dashboard');
    }
}
