<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Projectbudget extends CI_Controller
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
        $data['sidesubmenu'] = 'Project Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->get_where('project', ['status' =>  'OPEN'])->result_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        if($karyawan['sect_id'] == 110)
        {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/projecteng', $data);
        $this->load->view('templates/footer');
        }elseif ($karyawan['sect_id'] == 222) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/projectaktual', $data);
        $this->load->view('templates/footer');
        }elseif ($karyawan['sect_id'] == 223) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/project', $data);
        $this->load->view('templates/footer');
        }else{
         $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf Menu Ini Tidak Dapat Anda Akses!</strong>
              
              </div>');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('Dashboard/index', $data);
        $this->load->view('templates/footer');
        }
        
    }
    public function budget($copro)
    {	
    	$data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
    	$data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_budget', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_budget.part from project_budget where part_project.nama = project_budget.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budget', $data);
        $this->load->view('templates/footer');
    }
    public function budgeteng($copro)
    {   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_budget', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_budget.part from project_budget where part_project.nama = project_budget.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgeteng', $data);
        $this->load->view('templates/footer');
    }public function budgetpch($copro)
    {   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_budget', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_budget.part from project_budget where part_project.nama = project_budget.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgetaktual', $data);
        $this->load->view('templates/footer');
    }
    public function estimasicost()
    {
        $this->db->set('est_cost', $this->input->post('cost'));
        $this->db->set('est_total', $this->input->post('total'));
        $this->db->set('est_exprod', $this->input->post('exprod'));
        $this->db->set('est_persen', $this->input->post('persen'));
        $this->db->set('est_selisih', $this->input->post('selisih'));
        $this->db->set('est_selisihpersen', $this->input->post('selisihpersen'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_budget');

        redirect('projectbudget/budgeteng/'.$this->input->post('copro'));
    }
    public function aktualcost()
    {
        $this->db->set('act_cost', $this->input->post('cost'));
        $this->db->set('act_total', $this->input->post('total'));
        $this->db->set('act_exprod', $this->input->post('exprod'));
        $this->db->set('act_persen', $this->input->post('persen'));
        $this->db->set('act_selisih', $this->input->post('selisih'));
        $this->db->set('act_selisihpersen', $this->input->post('selisihpersen'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_budget');

        redirect('projectbudget/budgetaktual/'.$this->input->post('copro'));
    }
    public function tmbhbudget()
    {	   
    	$data = [
                'copro' => $this->input->post('copro'),
                'part' => $this->input->post('part'),
                'budget' => $this->input->post('budget'),
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_persen' => '0',
                'est_selisih'=> '0',
                'est_selisihpersen'=>'0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_persen' => '0',
                'act_selisih'=> '0',
                'act_selisihpersen'=> '0'
                ];
            $this->db->insert('project_budget', $data);
           

        redirect('projectbudget/budget/'.$data['copro']);
    }
    public function hapus_project($id)
    {
        # code...
    }
}