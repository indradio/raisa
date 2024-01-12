<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        date_default_timezone_set('asia/jakarta');
        parent::__construct();
        is_logged_in();
        $this->load->model("dashboard_model");

        // $this->update_perjalanan();
        $this->update_lembur();
        $this->update_cuti();
        // $this->update_presensi();
    }

    public function update_perjalanan()
    {
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
                                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                                ],
                    ]
                );
                $body = $response->getBody();
            }
            
        endforeach;
    }

    public function update_lembur()
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
        
        //Auto LEMBUR

        $this->db->where('tglmulai >=', Date('Y-m-d', strtotime('-31 days')));
        $lembur = $this->db->get('lembur')->result_array();

        foreach ($lembur as $l) :
            
            // cari selisih
            $sekarang = strtotime(date('Y-m-d H:i:s'));
            $tempo = strtotime(date('Y-m-d H:i:s', strtotime('+2 days', strtotime($l['tglselesai_rencana']))));
            $kirim_notif = strtotime(date('Y-m-d H:i:s', strtotime('+45 hours', strtotime($l['tglselesai_rencana']))));
            $expired = strtotime($l['expired_at']);
            $user = $this->db->get_where('karyawan', ['npk' => $l['npk']])->row_array();
            $last_status = $this->db->get_where('lembur_status', ['id' => $l['status']])->row_array();

            if ($l['status'] >= 1 and $l['status'] <= 4) {
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
                                    'message' => "*[MENUNGGU REALISASI] WAKTU REALISASI KAMU KURANG DARI 3 JAM*" .
                                        "\r\n \r\n*LEMBUR* kamu dengan detil berikut :" .
                                        "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                        "\r\nNama : *" . $l['nama'] . "*" .
                                        "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai_rencana'])) . "*" .
                                        "\r\nDurasi : *" . $l['durasi_rencana'] . " Jam*" .
                                        "\r\n \r\nWaktu *REALISASI LEMBUR* kurang dari *3 JAM*, Ayo segera selesaikan REALISASI kamu." .
                                        "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                        ],
                            ]
                        );
                        $body = $response->getBody();
                    }
                }

                // Batalkan LEMBUR REALISASI
                if ($tempo < $sekarang and $l['life'] == 0) {
                    $this->db->set('catatan', "Waktu REALISASI LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i', strtotime($l['expired_at'])));
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
                                    "\r\n \r\nWaktu *REALISASI LEMBUR* kamu melebihi 2x24 Jam dari batas waktu *RENCANA LEMBUR*." .
                                    "\r\nLembur yg hangus karena karyawan telat membuat realisasi dalam 2x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2 dan kadiv kemudian diserahkan ke HR." .
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                ],
                        ]
                    );
                    $body = $response->getBody();

                    $log = [
                        'npk' => $user['npk'],
                        'activity' => 'Waktu realisasi LEMBUR telah habis',
                        'reference' => $l['id']
                    ];
                    $this->db->insert('log', $log);
                }
            } elseif ($l['status'] > 1 and $l['status'] < 7 and $l['life'] == 0) {
                // Batalkan LEMBUR LEWAT 7 HARI
                if ($expired < $sekarang) {
                    $this->db->set('catatan', "Waktu LEMBUR kamu telah HABIS - Dibatalkan oleh : SYSTEM Pada " . date('d-m-Y H:i', strtotime($l['expired_at'])));
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
                                    "\r\n1. Untuk hangus karena karyawan telat membuat realisasi dalam 2x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2, dan kadiv." .
                                    "\r\n2. untuk hangus karena atasan 1 atau atasan 2 telat approve dalam 7x24 jam, maka atasan yang jadi penyebab hangus harus buat memo menjelaskan kenapa telat approve yang ditandatangani kadept dan/atau kadiv." .
                                    "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                                    ],
                        ]
                    );
                    $body = $response->getBody();

                    $log = [
                        'npk' => $user['npk'],
                        'activity' => 'Waktu LEMBUR telah melewati 7 hari',
                        'reference' => $l['id']
                    ];
                    $this->db->insert('log', $log);
                }
            }
        endforeach;
    }

    public function update_cuti()
    {
        date_default_timezone_set('asia/jakarta');
        $today = date('Y-m-d');
        
        // $this->db->where('valid <=', $today);
        // $this->db->where('expired >=', $today);
        // $this->db->where('status !=', 'AKTIF');
        // $this->db->where('status !=', 'HOLD');
        // $activated = $this->db->get_where('cuti_saldo')->result();
        //     foreach ($activated as $row) :
        //         $this->db->set('status', 'AKTIF');
        //         $this->db->where('id', $row->id);
        //         $this->db->update('cuti_saldo');
        //     endforeach;

        // $this->db->where('valid >', $today);
        // $this->db->where('status !=', 'WAITING');
        // $waiting = $this->db->get_where('cuti_saldo')->result();
        //     foreach ($waiting as $row) :
        //         $this->db->set('status', 'WAITING');
        //         $this->db->where('id', $row->id);
        //         $this->db->update('cuti_saldo');
        //     endforeach;

        // $this->db->where('expired <', $today);
        // $this->db->where('status !=', 'EXPIRED');
        // $expired = $this->db->get_where('cuti_saldo')->result();
        //     foreach ($expired as $row) :
        //         $this->db->set('status', 'EXPIRED');
        //         $this->db->where('id', $row->id);
        //         $this->db->update('cuti_saldo');
        //     endforeach;
            
        $this->db->where('tgl1 <', $today);
        $this->db->where('status >', 0);
        $this->db->where('status <', 3);
        $this->db->where('darurat', null);
        $cuti = $this->db->get_where('cuti')->result();
            foreach ($cuti as $row) :
                $this->db->set('reject_by', 'SYSTEM');
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', 'Batas waktu persetujuan telah selesai');
                $this->db->set('status', '0');
                $this->db->set('reject_status', $row->status);
                $this->db->where('id', $row->id);
                $this->db->update('cuti');

                $this->db->set('status', '0');
                $this->db->where('cuti_id', $row->id);
                $this->db->update('cuti_detail');

                $cuti_saldo = $this->db->get_where('cuti_saldo', ['id' => $row->saldo_id])->row();
                if ($cuti_saldo)
                {
                    $this->db->select_sum('lama');
                    $this->db->where('saldo_id', $row->saldo_id);
                    $this->db->where('status >', 0);
                    $query = $this->db->get('cuti');
                    $digunakan = $query->row()->lama;
                    $sisa = $cuti_saldo->saldo_awal - $digunakan;

                    $this->db->set('saldo_digunakan', $digunakan);
                    $this->db->set('saldo', $sisa);
                    $this->db->where('id', $row->saldo_id);
                    $this->db->update('cuti_saldo');
                }

                //Notifikasi ke USER
                $user = $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
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
                            'message' => "*[NOTIF] PEMBATALAN CUTI*" .
                            "\r\n \r\nNama : *" . $row->nama . "*" .
                            "\r\nTanggal : *" . date('d-M', strtotime($row->tgl1)) . "*" .
                            "\r\nLama : *" . $row->lama ." Hari* " .
                            "\r\nAlasan : *Cuti kamu melewati batas waktu persetujuan atasan*" .
                            "\r\n \r\nCuti ini telah *DIBATALKAN oleh SYSTEM*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/"
                        ],
                    ]
                );
                $body = $response->getBody();
            endforeach;

    }

    // public function update_presensi()
    // {
    //     if(date('D')!='Sun' || date('D')!='Sat') 
    //     {
    //         if (date('H:i:s') > date('07:35:00') AND date('H:i:s') < date('07:45:00'))
    //         {
    //             $id = 'IN'.date('ymd');
    //             $notif = $this->db->get_where('notifikasi', ['id' =>  $id])->row();

    //             if (empty($notif))
    //             {
    //                 $data = array(
    //                     'id' => $id,
    //                     'notifikasi' => 1,
    //                     'tanggal' => date('Y-m-d H:i:s')
    //                 );
    //                 $this->db->insert('notifikasi', $data);

    //                 $this->db->where('posisi_id >','4');
    //                 $this->db->where('is_active','1');
    //                 $this->db->where('status','1');
    //                 $queryUsers = $this->db->get('karyawan')->result();

    //                 foreach ($queryUsers as $user) :

    //                     $this->db->where('date',date('Y-m-d'));
    //                     $this->db->where('npk',$user->npk);
    //                     $this->db->where('status','In');
    //                     $presensi = $this->db->get('presensi_raw')->row();
    //                     if (empty($presensi))
    //                     {
    //                             $client = new \GuzzleHttp\Client();
    //                             $response = $client->post(
    //                                 'https://region01.krmpesan.com/api/v2/message/send-text',
    //                                 [
    //                                     'headers' => [
    //                                         'Content-Type' => 'application/json',
    //                                         'Accept' => 'application/json',
    //                                         'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
    //                                     ],
    //                                     'json' => [
    //                                         'phone' => $user->phone,
    //                                         'message' => "*[NOTIF] ANDA BELUM ABSEN*" .
    //                                         "\r\n \r\nSemangat pagi *" . $user->nama . "*" .
    //                                         "\r\n \r\n*ANDA BELUM MELAKUKAN ABSENSI HARI INI*" .
    //                                         "\r\nSilahkan segera absen melalui FACE ID ataupun RAISA".
    //                                         "\r\n \r\nAbaikan jika kamu sedang cuti/off/ijin lainnya"
    //                                     ],
    //                                 ]
    //                             );
    //                             $body = $response->getBody();
    //                     }

    //                 endforeach;
    //             }
    //         }
    //     }
    // }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');

        // $complete = $this->db->get_where('survei_payment', ['npk' =>  $this->session->userdata('npk')])->row_array();

        // if (empty($complete)){
        //     redirect('dashboard/survei');
        // }

        // List Kendaraan
        // $this->db->where('is_active', '1');
        // $this->db->where('id !=', '1');
        // $data['kendaraan'] = $this->db->get('kendaraan')->result_array();

        $queryReservasi = "SELECT *
        FROM `reservasi`
        WHERE (`atasan1` = '{$this->session->userdata('inisial')}' and `status` = 1) or (`atasan2` = '{$this->session->userdata('inisial')}' and `status` = 2) ";
        $data['Reservasi'] = $this->db->query($queryReservasi)->result_array();

        $queryRencanaLembur = "SELECT *
        FROM `lembur`
        WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '2') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '3') ";
        $data['RencanaLembur'] = $this->db->query($queryRencanaLembur)->result_array();

        $queryRealisasiLembur = "SELECT *
        FROM `lembur`
        WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '5') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '6') ";
        $data['RealisasiLembur'] = $this->db->query($queryRealisasiLembur)->result_array();

        $queryCuti = "SELECT *
        FROM `cuti`
        WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '2') ";
        $data['Cuti'] = $this->db->query($queryCuti)->result_array();

        $queryPresensi = "SELECT *
        FROM `presensi`
        WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1')";
        $data['presensi'] = $this->db->query($queryPresensi)->result_array();

        $queryIMP = "SELECT *
        FROM `imp`
        WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '2') ";
        $data['imp'] = $this->db->query($queryIMP)->result_array();
    
        // Halaman dashboard
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = $this->session->userdata('nama');
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        // $data['pendapatan'] = $this->db->get('pendapatan')->result_array();
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

    public function presensi()
    {
        date_default_timezone_set('asia/jakarta');
            $data['sidemenu'] = 'Dashboard';
            $data['sidesubmenu'] = '';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('presensi/presensi_today', $data);
            $this->load->view('templates/footer');
    }

    public function survei($param=null)
    {
        if ($param=='submit')
        {
            $jawaban = array(
                $this->input->post('a1'),$this->input->post('a2'),$this->input->post('a3'),$this->input->post('a4'),$this->input->post('a5'),$this->input->post('a6'),$this->input->post('lainnya')
            );
            $jawaban = array_filter($jawaban);
            // $data = implode("::", $result);
    
            $data = [
                'npk' => $this->session->userdata('npk'),
                'nama' => $this->session->userdata('nama'),
                'a1' => $this->input->post('a1'),
                'a2' => $this->input->post('a2'),
                'a3' => $this->input->post('a3'),
                'a4' => $this->input->post('a4'),
                'a5' => $this->input->post('a5'),
                'a6' => $this->input->post('a6'),
                'jawaban' => implode(', ', $jawaban),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('survei_payment', $data);

            redirect('dashboard');
        }elseif ($param=='cuti')
            {
        
                $data = [
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $this->session->userdata('nama'),
                    'ide' => $this->input->post('ide'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('survei_cuti', $data);
    
                redirect('dashboard');
        }else{
       
            $data['sidemenu'] = 'Dashboard';
            $data['sidesubmenu'] = '';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dashboard/survei_payment', $data);
            $this->load->view('templates/footer');

        }
    }

    public function submit_survei()
    {
                $data = [
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $this->session->userdata('nama'),
                    'nama' => $this->session->userdata('nama'),
                    'p1' => $this->input->post('pertanyaan1'),
                    'p2' => $this->input->post('pertanyaan2'),
                    'p3' => $this->input->post('pertanyaan3'),
                    'p4' => $this->input->post('pertanyaan4'),
                    'p5' => $this->input->post('pertanyaan5'),
                    'p6' => $this->input->post('pertanyaan6'),
                    'p7' => $this->input->post('pertanyaan7'),
                    'p8' => $this->input->post('pertanyaan8'),
                    'p9' => $this->input->post('pertanyaan9'),
                    'p10' => $this->input->post('pertanyaan10'),
                    'kritik' => $this->input->post('kritik'),
                    'saran' => $this->input->post('saran'),
                    'sect_id' => $this->session->userdata('sect_id'),
                    'dept_id' => $this->session->userdata('dept_id'),
                    'div_id' => $this->session->userdata('div_id')
                ];
                $this->db->insert('survei_ga', $data);
    
            redirect('dashboard/survei');
        
    }

    public function emisi($params)
    {
                $data = [
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $this->session->userdata('nama'),
                    'daftar' => $params,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('survei_emisi', $data);
    
            redirect('dashboard');
        
    }

}
