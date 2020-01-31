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

    public function jamkerja()
    {
        date_default_timezone_set('asia/jakarta');
        $tglawal  = date('Y-m-d', strtotime($this->input->post('tglawal')));
        $tglakhir = date('Y-m-d', strtotime($this->input->post('tglakhir')));
        if ($tglawal != null AND $tglakhir != null)
        {
            $this->db->where('tgl_aktivitas >=',$tglawal);
            $this->db->where('tgl_aktivitas <=',$tglakhir);
            $this->db->where('jenis_aktivitas','JAM KERJA');
            $this->db->where('status','9');
            $this->db->order_by('npk', 'ASC');
            $data['aktivitas'] = $this->db->get('aktivitas')->result_array();
        }else{
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['id' => 'X'])->result_array();
            $this->session->set_flashdata('pilihtgl', ' <div class="alert alert-info alert-dismissible fade show" role="alert">
            Silahkan PILIH tanggal terlebih dahulu.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        }
        $data['sidemenu'] = 'PPIC';
        $data['sidesubmenu'] = 'Jam Kerja Harian';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pmd/lp_jamkerja', $data);
        $this->load->view('templates/footer');
    }

    public function lembur()
    {
        date_default_timezone_set('asia/jakarta');
        $tglawal  = date('Y-m-d', strtotime($this->input->post('tglawal')));
        $tglakhir = date('Y-m-d', strtotime($this->input->post('tglakhir')));
        if ($tglawal != null AND $tglakhir != null)
        {
            $this->db->where('tgl_aktivitas >=',$tglawal);
            $this->db->where('tgl_aktivitas <=',$tglakhir);
            $this->db->where('jenis_aktivitas','LEMBUR');
            $this->db->where('status','9');
            $this->db->order_by('npk', 'ASC');
            $data['aktivitas'] = $this->db->get('aktivitas')->result_array();
        }else{
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['id' => 'X'])->result_array();
            $this->session->set_flashdata('pilihtgl', ' <div class="alert alert-info alert-dismissible fade show" role="alert">
            Silahkan PILIH tanggal terlebih dahulu.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        }
        $data['sidemenu'] = 'PPIC';
        $data['sidesubmenu'] = 'Jam Kerja Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pmd/lp_lembur', $data);
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
    public function projectbudget()
    {
        $data['sidemenu'] = 'PMD';
        $data['sidesubmenu'] = 'Project  Budget';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->db->get('project_budget')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pmd/project_budget', $data);
        $this->load->view('templates/footer');
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
            
        redirect('pmd/projectbudget/');
    }
    public function ubahProjectbudget()
    {
        $this->db->set('est_cost', $this->input->post('cost'));
        $this->db->set('est_total', $this->input->post('total'));
        $this->db->set('est_exprod', $this->input->post('exprod'));
        $this->db->set('est_persen', $this->input->post('persen'));
        $this->db->set('est_selisih', $this->input->post('selisih'));
        $this->db->set('est_selisihpersen', $this->input->post('selisihpersen'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('project_budget');

        redirect('pmd/projectbudget/');
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
