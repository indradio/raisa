<?php defined('BASEPATH') or exit('No direct script access allowed');

class Jamkerja_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_events()
    {
        return $this->db->get_where('lembur',['status >' => 0]);
    }

    public function GET_MY_jamkerja()
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('status >', 0);
        return $this->db->get("jamkerja");
    }

    public function GET_MY_lembur()
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('status >', 0);
        return $this->db->get("lembur");
    }

    public function GET_WH_TODAY()
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('year(tglmulai)',date('Y'));
        $this->db->where('month(tglmulai)',date('m'));
        $this->db->where('day(tglmulai)',date('d'));
        $query = $this->db->get("jamkerja");
        return $query->row_array();
    }

    public function get_ACT_TODAY()
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('tgl_aktivitas', date("Y-m-d"));
        $query = $this->db->get("aktivitas");
        return $query->result_array();
    }

    function fetch_kategori()
    {
        $query = $this->db->get("jamkerja_kategori");
        return $query->result();
    }

    function fetch_project()
    {
        $this->db->order_by("copro", "ASC");
        $query = $this->db->get("project");
        return $query->result();
    }

    function get_wbs_bycopro($copro)
    {

        $this->db->where('tglmulai_wbs <=', date("Y-m-d"));
        $this->db->where('tglselesai_wbs >=', date("Y-m-d"));
        $this->db->where('level', 2);
        $this->db->where('copro', $copro);
        $query = $this->db->get("wbs");
        return $query->result_array();
    }

    function get_jamkerja_lainpro()
    {

        $this->db->where('kategori_id', '2');
        $query = $this->db->get("jamkerja_lain");
        return $query->result_array();
    }

    function get_jamkerja_lain()
    {

        $this->db->where('kategori_id', '3');
        $query = $this->db->get("jamkerja_lain");
        return $query->result_array();
    }
    
    public function get_manhours()
    {
        $this->db->where('contract', 'Direct Labor');
        $this->db->where('status', 9);
        $query = $this->db->get("aktivitas");
        return $query->result_array();
    }

    public function get_mh_ot()
    {
        $this->db->where('jenis_aktivitas', 'LEMBUR');
        $this->db->where('contract', 'Direct Labor');
        $this->db->where('status', 9);
        return $this->db->get("aktivitas");
    }

}
