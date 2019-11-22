<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class App extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }
 
    function simpan($data = array())
    {
        $jumlah = count($data);
 
        if ($jumlah > 0)
        {
            $this->db->insert_batch('kendaraan_gps', $data);
        }
    }
}