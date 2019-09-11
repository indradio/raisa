<?php defined('BASEPATH') or exit('No direct script access allowed');

class Jamkerja_model extends CI_Model
{
    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }

    public function getByNpk()
    {
        return $this->db->get_where('Jamkerja', ['npk' =>  $this->session->userdata('npk')])->row_array();
    }
}
