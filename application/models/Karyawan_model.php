<?php defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{
    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }

    public function getById()
    {
        return $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    }
}
