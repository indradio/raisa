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
        return $this->db->get("jamkerja");
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

    // function fetch_milestone($copro)
    // {
    //     $this->db->where('copro', $copro);
    //     $this->db->where('level', '1');
    //     $this->db->order_by('id', 'ASC');
    //     $query = $this->db->get('wbs');
    //     return $query->result();

    // $output = '<option value="">Pilih Milestone</option>';
    // foreach ($milestone as $row) {
    //     $output = '<option value="' . $row['milestone'] . '">' . $row['milestone'] . '</option>';
    // }
    // return $output;
    // }

    // function fetch_aktivitas($milestone)
    // {
    //     $this->db->where("milestone", $milestone);
    //     $this->db->where("level", "1");
    //     $this->db->order_by("id", "ASC");
    //     $query = $this->db->get("wbs");
    //     return $query->result_array();
    // }
}
