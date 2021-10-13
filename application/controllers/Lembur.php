<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Lembur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        
        $this->load->model("project_model");
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
        $data['lembur'] = $this->db->get_where('lembur', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/index', $data);
        $this->load->view('templates/footer');
    }

    public function rencana()
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
        $this->load->view('lembur/rencana', $data);
        $this->load->view('templates/footer');
    }

    public function realisasi()
    {
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
        $this->load->view('lembur/realisasi', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_hariini()
    {
        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();


        // $this->db->where('year(tglmulai_rencana)', date('Y'));
        // $this->db->where('month(tglmulai_rencana)', date('m'));
        // $lembur = $this->db->get('lembur');
        // $total_lembur = $lembur->num_rows()+1;
        
        $this->load->helper('string');

        $id = 'OT'.date('ym'). random_string('alnum',3);
        $existid = $this->db->get_where('lembur', ['id' => $id])->row_array();
        if (!empty($existid)){$id = 'OT'.date('ym'). random_string('alnum',4);}

        if (date('H:i:s') <= date('16:30:00')) {
            $tglmulai = date('Y-m-d 16:30:00');
        }else{
            $tglmulai = date('Y-m-d H:i:s');
        }

        if (date('D') == 'Sat' OR date('D') == 'Sun') {
            $hari = 2;
        }else{
            $hari = 1;
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
        redirect('lembur/rencana_aktivitas/' . $data['id']);
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
            // $this->db->where('year(tglmulai_rencana)', $tahun);
            // $this->db->where('month(tglmulai_rencana)', $bulan);
            // $lembur = $this->db->get('lembur');
            // $total_lembur = $lembur->num_rows()+1;
            // $id = 'OT'.date('ym', strtotime($this->input->post('tglmulai'))). sprintf("%04s", $total_lembur);

            $this->load->helper('string');

            $id = 'OT'.date('ym', strtotime($this->input->post('tglmulai'))). random_string('alnum',3);
            $existid = $this->db->get_where('lembur', ['id' => $id])->row_array();
            if (!empty($existid)){$id = 'OT'.date('ym'). random_string('alnum',4);}

            if (date('D', strtotime($this->input->post('tglmulai'))) == 'Sat' OR date('D', strtotime($this->input->post('tglmulai'))) == 'Sun') {
                $hari = 2;
            }else{
                $hari = 1;
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
            redirect('lembur/rencana_aktivitas/' . $data['id']);
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
                    if ($lembur['contract']=='Direct Labor' AND $lembur['hari']==1){
                        $this->db->where('npk', $lembur['npk']);
                        $this->db->where('year(tglmulai)',$tahun);
                        $this->db->where('month(tglmulai)',$bulan);
                        $this->db->where('day(tglmulai)',$tanggal);
                        $this->db->where('status >', '0'); 
                        $jamkerja = $this->db->get('jamkerja')->result();

                        if (!empty($jamkerja)){
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
                $this->session->set_flashdata('message', 'hapus');
                redirect('lembur/rencana_aktivitas/' . $aktivitas['link_aktivitas']);
            }
            else if ($lembur['status']=='2' OR $lembur['status']=='3'){
                $this->session->set_flashdata('message', 'hapus');
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

    public function update_aktivitas_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
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
            $this->session->set_flashdata('message', 'hapus');
            redirect('lembur/realisasi_aktivitas/' . $lembur['id']);
        } elseif ($lembur['status']=='7'){
            $this->session->set_flashdata('message', 'hapus');
            redirect('lembur/proses/hr/' . $lembur['id']);
        }
    }

    public function ajukan_rencana()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $expired = date('Y-m-d H:i:s', strtotime('+7 days', strtotime($lembur['tglmulai'])));

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
                $karyawan = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2_rencana']])->row_array();
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
                            'phone' => $karyawan['phone'],
                            'message' => "*PENGAJUAN RENCANA LEMBUR*" .
                            "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                            "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                            "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
                            "\r\n \r\nRENCANA LEMBUR ini telah DISETUJUI oleh *". $lembur['atasan1_rencana'] ."*".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\n*Semakin lama kamu merespon, semakin sedikit waktu tim kamu membuat realisasi*".
                            "\r\n Untuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();

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
                $response = $client->post(
                    'https://region01.krmpesan.com/api/v2/message/send-text',
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                        ],
                        'json' => [
                            'phone' => $atasan1['phone'],
                            'message' => "*PENGAJUAN RENCANA LEMBUR*" .
                            "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                            "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                            "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
                            "\r\n \r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nRespon sebelum jam 4 sore agar tim kamu *Dipesankan makan malamnya".
                            "\r\nKalau kamu belum respon, tim kamu tidak bisa melakukan realisasi".
                            "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
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
            $karyawan = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
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
                        'phone' => $karyawan['phone'],
                        'message' => "*PERINTAH RENCANA LEMBUR*" .
                        "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                        "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                        "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
                        "\r\n \r\nHarap segera respon *Terima/Batalkan*".
                        "\r\n \r\nRespon sebelum jam 4 sore agar kamu *dipesankan makan malamnya".
                        "\r\nKalau kamu belum respon, kamu tidak bisa melakukan realisasi".
                        "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();
        }
       
        redirect('lembur/rencana/');
    }

    public function ajukan_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();

        $this->db->set('tglpengajuan_realisasi', date('Y-m-d H:i:s'));
        $this->db->set('status', 5);
        $this->db->set('last_notify', date('Y-m-d H:i:s'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        // Notification saat mengajukan REALISASI to ATASAN 1
        $atasan1 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1']])->row_array();
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
                    'phone' => $atasan1['phone'],
                    'message' => "*PENGAJUAN REALISASI LEMBUR*" .
                    "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                    "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) .
                    "\r\nDurasi : " . $lembur['durasi'] ." Jam" .
                    "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                ],
            ]
        );
        $body = $response->getBody();
        redirect('lembur/realisasi/');
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
        if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('atasan1_rencana', 'Disetujui oleh '.$this->session->userdata('inisial'));
            $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
            $this->db->set('status', '3');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            //Notifikasi ke ATASAN 2
            $atasan2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1']])->row_array();
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
                        'phone' => $atasan2['phone'],
                        'message' => "*PENGAJUAN RENCANA LEMBUR*" .
                        "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                        "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai_rencana'])) . 
                        "\r\nDurasi : " . $lembur['durasi_rencana'] ." Jam " .
                        "\r\n \r\nRENCANA LEMBUR ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                        "\r\nHarap segera respon *Setujui/Batalkan*".
                        "\r\n \r\n*Semakin lama kamu merespon, semakin sedikit waktu tim kamu membuat realisasi*".
                        "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();
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
            $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
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
                        'message' => "*HOREEE!! RENCANA LEMBUR KAMU SUDAH DISETUJUI*" .
                        "\r\n \r\n*RENCANA LEMBUR* kamu dengan detil berikut :" .
                        "\r\n \r\nTanggal " . date('d-M H:i', strtotime($lembur['tglmulai_rencana'])) . 
                        "\r\nDurasi " . $lembur['durasi_rencana'] ." Jam " . 
                        "\r\n \r\nTelah disetujui oleh *" . $this->session->userdata('inisial') . "*" .
                        "\r\nManfaatkan waktu lembur kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
                        "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI LEMBUR* kamu jika sudah selesai lemburnya ya!." .
                        "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" .
                        "\r\n \r\n" . $notifikasi['pesan']
                    ],
                ]
            );
            $body = $response->getBody();
        }

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_lembur/');
    }

    public function setujui_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        // Persetujuan Koordinator / Section Head 
        if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('atasan1_realisasi', 'Disetujui oleh '.$this->session->userdata('inisial'));
            $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
            $this->db->set('status', '6');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            //Notifikasi ke ATASAN 2
            $atasan2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2']])->row_array();
            if (!empty($atasan2)){
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
                            'message' => "*PENGAJUAN REALISASI LEMBUR*" .
                            "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                            "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                            "\r\nDurasi : " . $lembur['durasi'] ." Jam " .
                            "\r\n \r\nREALISASI LEMBUR ini telah disetujui oleh *". $this->session->userdata('inisial') ."*".
                            "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
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
        redirect('lembur/persetujuan_lembur/');
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

    // public function persetujuan_lemburga()
    // {
    //     date_default_timezone_set('asia/jakarta');
    //     $data['sidemenu'] = 'GA';
    //     $data['sidesubmenu'] = 'Konfirmasi Lembur';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
    //     $today = date('d');
    //     $bulan = date('m');
    //     $tahun = date('Y');

    //     $this->db->where('year(tglmulai) >=',$tahun);
    //     $this->db->where('month(tglmulai) >=',$bulan);
    //     $this->db->where('day(tglmulai) >=',$today);
    //     $this->db->where('admin_ga',null);
    //     $this->db->where('status >', '2');
    //     $this->db->order_by('tglmulai', 'ASC');
    //     $data['lembur'] = $this->db->get('lembur')->result_array();

    //     $this->db->where('year(tglmulai) >=',$tahun);
    //     $this->db->where('month(tglmulai) >=',$bulan);
    //     $this->db->where('day(tglmulai) >=',$today);
    //     $this->db->where('admin_ga !=',null);
    //     $this->db->where('status >', '2');
    //     $data['lembur_konfirmasi'] = $this->db->get('lembur')->result_array();
        
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('lembur/persetujuanga', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function persetujuan_lemburhr()
    // {
    //     $data['sidemenu'] = 'HR';
    //     $data['sidesubmenu'] = 'Konfirmasi Lembur';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $data['lembur'] = $this->db->get_where('lembur', ['status' => '7'])->result_array();
    //     $data['lembur_ssc'] = $this->db->get_where('lembur', ['status' => '8'])->result_array();
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('lembur/persetujuanhr', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function konfirmasi_hr($id)
    // {
    //     date_default_timezone_set('asia/jakarta');
    //     $data['sidemenu'] = 'HR';
    //     $data['sidesubmenu'] = 'Konfirmasi Lembur';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
    //     $data['lembur'] = $this->db->get_where('lembur', ['id' => $id])->row_array();
    //     $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();
    //     $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
    //     $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('lembur/konfirmasi_hr', $data);  
    //     $this->load->view('templates/footer');
    // }

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
            $this->load->view('lembur/persetujuanhr', $data);
            $this->load->view('templates/footer');
        }elseif ($section=='ppic'){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Konfirmasi Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['status' => '8'])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanppic', $data);
            $this->load->view('templates/footer');
        }
    }

    public function proses($section,$id)
    {
        date_default_timezone_set('asia/jakarta');
        if ($section=='hr'){
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Konfirmasi Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' => $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/konfirmasi_hr', $data);  
            $this->load->view('templates/footer');
        }elseif ($section=='ppic'){
            $data['sidemenu'] = 'PPIC';
            $data['sidesubmenu'] = 'Konfirmasi Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' => $id])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();
            $data['listproject'] = $this->project_model->fetch_project();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/konfirmasi_ppic', $data);  
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

        if ($this->input->post('konsumsi')!=0)
        {
            //Notifikasi ke USER
            $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
            $konsumsi = $this->db->get_where('lembur_konsumsi', ['id' => $this->input->post('konsumsi')])->row_array();
            $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
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
                        'message' => "*HOREEE!! RENCANA LEMBUR KAMU SUDAH DIKONFIRMASI OLEH GA*" .
                        "\r\n \r\n*RENCANA LEMBUR* kamu dengan detil berikut :" .
                        "\r\n \r\nID *" . $lembur['id'] .'*'. 
                        "\r\nTanggal " . date('d-M H:i', strtotime($lembur['tglmulai_rencana'])) . 
                        "\r\nDurasi " . $lembur['durasi_rencana'] ." Jam " . 
                        "\r\nKonsumsi " . $konsumsi['nama'] . 
                        "\r\nTelah konfirmasi oleh *" . $this->session->userdata('inisial') . "*" .
                        "\r\n \r\nManfaatkan waktu lembur kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
                        "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI LEMBUR* kamu jika sudah selesai lemburnya ya!." .
                        "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" .
                        "\r\n \r\n" . $notifikasi['pesan']
                    ],
                ]
            );
            $body = $response->getBody();
        }

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('lembur/konfirmasi/ga');
    }

    public function submit_konfirmasi_hr()
    {
        date_default_timezone_set('asia/jakarta');
        $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();

        if ($this->input->post('istirahat1')==1){
            $istirahat1 = 'YA';
        }else{
            $istirahat1 = 'TIDAK';
        }

        if ($this->input->post('istirahat2')==0.5){
            $istirahat2 = 'YA';
        }else{
            $istirahat2 = 'TIDAK';
        }

        if ($this->input->post('istirahat3')==1){
            $istirahat3 = 'YA';
        }else{
            $istirahat3 = 'TIDAK';
        }

        $istirahat = $this->input->post('istirahat1') + $this->input->post('istirahat2') + $this->input->post('istirahat3');
        $durasi_hr = $lembur['durasi'] - $istirahat;
    
        $user = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        if ($user['work_contract']=='Direct Labor'){ 
            $this->db->set('tul', $this->input->post('tul'));
            $this->db->set('admin_hr', $this->session->userdata('inisial'));
            $this->db->set('tgl_admin_hr', date('Y-m-d H:i:s'));
            $this->db->set('istirahat1', $istirahat1);
            $this->db->set('istirahat2', $istirahat2);
            $this->db->set('istirahat3', $istirahat3);
            $this->db->set('istirahat', $istirahat);
            $this->db->set('durasi_hr', $durasi_hr);
            $this->db->set('status', '8');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

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
                        'phone' => $user['phone'],
                        'message' => "*HOREEE!! LEMBUR KAMU SUDAH DIKONFIRMASI OLEH HR*" .
                        "\r\n \r\n*LEMBUR* kamu dengan detil berikut :" . 
                        "\r\n \r\nID *" . $lembur['id'] .'*'. 
                        "\r\nNama : *" . $lembur['nama'] .'*'. 
                        "\r\nTanggal : *" . date('d-M H:i', strtotime($lembur['tglmulai'])) ." - " . date('d-M H:i', strtotime($lembur['tglselesai'])) .'*'. 
                        "\r\nDurasi Lembur : *" . $lembur['durasi'] ." Jam* " . 
                        "\r\nIstirahat : *" . $istirahat ." Jam* " . 
                        "\r\nDurasi yang dibayarkan : *" . $durasi_hr . " Jam* " . 
                        "\r\nEstimasi TUL : *" . $this->input->post('tul') .'*'. 
                        "\r\nTelah konfirmasi oleh *" . $this->session->userdata('inisial') . "*" .
                        "\r\n \r\nNote : Durasi yang dibayarkan adalah durasi yang sudah dikurangi dengan jam istirahat kamu" .
                        "\r\nHitungan ini belum dicocokan dengan *PRESENSI* kamu Loh." . 
                        "\r\n*Sooo* ini masih *Estimasi* ya!. Hasil final sangat mungkin berbeda dari ini." .
                        "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" .
                        "\r\n \r\n" . $notifikasi['pesan']
                    ],
                ]
            );
            $body = $response->getBody();
        }else{
            $this->db->set('tul', $this->input->post('tul'));
            $this->db->set('admin_hr', $this->session->userdata('inisial'));
            $this->db->set('tgl_admin_hr', date('Y-m-d H:i:s'));
            $this->db->set('istirahat1', $istirahat1);
            $this->db->set('istirahat2', $istirahat2);
            $this->db->set('istirahat3', $istirahat3);
            $this->db->set('istirahat', $istirahat);
            $this->db->set('durasi_hr', $durasi_hr);
            $this->db->set('status', '9');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->db->set('tglmulai', $lembur['tglmulai']);
            $this->db->set('tglselesai', $lembur['tglselesai']);
            $this->db->set('status', 9);
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->update('aktivitas');

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
                        'phone' => $user['phone'],
                        'message' => "*HOREEE!! LEMBUR KAMU SUDAH DIKONFIRMASI OLEH HR*" .
                        "\r\n \r\n*LEMBUR* kamu dengan detil berikut :" . 
                        "\r\n \r\nID *" . $lembur['id'] .'*'. 
                        "\r\nNama : *" . $lembur['nama'] .'*'. 
                        "\r\nTanggal : *" . date('d-M H:i', strtotime($lembur['tglmulai'])) ." - " . date('d-M H:i', strtotime($lembur['tglselesai'])) .'*'. 
                        "\r\nDurasi Lembur : *" . $lembur['durasi'] ." Jam* " . 
                        "\r\nIstirahat : *" . $istirahat ." Jam* " . 
                        "\r\nDurasi yang dibayarkan : *" . $durasi_hr . " Jam* " . 
                        "\r\nEstimasi TUL : *" . $this->input->post('tul') .'*'. 
                        "\r\nTelah konfirmasi oleh *" . $this->session->userdata('inisial') . "*" .
                        "\r\n \r\nNote : Durasi yang dibayarkan adalah durasi yang sudah dikurangi dengan jam istirahat kamu" .
                        "\r\nHitungan ini belum dicocokan dengan *PRESENSI* kamu Loh." . 
                        "\r\n*Sooo* ini masih *Estimasi* ya!. Hasil final sangat mungkin berbeda dari ini." .
                        "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" .
                        "\r\n \r\n" . $notifikasi['pesan']
                    ],
                ]
            );
            $body = $response->getBody();
        }

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/konfirmasi/hr');
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

    public function submit_konfirmasi_ppic()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();

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

    public function cari_lembur_hr()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $tglmulai = date("Y-m-d 00:00:00", strtotime($this->input->post('tglawal')));
        $tglselesai = date("Y-m-d 23:59:00", strtotime($this->input->post('tglakhir')));

        $querylembur = "SELECT *
                        FROM `lembur`
                        WHERE `tglmulai` >= '$tglmulai' AND `tglmulai` <= '$tglselesai' AND (`status` = '9')
                        ";
        $data['lembur'] = $this->db->query($querylembur)->result_array();
        $data['tglmulai'] = $tglmulai;
        $data['tglselesai'] = $tglselesai;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/laporanhr', $data);
        $this->load->view('templates/footer');
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

    public function gtJamRencana()
    {
        //Update jam setelah isi aktivitas seharusnya masih diperbolehkan
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
        $tglmulai = date("Y-m-d", strtotime($lembur['tglmulai']));

        $tgl = date("Y-m-d", strtotime($lembur['tglmulai']));
        $jam = $this->input->post('jammulai');
        $tglmulai = $tgl .' '. $jam; //Y-m-d H:i:s

        if ($tglmulai < date('Y-m-d H:i'))
        {
            $this->session->set_flashdata('message', 'update');
            redirect('lembur/rencana_aktivitas/' . $this->input->post('id'));
        }else{
                //Hitung total durasi aktivitas
            $this->db->select('SUM(durasi_menit) as total');
            $this->db->where('link_aktivitas', $this->input->post('id'));
            $this->db->from('aktivitas');

            $totalDMenit = $this->db->get()->row()->total;
            $totalDJam = $totalDMenit / 60;
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($tglmulai)));

            $this->db->set('durasi', $totalDJam);
            $this->db->set('tglmulai_rencana', $tglmulai);
            $this->db->set('tglselesai_rencana',$tglselesai);
            $this->db->set('tglmulai', $tglmulai);
            $this->db->set('tglselesai', $tglselesai);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            redirect('lembur/rencana_aktivitas/' . $this->input->post('id'));
        }
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
}
