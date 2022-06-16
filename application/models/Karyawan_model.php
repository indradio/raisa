<?php defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{
    var $table = 'karyawan';
    var $column_order = array(null,'npk','inisial','nama','email','phone','posisi_id','div_id','dept_id','sect_id','status','is_active'); //set column field database for datatable orderable
    var $column_search = array('npk','inisial','nama','email','phone'); //set column field database for datatable searchable 
    var $order = array('npk' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getById()
    {
        return $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    }

    public function getAll()
    {
        return $this->db->get('karyawan')->result();
    }

    public function getActive()
    {
            $this->db->where('npk !=', '1111');
            $this->db->where('is_active', '1');
        return $this->db->get('karyawan')->result();
    }

    public function getOrganic()
    {
            $this->db->where('status', '1');
            $this->db->where('is_active', '1');
        return $this->db->get('karyawan')->result();
    }
}
