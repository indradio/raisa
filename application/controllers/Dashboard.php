<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("dashboard_model");
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        //Auto batalkan perjalanan
        $queryPerjalanan = "SELECT *
        FROM `perjalanan`
        WHERE `tglberangkat` <= CURDATE() AND (`status` = 1 OR `status` = 8)
        ";
        $perjalanan = $this->db->query($queryPerjalanan)->result_array();
        foreach ($perjalanan as $p) :
            // cari selisih
            $mulai = strtotime($p['jamberangkat']);
            $selesai = time();
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));

            if ($jam >= 2) {
                $this->db->set('status', '0');
                $this->db->set('catatan_ga', "Waktu keberangkatan perjalanan kamu telah selesai. - Dibatalkan oleh RAISA pada " . date('d-m-Y H:i'));
                $this->db->where('id', $p['id']);
                $this->db->update('perjalanan');

                $this->db->set('status', '9');
                $this->db->where('id', $p['reservasi_id']);
                $this->db->update('reservasi');

                $this->db->where('npk', $p['npk']);
                $karyawan = $this->db->get('karyawan')->row_array();
                $my_apikey = "NQXJ3HED5LW2XV440HCG";
                $destination = $karyawan['phone'];
                $message = "*PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. PERJALANAN : *" . $p['id'] . "*" .
                    "\r\n Nama : *" . $p['nama'] . "*" .
                    "\r\n Tujuan : *" . $p['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $p['keperluan'] . "*" .
                    "\r\n Peserta : *" . $p['anggota'] . "*" .
                    "\r\n Berangkat : *" . $p['tglberangkat'] . "* *" . $p['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $p['tglkembali'] . "* *" . $p['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $p['nopol'] . "* ( *" . $p['kepemilikan'] . "* )" .
                    "\r\n Catatan : *" . $p['catatan_ga'] .  "*" .
                    "\r\n \r\nWaktu keberangkatan perjalanan kamu melebihi 2 Jam / batas waktu keberangkatan. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
                $api_url = "http://panel.apiwha.com/send_message.php";
                $api_url .= "?apikey=" . urlencode($my_apikey);
                $api_url .= "&number=" . urlencode($destination);
                $api_url .= "&text=" . urlencode($message);
                json_decode(file_get_contents($api_url, false));
            }
        endforeach;

        //Auto LEMBUR
        // $this->db->where('status', '4');
        $lembur = $this->db->get('lembur')->result_array();

        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+3 days', strtotime($l['tglselesai_rencana']))));
            $kirim_notif = strtotime(date('Y-m-d H:i:s', strtotime('+64 hours', strtotime($l['tglselesai_rencana']))));
            $expired = strtotime($l['expired_at']);

            if ($l['status']==4){
                // Notifikasi REALISASI tinggal 8 JAM
                if ($kirim_notif < $sekarang and $l['life']==0) { 
                    $notifikasi = $this->db->get_where('notifikasi', ['id' =>  $l['id']])->row_array();
                    if (!isset($notifikasi['id'])){
                        $data = array(
                            'id' => $l['id'],
                            'notifikasi' => 1,
                            'tanggal' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('notifikasi', $data);
        
                        $this->db->where('npk', $l['npk']);
                        $karyawan = $this->db->get('karyawan')->row_array();
                        $my_apikey = "NQXJ3HED5LW2XV440HCG";
                        $destination = $karyawan['phone'];
                        $message = "*WAKTU REALISASI KAMU KURANG DARI 8 JAM*" .
                                    "\r\n \r\n*LEMBUR* kamu dengan detil berikut :". 
                                    "\r\n \r\nNo LEMBUR : *" . $l['id'] ."*". 
                                    "\r\nNama : *" . $l['nama'] ."*". 
                                    "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai_rencana'])) ."*". 
                                    "\r\nDurasi : *" . $l['durasi_rencana'] ." Jam*" .
                                    "\r\n \r\nWaktu *REALISASI LEMBUR* kurang dari *8 JAM*, Ayo segera selesaikan REALISASI kamu." . 
                                    "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
                        $api_url = "http://panel.apiwha.com/send_message.php";
                        $api_url .= "?apikey=" . urlencode($my_apikey);
                        $api_url .= "&number=" . urlencode($destination);
                        $api_url .= "&text=" . urlencode($message);
                        json_decode(file_get_contents($api_url, false));
                    }
                }

                // Batalkan LEMBUR REALISASI
                if ($tempo < $sekarang and $l['life']==0) {
                    $this->db->set('catatan', "Waktu REALISASI LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i'));
                    $this->db->set('status', '0');
                    $this->db->set('last_status', $l['status']);
                    $this->db->where('id', $l['id']);
                    $this->db->update('lembur');

                    $this->db->where('npk', $l['npk']);
                    $karyawan = $this->db->get('karyawan')->row_array();
                    $my_apikey = "NQXJ3HED5LW2XV440HCG";
                    $destination = $karyawan['phone'];
                    $message = "*:( LEMBUR KAMU DIBATALKAN*" .
                                "\r\n \r\n*LEMBUR* kamu dengan detil berikut :". 
                                "\r\n \r\nNo LEMBUR : *" . $l['id'] ."*". 
                                "\r\nNama : *" . $l['nama'] ."*". 
                                "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) ."*". 
                                "\r\nDurasi : *" . $l['durasi'] ." Jam*" .
                                "\r\n \r\nTelah *DIBATALKAN* otomatis oleh SISTEM" .
                                "\r\n \r\nWaktu *REALISASI LEMBUR* kamu melebihi 3x24 Jam dari batas waktu *RENCANA SELESAI LEMBUR*." . 
                                "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
                    $api_url = "http://panel.apiwha.com/send_message.php";
                    $api_url .= "?apikey=" . urlencode($my_apikey);
                    $api_url .= "&number=" . urlencode($destination);
                    $api_url .= "&text=" . urlencode($message);
                    json_decode(file_get_contents($api_url, false));
                }
            }elseif ($l['status']>4 and $l['status']<7){
                 // Batalkan LEMBUR LEWAT 7 HARI
                if ($expired < $sekarang) {
                    $this->db->set('catatan', "Waktu LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i', strtotime($l['expired_at'])));
                    $this->db->set('status', '0');
                    $this->db->set('last_status', $l['status']);
                    $this->db->where('id', $l['id']);
                    $this->db->update('lembur');

                    $this->db->where('npk', $l['npk']);
                    $karyawan = $this->db->get('karyawan')->row_array();
                    $my_apikey = "NQXJ3HED5LW2XV440HCG";
                    $destination = $karyawan['phone'];
                    $message = "*LEMBUR KAMU DIBATALKAN :( *".
                                "\r\n \r\n*LEMBUR* kamu dengan detil berikut :". 
                                "\r\n \r\nNo LEMBUR : *" . $l['id'] ."*". 
                                "\r\nNama : *" . $l['nama'] ."*". 
                                "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) ."*". 
                                "\r\nDurasi : *" . $l['durasi'] ." Jam*".
                                "\r\n \r\nTelah *DIBATALKAN* otomatis oleh SISTEM" .
                                "\r\n \r\nWaktu *LEMBUR* kamu melebihi 7x24 Jam dari batas waktu *RENCANA MULAI LEMBUR*." . 
                                "\r\n \r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com";
                    $api_url = "http://panel.apiwha.com/send_message.php";
                    $api_url .= "?apikey=" . urlencode($my_apikey);
                    $api_url .= "&number=" . urlencode($destination);
                    $api_url .= "&text=" . urlencode($message);
                    json_decode(file_get_contents($api_url, false));
                }
            }
        endforeach;

        $this->db->where('year(tglmulai)',date('Y'));
        $this->db->where('month(tglmulai)',date('m'));
        $this->db->where('day(tglmulai)',date('d'));
        $this->db->where('konsumsi','YA');
        $this->db->where('status >', '2');
        $data['lembur_makan_malam'] = $this->db->get('lembur')->result_array();

        $this->db->where('year(tglmulai)',date('Y'));
        $this->db->where('month(tglmulai)',date('m'));
        $this->db->where('day(tglmulai)',date('d'));
        $this->db->where('status >', '2');
        $data['listlembur'] = $this->db->get('lembur')->result_array();

        $data['listclaim'] = $this->dashboard_model->get_claim();
        $data['listkaryawan'] = $this->dashboard_model->get_karyawan();

        // Halaman dashboard
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['pendapatan'] = $this->db->get('pendapatan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    public function informasi($id)
    {
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['info'] = $this->db->get_where('informasi', ['id' =>  $id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/informasi', $data);
        $this->load->view('templates/footer');
    }

    public function medical($action)
    {
        if ($action=='add'){
            foreach ($this->input->post('karyawan') as $k) :
                $karyawan = $this->db->get_where('karyawan', ['npk' => $k])->row_array();
                $data = [
                    'npk' => $k,
                    'nama' => $karyawan['nama'],
                    'transfer_at' => date('Y-m-d', strtotime($this->input->post('tgltransfer')))
                ];
                $this->db->insert('medical_claim', $data);
            endforeach;
            redirect('dashboard');
        }elseif ($action=='delete'){
            $this->dashboard_model->delete_claim($this->input->post('id'));
            redirect('dashboard');
        }
    }
}
