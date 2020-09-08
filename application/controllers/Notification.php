<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Notification extends CI_Controller
{
    public function index()
    {
        echo 'Auto Refresh';
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
                    'phone' => '6281311196988',
                    'message' => "*AUTO REFRESH*" .
                        "\r\n*BERHASIL*"
                        ],
            ]
        );
        $body = $response->getBody();

        date_default_timezone_set('asia/jakarta');

        //Notif lembur hari ini to GA
        $n = time();
        $m = strtotime(date('Y-m-d 16:00:00'));
        $today = date('d');
        $bulan = date('m');
        $tahun = date('Y');
        if ($n > $m){
            $id = 'GA'.date('ymd');
            $cekn = $this->db->get_where('notifikasi', ['id' =>  $id])->row_array();
            if (empty($cekn)){
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

                // Notifikasi telah dikirim
                $data = array(
                    'id' => $id,
                    'notifikasi' => 1,
                    'tanggal' => date('Y-m-d H:i:s')
                );
                $this->db->insert('notifikasi', $data);

            }
        }

        echo '<p>Kirim Notif lembur hari ini ke GA Admin - Berhasil';
// ----------------------------------------------------------------------------------------
        //Cari Lembur Realisasi
        $this->db->where('status','4');
        $lembur = $this->db->get('lembur')->result_array();

        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+3 days', strtotime($l['tglselesai_rencana']))));
            $kirim_notif = strtotime(date('Y-m-d H:i:s', strtotime('+64 hours', strtotime($l['tglselesai_rencana']))));
            $expired = strtotime($l['expired_at']);
            $user = $this->db->get_where('karyawan', ['npk' => $l['npk']])->row_array();
            $last_status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array();

            // Notifikasi REALISASI tinggal 8 JAM
            if ($kirim_notif < $sekarang and $l['life'] != 1) {
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
            if ($tempo < $sekarang and $l['life'] != 1) {
                $this->db->set('catatan', "Waktu REALISASI LEMBUR kamu telah HABIS - Dibatalkan oleh : SYSTEM Pada " . date('d-m-Y H:i'));
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
                                "\r\n1. Untuk hangus karena karyawan telat membuat realisasi dalam 3x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2, kadiv, dan HR" .
                                "\r\n2. Untuk hangus karena atasan 1 atau atasan 2 telat approve dalam 7x24 jam, maka atasan yang jadi penyebab hangus harus buat memo menjelaskan kenapa telat approve yang ditandatangani kadep, kadiv, dan HR" .
                                "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com" .
                                "\r\n \r\n" . $notifikasi['pesan']
                                ],
                    ]
                );
                $body = $response->getBody();
            }
        endforeach;

        // Cari Lembur 
        $this->db->where('status','2');
        $this->db->where('status','3');
        $this->db->where('status','5');
        $this->db->where('status','6');
        $lembur = $this->db->get('lembur')->result_array();

        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            $expired = strtotime($l['expired_at']);
            $user = $this->db->get_where('karyawan', ['npk' => $l['npk']])->row_array();
            $last_status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array();

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
                                "\r\n1. Untuk hangus karena karyawan telat membuat realisasi dalam 3x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2, kadiv, dan HR" .
                                "\r\n2. Untuk hangus karena atasan 1 atau atasan 2 telat approve dalam 7x24 jam, maka atasan yang jadi penyebab hangus harus buat memo menjelaskan kenapa telat approve yang ditandatangani kadep, kadiv, dan HR" .
                                "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com" .
                                "\r\n \r\n" . $notifikasi['pesan']
                                ],
                    ]
                );
                $body = $response->getBody();
            }
        endforeach;
        echo '<p>Kirim Notif lembur realisasi - Berhasil';
        echo '<p>Kirim Notif lembur expired 7x24 - Berhasil';
// ----------------------------------------------------------------------------------------
    }
}