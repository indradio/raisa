<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lembur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
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
        $rencanalembur = $this->db->get('lembur')->result_array();

        foreach ($rencanalembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+1 hours', strtotime($l['tglmulai']))));

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
        WHERE (`status`= '1' OR `status`= '2' OR `status`= '3') and (`npk`= '$npk' OR  `pemohon`= '$pemohon')";
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

    public function tambah()
    {
                date_default_timezone_set('asia/jakarta');
                $karyawan = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
                $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();


                $this->db->where('year(tglmulai)', date('Y'));
                $this->db->where('month(tglmulai)', date('m'));
                $lembur = $this->db->get('lembur');
                $total_lembur = $lembur->num_rows()+1;
                $id = 'OT'.date('ym'). sprintf("%04s", $total_lembur);

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
                    'tglpengajuan' => date('Y-m-d H:i:s'),
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $karyawan['nama'],
                    'tglmulai' => $tglmulai,
                    'tglselesai' => $tglmulai,
                    'tglmulai_aktual' => $tglmulai,
                    'tglselesai_aktual' => $tglmulai,
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
                    'posisi_id' => $karyawan['posisi_id'],
                    'div_id' => $karyawan['div_id'],
                    'dept_id' => $karyawan['dept_id'],
                    'sect_id' => $karyawan['sect_id'],
                    'pemohon' => $this->session->userdata('inisial')
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
                'npk' => $this->session->userdata('npk'),
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
            $data['lembur_lokasi'] = $this->db->get_where('lembur_lokasi')->result_array();
            
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
        if ($lembur['npk'] == $this->session->userdata('npk') or $lembur['pemohon'] == $this->session->userdata('inisial')){
            if ($lembur['status']==4){
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
    
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('lembur/lemburku', $data);
                $this->load->view('templates/footer');
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
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai'])));
        
        $mulai = strtotime($lembur['tglmulai']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi_rencana', $jam . ':' . $menit . ':00');
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
        
        $mulai = strtotime($lembur['tglmulai']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        // Update data LEMBUR
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi_rencana', $jam . ':' . $menit . ':00');
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
        
        $mulai = strtotime($lembur['tglmulai']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi_rencana', $jam . ':' . $menit . ':00');
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
                redirect('lembur/konfirmasi_hr/' . $this->input->post('link_aktivitas'));
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

            $data = [
                'id' => $id,
                'npk' => $lembur['npk'],
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
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
        $this->db->where('status >', '1');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_aktual'])));
        
        $mulai = strtotime($lembur['tglmulai_aktual']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data LEMBUR
        $this->db->set('tglselesai_aktual', $tglselesai);
        $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
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
            redirect('lembur/konfirmasi_hr/' . $this->input->post('link_aktivitas'));
        }
    }

    public function update_aktivitas_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();

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
       $this->db->where('status >', '1');
       $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
       $this->db->from('aktivitas');

       $totalDMenit = $this->db->get()->row()->total;
       $totalDJam = $totalDMenit / 60;
       $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_aktual'])));
       
       $mulai = strtotime($lembur['tglmulai_aktual']);
       $selesai = strtotime($tglselesai);
       $durasi = $selesai - $mulai;
       $jam   = floor($durasi / (60 * 60));
       $menit = $durasi - $jam * (60 * 60);
       $menit = floor($menit / 60);

       //Hitung total aktivitas
       $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
       $this->db->where('status >', '1');
       $this->db->from('aktivitas');

       $totalAktivitas = $this->db->get()->num_rows();

       // Update data LEMBUR
       $this->db->set('tglselesai_aktual', $tglselesai);
       $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
       $this->db->set('aktivitas', $totalAktivitas);
       $this->db->where('id', $this->input->post('link_aktivitas'));
       $this->db->update('lembur');

       
        if ($lembur['status']=='4'){
            redirect('lembur/realisasi_aktivitas/' . $this->input->post('link_aktivitas'));
        } elseif ($lembur['status']=='7'){
            redirect('lembur/konfirmasi_hr/' . $this->input->post('link_aktivitas'));
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
        $this->db->where('status >', '1');
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        if ($totalDMenit == 0)
        {
            $tglselesai = $lembur['tglmulai_aktual'];
        }else{
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_aktual'])));
        }
       
       $mulai = strtotime($lembur['tglmulai_aktual']);
       $selesai = strtotime($tglselesai);
       $durasi = $selesai - $mulai;
       $jam   = floor($durasi / (60 * 60));
       $menit = $durasi - $jam * (60 * 60);
       $menit = floor($menit / 60);

       //Hitung total aktivitas
       $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
       $this->db->from('aktivitas');

       $totalAktivitas = $this->db->get()->num_rows();

       // Update data LEMBUR
       $this->db->set('tglselesai_aktual', $tglselesai);
       $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
       $this->db->set('aktivitas', $totalAktivitas);
       $this->db->where('id', $aktivitas['link_aktivitas']);
       $this->db->update('lembur');

       if($lembur['status']=='4'){
            $this->session->set_flashdata('message', 'hapus');
            redirect('lembur/realisasi_aktivitas/' . $aktivitas['link_aktivitas']);
        } elseif ($lembur['status']=='7'){
            $this->session->set_flashdata('message', 'hapus');
            redirect('lembur/konfirmasi_hr/' . $aktivitas['link_aktivitas']);
        }
    }

    public function ajukan_rencana()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();

        if ($this->input->post('lokasi') != 'lainnya')
        {
            $lokasi = $this->input->post('lokasi');
        }else{
            $lokasi = $this->input->post('lokasi_lain');
        }

        if ($lembur['npk'] == $this->session->userdata('npk'))
        {
            if($this->session->userdata('posisi_id') < 4 OR $this->session->userdata('posisi_id') == 8) 
            {
                $status = '4';

                $this->db->set('status', $status);
                $this->db->set('lokasi', $lokasi);
                $this->db->set('catatan', $this->input->post('catatan'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            }else{
                if ($lembur['atasan1_rencana'] == $lembur['pemohon']){
                    $status = '3';

                    $this->db->set('tglpengajuan', date('Y-m-d H:i:s'));
                    $this->db->set('status', $status);
                    $this->db->set('lokasi', $lokasi);
                    $this->db->set('catatan', $this->input->post('catatan'));
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('lembur');
        
                    // Notification saat mengajukan RENCANA to ATASAN 2
                    $karyawan = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2_rencana']])->row_array();
                    $my_apikey = "NQXJ3HED5LW2XV440HCG";
                    $destination = $karyawan['phone'];
                    $message = "*PENGAJUAN RENCANA LEMBUR*" .
                        "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                        "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                        "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
                        "\r\n \r\nRENCANA LEMBUR ini telah DISETUJUI oleh *". $lembur['atasan1_rencana'] ."*".
                        "\r\nHarap segera respon *Setujui/Batalkan*".
                        "\r\n \r\n*Semakin lama kamu merespon, semakin sedikit waktu tim kamu membuat realisasi*".
                        "\r\n Untuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
                    $api_url = "http://panel.apiwha.com/send_message.php";
                    $api_url .= "?apikey=" . urlencode($my_apikey);
                    $api_url .= "&number=" . urlencode($destination);
                    $api_url .= "&text=" . urlencode($message);
                    json_decode(file_get_contents($api_url, false));
                }else{
                    $status = '2';

                    $this->db->set('tglpengajuan', date('Y-m-d H:i:s'));
                    $this->db->set('status', $status);
                    $this->db->set('lokasi', $lokasi);
                    $this->db->set('catatan', $this->input->post('catatan'));
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('lembur');
        
                    // Notification saat mengajukan RENCANA to ATASAN 1
                    $karyawan = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1_rencana']])->row_array();
                    $my_apikey = "NQXJ3HED5LW2XV440HCG";
                    $destination = $karyawan['phone'];
                    $message = "*PENGAJUAN RENCANA LEMBUR*" .
                        "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                        "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                        "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
                        "\r\n \r\nHarap segera respon *Setujui/Batalkan*".
                        "\r\n \r\nRespon sebelum jam 4 sore agar tim kamu *Dipesankan makan malamnya".
                        "\r\nKalau kamu belum respon, tim kamu tidak bisa melakukan realisasi".
                        "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
                    $api_url = "http://panel.apiwha.com/send_message.php";
                    $api_url .= "?apikey=" . urlencode($my_apikey);
                    $api_url .= "&number=" . urlencode($destination);
                    $api_url .= "&text=" . urlencode($message);
                    json_decode(file_get_contents($api_url, false));
                }
            }
        }
        else
        {
            $this->db->set('lokasi', $lokasi);
            $this->db->set('catatan', $this->input->post('catatan'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            // Notification saat mengajukan RENCANA to BAWAHAN 1
            $karyawan = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PERINTAH RENCANA LEMBUR*" .
                "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
                "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
                "\r\n \r\nHarap segera respon *Terima/Batalkan*".
                "\r\n \r\nRespon sebelum jam 4 sore agar kamu *dipesankan makan malamnya".
                "\r\nKalau kamu belum respon, kamu tidak bisa melakukan realisasi".
                "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));

        }
       
        redirect('lembur/rencana/');
    }

    public function ajukan_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();

        if($this->session->userdata('posisi_id') < 4 OR $this->session->userdata('posisi_id') == 8) 
        {
            $status = '7';
        }else{
            $status = '5';
        }

        $this->db->set('tglrealisasi', date('Y-m-d H:i:s'));
        $this->db->set('status', $status);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        // Notification saat mengajukan REALISASI to ATASAN 1
        $karyawan = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1_realisasi']])->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $karyawan['phone'];
        $message = "*PENGAJUAN REALISASI LEMBUR*" .
        "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
        "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai_aktual'])) . 
        "\r\nDurasi : " . date('H', strtotime($lembur['durasi_aktual'])) ." Jam " . date('i', strtotime($lembur['durasi_aktual']))." Menit." .
        "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        redirect('lembur/realisasi/');
    }

    public function persetujuan_lembur()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Persetujuan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($this->session->userdata('posisi_id') >= 3 AND $this->session->userdata('posisi_id') <= 6) 
        {
            $queryRencanaLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' AND `status`= '2') OR (`atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '3') ";
            $data['rencana'] = $this->db->query($queryRencanaLembur)->result_array();

            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' AND `status`= '5') OR (`atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '6') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();
        } 
        else if ($this->session->userdata('posisi_id') == 2) 
        {
            $queryRencanaLembur = "SELECT *
            FROM `lembur`
            WHERE `atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '3' AND `sect_id`= 200 ";
            $data['rencana'] = $this->db->query($queryRencanaLembur)->result_array();

            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE `atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '6' AND `sect_id`= 200 ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();
        } 
        else 
        {
            $this->load->view('auth/denied');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuan_lembur', $data);
        $this->load->view('templates/footer');
    }

    public function setujui_rencana()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        // Persetujuan Koordinator / Section Head 
        if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
            $this->db->set('status', '3');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            //Notifikasi ke ATASAN 2
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2_rencana']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN RENCANA LEMBUR*" .
            "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
            "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
            "\r\nDurasi : " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
            "\r\n \r\nRENCANA LEMBUR ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
            "\r\nHarap segera respon *Setujui/Batalkan*".
            "\r\n \r\n*Semakin lama kamu merespon, semakin sedikit waktu tim kamu membuat realisasi*".
            "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        } 
        // Persetujuan Dept Head 
        else if ($this->session->userdata('posisi_id') == 3) {
            if ($lembur['atasan1_rencana'] == $this->session->userdata('inisial') AND $lembur['atasan2_rencana'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1_rencana'] == $this->session->userdata('inisial') AND $lembur['atasan2_rencana'] != $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1_rencana'] != $this->session->userdata('inisial') AND $lembur['atasan2_rencana'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            }

            if ($this->input->post('kategori')){
                $this->db->set('kategori', $this->input->post('kategori'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            }

            //Notifikasi ke USER
            $karyawan = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*HOREEE!! RENCANA LEMBUR KAMU SUDAH DISETUJUI*" .
                "\r\n \r\n*RENCANA LEMBUR* kamu dengan detil berikut :" .
                "\r\n \r\nTanggal " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                "\r\nDurasi " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit.".
                "\r\n \r\nTelah disetujui oleh *" . $this->session->userdata('inisial') . "*" .
                "\r\nManfaatkan waktu lembur kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
                "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI LEMBUR* kamu jika sudah selesai lemburnya ya!." .
                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }
        // Persetujuan Division Head 
        else if ($this->session->userdata('posisi_id') == 2) {
            $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
            $this->db->set('status', '4');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            //Notifikasi ke USER
            $karyawan = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*HOREEE!! RENCANA LEMBUR KAMU SUDAH DISETUJUI*" .
                "\r\n \r\n*RENCANA LEMBUR* kamu dengan detil berikut :" .
                "\r\n \r\nTanggal " . date('d-M H:i', strtotime($lembur['tglmulai'])) . 
                "\r\nDurasi " . date('H', strtotime($lembur['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit.".
                "\r\n \r\nTelah disetujui oleh *" . $this->session->userdata('inisial') . "*" .
                "\r\nManfaatkan waktu lembur kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
                "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI LEMBUR* kamu jika sudah selesai lemburnya ya!." .
                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_lembur/');
    }

    public function setujui_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('id')])->row_array();
        // Persetujuan Koordinator / Section Head 
        if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
            $this->db->set('status', '6');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            //Notifikasi ke ATASAN 2
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2_realisasi']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN REALISASI LEMBUR*" .
            "\r\n \r\nNama : *" . $lembur['nama'] . "*" .
            "\r\nTanggal : " . date('d-M H:i', strtotime($lembur['tglmulai_aktual'])) . 
            "\r\nDurasi : " . date('H', strtotime($lembur['durasi_aktual'])) ." Jam " . date('i', strtotime($lembur['durasi_aktual']))." Menit." .
            "\r\n \r\nREALISASI LEMBUR ini telah disetujui oleh *". $lembur['atasan1_realisasi'] ."*".
            "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        } 
        // Persetujuan Dept Head 
        else if ($this->session->userdata('posisi_id') == 3) {
            if ($lembur['atasan1_realisasi'] == $this->session->userdata('inisial') AND $lembur['atasan2_realisasi'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1_realisasi'] == $this->session->userdata('inisial') AND $lembur['atasan2_realisasi'] != $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            } elseif ($lembur['atasan1_realisasi'] != $this->session->userdata('inisial') AND $lembur['atasan2_realisasi'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');
            }
        }
        // Persetujuan Division Head 
        else if ($this->session->userdata('posisi_id') == 2) {
            $this->db->set('atasan2_realisasi', $this->session->userdata('inisial'));
            $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
            $this->db->set('status', '7');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        }

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_lembur/');
    }

    public function batal_lembur()
    {
        date_default_timezone_set('asia/jakarta');
            $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
            $this->db->set('catatan', "" . $this->input->post('catatan') . " - Dibatalkan oleh : " . $this->session->userdata['inisial'] ." pada " . date('d-m-Y H:i'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            //Planing next
            // $this->db->set('catatan', "" . $this->input->post('catatan') . " - Dibatalkan oleh : " . $this->session->userdata['inisial'] ." Pada " . date('d-m-Y H:i'));
            // $this->db->set('tglselesai', $lembur['tglmulai']);
            // $this->db->set('durasi', '00:00:00');
            // $this->db->set('tglselesai_aktual', $lembur['tglmulai_aktual']);
            // $this->db->set('durasi_aktual', '00:00:00');
            // $this->db->set('status', '0');
            // $this->db->where('id', $this->input->post('id'));
            // $this->db->update('lembur');

            // $this->db->set('aktivitas');
            // $this->db->where('link_aktivitas', $this->input->post('id'));
            // $this->db->delete('aktivitas');

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
            $this->db->set('catatan', $this->input->post('catatan').' - oleh '. $this->session->userdata('inisial'));
            $this->db->set('status', '4');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            redirect('lembur/persetujuan_lembur');
    }

    public function persetujuan_lemburga()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Konfirmasi Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $today = date('d');
        $bulan = date('m');
        $tahun = date('Y');

        $this->db->where('year(tglmulai)',$tahun);
        $this->db->where('month(tglmulai)',$bulan);
        $this->db->where('day(tglmulai) >=',$today);
        $this->db->where('admin_ga',null);
        $this->db->where('status >', '2');
        $this->db->order_by('tglmulai', 'ASC');
        $data['lembur'] = $this->db->get('lembur')->result_array();

        $this->db->where('year(tglmulai)',$tahun);
        $this->db->where('month(tglmulai)',$bulan);
        $this->db->where('day(tglmulai) >=',$today);
        $this->db->where('admin_ga !=',null);
        $this->db->where('status >', '2');
        $data['lembur_konfirmasi'] = $this->db->get('lembur')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuanga', $data);
        $this->load->view('templates/footer');
    }

    public function submit_konfirmasi_ga()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('admin_ga', $this->session->userdata('inisial'));
        $this->db->set('tgl_admin_ga', date('Y-m-d  H:i:s'));
        $this->db->set('konsumsi', $this->input->post('konsumsi'));
        $this->db->where_in('id', $this->input->post('id'));
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('lembur/persetujuan_lemburga/');
    }

    public function persetujuan_lemburhr()
    {
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
    }

    public function konfirmasi_hr($id)
    {
        date_default_timezone_set('asia/jakarta');
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
    }

    public function submit_konfirmasi_hr()
    {
        date_default_timezone_set('asia/jakarta');
        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();

        $jammulai = date('H:i', strtotime($lembur['tglmulai_aktual']));
        $jamselesai = date('H:i', strtotime($lembur['tglselesai_aktual']));

        if ($jammulai < '12:00' AND $jamselesai > '13:00'){
            $istirahat1 = 'YA';
        }else{
            $istirahat1 = 'TIDAK';
        }

        if ($jammulai < '18:30' AND $jamselesai > '19:00'){
            $istirahat2 = 'YA';
        }else{
            $istirahat2 = 'TIDAK';
        }

    
        $this->db->set('tglmulai', $lembur['tglmulai_aktual']);
        $this->db->set('tglselesai', $lembur['tglselesai_aktual']);
        $this->db->set('status', 9);
        $this->db->where('link_aktivitas', $jamkerja['id']);
        $this->db->update('aktivitas');

        $this->db->select('SUM(durasi) as total');
        $this->db->where('link_aktivitas',$this->input->post('id'));
        $this->db->where('status >', '1');
        $this->db->from('aktivitas');
        $totalDurasi = $this->db->get()->row()->total;

        $this->db->set('durasi', $totalDurasi);
        $this->db->set('tul', $this->input->post('tul'));
        $this->db->set('admin_hr', $this->session->userdata('inisial'));
        $this->db->set('tgl_admin_hr', date('Y-m-d H:i:s'));
        $this->db->set('istirahat1', $istirahat1);
        $this->db->set('istirahat2', $istirahat2);
        $this->db->set('status', '9');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        //Notifikasi ke USER
        // $karyawan = $this->db->get_where('karyawan', ['npk' => $lembur['npk']])->row_array();
        // $my_apikey = "NQXJ3HED5LW2XV440HCG";
        // $destination = $karyawan['phone'];
        // $message = "*ASYIIK LEMBUR KAMU SUDAH DIPROSES OLEH HR*" .
        //     "\r\n \r\n*LEMBUR* kamu dengan detil berikut :". 
        //     "\r\n \r\nNo LEMBUR : *" . $lembur['id'] ."*". 
        //     "\r\nNama : *" . $karyawan['nama'] ."*". 
        //     "\r\nTanggal : *" . date('d-M H:i', strtotime($lembur['tglmulai_aktual'])) ."*". 
        //     "\r\nDurasi : *" . date('H', strtotime($lembur['durasi_aktual'])) ." Jam " . date('i', strtotime($lembur['durasi_aktual']))." Menit*".
        //     "\r\n \r\nMendapatkan : *" . $this->input->post('tul') . " TUL*" .
        //     "\r\n \r\nHitungan ini belum dicocokan dengan *PRESENSI* kamu Loh." . 
        //     "\r\n*INGET* ini masih *Estimasi* ya!. Hasil final sangat mungkin lebih kecil dari ini." .
        //     "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
        // $api_url = "http://panel.apiwha.com/send_message.php";
        // $api_url .= "?apikey=" . urlencode($my_apikey);
        // $api_url .= "&number=" . urlencode($destination);
        // $api_url .= "&text=" . urlencode($message);
        // json_decode(file_get_contents($api_url, false));

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_lemburhr');
    }

    public function persetujuan_rencana($id)
    {
        $lembur = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        if (($lembur['atasan1_rencana']==$this->session->userdata('inisial') AND $lembur['status']==2) OR ($lembur['atasan2_rencana']==$this->session->userdata('inisial') AND $lembur['status']==3))
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
        if (($lembur['atasan1_rencana']==$this->session->userdata('inisial') AND $lembur['status']==5) OR ($lembur['atasan2_rencana']==$this->session->userdata('inisial') AND $lembur['status']==6))
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

    public function setujui_ga($id)
    {
        date_default_timezone_set('asia/jakarta');
        $admin_ga = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->db->set('admin_ga', $admin_ga['inisial']);
        $this->db->set('tgl_admin_ga', date('y-m-d  H:i:s'));
        $this->db->where_in('id', $id);
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('lembur/persetujuan_lemburga/');
    }

    public function setujui_all($id)
    {
        date_default_timezone_set('asia/jakarta');
        $admin_ga = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->db->set('admin_ga', $admin_ga['inisial']);
        $this->db->set('tgl_admin_ga', date('y-m-d  H:i:s'));
        $this->db->where('admin_ga', '-');
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('lembur/persetujuan_lemburga/');
    }

    //temp
    public function setujui_hr($id)
    {
        date_default_timezone_set('asia/jakarta');
        $admin_hr = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $id])->row_array();
        // $l = $lembur['id'];
        $this->db->set('admin_hr', $admin_hr['inisial']);
        $this->db->set('tgl_admin_hr', date('y-m-d  H:i:s'));
        $this->db->set('status', '9');
        $this->db->where('id', $id);
        $this->db->update('lembur');

        $aktivitas = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();
        foreach($aktivitas as $a):
            $this->db->set('tglmulai', $lembur['tglmulai_aktual']);
            $this->db->set('tglselesai', $lembur['tglselesai_aktual']);
            $this->db->set('status', 9);
            $this->db->where('id', $a['id']);
            $this->db->update('aktivitas');
        endforeach;

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_lemburhr/' . $id);
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
        // $querylembur = "SELECT * 
        //                 FROM `lembur` 
        //                 WHERE `tglmulai` >= '$tglawal' AND `tglselesai` <= '$tglakhir' AND `sect_id` = '$section' AND `status` = '9'
        //                 ORDER BY `tglmulai` ASC
        //                 ";
        // $data['lembur'] = $this->db->query($querylembur)->result_array();

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
                                    WHERE `tglmulai` >= '$tglmulai' AND `tglselesai` <= '$tglselesai' AND (`status` = '9')
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
        $querylembur =  "SELECT *
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
            }
        else
            {
                $this->db->set('tglmulai', $tglmulai);
                $this->db->set('tglselesai',$tglmulai);
                $this->db->set('tglmulai_aktual', $tglmulai);
                $this->db->set('tglselesai_aktual', $tglmulai);
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('lembur');

                redirect('lembur/rencana_aktivitas/' . $this->input->post('id'));
            }
    }

    public function gtJamRelalisai()
    {
        date_default_timezone_set('asia/jakarta');
        $rencanalembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
        $tglmulai = date("Y-m-d", strtotime($rencanalembur['tglmulai']));
        $this->db->set('tglmulai_aktual', $tglmulai . ' ' . $this->input->post('jammulai'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        $lembur = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array(); 
        //Hitung total durasi aktivitas
       $this->db->select('SUM(durasi_menit) as total');
       $this->db->where('status >', '1');
       $this->db->where('link_aktivitas', $this->input->post('id'));
       $this->db->from('aktivitas');

       $totalDMenit = $this->db->get()->row()->total;
       $totalDJam = $totalDMenit / 60;
       $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($lembur['tglmulai_aktual'])));
       
       $mulai = strtotime($lembur['tglmulai_aktual']);
       $selesai = strtotime($tglselesai);
       $durasi = $selesai - $mulai;
       $jam   = floor($durasi / (60 * 60));
       $menit = $durasi - $jam * (60 * 60);
       $menit = floor($menit / 60);

       // Update data LEMBUR
       $this->db->set('tglselesai_aktual', $tglselesai);
       $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
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

    public function laporan()
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
