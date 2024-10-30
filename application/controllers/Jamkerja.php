<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jamkerja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        
        $this->load->model("jamkerja_model");
        $this->load->model("Aktivitas_model");
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
        $tanggal = $this->input->post('tanggal');
        $tahun = date("Y", strtotime($tanggal));
        $bulan = date("m", strtotime($tanggal));
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

        if ($this->input->post('shift')=='SHIFT1'){
            $tglmulai = date('Y-m-d 00:30:00', strtotime($tanggal));
            $tglselesai = date('Y-m-d 07:30:00', strtotime($tanggal));
            $due = strtotime(date('Y-m-d 00:30:00', strtotime('+1 days', strtotime($tanggal))));
        }elseif($this->input->post('shift')=='SHIFT2'){
            $tglmulai = date('Y-m-d 07:30:00', strtotime($tanggal));
            $tglselesai = date('Y-m-d 16:30:00', strtotime($tanggal));
            $due = strtotime(date('Y-m-d 07:30:00', strtotime('+1 days', strtotime($tanggal))));
        }elseif($this->input->post('shift')=='SHIFT3'){
            $tglmulai = date('Y-m-d 16:30:00', strtotime($tanggal));
            $tglselesai = date('Y-m-d 00:00:00', strtotime('+1 days',strtotime($tanggal)));
            $due = strtotime(date('Y-m-d 16:30:00', strtotime('+1 days', strtotime($tanggal))));
        }
        
        $create = time();
        $respon = $due - $create;

        $this->load->helper('string');
        $id = 'WH'.date('ym'). $this->session->userdata('npk') . random_string('alnum',4);

        $data = [
            'id' => $id,
            'shift' => $this->input->post('shift'),
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'tglmulai' => $tglmulai,
            'tglselesai' => $tglselesai,
            'durasi' => '0',
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

    //via button
    public function pilihtanggal()
    {
        date_default_timezone_set('asia/jakarta');
        $strdate = strtotime($this->input->post('tanggal'));
        $strnow =  time();
        $strlastyear = strtotime(date('2020-12-31'));

        if ($strdate>=$strnow){
            redirect('jamkerja');
        }elseif ($strdate<=$strlastyear){
            redirect('jamkerja');
        // }elseif (date('D', strtotime($this->input->post('tanggal')))=='Sat' or date('D', strtotime($this->input->post('tanggal')))=='Sun'){
        //     redirect('jamkerja');
        }else{
            redirect('jamkerja/tanggal/'.$this->input->post('tanggal'));
        }
    } 

    //via callendar
    public function checktanggal($date)
    {
        date_default_timezone_set('asia/jakarta');
        $strdate = strtotime($date);
        $strnow =  time();
        $strlastyear = strtotime(date('2019-12-31'));

        if ($strdate>=$strnow){
            redirect('jamkerja');
        }elseif ($strdate<=$strlastyear){
            redirect('jamkerja');
        // }elseif (date('D', strtotime($date))=='Sat' or date('D', strtotime($date))=='Sun'){
        //     redirect('jamkerja');
        }else{
            redirect('jamkerja/tanggal/'.$date);
        }
    }

    public function tanggal($date)
    {
        date_default_timezone_set('asia/jakarta');
        
        $tahun = date("Y", strtotime($date));
        $bulan = date("m", strtotime($date));
        $tanggal = date("d", strtotime($date));
    
        $this->db->where('year(tglmulai)',$tahun);
        $this->db->where('month(tglmulai)',$bulan);
        $this->db->where('day(tglmulai)',$tanggal);
        $this->db->where('npk',$this->session->userdata('npk'));
        $jamkerja = $this->db->get('jamkerja')->row_array();
        if (!empty($jamkerja['id'])){
        
            $data['sidemenu'] = 'Jam Kerja';
            $data['sidesubmenu'] = 'Laporan Kerja Harian';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->db->where('year(tglmulai)',$tahun);
            $this->db->where('month(tglmulai)',$bulan);
            $this->db->where('day(tglmulai)',$tanggal);
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

            $data['sidemenu'] = 'Jam Kerja';
            $data['sidesubmenu'] = 'Laporan Kerja Harian';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['tanggal'] = date("d M Y", strtotime($date));
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/jamkerja_kosong', $data);
            $this->load->view('templates/footer');

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

    public function selectAktivitas()
    {
        $kategori_id = $_POST['kategori'];
        $dept_id = $_POST['deptid'];
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

        if($aktivitas=="DR, Konsep"){
            $copro = null;
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

        if ($jamkerja['shift']=='SHIFT1'){
            
            if ($totaldurasi==6){
                $this->db->set('rev', 0);
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
                if ($totaldurasi==6){
                    $this->db->select_sum('durasi');
                    $this->db->where('link_aktivitas', $jamkerja['id']);
                    $this->db->where('kategori', '1');
                    $query1 = $this->db->get('aktivitas');
                    $kategori1 = $query1->row()->durasi;
                    $produktif1 = ($kategori1 / 6) * 100;
    
                    $this->db->select_sum('durasi');
                    $this->db->where('link_aktivitas', $jamkerja['id']);
                    $this->db->where('kategori', '2');
                    $query2 = $this->db->get('aktivitas');
                    $kategori2 = $query2->row()->durasi;
                    $produktif2 = ($kategori2 / 6) * 100;
    
                    $produktifitas = $produktif1 + $produktif2;
    
                    $this->db->set('produktifitas', $produktifitas);
                    $this->db->set('rev', 0);
                    $this->db->set('status', 2);
                    $this->db->set('create', date('Y-m-d H:i:s'));
                    $this->db->set('respon_create', $respon);
                    $this->db->set('durasi', $totaldurasi);
                    $this->db->where('id', $jamkerja['id']);
                    $this->db->update('jamkerja');
                }
            } 
        }elseif ($jamkerja['shift']=='SHIFT2'){
            
            if ($totaldurasi==8){
                $this->db->set('rev', 0);
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
                if ($totaldurasi==8){
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
                    $this->db->set('rev', 0);
                    $this->db->set('status', 2);
                    $this->db->set('create', date('Y-m-d H:i:s'));
                    $this->db->set('respon_create', $respon);
                    $this->db->set('durasi', $totaldurasi);
                    $this->db->where('id', $jamkerja['id']);
                    $this->db->update('jamkerja');
                }
            } 
        }elseif ($jamkerja['shift']=='SHIFT3'){
            
            if ($totaldurasi==7){
                $this->db->set('rev', 0);
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
                if ($totaldurasi==7){
                    $this->db->select_sum('durasi');
                    $this->db->where('link_aktivitas', $jamkerja['id']);
                    $this->db->where('kategori', '1');
                    $query1 = $this->db->get('aktivitas');
                    $kategori1 = $query1->row()->durasi;
                    $produktif1 = ($kategori1 / 7) * 100;
    
                    $this->db->select_sum('durasi');
                    $this->db->where('link_aktivitas', $jamkerja['id']);
                    $this->db->where('kategori', '2');
                    $query2 = $this->db->get('aktivitas');
                    $kategori2 = $query2->row()->durasi;
                    $produktif2 = ($kategori2 / 7) * 100;
    
                    $produktifitas = $produktif1 + $produktif2;
    
                    $this->db->set('produktifitas', $produktifitas);
                    $this->db->set('rev', 0);
                    $this->db->set('status', 2);
                    $this->db->set('create', date('Y-m-d H:i:s'));
                    $this->db->set('respon_create', $respon);
                    $this->db->set('durasi', $totaldurasi);
                    $this->db->where('id', $jamkerja['id']);
                    $this->db->update('jamkerja');
                }
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

        if($aktivitas=="DR, Konsep"){
            $copro = null;
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
            'contract' => 'Direct Labor',
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

            $this->db->set('status', 0);
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

    public function persetujuan($role=null)
    {
        date_default_timezone_set('asia/jakarta');
        if ($role==null){
            $data['bulan'] = date('m');
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'Approval';
            $data['sidesubmenu'] = 'Approval Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_koordinator', $data);
            $this->load->view('templates/footer');
        }elseif ($role=='koordinator'){
            $data['bulan'] = date('m');
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'Koordinator';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_koordinator', $data);
            $this->load->view('templates/footer');
        }elseif ($role=='ppic'){
            $data['bulan'] = date('m');
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan/persetujuan_ppic', $data);
            $this->load->view('templates/footer');
        }
    }

    // public function koordinator($tanggal)
    // {
    //         $data['tanggal'] = date("Y-m-d 07:30:00", strtotime($tanggal));
    //         $data['sidemenu'] = 'Koordinator';
    //         $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
    //         $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/sidebar', $data);
    //         $this->load->view('templates/navbar', $data);
    //         $this->load->view('jamkerja/persetujuan_koordinator', $data);
    //         $this->load->view('templates/footer');
    // }

    public function laporan($params=false)
    {
        if($params=="jk"){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Cetak Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                                $this->db->where('tglmulai >', date("Y-m-d 00:00:00", strtotime($this->input->post('tanggal'))));
                                $this->db->where('tglmulai <', date("Y-m-d 23:59:00", strtotime($this->input->post('tanggal'))));
                                $this->db->where('status', '9');
            $data['jamkerja'] = $this->db->get('jamkerja')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/lp_jamkerja', $data);
            $this->load->view('templates/footer');
        }elseif ($params=="ot"){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Cetak Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $tglmulai = date("Y-m-d 00:00:00", strtotime($this->input->post('tglawal')));
            $tglselesai = date("Y-m-d 23:59:00", strtotime($this->input->post('tglakhir')));

            $querylembur = "SELECT *
                            FROM `lembur`
                            WHERE `tglmulai` >= '$tglmulai' AND `tglmulai` <= '$tglselesai' AND `status`='9'
                            ";
                            
            $data['lembur'] = $this->db->query($querylembur)->result_array();
            $data['tglmulai'] = $tglmulai;
            $data['tglselesai'] = $tglselesai;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/lp_lembur', $data);
            $this->load->view('templates/footer');
        }elseif($params='getbyMonthly_Sum'){

            if (empty($this->input->post('dept')))
            {
                $this->db->where('work_contract','Direct Labor');
                $this->db->where('is_active','1');
                $this->db->where('status','1');
            }else{
                $this->db->where('work_contract','Direct Labor');
                $this->db->where('dept_id',$this->input->post('dept'));
                $this->db->where('is_active','1');
                $this->db->where('status','1');
            }
            
            $directList = $this->db->get('karyawan')->result();

            foreach ($directList as $row) :
                $deptName = $this->db->get_where('karyawan_dept', ['id' => $row->dept_id])->row();

                $this->db->where('year(tglmulai)',$this->input->post('tahun'));
                $this->db->where('month(tglmulai)',$this->input->post('bulan'));
                $this->db->where('npk',$row->npk);
                $this->db->where('status','9');
                $harian = $this->db->get('jamkerja');
                
                $this->db->select('SUM(durasi) as totalcopro_harian');
                $this->db->where('year(tgl_aktivitas)',$this->input->post('tahun'));
                $this->db->where('month(tgl_aktivitas)',$this->input->post('bulan'));
                $this->db->where('npk',$row->npk);
                $this->db->where('jenis_aktivitas','JAM KERJA');
                $this->db->where('kategori !=','3');
                $this->db->where('status','9');
                $this->db->from('aktivitas');
                $coproHarian = $this->db->get()->row()->totalcopro_harian;

                $this->db->select('SUM(durasi) as totalnon_harian');
                $this->db->where('year(tgl_aktivitas)',$this->input->post('tahun'));
                $this->db->where('month(tgl_aktivitas)',$this->input->post('bulan'));
                $this->db->where('npk',$row->npk);
                $this->db->where('jenis_aktivitas','JAM KERJA');
                $this->db->where('kategori','3');
                $this->db->where('status','9');
                $this->db->from('aktivitas');
                $nonHarian = $this->db->get()->row()->totalnon_harian;

                $totalHarian = $coproHarian + $nonHarian;

                if ($coproHarian>0 and $totalHarian>0){
                    $okupansiHarian = ($coproHarian / $totalHarian)*100;
                    $okupansiHarian = number_format($okupansiHarian, 2, '.', '');
                }else{
                    $okupansiHarian = 0;
                }

                $this->db->where('year(tglmulai)',$this->input->post('tahun'));
                $this->db->where('month(tglmulai)',$this->input->post('bulan'));
                $this->db->where('npk',$row->npk);
                $this->db->where('status','9');
                $lembur = $this->db->get('lembur');

                $this->db->select('SUM(durasi) as totalcopro_lembur');
                $this->db->where('year(tgl_aktivitas)',$this->input->post('tahun'));
                $this->db->where('month(tgl_aktivitas)',$this->input->post('bulan'));
                $this->db->where('npk',$row->npk);
                $this->db->where('jenis_aktivitas','LEMBUR');
                $this->db->where('kategori !=','3');
                $this->db->where('status','9');
                $this->db->from('aktivitas');
                $coproLembur = $this->db->get()->row()->totalcopro_lembur;

                $this->db->select('SUM(durasi) as totalnon_lembur');
                $this->db->where('year(tgl_aktivitas)',$this->input->post('tahun'));
                $this->db->where('month(tgl_aktivitas)',$this->input->post('bulan'));
                $this->db->where('npk',$row->npk);
                $this->db->where('jenis_aktivitas','LEMBUR');
                $this->db->where('kategori','3');
                $this->db->where('status','9');
                $this->db->from('aktivitas');
                $nonLembur = $this->db->get()->row()->totalnon_lembur;

                $totalLembur = $coproLembur + $nonLembur;

                if ($coproLembur>0 and $totalHarian>0){
                    $okupansiLembur = ($coproLembur / $totalLembur)*100;
                    $okupansiLembur = number_format($okupansiLembur, 2, '.', '');
                }else{
                    $okupansiLembur = 0;
                }

           
            $output['data'][] = array(
                'nama' => $row->nama,
                'dept' => $deptName->nama,
                'jamkerja_harian' => $harian->num_rows(),
                'projek_harian' => $coproHarian,
                'non_projek_harian' => $nonHarian,
                'okupansi_harian' => $okupansiHarian,
                'jamkerja_lembur' => $lembur->num_rows(),
                'projek_lembur' => $coproLembur,
                'non_projek_lembur' => $nonLembur,
                'okupansi_lembur' => $okupansiLembur
            );
        endforeach;

            //output to json format
            echo json_encode($output);





        }else{
            $this->load->view('auth/denied');
        }
    }

    public function cetak($id)
    {
        $data['jamkerja']  = $this->db->get_where('jamkerja', ['id' => $id])->row_array();
        $data['jamkerja_kategori']  = $this->db->get_where('jamkerja_kategori', ['id' => $id])->row_array();
        $data['aktivitas']  = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();

        $this->load->view('jamkerja/reportjk', $data);
    }

    public function detail($link_aktivitas)
    {
        if ($this->session->userdata('npk')=='0160'){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Persetujuan Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['jamkerja'] = $this->db->get_where('jamkerja', ['id' => $link_aktivitas])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $link_aktivitas])->result_array();
            $data['kategori'] = $this->jamkerja_model->fetch_kategori();
            $data['listproject'] = $this->db->get_where('project', ['status' => 'OPEN'])->result();
            // $data['listproject'] = $this->jamkerja_model->fetch_project();
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
            $data['listproject'] = $this->db->get_where('project', ['status' => 'OPEN'])->result();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/persetujuan_detail', $data);
            $this->load->view('templates/footer');
        }
        
    }

    public function approve($role)
    {
        date_default_timezone_set('asia/jakarta');
        if ($role=='koordinator'){
            $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
            $now = time();
            $due = strtotime(date('Y-m-d 23:59:00', strtotime($jamkerja['create'])));
            $respon = $due - $now;
            // if ($this->input->post('catatan')){
            //     $this->db->set('catatan', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
            //     }
            $this->db->set('tgl_atasan1', date("Y-m-d H:i:s"));
            // $this->db->set('poin', $this->input->post('poin'));
            $this->db->set('produktifitas', $this->input->post('produktifitas'));
            $this->db->set('respon_approve', $respon);
            $this->db->set('rev', 0);
            $this->db->set('status', 2);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('jamkerja');

            redirect('jamkerja/persetujuan/koordinator');
        }elseif ($role=='ppic'){    
            $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
            $this->db->set('ppic', $this->session->userdata('inisial'));
            $this->db->set('tgl_ppic', date("Y-m-d H:i:s"));
            // $this->db->set('poin_ppic', $this->input->post('poin'));
            $this->db->set('rev', 0);
            $this->db->set('status', 9);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('jamkerja');
    
            $this->db->set('status', 9);
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->update('aktivitas');
    
            redirect('jamkerja/persetujuan/ppic');
        }
    }

    public function persetujuan_accept()
    {
        date_default_timezone_set('asia/jakarta');   
    }

    public function persetujuan_revisi()
    {
        date_default_timezone_set('asia/jakarta');
        $jamkerja = $this->db->get_where('jamkerja', ['id' => $this->input->post('id')])->row_array();
        
        if ($jamkerja['atasan1']==$this->session->userdata('inisial')){
            $this->db->set('catatan', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
            $this->db->set('rev', 1);
            $this->db->set('status', 0);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('jamkerja');
            
            $user = $this->db->get_where('karyawan', ['npk' => $jamkerja['npk']])->row_array();
            $postData = array(
                'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                'number' => $user['phone'],
                'message' => "*OOPS!! LAPORAN JAM KERJA KAMU HARUS SEGERA DIREVISI*" .
                "\r\n \r\n*LAPORAN JAM KERJA* kamu dengan detil berikut :" .
                "\r\n \r\nTanggal : " . date('d-M H:i', strtotime($jamkerja['tglmulai'])) . 
                "\r\nCatatan dari atasan kamu : " . $this->input->post('catatan') . 
                "\r\n \r\nSegera Submit kembali laporan jam kerja kamu yang sudah direvisi ya" .
                "\r\n*JANGAN LUPA* Untuk melaporkan *JAM KERJA* setiap hari kerja ya!." .
                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
            );
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $result = curl_exec($ch);

            redirect('jamkerja/persetujuan/koordinator');
        }else{
            if ($jamkerja['posisi_id']==7){
                $this->db->set('ppic', $this->session->userdata('inisial'));
                $this->db->set('catatan_ppic', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
                $this->db->set('rev', 1);
                $this->db->set('status', 1);
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('jamkerja');

                $atasan1 = $this->db->get_where('karyawan', ['inisial' => $jamkerja['atasan1']])->row_array();
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $atasan1['phone'],
                    'message' => "*OOPS!! LAPORAN JAM KERJA TIM KAMU HARUS SEGERA DIREVISI*" .
                    "\r\n \r\n*LAPORAN JAM KERJA* tim kamu dengan detil berikut :" .
                    "\r\n \r\nNama : " . $jamkerja['nama']. 
                    "\r\nTanggal : " . date('d-M H:i', strtotime($jamkerja['tglmulai'])) . 
                    "\r\nCatatan dari ppic : " . $this->input->post('catatan') . 
                    "\r\n \r\nSegera Submit kembali laporan jam kerja kamu yang sudah direvisi ya" .
                    "\r\n*JANGAN LUPA* Untuk melaporkan *JAM KERJA* setiap hari kerja ya!." .
                    "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                );
            }else{
                $this->db->set('ppic', $this->session->userdata('inisial'));
                $this->db->set('catatan_ppic', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
                $this->db->set('rev', 1);
                $this->db->set('status', 0);
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('jamkerja');

                $user = $this->db->get_where('karyawan', ['npk' => $jamkerja['npk']])->row_array();
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $user['phone'],
                    'message' => "*OOPS!! LAPORAN JAM KERJA KAMU HARUS SEGERA DIREVISI*" .
                    "\r\n \r\n*LAPORAN JAM KERJA* kamu dengan detil berikut :" .
                    "\r\n \r\nTanggal : " . date('d-M H:i', strtotime($jamkerja['tglmulai'])) . 
                    "\r\nCatatan dari atasan kamu : " . $this->input->post('catatan') . 
                    "\r\n \r\nSegera Submit kembali laporan jam kerja kamu yang sudah direvisi ya" .
                    "\r\n*JANGAN LUPA* Untuk melaporkan *JAM KERJA* setiap hari kerja ya!." .
                    "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                );
            }
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $result = curl_exec($ch);

            redirect('jamkerja/persetujuan/ppic');
        }
    }

    public function hapus()
    {
        // Hapus Aktivitas
        $this->db->where('link_aktivitas', $this->input->post('id'));
        $this->db->delete('aktivitas');

        // Hapus Jam Kerja
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('jamkerja');

        redirect('jamkerja/persetujuan/ppic');
    }

    public function status()
    {
            date_default_timezone_set('asia/jakarta');
            
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Status Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            if($this->input->post('bulan')){
                $data['tahun'] = $this->input->post('tahun');
                $data['bulan'] = $this->input->post('bulan');
                $data['tgl1'] = $this->input->post('tgl1');
                $data['tgl2'] = $this->input->post('tgl2');
                $data['section'] = $this->input->post('section');
            }else{
                $data['tahun'] = date('Y');
                $data['bulan'] = date('m');
                $data['tgl1'] = date('d');
                $data['tgl2'] = date('d');
                $data['section'] = 111;
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/jamkerja_status2', $data);
            $this->load->view('templates/footer');
    }

    public function status_ot()
    {
            date_default_timezone_set('asia/jakarta');
            
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Status Jam Kerja';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            if($this->input->post('bulan')){
                $data['tahun'] = $this->input->post('tahun');
                $data['bulan'] = $this->input->post('bulan');
                $data['section'] = $this->input->post('section');
            }else{
                $data['tahun'] = date('Y');
                $data['bulan'] = date('m');
                $data['section'] = 111;
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('jamkerja/jamkerja_status3', $data);
            $this->load->view('templates/footer');
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

    public function get_status()
    {
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        for ($i = 1; $i < $tanggal + 1; $i++) {

            $this->db->where('is_active', '1');
            $directLabor = $this->db->get_where('karyawan', ['work_contract' => 'Direct Labor'])->result_array();

            foreach ($directLabor as $row) :
                $this->db->where('npk', $row['npk']);
                $this->db->where('year(tglmulai)', $tahun);
                $this->db->where('month(tglmulai)', $bulan);
                $this->db->where('day(tglmulai)', $i);
                $this->db->where('status >', 0);
                $jamkerja = $this->db->get_where('jamkerja')->row_array();

                $this->db->where('npk', $row['npk']);
                $this->db->where('year(tglmulai)', $tahun);
                $this->db->where('month(tglmulai)', $bulan);
                $this->db->where('day(tglmulai)', $i);
                $this->db->where('status >', 0);
                $lembur = $this->db->get_where('lembur')->row_array();

                $data[] = array(
                    "id" => $r->id,
                    "title" => $r->id,
                    "start" => $r->tglmulai,
                    "end" => $r->tglselesai
                );

            endforeach;
        }
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
            $this->db->where('status','9');
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

    public function lp_acc_monthly()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'PPIC';
        $data['sidesubmenu'] = 'Laporan Jam Kerja';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if($this->input->post('tglawal')){
            $tglawal  = date('Y-m-d', strtotime($this->input->post('tglawal')));
            $tglakhir = date('Y-m-d', strtotime($this->input->post('tglakhir')));
        }else{
            $tglawal  = date('Y-m-1');
            $tglakhir = date('Y-m-d');
        }
        
        $data['periode'] = [
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/lp_acc_monthly', $data);
        $this->load->view('templates/footer');
    }

    public function laporan_jk()
    {
        $data['sidemenu'] = 'PPIC';
        $data['sidesubmenu'] = 'Jam Kerja Harian';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        date_default_timezone_set('asia/jakarta');

        if($this->input->post('tglawal')){
            $tglawal  = date('Y-m-d', strtotime($this->input->post('tglawal')));
            $tglakhir = date('Y-m-d', strtotime($this->input->post('tglakhir')));
        }else{
            $tglawal  = date('Y-m-1');
            $tglakhir = date('Y-m-31');
        }
        
        $data['periode'] = [
            'tglawal'   => $tglawal,
            'tglakhir'  => $tglakhir
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('jamkerja/lp_jk_range', $data);
        $this->load->view('templates/footer');
    }

    public function get_aktivitas_jk()
    {
        $this->db->where('tgl_aktivitas >=',$this->input->post('awal'));
        $this->db->where('tgl_aktivitas <=',$this->input->post('akhir'));
        $this->db->where('jenis_aktivitas','JAM KERJA');
        $this->db->where('contract','Direct Labor');
        $this->db->where('status','9');
        $this->db->order_by('npk', 'ASC');
        $aktivitas = $this->db->get('aktivitas')->result();

        foreach ($aktivitas as $row) {
            $person = $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
            $dept = $this->db->get_where('karyawan_dept', ['id' => $person->dept_id])->row();
            $sect = $this->db->get_where('karyawan_sect', ['id' => $person->sect_id])->row();
            $posisi = $this->db->get_where('karyawan_posisi', ['id' => $person->posisi_id])->row();
            
            $kategori =  $this->db->get_where('jamkerja_kategori', ['id' => $row->kategori])->row();
            if ($row->copro){
                $copro = $row->copro;
            }else{
                $copro = $row->aktivitas;
            }

            $output['data'][] = array(
                "tanggal" => date('m-d-Y', strtotime($row->tgl_aktivitas)),
                "nama" => $person->nama,
                "npk" => $person->npk,
                "kategori" => $kategori->nama,
                "copro" => $copro,
                "aktivitas" => $row->aktivitas,
                "deskripsi" => $row->deskripsi_hasil,
                "durasi" => $row->durasi,
                "progres" => $row->progres_hasil,
                "dept" => $dept->nama,
                "sect" => $sect->nama,
                "posisi" => $posisi->nama
            );
        }
        
        echo json_encode($output);
        exit();
    }

    public function get_aktivitas()
    {
        $this->db->where('tgl_aktivitas >=',$this->input->post('awal'));
        $this->db->where('tgl_aktivitas <=',$this->input->post('akhir'));
        $this->db->where('contract', 'Direct Labor');
        $this->db->where('status', 9);
        $aktivitas = $this->db->get('aktivitas')->result();

        foreach ($aktivitas as $row) {
            $person = $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
            $dept = $this->db->get_where('karyawan_dept', ['id' => $person->dept_id])->row();
            $sect = $this->db->get_where('karyawan_sect', ['id' => $person->sect_id])->row();
            $posisi = $this->db->get_where('karyawan_posisi', ['id' => $person->posisi_id])->row();
            
            $kategori =  $this->db->get_where('jamkerja_kategori', ['id' => $row->kategori])->row();
            if ($row->copro){
                $copro = $row->copro;
            }else{
                $copro = $row->aktivitas;
            }

            $output['data'][] = array(
                "tanggal" => date('m-d-Y', strtotime($row->tgl_aktivitas)),
                "nama" => $person->nama,
                "npk" => $person->npk,
                "kategori" => $kategori->nama,
                "copro" => $copro,
                "aktivitas" => $row->aktivitas,
                "deskripsi" => $row->deskripsi_hasil,
                "durasi" => $row->durasi,
                "progres" => $row->progres_hasil,
                "dept" => $dept->nama,
                "sect" => $sect->nama,
                "posisi" => $posisi->nama,
                "jenis" => $row->jenis_aktivitas,
                "hari" => date('D', strtotime($row->tgl_aktivitas))
            );
        }
        
        echo json_encode($output);
        exit();
    }

    public function get_status_section()
    {
        date_default_timezone_set('asia/jakarta');
        //Set variable
        // $tahun      = $this->input->post('tahun');
        // $bulan      = $this->input->post('bulan');
        // $tanggal    = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        // $section    = $this->input->post('section');

        $tahun      = '2024';
        $bulan      = '05';
        $tanggal    = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $section    = '111';

        
        
        $this->db->where('status', '1');
        $this->db->where('is_active', '1');
        $this->db->where('sect_id', $section);
        $kry = $this->db->get_where('karyawan', ['work_contract' => 'Direct Labor'])->result_array();
        
        foreach ($kry as $k) {
            $row = array();
            for ($i = 1; $i < $tanggal + 1; $i++) {

                      $this->db->where('npk', $k['npk']);
                      $this->db->where('year(tglmulai)', $tahun);
                      $this->db->where('month(tglmulai)', $bulan);
                      $this->db->where('day(tglmulai)', $i);
                      $this->db->where('status >', 0);
                      $jamkerja = $this->db->get_where('jamkerja')->row_array();

                        if (!empty($jamkerja)) {
                            if ($jamkerja['status'] == 1) {
                                $jk_status = 'Menunggu Persetujuan ' . $jamkerja['atasan1'];
                            } elseif ($jamkerja['status'] == 2) {
                                $jk_status = 'Menunggu Persetujuan PPIC';
                            } elseif ($jamkerja['status'] == 9) {
                                $jk_status = 'Selesai';
                            }
                        else{
                                $jk_status = 'Tidak ada Laporan';
                        }

                      $this->db->where('npk', $k['npk']);
                      $this->db->where('year(tglmulai)', $tahun);
                      $this->db->where('month(tglmulai)', $bulan);
                      $this->db->where('day(tglmulai)', $i);
                      $this->db->where('status >', 0);
                      $lembur = $this->db->get_where('lembur')->row_array();

                        if (!empty($lembur)) {
                            $status_ot = $this->db->get_where('lembur_status', ['id' =>  $lembur['status']])->row_array();
                            $ot_status = $status_ot['nama'];
                        }
                        else{
                            $ot_status = 'Tidak ada Laporan';
                        }

                        // $respon = floor($jamkerja['respon_create'] / (60 * 60 * 24));
                        // if ($respon == 0) {
                        //   $respon = 'Tepat Waktu';
                        // } else {
                        //   $respon = $respon;
                        // }

                        // $now = time();
                        // // $due = strtotime($jamkerja['create']);
                        // $due = strtotime(date('Y-m-d 23:59:00', strtotime($jamkerja['create'])));
                        // $approve = $due - $now;
                        // $approve = floor($approve / (60 * 60 * 24));
                        // if ($approve < 0) {
                        //   $approve = '( ' . $approve . ' Hari )';
                        // } else {
                        //   $approve = null;
                        // }
                        $row[] =  $k['nama'];
                        $row[] = date('m-d-Y', strtotime($tahun . '-' . $bulan . '-' . $i));

                        // $output['data'][] = array(
                        //         "nama" => $k['nama'],
                        //         "tgl" => date('m-d-Y', strtotime($tahun . '-' . $bulan . '-' . $i)),
                        //         "shift" => $jamkerja['shift'],
                        //         "jk" => $jk_status,
                        //         "ot" => $ot_status
                        // );
                        
                    }

                    $output['data'][] = array(
                            "nama" => $row,
                    );
                    
                    
                };
                echo json_encode($output);
                exit();
                    // echo json_encode($output);

            }


        // $this->db->where('tgl_aktivitas >=',$this->input->post('awal'));
        // $this->db->where('tgl_aktivitas <=',$this->input->post('akhir'));
        // $this->db->where('contract', 'Direct Labor');
        // $this->db->where('status', 9);
        // $aktivitas = $this->db->get('aktivitas')->result();

        // foreach ($aktivitas as $row) {
        //     $person = $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
        //     $dept = $this->db->get_where('karyawan_dept', ['id' => $person->dept_id])->row();
        //     $sect = $this->db->get_where('karyawan_sect', ['id' => $person->sect_id])->row();
        //     $posisi = $this->db->get_where('karyawan_posisi', ['id' => $person->posisi_id])->row();
            
        //     $kategori =  $this->db->get_where('jamkerja_kategori', ['id' => $row->kategori])->row();
        //     if ($row->copro){
        //         $copro = $row->copro;
        //     }else{
        //         $copro = $row->aktivitas;
        //     }

        //     $output['data'][] = array(
        //         "tanggal" => date('m-d-Y', strtotime($row->tgl_aktivitas)),
        //         "nama" => $person->nama,
        //         "npk" => $person->npk,
        //         "kategori" => $kategori->nama,
        //         "copro" => $copro,
        //         "aktivitas" => $row->aktivitas,
        //         "deskripsi" => $row->deskripsi_hasil,
        //         "durasi" => $row->durasi,
        //         "progres" => $row->progres_hasil,
        //         "dept" => $dept->nama,
        //         "sect" => $sect->nama,
        //         "posisi" => $posisi->nama,
        //         "jenis" => $row->jenis_aktivitas,
        //         "hari" => date('D', strtotime($row->tgl_aktivitas))
        //     );
        // }
        
        // echo json_encode($output);
        // exit();
    }
}
