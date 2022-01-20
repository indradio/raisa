<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->view('dashboard/info');
    }

    public function kab()
    {
        $prov_id = $_POST['prov'];
        $getKab = $this->db->query("SELECT * FROM wilayah_kabupaten WHERE provinsi_id = '$prov_id'")->result();

        foreach ($getKab as $row) {
            echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
        }
    }

    public function kec()
    {
        $kab_id = $_POST['kab'];
        $getKec = $this->db->query("SELECT * FROM wilayah_kecamatan WHERE kabupaten_id = '$kab_id'")->result();

        foreach ($getKec as $row) {
            echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
        }
    }

    public function desa()
    {
        $kec_id = $_POST['kec'];
        $getDesa = $this->db->query("SELECT * FROM wilayah_desa WHERE kecamatan_id = '$kec_id'")->result();

        foreach ($getDesa as $row) {
            echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
        }
    }

}