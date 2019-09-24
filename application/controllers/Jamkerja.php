<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jamkerja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("jamkerja_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Jam Kerja';
        $data['sidesubmenu'] = 'Jam Kerja';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/index', $data);
        $this->load->view('templates/footer');
    }

    public function get_events()
    {
        // Our Start and End Dates
        $events = $this->jamkerja_model->get_events();
        $data_events = array();

        foreach ($events->result() as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "title" => $r->nama,
                "start" => $r->tanggal_mulai,
                "end" => $r->tanggal_selesai
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
    }

    public function aktivitas()
    {
        $data['sidemenu'] = 'Jam Kerja';
        $data['sidesubmenu'] = 'Aktivitas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['project'] = $this->jamkerja_model->fetch_project();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/aktivitas', $data);
        $this->load->view('templates/footer');
    }

    public function aktivitas_wbs()
    {
        $copro = $this->input->post('copro');
        $data['sidemenu'] = 'Jam Kerja';
        $data['sidesubmenu'] = 'Aktivitas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['wbs'] = $this->jamkerja_model->get_wbs_bycopro($copro);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/aktivitas_wbs', $data);
        $this->load->view('templates/footer');
    }

    public function addAktivitas()
    {
        $this->db->where('tanggal_mulai', date("Y-m-d 07:30:00"));
        $this->db->where('npk', $this->session->userdata('npk'));
        $jamkerja = $this->db->get("jamkerja")->row_array();

        if ($jamkerja['id'] == null) {
            if (date('D') != 'Fri') {
                $tgl_mulai = date('Y-m-d 07:30:00');
                $tgl_selesai = date('Y-m-d 16:30:00');
            } else {
                $tgl_mulai = date('Y-m-d 07:00:00');
                $tgl_selesai = date('Y-m-d 16:00:00');
            }
            $data_jamkerja = [
                'id' => time(),
                'npk' => $this->session->userdata('npk'),
                'tanggal_mulai' => $tgl_mulai,
                'tanggal_selesai' => $tgl_selesai,
                'nama' => date('D'),
                'durasi' => '08:00:00'
            ];
            $this->db->insert('jamkerja', $data_jamkerja);
            redirect('jamkerja');
        } else {
            redirect('jamkerja/aktivitas_wbs');
        }

        // $data = [
        //     'copro' => $this->input->post('copro'),
        //     'wbs' => $this->input->post('id'),
        //     'milestone' => $this->input->post('milestone'),
        //     'aktivitas' => $this->input->post('aktivitas'),
        //     'tglmulai' => date('Y-m-d H:i:s'),
        //     'tglselesai' => date('Y-m-d H:i:s'),
        //     'progres_hasil' => $this->input->post('progres_hasil'),
        //     'deskripsi_hasil' => $this->input->post('deskripsi_hasil'),
        //     'npk' => $this->session->userdata('npk'),
        //     'status' => '1'
        // ];
        // $this->db->insert('aktivitas', $data);
    }
}
