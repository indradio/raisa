<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("dashboard_model");
    }

    public function notifications()
    {
        //Notif lembur hari ini to GA
        $n = time();
        $m = strtotime(date('Y-m-d 16:00:00'));
        if ($n > $m){
            $id = 'GA'.date('ymd');
            $cekn = $this->db->get_where('notifikasi', ['id' =>  $id])->row_array();
            if (empty($cekn)){
                $today = date('d');
                $bulan = date('m');
                $tahun = date('Y');
                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulan);
                $this->db->where('day(tglmulai)',$today);
                $this->db->where('lokasi !=','WTQ');
                $this->db->where('status >', '2');
                $lembur_cus = $this->db->get('lembur');

                $this->db->where('year(tglmulai)',$tahun);
                $this->db->where('month(tglmulai)',$bulan);
                $this->db->where('day(tglmulai)',$today);
                $this->db->where('lokasi','WTQ');
                $this->db->where('status >', '2');
                $lembur_wtq = $this->db->get('lembur');

                $data = array(
                    'id' => $id,
                    'notifikasi' => 1,
                    'tanggal' => date('Y-m-d H:i:s')
                );
                $this->db->insert('notifikasi', $data);

                $this->db->where('sect_id', '214');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();
             
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
                            'phone' => $ga_admin['phone'],
                            'message' => "*INFORMASI LEMBUR HARI INI*" . 
                            "\r\n \r\nTanggal : *" . date('d M Y') . "*" .
                            "\r\nLembur di WINTEQ : *" . $lembur_wtq->num_rows() . "*" .
                            "\r\nLembur di Customer : *" . $lembur_cus->num_rows() . "*" .
                            "\r\n \r\nMohon segera konfirmasi untuk konsumsi.".
                            "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
            }
        }

        $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        
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
            $menit   = floor($durasi / 60);
            $user = $this->db->get_where('karyawan', ['npk' => $p['npk']])->row_array();
            
            if (($p['copro']!='NON PROJEK' and $jam >= 1)or($p['copro']=='NON PROJEK' and $jam >= 2)) {
                $this->db->set('status', '0');
                $this->db->set('last_status', $p['status']);
                $this->db->set('catatan', "Waktu keberangkatan perjalanan kamu telah selesai. - Dibatalkan oleh SYSTEM pada " . date('d-m-Y H:i'));
                $this->db->where('id', $p['id']);
                $this->db->update('perjalanan');

                $this->db->set('status', '9');
                $this->db->where('id', $p['reservasi_id']);
                $this->db->update('reservasi');

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
                            'message' => "*[DIBATALKAN] PERJALANAN DINAS KAMU MELEBIHI BATAS WAKTU KEBERANGKATAN*". 
                                "\r\n \r\n No. PERJALANAN : *" . $p['id'] . "*" .
                                "\r\nTujuan : *" . $p['tujuan'] . "*" .
                                "\r\nKeperluan : *" . $p['keperluan'] . "*" .
                                "\r\nPeserta : *" . $p['anggota'] . "*" .
                                "\r\nBerangkat : *" . date('d-M', strtotime($p['tglberangkat'])) . "* *" . date('H:i', strtotime($p['jamberangkat'])) . "* _estimasi_" .
                                "\r\nKembali : *" . date('d-M', strtotime($p['tglkembali'])) . "* *" . date('H:i', strtotime($p['jamkembali'])) . "* _estimasi_" .
                                "\r\nKendaraan : *" . $p['nopol'] . "* ( *" . $p['kepemilikan'] . "* )" .
                                "\r\nCatatan : *" . $p['catatan'] .  "*" .
                                "\r\n \r\nWaktu keberangkatan perjalanan kamu melebihi batas waktu keberangkatan" .
                                "\r\nBatas Waktu keberangkatan :" .
                                "\r\n1 Jam untuk perjalanan dengan COPRO" .
                                "\r\n2 Jam untuk perjalanan tanpa COPRO" .
                                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" .
                                "\r\n \r\n" . $notifikasi['pesan']
                                ],
                    ]
                );
                $body = $response->getBody();
            }
            
        endforeach;

        //Auto LEMBUR
        $lembur = $this->db->get('lembur')->result_array();

        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+3 days', strtotime($l['tglselesai_rencana']))));
            $kirim_notif = strtotime(date('Y-m-d H:i:s', strtotime('+64 hours', strtotime($l['tglselesai_rencana']))));
            $expired = strtotime($l['expired_at']);
            $user = $this->db->get_where('karyawan', ['npk' => $l['npk']])->row_array();
            $last_status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array();

            if ($l['status'] == 4) {
                // Notifikasi REALISASI tinggal 8 JAM
                if ($kirim_notif < $sekarang and $l['life'] == 0) {
                    $notifikasi = $this->db->get_where('notifikasi', ['id' =>  $l['id']])->row_array();
                    if (!isset($notifikasi['id'])) {
                        $data = array(
                            'id' => $l['id'],
                            'notifikasi' => 1,
                            'tanggal' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('notifikasi', $data);

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
                                    'message' => "*[MENUNGGU REALISASI] WAKTU REALISASI KAMU KURANG DARI 8 JAM*" .
                                        "\r\n \r\n*LEMBUR* kamu dengan detil berikut :" .
                                        "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                        "\r\nNama : *" . $l['nama'] . "*" .
                                        "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai_rencana'])) . "*" .
                                        "\r\nDurasi : *" . $l['durasi_rencana'] . " Jam*" .
                                        "\r\n \r\nWaktu *REALISASI LEMBUR* kurang dari *8 JAM*, Ayo segera selesaikan REALISASI kamu." .
                                        "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com" .
                                        "\r\n \r\n" . $notifikasi['pesan']
                                        ],
                            ]
                        );
                        $body = $response->getBody();
                    }
                }

                // Batalkan LEMBUR REALISASI
                if ($tempo < $sekarang and $l['life'] == 0) {
                    $this->db->set('catatan', "Waktu REALISASI LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i'));
                    $this->db->set('status', '0');
                    $this->db->set('last_status', $l['status']);
                    $this->db->where('id', $l['id']);
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
                                'message' => "*[DIBATALKAN] WAKTU REALISASI LEMBUR KAMU TELAH HABIS*" .
                                    "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                    "\r\nNama : *" . $l['nama'] . "*" .
                                    "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) . "*" .
                                    "\r\nDurasi : *" . $l['durasi'] . " Jam*" .
                                    "\r\n \r\nLEMBUR kamu *DIBATALKAN* otomatis oleh SISTEM" .
                                    "\r\n \r\nWaktu *REALISASI LEMBUR* kamu melebihi 3x24 Jam dari batas waktu *RENCANA SELESAI LEMBUR*." .
                                    "\r\n1. Untuk hangus karena karyawan telat membuat realisasi dalam 3x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2, kadivnya, dan bu dwi" .
                                    "\r\n2. untuk hangus karena atasan 1 atau atasan 2 telat approve dalam 7x24 jam, maka atasan yang jadi penyebab hangus harus buat memo menjelaskan kenapa telat approve yang ditandatangani kadep, kadivnya, dan bu dwi" .
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com" .
                                    "\r\n \r\n" . $notifikasi['pesan']
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                }
            } elseif ($l['status'] > 1 and $l['status'] < 7 and $l['life'] == 0) {
                // Batalkan LEMBUR LEWAT 7 HARI
                if ($expired < $sekarang) {
                    $this->db->set('catatan', "Waktu LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i', strtotime($l['expired_at'])));
                    $this->db->set('status', '0');
                    $this->db->set('last_status', $l['status']);
                    $this->db->where('id', $l['id']);
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
                                'message' => "*[DIBATALKAN] WAKTU LEMBUR KAMU TELAH HABIS*" .
                                    "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                    "\r\nNama : *" . $l['nama'] . "*" .
                                    "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) . "*" .
                                    "\r\nDurasi : *" . $l['durasi'] . " Jam*" .
                                    "\r\nStatus Terakhir : *" . $last_status['nama'] . "*" .
                                    "\r\n \r\nLEMBUR kamu *DIBATALKAN* otomatis oleh SISTEM" .
                                    "\r\nWaktu *LEMBUR* kamu melebihi 7x24 Jam dari batas waktu *RENCANA MULAI LEMBUR*." .
                                    "\r\n1. Untuk hangus karena karyawan telat membuat realisasi dalam 3x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2, kadivnya, dan bu dwi" .
                                    "\r\n2. untuk hangus karena atasan 1 atau atasan 2 telat approve dalam 7x24 jam, maka atasan yang jadi penyebab hangus harus buat memo menjelaskan kenapa telat approve yang ditandatangani kadep, kadivnya, dan bu dwi" .
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com" .
                                    "\r\n \r\n" . $notifikasi['pesan']
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                }
            }
        endforeach;
    }

    public function index()
    {
        $this->notifications();

        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('date', date('Y-m-d'));
        $complete = $this->db->get('kesehatan')->row_array();

        if (empty($complete)){
            redirect('dashboard/sehat');
        }

        // List Kendaraan
        $this->db->where('is_active', '1');
        $this->db->where('id !=', '1');
        $data['kendaraan'] = $this->db->get('kendaraan')->result_array();


        $this->db->where('year(tglmulai)', date('Y'));
        $this->db->where('month(tglmulai)', date('m'));
        $this->db->where('day(tglmulai)', date('d'));
        $this->db->where('konsumsi', 'YA');
        $this->db->where('status >', '2');
        $data['lembur_makan_malam'] = $this->db->get('lembur')->result_array();

        $this->db->where('year(tglmulai)', date('Y'));
        $this->db->where('month(tglmulai)', date('m'));
        $this->db->where('day(tglmulai)', date('d'));
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
        if ($action == 'add') {
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
        } elseif ($action == 'delete') {
            $this->dashboard_model->delete_claim($this->input->post('id'));
            redirect('dashboard');
        } elseif ($action == 'empty') {
            $this->dashboard_model->empty_claim();
            redirect('dashboard');
        }
    }

    public function sehat()
    {
        date_default_timezone_set('asia/jakarta');
        
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('date', date('Y-m-d'));
        $complete = $this->db->get('kesehatan')->row_array();

        if (empty($complete)){
            $data['sidemenu'] = 'Dashboard';
            $data['sidesubmenu'] = '';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dashboard/fpk', $data);
            $this->load->view('templates/footer');
        }else{
            redirect('dashboard');
        }
    }

}
