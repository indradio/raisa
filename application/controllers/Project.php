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
            $row[] = $project->status;
            $row[] = $project->deskripsi;
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

    public function ubahMilestone()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('id');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        $this->db->set('milestone', $this->input->post('milestone'));
        $this->db->set('tglmulai_wbs', $this->input->post('tglmulai'));
        $this->db->set('tglselesai_wbs', $this->input->post('tglselesai'));
        $this->db->where($array);
        $this->db->update('wbs');

        redirect('project/wbs/'.$copro);

    }

    public function tmbahAkt()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('milestone');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        //query Mailstone
        $queryMailstone = "SELECT *
        FROM `wbs`
        WHERE (`copro` = {$copro}) AND (`id` = {$id} AND `level`= '1') ";
        $mailstone = $this->db->query($queryMailstone)->row_array();
        $totalMailstone = $mailstone['jumlah_aktivitas'] + 1;

        //query Aktivitas Mailstone
        $queryTGL = "SELECT * 
        FROM `wbs` 
        WHERE (`copro` = {$copro}) AND (`id` = {$id} AND `level`= '1')";
        $tgl = $this->db->query($queryTGL)->row_array();

        if(date("Y-m-d", strtotime($this->input->post('tglmulai'))) < date("Y-m-d", strtotime($tgl['tglmulai_wbs'])) OR date("Y-m-d", strtotime($this->input->post('tglmulai'))) > date("Y-m-d", strtotime($tgl['tglselesai_wbs'])) OR date("Y-m-d", strtotime($this->input->post('tglselesai'))) > date("Y-m-d", strtotime($tgl['tglselesai_wbs'])) OR date("Y-m-d", strtotime($this->input->post('tglselesai'))) < date("Y-m-d", strtotime($tgl['tglmulai_wbs'])) ){

            $this->session->set_flashdata('message', 'update');
            redirect('project/wbs/' .$this->input->post('copro'));
        }else
        {
            $data = [
            'id' => $id .'.' .$totalMailstone,
            'copro' => $this->input->post('copro'),
            // 'jumlah_aktivitas' => $this->input->post('milestone'),
            'aktivitas' => $this->input->post('aktivitas'),
            'tglmulai' => $this->input->post('tglmulai'),
            'tglselesai' => $this->input->post('tglselesai'),
            'durasi' => $this->input->post('durasi'),
            'level' => '2'
            ];
            $this->db->insert('wbs', $data);

            $this->db->set('jumlah_aktivitas',$totalMailstone);
            $this->db->where($array);
            $this->db->update('wbs');
            redirect('project/wbs/' .$this->input->post('copro'));
                
        }   
    }

    public function ubahAkt()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('id');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        $this->db->set('aktivitas', $this->input->post('aktivitas'));
        $this->db->set('tglmulai_wbs', $this->input->post('tglmulai'));
        $this->db->set('tglselesai_wbs', $this->input->post('tglselesai'));
        $this->db->set('durasi', $this->input->post('durasi'));
        $this->db->where($array);
        $this->db->update('wbs');

        redirect('project/wbs/' .$copro);
    }
    // public function hapusMailstone($id)
    // {
    //     $wbs = $this->db->get_where('wbs', ['id' => $id])->row_array();
    //     $copro = $wbs['copro'];
    //     $array = array('copro' => $copro, 'id' => $id);

    //     $this->db->set('wbs');
    //     $this->db->where($array);
    //     $this->db->delete('wbs');
    //     $this->session->set_flashdata('message', 'hapus');
    //     redirect('project/wbs/' .$wbs['copro']);    
    // }

    public function hapus()
    {
        $id = $this->input->post('id');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        $this->db->set('wbs');
        $this->db->where($array);
        $this->db->delete('wbs');
        $this->session->set_flashdata('message', 'hapus');
        redirect('project/wbs/' .$copro);  
    }
}
