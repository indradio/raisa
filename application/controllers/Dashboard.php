<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        date_default_timezone_set('asia/jakarta');
        parent::__construct();
        is_logged_in();
        $this->load->model("dashboard_model");

        // $this->update_perjalanan();
        // $this->update_lembur();
    }

    public function update_perjalanan()
    {
        //Auto batalkan perjalanan

        $queryPerjalanan = "SELECT *
        FROM `perjalanan`
        WHERE `tglberangkat` <= CURDATE() AND `status` = 1
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
            
            if (($p['copro']!='NON PROJEK' and $jam >= 1) or ($p['copro']=='NON PROJEK' and $jam >= 2) or (date('Y-m-d', strtotime($p['tglberangkat'])) < date('Y-m-d'))) {

                $this->db->set('status', '0');
                $this->db->set('last_status', $p['status']);
                $this->db->set('catatan', "Waktu keberangkatan perjalanan kamu telah selesai. - Dibatalkan oleh SYSTEM pada " . date('d-m-Y H:i'));
                $this->db->where('id', $p['id']);
                $this->db->update('perjalanan');

                $this->db->set('status', '9');
                $this->db->where('id', $p['reservasi_id']);
                $this->db->update('reservasi');

                //Notifikasi ke USER

            }
            
        endforeach;
    }

    public function update_lembur()
    {
        //Notif lembur hari ini to GA
        // $n = time();
        // $m = strtotime(date('Y-m-d 16:00:00'));
        // if ($n > $m){
        //     $id = 'GA'.date('ymd');
        //     $cekn = $this->db->get_where('notifikasi', ['id' =>  $id])->row_array();
        //     if (empty($cekn)){
        //         $today = date('d');
        //         $bulan = date('m');
        //         $tahun = date('Y');
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

        //         $data = array(
        //             'id' => $id,
        //             'notifikasi' => 1,
        //             'tanggal' => date('Y-m-d H:i:s')
        //         );
        //         $this->db->insert('notifikasi', $data);

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
        //     }
        // }

        // $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
        
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
            
                // Batalkan LEMBUR REALISASI
                if ($tempo < $sekarang and $l['life'] == 0) {
                    $this->db->set('catatan', "Waktu REALISASI LEMBUR kamu telah HABIS - Dibatalkan oleh : RAISA Pada " . date('d-m-Y H:i', strtotime($l['expired_at'])));
                    $this->db->set('status', '0');
                    $this->db->set('last_status', $l['status']);
                    $this->db->where('id', $l['id']);
                    $this->db->update('lembur');

                    //Notifikasi ke USER
                    //Kirim pesan via Whatsapp
                    // $curl = curl_init();

                    // $message = [
                    // "messageType"   => "text",
                    // "to"            =>  $user['phone'],
                    // "body"          => "*" . $l['id'] . " - LEMBUR KAMU MELEBIHI BATAS WAKTU REALISASI*" .
                    // "\r\n \r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) . "*" .
                    // "\r\nDurasi : *" . $l['durasi'] . " Jam*" .
                    // "\r\n \r\nWaktu *REALISASI LEMBUR* kamu melebihi 2x24 Jam dari batas waktu *RENCANA LEMBUR*." .
                    // "\r\nLembur yg hangus karena karyawan telat membuat realisasi dalam 2x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2 dan kadiv kemudian diserahkan ke HR.",
                    // "file"          => "",
                    // "delay"         => 10,
                    // "schedule"      => 1665408510000
                    // ];
                    
                    // curl_setopt_array($curl, array(
                    // CURLOPT_URL => 'https://api.starsender.online/api/send',
                    // CURLOPT_RETURNTRANSFER => true,
                    // CURLOPT_ENCODING => '',
                    // CURLOPT_MAXREDIRS => 10,
                    // CURLOPT_TIMEOUT => 0,
                    // CURLOPT_FOLLOWLOCATION => true,
                    // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    // CURLOPT_CUSTOMREQUEST => 'POST',
                    // CURLOPT_POSTFIELDS => json_encode($message),
                    // CURLOPT_HTTPHEADER => array(
                    //     'Content-Type:application/json',
                    //     'Authorization: 26e68837-3e49-4692-b389-e2e132de361c'
                    // ),
                    // ));
                    
                    // $response = curl_exec($curl);
                    // curl_close($curl);

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
                    //             'message' => "*[DIBATALKAN] WAKTU REALISASI LEMBUR KAMU TELAH HABIS*" .
                                    // "\r\n \r\nNo LEMBUR : *" . $l['id'] . "*" .
                                    // "\r\nNama : *" . $l['nama'] . "*" .
                                    // "\r\nTanggal : *" . date('d-M H:i', strtotime($l['tglmulai'])) . "*" .
                                    // "\r\nDurasi : *" . $l['durasi'] . " Jam*" .
                                    // "\r\n \r\nLEMBUR kamu *DIBATALKAN* otomatis oleh SISTEM" .
                                    // "\r\n \r\nWaktu *REALISASI LEMBUR* kamu melebihi 2x24 Jam dari batas waktu *RENCANA LEMBUR*." .
                                    // "\r\nLembur yg hangus karena karyawan telat membuat realisasi dalam 2x24 jam, maka karyawan harus buat memo menjelaskan kenapa telat membuat realisasi yang ditandatangani atasan 1, atasan 2 dan kadiv kemudian diserahkan ke HR." .
                                    // "\r\nUntuk informasi lebih lengkap dapat dilihat melalui RAISA di link berikut https://raisa.winteq-astra.com"
                    //             ],
                    //     ]
                    // );
                    // $body = $response->getBody();

                    $log = [
                        'npk' => $user['npk'],
                        'activity' => 'Waktu realisasi LEMBUR telah habis',
                        'reference' => $l['id']
                    ];
                    $this->db->insert('log', $log);
                }
            }
            
        endforeach;
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        // Aktifkan cache untuk 15 menit (900 detik)
        $this->output->cache(15); // Durasi dalam menit

        // $this->db->where('is_active', '1');
        // $this->db->where('id !=', '1');
        // $data['kendaraan'] = $this->db->get('kendaraan')->result_array();

        if ($this->session->userdata('posisi_id') < 7){

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

            // $queryCuti = "SELECT *
            // FROM `cuti`
            // WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '2') ";
            // $data['Cuti'] = $this->db->query($queryCuti)->result_array();

            $queryPresensi = "SELECT *
            FROM `presensi`
            WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1')";
            $data['presensi'] = $this->db->query($queryPresensi)->result_array();

            // $queryIMP = "SELECT *
            // FROM `imp`
            // WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '2') ";
            // $data['imp'] = $this->db->query($queryIMP)->result_array();

            $data['Cuti'] = null;
            $data['imp'] = null;

        }else{
            $data['Reservasi'] = null;
            $data['RencanaLembur'] = null;
            $data['RealisasiLembur'] = null;
            $data['Cuti'] = null;
            $data['presensi'] = null;
            $data['imp'] = null;
        }


        // Halaman dashboard
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = $this->session->userdata('nama');
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
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

    public function vote_bipartit()
    {
                $data = [
                    'npk' => $this->session->userdata('npk'),
                    'vote_npk' => $this->input->post('vote')
                ];
                $this->db->insert('vote_bipartit', $data);
    
            redirect('dashboard');
        
    }

    public function vote_reset()
    {
              // Menghapus data di mana npk sesuai dengan session
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->delete('vote_bipartit');
    
            redirect('dashboard');
        
    }

    public function wa()
    {
        $client = new \GuzzleHttp\Client();
        $options = [
        'form_params' => [
          'token' => '1o7dFUa9TKGawCCwpGXo5H9ag4X7Z8xYw5fyDY3yg67UWp1PF8',
          'number' => '081311196988',
          'message' => 'Testing RAISA',
          'date' => date('Y-m-d'),
          'time' => date(' H:i:s')
        ]];
        $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
        $res = $client->sendAsync($request, $options)->wait();
        echo $res->getBody();
        
        
    }

}
