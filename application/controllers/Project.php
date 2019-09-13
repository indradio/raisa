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
        // $data['project'] = $this->db->get_where('project')->result_array();

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

    public function wbs()
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'WBS';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['wbs'] = $this->db->where('level', '2');
        $data['wbs'] = $this->db->get_where('wbs', ['copro' => $this->input->post('copro')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('project/wbs', $data);
        $this->load->view('templates/footer');
    }
}
