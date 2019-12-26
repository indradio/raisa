<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gantihari extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->where('status', '0');
        $this->db->where('npk', $this->session->userdata('npk'));
        $gantihari = $this->db->get('gantihari')->result_array();

        foreach ($gantihari as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d'));
            $tempo = strtotime(date('Y-m-d', strtotime('+40 days', strtotime($l['tglmulai']))));

            if ($tempo < $sekarang) {

                //Hapus Aktivitas
                $this->db->set('aktivitas_gantihari');
                $this->db->where('link_aktivitas', $l['id']);
                $this->db->delete('aktivitas_gantihari');

                $this->db->set('gantihari');
                $this->db->where('id', $l['id']);
                $this->db->delete('gantihari');
            }
        endforeach;

        $data['sidemenu'] = 'Ganti Hari';
        $data['sidesubmenu'] = 'Ganti Hariku';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['gantihari'] = $this->db->get_where('gantihari', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/index', $data);
        $this->load->view('templates/footer');
    }

    public function gantihariku($id)
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Ganti Hari';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['gantihari'] = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
        $data['aktivitas_gantihari'] = $this->db->get_where('aktivitas_gantihari', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/gantihariku', $data);
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
        // End Auto Batalkan LEMBUR

        $data['sidemenu'] = 'Ganti Hari';
        $data['sidesubmenu'] = 'Rencana GH';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $npk = $this->session->userdata('npk');
        $pemohon = $this->session->userdata('inisial');
        $queryLembur = "SELECT *
        FROM `gantihari`
        WHERE (`status`= '1' OR `status`= '2' OR `status`= '3') and (`npk`= '$npk' OR  `pemohon`= '$pemohon')";
        $data['gantihari'] = $this->db->query($queryLembur)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/rencana', $data);
        $this->load->view('templates/footer');
    }

    public function realisasi()
    {
        $data['sidemenu'] = 'Ganti Hari';
        $data['sidesubmenu'] = 'Realisasi GH';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $npk = $this->session->userdata('npk');
        $queryGantihari = "SELECT *
        FROM `gantihari`
        WHERE (`status`= '4' OR `status`= '5' OR `status`= '6') and `npk`= '$npk' ";
        $data['gantihari'] = $this->db->query($queryGantihari)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/realisasi', $data);
        $this->load->view('templates/footer');
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
            $queryLemburBulan = "SELECT COUNT(*)
            FROM `gantihari`
            WHERE YEAR(tglmulai) = '$tahun' AND MONTH(tglmulai) = '$bulan'
            ";
            $lembur = $this->db->query($queryLemburBulan)->row_array();
            $totalLembur = $lembur['COUNT(*)'] + 1;

            if (date('D', strtotime($this->input->post('tglmulai'))) == 'Sat' OR date('D', strtotime($this->input->post('tglmulai'))) == 'Sun') {
                $hari = 2;
            }else{
                $hari = 1;
            }


            $data = [
                'id' => 'GH' . date('ym', strtotime($this->input->post('tglmulai'))) . $totalLembur,
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
            $this->db->insert('gantihari', $data);
            redirect('gantihari/rencana_aktivitas/' . $data['id']);
        }
        else{
            $this->session->set_flashdata('message', 'update');
            redirect('gantihari/rencana/');
        }
    }

    public function rencana_aktivitas($id)
    {
        $data['sidemenu'] = 'Ganti Hari';
        $data['sidesubmenu'] = 'Rencana GH';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['gantihari'] = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
        $data['aktivitas_gantihari'] = $this->db->get_where('aktivitas_gantihari', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $data['lembur_lokasi'] = $this->db->get_where('lembur_lokasi')->result_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $queryjamKerjalain = "SELECT *
            FROM `jamkerja_lain`
            WHERE(`dept_id` = '{$karyawan['dept_id']}') ";
            $data['jamkerja_lain'] = $this->db->query($queryjamKerjalain)->result_array();
            
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/rencana_aktivitas', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $copro = $this->input->post('copro');

        $durasiPost = $this->input->post('durasi');
        $durasi_jam = $durasiPost / 60;

        if ($copro) {
            $id = $copro . $gantihari['npk'] . time();
        }else{
            $id = date('ymd') . $gantihari['npk'] . time();
        }

            $data = [
                'id' => $id,
                'npk' => $gantihari['npk'],
                'tgl_aktivitas' => $gantihari['tglmulai'],
                'jenis_aktivitas' => 'GANTI HARI',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'wbs' => $this->input->post('wbs'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => $durasi_jam,
                'deskripsi_hasil' => '',
                'progres_hasil' => '0',
                'dibuat_oleh' => $this->session->userdata('inisial'),
                'status' => '1'
            ];
            $this->db->insert('aktivitas_gantihari', $data);

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas_gantihari');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($gantihari['tglmulai'])));
        
        $mulai = strtotime($gantihari['tglmulai']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas_gantihari');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data gantihari
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi_rencana', $jam . ':' . $menit . ':00');
        $this->db->set('aktivitas_rencana', $totalAktivitas);
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('gantihari');

        if($gantihari['status']=='1'){
            redirect('gantihari/rencana_aktivitas/' . $this->input->post('link_aktivitas'));
        }
        else if ($gantihari['status']=='2' OR $gantihari['status']=='3' OR $gantihari['status']=='5' OR $gantihari['status']=='6'){
            redirect('gantihari/persetujuan_rencana/' . $this->input->post('link_aktivitas'));
        }
    }

    public function update_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas_gantihari', ['id' => $this->input->post('id')])->row_array();
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $durasiPost = $this->input->post('durasi');
        $jam = $durasiPost / 60;

        $this->db->set('aktivitas', $this->input->post('aktivitas'));
        $this->db->set('durasi_menit', $this->input->post('durasi'));
        $this->db->set('durasi', $jam);
        $this->db->set('diubah_oleh', $this->session->userdata('inisial'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('aktivitas_gantihari');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas_gantihari');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($gantihari['tglmulai'])));
        
        $mulai = strtotime($gantihari['tglmulai']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        // Update data GANTI HARI
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi_rencana', $jam . ':' . $menit . ':00');
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('gantihari');

        redirect('gantihari/persetujuan_rencana/' . $this->input->post('link_aktivitas'));
    }

    public function hapus_aktivitas($id)
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas_gantihari', ['id' => $id])->row_array();
        $gantihari = $this->db->get_where('gantihari', ['id' => $aktivitas['link_aktivitas']])->row_array();

        // Hapus AKTIVITAS
        $this->db->set('aktivitas_gantihari');
        $this->db->where('id', $id);
        $this->db->delete('aktivitas_gantihari');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas_gantihari');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        if ($totalDMenit == 0)
        {
            $tglselesai = $gantihari['tglmulai'];
        }else{
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($gantihari['tglmulai'])));
        }
        
        $mulai = strtotime($gantihari['tglmulai']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas_gantihari');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data gantihari
        $this->db->set('tglselesai', $tglselesai);
        $this->db->set('durasi_rencana', $jam . ':' . $menit . ':00');
        $this->db->set('aktivitas_rencana', $totalAktivitas);
        $this->db->where('id', $aktivitas['link_aktivitas']);
        $this->db->update('gantihari');

            if($gantihari['status']=='1'){
                $this->session->set_flashdata('message', 'hapus');
                redirect('gantihari/rencana_aktivitas/' . $aktivitas['link_aktivitas']);
            }
            else if ($gantihari['status']=='2' OR $gantihari['status']=='3'){
                $this->session->set_flashdata('message', 'hapus');
                redirect('gantihari/persetujuan_rencana/' . $aktivitas['link_aktivitas']);
            }
            elseif ($gantihari['status']=='7'){
                redirect('gantihari/konfirmasi_hr/' . $this->input->post('link_aktivitas'));
            }
    }


    public function ajukan_rencana()
    {
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('id')])->row_array();

        if ($this->input->post('lokasi') != 'lainnya')
        {
            $lokasi = $this->input->post('lokasi');
        }else{
            $lokasi = $this->input->post('lokasi_lain');
        }

        if ($gantihari['npk'] == $this->session->userdata('npk'))
        {

            if($this->session->userdata('posisi_id') < 4 OR $this->session->userdata('posisi_id') == 8) 
            {
                $status = '4';
            }else{
                if ($gantihari['atasan1_rencana'] == $gantihari['pemohon']){
                    $status = '3';

                    $this->db->set('status', $status);
                    $this->db->set('lokasi', $lokasi);
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('gantihari');
        
                    // Notification saat mengajukan RENCANA to ATASAN 1
                    $karyawan = $this->db->get_where('karyawan', ['inisial' => $gantihari['atasan2_rencana']])->row_array();
                    $my_apikey = "NQXJ3HED5LW2XV440HCG";
                    $destination = $karyawan['phone'];
                    $message = "*PENGAJUAN RENCANA GANTI HARI*" .
                        "\r\n \r\nNama : *" . $gantihari['nama'] . "*" .
                        "\r\nTanggal : " . date('d-M H:i', strtotime($gantihari['tglmulai'])) . 
                        "\r\nDurasi : " . date('H', strtotime($gantihari['durasi_rencana'])) ." Jam " . date('i', strtotime($gantihari['durasi_rencana']))." Menit." .
                        "\r\n \r\nRENCANA RENCANA GANTI HARI ini telah DISETUJUI oleh *". $gantihari['atasan1_rencana'] ."*".
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

                    $this->db->set('status', $status);
                    $this->db->set('lokasi', $lokasi);
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('gantihari');
        
                    // Notification saat mengajukan RENCANA to ATASAN 1
                    $karyawan = $this->db->get_where('karyawan', ['inisial' => $gantihari['atasan1_rencana']])->row_array();
                    $my_apikey = "NQXJ3HED5LW2XV440HCG";
                    $destination = $karyawan['phone'];
                    $message = "*PENGAJUAN RENCANA gantihari*" .
                        "\r\n \r\nNama : *" . $gantihari['nama'] . "*" .
                        "\r\nTanggal : " . date('d-M H:i', strtotime($gantihari['tglmulai'])) . 
                        "\r\nDurasi : " . date('H', strtotime($gantihari['durasi_rencana'])) ." Jam " . date('i', strtotime($gantihari['durasi_rencana']))." Menit." .
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
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('gantihari');

            // Notification saat mengajukan RENCANA to BAWAHAN 1
            $karyawan = $this->db->get_where('karyawan', ['npk' => $gantihari['npk']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PERINTAH RENCANA gantihari*" .
                "\r\n \r\nNama : *" . $gantihari['nama'] . "*" .
                "\r\nTanggal : " . date('d-M H:i', strtotime($gantihari['tglmulai'])) . 
                "\r\nDurasi : " . date('H', strtotime($gantihari['durasi_rencana'])) ." Jam " . date('i', strtotime($gantihari['durasi_rencana']))." Menit." .
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
       
        redirect('gantihari/rencana/');
    }

    public function batal_gantihari()
    {
        date_default_timezone_set('asia/jakarta');
            $gantihari = $this->db->get_where('gantihari', ['id' =>  $this->input->post('id')])->row_array();
            $this->db->set('catatan', "" . $this->input->post('catatan') . " - Dibatalkan oleh : " . $this->session->userdata['inisial'] ." pada " . date('d-m-Y H:i'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('gantihari');

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
                redirect('gantihari/rencana/');
            }
            else if ($lembur['status']=='4'){
                $this->session->set_flashdata('message', 'batalbr');
                redirect('gantihari/realisasi/');
            }
            else if ($gantihari['status']=='2' OR $gantihari['status']=='3' OR $gantihari['status']=='5' OR $gantihari['status']=='6'){
                $this->session->set_flashdata('message', 'batalbr');
                redirect('gantihari/persetujuan_gantihari/');
            }
            elseif ($gantihari['status']=='7'){
                redirect('gantihari/persetujuan_lemburhr');
            }
    }


    public function persetujuan_gantihari()
    {
        $data['sidemenu'] = 'Ganti Hari';
        $data['sidesubmenu'] = 'Persetujuan GH';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($this->session->userdata('posisi_id') >= 3 AND $this->session->userdata('posisi_id') <= 6) 
        {
            $queryRencanaLembur = "SELECT *
            FROM `gantihari`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' AND `status`= '2') OR (`atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '3') ";
            $data['rencana'] = $this->db->query($queryRencanaLembur)->result_array();

            $queryLembur = "SELECT *
            FROM `gantihari`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' AND `status`= '5') OR (`atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '6') ";
            $data['gantihari'] = $this->db->query($queryLembur)->result_array();

            
        } 
        else if ($this->session->userdata('posisi_id') == 2) 
        {
            $queryRencanaLembur = "SELECT *
            FROM `gantihari`
            WHERE `atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '3' AND `sect_id`= 200 ";
            $data['rencana'] = $this->db->query($queryRencanaLembur)->result_array();

            $queryLembur = "SELECT *
            FROM `gantihari`
            WHERE `atasan2_rencana` = '{$karyawan['inisial']}' AND `status`= '6' AND `sect_id`= 200 ";
            $data['gantihari'] = $this->db->query($queryLembur)->result_array();
        } 
        else 
        {
            $this->load->view('auth/denied');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/persetujuan_gantihari', $data);
        $this->load->view('templates/footer');
    }

    public function persetujuan_rencana($id)
    {
        $gantihari = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
        if (($gantihari['atasan1_rencana']==$this->session->userdata('inisial') AND $gantihari['status']==2) OR ($gantihari['atasan2_rencana']==$this->session->userdata('inisial') AND $gantihari['status']==3))
        {
            $data['sidemenu'] = 'Ganti Hari';
            $data['sidesubmenu'] = 'Persetujuan GH';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['gantihari'] = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
            $data['aktivitas_gantihari'] = $this->db->get_where('aktivitas_gantihari', ['link_aktivitas' =>  $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();

            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

            $queryjamKerjalain = "SELECT *
            FROM `jamkerja_lain`
            WHERE(`dept_id` = '{$karyawan['dept_id']}') ";
            $data['jamkerja_lain'] = $this->db->query($queryjamKerjalain)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('gantihari/persetujuan_rencana', $data);
            $this->load->view('templates/footer');
        } else 
        {
            $this->persetujuan_gantihari();
        }
    }

    public function persetujuan_realisasi($id)
    {
        $gantihari = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
        if (($gantihari['atasan1_rencana']==$this->session->userdata('inisial') AND $gantihari['status']==5) OR ($gantihari['atasan2_rencana']==$this->session->userdata('inisial') AND $gantihari['status']==6))
        {
            $data['sidemenu'] = 'Ganti Hari';
            $data['sidesubmenu'] = 'Persetujuan GH';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['gantihari'] = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
            $data['aktivitas_gantihari'] = $this->db->get_where('aktivitas_gantihari', ['link_aktivitas' =>  $id])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('gantihari/persetujuan_realisasi', $data);
            $this->load->view('templates/footer');
        } else 
        {
            $this->persetujuan_gantihari();
        }
    }

    public function setujui_rencana()
    {
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('id')])->row_array();
        
        // Persetujuan Koordinator / Section Head 
        if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
            $this->db->set('status', '3');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('gantihari');

            //Notifikasi ke ATASAN 2
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $gantihari['atasan2_rencana']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN RENCANA GANTI HARI*" .
            "\r\n \r\nNama : *" . $gantihari['nama'] . "*" .
            "\r\nTanggal : " . date('d-M H:i', strtotime($gantihari['tglmulai'])) . 
            "\r\nDurasi : " . date('H', strtotime($gantihari['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit." .
            "\r\n \r\nRENCANA GANTI HARI ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
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
            if ($gantihari['atasan1_rencana'] == $this->session->userdata('inisial') AND $gantihari['atasan2_rencana'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('gantihari');
            } elseif ($gantihari['atasan1_rencana'] == $this->session->userdata('inisial') AND $gantihari['atasan2_rencana'] != $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('gantihari');
            } elseif ($gantihari['atasan1_rencana'] != $this->session->userdata('inisial') AND $gantihari['atasan2_rencana'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan2_rencana', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('gantihari');
            }

            //Notifikasi ke USER
            $karyawan = $this->db->get_where('karyawan', ['npk' => $gantihari['npk']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*HOREEE!! RENCANA GANTI HARI KAMU SUDAH DISETUJUI*" .
                "\r\n \r\n*RENCANA GANTI HARI* kamu dengan detil berikut :" .
                "\r\n \r\nTanggal " . date('d-M H:i', strtotime($gantihari['tglmulai'])) . 
                "\r\nDurasi " . date('H', strtotime($gantihari['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit.".
                "\r\n \r\nTelah disetujui oleh *" . $this->session->userdata('inisial') . "*" .
                "\r\nManfaatkan waktu ganti hari kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
                "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI GANTI HARI* kamu jika sudah selesai Pekerjaannya ya!." .
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
            $this->db->update('gantihari');

            //Notifikasi ke USER
            $karyawan = $this->db->get_where('karyawan', ['npk' => $gantihari['npk']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*HOREEE!! RENCANA GANTI HARI KAMU SUDAH DISETUJUI*" .
                "\r\n \r\n*RENCANA GANTI HARI* kamu dengan detil berikut :" .
                "\r\n \r\nTanggal " . date('d-M H:i', strtotime($gantihari['tglmulai'])) . 
                "\r\nDurasi " . date('H', strtotime($gantihari['durasi_rencana'])) ." Jam " . date('i', strtotime($lembur['durasi_rencana']))." Menit.".
                "\r\n \r\nTelah disetujui oleh *" . $this->session->userdata('inisial') . "*" .
                "\r\nManfaatkan waktu ganti hari kamu dengan PRODUKTIF dan ingat selalu untuk jaga KESELAMATAN dalam bekerja." .
                "\r\n*JANGAN LUPA* Untuk melaporkan *REALISASI GANTI HARI* kamu jika sudah selesai pekerjaannya ya!." .
                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }

        $this->session->set_flashdata('message', 'setujuigth');
        redirect('gantihari/persetujuan_gantihari/');
    }

    public function setujui_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('id')])->row_array();
        // Persetujuan Koordinator / Section Head 
        if ($this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6) {
            $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
            $this->db->set('status', '6');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('gantihari');

            //Notifikasi ke ATASAN 2
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $gantihari['atasan2_realisasi']])->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN REALISASI GANTI HARI*" .
            "\r\n \r\nNama : *" . $gantihari['nama'] . "*" .
            "\r\nTanggal : " . date('d-M H:i', strtotime($gantihari['tglmulai_aktual'])) . 
            "\r\nDurasi : " . date('H', strtotime($gantihari['durasi_aktual'])) ." Jam " . date('i', strtotime($gantihari['durasi_aktual']))." Menit." .
            "\r\n \r\nREALISASI GANTI HARI ini telah disetujui oleh *". $gantihari['atasan1_realisasi'] ."*".
            "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        } 
        // Persetujuan Dept Head 
        else if ($this->session->userdata('posisi_id') == 3) {
            if ($gantihari['atasan1_realisasi'] == $this->session->userdata('inisial') AND $gantihari['atasan2_realisasi'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('gantihari');
            } elseif ($gantihari['atasan1_realisasi'] == $this->session->userdata('inisial') AND $gantihari['atasan2_realisasi'] != $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan1_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('gantihari');
            } elseif ($gantihari['atasan1_realisasi'] != $this->session->userdata('inisial') AND $gantihari['atasan2_realisasi'] == $this->session->userdata('inisial')) {
                $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('gantihari');
            }
        }
        // Persetujuan Division Head 
        else if ($this->session->userdata('posisi_id') == 2) {
            $this->db->set('atasan2_realisasi', $this->session->userdata('inisial'));
            $this->db->set('tgl_atasan2_realisasi', date('Y-m-d H:i:s'));
            $this->db->set('status', '7');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('gantihari');
        }

        $this->session->set_flashdata('message', 'setujuigth');
        redirect('gantihari/persetujuan_gantihari/');
    }

    public function realisasi_aktivitas($id)
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Ganti Hari';
        $data['sidesubmenu'] = 'Realisasi GH';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['gantihari'] = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
        $data['aktivitas_gantihari'] = $this->db->get_where('aktivitas_gantihari', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $queryjamKerjalain = "SELECT *
            FROM `jamkerja_lain`
            WHERE(`dept_id` = '{$karyawan['dept_id']}') ";
            $data['jamkerja_lain'] = $this->db->query($queryjamKerjalain)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/realisasi_aktivitas', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_aktivitas_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $copro = $this->input->post('copro');

        $durasiPost = $this->input->post('durasi');
        $durasi_jam = $durasiPost / 60;

        if ($copro) {
            $id = $copro . $gantihari['npk'] . time();
        }else{
            $id = date('ymd') . $gantihari['npk'] . time();
        }

        if ($this->input->post('progres_hasil') == 100){
            $status = 9;
        }else{
            $status = 3;
        }

            $data = [
                'id' => $id,
                'npk' => $gantihari['npk'],
                'tgl_aktivitas' => $gantihari['tglmulai'],
                'jenis_aktivitas' => 'GANTI HARI',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'wbs' => $this->input->post('wbs'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => $durasi_jam,
                'deskripsi_hasil' => $this->input->post('deskripsi_hasil'),
                'progres_hasil' => $this->input->post('progres_hasil'),
                'dibuat_oleh' => $this->session->userdata('inisial'),
                'status' => $status
            ];
            $this->db->insert('aktivitas_gantihari', $data);

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('status >', '2');
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas_gantihari');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($gantihari['tglmulai_aktual'])));
        
        $mulai = strtotime($gantihari['tglmulai_aktual']);
        $selesai = strtotime($tglselesai);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        //Hitung total aktivitas
        $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
        $this->db->from('aktivitas_gantihari');

        $totalAktivitas = $this->db->get()->num_rows();

        // Update data gantihari
        $this->db->set('tglselesai_aktual', $tglselesai);
        $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
        $this->db->set('aktivitas', $totalAktivitas);
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('gantihari');

        if($gantihari['status']=='4'){
            redirect('gantihari/realisasi_aktivitas/' . $this->input->post('link_aktivitas'));
        }
        elseif ($gantihari['status']=='5' OR $gantihari['status']=='6'){
            redirect('gantihari/persetujuan_realisasi/' . $this->input->post('link_aktivitas'));
        }
        elseif ($gantihari['status']=='7'){
            redirect('gantihari/konfirmasi_hr/' . $this->input->post('link_aktivitas'));
        }
    }

    public function update_aktivitas_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas_gantihari', ['id' => $this->input->post('id')])->row_array();
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $durasiPost = $this->input->post('durasi');
        $jam = $durasiPost / 60;

        if ($this->input->post('progres_hasil') == 100){
            $status = 9;
        }else{
            $status = 3;
        }

        $this->db->set('deskripsi_hasil', $this->input->post('deskripsi_hasil'));
        $this->db->set('durasi_menit', $this->input->post('durasi'));
        $this->db->set('durasi', $jam);
        $this->db->set('progres_hasil', $this->input->post('progres_hasil'));
        $this->db->set('status', $status);
        $this->db->set('diubah_oleh', $this->session->userdata('inisial'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('aktivitas_gantihari');

       //Hitung total durasi aktivitas
       $this->db->select('SUM(durasi_menit) as total');
       $this->db->where('status >', '2');
       $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
       $this->db->from('aktivitas_gantihari');

       $totalDMenit = $this->db->get()->row()->total;
       $totalDJam = $totalDMenit / 60;
       $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($gantihari['tglmulai_aktual'])));
       
       $mulai = strtotime($gantihari['tglmulai_aktual']);
       $selesai = strtotime($tglselesai);
       $durasi = $selesai - $mulai;
       $jam   = floor($durasi / (60 * 60));
       $menit = $durasi - $jam * (60 * 60);
       $menit = floor($menit / 60);

       //Hitung total aktivitas
       $this->db->where('link_aktivitas', $this->input->post('link_aktivitas'));
       $this->db->where('status >', '2');
       $this->db->from('aktivitas_gantihari');

       $totalAktivitas = $this->db->get()->num_rows();

       // Update data LEMBUR
       $this->db->set('tglselesai_aktual', $tglselesai);
       $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
       $this->db->set('aktivitas', $totalAktivitas);
       $this->db->where('id', $this->input->post('link_aktivitas'));
       $this->db->update('gantihari');

       
        if ($gantihari['status']=='4'){
            redirect('gantihari/realisasi_aktivitas/' . $this->input->post('link_aktivitas'));
        } elseif ($gantihari['status']=='7'){
            redirect('gantihari/konfirmasi_hr/' . $this->input->post('link_aktivitas'));
        }
    }

    public function hapus_aktivitas_realisasi($id)
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas_gantihari', ['id' => $id])->row_array();
        $gantihari = $this->db->get_where('gantihari', ['id' => $aktivitas['link_aktivitas']])->row_array();

        $this->db->set('aktivitas_gantihari');
        $this->db->where('id', $id);
        $this->db->delete('aktivitas_gantihari');

        //Hitung total durasi aktivitas
        $this->db->select('SUM(durasi_menit) as total');
        $this->db->where('status >', '2');
        $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
        $this->db->from('aktivitas_gantihari');

        $totalDMenit = $this->db->get()->row()->total;
        $totalDJam = $totalDMenit / 60;
        if ($totalDMenit == 0)
        {
            $tglselesai = $gantihari['tglmulai_aktual'];
        }else{
            $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($gantihari['tglmulai_aktual'])));
        }
       
       $mulai = strtotime($gantihari['tglmulai_aktual']);
       $selesai = strtotime($tglselesai);
       $durasi = $selesai - $mulai;
       $jam   = floor($durasi / (60 * 60));
       $menit = $durasi - $jam * (60 * 60);
       $menit = floor($menit / 60);

       //Hitung total aktivitas
       $this->db->where('link_aktivitas', $aktivitas['link_aktivitas']);
       $this->db->from('aktivitas_gantihari');

       $totalAktivitas = $this->db->get()->num_rows();

       // Update data LEMBUR
       $this->db->set('tglselesai_aktual', $tglselesai);
       $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
       $this->db->set('aktivitas', $totalAktivitas);
       $this->db->where('id', $aktivitas['link_aktivitas']);
       $this->db->update('gantihari');

       if($gantihari['status']=='4'){
            $this->session->set_flashdata('message', 'hapus');
            redirect('gantihari/realisasi_aktivitas/' . $aktivitas['link_aktivitas']);
        } elseif ($gantihari['status']=='7'){
            $this->session->set_flashdata('message', 'hapus');
            redirect('gantihari/konfirmasi_hr/' . $aktivitas['link_aktivitas']);
        }
    }

    public function gtJamRelalisai()
    {
        date_default_timezone_set('asia/jakarta');
        $rencanaGantihari = $this->db->get_where('gantihari', ['id' =>  $this->input->post('id')])->row_array();
        $tglmulai = date("Y-m-d", strtotime($rencanaGantihari['tglmulai']));
        $this->db->set('tglmulai_aktual', $tglmulai . ' ' . $this->input->post('jammulai'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('gantihari');

        $gantihari = $this->db->get_where('gantihari', ['id' =>  $this->input->post('id')])->row_array(); 
        //Hitung total durasi aktivitas
       $this->db->select('SUM(durasi_menit) as total');
       $this->db->where('status >', '2');
       $this->db->where('link_aktivitas', $this->input->post('id'));
       $this->db->from('aktivitas_gantihari');

       $totalDMenit = $this->db->get()->row()->total;
       $totalDJam = $totalDMenit / 60;
       $tglselesai = date('Y-m-d H:i:s', strtotime('+' . $totalDMenit . 'minute', strtotime($gantihari['tglmulai_aktual'])));
       
       $mulai = strtotime($gantihari['tglmulai_aktual']);
       $selesai = strtotime($tglselesai);
       $durasi = $selesai - $mulai;
       $jam   = floor($durasi / (60 * 60));
       $menit = $durasi - $jam * (60 * 60);
       $menit = floor($menit / 60);

       // Update data gantihari
       $this->db->set('tglselesai_aktual', $tglselesai);
       $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
       $this->db->where('id', $this->input->post('id'));
       $this->db->update('gantihari');

        redirect('gantihari/realisasi_aktivitas/' . $this->input->post('id'));
    }

    public function ajukan_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' => $this->input->post('id')])->row_array();

        if($this->session->userdata('posisi_id') < 4 OR $this->session->userdata('posisi_id') == 8) 
        {
            $status = '7';
        }else{
            $status = '5';
        }

        $this->db->set('status', $status);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('gantihari');

        // Notification saat mengajukan REALISASI to ATASAN 1
        $karyawan = $this->db->get_where('karyawan', ['inisial' => $gantihari['atasan1_realisasi']])->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $karyawan['phone'];
        $message = "*PENGAJUAN REALISASI GANTI HARI*" .
        "\r\n \r\nNama : *" . $gantihari['nama'] . "*" .
        "\r\nTanggal : " . date('d-M H:i', strtotime($gantihari['tglmulai_aktual'])) . 
        "\r\nDurasi : " . date('H', strtotime($gantihari['durasi_aktual'])) ." Jam " . date('i', strtotime($gantihari['durasi_aktual']))." Menit." .
        "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        redirect('gantihari/realisasi/');
    }

    public function konfirmasi_hr($id)
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Konfirmasi Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['gantihari'] = $this->db->get_where('gantihari', ['id' =>  $id])->row_array();
        $data['aktivitas_gantihari'] = $this->db->get_where('aktivitas_gantihari', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/konfirmasi_hr', $data);  
        $this->load->view('templates/footer');
    }

    public function persetujuan_gantihariga()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Konfirmasi Ganti Hari';
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
        $data['gantihari'] = $this->db->get('gantihari')->result_array();

        $this->db->where('year(tglmulai)',$tahun);
        $this->db->where('month(tglmulai)',$bulan);
        $this->db->where('day(tglmulai) >=',$today);
        $this->db->where('admin_ga !=',null);
        $this->db->where('status >', '2');
        $data['gantihari_konfirmasi'] = $this->db->get('gantihari')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('gantihari/persetujuanga', $data);
        $this->load->view('templates/footer');
    }

    public function submit_konfirmasi_ga()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('admin_ga', $this->session->userdata('inisial'));
        $this->db->set('tgl_admin_ga', date('Y-m-d  H:i:s'));
        $this->db->set('konsumsi', $this->input->post('konsumsi'));
        $this->db->where_in('id', $this->input->post('id'));
        $this->db->update('gantihari');

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('gantihari/persetujuan_gantihariga/');
    }

    public function submit_konfirmasi_hr()
    {
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' =>  $this->input->post('id')])->row_array();

        $jammulai = date('H:i', strtotime($gantihari['tglmulai_aktual']));
        $jamselesai = date('H:i', strtotime($gantihari['tglselesai_aktual']));

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

        $this->db->select('SUM(durasi) as total');
        $this->db->where('link_aktivitas', $gantihari['id']);
        $this->db->where('status >', '2');
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
        $this->db->update('gantihari');

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

        $this->session->set_flashdata('message', 'setujuigth');
        redirect('lembur/persetujuan_lemburhr');
    }

    public function gtJamRencana()
    {
        //Update jam setelah isi aktivitas seharusnya masih diperbolehkan
        date_default_timezone_set('asia/jakarta');
        $gantihari = $this->db->get_where('gantihari', ['id' =>  $this->input->post('id')])->row_array();
        $tglmulai = date("Y-m-d", strtotime($gantihari['tglmulai']));

        $tgl = date("Y-m-d", strtotime($gantihari['tglmulai']));
        $jam = $this->input->post('jammulai');
        $tglmulai = $tgl .' '. $jam; //Y-m-d H:i:s

        if ($tglmulai < date('Y-m-d H:i'))
            {
                $this->session->set_flashdata('message', 'update');
                redirect('gantihari/rencana_aktivitas/' . $this->input->post('id'));
            }
        else
            {
                $this->db->set('tglmulai', $tglmulai);
                $this->db->set('tglselesai',$tglmulai);
                $this->db->set('tglmulai_aktual', $tglmulai);
                $this->db->set('tglselesai_aktual', $tglmulai);
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('gantihari');

                redirect('gantihari/rencana_aktivitas/' . $this->input->post('id'));
            }
    }

    public function batal_lembur()
    {
        date_default_timezone_set('asia/jakarta');
            $gantihari = $this->db->get_where('gantihari', ['id' =>  $this->input->post('id')])->row_array();
            $this->db->set('catatan', "" . $this->input->post('catatan') . " - Dibatalkan oleh : " . $this->session->userdata['inisial'] ." pada " . date('d-m-Y H:i'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('gantihari');

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

            if($gantihari['status']=='1'){
                $this->session->set_flashdata('message', 'batalbr');
                redirect('gantihari/rencana/');
            }
            else if ($gantihari['status']=='4'){
                $this->session->set_flashdata('message', 'batalbr');
                redirect('gantihari/realisasi/');
            }
            else if ($gantihari['status']=='2' OR $gantihari['status']=='3' OR $gantihari['status']=='5' OR $gantihari['status']=='6'){
                $this->session->set_flashdata('message', 'batalbr');
                redirect('gantihari/persetujuan_gantihari/');
            }
            elseif ($gantihari['status']=='7'){
                redirect('lembur/persetujuan_lemburhr');
            }
    }

    public function reportgh($id)
    {
        $data['sidemenu'] = 'GANTI HARI';
        $data['sidesubmenu'] = 'Ganti Hariku';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['gantihari']  = $this->db->get_where('gantihari', ['id' => $id])->row_array();
        $data['jamkerja_kategori']  = $this->db->get_where('jamkerja_kategori', ['id' => $id])->row_array();
        $data['aktivitas_gantihari']  = $this->db->get_where('aktivitas_gantihari', ['link_aktivitas' => $id])->result_array();

        $this->load->view('gantihari/reportgh', $data);
    }
    

}
