<?php defined('BASEPATH') or exit('No direct script access allowed');

class Presensi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function GET_MY_IN()
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('state', 'C/In');
        $this->db->limit(93);
        return $this->db->get("presensi");
    }
    public function GET_MY_OUT($date)
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('date', $date);
        $this->db->where('state', 'C/Out');
        return $this->db->get("presensi");
    }
}