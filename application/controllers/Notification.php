<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Notification extends CI_Controller
{
    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        echo 'Auto Refresh | Last Refresh at '.date('d M Y H:i:s') ;

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

                echo '<p>Kirim Notif lembur hari ini ke GA Admin - Berhasil';
            }
        }
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
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $l['id'] .' [NOTIFIKASI] Kirim Notif lembur realisasi kurang dari 8 Jam - Berhasil';
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
                                "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                ],
                    ]
                );
                $body = $response->getBody();
                echo '<p>#'. $l['id'] .' [DIBATALKAN] Kirim Notif lembur realisasi lebih dari 3x24 Jam - Berhasil';
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
                                "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                ],
                    ]
                );
                $body = $response->getBody();
                echo '<p>#'. $l['id'] .' [DIBATALKAN] Kirim Notif lembur lebih dari 7x24 Jam - Berhasil';
            }
        endforeach;
// ----------------------------------------------------------------------------------------
        //Cari Lembur Approval
        $this->db->or_where('status','2');
        $this->db->or_where('status','3');
        $this->db->or_where('status','5');
        $this->db->or_where('status','6');
        $lembur = $this->db->get('lembur')->result_array();
        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            // $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+3 days', strtotime($l['tglselesai_rencana']))));
            $last_notify = strtotime(date('Y-m-d H:i:s', strtotime('+3 hours', strtotime($l['last_notify']))));
            // $expired = strtotime($l['expired_at']);
            $atasan1 = $this->db->get_where('karyawan', ['inisial' => $l['atasan1']])->row_array();
            $atasan2 = $this->db->get_where('karyawan', ['inisial' => $l['atasan2']])->row_array();
            // $last_status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array();

            if ($last_notify < $sekarang) {
                if ($l['status']=='2') {
                
                    $this->db->set('last_notify', date('Y-m-d H:i:s'));
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
                                'phone' => $atasan1['phone'],
                                'message' => "*[MENUNGGU APPROVAL] RENCANA LEMBUR INI MASIH MENUNGGU PERSETUJUAN*" .
                                    "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                    "\r\nNama : *" . $l['nama'] . "*" .
                                    "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai_rencana'])) . "*" .
                                    "\r\nDurasi : *" . $l['durasi_rencana'] . " Jam*" .
                                    "\r\n \r\nHarap segera respon *Setujui/Batalkan*".
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $l['id'] .' [NOTIFIKASI] Kirim Notif lembur menunggu approval atasan1 - Berhasil';
                    
                }elseif ($l['status']=='3') {
                
                    $this->db->set('last_notify', date('Y-m-d H:i:s'));
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
                                'phone' => $atasan2['phone'],
                                'message' => "*[MENUNGGU APPROVAL] RENCANA LEMBUR INI MASIH MENUNGGU PERSETUJUAN*" .
                                    "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                    "\r\nNama : *" . $l['nama'] . "*" .
                                    "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai_rencana'])) . "*" .
                                    "\r\nDurasi : *" . $l['durasi_rencana'] . " Jam*" .
                                    "\r\n \r\nHarap segera respon *Setujui/Batalkan*".
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $l['id'] .' [NOTIFIKASI] Kirim Notif lembur menunggu approval atasan2 - Berhasil';

                } elseif ($l['status']=='5') {
                
                    $this->db->set('last_notify', date('Y-m-d H:i:s'));
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
                                'phone' => $atasan1['phone'],
                                'message' => "*[MENUNGGU APPROVAL] REALISASI LEMBUR INI MASIH MENUNGGU PERSETUJUAN*" .
                                    "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                    "\r\nNama : *" . $l['nama'] . "*" .
                                    "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) . "*" .
                                    "\r\nDurasi : *" . $l['durasi'] . " Jam*" .
                                    "\r\n \r\nHarap segera respon *Setujui/Batalkan*".
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $l['id'] .' [NOTIFIKASI] Kirim Notif lembur menunggu approval atasan1 - Berhasil';
                    
                }elseif ($l['status']=='6') {
                
                    $this->db->set('last_notify', date('Y-m-d H:i:s'));
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
                                'phone' => $atasan2['phone'],
                                'message' => "*[MENUNGGU APPROVAL] REALISASI LEMBUR INI MASIH MENUNGGU PERSETUJUAN*" .
                                    "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                    "\r\nNama : *" . $l['nama'] . "*" .
                                    "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) . "*" .
                                    "\r\nDurasi : *" . $l['durasi'] . " Jam*" .
                                    "\r\n \r\nHarap segera respon *Setujui/Batalkan*".
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $l['id'] .' [NOTIFIKASI] Kirim Notif lembur menunggu approval atasan2 - Berhasil';
                }
            }

        endforeach;
// ----------------------------------------------------------------------------------------
        //auto batalkan reservasi
        $queryReservasi = "SELECT *
        FROM `reservasi`
        WHERE `tglberangkat` <= CURDATE() AND (`status` = '1' OR `status` = '2' OR `status` = '3' OR `status` = '4' OR `status` = '5' OR `status` = '6')
        ";
        $reservasi = $this->db->query($queryReservasi)->result_array();
        foreach ($reservasi as $r) :
            // cari selisih
            $mulai = strtotime($r['jamberangkat']);
            $selesai = time();
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));

            if (($r['copro']!='NON PROJEK' and $jam >= 1)or($r['copro']=='NON PROJEK' and $jam >= 2)) {
                $perjalanan = $this->db->get_where('perjalanan', ['reservasi_id' => $r['id']])->row_array();
                $status = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array();
                
                if (empty($perjalanan['id'])) {

                    $this->db->set('status', '0');
                    $this->db->set('catatan', "Waktu reservasi perjalanan kamu telah selesai (Status : ".$status['nama'].") - Dibatalkan oleh SYSTEM pada " . date('d-m-Y H:i'));
                    $this->db->where('id', $r['id']);
                    $this->db->update('reservasi');

                    $this->db->where('npk', $r['npk']);
                    $karyawan = $this->db->get('karyawan')->row_array();
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
                                'message' => "*[DIBATALKAN] RESERVASI PERJALANAN DINAS KAMU MELEBIHI BATAS WAKTU KEBERANGKATAN*". 
                                "\r\n \r\n No. Reservasi : *" . $r['id'] . "*" .
                                "\r\nNama : *" . $r['nama'] . "*" .
                                "\r\nTujuan : *" . $r['tujuan'] . "*" .
                                "\r\nKeperluan : *" . $r['keperluan'] . "*" .
                                "\r\nPeserta : *" . $r['anggota'] . "*" .
                                "\r\nBerangkat : *" . $r['tglberangkat'] . "* *" . $r['jamberangkat'] . "* _estimasi_" .
                                "\r\nKembali : *" . $r['tglkembali'] . "* *" . $r['jamkembali'] . "* _estimasi_" .
                                "\r\nKendaraan : *" . $r['nopol'] . "* ( *" . $r['kepemilikan'] . "* )" .
                                "\r\nStatus Terakhir : *" . $status['nama'] . "*" .
                                "\r\n \r\nWaktu reservasi kamu telah selesai. Dibatalkan oleh RAISA pada " . date('d-m-Y H:i') .
                                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                            ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $r['id'] .' [DIBATALKAN] Kirim Notif reservasi dibatalkan - Berhasil';
                }else{
                    $this->db->set('status', '9');
                    $this->db->where('id', $r['id']);
                    $this->db->update('reservasi');
                }
            }
        endforeach;
// ----------------------------------------------------------------------------------------
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
            
            if ($menit > 1) {
                $notifyCheck = $this->db->get_where('notifikasi', ['id' => $p['id']])->row_array();
                if (empty($notifyCheck)){
                    //Notify to USER
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
                                'message' => "*PERJALANAN DINAS KAMU HARUS SEGERA BERANGKAT*". 
                                    "\r\n \r\nPerjalanan dinas kamu dengan No. PERJALANAN : *" . $p['id'] . "*" .
                                    "\r\nTujuan : *" . $p['tujuan'] . "*" .
                                    "\r\nBerangkat : *" . date('d-M', strtotime($p['tglberangkat'])) . "* *" . date('H:i', strtotime($p['jamberangkat'])) . "* _rencana_" .
                                    "\r\n \r\nWaktu keberangkatan perjalanan kamu *Telah Tiba*." .
                                    "\r\n \r\nJIka tidak berangkat max 1 Jam (untuk projek) atau max 2 Jam (Non Projek) maka perjalanan akan dibatalkan." .
                                    "\r\n \r\nKamu dapat menambah waktu keberangkatan perjalanan di menu Perjalanan - PerjalananKu."
                            ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $p['id'] .' [INFO] Kirim Notif Waktu perjalanan telah tiba - Berhasil';

                    $data = array(
                        'id' => $p['id'],
                        'times' => 2,
                        'tanggal' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('notifikasi', $data);
                }
            }

            if ($p['copro']!='NON PROJEK' and $menit > -30) {
                $this->db->where('times', '2');
                $notifyCheck = $this->db->get_where('notifikasi', ['id' => $p['id']])->row_array();
                if (empty($notifyCheck)){
                    //Notify to USER
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
                                'message' => "*WAKTU PERJALANAN DINAS KAMU SUDAH LEWAT 30 MENIT*". 
                                    "\r\n \r\nPerjalanan dinas kamu dengan No. PERJALANAN : *" . $p['id'] . "*" .
                                    "\r\nTujuan : *" . $p['tujuan'] . "*" .
                                    "\r\nBerangkat : *" . date('d-M', strtotime($p['tglberangkat'])) . "* *" . date('H:i', strtotime($p['jamberangkat'])) . "* _rencana_" .
                                    "\r\n \r\nWaktu keberangkatan perjalanan kamu akan dibatalkan dalam *30 Menit* lagi."
                                    ],
                        ]
                    );
                    $body = $response->getBody();
                    echo '<p>#'. $p['id'] .' [INFO] Kirim Notif Waktu perjalanan lewat 30 menit - Berhasil';

                    $data = array(
                        'id' => $p['id'],
                        'times' => 1,
                        'tanggal' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('notifikasi', $data);
                }
            }

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
                                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com" 
                        ],
                    ]
                );
                $body = $response->getBody();
                echo '<p>#'. $p['id'] .' [DIBATALKAN] Kirim Notif perjalanan dibatalkan - Berhasil';
            }
        endforeach;
// ----------------------------------------------------------------------------------------
        //Notif Kehadiran hari ini to Atasan
        // $t = time();
        // $in = strtotime(date('Y-m-d 08:30:00'));
        // $rest = strtotime(date('Y-m-d 13:00:00'));
        // $out = strtotime(date('Y-m-d 17:30:00'));
        // $today = date('d');
        // $bulan = date('m');
        // $tahun = date('Y');
        


        // if ($t > $in and $t < $rest){
        //     $id = 'GA'.date('ymd');
        //     $cekn = $this->db->get_where('notifikasi', ['id' =>  $id])->row_array();
        //     if (empty($cekn)){
        //         $this->db->where('year(tglmulai)',$tahun);
        //         $this->db->where('month(tglmulai)',$bulan);
        //         $this->db->where('day(tglmulai)',$today);
        //         $this->db->where('lokasi !=','WTQ');
        //         $this->db->where('status >', '2');
        //         $lembur_cus = $this->db->get('lembur');

        //         $this->db->where('year(tglmulai)',$tahun);
        //         $this->db->where('month(tglmulai)',$bulan);
        //         $this->db->where('day(tglmulai)',$today);
        //         $this->db->where('lokasi','WTQ');
        //         $this->db->where('status >', '2');
        //         $lembur_wtq = $this->db->get('lembur');

        //         $this->db->where('sect_id', '214');
        //         $ga_admin = $this->db->get('karyawan_admin')->row_array();
             
        //         $client = new \GuzzleHttp\Client();
        //         $response = $client->post(
        //             'https://region01.krmpesan.com/api/v2/message/send-text',
        //             [
        //                 'headers' => [
        //                     'Content-Type' => 'application/json',
        //                     'Accept' => 'application/json',
        //                     'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
        //                 ],
        //                 'json' => [
        //                     'phone' => $ga_admin['phone'],
        //                     'message' => "*INFORMASI LEMBUR HARI INI*" . 
        //                     "\r\n \r\nTanggal : *" . date('d M Y') . "*" .
        //                     "\r\nLembur di WINTEQ : *" . $lembur_wtq->num_rows() . "*" .
        //                     "\r\nLembur di Customer : *" . $lembur_cus->num_rows() . "*" .
        //                     "\r\n \r\nMohon segera konfirmasi untuk konsumsi.".
        //                     "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
        //                 ],
        //             ]
        //         );
        //         $body = $response->getBody();

        //         // Notifikasi telah dikirim
        //         $data = array(
        //             'id' => $id,
        //             'notifikasi' => 1,
        //             'tanggal' => date('Y-m-d H:i:s')
        //         );
        //         $this->db->insert('notifikasi', $data);

        //         echo '<p>Kirim Notif lembur hari ini ke GA Admin - Berhasil';
        //     }
        // }

// ----------------------------------------------------------------------------------------
    }
}