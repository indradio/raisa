<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends CI_Controller
{
    public function index()
    {
        date_default_timezone_set('asia/jakarta');
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

        echo 'Kirim Notif lembur hari ini ke GA Admin Berhasil';
    }
}