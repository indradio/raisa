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
        $this->db->where('state', 'In');

        // Hitung tanggal 2 bulan ke belakang
        $two_months_ago = date('Y-m-d', strtotime('-2 months'));
        $this->db->where('date >=', $two_months_ago);

        $this->db->order_by('date', 'DESC'); // opsional: urutkan terbaru dulu
        $this->db->limit(93); // opsional: batasi data jika perlu

        return $this->db->get("presensi");
    }
    public function GET_MY_OUT($date)
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('date', $date);
        $this->db->where('state', 'Out');
        return $this->db->get("presensi");
    }
}