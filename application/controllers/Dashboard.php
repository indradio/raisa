<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        //auto batalkan perjalanan
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
}
