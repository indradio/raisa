<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cuti_model extends CI_Model
{
    var $table = 'cuti';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getAll()
    {
        $query = $this->db->from($this->table);
        return $query->get()->result();
    }

}
