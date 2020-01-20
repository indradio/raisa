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

        $tglmulai = date('Y-m-d 07:30:00');
        $tglselesai = date('Y-m-d 16:30:00');
        
        $this->db->where('year(tglmulai)', date('Y'));
        $this->db->where('month(tglmulai)', date('m'));
        $hitung_jamkerja = $this->db->get('jamkerja');
        $total_jamkerja = $hitung_jamkerja->num_rows()+1;
        $id = 'WH'.date('ym'). sprintf("%04s", $total_jamkerja);

            $create = time();
            $due = strtotime(date('Y-m-d 23:59:00'));
            $respon = $due - $create;

        $data = [
            'id' => $id,
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'tglmulai' => $tglmulai,
            'tglselesai' => $tglselesai,
            'durasi' => '00:00:00',
            'atasan1' => $atasan1['inisial'],
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

    public function pilihtanggal()
    {
        date_default_timezone_set('asia/jakarta');
        redirect('jamkerja/tanggal/'.$this->input->post('tanggal'));
    }

    public function tanggal($tanggal)
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
                $this->load->view('jamkerja/jamkerja_tanggal', $data);
                $this->load->view('templates/footer');
         
            }else{
                if ($strdate>=$strnow){
                    redirect('jamkerja');
                }elseif ($strdate<=$strlastyear){
                    redirect('jamkerja');
                }else{
         
                    $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

                    $tglmulai = date('Y-m-d 07:30:00', strtotime($tanggal));
                    $tglselesai = date('Y-m-d 16:30:00', strtotime($tanggal));
                    
                    $this->db->where('year(tglmulai)', $tahun);
                    $this->db->where('month(tglmulai)', $bulan);
                    $hitung_jamkerja = $this->db->get('jamkerja');
                    $total_jamkerja = $hitung_jamkerja->num_rows()+1;
                    $id = 'WH'.date('ym', strtotime($tanggal)). sprintf("%04s", $total_jamkerja);

                    $create = time();
                    $due = strtotime(date('Y-m-d 23:59:00', strtotime($tanggal)));
                    $respon = $due - $create;

                    $data = [
                        'id' => $id,
                        'npk' => $this->session->userdata('npk'),
                        'nama' => $this->session->userdata('nama'),
                        'tglmulai' => $tglmulai,
                        'tglselesai' => $tglselesai,
                        'durasi' => '00:00:00',
                        'atasan1' => $atasan1['inisial'],
                        'posisi_id' => $this->session->userdata('posisi_id'),
                        'div_id' => $this->session->userdata('div_id'),
                        'dept_id' => $this->session->userdata('dept_id'),
                        'sect_id' => $this->session->userdata('sect_id'),
                        'create' => date('Y-m-d H:i:s'),
                        'respon_create' => $respon,
                        'status' => '0'
                    ];
                    $this->db->insert('jamkerja', $data);
                    redirect('jamkerja/tanggal/'.$tanggal);
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
            'status' => '1'
        ];
        $this->db->insert('aktivitas', $data);

        //Update create date and create respon
        $create = time();
        $due = strtotime(date('Y-m-d 23:59:00', strtotime($jamkerja['tglmulai'])));
        $respon = $due - $create;

        // Update DURASI & STATUS JAMKERJA
        $this->db->select('SUM(durasi) as total');
        $this->db->where('link_aktivitas', $jamkerja['id']);
        $this->db->from('aktivitas');
        $totaldurasi = $this->db->get()->row()->total;

        if ($totaldurasi>=8){
            $this->db->set('status', 1);
        }else{
            $this->db->set('status', 0);
        }

        $this->db->set('create', date('Y-m-d H:i:s'));
        $this->db->set('respon_create', $respon);
        $this->db->set('durasi', $totaldurasi);
        $this->db->where('id', $jamkerja['id']);
        $this->db->update('jamkerja');

        if ($this->session->userdata('posisi_id')!=7){
            if ($totaldurasi>=8){
                $this->db->select_sum('durasi');
                $this->db->where('link_aktivitas', $jamkerja['id']);
                $this->db->where('kategori', '1');
                $query1 = $this->db->get('aktivitas');
                $kategori1 = $query1->row()->durasi;
                $produktif1 = ($kategori1 / 8) * 100;

                $this->db->select_sum('durasi');
                $this->db->where('link_aktivitas', $jamkerja['id']);
                $this->db->where('kategori', '2');
                $query2 = $this->db->get('aktivitas');
                $kategori2 = $query2->row()->durasi;
                $produktif2 = ($kategori2 / 8) * 100;

                $produktifitas = $produktif1 + $produktif2;

                $this->db->set('produktifitas', $produktifitas);
                $this->db->set('status', 9);
                $this->db->set('create', date('Y-m-d H:i:s'));
                $this->db->set('respon_create', $respon);
                $this->db->set('durasi', $totaldurasi);
                $this->db->where('id', $jamkerja['id']);
                $this->db->update('jamkerja');

                $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $jamkerja['id']])->result_array();
                foreach($aktivitas as $a):
                    $this->db->set('status', 9);
                    $this->db->where('id', $a['id']);
                    $this->db->update('aktivitas');
                endforeach;
            }
        } 
       
        redirect('jamkerja/tanggal/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
    }

    public function add_aktivitas_by_koor()
    {
        date_default_timezone_set('asia/jakarta');
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
        $npk = $jamkerja['npk'];
        $aktivitas = $this->input->post('aktivitas');
        $durasi = $this->input->post('durasi');
        $hasil = $this->input->post('progres_hasil');
        $kategori = $this->input->post('kategori');
        $copro = $this->input->post('copro');
        $deskripsi = $this->input->post('deskripsi');
        
        if ($copro) {
            $id = $copro . $npk . time();
        }else{
            $id = date("ymd", strtotime($jamkerja['tglmulai'])) . $npk . time();
        }

        if (!$deskripsi){
            $deskripsi = $aktivitas;
        }

        $data = [
            'id' => $id,
            'npk' => $npk,
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
            'status' => '1'
        ];
        $this->db->insert('aktivitas', $data);

        // Update DURASI & STATUS JAMKERJA
        $this->db->select('SUM(durasi) as total');
        $this->db->where('link_aktivitas', $jamkerja['id']);
        $this->db->from('aktivitas');
        $totaldurasi = $this->db->get()->row()->total;

        $this->db->set('durasi', $totaldurasi);
        $this->db->where('id', $jamkerja['id']);
        $this->db->update('jamkerja'); 
       
        redirect('jamkerja/detail/'.$jamkerja['id']);
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

        if($jamkerja['npk']==$this->session->userdata('npk')){

            if ($totaldurasi>=8){
                $this->db->set('status', 1);
            }else{
                $this->db->set('status', 0);
            }
            $this->db->set('durasi', $totaldurasi);
            $this->db->where('id', $jamkerja['id']);
            $this->db->update('jamkerja');

            redirect('jamkerja/tanggal/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
        }else{

            $this->db->set('durasi', $totaldurasi);
            $this->db->where('id', $jamkerja['id']);
            $this->db->update('jamkerja');

            redirect('jamkerja/detail/'.$jamkerja['id']);
        }
        
        
    }

    public function persetujuan()
    {
        date_default_timezone_set('asia/jakarta');
        if($this->input->post('tanggal')){
            $tanggal = $this->input->post('tanggal');
        }else{
            $tanggal = date("Y-m-d");
        }

        if ($this->session->userdata('dept_id')==14 AND $this->session->userdata('sect_id')==143){
            redirect('jamkerja/ppic/'.$tanggal);
        }else{
            redirect('jamkerja/koordinator/'.$tanggal);
        }
    }

    public function koordinator($tanggal)
    {
            $data['tanggal'] = date("Y-m-d 07:30:00", strtotime($tanggal));
            $data['sidemenu'] = 'Koordinator';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_koordinator', $data);
            $this->load->view('templates/footer');
    }

    public function ppic($tanggal)
    {
            $data['tanggal'] = date("Y-m-d 07:30:00", strtotime($tanggal));
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_ppic', $data);
            $this->load->view('templates/footer');
    }

    public function detail($link_aktivitas)
    {
        if ($this->session->userdata('dept_id')==14 AND $this->session->userdata('dept_id')==143){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['jamkerja'] = $this->db->get_where('jamkerja', ['id' => $link_aktivitas])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $link_aktivitas])->result_array();
            $data['listproject'] = $this->jamkerja_model->fetch_project();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_detail', $data);
            $this->load->view('templates/footer');
        }else{
            $data['sidemenu'] = 'Koordinator';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['jamkerja'] = $this->db->get_where('jamkerja', ['id' => $link_aktivitas])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $link_aktivitas])->result_array();
            $data['kategori'] = $this->jamkerja_model->fetch_kategori();
            $data['listproject'] = $this->jamkerja_model->fetch_project();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_detail', $data);
            $this->load->view('templates/footer');
        }
        
    }

    public function persetujuan_approve()
    {
        date_default_timezone_set('asia/jakarta');
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
        $now = time();
        $due = strtotime(date('Y-m-d 23:59:00', strtotime($jamkerja['create'])));
        $respon = $due - $now;

        $this->db->set('tgl_atasan1', date("Y-m-d H:i:s"));
        $this->db->set('poin', $this->input->post('poin'));
        $this->db->set('produktifitas', $this->input->post('produktifitas'));
        $this->db->set('respon_approve', $respon);
        $this->db->set('status', 2);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('jamkerja');

        redirect('jamkerja/koordinator/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
    }

    public function persetujuan_accept()
    {
        date_default_timezone_set('asia/jakarta');
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
        $this->db->set('ppic', $this->session->userdata('inisial'));
        $this->db->set('tgl_ppic', date("Y-m-d H:i:s"));
        $this->db->set('poin_ppic', $this->input->post('poin'));
        $this->db->set('status', 9);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('jamkerja');

        $this->db->set('status', 9);
        $this->db->where('link_aktivitas', $this->input->post('id'));
        $this->db->update('aktivitas');

        redirect('jamkerja/ppic/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
    }

    public function persetujuan_revisi()
    {
        date_default_timezone_set('asia/jakarta');
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
        
        if ($jamkerja['atasan1']==$this->session->userdata('inisial')){
            $this->db->set('catatan', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
            $this->db->set('status', 0);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('jamkerja');

            redirect('jamkerja/koordinator/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
        }else{
            $this->db->set('ppic', $this->session->userdata('inisial'));
            $this->db->set('catatan_ppic', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
            $this->db->set('status', 1);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('jamkerja');

            redirect('jamkerja/ppic/'.date("Y-m-d", strtotime($jamkerja['tglmulai'])));
        }
    }

    public function ubah_copro()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('id');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $aktivitas['link_aktivitas']])->row_array();

        $this->db->set('diubah_oleh', $this->session->userdata('inisial'));
        $this->db->set('copro',$this->input->post('copro'));
        $this->db->where('id', $id);
        $this->db->update('aktivitas');

        redirect('jamkerja/detail/'.$jamkerja['id']);
    }

    public function GET_MY_jamkerja()
    {
        // Our Start and End Dates
        $events = $this->jamkerja_model->GET_MY_jamkerja();
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

    public function GET_MY_lembur()
    {
        // Our Start and End Dates
        $events = $this->jamkerja_model->GET_MY_lembur();
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
            $this->db->where('jenis_aktivitas','LEMBUR');
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
