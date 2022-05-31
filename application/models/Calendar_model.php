<?php defined('BASEPATH') or exit('No direct script access allowed');

class Calendar_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function GET_EVENTS()
    {
        return $this->db->get("calendar_event");
    }

    public function GET_EVENTS_BY_YEAR($year)
    {
        $this->db->where('year(starts)',$year);
        return $this->db->get("calendar_event");
    }

    public function GET_NASIONAL()
    {
        $this->db->where('category', 'NASIONAL');
        return $this->db->get("calendar_event");
    }

    public function GET_KEAGAMAAN()
    {
        $this->db->where('category', 'KEAGAMAAN');
        return $this->db->get("calendar_event");
    }

    public function GET_MASSAL()
    {
        $this->db->where('category', 'MASSAL');
        return $this->db->get("calendar_event");
    }

}
