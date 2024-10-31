<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Lembur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        $this->update();
        
        $this->load->model("project_model");
    }

    public function update()
    {
         //Auto batalkan LEMBUR
         $this->db->where('status', '1');
         $this->db->where('life', '0');
         $rencanalembur = $this->db->get('lembur')->result_array();
 
         foreach ($rencanalembur as $l) :
             // cari selisih
             $sekarang = strtotime(date('Y-m-d H:i:s'));
             $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+1 hours', strtotime($l['tglmulai_rencana']))));
 
             if ($tempo < $sekarang) {
                 $this->db->set('catatan', "Waktu RENCANA LEMBUR kamu telah HABIS - Dibatalkan oleh SISTEM");
                 $this->db->set('status', '0');
                 $this->db->where('id', $l['id']);
                 $this->db->update('lembur');
             }
         endforeach;
         // End Auto Batalkan RENCANA LEMBUR
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

    public function index()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        // $data['lembur'] = $this->db->get_where('lembur', ['npk' =>  $this->session->userdata('npk')])->result_array();

        $this->output->cache(10); // Durasi dalam menit

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/index', $data);
        $this->load->view('templates/footer');
    }

    public function rencana($params=null,$id=null)
    {
        date_default_timezone_set('asia/jakarta');
        if ($params==null or $id==null){
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $npk = $this->session->userdata('npk');
            $pemohon = $this->session->userdata('inisial');
            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE (`status`>= '1' AND `status` <= '6' AND `npk`= '$npk') OR (`status`= '1' AND `pemohon`= '$pemohon')";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/rencana/index', $data);
            $this->load->view('templates/footer');

        }elseif ($params=='aktivitas' and $id!=null){
            $this->db->where('id', $id);
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->where('status', '1');
            $lembur = $this->db->get('lembur')->row_array();
            if (!empty($lembur)){
                $data['sidemenu'] = 'Lembur';
                $data['sidesubmenu'] = 'Rencana';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $data['lembur'] = $lembur;
                // $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
                // $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
                
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);

                $this->load->view('lembur/rencana/aktivitas', $data);
                $this->load->view('templates/footer');
            }else{
                redirect('lembur/rencana');
            }
        }else{
            redirect('lembur/rencana');
        }
    }

    public function realisasi($params=null,$id=null)
    {
        date_default_timezone_set('asia/jakarta');
        if ($params==null){

            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Realisasi';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $npk = $this->session->userdata('npk');
            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE (`status`= '4' OR `status`= '5' OR `status`= '6') and `npk`= '$npk' ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/realisasi/index', $data);
            $this->load->view('templates/footer');
        
        }elseif ($params=='aktivitas' and $id!=null){
            $this->db->where('id', $id);
            $this->db->where('npk', $this->session->userdata('npk'));
            // $this->db->where('tglselesai_rencana <', date('Y-m-d H:i:s'));
            $this->db->where('status', '4');
            $lembur = $this->db->get('lembur')->row_array();
            if (!empty($lembur)){
                if ($lembur['contract']=='Direct Labor' AND $lembur['hari']=='KERJA'){
                    
                    $this->db->where('npk', $lembur['npk']);
                    $this->db->where('year(tglmulai)',date('Y', strtotime($lembur['tglmulai'])));
                    $this->db->where('month(tglmulai)',date('m', strtotime($lembur['tglmulai'])));
                    $this->db->where('day(tglmulai)',date('d', strtotime($lembur['tglmulai'])));
                    $this->db->where('status >', '0'); 
                    $jamkerja = $this->db->get('jamkerja')->row_array();
                    if (empty($jamkerja))
                    {
                        $this->session->set_flashdata('notify', 'error');
                        redirect('lembur/realisasi');
                    }
                }
                $data['sidemenu'] = 'Lembur';
                $data['sidesubmenu'] = 'Realisasi';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $data['lembur'] = $lembur;
                // $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
                // $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
                
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);

                $this->load->view('lembur/realisasi/aktivitas', $data);
                $this->load->view('templates/footer');
            }else{
                $this->session->set_flashdata('notify', 'error');
                redirect('lembur/realisasi');
            }

        }elseif ($params=='submit' and $id==null){
            
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
            $expired = date('Y-m-d H:i:s', strtotime('+7 days', strtotime($lembur['tglmulai'])));

            if ($lembur['kategori'] != 'OT' and $lembur['durasi'] != 9){
                redirect('lembur/realisasi/aktivitas/'.$this->input->post('id'));
            }

            $jammulai = date('H:i', strtotime($lembur['tglmulai']));
            $jamselesai = date('H:i', strtotime($lembur['tglselesai']));

            if ($lembur['durasi']>=4 AND $jammulai < '12:00' AND $jamselesai > '13:00'){
                $istirahat1 = 1;
            }else{
                $istirahat1 = 0;
            }

            if ($lembur['durasi']>=4 AND $jammulai < '18:30' AND $jamselesai > '19:00'){
                $istirahat2 = 0.5;
            }else{
                $istirahat2 = 0;
            }

            $istirahat = $istirahat1 + $istirahat2;

            $durasi = $lembur['durasi'] - $istirahat;
                $this->db->where('durasi', $durasi);
                $this->db->where('hari', $lembur['hari']);
            $tul = $this->db->get('lembur_tul')->row();

            $this->db->set('tglpengajuan_realisasi', date('Y-m-d H:i:s'));
            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat1', $istirahat1);
            $this->db->set('istirahat2', $istirahat2);
            $this->db->set('istirahat3', 0);
            $this->db->set('durasi_hr', $durasi);
            $this->db->set('tul', $tul->tul);
            $this->db->set('status', 5);
            $this->db->set('expired_at', $expired);
            $this->db->set('last_notify', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->db->set('aktivitas');
            $this->db->where('status !=', '2');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->delete('aktivitas');

            // Notification saat mengajukan REALISASI to ATASAN 1
            $atasan1 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1']])->row_array();
            $client = new \GuzzleHttp\Client();
            $options = [
                'form_params' => [
                    'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
                    'number' => $atasan1['phone'],
                    'message' => "*PENGAJUAN REALISASI LEMBUR*" .
                                "\r\n \r\n👤 : *" . $lembur['nama'] . "*" .
                                "\r\n🗓 : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                                "\r\n🕗 : " . $lembur['durasi'] ." Jam " .
                                "\r\n\r\nBatal otomatis pada *" . date('d-M H:i', strtotime($expired)) . "*",
                    'date' => date('Y-m-d'),
                    'time' => date(' H:i:s')
                ]
            ];
            $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
            $res = $client->sendAsync($request, $options)->wait();
            echo $res->getBody();
            redirect('lembur/realisasi/');

        }elseif ($params=='telat'){
            
            $data['sidemenu'] = 'DH Lembur';
            $data['sidesubmenu'] = 'Realisasi';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/dh/dibatalkan', $data);
            $this->load->view('templates/footer');

        }
    }

    public function lemburku($id)
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        if ($lembur['npk'] == $this->session->userdata('npk')){
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'LemburKu';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/lemburku', $data);
            $this->load->view('templates/footer');
        }else{
            redirect('lembur');
        }
    }

    public function tambah_hariini()
    {
        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();
        
        $this->load->helper('string');

        $id = 'OT'.date('ym'). random_string('alnum',3);
        $existid = $this->db->get_where('lembur', ['id' => $id])->row_array();
        if (!empty($existid)){$id = 'OT'.date('ym'). random_string('alnum',4);}
        
        if (date('D') == 'Sat' OR date('D') == 'Sun') 
        {
            $tglmulai = date('Y-m-d H:i:s');
            $hari = 'LIBUR';
        }else{
            $tglmulai = date('Y-m-d H:i:s');
            $event = $this->db->get_where('calendar_event_details', ['date' => date('Y-m-d')])->row_array();
            if (empty($event))
            {
                $hari = 'KERJA';
            }else{
                $hari = $event['category'];
            }
        }

        $data = [
            'id' => $id,
            'tglpengajuan_rencana' => date('Y-m-d H:i:s'),
            'npk' => $this->session->userdata('npk'),
            'nama' => $karyawan['nama'],
            'tglmulai_rencana' => $tglmulai,
            'tglselesai_rencana' => $tglmulai,
            'tglmulai' => $tglmulai,
            'tglselesai' => $tglmulai,
            'durasi_rencana' => '0',
            'durasi' => '0',
            'hari' => $hari,
            'atasan1' => $atasan1['inisial'],
            'atasan2' => $atasan2['inisial'],
            'gol_id' => $karyawan['gol_id'],
            'posisi_id' => $karyawan['posisi_id'],
            'div_id' => $karyawan['div_id'],
            'dept_id' => $karyawan['dept_id'],
            'sect_id' => $karyawan['sect_id'],
            'pemohon' => $this->session->userdata('inisial'),
            'contract' => $this->session->userdata('contract'),
            'status' => '1',
            'life' => '0'
        ];
        $this->db->insert('lembur', $data);

        redirect('lembur/rencana/aktivitas/' . $data['id']);
    }

    public function tambah_harilain()
    {  
        //validasi jam hari kerja dan jam hari libur BELUM
        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();
        $tahun = date("Y", strtotime($this->input->post('tglmulai')));
        $bulan = date("m", strtotime($this->input->post('tglmulai')));

        if (date("Y-m-d", strtotime($this->input->post('tglmulai'))) > date('Y-m-d')) {
        
            $this->load->helper('string');

            $id = 'OT'.date('ym', strtotime($this->input->post('tglmulai'))). random_string('alnum',3);
            $existid = $this->db->get_where('lembur', ['id' => $id])->row_array();
            if (!empty($existid)){$id = 'OT'.date('ym'). random_string('alnum',4);}

            if (date('D', strtotime($this->input->post('tglmulai'))) == 'Sat' OR date('D', strtotime($this->input->post('tglmulai'))) == 'Sun') {
                $hari = 'LIBUR';
            }else{
                $event = $this->db->get_where('calendar_event_details', ['date' => date('Y-m-d', strtotime($this->input->post('tglmulai')))])->row_array();
                if (empty($event))
                {
                    $hari = 'KERJA';
                }else{
                    $hari = $event['category'];
                }
            }

            $data = [
                'id' => $id,
                'tglpengajuan_rencana' => date('Y-m-d H:i:s'),
                'npk' => $this->session->userdata('npk'),
                'nama' => $karyawan['nama'],
                'tglmulai_rencana' => $this->input->post('tglmulai'),
                'tglselesai_rencana' => $this->input->post('tglmulai'),
                'tglmulai' => $this->input->post('tglmulai'),
                'tglselesai' => $this->input->post('tglmulai'),
                'durasi_rencana' => '0',
                'durasi' => '0',
                'hari' => $hari,
                'atasan1' => $atasan1['inisial'],
                'atasan2' => $atasan2['inisial'],
                'gol_id' => $karyawan['gol_id'],
                'posisi_id' => $karyawan['posisi_id'],
                'div_id' => $karyawan['div_id'],
                'dept_id' => $karyawan['dept_id'],
                'sect_id' => $karyawan['sect_id'],
                'pemohon' => $this->session->userdata('inisial'),
                'contract' => $this->session->userdata('contract'),
                'status' => '1',
                'life' => '0'
            ];

            $this->db->insert('lembur', $data);
            redirect('lembur/rencana/aktivitas/' . $data['id']);
        }
        else{
            $this->session->set_flashdata('message', 'update');
            redirect('lembur/rencana/');
        }
    }

    public function tambah_tim()
    {  
        //validasi jam hari kerja dan jam hari libur BELUM
        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' => $this->input->post('npk')])->row_array();
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $tahun = date("Y", strtotime($this->input->post('tglmulai')));
        $bulan = date("m", strtotime($this->input->post('tglmulai')));

        if (date("Y-m-d H:i:s", strtotime($this->input->post('tglmulai'))) > date('Y-m-d H:i:s')) {
            $this->db->where('year(tglmulai)', $tahun);
            $this->db->where('month(tglmulai)', $bulan);
            $lembur = $this->db->get('lembur');
            $total_lembur = $lembur->num_rows()+1;
            $id = 'OT'.date('ym', strtotime($this->input->post('tglmulai'))). sprintf("%04s", $total_lembur);

            if (date('D', strtotime($this->input->post('tglmulai'))) == 'Sat' OR date('D', strtotime($this->input->post('tglmulai'))) == 'Sun') {
                $hari = 2;
            }else{
                $hari = 1;
            }

            $data = [
                'id' => $id,
                'tglpengajuan' => date('Y-m-d H:i:s'),
                'npk' => $this->input->post('npk'),
                'nama' => $karyawan['nama'],
                'tglmulai' => $this->input->post('tglmulai'),
                'tglselesai' => $this->input->post('tglmulai'),
                'tglmulai_aktual' => $this->input->post('tglmulai'),
                'tglselesai_aktual' => $this->input->post('tglmulai'),
                'atasan1_rencana' => $atasan1['inisial'],
                'atasan2_rencana' => $atasan2['inisial'],
                'atasan1_realisasi' => $atasan1['inisial'],
                'atasan2_realisasi' => $atasan2['inisial'],
                'durasi_rencana' => '00:00:00',
                'durasi_aktual' => '00:00:00',
                'aktivitas_rencana' => '0',
                'aktivitas' => '0',
                'status' => '1',
                'hari' => $hari,
                'gol_id' => $karyawan['gol_id'],
                'posisi_id' => $karyawan['posisi_id'],
                'div_id' => $karyawan['div_id'],
                'dept_id' => $karyawan['dept_id'],
                'sect_id' => $karyawan['sect_id'],
                'pemohon' => $this->session->userdata('inisial')
            ];
            $this->db->insert('lembur', $data);
            redirect('lembur/rencana_aktivitas/' . $data['id']);
        }
        else{
            $this->session->set_flashdata('message', 'update');
            redirect('lembur/rencana/');
        }
    }

    public function rencana_aktivitas($id)
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        if ($lembur['npk'] == $this->session->userdata('npk') or $lembur['pemohon'] == $this->session->userdata('inisial')){
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            // $data['lembur_lokasi'] = $this->db->get_where('lembur_lokasi')->result_array();
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/rencana_aktivitas', $data);
            $this->load->view('templates/footer');
        }else{
            redirect('lembur/rencana');
        }
    }

    public function realisasi_aktivitas($id)
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $id])->row_array();

        $tahun = date('Y', strtotime($lembur['tglmulai']));
        $bulan = date('m', strtotime($lembur['tglmulai']));
        $tanggal = date('d', strtotime($lembur['tglmulai']));

        $sekarang = strtotime(date('Y-m-d H:i:s'));
        $realisasi = strtotime(date('Y-m-d H:i:s', strtotime($lembur['tglselesai_rencana'])));

        if ($sekarang > $realisasi){
            if ($lembur['npk'] == $this->session->userdata('npk') or $lembur['pemohon'] == $this->session->userdata('inisial')){
                if ($lembur['status']==4){
                    if ($lembur['contract']=='Direct Labor' AND $lembur['hari']=='KERJA'){
                        $this->db->where('npk', $lembur['npk']);
                        $this->db->where('year(tglmulai)',$tahun);
                        $this->db->where('month(tglmulai)',$bulan);
                        $this->db->where('day(tglmulai)',$tanggal);
                        $this->db->where('status >', '0'); 
                        $jamkerja = $this->db->get('jamkerja')->result();

                        if (!empty($jamkerja))
                        {
                            $data['sidemenu'] = 'Lembur';
                            $data['sidesubmenu'] = 'Realisasi';
                            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                            $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
                            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
                            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
                            $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();
            
                            $this->load->view('templates/header', $data);
                            $this->load->view('templates/sidebar', $data);
                            $this->load->view('templates/navbar', $data);
                            $this->load->view('lembur/realisasi_aktivitas', $data);
                            $this->load->view('templates/footer');
                        }else{
                            $data['sidemenu'] = 'Lembur';
                            $data['sidesubmenu'] = 'LemburKu';
                            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                            $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
                            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
                            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
                            $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();
                            $this->session->set_flashdata('jknotfound', '<div class="alert alert-rose alert-dismissible fade show" role="alert">
                            Silahkan melaporkan JAM KERJA Terlebih dahulu sebelum melakukan REALISASI.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>');
                            $this->load->view('templates/header', $data);
                            $this->load->view('templates/sidebar', $data);
                            $this->load->view('templates/navbar', $data);
                            $this->load->view('lembur/lemburku', $data);
                            $this->load->view('templates/footer');
                        }
                    }else{
                        $data['sidemenu'] = 'Lembur';
                        $data['sidesubmenu'] = 'Realisasi';
                        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
                        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
                        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
                        $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();
        
                        $this->load->view('templates/header', $data);
                        $this->load->view('templates/sidebar', $data);
                        $this->load->view('templates/navbar', $data);
                        $this->load->view('lembur/realisasi_aktivitas', $data);
                        $this->load->view('templates/footer');
                    }
                }else{
                    $data['sidemenu'] = 'Lembur';
                    $data['sidesubmenu'] = 'LemburKu';
                    $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                    $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
                    $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
                    $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
                    $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();
        
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('lembur/lemburku', $data);
                    $this->load->view('templates/footer');
                }
            }else{
                redirect('lembur/realisasi');
            }
        }else{
            redirect('lembur/realisasi');
        }
    }

    public function aktivitas($params1, $params2)
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();

        if ($params1=='rencana' and $params2=='tambah'){

            if ($user['work_contract'] == 'Direct Labor')
            {
                $kategori = $this->input->post('kategori');
                if ($kategori=='1')
                {
                    $aktivitas = $this->input->post('aktivitas_projek');
                    $copro = $this->input->post('copro');
                }elseif ($kategori=='2')
                {
                    $aktivitas = $this->input->post('aktivitas_direct');
                    if($aktivitas=="DR, Konsep")
                    {
                        $copro = null;
                    }else{
                        $copro = $this->input->post('copro');
                    }
                }elseif ($kategori=='3')
                {
                    $aktivitas = $this->input->post('aktivitas_direct');
                    $copro = null;
                }
            }else{
                $kategori = '3';
                $aktivitas = $this->input->post('aktivitas');
                $copro = null;
            }

            $data = [
                'id' => $lembur['npk'] . time(),
                'npk' => $lembur['npk'],
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $lembur['id'],
                'kategori' => $kategori,
                'aktivitas' => $aktivitas,
                'copro' => $copro,
                'durasi_menit' => floatval($this->input->post('durasi')) * 60,
                'durasi' => $this->input->post('durasi'),
                'durasi_rencana' => $this->input->post('durasi'),
                'progres_hasil' => 0,
                'dibuat_oleh' => $this->session->userdata('inisial'),
                'dept_id' => $user['dept_id'],
                'sect_id' => $user['sect_id'],
                'contract' => $user['work_contract'],
                'terencana' => '1',
                'status' => '1'
            ];
            $this->db->insert('aktivitas', $data);

            //Hitung total aktivitas
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '1');
            $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '1');
            $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;

            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_rencana'])));

            // Update data LEMBUR
            $this->db->set('tglselesai_rencana', $tglselesai);
            $this->db->set('durasi_rencana', $totalDJam);
            $this->db->set('aktivitas_rencana', $totalAktivitas);
            $this->db->where('id', $lembur['id']);
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                'durasi' =>  $totalDJam.' Jam'
            );

            //output to json format
            echo json_encode($output);
        }elseif ($params1=='rencana' and $params2=='hapus'){

            // Hapus AKTIVITAS
            $this->db->set('aktivitas');
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->delete('aktivitas');

            //Hitung total aktivitas
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '1');
            $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '1');
            $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;

            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_rencana'])));

            // Update data LEMBUR
            $this->db->set('tglselesai_rencana', $tglselesai);
            $this->db->set('durasi_rencana', $totalDJam);
            $this->db->set('aktivitas_rencana', $totalAktivitas);
            $this->db->where('id', $lembur['id']);
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                'durasi' =>  $totalDJam.' Jam'
            );

            //output to json format
            echo json_encode($output);

        }elseif ($params1=='rencana' and $params2=='ubah_durasi'){

            // Hapus AKTIVITAS
            $this->db->set('durasi', $this->input->post('durasi'));
            $this->db->set('durasi_rencana', $this->input->post('durasi'));
            $this->db->set('durasi_menit', floatval($this->input->post('durasi')) * 60);
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->update('aktivitas');

            //Hitung total aktivitas
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '1');
            $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '1');
            $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;

            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_rencana'])));

            // Update data LEMBUR
            $this->db->set('tglselesai_rencana', $tglselesai);
            $this->db->set('durasi_rencana', $totalDJam);
            $this->db->set('aktivitas_rencana', $totalAktivitas);
            $this->db->where('id', $lembur['id']);
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                'durasi' =>  $totalDJam.' Jam'
            );

            //output to json format
            echo json_encode($output);
        }elseif ($params1=='realisasi' and $params2=='update'){

            // Update AKTIVITAS
            $this->db->set('deskripsi_hasil', $this->input->post('deskripsi'));
            $this->db->set('progres_hasil', $this->input->post('progres'));
            $this->db->set('durasi', $this->input->post('durasi'));
            $this->db->set('durasi_menit', floatval($this->input->post('durasi')) * 60);
            $this->db->set('status', '2');
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->update('aktivitas');

            //Hitung total aktivitas
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;

            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));

            // Update data LEMBUR
            $this->db->set('tglselesai', $tglselesai);
            $this->db->set('durasi', $totalDJam);
            $this->db->set('aktivitas', $totalAktivitas);
            $this->db->where('id', $lembur['id']);
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                'durasi' =>  $totalDJam.' Jam'
            );

            //output to json format
            echo json_encode($output);

        }elseif ($params1=='realisasi' and $params2=='tambah'){

                if ($user['work_contract'] == 'Direct Labor')
                {
                    $kategori = $this->input->post('kategori');
                    if ($kategori=='1')
                    {
                        $aktivitas = $this->input->post('aktivitas_projek');
                        $copro = $this->input->post('copro');
                    }elseif ($kategori=='2')
                    {
                        $aktivitas = $this->input->post('aktivitas_direct');
                        if($aktivitas=="DR, Konsep")
                        {
                            $copro = null;
                        }else{
                            $copro = $this->input->post('copro');
                        }
                    }elseif ($kategori=='3')
                    {
                        $aktivitas = $this->input->post('aktivitas_direct');
                        $copro = null;
                    }
                }else{
                    $kategori = '3';
                    $aktivitas = $this->input->post('aktivitas');
                    $copro = null;
                }
    
                $data = [
                    'id' => $lembur['npk'] . time(),
                    'npk' => $lembur['npk'],
                    'tgl_aktivitas' => $lembur['tglmulai'],
                    'jenis_aktivitas' => 'LEMBUR',
                    'link_aktivitas' => $lembur['id'],
                    'kategori' => $kategori,
                    'aktivitas' => $aktivitas,
                    'copro' => $copro,
                    'deskripsi_hasil' => $this->input->post('deskripsi'),
                    'durasi_menit' => floatval($this->input->post('durasi')) * 60,
                    'durasi' => $this->input->post('durasi'),
                    'durasi_rencana' => '0',
                    'progres_hasil' => $this->input->post('progres'),
                    'dibuat_oleh' => $this->session->userdata('inisial'),
                    'dept_id' => $user['dept_id'],
                    'sect_id' => $user['sect_id'],
                    'contract' => $user['work_contract'],
                    'terencana' => '0',
                    'status' => '2'
                ];
                $this->db->insert('aktivitas', $data);
    
                //Hitung total aktivitas
                $this->db->where('link_aktivitas', $lembur['id']);
                $this->db->where('status', '2');
                $this->db->from('aktivitas');
                $totalAktivitas = $this->db->get()->num_rows();
    
                //Hitung total durasi aktivitas
                $this->db->select('SUM(durasi_menit) as total');
                $this->db->where('link_aktivitas', $lembur['id']);
                $this->db->where('status', '2');
                $this->db->from('aktivitas');
                $totalDMenit = $this->db->get()->row()->total;
                $totalDJam = $totalDMenit / 60;
    
                $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));
    
                // Update data LEMBUR
                $this->db->set('tglselesai', $tglselesai);
                $this->db->set('durasi', $totalDJam);
                $this->db->set('aktivitas', $totalAktivitas);
                $this->db->where('id', $lembur['id']);
                $this->db->update('lembur');
    
                $output['data'] = array(
                    'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                    'durasi' =>  $totalDJam.' Jam'
                );
    
                //output to json format
                echo json_encode($output);
        }elseif ($params1=='realisasi' and $params2=='hapus'){

            // Hapus AKTIVITAS
            $this->db->set('aktivitas');
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->delete('aktivitas');

            //Hitung total aktivitas
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;

            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));

            // Update data LEMBUR
            $this->db->set('tglselesai', $tglselesai);
            $this->db->set('durasi', $totalDJam);
            $this->db->set('aktivitas', $totalAktivitas);
            $this->db->where('id', $lembur['id']);
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                'durasi' =>  $totalDJam.' Jam'
            );

            //output to json format
            echo json_encode($output);
        }elseif ($params1=='realisasi' and $params2=='update_hr'){

            // Update AKTIVITAS
            $this->db->set('deskripsi_hasil', $this->input->post('deskripsi'));
            $this->db->set('durasi', $this->input->post('durasi'));
            $this->db->set('durasi_menit', floatval($this->input->post('durasi')) * 60);
            $this->db->set('diubah_oleh', 'Diubah oelh '.$this->session->userdata('inisial'). ' pada '.date('Y-m-d H:i:s'));
            $this->db->set('status', '2');
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->update('aktivitas');

            //Hitung total aktivitas
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;

            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));

            $jammulai = date('H:i', strtotime($lembur['tglmulai']));
            $jamselesai = date('H:i', strtotime($tglselesai));

            if ($lembur['durasi']>=4 AND $jammulai < '12:00' AND $jamselesai > '13:00'){
                $istirahat1 = 1;
            }else{
                $istirahat1 = 0;
            }

            if ($lembur['durasi']>=4 AND $jammulai < '18:30' AND $jamselesai > '19:00'){
                $istirahat2 = 0.5;
            }else{
                $istirahat2 = 0;
            }

            $istirahat = $istirahat1 + $istirahat2 + $lembur['istirahat3'];

            $durasiHR = $totalDJam - $istirahat;
                $this->db->where('durasi', $durasiHR);
                $this->db->where('hari', $lembur['hari']);
            $tul = $this->db->get('lembur_tul')->row();

            // Update data LEMBUR
            $this->db->set('tglselesai', $tglselesai);
            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat1', $istirahat1);
            $this->db->set('istirahat2', $istirahat2);
            $this->db->set('tul', $tul->tul);
            $this->db->set('durasi_hr', $durasiHR);
            $this->db->set('durasi', $totalDJam);
            $this->db->set('aktivitas', $totalAktivitas);
            $this->db->where('id', $lembur['id']);
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                'durasi' =>  $totalDJam.' Jam',
                'istirahat' =>  $istirahat.' Jam',
                'tul' =>  $tul->tul
            );

            //output to json format
            echo json_encode($output);
        }elseif ($params1=='realisasi' and $params2=='hapus_hr'){

            // Hapus AKTIVITAS
            $this->db->set('aktivitas');
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->delete('aktivitas');

            //Hitung total aktivitas
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $lembur['id']);
            $this->db->where('status', '2');
            $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;

            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));

            $jammulai = date('H:i', strtotime($lembur['tglmulai']));
            $jamselesai = date('H:i', strtotime($tglselesai));

            if ($lembur['durasi']>=4 AND $jammulai < '12:00' AND $jamselesai > '13:00'){
                $istirahat1 = 1;
            }else{
                $istirahat1 = 0;
            }

            if ($lembur['durasi']>=4 AND $jammulai < '18:30' AND $jamselesai > '19:00'){
                $istirahat2 = 0.5;
            }else{
                $istirahat2 = 0;
            }

            $istirahat = $istirahat1 + $istirahat2 + $lembur['istirahat3'];

            $durasiHR = $totalDJam - $istirahat;
                $this->db->where('durasi', $durasiHR);
                $this->db->where('hari', $lembur['hari']);
            $tul = $this->db->get('lembur_tul')->row();

            // Update data LEMBUR
            $this->db->set('tglselesai', $tglselesai);
            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat1', $istirahat1);
            $this->db->set('istirahat2', $istirahat2);
            $this->db->set('tul', $tul->tul);
            $this->db->set('durasi_hr', $durasiHR);
            $this->db->set('durasi', $totalDJam);
            $this->db->set('aktivitas', $totalAktivitas);
            $this->db->where('id', $lembur['id']);
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai)),
                'durasi' =>  $totalDJam.' Jam',
                'istirahat' =>  $istirahat.' Jam',
                'tul' =>  $tul->tul
            );

            //output to json format
            echo json_encode($output);
        }elseif ($params1=='realisasi' and $params2=='update_ppic'){

            $kategori = $this->input->post('kategori');
            if ($kategori == '1'){
                $copro = $this->input->post('copro');
            }elseif ($kategori == '2'){
                if($this->input->post('aktivitas')=="DR, Konsep"){
                    $copro = null;
                }else{
                    $copro = $this->input->post('copro');
                }
            }elseif ($kategori == '3'){
                $copro = null;
            }

            // Update AKTIVITAS
            $this->db->set('aktivitas', $this->input->post('aktivitas'));
            $this->db->set('deskripsi_hasil', $this->input->post('deskripsi'));
            $this->db->set('copro', $copro);
            $this->db->set('durasi', $this->input->post('durasi'));
            $this->db->set('progres_hasil', $this->input->post('progres'));
            $this->db->set('durasi_menit', floatval($this->input->post('durasi')) * 60);
            $this->db->set('diubah_oleh', 'Diubah oelh '.$this->session->userdata('inisial'). ' pada '.date('Y-m-d H:i:s'));
            $this->db->set('status', '2');
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->update('aktivitas');

            $output['data'] = array(
                'result' => 'Success'
            );

            //output to json format
            echo json_encode($output);
        }elseif ($params1=='realisasi' and $params2=='tambah_ppic'){

            if ($user['work_contract'] == 'Direct Labor')
            {
                $kategori = $this->input->post('kategori');
                if ($kategori=='1')
                {
                    $aktivitas = $this->input->post('aktivitas_projek');
                    $copro = $this->input->post('copro');
                }elseif ($kategori=='2')
                {
                    $aktivitas = $this->input->post('aktivitas_direct');
                    if($aktivitas=="DR, Konsep")
                    {
                        $copro = null;
                    }else{
                        $copro = $this->input->post('copro');
                    }
                }elseif ($kategori=='3')
                {
                    $aktivitas = $this->input->post('aktivitas_direct');
                    $copro = null;
                }
            }else{
                $kategori = '3';
                $aktivitas = $this->input->post('aktivitas');
                $copro = null;
            }

            $data = [
                'id' => $lembur['npk'] . time(),
                'npk' => $lembur['npk'],
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $lembur['id'],
                'kategori' => $kategori,
                'aktivitas' => $aktivitas,
                'copro' => $copro,
                'deskripsi_hasil' => $this->input->post('deskripsi'),
                'durasi_menit' => floatval($this->input->post('durasi')) * 60,
                'durasi' => $this->input->post('durasi'),
                'progres_hasil' => $this->input->post('progres'),
                'dibuat_oleh' => $this->session->userdata('inisial'),
                'dept_id' => $user['dept_id'],
                'sect_id' => $user['sect_id'],
                'contract' => $user['work_contract'],
                'status' => '2'
            ];
            $this->db->insert('aktivitas', $data);

            $output['data'] = array(
                'result' => 'Success'
            );

            //output to json format
            echo json_encode($output);
        }elseif ($params1=='realisasi' and $params2=='hapus_ppic'){

            // Hapus AKTIVITAS
            $this->db->set('aktivitas');
            $this->db->where('id', $this->input->post('id_aktivitas'));
            $this->db->delete('aktivitas');
            
            $output['data'] = array(
                'result' => 'Success'
            );

            //output to json format
            echo json_encode($output);
        }else{

        }

    }


    public function tambah_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $kry = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        $copro = $this->input->post('copro');
        $aktivitas = $this->input->post('aktivitas');

        // $durasiPost = $this->input->post('durasi');
        // $durasi_jam = $durasiPost / 60;

        if ($copro) {
            $id = $copro . $lembur['npk'] . time();
        }else{
            $id = date('ymd') . $lembur['npk'] . time();
        }

        if($aktivitas=="DR, Konsep"){
            $copro = null;
        }
            $data = [
                'id' => $id,
                'npk' => $lembur['npk'],
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $copro,
                'aktivitas' => $this->input->post('aktivitas'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => intval($this->input->post('durasi')) / 60,
                'deskripsi_hasil' => '',
                'progres_hasil' => '0',
                'dibuat_oleh' => $this->session->userdata('inisial'),
                'dept_id' => $kry['dept_id'],
                'sect_id' => $kry['sect_id'],
                'contract' => $kry['work_contract'],
                'status' => '1'
            ];
            $this->db->insert('aktivitas', $data);

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_rencana'])));
        
        // $mulai = strtotime($lembur['tglmulai']);
        // $selesai = strtotime($tglselesai);
        // $durasi = $selesai - $mulai;
        // $jam   = floor($durasi / (60 * 60));
        // $menit = $durasi - $jam * (60 * 60);
        // $menit = floor($menit / 60);

        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai_rencana', $tglselesai);
        $this->db->set('durasi_rencana', $totalDJam);
        $this->db->set('aktivitas_rencana', $totalAktivitas);
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        if($lembur['status']=='1'){
            redirect('lembur/rencana_aktivitas/' . $this->input->post('link_aktivitas'));
        }
        else if ($lembur['status']=='2' OR $lembur['status']=='3' OR $lembur['status']=='5' OR $lembur['status']=='6'){
            redirect('lembur/persetujuan_rencana/' . $this->input->post('link_aktivitas'));
        }
    }

    public function update_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();
       
        $this->db->set('aktivitas', $this->input->post('aktivitas'));
        $this->db->set('durasi_menit', $this->input->post('durasi'));
        $this->db->set('durasi', intval($this->input->post('durasi')) / 60);
        $this->db->set('diubah_oleh', $this->session->userdata('inisial'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('aktivitas');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));
        
        // Update data LEMBUR
        $this->db->set('tglselesai_rencana', $tglselesai);
        $this->db->set('durasi_rencana', $totalDJam);
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        redirect('lembur/persetujuan_rencana/' . $this->input->post('link_aktivitas'));
    }

    public function hapus_aktivitas($id)
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $aktivitas['link_aktivitas']])->row_array();

        // Hapus AKTIVITAS
        $this->db->set('aktivitas');
        $this->db->where('id', $id);
        $this->db->delete('aktivitas');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        if ($totalDMenit == 0)
        {
            $tglselesai = $lembur['tglmulai'];
        }else{
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));
        }
        
        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai_rencana', $tglselesai);
        $this->db->set('durasi_rencana', $totalDJam);
        $this->db->set('aktivitas_rencana', $totalAktivitas);
        $this->db->where('id', $aktivitas['link_aktivitas']);
        $this->db->update('lembur');

            if($lembur['status']=='1'){
                // $this->session->set_flashdata('message', 'hapus');
                redirect('lembur/rencana_aktivitas/' . $aktivitas['link_aktivitas']);
            }
            else if ($lembur['status']=='2' OR $lembur['status']=='3'){
                // $this->session->set_flashdata('message', 'hapus');
                redirect('lembur/persetujuan_rencana/' . $aktivitas['link_aktivitas']);
            }
            elseif ($lembur['status']=='7'){
                redirect('lembur/konfirmasi/hr/' . $this->input->post('link_aktivitas'));
            }
    }

    public function tambah_aktivitas_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $kry = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        $copro = $this->input->post('copro');
        $aktivitas = $this->input->post('aktivitas');

        if ($copro) {
            $id = $copro . $lembur['npk'] . time();
        }else{
            $id = date('ymd') . $lembur['npk'] . time();
        }

        if($aktivitas=="DR, Konsep"){
            $copro = null;
        }

        if($lembur['kategori']=='OT'){
            $jenis = 'LEMBUR';
        }else{
            $jenis = 'JAM KERJA';
        }

            $data = [
                'id' => $id,
                'npk' => $lembur['npk'],
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => $jenis,
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $copro,
                'aktivitas' =>  $this->input->post('aktivitas'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => intval($this->input->post('durasi')) / 60,
                'deskripsi_hasil' => $this->input->post('deskripsi_hasil'),
                'progres_hasil' => $this->input->post('progres_hasil'),
                'dibuat_oleh' => $this->session->userdata('inisial'),
                'dept_id' => $kry['dept_id'],
                'sect_id' => $kry['sect_id'],
                'contract' => $kry['work_contract'],
                'status' => '2'
            ];
            $this->db->insert('aktivitas', $data);

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('status', '2');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));
        
        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->where('status', '2');
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi', $totalDJam);
        $this->db->set('aktivitas', $totalAktivitas);
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        if($lembur['status']=='4'){
            redirect('lembur/realisasi_aktivitas/' . $this->input->post('link_aktivitas'));
        }
        elseif ($lembur['status']=='5' OR $lembur['status']=='6'){
            redirect('lembur/persetujuan_realisasi/' . $this->input->post('link_aktivitas'));
        }
        elseif ($lembur['status']=='7'){
            redirect('lembur/proses/hr/' . $this->input->post('link_aktivitas'));
        }
    }

    public function update_aktivitas_realisasi($params=null)
    {
        date_default_timezone_set('asia/jakarta');
        if ($params==null){

        }elseif ($params=='hr'){
            $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row_array();
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link')])->row_array();

            $this->db->set('deskripsi_hasil', $this->input->post('deskripsi'));
            $this->db->set('durasi', $this->input->post('durasi'));
            $this->db->set('durasi_menit', floatval($this->input->post('durasi')) * 60);
            $this->db->set('diubah_oleh', $this->session->userdata('inisial'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('aktivitas');

            //Hitung total aktivitas
                $this->db->where('link_aktivitas', $this->input->post('link'));
                $this->db->where('status', '2');
                $this->db->from('aktivitas');
            $totalAktivitas = $this->db->get()->num_rows();

            //Hitung total durasi aktivitas
                $this->db->select('SUM(durasi_menit) as total');
                $this->db->where('link_aktivitas', $this->input->post('link'));
                $this->db->where('status', '2');
                $this->db->from('aktivitas');
            $totalDMenit = $this->db->get()->row()->total;

            $totalDJam = $totalDMenit / 60;
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));

            $jammulai = date('H:i', strtotime($lembur['tglmulai']));
            $jamselesai = date('H:i', strtotime($tglselesai));

            if ($totalDJam >=4 AND $jammulai < '12:00' AND $jamselesai > '13:00'){
                $istirahat1 = 1;
            }else{
                $istirahat1 = 0;
            }
            if ($totalDJam >=4 AND $jammulai < '18:30' AND $jamselesai > '19:00'){
                $istirahat2 = 0.5;
            }else{
                $istirahat2 = 0;
            }

            $istirahat = $istirahat1 + $istirahat2 + $lembur['istirahat3'];

            $durasi = $totalDJam - $istirahat;
                $this->db->where('durasi', $durasi);
                $this->db->where('hari', $lembur['hari']);
            $tul = $this->db->get('lembur_tul')->row();

            // Update data LEMBUR
            $this->db->set('tglselesai', $tglselesai);
            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat1', $istirahat1);
            $this->db->set('istirahat2', $istirahat2);
            $this->db->set('durasi', $totalDJam);
            $this->db->set('durasi_hr', $durasi);
            $this->db->set('tul', $tul->tul);
            $this->db->set('aktivitas', $totalAktivitas);
            $this->db->where('id', $this->input->post('link'));
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($lembur['tglmulai'])).date(' - H:i', strtotime($tglselesai))
            );

            //output to json format
            echo json_encode($output);
        
        }else{
            $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row_array();
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();

            if($lembur['kategori']=='OT'){
                $jenis = 'LEMBUR';
            }else{
                $jenis = 'JAM KERJA';
            }

            $this->db->set('jenis_aktivitas', $jenis);
            $this->db->set('deskripsi_hasil', $this->input->post('deskripsi_hasil'));
            $this->db->set('durasi_menit', $this->input->post('durasi'));
            $this->db->set('durasi', intval($this->input->post('durasi')) / 60);
            $this->db->set('progres_hasil', $this->input->post('progres_hasil'));
            $this->db->set('status', '2');
            $this->db->set('diubah_oleh', $this->session->userdata('inisial'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('aktivitas');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('status', '2');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));
        
        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->where('status', '2');
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi', $totalDJam);
        $this->db->set('aktivitas', $totalAktivitas);
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        
            if ($lembur['status']=='4'){
                redirect('lembur/realisasi_aktivitas/' . $this->input->post('link_aktivitas'));
            } elseif ($lembur['status']=='7'){
                redirect('lembur/proses/hr/' . $this->input->post('link_aktivitas'));
            }
        }
    }

    public function hapus_aktivitas_realisasi($id)
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $aktivitas['link_aktivitas']])->row_array();

        $this->db->set('aktivitas');
        $this->db->where('id', $id);
        $this->db->delete('aktivitas');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('status', '2');
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));
        
        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->where('status', '2');
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi', $totalDJam);
        $this->db->set('aktivitas', $totalAktivitas);
        $this->db->where('id', $lembur['id']);
        $this->db->update('lembur');

        if($lembur['status']=='4'){
            // $this->session->set_flashdata('message', 'hapus');
            redirect('lembur/realisasi_aktivitas/' . $lembur['id']);
        } elseif ($lembur['status']=='7'){
            // $this->session->set_flashdata('message', 'hapus');
            redirect('lembur/proses/hr/' . $lembur['id']);
        }
    }

    public function ajukan_rencana()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $expired = date('Y-m-d H:i:s', strtotime('+2 days', strtotime($lembur['tglmulai'])));

        if ($this->input->post('lokasi') != 'lainnya')
        {
            $lokasi = $this->input->post('lokasi');
        }else{
            $lokasi = $this->input->post('lokasi_lain');
        }

        if ($lembur['npk'] == $this->session->userdata('npk')) 
        {
            //Accept Perintah LEMBUR dari Atasan 1
            //fitur ini sementara off
            if ($lembur['pemohon'] == $lembur['atasan1']){

                $this->db->set('kategori', $this->input->post('kategori_lembur'));
                $this->db->set('lokasi', $lokasi);
                $this->db->set('catatan', $this->input->post('catatan'));
                $this->db->set('expired_at', $expired);
                $this->db->set('status', '3');
                $this->db->set('last_notify', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
    
                // Notification saat mengajukan RENCANA to ATASAN 2
                // $karyawan = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2_rencana']])->row_array();
                // $client = new \GuzzleHttp\Client();
                // $response = $client->post(
                //     'https://region01.krmpesan.com/api/v2/message/send-text',
                //     [
                //         'headers' => [
                //             'Content-Type' => 'application/json',
                //             'Accept' => 'application/json',
                //             'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                //         ],
                //         'json' => [
                //             'phone' => $karyawan['phone'],
                //             'message' => "*PENGAJUAN RENCANA LEMBUR*" .
                //             "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                //             "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                //             "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
                //             "\r\n \r\nRENCANA LEMBUR ini telah DISETUJUI oleh *". $lembur['atasan1_rencana'] ."*".
                //             "\r\nHarap segera respon *Setujui/Batalkan*".
                //             "\r\n \r\n*Semakin lama kamu merespon, semakin sedikit waktu tim kamu membuat realisasi*".
                //             "\r\n Untuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                //         ],
                //     ]
                // );
                // $body = $response->getBody();

            }else{
                
                //Submit RENCANA Lembur to Atasan 1
                
                $this->db->set('tglpengajuan_rencana', date('Y-m-d H:i:s'));
                $this->db->set('kategori', $this->input->post('kategori_lembur'));
                $this->db->set('lokasi', $lokasi);
                $this->db->set('catatan', $this->input->post('catatan'));
                $this->db->set('expired_at', $expired);
                $this->db->set('status', '2');
                $this->db->set('last_notify', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
    
                // Notification saat mengajukan RENCANA to ATASAN 1
                $atasan1 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1']])->row_array();

                $client = new \GuzzleHttp\Client();
                $options = [
                'form_params' => [
                    'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
                    'number' => $atasan1['phone'],
                    'message' => "*PENGAJUAN RENCANA LEMBUR*" .
                                "\r\n \r\n👤 : *" . $lembur['nama'] . "*" .
                                "\r\n🗓 : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                                "\r\n🕗 : " . $lembur['durasi_rencana'] ." Jam " .
                                "\r\n\r\nBatal otomatis pada *" . date('d-M H:i', strtotime($expired)) . "*",
                    'date' => date('Y-m-d'),
                    'time' => date(' H:i:s')
                ]];
                $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
                $res = $client->sendAsync($request, $options)->wait();
                echo $res->getBody();

            }

        }else{

            //Submit Perintah lembur to TIM
            //fitur ini sementara off
            $this->db->set('tglpengajuan_rencana', date('Y-m-d H:i:s'));
            $this->db->set('atasan1_rencana','Approved by '.$this->session->userdata('inisial'));
            $this->db->set('kategori', $this->input->post('kategori_lembur'));
            $this->db->set('lokasi', $lokasi);
            $this->db->set('catatan', $this->input->post('catatan'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            // Notification saat mengajukan RENCANA to BAWAHAN 1
            // $karyawan = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
            // $client = new \GuzzleHttp\Client();
            // $response = $client->post(
            //     'https://region01.krmpesan.com/api/v2/message/send-text',
            //     [
            //         'headers' => [
            //             'Content-Type' => 'application/json',
            //             'Accept' => 'application/json',
            //             'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
            //         ],
            //         'json' => [
            //             'phone' => $karyawan['phone'],
            //             'message' => "*PERINTAH RENCANA LEMBUR*" .
            //             "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
            //             "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
            //             "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
            //             "\r\n \r\nHarap segera respon *Terima/Batalkan*".
            //             "\r\n \r\nRespon sebelum jam 4 sore agar kamu *dipesankan makan malamnya".
            //             "\r\nKalau kamu belum respon, kamu tidak bisa melakukan realisasi".
            //             "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
            //         ],
            //     ]
            // );
            // $body = $response->getBody();
        }
       
        redirect('lembur/rencana/');
    }

    public function ajukan_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $expired = date('Y-m-d H:i:s', strtotime('+7 days', strtotime($lembur['tglmulai'])));

        $this->db->set('tglpengajuan_realisasi', date('Y-m-d H:i:s'));
        $this->db->set('status', 5);
        $this->db->set('expired_at', $expired);
        $this->db->set('last_notify', date('Y-m-d H:i:s'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        // Notification saat mengajukan REALISASI to ATASAN 1
        $atasan1 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1']])->row_array();
        $client = new \GuzzleHttp\Client();
        $options = [
            'form_params' => [
                'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
                'number' => $atasan1['phone'],
                'message' => "*PENGAJUAN REALISASI LEMBUR*" .
                            "\r\n \r\n👤 : *" . $lembur['nama'] . "*" .
                            "\r\n🗓 : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                            "\r\n🕗 : " . $lembur['durasi'] ." Jam " .
                            "\r\n\r\nBatal otomatis pada *" . date('d-M H:i', strtotime($expired)) . "*",
                'date' => date('Y-m-d'),
                'time' => date(' H:i:s')
            ]
        ];
        $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
        $res = $client->sendAsync($request, $options)->wait();
        echo $res->getBody();


        redirect('lembur/realisasi/');
    }

    public function persetujuan($params=null, $id=null)
    {
        date_default_timezone_set('asia/jakarta');
        if ($params==null AND $id==null){
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
                $queryRencanaLembur = "SELECT *
                FROM `lembur`
                WHERE(`atasan1` = '{$karyawan['inisial']}' AND `status`= '2') OR (`atasan2` = '{$karyawan['inisial']}' AND `status`= '3') ";
                $data['rencana'] = $this->db->query($queryRencanaLembur)->result_array();
    
                $queryRealisasiLembur = "SELECT *
                FROM `lembur`
                WHERE(`atasan1` = '{$karyawan['inisial']}' AND `status`= '5') OR (`atasan2` = '{$karyawan['inisial']}' AND `status`= '6') ";
                $data['realisasi'] = $this->db->query($queryRealisasiLembur)->result_array();
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuan/index', $data);
            $this->load->view('templates/footer');

        }elseif ($params=='rencana' AND $id!=null){
            $lembur = $this->db->get_where('lembur', ['id' => $id])->row_array();
            if ($lembur){
                if ($lembur['atasan1']==$this->session->userdata('inisial') OR $lembur['atasan2']==$this->session->userdata('inisial'))
                {
                    $data['sidemenu'] = 'Lembur';
                    $data['sidesubmenu'] = 'Persetujuan';
                    $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                    $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('lembur/persetujuan/rencana', $data);
                    $this->load->view('templates/footer');
                } else 
                {
                    redirect('lembur/persetujuan');
                }
            } else 
            {
                redirect('lembur/persetujuan');
            }
        }elseif ($params=='realisasi' AND $id!=null){
            $lembur = $this->db->get_where('lembur', ['id' => $id])->row_array();
            if ($lembur){
                if ($lembur['atasan1']==$this->session->userdata('inisial') OR $lembur['atasan2']==$this->session->userdata('inisial'))
                {
                    $data['sidemenu'] = 'Lembur';
                    $data['sidesubmenu'] = 'Persetujuan';
                    $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                    $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('lembur/persetujuan/realisasi', $data);
                    $this->load->view('templates/footer');
                } else 
                {
                    redirect('lembur/persetujuan');
                }
            } else 
            {
                redirect('lembur/persetujuan');
            }

        }

    }

    public function persetujuan_lembur()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Persetujuan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        // if ($this->session->userdata('posisi_id') >= 3 AND $this->session->userdata('posisi_id') <= 6) 
        // {

            $queryRencanaLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1` = '{$karyawan['inisial']}' AND `status`= '2') OR (`atasan2` = '{$karyawan['inisial']}' AND `status`= '3') ";
            $data['rencana'] = $this->db->query($queryRencanaLembur)->result_array();

            $queryRealisasiLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1` = '{$karyawan['inisial']}' AND `status`= '5') OR (`atasan2` = '{$karyawan['inisial']}' AND `status`= '6') ";
            $data['realisasi'] = $this->db->query($queryRealisasiLembur)->result_array();

        // } 
        // else if ($this->session->userdata('posisi_id') == 2) 
        // {
        //     $queryRencanaLembur = "SELECT *
        //     FROM `lembur`
        //     WHERE `atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '3' AND `sect_id`= 200 ";
        //     $data['rencana'] = $this->db->query($queryRencanaLembur)->result_array();

        //     $queryLembur = "SELECT *
        //     FROM `lembur`
        //     WHERE `atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '6' AND `sect_id`= 200 ";
        //     $data['lembur'] = $this->db->query($queryLembur)->result_array();
        // } 
        // else 
        // {
        //     $this->load->view('auth/denied');
        // }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuan_lembur', $data);
        $this->load->view('templates/footer');
    }

    public function setujui_rencana()
    {
        date_default_timezone_set('asia/jakarta');
        $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        
        // Persetujuan Koordinator / Section Head 
        if ($this->session->userdata('posisi_id') == 4 or $this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('atasan1_rencana', 'Disetujui oleh '.$this->session->userdata('inisial'));
            $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
            $this->db->set('status', '3');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            //Notifikasi ke ATASAN 2
            $atasan2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2']])->row_array();
            $client = new \GuzzleHttp\Client();
                $options = [
                'form_params' => [
                'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
                'number' => $atasan2['phone'],
                'message' => "*PENGAJUAN RENCANA LEMBUR*" .
                            "\r\n \r\n👤 : *" . $lembur['nama'] . "*" .
                            "\r\n🗓 : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                            "\r\n🕗 : " . $lembur['durasi_rencana'] ." Jam " .
                            "\r\n \r\nRENCANA LEMBUR ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*",
                'date' => date('Y-m-d'),
                'time' => date(' H:i:s')
                ]];
                $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
                $res = $client->sendAsync($request, $options)->wait();
                echo $res->getBody();

        } 

        // Persetujuan Dept Head UP
        else if ($this->session->userdata('posisi_id') == 3 or $this->session->userdata('posisi_id') == 2 or $this->session->userdata('posisi_id') == 1) {
            
            if ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                $this->db->set('atasan1_rencana', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                $this->db->set('atasan2_rencana', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] != $this->session->userdata('inisial')) {
                $this->db->set('atasan1_rencana', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1'] != $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                $this->db->set('atasan2_rencana', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            }

            if ($this->input->post('mch_kategori')){
                $this->db->set('mch_kategori', $this->input->post('mch_kategori'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            }

            //Notifikasi ke USER
            // $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
            // $client = new \GuzzleHttp\Client();
            // $response = $client->post(
            //     'https://region01.krmpesan.com/api/v2/message/send-text',
            //     [
            //         'headers' => [
            //             'Content-Type' => 'application/json',
            //             'Accept' => 'application/json',
            //             'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
            //         ],
            //         'json' => [
            //             'phone' => $user['phone'],
            //             'message' => "*HOREEE!! RENCANA LEMBUR KAMU SUDAH DISETUJUI*" .
            //             "\r\n \r\n*RENCANA LEMBUR* kamu dengan detil berikut :" .
            //             "\r\n \r\nTanggal " . date('d-M H:i', strtotime($lembur['tglmulai_rencana'])) . 
            //             "\r\nDurasi " . $lembur['durasi_rencana'] ." Jam " . 
            //             "\r\n \r\nTelah disetujui oleh *" . $this->session->userdata('inisial') . "*" .
            //             "\r\nManfaatkan waktu lembur kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
            //             "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI LEMBUR* kamu jika sudah selesai lemburnya ya!." .
            //             "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" .
            //             "\r\n \r\n" . $notifikasi['pesan']
            //         ],
            //     ]
            // );
            // $body = $response->getBody();
        }

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan');
    }

    public function setujui_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        // Persetujuan Koordinator / Section Head 
        if ($this->session->userdata('posisi_id') == 4 or $this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('atasan1_realisasi', 'Disetujui oleh '.$this->session->userdata('inisial'));
            $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
            $this->db->set('status', '6');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            // Notifikasi ke ATASAN 2
            $atasan2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2']])->row_array();
            if (!empty($atasan2)){
                $client = new \GuzzleHttp\Client();
                $options = [
                'form_params' => [
                'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
                'number' => $atasan2['phone'],
                'message' => "*PENGAJUAN RENCANA LEMBUR*" .
                            "\r\n \r\n👤 : *" . $lembur['nama'] . "*" .
                            "\r\n🗓 : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                            "\r\n🕗 : " . $lembur['durasi'] ." Jam " .
                            "\r\n \r\nRENCANA LEMBUR ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*",
                'date' => date('Y-m-d'),
                'time' => date(' H:i:s')
                ]];
                $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
                $res = $client->sendAsync($request, $options)->wait();
                echo $res->getBody();


                // $client = new \GuzzleHttp\Client();
                // $response = $client->post(
                //     'https://region01.krmpesan.com/api/v2/message/send-text',
                //     [
                //         'headers' => [
                //             'Content-Type' => 'application/json',
                //             'Accept' => 'application/json',
                //             'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                //         ],
                //         'json' => [
                //             'phone' => $atasan2['phone'],
                //             'message' => "*PENGAJUAN REALISASI LEMBUR*" .
                //             "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                //             "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                //             "\r\nDurasi : " . $lembur['durasi'] ." Jam " .
                //             "\r\n \r\nREALISASI LEMBUR ini telah disetujui oleh *". $this->session->userdata('inisial') ."*".
                //             "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                //         ],
                //     ]
                // );
                // $body = $response->getBody();
            }
        } 
        // Persetujuan Dept Head 
        elseif ($this->session->userdata('posisi_id') == 3 or $this->session->userdata('posisi_id') == 2 or $this->session->userdata('posisi_id') == 1) {
            if ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                $this->db->set('atasan1_realisasi', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('atasan2_realisasi', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] != $this->session->userdata('inisial')) {
                $this->db->set('atasan1_realisasi', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1'] != $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                $this->db->set('atasan2_realisasi', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            }
        }
        
        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan');
    }

    public function reject($params)
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id_lembur_batal')])->row_array();
        $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        if ($params=='rencana'){
            // Persetujuan Koordinator / Section Head 
            if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
                $this->db->set('atasan1_rencana', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                $this->db->set('status', '0');
                $this->db->where('id', $this->input->post('id_lembur_batal'));
                $this->db->update('lembur');
            }elseif ($this->session->userdata('posisi_id') == 3 or $this->session->userdata('posisi_id') == 2 or $this->session->userdata('posisi_id') == 1) {
                if ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                    $this->db->set('atasan1_rencana', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                    $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                    $this->db->set('atasan2_rencana', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                    $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                    $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                    $this->db->set('status', '0');
                    $this->db->where('id', $this->input->post('id_lembur_batal'));
                    $this->db->update('lembur');
                } elseif ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] != $this->session->userdata('inisial')) {
                    $this->db->set('atasan1_rencana', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                    $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                    $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                    $this->db->set('status', '0');
                    $this->db->where('id', $this->input->post('id_lembur_batal'));
                    $this->db->update('lembur');
                } elseif ($lembur['atasan1'] != $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                    $this->db->set('atasan2_rencana', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                    $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                    $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                    $this->db->set('status', '0');
                    $this->db->where('id', $this->input->post('id_lembur_batal'));
                    $this->db->update('lembur');
                }

                //Notifikasi ke ATASAN 2
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                'https://region01.krmpesan.com/api/v2/message/send-text',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                    ],
                    'json' => [
                        'phone' => $user['phone'],
                        'message' => "*RENCANA LEMBUR KAMU DIBATALKAN*" .
                        "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                        "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                        "\r\nDurasi : " . $lembur['durasi'] ." Jam " .
                        "\r\n \r\nREALISASI LEMBUR ini telah dibatalkan oleh *". $this->session->userdata('inisial') ."*".
                        "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();

            }
        }elseif ($params=='realisasi'){
            // Persetujuan Koordinator / Section Head 
                if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
                    $this->db->set('atasan1_realisasi', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                    $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                    $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                    $this->db->set('status', '0');
                    $this->db->where('id', $this->input->post('id_lembur_batal'));
                    $this->db->update('lembur');
                }elseif ($this->session->userdata('posisi_id') == 3 or $this->session->userdata('posisi_id') == 2 or $this->session->userdata('posisi_id') == 1) {
                    if ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                        $this->db->set('atasan1_realisasi', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                        $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                        $this->db->set('atasan2_realisasi', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                        $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                        $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                        $this->db->set('status', '0');
                        $this->db->where('id', $this->input->post('id_lembur_batal'));
                        $this->db->update('lembur');
                    } elseif ($lembur['atasan1'] == $this->session->userdata('inisial') AND $lembur['atasan2'] != $this->session->userdata('inisial')) {
                        $this->db->set('atasan1_realisasi', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                        $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                        $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                        $this->db->set('status', '0');
                        $this->db->where('id', $this->input->post('id_lembur_batal'));
                        $this->db->update('lembur');
                    } elseif ($lembur['atasan1'] != $this->session->userdata('inisial') AND $lembur['atasan2'] == $this->session->userdata('inisial')) {
                        $this->db->set('atasan2_realisasi', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                        $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                        $this->db->set('catatan', $this->input->post('catatan').' - Dibatalkan oleh '.$this->session->userdata('inisial').' pada '.date('Y-m-d H:i:s'));
                        $this->db->set('status', '0');
                        $this->db->where('id', $this->input->post('id_lembur_batal'));
                        $this->db->update('lembur');
                    }
                }
    
                //Notifikasi ke ATASAN 2
                $client = new \GuzzleHttp\Client();
                $response = $client->post(
                    'https://region01.krmpesan.com/api/v2/message/send-text',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                        ],
                        'json' => [
                            'phone' => $user['phone'],
                            'message' => "*REALISASI LEMBUR KAMU DIBATALKAN*" .
                            "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                            "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                            "\r\nDurasi : " . $lembur['durasi'] ." Jam " .
                            "\r\n \r\nREALISASI LEMBUR ini telah dibatalkan oleh *". $this->session->userdata('inisial') ."*".
                            "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();

        }

        $this->db->set('status', '0');
        $this->db->where('link_aktivitas', $this->input->post('id_lembur_batal'));
        $this->db->update('aktivitas');
        
        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan');
    }

    public function batal_lembur()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
        $this->db->set('catatan', $this->input->post('catatan') . " - Dibatalkan oleh : " . $this->session->userdata['inisial'] ." pada " . date('d-m-Y H:i'));
        $this->db->set('last_status', $lembur['status']);
        $this->db->set('status', 0);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        $this->db->set('status', 0);
        $this->db->where('link_aktivitas', $this->input->post('id'));
        $this->db->update('aktivitas');

        if($lembur['status']=='1'){
            $this->session->set_flashdata('message', 'batalbr');
            redirect('lembur/rencana/');
        }
        else if ($lembur['status']=='4'){
            $this->session->set_flashdata('message', 'batalbr');
            redirect('lembur/realisasi/');
        }
        else if ($lembur['status']=='2' OR $lembur['status']=='3' OR $lembur['status']=='5' OR $lembur['status']=='6'){
            $this->session->set_flashdata('message', 'batalbr');
            redirect('lembur/persetujuan_lembur/');
        }
        elseif ($lembur['status']=='7'){
            redirect('lembur/persetujuan_lemburhr');
        }
    }

    public function revisi_lembur()
    {
        date_default_timezone_set('asia/jakarta');
            $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
            $this->db->set('catatan', $this->input->post('catatan')." - ". $this->session->userdata('inisial'));
            $this->db->set('status', 4);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            redirect('lembur/persetujuan_lembur');
    }

    public function konfirmasi($section)
    {
        date_default_timezone_set('asia/jakarta');
        if ($section=='ga'){
            $data['sidemenu'] = 'GA';
            $data['sidesubmenu'] = 'Konfirmasi Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $today = date('d');
            $bulan = date('m');
            $tahun = date('Y');
    
            $this->db->where('year(tglmulai) >=',$tahun);
            $this->db->where('month(tglmulai) >=',$bulan);
            $this->db->where('day(tglmulai) >=',$today);
            $this->db->where('admin_ga',null);
            $this->db->where('status >', '2');
            $this->db->order_by('tglmulai', 'ASC');
            $data['lembur'] = $this->db->get('lembur')->result_array();
    
            $this->db->where('year(tglmulai) >=',$tahun);
            $this->db->where('month(tglmulai) >=',$bulan);
            $this->db->where('day(tglmulai) >=',$today);
            $this->db->where('admin_ga !=',null);
            $this->db->where('status >', '2');
            $data['lembur_konfirmasi'] = $this->db->get('lembur')->result_array();
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanga', $data);
            $this->load->view('templates/footer');
        }elseif ($section=='hr'){
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Konfirmasi Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['status' => '7'])->result_array();
            $data['lembur_ssc'] = $this->db->get_where('lembur', ['status' => '8'])->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/hr/index', $data);
            $this->load->view('templates/footer');
        }elseif ($section=='ppic'){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Konfirmasi Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['status' => '8'])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/ppic/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function proses($section,$id)
    {
        date_default_timezone_set('asia/jakarta');
        if ($section=='hr'){
            $data['sidemenu'] = 'HR Lembur';
            $data['sidesubmenu'] = 'Approval Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' => $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/hr/konfirmasi', $data);  
            $this->load->view('templates/footer');
        }elseif ($section=='ppic'){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Konfirmasi Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' => $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();
            // $data['listproject'] = $this->project_model->fetch_project();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/ppic/konfirmasi', $data);  
            $this->load->view('templates/footer');
        }
    }

    public function submit_konfirmasi_ga()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();

        $this->db->set('admin_ga', $this->session->userdata('inisial'));
        $this->db->set('tgl_admin_ga', date('Y-m-d  H:i:s'));
        $this->db->set('konsumsi', $this->input->post('konsumsi'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        // if ($this->input->post('konsumsi')!=0)
        // {
        //     //Notifikasi ke USER
        //     $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        //     $konsumsi = $this->db->get_where('lembur_konsumsi', ['id' => $this->input->post('konsumsi')])->row_array();
        //     $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        //     $client = new \GuzzleHttp\Client();
        //     $response = $client->post(
        //         'https://region01.krmpesan.com/api/v2/message/send-text',
        //         [
        //             'headers' => [
        //                 'Content-Type' => 'application/json',
        //                 'Accept' => 'application/json',
        //                 'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
        //             ],
        //             'json' => [
        //                 'phone' => $user['phone'],
        //                 'message' => "*HOREEE!! RENCANA LEMBUR KAMU SUDAH DIKONFIRMASI OLEH GA*" .
        //                 "\r\n \r\n*RENCANA LEMBUR* kamu dengan detil berikut :" .
        //                 "\r\n \r\nID *" . $lembur['id'] .'*'. 
        //                 "\r\nTanggal " . date('d-M H:i', strtotime($lembur['tglmulai_rencana'])) . 
        //                 "\r\nDurasi " . $lembur['durasi_rencana'] ." Jam " . 
        //                 "\r\nKonsumsi " . $konsumsi['nama'] . 
        //                 "\r\nTelah konfirmasi oleh *" . $this->session->userdata('inisial') . "*" .
        //                 "\r\n \r\nManfaatkan waktu lembur kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
        //                 "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI LEMBUR* kamu jika sudah selesai lemburnya ya!." .
        //                 "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" .
        //                 "\r\n \r\n" . $notifikasi['pesan']
        //             ],
        //         ]
        //     );
        //     $body = $response->getBody();
        // }

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('lembur/konfirmasi/ga');
    }

    public function copro()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('id');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $aktivitas['link_aktivitas']])->row_array();

        $this->db->set('diubah_oleh', $this->session->userdata('inisial'));
        $this->db->set('copro', $this->input->post('copro'));
        $this->db->where('id', $id);
        $this->db->update('aktivitas');

        redirect('lembur/proses/ppic/'.$lembur['id']);
    }

    public function persetujuan_rencana($id)
    {
        $lembur = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        if ($lembur['atasan1']==$this->session->userdata('inisial') OR $lembur['atasan2']==$this->session->userdata('inisial'))
        {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuan_rencana', $data);
            $this->load->view('templates/footer');
        } else 
        {
            $this->persetujuan_lembur();
        }
    }

    public function persetujuan_realisasi($id)
    {
        $lembur = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        if (($lembur['atasan1']==$this->session->userdata('inisial') AND $lembur['status']==5) OR ($lembur['atasan2']==$this->session->userdata('inisial') AND $lembur['status']==6))
        {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Realisasi';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuan_realisasi', $data);
            $this->load->view('templates/footer');
        } else 
        {
            $this->persetujuan_lembur();
        }
    }

    public function persetujuan_hr()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
    
        if ($lembur['contract']=='Direct Labor'){ 
            $this->db->set('admin_hr', $this->session->userdata('inisial'));
            $this->db->set('tgl_admin_hr', date('Y-m-d H:i:s'));
            $this->db->set('status', '8');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        }else{
            $this->db->set('admin_hr', $this->session->userdata('inisial'));
            $this->db->set('tgl_admin_hr', date('Y-m-d H:i:s'));
            $this->db->set('status', '9');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->db->set('tglmulai', $lembur['tglmulai']);
            $this->db->set('tglselesai', $lembur['tglselesai']);
            $this->db->set('status', 9);
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->update('aktivitas');
        }

        //Notifikasi ke USER
        // $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        // $client = new \GuzzleHttp\Client();
        // $response = $client->post(
        //     'https://region01.krmpesan.com/api/v2/message/send-text',
        //     [
        //         'headers' => [
        //             'Content-Type' => 'application/json',
        //             'Accept' => 'application/json',
        //             'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
        //         ],
        //         'json' => [
        //             'phone' => $user['phone'],
        //             'message' => "*LEMBUR KAMU TELAH DIKONFIRMASI OLEH HR*" .
        //             "\r\n \r\n*LEMBUR* kamu dengan detil berikut :" . 
        //             "\r\n \r\n# : *" . $lembur['id'] .'*'. 
        //             "\r\nWaktu : *" . date('d-M H:i', strtotime($lembur['tglmulai'])) ." - " . date('d-M H:i', strtotime($lembur['tglselesai'])) .'*'. 
        //             "\r\nDurasi (Istirahat) : *" . $lembur['durasi_hr'] ." Jam ( " . $lembur['istirahat'] ." Jam )* " . 
        //             "\r\nEstimasi TUL : *" . $lembur['tul'] .'*'. 
        //             "\r\nTelah konfirmasi oleh *" . $this->session->userdata('inisial') . "*" .
        //             "\r\n \r\nNote : Hitungan ini belum dicocokan dengan *PRESENSI* kamu Loh." . 
        //             "\r\nJadi ini masih *Estimasi* ya!. Hasil final sangat mungkin berbeda dari ini." .
        //             "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
        //         ],
        //     ]
        // );
        // $body = $response->getBody();

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/konfirmasi/hr');
    }

    public function persetujuan_ppic()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();

        $this->db->set('status', 9);
        $this->db->where('link_aktivitas', $this->input->post('id'));
        $this->db->update('aktivitas');

        $this->db->set('admin_ppic', $this->session->userdata('inisial'));
        $this->db->set('tgl_admin_ppic', date('Y-m-d H:i:s'));
        $this->db->set('status', '9');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/konfirmasi/ppic');
    }

    public function laporan_lembur($id)
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur']  = $this->db->get_where('lembur', ['id' => $id])->row_array();
        $data['jamkerja_kategori']  = $this->db->get_where('jamkerja_kategori', ['id' => $id])->row_array();
        $data['aktivitas']  = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();

        $this->load->view('lembur/reportlbr', $data);
    }

    public function report_lembur_sect()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $sect = $this->db->get_where('karyawan_sect', ['id' => $this->input->post('sect_id')])->row_array();
        $this->db->where('sect_id', $this->input->post('sect_id'));
        $this->db->where('posisi_id', '5');
        $this->db->or_where('sect_id', $this->input->post('sect_id'));
        $this->db->where('posisi_id', '6');
        $sh = $this->db->get('karyawan')->row_array();

        $dept = $this->db->get_where('karyawan_dept', ['id' => $sect['dept_id']])->row_array();
        $this->db->where('dept_id', $sect['dept_id']);
        $this->db->where('posisi_id', '3');
        $dh = $this->db->get('karyawan')->row_array();

        $tglawal = date("Y-m-d 00:00:00", strtotime($this->input->post('tglawal')));
        $tglakhir = date("Y-m-d 23:59:00", strtotime($this->input->post('tglakhir')));

        $this->db->where('tglmulai >=',$tglawal);
        $this->db->where('tglmulai <=',$tglakhir);
        $this->db->where('sect_id',$this->input->post('sect_id'));
        $this->db->where('status >', '7');
        $this->db->order_by('tglmulai', 'ASC');
        $data['lembur'] = $this->db->get('lembur')->result_array();

        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $data['section'] = $sect['nama'];
        $data['department'] = $dept['inisial'];
        $data['secthead'] = $sh['nama'];
        $data['depthead'] = $dh['nama'];
        
        $this->load->view('lembur/lp_lembur_sect_pdf', $data);
    }

    public function laporan_hr()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if($this->input->post('tglawal')){
            $tglawal  = date('Y-m-d', strtotime($this->input->post('tglawal')));
            $tglakhir = date('Y-m-d', strtotime($this->input->post('tglakhir')));
        }else{
            $tglawal  = date('Y-m-1');
            $tglakhir = date('Y-m-31');
        }
        
        $data['periode'] = [
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/laporan/laporan_hr', $data);
        $this->load->view('templates/footer');
    }

    public function get_data($params=null)
    {
        if ($params=='hr')
        {

            $this->db->where('tglmulai >=', $this->input->post('awal'));
            $this->db->where('tglmulai <=', $this->input->post('akhir'));
            $this->db->where('status >','7');
            $this->db->order_by('tglmulai', 'ASC');
            $lembur = $this->db->get('lembur')->result();
    
            foreach ($lembur as $row) {
                $person = $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
                $kategori = $this->db->get_where('lembur_kategori', ['id' => $row->kategori])->row();
                $dept = $this->db->get_where('karyawan_dept', ['id' => $person->dept_id])->row();
                $sect = $this->db->get_where('karyawan_sect', ['id' => $person->sect_id])->row();

                //     if ($row->status=='9')
                //     {
                //         $actions = "<a href='". base_url('lembur/laporan_lembur/').$row->id."' class='btn btn-link btn-warning btn-just-icon edit' target='_blank'><i class='material-icons'>dvr</i></a>";
                //     }else{
                //         $actions = "<a href='#' class='btn btn-link btn-warning btn-just-icon edit disabled'><i class='material-icons'>dvr</i></a>";
                //     }
    if (empty($row->admin_ppic)){
        $admin_ppic = '-';
        $tgl_admin_ppic = '-';
    }else{
        $admin_ppic = 'Disetujui oleh '.$row->admin_ppic;
        $tgl_admin_ppic = date('d-m-Y H:i', strtotime($row->tgl_admin_ppic));
    }

    if ($row->status=='8'){
        $status_lembur = 'Menunggu PPIC';
    } elseif ($row->status=='9'){
        $status_lembur = 'Selesai';
    }

                $output['data'][] = array(
                    "id" => $row->id,
                    "kategori" => $kategori->nama,
                    "nama" => $person->nama,
                    "npk" => $person->npk,
                    "tanggal_mulai" => date('m/d/Y', strtotime($row->tglmulai)),
                    "jam_mulai" => date('H:i', strtotime($row->tglmulai)),
                    "tanggal_selesai" => date('m/d/Y', strtotime($row->tglselesai)),
                    "jam_selesai" => date('H:i', strtotime($row->tglselesai)),
                    "durasi" => $row->durasi,
                    "tul" => $row->tul,
                    "dept" => $dept->nama,
                    "sect" => $sect->nama,
                    "hr" => 'Disetujui oleh '.$row->admin_hr,
                    "tanggal_hr" => date('d-m-Y H:i', strtotime($row->tgl_admin_hr)),
                    "ppic" => $admin_ppic,
                    "tanggal_ppic" => $tgl_admin_ppic,
                    "status" => $status_lembur,
                    "catatan" => $row->catatan,
                    "actions" => "<a href='". base_url('lembur/laporan_lembur/').$row->id."' class='btn btn-link btn-warning btn-just-icon edit' target='_blank'><i class='material-icons'>dvr</i></a>"
                );
            }
            
            echo json_encode($output);
            exit();
        }
        
    }

    public function cari_lembur_ga()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $tglmulai = date("Y-m-d 00:00:00", strtotime($this->input->post('tglmulai')));
        $tglselesai = date("Y-m-d 23:59:00", strtotime($this->input->post('tglselesai')));
        $querylembur = "SELECT *
                        FROM `lembur`
                        WHERE `tglmulai` >= '$tglmulai' AND `tglselesai` <= '$tglselesai' AND `status` > 2
                        ";
        $data['lembur'] = $this->db->query($querylembur)->result_array();
        $data['tglmulai'] = $tglmulai;
        $data['tglselesai'] = $tglselesai;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/laporanga', $data);
        $this->load->view('templates/footer');
    }

    public function gtJamRelalisai()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
        $tglmulai = date("Y-m-d", strtotime($lembur['tglmulai'])). ' ' . date("H:i:s", strtotime($this->input->post('jammulai')));
        $this->db->set('tglmulai', $tglmulai);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('status', 2);
        $this->db->where('link_aktivitas', $this->input->post('id'));
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($tglmulai)));

        // Update data LEMBUR
        $this->db->set('durasi', $totalDJam);
        $this->db->set('tglselesai', $tglselesai);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        redirect('lembur/realisasi_aktivitas/' . $this->input->post('id'));
    }

    public function gantitgl_lembur_sect()
    {
        $this->db->set('tglmulai', $this->input->post('tglmulai'));
        $this->db->set('tglselesai', $this->input->post('tglmulai'));
        $this->db->set('tglmulai_aktual', $this->input->post('tglmulai'));
        $this->db->set('tglselesai_aktual', $this->input->post('tglmulai'));
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        redirect('lembur/persetujuan_aktivitas/' . $this->input->post('link_aktivitas'));
    }

    public function laporan($dept)
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        if($this->input->post('tahun')){
            $data['tahun'] = $this->input->post('tahun');
            $data['bulan'] = $this->input->post('bulan');
        }else{
            $data['tahun'] = date('Y');
            $data['bulan'] = date('m');
        }

        if ($dept=='mch'){
            $data['lembur'] = $this->db->where('dept_id','13');
            $data['lembur'] = $this->db->where('year(tglmulai)', $this->input->post('tahun'));
            $data['lembur'] = $this->db->where('month(tglmulai)', $this->input->post('bulan'));
            $data['lembur'] = $this->db->where('status', '9');
            $data['lembur'] = $this->db->get('lembur')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/lp_lembur_mch', $data);
            $this->load->view('templates/footer');
        }else{
            $data['lembur'] = $this->db->where('year(tglmulai)', $this->input->post('tahun'));
            $data['lembur'] = $this->db->where('month(tglmulai)', $this->input->post('bulan'));
            $data['lembur'] = $this->db->where('status', '9');
            $data['lembur'] = $this->db->get('lembur')->result_array();
            if ($this->input->post('laporan') == 1){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('lembur/lp_lembur_1', $data);
                $this->load->view('templates/footer');
            }elseif ($this->input->post('laporan') == 2){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('lembur/lp_lembur_2', $data);
                $this->load->view('templates/footer');
            }elseif ($this->input->post('laporan') == 3){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('lembur/lp_lembur_3', $data);
                $this->load->view('templates/footer');
            }elseif ($this->input->post('laporan') == 5){
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('lembur/lp_copro', $data);
                $this->load->view('templates/footer');
            }else{
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('lembur/lp_lembur', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function cetak($id)
    {
        $data['lembur']  = $this->db->get_where('lembur', ['id' => $id])->row_array();
        $data['jamkerja_kategori']  = $this->db->get_where('jamkerja_kategori', ['id' => $id])->row_array();
        $data['aktivitas']  = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();

        $this->load->view('lembur/reportlbr', $data);
    }

    public function getData($params = null)
    {
        if ($params=='')
        {
           
        }elseif ($params=='lemburku'){
          
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->where('tglmulai >=', date('Y-m-d', strtotime('-3 months')));
            $lembur = $this->db->get('lembur')->result();

            foreach ($lembur as $row) {

                $status = $this->db->get_where('lembur_status', ['id' => $row->status])->row();

                if ($row->status < 5):
                    $durasi = $row->durasi_rencana;
                else :
                    $durasi = $row->durasi;
                endif;

                $output['data'][] = array(
                    "id" => $row->id,
                    "mulai" => date('d M y H:i', strtotime($row->tglmulai)),
                    "selesai" => date('d M y H:i', strtotime($row->tglselesai)),
                    "durasi" => $durasi,
                    "catatan" => $row->catatan,
                    "status" => $status->nama,
                    "action" => ""
                );
            }
            echo json_encode($output);
            exit();

        }elseif ($params=='penyimpangan')
        {
            $this->db->where('status','0');
            $this->db->where('life', '0');
            $this->db->where('last_status', '4');
            $lembur = $this->db->get('lembur')->result();

            foreach ($lembur as $row) :
                $output['data'][] = array(
                    'id' => $row->id,
                    'kategori' => $row->kategori,
                    'nama' => $row->nama,
                    'tanggal' => date('d-m-Y', strtotime($row->tglmulai_rencana)),
                    'durasi' => $row->durasi_rencana,
                    'catatan' => $row->catatan
                );
            endforeach;
            
            // var_dump($output);

            //output to json format
            echo json_encode($output);

        }
    }

    public function penyimpangan($params = null )
    {
        if (empty($params))
        {
            $data['sidemenu'] = 'HR Lembur';
            $data['sidesubmenu'] = 'Penyimpangan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/hr/penyimpangan_index', $data);
            $this->load->view('templates/footer');
        }elseif($params=='submit')
        {
            // Update data LEMBUR
            $this->db->set('status', '4');
            $this->db->set('life', '1');
            $this->db->set('catatan', 'Lembur ini telah diaktifkan - '.$this->session->userdata('inisial').' pada '.date('d-m-Y H:i'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();
            $user = $this->db->get_where('karyawan', ['npk' => $lembur->npk ])->row();
            //Notifikasi ke USER
            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                'https://region01.krmpesan.com/api/v2/message/send-text',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                    ],
                    'json' => [
                        'phone' => $user->phone,
                        'message' => "*[AKTIF] LEMBURAN KAMU TELAH AKTIF*" .
                            "\r\n \r\nNo LEMBUR : *" . $lembur->id . "*" .
                            "\r\nNama : *" . $lembur->nama . "*" .
                            "\r\nTanggal : *" . date('d-M H:i', strtotime($lembur->tglmulai)) . "*" .
                            "\r\nDurasi : *" . $lembur->durasi . " Jam*" .
                            "\r\n \r\nLEMBURAN kamu telah *DIAKTIFKAN*" .
                            "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                        ],
                ]
            );
            $body = $response->getBody();
        }
    }
    public function get_top($from,$to)
    {
            $this->db->distinct();
            $this->db->select('nama');
            $this->db->where('tglmulai >=',$from);
            $this->db->where('tglselesai <=', $to);
            $this->db->where('kategori', 'OT');
            $this->db->where('status','9');
            $query = $this->db->get('lembur')->result();
            foreach ($query as $row) :

                $this->db->select('SUM(durasi) as total');
                $this->db->where('nama', $row->nama);
                $this->db->where('tglmulai >=',$from);
                $this->db->where('tglselesai <=', $to);
                $this->db->where('kategori', 'OT');
                $this->db->where('status', '9');
                $this->db->from('lembur');
                $queryJam = $this->db->get()->row()->total;

                $this->db->select('SUM(tul) as total');
                $this->db->where('nama', $row->nama);
                $this->db->where('tglmulai >=',$from);
                $this->db->where('tglselesai <=', $to);
                $this->db->where('kategori', 'OT');
                $this->db->where('status', '9');
                $this->db->from('lembur');
                $queryTul = $this->db->get()->row()->total;

                $this->db->select('karyawan.*, karyawan_dept.*');
                $this->db->where('karyawan.nama', $row->nama);
                $this->db->from('karyawan');
                $this->db->join('karyawan_dept', 'karyawan_dept.id = karyawan.dept_id', 'inner');
                $queryDept = $this->db->get()->row();

                $output['data'][] = array(
                    'nama' => $row->nama,
                    'jam' => $queryJam,
                    'tul' => $queryTul,
                    'dept' => $queryDept->nama
                );

            endforeach;
        //output to json format
        echo json_encode($output);

    }

    public function count($params=null)
    {
        if ($params==null){

        }elseif ($params=='hari'){
            
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();
            $durasi = $lembur->durasi - $lembur->istirahat;

                $this->db->where('durasi', $durasi);
                $this->db->where('hari', $this->input->post('hari'));
            $tul = $this->db->get('lembur_tul')->row();

            $this->db->set('hari', $this->input->post('hari'));
            $this->db->set('tul', $tul->tul);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $output['data'] = array(
                'tul' => $tul->tul
            );

            echo json_encode($output);
        }elseif ($params=='istirahat'){
            
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();

            $output['data'] = array(
                'istirahat' =>  $lembur->istirahat,
                'istirahat1' =>  $lembur->istirahat1,
                'istirahat2' =>  $lembur->istirahat2,
                'istirahat3' =>  $lembur->istirahat3,
                'tul' =>  $lembur->tul
            );

            echo json_encode($output);
        }elseif ($params=='istirahat1'){
            
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();
            $istirahat = $lembur->istirahat2 + $lembur->istirahat3 + $this->input->post('istirahat1');

            $durasi = $lembur->durasi - $istirahat;
                $this->db->where('durasi', $durasi);
                $this->db->where('hari', $lembur->hari);
            $tul = $this->db->get('lembur_tul')->row();

            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat1', $this->input->post('istirahat1'));
            $this->db->set('durasi_hr', $durasi);
            $this->db->set('tul', $tul->tul);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $output['data'] = array(
                'istirahat' => $istirahat,
                'tul' => $tul->tul
            );

            echo json_encode($output);
        }elseif ($params=='istirahat2'){
            
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();
            $istirahat = $lembur->istirahat1 + $lembur->istirahat3 + $this->input->post('istirahat2');

            $durasi = $lembur->durasi - $istirahat;
                $this->db->where('durasi', $durasi);
                $this->db->where('hari', $lembur->hari);
            $tul = $this->db->get('lembur_tul')->row();

            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat2', $this->input->post('istirahat2'));
            $this->db->set('durasi_hr', $durasi);
            $this->db->set('tul', $tul->tul);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $output['data'] = array(
                'istirahat' => $istirahat,
                'tul' => $tul->tul
            );

            echo json_encode($output);
        }elseif ($params=='istirahat3'){
            
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();
            $istirahat = $lembur->istirahat1 + $lembur->istirahat2 + $this->input->post('istirahat3');

            $durasi = $lembur->durasi - $istirahat;
            $this->db->where('durasi', $durasi);
            $this->db->where('hari', $lembur->hari);
            $tul = $this->db->get('lembur_tul')->row();
            
            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat3', $this->input->post('istirahat3'));
            $this->db->set('durasi_hr', $durasi);
            $this->db->set('tul', $tul->tul);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $output['data'] = array(
                'istirahat' => $istirahat,
                'tul' => $tul->tul
            );

            echo json_encode($output);
        }elseif ($params=='jamkerja'){
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();

            $this->db->select('SUM(durasi) as total1');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->where('kategori','1');
            $this->db->from('aktivitas');
            $durasi1 = $this->db->get()->row()->total1;

            $this->db->select('SUM(durasi) as total2');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->where('kategori','2');
            $this->db->from('aktivitas');
            $durasi2 = $this->db->get()->row()->total2;

            $this->db->select('SUM(durasi) as total3');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->where('kategori','3');
            $this->db->from('aktivitas');
            $durasi3 = $this->db->get()->row()->total3;

            $total = $durasi1 + $durasi2 + $durasi3;

            if ($total < $lembur->durasi or $total > $lembur->durasi){
                $errorText = 'Total durasi tidak sama dengan durasi sebelumnya.';
            }else{
                $errorText = '';
            }

            $output['data'] = array(
                'durasi1' => $durasi1,
                'durasi2' => $durasi2,
                'durasi3' => $durasi3,
                'error' => $errorText
            );

            echo json_encode($output);
        }
    }

    public function get_aktivitas($params=null)
    {
        if ($params==null){

        }elseif ($params=='rencana'){
            // Our Start and End Dates
            $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $this->input->post('id')])->result();

            if (!empty($aktivitas)){
                
                foreach ($aktivitas as $row) {
                    if ($row->kategori=='1')
                    {
                        $aktivitas = "PROJEK ".$row->copro." - ".$row->aktivitas;
    
                    }elseif ($row->kategori=='2')
                    {
                        if($aktivitas=="DR, Konsep")
                        {
                            $aktivitas = "LAIN-LAIN PROJEK - ".$row->aktivitas;
                        }else{
                            $aktivitas = "LAIN-LAIN PROJEK ".$row->copro." - ".$row->aktivitas;
                        }
                    }elseif ($row->kategori=='3')
                    {
                        $aktivitas = "NON PROJEK - ".$row->aktivitas;
                    }

                    $output['data'][] = array(
                        "aktivitas" => $aktivitas,
                        "durasi" => $row->durasi,
                        "action" => "<button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#hapusAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."'><i class='material-icons'>delete</i></button>"
                    );
                }
            }else{
                $output['data'][] = array(
                    "aktivitas" => '',
                    "durasi" => 'There are no data to display.',
                    "action" => ''
                );
            }
            echo json_encode($output);
            exit();

        }elseif ($params=='rencana_persetujuan'){
            // Our Start and End Dates
            $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $this->input->post('id')])->result();

            if (!empty($aktivitas)){
                
                foreach ($aktivitas as $row) {
                    if ($row->kategori=='1')
                    {
                        $aktivitas = "PROJEK ".$row->copro." - ".$row->aktivitas;
    
                    }elseif ($row->kategori=='2')
                    {
                        if($aktivitas=="DR, Konsep")
                        {
                            $aktivitas = "LAIN-LAIN PROJEK - ".$row->aktivitas;
                        }else{
                            $aktivitas = "LAIN-LAIN PROJEK ".$row->copro." - ".$row->aktivitas;
                        }
                    }elseif ($row->kategori=='3')
                    {
                        if($row->contract=="Direct Labor")
                        {
                            $aktivitas = "NON PROJEK - ".$row->aktivitas;
                        }else{
                            $aktivitas = $row->aktivitas;
                        }
                    }

                    $output['data'][] = array(
                        "aktivitas" => $aktivitas,
                        "durasi" => $row->durasi,
                        "action" => "<button type='button' class='btn btn-success btn-link btn-just-icon' data-toggle='modal' data-target='#ubahDurasi' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."' data-aktivitas='".$aktivitas."'><i class='material-icons'>more_time</i></button>
                                     <button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#hapusAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."'><i class='material-icons'>delete</i></button>"
                    );
                }
            }else{
                $output['data'][] = array(
                    "aktivitas" => '',
                    "durasi" => 'There are no data to display.',
                    "action" => ''
                );
            }
            echo json_encode($output);
            exit();

        }elseif ($params=='realisasi'){
            // Our Start and End Dates
            $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $this->input->post('id')])->result();

            if (!empty($aktivitas)){
                
                foreach ($aktivitas as $row) {
                    if ($row->kategori=='1')
                    {
                        $aktivitas = "PROJEK ".$row->copro." - ".$row->aktivitas;
    
                    }elseif ($row->kategori=='2')
                    {
                        if($aktivitas=="DR, Konsep")
                        {
                            $aktivitas = "LAIN-LAIN PROJEK - ".$row->aktivitas;
                        }else{
                            $aktivitas = "LAIN-LAIN PROJEK ".$row->copro." - ".$row->aktivitas;
                        }
                    }elseif ($row->kategori=='3')
                    {
                        if($row->contract=="Direct Labor")
                        {
                            $aktivitas = "NON PROJEK - ".$row->aktivitas;
                        }else{
                            $aktivitas = $row->aktivitas;
                        }
                    }

                    if ($row->status=='1')
                    {
                        $actions = "<button type='button' class='btn btn-success btn-link btn-just-icon' data-toggle='modal' data-target='#updateAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."' data-aktivitas='".$aktivitas."' data-deskripsi='".$row->deskripsi_hasil."'><i class='material-icons'>create</i></button>
                                    <button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#hapusAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."'><i class='material-icons'>delete</i></button>";
                    }else{
                        $actions = "<button type='button' class='btn btn-info btn-link btn-just-icon' data-toggle='modal' data-target='#updateAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."' data-aktivitas='".$aktivitas."' data-deskripsi='".$row->deskripsi_hasil."'><i class='material-icons'>task_alt</i></button>
                                    <button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#hapusAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."'><i class='material-icons'>delete</i></button>";
                    }

                    $output['data'][] = array(
                        "aktivitas" => $aktivitas,
                        "deskripsi" => $row->deskripsi_hasil." (".$row->progres_hasil."%)",
                        "durasi" => $row->durasi,
                        "action" => $actions
                    );
                }
            }else{
                $output['data'][] = array(
                    "aktivitas" => '',
                    "deskripsi" => 'There are no data to display.',
                    "durasi" => '',
                    "action" => ''
                );
            }
            echo json_encode($output);
            exit();

        }elseif ($params=='realisasi_persetujuan'){
            // Our Start and End Dates
            $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $this->input->post('id')])->result();

            if (!empty($aktivitas)){
                
                foreach ($aktivitas as $row) {
                    if ($row->kategori=='1')
                    {
                        $aktivitas = "PROJEK ".$row->copro." - ".$row->aktivitas;
    
                    }elseif ($row->kategori=='2')
                    {
                        if($aktivitas=="DR, Konsep")
                        {
                            $aktivitas = "LAIN-LAIN PROJEK - ".$row->aktivitas;
                        }else{
                            $aktivitas = "LAIN-LAIN PROJEK ".$row->copro." - ".$row->aktivitas;
                        }
                    }elseif ($row->kategori=='3')
                    {
                        if($row->contract=="Direct Labor")
                        {
                            $aktivitas = "NON PROJEK - ".$row->aktivitas;
                        }else{
                            $aktivitas = $row->aktivitas;
                        }
                    }

                    if ($row->terencana=='1'){
                        if ($row->durasi==$row->durasi_rencana){
                            $durasi = $row->durasi;
                        }else{
                            $durasi = $row->durasi.' <a class="text-danger">( rencana : '.$row->durasi_rencana.' )</a>';
                        }
                    }else{
                        $durasi = $row->durasi.' <a class="text-danger">( tidak ada rencana )</a>';
                    }

                    $output['data'][] = array(
                        "aktivitas" => $aktivitas,
                        "deskripsi" => $row->deskripsi_hasil." (".$row->progres_hasil."%)",
                        "durasi" => $durasi
                    );
                }
            }else{
                $output['data'][] = array(
                    "aktivitas" => '',
                    "deskripsi" => 'There are no data to display.',
                    "durasi" => ''
                );
            }
            echo json_encode($output);
            exit();

        }elseif ($params=='hr'){
        
            // Our Start and End Dates
            $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $this->input->post('id')])->result();

            foreach ($aktivitas as $row) {

                if ($row->kategori=='1')
                {
                    $aktivitas = "PROJEK ".$row->copro." - ".$row->aktivitas;

                }elseif ($row->kategori=='2')
                {
                    if($aktivitas=="DR, Konsep")
                    {
                        $aktivitas = "LAIN-LAIN PROJEK - ".$row->aktivitas;
                    }else{
                        $aktivitas = "LAIN-LAIN PROJEK ".$row->copro." - ".$row->aktivitas;
                    }
                }elseif ($row->kategori=='3')
                {
                    if($row->contract=="Direct Labor")
                    {
                        $aktivitas = "NON PROJEK - ".$row->aktivitas;
                    }else{
                        $aktivitas = $row->aktivitas;
                    }
                }

                $output['data'][] = array(
                    "aktivitas" => $aktivitas,
                    "deskripsi" => $row->deskripsi_hasil." (".$row->progres_hasil."%)",
                    "durasi" => $row->durasi,
                    "action" => "<button type='button' class='btn btn-success btn-link btn-just-icon' data-toggle='modal' data-target='#updateAktivitas' data-id_lembur='". $row->link_aktivitas ."' data-id_aktivitas='". $row->id ."' data-deskripsi_hasil='". $row->deskripsi_hasil. "'><i class='material-icons'>edit</i></button> 
                                 <button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#hapusAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."'><i class='material-icons'>delete</i></button>"
                );
            }
            echo json_encode($output);
            exit();
        }elseif ($params=='ppic'){
        
            // Our Start and End Dates
            $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $this->input->post('id')])->result();

            foreach ($aktivitas as $row) {

                if ($row->kategori=='1')
                {
                    $aktivitas = "PROJEK ".$row->copro." - ".$row->aktivitas;

                }elseif ($row->kategori=='2')
                {
                    if($aktivitas=="DR, Konsep")
                    {
                        $aktivitas = "LAIN-LAIN PROJEK - ".$row->aktivitas;
                    }else{
                        $aktivitas = "LAIN-LAIN PROJEK ".$row->copro." - ".$row->aktivitas;
                    }
                }elseif ($row->kategori=='3')
                {
                    $aktivitas = "NON PROJEK - ".$row->aktivitas;
                }

                $output['data'][] = array(
                    "aktivitas" => $aktivitas,
                    "deskripsi" => $row->deskripsi_hasil." (".$row->progres_hasil."%)",
                    "durasi" => $row->durasi,
                    "action" => "<button type='button' class='btn btn-success btn-link btn-just-icon' data-toggle='modal' data-target='#updateAktivitas".$row->kategori."' data-id_lembur='". $row->link_aktivitas ."' data-id_aktivitas='". $row->id ."' data-aktivitas='". $row->aktivitas. "' data-deskripsi_hasil='". $row->deskripsi_hasil. "' data-progres_hasil='". $row->progres_hasil. "'><i class='material-icons'>edit</i></button> 
                                 <button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#hapusAktivitas' data-id_lembur='".$row->link_aktivitas."' data-id_aktivitas='".$row->id."'><i class='material-icons'>delete</i></button>"
                );
            }
            echo json_encode($output);
            exit();
        }else{

        }
    }

    public function direct_aktivitas($params)
    {
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row();
        if ($params=='1'){
        
            $output['data'] = array(
                "aktivitas" => $aktivitas->aktivitas
            );
        }
        if ($params=='2' or $params=='3'){
        
           $this->db->where('kategori_id', $aktivitas->kategori);
           $this->db->where('dept_id', $aktivitas->dept_id);
            $getList = $this->db->get("jamkerja_lain")->result();
      
            foreach ($getList as $row) {
                echo '<option value="'.$row->aktivitas.'" ';
                if ($row->aktivitas == $aktivitas->aktivitas) {
                    echo 'selected';
                }
                echo '>'.$row->aktivitas.'</option>';   
            }
        }

        echo json_encode($output);
        exit();
    }

    public function kategori_aktivitas()
    {
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $kategori_id = $_POST['kategori'];
        $dept_id = $lembur['dept_id'];
        $getAktivitas = $this->db->query("SELECT * FROM jamkerja_lain WHERE kategori_id = '$kategori_id' AND dept_id = '$dept_id' ")->result_array();
  
        foreach ($getAktivitas as $a) {
            echo '<option value="'.$a['aktivitas'].'">'.$a['aktivitas'].'</option>';   
        }
    }

    public function durasi_aktivitas()
    {
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row();
        $jam = $this->db->get_where('jam', ['jam <=' => 4])->result();
        foreach ($jam as $row) : 
            echo '<option value="' . $row->jam . '" ' ;
            if ($row->jam == $aktivitas->durasi) {
                echo 'selected';
            }
            echo '>' . $row->nama . '</option>' . "\n";
        endforeach;
    }

    public function copro_aktivitas()
    {
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row();
        $copro = $this->db->get_where('project', ['status !=' => 'CLOSED'])->result();
        foreach ($copro as $row) :
            echo '<option data-subtext="'. $row->deskripsi.'" value="'. $row->copro.'"';
            if ($row->copro == $aktivitas->copro) {
                echo 'selected';
            }
            echo '>'. $row->copro.'</option>';
        endforeach; 
    }

    public function progres_aktivitas()
    {
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row();
        for ($i = 0; $i <= 100; $i=$i+10) {
            echo '<option value="'. $i.'"';
            if ($i == $aktivitas->progres_hasil) {
                echo 'selected';
            }
            echo '>'.$i.'%</option>';
        }
    }

    public function ubah_jam($params=null)
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        if ($params=='rencana'){
            //Update jam setelah isi aktivitas seharusnya masih diperbolehkan
            $tglmulai = date("Y-m-d", strtotime($lembur['tglmulai_rencana'])).' '.$this->input->post('jammulai');
    
            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->from('aktivitas');
            $menit = $this->db->get()->row()->total;
            
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $menit . 'minutes', strtotime($tglmulai)));

            $this->db->set('tglmulai_rencana', $tglmulai);
            $this->db->set('tglselesai_rencana',$tglselesai);
            $this->db->set('tglmulai', $tglmulai);
            $this->db->set('tglselesai', $tglmulai);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($tglmulai)).date(' - H:i', strtotime($tglselesai))
            );

            echo json_encode($output);
            exit();
        }elseif ($params=='realisasi'){
            //Update jam setelah isi aktivitas seharusnya masih diperbolehkan
            $tglmulai = date("Y-m-d", strtotime($lembur['tglmulai'])).' '.$this->input->post('jammulai');
    
            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('status', '2');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->from('aktivitas');
            $menit = $this->db->get()->row()->total;
            
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $menit . 'minutes', strtotime($tglmulai)));

            $this->db->set('tglmulai', $tglmulai);
            $this->db->set('tglselesai', $tglselesai);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($tglmulai)).date(' - H:i', strtotime($tglselesai))
            );

            echo json_encode($output);
            exit();
        }elseif ($params=='konfirmasi_hr'){
            //Update jam setelah isi aktivitas seharusnya masih diperbolehkan
            $tglmulai = date("Y-m-d H:i:s", strtotime($this->input->post('tglmulai')));
    
            //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('status', '2');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->from('aktivitas');
            $menit = $this->db->get()->row()->total;
            
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $menit . 'minutes', strtotime($tglmulai)));

            if (date('D', strtotime($tglmulai)) == 'Sat' OR date('D', strtotime($tglmulai)) == 'Sun') {
                $hari = 'LIBUR';
            }else{
                $event = $this->db->get_where('calendar_event_details', ['date' => date('Y-m-d', strtotime($tglmulai))])->row_array();
                if (empty($event))
                {
                    $hari = 'KERJA';
                }else{
                    $hari = $event['category'];
                }
            }

            $jammulai = date('H:i', strtotime($tglmulai));
            $jamselesai = date('H:i', strtotime($tglselesai));

            if ($lembur['durasi']>=4 AND $jammulai < '12:00' AND $jamselesai > '13:00'){
                $istirahat1 = 1;
            }else{
                $istirahat1 = 0;
            }

            if ($lembur['durasi']>=4 AND $jammulai < '18:30' AND $jamselesai > '19:00'){
                $istirahat2 = 0.5;
            }else{
                $istirahat2 = 0;
            }

            $istirahat = $istirahat1 + $istirahat2 + $lembur['istirahat3'];

            $durasi = $lembur['durasi'] - $istirahat;
                $this->db->where('durasi', $durasi);
                $this->db->where('hari', $hari);
            $tul = $this->db->get('lembur_tul')->row();

            $this->db->set('istirahat', $istirahat);
            $this->db->set('istirahat1', $istirahat1);
            $this->db->set('istirahat2', $istirahat2);
            $this->db->set('durasi_hr', $durasi);
            $this->db->set('tul', $tul->tul);
            $this->db->set('tglmulai', $tglmulai);
            $this->db->set('tglselesai', $tglselesai);
            $this->db->set('hari', $hari);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->db->set('tgl_aktivitas', date("Y-m-d", strtotime($this->input->post('tglmulai'))));
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->update('aktivitas');

            $output['data'] = array(
                'tgl' => date('d M H:i', strtotime($tglmulai)).date(' - H:i', strtotime($tglselesai))
            );

            echo json_encode($output);
            exit();
        }
    }

    public function ubah_kategori($params=null)
    {
        if ($params=='konfirmasi_hr'){
            $this->db->set('kategori', $this->input->post('kategori'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            if ($this->input->post('kategori')=='OT'){
                $jenis_aktivitas = 'LEMBUR';
            }else{
                $jenis_aktivitas = 'JAM KERJA';
            }
            $this->db->set('jenis_aktivitas', $jenis_aktivitas);
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->update('aktivitas');

            $kategori = $this->db->get_where('lembur_kategori',['id'=>$this->input->post('kategori')])->row();

            $output['data'] = array(
                'kategori' => $kategori->nama
            );

            echo json_encode($output);
            exit();
        
        }else{
            $kategori = $this->db->get('lembur_kategori')->result();
            $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row();
            foreach ($kategori as $row) :
                echo '<option data-subtext="'. $row->id.'" value="'. $row->id.'"';
                if ($row->id == $lembur->kategori) {
                    echo 'selected';
                }
                echo '>'. $row->nama.'</option>';
            endforeach; 
        }
    }

    public function hari()
    {
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $hari = $this->db->get('lembur_hari')->result();
        foreach ($hari as $row) : echo '<option value="' . $row->nama . '"';
            if ($row->nama == $lembur['hari']) {
                echo 'selected';
            }
            echo '>' . $row->nama . '</option>' . "\n";
        endforeach;
    }

    public function leadtime($params)
    {
        if ($params=='get'){

            $this->db->where('year(tglmulai)',$this->input->post('tahun'));
            $this->db->where('month(tglmulai)',$this->input->post('bulan'));
            $this->db->where('status','9');
            $query = $this->db->get('lembur')->result();

            foreach ($query as $row) :

                // Pengajuan to Atasan1 
                if (date('Y-M-d', strtotime($row->tglpengajuan_rencana))==date('Y-M-d', strtotime($row->tgl_atasan1_rencana)))
                {
                    $day1 = date('D', strtotime($row->tglpengajuan_rencana));
                    if($day1!="Sun" && $day1!="Sat") {

                        if (date('H:i', strtotime($row->tglpengajuan_rencana)) < '07:30'){
                            $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tglpengajuan_rencana)));
                        }elseif (date('H:i', strtotime($row->tglpengajuan_rencana)) > '16:30') {
                            $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tglpengajuan_rencana)));
                        }else{
                            $time1 = strtotime($row->tglpengajuan_rencana);
                        }
                        
                        if (date('H:i', strtotime($row->tgl_atasan1_rencana)) < '07:30'){
                            $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_rencana)));
                        }elseif (date('H:i', strtotime($row->tgl_atasan1_rencana)) > '16:30') {
                            $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_rencana)));
                        }else{
                            $time2 = strtotime($row->tgl_atasan1_rencana);
                        }

                    }else{
                        $time1 = 0;
                        $time2 = 0;
                    }

                    $diff = $time2 - $time1;
                    $time_atasan1_jam = floor($diff / (60 * 60));
                    $diff_menit = $diff - ($time_atasan1_jam * (60 * 60));
                    $time_atasan1_menit = floor($diff_menit / 60);
                    $atasan1_rencana_time = $time_atasan1_jam.' Jam '.$time_atasan1_menit.' Menit ';
                    $time_atasan1_int = number_format((float)$time_atasan1_jam + ($time_atasan1_menit/60), 2, '.', '');
                    

                }elseif(date('Y-M-d', strtotime($row->tglpengajuan_rencana)) < date('Y-M-d', strtotime($row->tgl_atasan1_rencana)))
                {
                    $date1 = new DateTime(date('Y-m-d', strtotime($row->tglpengajuan_rencana)));
                    $date2 = new DateTime(date('Y-m-d', strtotime('+1 days', strtotime($row->tgl_atasan1_rencana))));
                    $day2 = date('D', strtotime($this->input->post('tgl2')));
                    
                    $daterange  = new DatePeriod($date1, new DateInterval('P1D'), $date2);
                    
                    //mendapatkan range antara dua tanggal dan di looping
                    $total_diff   = 0;
                    foreach($daterange as $date){
            
                        //Convert tanggal untuk mendapatkan nama hari
                        $day         = $date->format('D');
            
                        // Check untuk menghitung yang bukan hari sabtu dan minggu
                        if($day!="Sun" && $day!="Sat") {

                            if (date('Y-m-d', strtotime($row->tglpengajuan_rencana))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                            {
                                if (date('H:i', strtotime($row->tglpengajuan_rencana)) < '07:30'){
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tglpengajuan_rencana)));
                                }elseif (date('H:i', strtotime($row->tglpengajuan_rencana)) > '16:30') {
                                    $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tglpengajuan_rencana)));
                                }else{
                                    $time1 = strtotime($row->tglpengajuan_rencana);
                                }                                    
                                $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                            }elseif (date('Y-m-d', strtotime($row->tgl_atasan1_rencana))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                            { 
                                $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                if (date('H:i', strtotime($row->tgl_atasan1_rencana)) < '07:30'){
                                    $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_rencana)));
                                }elseif (date('H:i', strtotime($row->tgl_atasan1_rencana)) > '16:30') {
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_rencana)));
                                }else{
                                    $time2 = strtotime($row->tgl_atasan1_rencana);
                                }
                                
                                
                            }else{
                                
                                $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                            }
                                
                                
                            $diff = $time2 - $time1;
                            $total_diff = $total_diff + $diff;   
                        }
                    }    

                    $time_atasan1_jam = floor($total_diff / (60 * 60));
                    $diff_menit = $total_diff - ($time_atasan1_jam * (60 * 60));
                    $time_atasan1_menit = floor($diff_menit / 60);
                    $atasan1_rencana_time = $time_atasan1_jam.' Jam '.$time_atasan1_menit.' Menit ';
                    $time_atasan1_int = number_format((float)$time_atasan1_jam + ($time_atasan1_menit/60), 2, '.', '');

                }else{
                    $atasan1_rencana_time = '';
                }

                //Pengajuan to Atasan 1 end




                $output['data'][] = array(
                    'id' => $row->id,
                    'nama' => $row->nama,
                    'rencana_at' => date('Y-m-d H:i:s', strtotime($row->tglpengajuan_rencana)),
                    'atasan1_rencana_at' => date('Y-m-d H:i:s', strtotime($row->tgl_atasan1_rencana)),
                    'atasan1_rencana_time' => $atasan1_rencana_time,
                    'atasan1_rencana_by' => substr($row->atasan1_rencana, -3),
                    'atasan2_rencana_at' => date('Y-m-d H:i:s', strtotime($row->tgl_atasan2_rencana)),
                    'atasan2_rencana_time' => '',
                    'atasan2_rencana_by' => substr($row->atasan2_rencana, -3)
                );
            endforeach;

            //output to json format
            echo json_encode($output);

        }elseif ($params=='getbyLead'){

            $this->db->where('posisi_id <','7');
            $this->db->where('is_active','1');;
            $this->db->where('status','1');
            $queryLead = $this->db->get('karyawan')->result();

            foreach ($queryLead as $lead) :

                $this->db->where('year(tglmulai)',$this->input->post('tahun'));
                // $this->db->where('month(tglmulai)',$this->input->post('bulan'));
                $this->db->where('atasan1',$lead->inisial);
                $this->db->where('status','9');
                $atasan1 = $this->db->get('lembur');
                $query = $atasan1->result();
                if ($query){
                    $jumlah_atasan1 = $atasan1->num_rows();
                }else{
                    $jumlah_atasan1 = 0;
                }

                $total_diff1_rencana   = 0;
                $total_diff1_realisasi = 0;
                foreach ($query as $row) :

                    // Pengajuan to Atasan1 
                    if (date('Y-M-d', strtotime($row->tglpengajuan_rencana))==date('Y-M-d', strtotime($row->tgl_atasan1_rencana)))
                    {
                        $day1 = date('D', strtotime($row->tglpengajuan_rencana));
                        if($day1!="Sun" && $day1!="Sat") {

                            if (date('H:i', strtotime($row->tglpengajuan_rencana)) < '07:30'){
                                $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tglpengajuan_rencana)));
                            }elseif (date('H:i', strtotime($row->tglpengajuan_rencana)) > '16:30') {
                                $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tglpengajuan_rencana)));
                            }else{
                                $time1 = strtotime($row->tglpengajuan_rencana);
                            }
                            
                            if (date('H:i', strtotime($row->tgl_atasan1_rencana)) < '07:30'){
                                $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_rencana)));
                            }elseif (date('H:i', strtotime($row->tgl_atasan1_rencana)) > '16:30') {
                                $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_rencana)));
                            }else{
                                $time2 = strtotime($row->tgl_atasan1_rencana);
                            }

                        }else{
                            $time1 = 0;
                            $time2 = 0;
                        }

                        $diff1_rencana = $time2 - $time1;

                    }elseif(date('Y-M-d', strtotime($row->tglpengajuan_rencana)) < date('Y-M-d', strtotime($row->tgl_atasan1_rencana)))
                    {
                        $date1 = new DateTime(date('Y-m-d', strtotime($row->tglpengajuan_rencana)));
                        $date2 = new DateTime(date('Y-m-d', strtotime('+1 days', strtotime($row->tgl_atasan1_rencana))));
                        $day2 = date('D', strtotime($this->input->post('tgl2')));
                        
                        $daterange  = new DatePeriod($date1, new DateInterval('P1D'), $date2);
                        
                        //mendapatkan range antara dua tanggal dan di looping
                        $diff1_rencana   = 0;
                        foreach($daterange as $date){
                
                            //Convert tanggal untuk mendapatkan nama hari
                            $day         = $date->format('D');
                
                            // Check untuk menghitung yang bukan hari sabtu dan minggu
                            if($day!="Sun" && $day!="Sat") {

                                if (date('Y-m-d', strtotime($row->tglpengajuan_rencana))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                {
                                    if (date('H:i', strtotime($row->tglpengajuan_rencana)) < '07:30'){
                                        $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tglpengajuan_rencana)));
                                    }elseif (date('H:i', strtotime($row->tglpengajuan_rencana)) > '16:30') {
                                        $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tglpengajuan_rencana)));
                                    }else{
                                        $time1 = strtotime($row->tglpengajuan_rencana);
                                    }                                    
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                }elseif (date('Y-m-d', strtotime($row->tgl_atasan1_rencana))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                { 
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    if (date('H:i', strtotime($row->tgl_atasan1_rencana)) < '07:30'){
                                        $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_rencana)));
                                    }elseif (date('H:i', strtotime($row->tgl_atasan1_rencana)) > '16:30') {
                                        $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_rencana)));
                                    }else{
                                        $time2 = strtotime($row->tgl_atasan1_rencana);
                                    }
                                    
                                    
                                }else{
                                    
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                } 
                                    
                                $diff = $time2 - $time1;
                                $diff1_rencana = $diff1_rencana + $diff;   
                            }
                        }       
                    }
                    
                    $total_diff1_rencana = $total_diff1_rencana + $diff1_rencana;
                    //Pengajuan to Atasan 1 end

                    //Realisasi to Atasan 1 Start
                    if (date('Y-M-d', strtotime($row->tglpengajuan_realisasi))==date('Y-M-d', strtotime($row->tgl_atasan1_realisasi)))
                    {
                        $day1 = date('D', strtotime($row->tglpengajuan_realisasi));
                        if($day1!="Sun" && $day1!="Sat") {

                            if (date('H:i', strtotime($row->tglpengajuan_realisasi)) < '07:30'){
                                $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tglpengajuan_realisasi)));
                            }elseif (date('H:i', strtotime($row->tglpengajuan_realisasi)) > '16:30') {
                                $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tglpengajuan_realisasi)));
                            }else{
                                $time1 = strtotime($row->tglpengajuan_realisasi);
                            }
                            
                            if (date('H:i', strtotime($row->tgl_atasan1_realisasi)) < '07:30'){
                                $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_realisasi)));
                            }elseif (date('H:i', strtotime($row->tgl_atasan1_realisasi)) > '16:30') {
                                $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_realisasi)));
                            }else{
                                $time2 = strtotime($row->tgl_atasan1_realisasi);
                            }

                        }else{
                            $time1 = 0;
                            $time2 = 0;
                        }

                        $diff1_realisasi = $time2 - $time1;

                    }elseif(date('Y-M-d', strtotime($row->tglpengajuan_realisasi)) < date('Y-M-d', strtotime($row->tgl_atasan1_realisasi)))
                    {
                        $date1 = new DateTime(date('Y-m-d', strtotime($row->tglpengajuan_realisasi)));
                        $date2 = new DateTime(date('Y-m-d', strtotime('+1 days', strtotime($row->tgl_atasan1_realisasi))));
                        $day2 = date('D', strtotime($this->input->post('tgl2')));
                        
                        $daterange  = new DatePeriod($date1, new DateInterval('P1D'), $date2);
                        
                        //mendapatkan range antara dua tanggal dan di looping
                        $diff1_realisasi   = 0;
                        foreach($daterange as $date){
                
                            //Convert tanggal untuk mendapatkan nama hari
                            $day         = $date->format('D');
                
                            // Check untuk menghitung yang bukan hari sabtu dan minggu
                            if($day!="Sun" && $day!="Sat") {

                                if (date('Y-m-d', strtotime($row->tglpengajuan_realisasi))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                {
                                    if (date('H:i', strtotime($row->tglpengajuan_realisasi)) < '07:30'){
                                        $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tglpengajuan_realisasi)));
                                    }elseif (date('H:i', strtotime($row->tglpengajuan_realisasi)) > '16:30') {
                                        $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tglpengajuan_realisasi)));
                                    }else{
                                        $time1 = strtotime($row->tglpengajuan_realisasi);
                                    }                                    
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                }elseif (date('Y-m-d', strtotime($row->tgl_atasan1_realisasi))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                { 
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    if (date('H:i', strtotime($row->tgl_atasan1_realisasi)) < '07:30'){
                                        $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_realisasi)));
                                    }elseif (date('H:i', strtotime($row->tgl_atasan1_realisasi)) > '16:30') {
                                        $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_realisasi)));
                                    }else{
                                        $time2 = strtotime($row->tgl_atasan1_realisasi);
                                    }
                                    
                                    
                                }else{
                                    
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                } 
                                    
                                $diff = $time2 - $time1;
                                $diff1_realisasi = $diff1_realisasi + $diff;   
                            }
                        }       
                    }
                    
                    $total_diff1_realisasi = $total_diff1_realisasi + $diff1_realisasi;
                    //Realisasi to Atasan 1 end

                endforeach;

                //Atasan 1 to Atasan 2
                $this->db->where('year(tglmulai)',$this->input->post('tahun'));
                // $this->db->where('month(tglmulai)',$this->input->post('bulan'));
                $this->db->where('atasan1 !=',$lead->inisial);
                $this->db->where('atasan2',$lead->inisial);
                $this->db->where('status','9');
                $atasan2 = $this->db->get('lembur');
                $query = $atasan2->result();
                
                if ($query){
                    $jumlah_atasan2 = $atasan2->num_rows();
                }else{
                    $jumlah_atasan2 = 0;
                }

                $total_diff2_rencana   = 0;
                $total_diff2_realisasi = 0;
                foreach ($query as $row) :

                    // Pengajuan to Atasan2
                    if (date('Y-M-d', strtotime($row->tgl_atasan1_rencana))==date('Y-M-d', strtotime($row->tgl_atasan2_rencana)))
                    {
                        $day1 = date('D', strtotime($row->tgl_atasan1_rencana));
                        if($day1!="Sun" && $day1!="Sat") {

                            if (date('H:i', strtotime($row->tgl_atasan1_rencana)) < '07:30'){
                                $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_rencana)));
                            }elseif (date('H:i', strtotime($row->tgl_atasan1_rencana)) > '16:30') {
                                $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_rencana)));
                            }else{
                                $time1 = strtotime($row->tgl_atasan1_rencana);
                            }
                            
                            if (date('H:i', strtotime($row->tgl_atasan2_rencana)) < '07:30'){
                                $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan2_rencana)));
                            }elseif (date('H:i', strtotime($row->tgl_atasan2_rencana)) > '16:30') {
                                $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan2_rencana)));
                            }else{
                                $time2 = strtotime($row->tgl_atasan2_rencana);
                            }

                        }else{
                            $time1 = 0;
                            $time2 = 0;
                        }

                        $diff2_rencana = $time2 - $time1;

                    }elseif(date('Y-M-d', strtotime($row->tgl_atasan1_rencana)) < date('Y-M-d', strtotime($row->tgl_atasan2_rencana)))
                    {
                        $date1 = new DateTime(date('Y-m-d', strtotime($row->tgl_atasan1_rencana)));
                        $date2 = new DateTime(date('Y-m-d', strtotime('+1 days', strtotime($row->tgl_atasan2_rencana))));
                        $day2 = date('D', strtotime($this->input->post('tgl2')));
                        
                        $daterange  = new DatePeriod($date1, new DateInterval('P1D'), $date2);
                        
                        //mendapatkan range antara dua tanggal dan di looping
                        $diff2   = 0;
                        foreach($daterange as $date){
                
                            //Convert tanggal untuk mendapatkan nama hari
                            $day         = $date->format('D');
                
                            // Check untuk menghitung yang bukan hari sabtu dan minggu
                            if($day!="Sun" && $day!="Sat") {

                                if (date('Y-m-d', strtotime($row->tgl_atasan1_rencana))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                {
                                    if (date('H:i', strtotime($row->tgl_atasan1_rencana)) < '07:30'){
                                        $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_rencana)));
                                    }elseif (date('H:i', strtotime($row->tgl_atasan1_rencana)) > '16:30') {
                                        $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_rencana)));
                                    }else{
                                        $time1 = strtotime($row->tgl_atasan1_rencana);
                                    }                                    
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                }elseif (date('Y-m-d', strtotime($row->tgl_atasan2_rencana))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                { 
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    if (date('H:i', strtotime($row->tgl_atasan2_rencana)) < '07:30'){
                                        $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan2_rencana)));
                                    }elseif (date('H:i', strtotime($row->tgl_atasan2_rencana)) > '16:30') {
                                        $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan2_rencana)));
                                    }else{
                                        $time2 = strtotime($row->tgl_atasan2_rencana);
                                    }
                                    
                                    
                                }else{
                                    
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                } 
                                    
                                $diff = $time2 - $time1;
                                $diff2_rencana = $diff2_rencana + $diff;   
                            }
                        }
                    }
                    $total_diff2_rencana = $total_diff2_rencana + $diff2_rencana;
                    // Rencana to Atasan 2 end
                    // Realisasi to Atasan 2
                    if (date('Y-M-d', strtotime($row->tgl_atasan1_realisasi))==date('Y-M-d', strtotime($row->tgl_atasan2_realisasi)))
                    {
                        $day1 = date('D', strtotime($row->tgl_atasan1_realisasi));
                        if($day1!="Sun" && $day1!="Sat") {

                            if (date('H:i', strtotime($row->tgl_atasan1_realisasi)) < '07:30'){
                                $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_realisasi)));
                            }elseif (date('H:i', strtotime($row->tgl_atasan1_realisasi)) > '16:30') {
                                $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_realisasi)));
                            }else{
                                $time1 = strtotime($row->tgl_atasan1_realisasi);
                            }
                            
                            if (date('H:i', strtotime($row->tgl_atasan2_realisasi)) < '07:30'){
                                $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan2_realisasi)));
                            }elseif (date('H:i', strtotime($row->tgl_atasan2_realisasi)) > '16:30') {
                                $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan2_realisasi)));
                            }else{
                                $time2 = strtotime($row->tgl_atasan2_realisasi);
                            }

                        }else{
                            $time1 = 0;
                            $time2 = 0;
                        }

                        $diff2_realisasi = $time2 - $time1;

                    }elseif(date('Y-M-d', strtotime($row->tgl_atasan1_realisasi)) < date('Y-M-d', strtotime($row->tgl_atasan2_realisasi)))
                    {
                        $date1 = new DateTime(date('Y-m-d', strtotime($row->tgl_atasan1_realisasi)));
                        $date2 = new DateTime(date('Y-m-d', strtotime('+1 days', strtotime($row->tgl_atasan2_realisasi))));
                        $day2 = date('D', strtotime($this->input->post('tgl2')));
                        
                        $daterange  = new DatePeriod($date1, new DateInterval('P1D'), $date2);
                        
                        //mendapatkan range antara dua tanggal dan di looping
                        $diff2_realisasi   = 0;
                        foreach($daterange as $date){
                
                            //Convert tanggal untuk mendapatkan nama hari
                            $day         = $date->format('D');
                
                            // Check untuk menghitung yang bukan hari sabtu dan minggu
                            if($day!="Sun" && $day!="Sat") {

                                if (date('Y-m-d', strtotime($row->tgl_atasan1_realisasi))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                {
                                    if (date('H:i', strtotime($row->tgl_atasan1_realisasi)) < '07:30'){
                                        $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan1_realisasi)));
                                    }elseif (date('H:i', strtotime($row->tgl_atasan1_realisasi)) > '16:30') {
                                        $time1 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan1_realisasi)));
                                    }else{
                                        $time1 = strtotime($row->tgl_atasan1_realisasi);
                                    }                                    
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                }elseif (date('Y-m-d', strtotime($row->tgl_atasan2_realisasi))==date('Y-m-d', strtotime($date->format("Y-m-d"))))
                                { 
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    if (date('H:i', strtotime($row->tgl_atasan2_realisasi)) < '07:30'){
                                        $time2 = strtotime(date('Y-m-d 07:30:00', strtotime($row->tgl_atasan2_realisasi)));
                                    }elseif (date('H:i', strtotime($row->tgl_atasan2_realisasi)) > '16:30') {
                                        $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($row->tgl_atasan2_realisasi)));
                                    }else{
                                        $time2 = strtotime($row->tgl_atasan2_realisasi);
                                    }
                                    
                                    
                                }else{
                                    
                                    $time1 = strtotime(date('Y-m-d 07:30:00', strtotime($date->format("Y-m-d"))));
                                    $time2 = strtotime(date('Y-m-d 16:30:00', strtotime($date->format("Y-m-d"))));
                                } 
                                    
                                $diff = $time2 - $time1;
                                $diff2_realisasi = $diff2_realisasi + $diff;
                            }
                        }
                    }
                    $total_diff2_realisasi = $total_diff2_realisasi + $diff2_realisasi;
                    //Realisasi to Atasan 2 end
                    
                endforeach;

                //------------

                //Rencana
                $total_diff_rencana = $total_diff1_rencana + $total_diff2_rencana;
                $time_rencana_jam = floor($total_diff_rencana / (60 * 60));
                $diff_menit = $total_diff_rencana - ($time_rencana_jam * (60 * 60));
                $time_rencana_menit = floor($diff_menit / 60);
                $time_rencana = $time_rencana_jam.' Jam '.$time_rencana_menit.' Menit ';
                $time_rencana_int = number_format((float)$time_rencana_jam + ($time_rencana_menit/60), 2, '.', '');

                //Realisasi
                $total_diff_realisasi = $total_diff1_realisasi + $total_diff2_realisasi;
                $time_realisasi_jam = floor($total_diff_realisasi / (60 * 60));
                $diff_menit = $total_diff_realisasi - ($time_realisasi_jam * (60 * 60));
                $time_realisasi_menit = floor($diff_menit / 60);
                $time_realisasi = $time_realisasi_jam.' Jam '.$time_realisasi_menit.' Menit ';
                $time_realisasi_int = number_format((float)$time_realisasi_jam + ($time_realisasi_menit/60), 2, '.', '');
               
                //Total
                $total_diff = $total_diff1_rencana + $total_diff2_rencana + $total_diff1_realisasi + $total_diff2_realisasi;
                $total_app = ($jumlah_atasan1 + $jumlah_atasan2)*2;
                if ($total_app > 0){
                    $average_app = $total_diff / $total_app;
                }else{
                    $average_app = 0;
                }

                $time_atasan_jam = floor($total_diff / (60 * 60));
                $diff_menit = $total_diff - ($time_atasan_jam * (60 * 60));
                $time_atasan_menit = floor($diff_menit / 60);
                $time_atasan = $time_atasan_jam.' Jam '.$time_atasan_menit.' Menit ';
                $time_atasan_int = number_format((float)$time_atasan_jam + ($time_atasan_menit/60), 2, '.', '');

                $time_avg_jam = floor($average_app / (60 * 60));
                $diff_avg_menit = $average_app - ($time_avg_jam * (60 * 60));
                $time_avg_menit = floor($diff_avg_menit / 60);
                $time_avg = $time_avg_jam.' Jam '.$time_avg_menit.' Menit ';
                $time_avg_int = number_format((float)$time_avg_jam + ($time_avg_menit/60), 2, '.', '');

                $output['data'][] = array(
                    'nama' => $lead->nama,
                    'durasi_rencana' => $time_rencana,
                    'durasi_realisasi' => $time_realisasi,
                    'durasi' => $time_atasan,
                    'jumlah' => $total_app,
                    'average' => $time_avg_int.' / '.$time_avg
                );
            endforeach;

                //output to json format
                echo json_encode($output);
        

        }
    }
}
