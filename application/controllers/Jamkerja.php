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

    function fetch_project()
    {
        echo $this->jamkerja_model->fetch_project();
    }

    public function get_events()
    {
        // Our Start and End Dates
        $events = $this->jamkerja_model->get_events();
        $data_events = array();

        foreach ($events->result() as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "title" => $r->id,
                "start" => $r->tanggal_mulai,
                "end" => $r->tanggal_selesai
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
    }

    public function aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->input->post('aktivitas');
        $durasi = $this->input->post('durasi');
        $durasi = $this->input->post('durasi');
        $hasil = $this->input->post('progres_hasil');
        $kategori = $this->input->post('kategori');
        if ($kategori != 3) {
            $copro = $this->input->post('copro');
        }

        $data = [
            'id' => time(),
            'npk' => $this->session->userdata('npk'),
            'link_aktivitas' => 'JK' . date('ymd'),
            'jenis_aktivitas' => 'JAMKERJA',
            'tgl_aktivitas' => date('Y-m-d'),
            'kategori' => $kategori,
            'copro' => $copro,
            'aktivitas' => $aktivitas,
            'durasi' => $durasi,
            'progres_hasil' => $hasil,
            'status' => '9'
        ];
        $this->db->insert('aktivitas', $data);
        redirect('jamkerja');
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

    public function add_jamkerja()
    {
        date_default_timezone_set('asia/jakarta');
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

        if (date('D') != 'Fri') {
            $tgl_mulai = date('Y-m-d 07:30:00');
            $tgl_selesai = date('Y-m-d 16:30:00');
        } else {
            $tgl_mulai = date('Y-m-d 07:00:00');
            $tgl_selesai = date('Y-m-d 16:00:00');
        }
        $data = [
            'id' => 'JK' . date('ymd'),
            'npk' => $this->session->userdata('npk'),
            'tanggal_mulai' => $tgl_mulai,
            'tanggal_selesai' => $tgl_selesai,
            'durasi' => '00:00:00',
            'atasan1' => $atasan1['inisial'],
            'atasan2' => $atasan2['inisial'],
            'status' => '0'
        ];
        $this->db->insert('jamkerja', $data);
        redirect('jamkerja');
    }

    public function addAktivitas()
    {
        date_default_timezone_set('asia/jakarta');
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

    public function do_aktivitaslain()
    {
        $data = [
            'id' => time(),
            'npk' => $this->session->userdata('npk'),
            'link_aktivitas' => $this->input->post('milestone'),
            'aktivitas' => $this->input->post('aktivitas'),
            'tglmulai' => date('Y-m-d H:i:s'),
            'tglselesai' => date('Y-m-d H:i:s'),
            'progres_hasil' => $this->input->post('progres_hasil'),
            'deskripsi_hasil' => $this->input->post('deskripsi_hasil'),
            'npk' => $this->session->userdata('npk'),
            'status' => '1'
        ];
        $this->db->insert('aktivitas', $data);
    }

    public function kalender()
    {
        $data['sidemenu'] = 'Jam Kerja';
        $data['sidesubmenu'] = 'Laporan Jam Kerja';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['aktivitas'] = $this->jamkerja_model->get_events();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/kalender', $data);
        $this->load->view('templates/footer');
    }

    public function lp_aktivitas_ppic()
    {
        date_default_timezone_set('asia/jakarta');
        $tglawal = $this->input->post('tglawal');
        $tglakhir = $this->input->post('tglakhir');
        if ($tglawal != null AND $tglakhir != null)
        {
            $this->db->where('day(tgl_aktivitas) >=',$tglawal);
            $this->db->where('day(tgl_aktivitas) <=',$tglakhir);
            $this->db->where('status >','1');
            $this->db->order_by('npk', 'ASC');
            $data['aktivitas'] = $this->db->get('aktivitas')->result_array();
        }else{
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['npk' => 'X'])->result_array();
            $this->session->set_flashdata('pilihtgl', ' <div class="alert alert-info alert-dismissible fade show" role="alert">
            Silahkan PILIH tanggal terlebih dahulu.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        }
        $data['sidemenu'] = 'PPIC';
        $data['sidesubmenu'] = 'Laporan Jam Kerja';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/lp_aktivitas_ppic', $data);
        $this->load->view('templates/footer');
    }
}
