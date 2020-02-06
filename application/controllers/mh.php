<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mh extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }
    public function index()
    {
    	$data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Man Hour';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->query("SELECT * from project where status ='OPEN' or status='TECO' ")->result_array();
        $data['customer'] = $this->db->get('customer')->result_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('manhour/manhour', $data);
        $this->load->view('templates/footer');
    }
    public function manhour($copro)
    {  
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Man Hour';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();  
        $data['manhour'] = $this->db->get('project_manhour')->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('manhour/eac', $data);
        $this->load->view('templates/footer');
    	
    }
    public function tmbhmanhour()
    {   
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $data = [
                'copro' => $this->input->post('copro'),
                'part' => $this->input->post('part'),
                'budget' => $this->input->post('budget'),
                'estimasi' => $this->input->post('eac'),
                'tgl_update' => $now
                ];
            $this->db->insert('project_manhour', $data);
           
        // echo $this->db->last_query();
       redirect('projectbudget/budget/'.$data['copro']);
    }
    public function updateeac()
    {
        $copro = $this->input->post('copro');
        $this->db->set('estimasi', $this->input->post('estimasi'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_manhour'); 
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $data = [
                'copro' => $this->input->post('copro'),
                'part' => $this->input->post('part'),
                'eac_update' => $this->session->userdata('inisial'),
                'eac' => $this->input->post('estimasi'),
                'tgl_update' => $now    
                ];
            $this->db->insert('project_manhour_detail', $data);

        redirect("mh/manhour/$copro");
    }
    public function hpsmanhour($copro,$id)
    {
        $this->db->where('id', $id);
        $this->db->delete('project_manhour');
        redirect("projectbudget/budget/$copro");
    }
}
?>