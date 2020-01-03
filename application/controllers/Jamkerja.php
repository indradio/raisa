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
        if ($this->session->userdata('contract') == 'Direct Labor')
        {
            $data['sidemenu'] = 'Jam Kerja';
            $data['sidesubmenu'] = 'Laporan Kerja Harian';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['jamkerja'] = $this->jamkerja_model->get_WH_TODAY();
            $data['aktivitas'] = $this->jamkerja_model->get_ACT_TODAY();
            $data['kategori'] = $this->jamkerja_model->fetch_kategori();
            $data['project'] = $this->jamkerja_model->fetch_project();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/index', $data);
            $this->load->view('templates/footer');
        }else{
            redirect('dashboard');
        }
    }

    public function add_jamkerja()
    {
        date_default_timezone_set('asia/jakarta');
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

        $tglmulai = date('Y-m-d 07:30:00');
        $tglselesai = date('Y-m-d 16:30:00');
        
        $this->db->where('year(tglmulai)', date('Y'));
        $this->db->where('month(tglmulai)', date('m'));
        $hitung_jamkerja = $this->db->get('jamkerja');
        $total_jamkerja = $hitung_jamkerja->num_rows()+1;
        $id = 'WH'.date('ym'). sprintf("%04s", $total_jamkerja);

            $create = time();
            $due = strtotime(date('Y-m-d 16:30:00'));
            $respon = $due - $create;

        $data = [
            'id' => $id,
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'tglmulai' => $tglmulai,
            'tglselesai' => $tglselesai,
            'durasi' => '00:00:00',
            'atasan1' => $atasan1['inisial'],
            'atasan2' => $atasan2['inisial'],
            'posisi_id' => $this->session->userdata('posisi_id'),
            'div_id' => $this->session->userdata('div_id'),
            'dept_id' => $this->session->userdata('dept_id'),
            'sect_id' => $this->session->userdata('sect_id'),
            'create' => date('Y-m-d H:i:s'),
            'respon_create' => $respon,
            'status' => '0'
        ];
        $this->db->insert('jamkerja', $data);
        redirect('jamkerja');
    }

    public function tanggal()
    {
        date_default_timezone_set('asia/jakarta');
        redirect('jamkerja/backdate/'.$this->input->post('tanggal'));
    }

    public function backdate($tanggal)
    {
            date_default_timezone_set('asia/jakarta');
            $tahun = date("Y", strtotime($tanggal));
            $bulan = date("m", strtotime($tanggal));
            $hari =  date("d", strtotime($tanggal));
            $strdate = strtotime($tanggal);
            $strnow =  time();
            $strlastyear = strtotime(date('2019-12-31'));

            $this->db->where('year(tglmulai)',$tahun);
            $this->db->where('month(tglmulai)',$bulan);
            $this->db->where('day(tglmulai)',$hari);
            $this->db->where('npk',$this->session->userdata('npk'));
            $jamkerja = $this->db->get('jamkerja')->row_array();
            if ($jamkerja['id']){
         
                $data['sidemenu'] = 'Jam Kerja';
                $data['sidesubmenu'] = 'Laporan Kerja Harian';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulan);
                $this->db->where('day(tglmulai)',$hari);
                $this->db->where('npk',$this->session->userdata('npk'));
                $data['jamkerja'] = $this->db->get('jamkerja')->row_array();
                $data['kategori'] = $this->jamkerja_model->fetch_kategori();
                $data['project'] = $this->jamkerja_model->fetch_project();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('jamkerja/jamkerja_backdate', $data);
                $this->load->view('templates/footer');
         
            }else{
                if ($strdate>=$strnow){
                    redirect('jamkerja');
                }elseif ($strdate<=$strlastyear){
                    redirect('jamkerja');
                }else{
         
                    $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
                    $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

                    $tglmulai = date('Y-m-d 07:30:00', strtotime($tanggal));
                    $tglselesai = date('Y-m-d 16:30:00', strtotime($tanggal));
                    
                    $this->db->where('year(tglmulai)', $tahun);
                    $this->db->where('month(tglmulai)', $bulan);
                    $hitung_jamkerja = $this->db->get('jamkerja');
                    $total_jamkerja = $hitung_jamkerja->num_rows()+1;
                    $id = 'WH'.date('ym', strtotime($tanggal)). sprintf("%04s", $total_jamkerja);

                    $create = time();
                    $due = strtotime(date('Y-m-d 16:30:00', strtotime($tanggal)));
                    $respon = $due - $create;

                    $data = [
                        'id' => $id,
                        'npk' => $this->session->userdata('npk'),
                        'nama' => $this->session->userdata('nama'),
                        'tglmulai' => $tglmulai,
                        'tglselesai' => $tglselesai,
                        'durasi' => '00:00:00',
                        'atasan1' => $atasan1['inisial'],
                        'atasan2' => $atasan2['inisial'],
                        'posisi_id' => $this->session->userdata('posisi_id'),
                        'div_id' => $this->session->userdata('div_id'),
                        'dept_id' => $this->session->userdata('dept_id'),
                        'sect_id' => $this->session->userdata('sect_id'),
                        'create' => date('Y-m-d H:i:s'),
                        'respon_create' => $respon,
                        'status' => '0'
                    ];
                    $this->db->insert('jamkerja', $data);
                    redirect('jamkerja/backdate/'.$tanggal);
                }
            }
    }

    public function ajax()
    {
        $kategori_id = $_POST['kategori'];
        $dept_id = $this->session->userdata('dept_id');
        $getAktivitas = $this->db->query("SELECT * FROM jamkerja_lain WHERE kategori_id = '$kategori_id' AND dept_id = '$dept_id' ")->result_array();
  
        foreach ($getAktivitas as $a) {
            echo '<option value="'.$a['aktivitas'].'">'.$a['aktivitas'].'</option>';   
        }
    }

    function fetch_project()
    {
        echo $this->jamkerja_model->fetch_project();
    }

    public function add_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
        $aktivitas = $this->input->post('aktivitas');
        $durasi = $this->input->post('durasi');
        $hasil = $this->input->post('progres_hasil');
        $kategori = $this->input->post('kategori');
        $copro = $this->input->post('copro');
        $deskripsi = $this->input->post('deskripsi');
        
        if ($copro) {
            $id = $copro . $this->session->userdata('npk') . time();
        }else{
            $id = date("ymd", strtotime($jamkerja['tglmulai'])) . $this->session->userdata('npk') . time();
        }

        if (!$deskripsi){
            $deskripsi = $aktivitas;
        }

        $data = [
            'id' => $id,
            'npk' => $this->session->userdata('npk'),
            'link_aktivitas' => $jamkerja['id'],
            'jenis_aktivitas' => 'JAM KERJA',
            'tgl_aktivitas' => date("Y-m-d", strtotime($jamkerja['tglmulai'])),
            'tglmulai' => $jamkerja['tglmulai'],
            'tglselesai' => $jamkerja['tglselesai'],
            'kategori' => $kategori,
            'copro' => $copro,
            'aktivitas' => $aktivitas,
            'deskripsi_hasil' => $deskripsi,
            'durasi' => $durasi,
            'progres_hasil' => $hasil,
            'dibuat_oleh' => $this->session->userdata('inisial'),
            'dept_id' => $this->session->userdata('dept_id'),
            'sect_id' => $this->session->userdata('sect_id'),
            'contract' => $this->session->userdata('contract'),
            'status' => '9'
        ];
        $this->db->insert('aktivitas', $data);

        // Update DURASI JAMKERJA
        $this->db->select('SUM(durasi) as total');
        $this->db->where('link_aktivitas', $jamkerja['id']);
        $this->db->from('aktivitas');
        $totaldurasi = $this->db->get()->row()->total;

        $this->db->set('durasi', $totaldurasi);
        $this->db->set('status', 1);
        $this->db->where('id', $jamkerja['id']);
        $this->db->update('jamkerja');
       
        if ( date('Y-m-d') == date("Y-m-d", strtotime($jamkerja['tglmulai'])))
        {
            redirect('jamkerja');
        }else{
            redirect('jamkerja/backdate/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
        }
    }

    public function batal_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('id');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $aktivitas['link_aktivitas']])->row_array();

        $this->db->set('aktivitas');
        $this->db->where('id', $id);
        $this->db->delete('aktivitas');

        // Update DURASI JAMKERJA
        $this->db->select('SUM(durasi) as total');
        $this->db->where('link_aktivitas', $jamkerja['id']);
        $this->db->from('aktivitas');
        $totaldurasi = $this->db->get()->row()->total;

        if ($totaldurasi > 0)
        {
            $this->db->set('durasi', $totaldurasi);
            $this->db->set('status', 1);
            $this->db->where('id', $jamkerja['id']);
            $this->db->update('jamkerja');
        }else{
            $this->db->set('durasi', $totaldurasi);
            $this->db->set('status', 0);
            $this->db->where('id', $jamkerja['id']);
            $this->db->update('jamkerja');
        }

        if ( date('Y-m-d') == date("Y-m-d", strtotime($jamkerja['tglmulai'])))
        {
            redirect('jamkerja');
        }else{
            redirect('jamkerja/backdate/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
        }
    }

    public function persetujuan()
    {
            $data['sidemenu'] = 'Koordinator';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['jamkerja'] = $this->db->where('sect_id', $this->session->userdata('sect_id'));
            $data['jamkerja'] = $this->db->where('status', 1);
            $data['jamkerja'] = $this->db->get('jamkerja')->result_array();
            $data['project'] = $this->jamkerja_model->fetch_project();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan', $data);
            $this->load->view('templates/footer');
    }

    public function persetujuan_detail($link_aktivitas)
    {
            $data['sidemenu'] = 'Koordinator';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['jamkerja'] = $this->db->get_where('jamkerja', ['id' => $link_aktivitas])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $link_aktivitas])->result_array();
            $data['project'] = $this->jamkerja_model->fetch_project();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_detail', $data);
            $this->load->view('templates/footer');
    }

    public function persetujuan_approve($id)
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('atasan1', 'Disetujui oleh '. $this->session->userdata('inisial'));
        $this->db->set('tgl_atasan1', date("Y-m-d H:i:s"));
        $this->db->set('status', 9);
        $this->db->where('id', $id);
        $this->db->update('jamkerja');

        redirect('jamkerja/persetujuan');
    }

    public function persetujuan_revisi($id)
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('catatan', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
        $this->db->set('status', 0);
        $this->db->where('id', $id);
        $this->db->update('jamkerja');

        redirect('jamkerja/persetujuan');
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
                "start" => $r->tglmulai,
                "end" => $r->tglselesai
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
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
        $tglawal  = date('Y-m-d', strtotime($this->input->post('tglawal')));
        $tglakhir = date('Y-m-d', strtotime($this->input->post('tglakhir')));
        if ($tglawal != null AND $tglakhir != null)
        {
            $this->db->where('tgl_aktivitas >=',$tglawal);
            $this->db->where('tgl_aktivitas <=',$tglakhir);
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
