<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_claim()
    {
        return $this->db->get('medical_claim')->result();
    }

    public function delete_claim($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->delete('medical_claim');
    }

    public function empty_claim()
    {
        $query = $this->db->empty_table('medical_claim');
    }

    public function get_karyawan()
    {
        return $this->db->get_where('karyawan',['status'=>1])->result();
    }
}