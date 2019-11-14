<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pmd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Jam Kerja';
        $data['sidesubmenu'] = 'Laporan Kerja Harian';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['aktivitas'] = $this->jamkerja_model->get_aktivitas();
        $data['project'] = $this->jamkerja_model->fetch_project();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/index', $data);
        $this->load->view('templates/footer');
    }
    public function project()
    {
        $data['sidemenu'] = 'PMD';
        $data['sidesubmenu'] = 'Project';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->get_where('project', ['status' =>  'OPEN'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pmd/project', $data);
        $this->load->view('templates/footer');
    }
    // public function aktivitas($copro)
    // {
    //     $data['sidemenu'] = 'PMD';
    //     $data['sidesubmenu'] = 'Project';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $data['aktivitas'] = $this->db->get_where('project_aktivitas', ['copro' =>  $copro])->result_array();
    //     $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
    //     $data['project_status'] = $this->db->get('project_status')->result_array();
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('pmd/aktivitas', $data);
    //     $this->load->view('templates/footer');
    // }
    public function ubahProject()
    {
        $this->db->set('deskripsi', $this->input->post('deskripsi'));
        $this->db->set('status', $this->input->post('status'));
        $this->db->where('copro', $this->input->post('copro'));
        $this->db->update('project');

        redirect('pmd/project/');
    }
    public function tmbahCopro()
    {
        $data = [
                'copro' => $this->input->post('copro'),
                'deskripsi' => $this->input->post('deskripsi'),
                'status' => $this->input->post('status')
                ];
            $this->db->insert('project', $data);
            
        redirect('pmd/project/');
    }
    public function hapus_project($id)
    {
        $this->db->set('project');
        $this->db->where('copro',$id);
        $this->db->delete('project');
        $this->session->set_flashdata('message', 'hapus');
        redirect('pmd/project/');
    }
}
