<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('project_model', 'project');
    }

    public function index()
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('project/index', $data);
        $this->load->view('templates/footer');
    }

    public function ajax_list()
    {
        $list = $this->project->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $project) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $project->copro;
            $row[] = $project->no_material;
            $row[] = $project->deskripsi;
            $row[] = $project->status;
            $row[] = null;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->project->count_all(),
            "recordsFiltered" => $this->project->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function wbs($copro)
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'WBS';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        // $data['wbs'] = $this->db->where('level', '2');
        $data['wbs'] = $this->db->get_where('wbs', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('project/wbs', $data);
        $this->load->view('templates/footer');
    }

    public function tmbahMilestone()
    {
        date_default_timezone_set('asia/jakarta');
        $copro = $this->input->post('copro');      
        $queryCopro = "SELECT COUNT(*)
        FROM `wbs`
        WHERE `copro` = {$copro} AND `level`= '1' ";
        $coproId = $this->db->query($queryCopro)->row_array();
        $totalCopro = $coproId['COUNT(*)'] + 1;

        $data = [
            'id' => $totalCopro,
            'copro' => $this->input->post('copro'),
            'milestone' => $this->input->post('milestone'),
            'tglmulai_wbs' => $this->input->post('tglmulai'),
            'tglselesai_wbs' => $this->input->post('tglselesai'),
            'level' => '1'
            ];
        $this->db->insert('wbs', $data);

     redirect('project/wbs/' . $data['copro']);
            
    }

    public function tmbahAkt()
    {
        date_default_timezone_set('asia/jakarta');
        // $wbs['wbs'] = $this->db->get_where('wbs', ['id' => $this->input->post('milestone')])->row_array();
        // $tgl = $wbs['tglmulai_wbs'];
        $id = $this->input->post('milestone');
        $copro = $this->input->post('copro'); 
        $queryMailstone = "SELECT COUNT(*)
        FROM `wbs`
        WHERE (`copro` = {$copro}) AND (`id_milestone` = {$id} AND `level`= '2') ";
        $mailstone = $this->db->query($queryMailstone)->row_array();
        $totalMailstone = $mailstone['COUNT(*)'] + 1;

        $queryTGL = "SELECT * FROM `wbs` WHERE (`copro` = {$copro}) AND (`id` = {$id} AND `level`= '1')";
        $tgl = $this->db->query($queryTGL)->row_array();

        if(date("Y-m-d", strtotime($this->input->post('tglmulai'))) < date("Y-m-d", strtotime($tgl['tglmulai_wbs'])) OR date("Y-m-d", strtotime($this->input->post('tglselesai'))) > date("Y-m-d", strtotime($tgl['tglselesai_wbs'])) ){

            $this->session->set_flashdata('message', 'update');
            redirect('project/wbs/' .$this->input->post('copro'));
        }else
        {
            $data = [
            'id' => $id .'.' .$totalMailstone,
            'copro' => $this->input->post('copro'),
            'id_milestone' => $this->input->post('milestone'),
            'aktivitas' => $this->input->post('aktivitas'),
            'tglmulai' => $this->input->post('tglmulai'),
            'tglselesai' => $this->input->post('tglselesai'),
            'durasi' => $this->input->post('durasi'),
            'level' => '2'
            ];
            $this->db->insert('wbs', $data);

            redirect('project/wbs/' .$this->input->post('copro'));
                
        }   
    }

    public function hapus_aktivitas($id)
    {
        $Project = $this->db->get_where('project_aktivitas', ['id' => $id])->row_array();
        $this->db->set('aktivitas');
        $this->db->where('id',$id);
        $this->db->delete('project_aktivitas');
        $this->session->set_flashdata('message', 'hapus');
        redirect('project/wbs/' . $Project['copro']);
    }
}
