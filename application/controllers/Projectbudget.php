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
        $data['sidesubmenu'] = 'Budget Material';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->query("SELECT * from project where status ='OPEN' or status='TECO' ")->result_array();
        $data['customer'] = $this->db->get('customer')->result_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        if ($karyawan['sect_id'] == 222) {
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
        }elseif($karyawan['posisi_id'] < 7 AND $karyawan['dept_id'] == 11 OR $karyawan['sect_id'] == 140) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('projectbudget/projecteng', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('projectbudget/projecteng', $data);
            $this->load->view('templates/footer');
        }
        
    }
    public function excel()
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Material';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->get('project_material_detail')->result_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
       
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('import/index', $data);
        $this->load->view('templates/footer');    
    }
    public function budget($copro)
    {	
    	$data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Material';
    	$data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_material', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_material.part from project_material where part_project.nama = project_material.part AND copro ='$copro')")->result_array();
        $data['part_project'] = $this->db->get('part_project')->result_array();
        $data['manhour'] = $this->db->get('project_manhour')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budget', $data);
        $this->load->view('templates/footer');
    }
    public function budgeteng($copro)
    {   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Material';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_material', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
       
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgeteng', $data);
        $this->load->view('templates/footer');
    }
    public function budgetpch($copro){   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Material';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->get_where('project_material', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_material.part from project_material where part_project.nama = project_material.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgetaktual', $data);
        $this->load->view('templates/footer');
    }
    public function budgetpchdetail($copro,$part){   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Material';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->query("SELECT * from project_material_detail where copro = '$copro' and part ='$part'")->result_array(); 
        $data['budget'] = $this->db->query("SELECT * from project_material where copro = '$copro' and part ='$part'")->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_material.part from project_material where part_project.nama = project_material.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgetaktualdetail', $data);
        $this->load->view('templates/footer');
    }
    public function budgetdetail($copro,$part){   
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Material';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->query("SELECT * from project_material_detail where copro = '$copro' and part ='$part'")->result_array(); 
        $data['budget'] = $this->db->query("SELECT * from project_material where copro = '$copro' and part ='$part'")->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/detail', $data);
        $this->load->view('templates/footer');
    }
    public function budgetengdetail($copro,$part)
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Budget Material';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['Projectbudget'] = $this->db->query("SELECT * from project_material_detail where copro = '$copro' and part ='$part'")->result_array();
        $data['budget'] = $this->db->query("SELECT * from project_material where copro = '$copro' and part ='$part'")->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' => $copro])->row_array();
        $data['query'] = $this->db->query("SELECT part_project.nama from part_project where not exists (SELECT project_material.part from project_material where part_project.nama = project_material.part AND copro ='$copro')")->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('projectbudget/budgetengdetail', $data);
        $this->load->view('templates/footer');
    }
    public function estimasicost(){
        $copro = $this->input->post('copro');
        $part = $this->input->post('part');
        $kategori = $this->input->post('kategori');
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $data = [
            'copro' => $this->input->post('copro'),
            'part' => $this->input->post('part'),
            'kategori'=> $this->input->post('kategori'),
            'biaya_est' => $this->input->post('biaya'),
            'no' => $this->input->post('no'),
            'biaya_act' => 0,
            'tgl_buat' => $now,
            'tgl_estimasi' => $now,
            'status' => 1,
            'pembuat_est' => $this->session->userdata('inisial'),
            'keterangan' => $this->input->post('keterangan')];
        $this->db->insert('project_material_detail', $data);
        // echo $this->db->last_query();
        $pp = $this->db->query("SELECT sum(biaya_est) from project_material_detail where part = '$part' and kategori = 'pp' and copro =".$copro)->result_array();
        $exprod = $this->db->query("SELECT sum(biaya_est) from project_material_detail where part = '$part' and kategori = 'exprod' and copro =".$copro)->result_array();
        $total = $pp[0]['sum(biaya_est)'] + $exprod[0]['sum(biaya_est)'] ;
        $selisih = $this->input->post('budget') - $total;
        $persen = $total / ($this->input->post('budget')/100);
        $persens = $selisih / ($this->input->post('budget')/100);

        $this->db->set('est_cost', $pp[0]['sum(biaya_est)']);
        $this->db->set('est_exprod', $exprod[0]['sum(biaya_est)']);
        $this->db->set('est_total',  $total);
        $this->db->set('est_selisih',  $selisih);
        $this->db->set('est_persen',  $persen);
        $this->db->set('est_selisihpersen',  $persens);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_material');
            // echo $this->db->last_query();
        

      redirect('projectbudget/budgeteng/'.$this->input->post('copro'));
    }
    public function aktualcost()
    {   
        $copro = $this->input->post('copro');
        $part = $this->input->post('part');
        $kategori = $this->input->post('kategori');
        $budget = $this->db->query("SELECT budget from project_material where copro = '$copro' and part ='$part'")->result_array();
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $this->db->set('biaya_act', $this->input->post('biaya_act'));
        $this->db->set('pr', $this->input->post('no_pr'));
        $this->db->set('tgl_aktual', $now);
        $this->db->set('status', 9);
        $this->db->set('keterangan', $this->input->post('keterangan'));
        $this->db->set('pembuat_act',  $this->session->userdata('inisial'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_material_detail');


        $pp = $this->db->query("SELECT sum(biaya_act) from project_material_detail where part = '$part' and kategori = 'pp' and copro =".$copro)->result_array();
        $exprod = $this->db->query("SELECT sum(biaya_act) from project_material_detail where part = '$part' and kategori = 'exprod' and copro =".$copro)->result_array();
        $total = $pp[0]['sum(biaya_act)'] + $exprod[0]['sum(biaya_act)'] ;
        $selisih = $budget[0]['budget'] - $total;
        $persen = $total / ($budget[0]['budget']/100);
        $persens = $selisih / ($budget[0]['budget']/100);
            
        $this->db->set('act_cost', $pp[0]['sum(biaya_act)']);
        $this->db->set('act_exprod', $exprod[0]['sum(biaya_act)']);
        $this->db->set('act_total',  $total);
        $this->db->set('act_selisih',  $selisih);
        $this->db->set('act_persen',  $persen);
        $this->db->set('act_selisihpersen',  $persens);
        $this->db->where('copro', $this->input->post('copro'));
        $this->db->where('part', $this->input->post('part'));
        $this->db->update('project_material');
        // echo $this->db->last_query();
        redirect("projectbudget/budgetpchdetail/$copro/$part");
    } 
    public function updatedetail()
    {   
        $copro = $this->input->post('copro');
        $part = $this->input->post('part');
        $kategori = $this->input->post('kategori');  
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $budget = $this->db->query("SELECT budget from project_material where copro = '$copro' and part ='$part'")->result_array();
        $this->db->set('biaya_est', $this->input->post('biaya_est'));
        $this->db->set('no', $this->input->post('no'));
        $this->db->set('tgl_estimasi', $now);
        $this->db->set('pembuat_act',  $this->session->userdata('inisial'));
        $this->db->set('keterangan', $this->input->post('keterangan'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_material_detail');

        $pp = $this->db->query("SELECT sum(biaya_est) from project_material_detail where part = '$part' and kategori = 'pp' and copro =".$copro)->result_array();
        $exprod = $this->db->query("SELECT sum(biaya_est) from project_material_detail where part = '$part' and kategori = 'exprod' and copro =".$copro)->result_array();
        $total = $pp[0]['sum(biaya_est)'] + $exprod[0]['sum(biaya_est)'] ;
        $selisih = $budget[0]['budget'] - $total;
        $persen = $total / ($budget[0]['budget']/100);
        $persens = $selisih / ($budget[0]['budget']/100);
            
        $this->db->set('est_cost', $pp[0]['sum(biaya_est)']);
        $this->db->set('est_exprod', $exprod[0]['sum(biaya_est)']);
        $this->db->set('est_total',  $total);
        $this->db->set('est_selisih',  $selisih);
        $this->db->set('est_persen',  $persen);
        $this->db->set('est_selisihpersen',  $persens);
        $this->db->where('copro', $this->input->post('copro'));
        $this->db->where('part', $this->input->post('part'));
        $this->db->update('project_material');
        // echo $this->db->last_query();
        redirect("projectbudget/budgetengdetail/$copro/$part");
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
            $this->db->insert('project_material', $data);
           
        $this->db->select_sum('budget');
        $this->db->where('copro', $this->input->post('copro'));
        $query1 = $this->db->get('project_material');
        $budget = $query1->row()->budget;

        $this->db->set('mt_budget', $budget);
        $this->db->where('copro',$this->input->post('copro'));
        $this->db->update('project');
        // echo $this->db->last_query();
        redirect('projectbudget/budget/'.$data['copro']);
    }
    public function ubahProjectbudget()
    {   
        $copro = $this->input->post('copro');
        $total = $this->input->post('total');
        $budget = $this->input->post('budget');
        $selisih =  $budget - $total;
        $selisih_persen = ($selisih / $budget) * 100;
        $this->db->set('budget', $this->input->post('budget'));
        $this->db->set('est_selisih', $selisih);
        $this->db->set('est_selisihpersen', $selisih_persen);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_material');

        $this->db->select_sum('budget');
        $this->db->where('copro', $copro);
        $query1 = $this->db->get('project_material');
        $budget = $query1->row()->budget;

        $this->db->set('mt_budget', $budget);
        $this->db->where('copro', $copro);
        $this->db->update('project');
        // echo $this->db->last_query();
        redirect("projectbudget/budget/$copro");
    }
    public function hapus_project($copro,$id,$part)
    {
        $query = "delete from project_material where id='$id'";
        $this->db->query($query);
        $query2 = "delete from project_material_detail where copro='$copro' and part ='$part'";
        $this->db->query($query2);
        $this->db->select_sum('budget');
        $this->db->where('copro', $copro);
        $query1 = $this->db->get('project_material');
        $budget = $query1->row()->budget;

        $this->db->set('mt_budget', $budget);
        $this->db->where('copro', $copro);
        $this->db->update('project');
        // echo $this->db->last_query();
        
        redirect("projectbudget/budget/$copro");
    }
    public function hapusdetail($copro,$part,$id)
    {
        $query = "delete from project_material_detail where id='$id'";
        $this->db->query($query);
        $budget = $this->db->query("SELECT budget from project_material where copro = '$copro' and part ='$part'")->result_array();
        $pp = $this->db->query("SELECT sum(biaya_est) from project_material_detail where part = '$part' and kategori = 'pp' and copro =".$copro)->result_array();
        $exprod = $this->db->query("SELECT sum(biaya_est) from project_material_detail where part = '$part' and kategori = 'exprod' and copro =".$copro)->result_array();
        $total = $pp[0]['sum(biaya_est)'] + $exprod[0]['sum(biaya_est)'] ;
        $selisih = $budget[0]['budget'] - $total;
        $persen = $total / ($budget[0]['budget']/100);
        $persens = $selisih / ($budget[0]['budget']/100);
        $ppa = $this->db->query("SELECT sum(biaya_act) from project_material_detail where part = '$part' and kategori = 'pp' and copro =".$copro)->result_array();
        $exproda = $this->db->query("SELECT sum(biaya_act) from project_material_detail where part = '$part' and kategori = 'exprod' and copro =".$copro)->result_array();
        $totala = $ppa[0]['sum(biaya_act)'] + $exproda[0]['sum(biaya_act)'] ;
        $selisiha = $budget[0]['budget'] - $total;
        $persena = $totala / ($budget[0]['budget']/100);
        $persensa = $selisiha / ($budget[0]['budget']/100);
            
        $this->db->set('est_cost', $pp[0]['sum(biaya_est)']);
        $this->db->set('est_exprod', $exprod[0]['sum(biaya_est)']);
        $this->db->set('est_total',  $total);
        $this->db->set('est_selisih',  $selisih);
        $this->db->set('est_persen',  $persen);
        $this->db->set('est_selisihpersen',  $persens);    
        $this->db->set('act_cost', $ppa[0]['sum(biaya_act)']);
        $this->db->set('act_exprod', $exproda[0]['sum(biaya_act)']);
        $this->db->set('act_total',  $totala);
        $this->db->set('act_selisih',  $selisiha);
        $this->db->set('act_persen',  $persena);
        $this->db->set('act_selisihpersen',  $persensa);
        $this->db->where('copro',$copro);
        $this->db->where('part', $part);
        $this->db->update('project_material');
        
        // echo $this->db->last_query();
        redirect("projectbudget/budgetengdetail/$copro/$part");
    }
}