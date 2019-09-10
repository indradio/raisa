<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persetujuandl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        if ($this->session->userdata('posisi_id') < 7) {
            $data['sidemenu'] = 'Perjalanan Dinas';
            $data['sidesubmenu'] = 'Persetujuan DL';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('persetujuandl/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('auth/denied');
        }
    }

    public function setujudl()
    {
        date_default_timezone_set('asia/jakarta');
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($rsv['atasan1'] == $this->session->userdata['inisial'] and $rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
            $this->db->set('atasan2', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan1'] == $this->session->userdata['inisial']) {
            if ($rsv['status'] == 3) {
                $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
                $this->session->set_flashdata('message', 'udahsetujudl');
                redirect('persetujuandl/index');
            } else {
                $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
            }
        } elseif ($rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan2', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }
        //Ganti status : 1 = Reservasi baru, 2 = Reservasi disetujui seksi/koordinator, 3 = Reservasi disetujui Kadept/kadiv/coo
        if ($this->session->userdata['posisi_id'] == '1' or $this->session->userdata['posisi_id'] == '2' or $this->session->userdata['posisi_id'] == '3') {
            if ($rsv['jenis_perjalanan'] == 'TAPP' or $rsv['jenis_perjalanan'] == 'TA') {
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '3');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                $this->db->where('posisi_id', '3');
                $this->db->where('dept_id', '21');
                $karyawan = $this->db->get('karyawan')->row_array();
                $my_apikey = "NQXJ3HED5LW2XV440HCG";
                $destination = $karyawan['phone'];
                $message = "*PENGAJUAN PERJALANAN DINAS TA*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                    "\r\n Nama : *" . $rsv['nama'] . "*" .
                    "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                    "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                    "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                    " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
                $api_url = "http://panel.apiwha.com/send_message.php";
                $api_url .= "?apikey=" . urlencode($my_apikey);
                $api_url .= "&number=" . urlencode($destination);
                $api_url .= "&text=" . urlencode($message);
                json_decode(file_get_contents($api_url, false));

                $this->db->where('posisi_id', '2');
                $this->db->where('div_id', '2');
                $karyawan = $this->db->get('karyawan')->row_array();
                $my_apikey = "NQXJ3HED5LW2XV440HCG";
                $destination = $karyawan['phone'];
                $message = "*PENGAJUAN PERJALANAN DINAS TA*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                    "\r\n Nama : *" . $rsv['nama'] . "*" .
                    "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                    "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                    "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                    " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
                $api_url = "http://panel.apiwha.com/send_message.php";
                $api_url .= "?apikey=" . urlencode($my_apikey);
                $api_url .= "&number=" . urlencode($destination);
                $api_url .= "&text=" . urlencode($message);
                json_decode(file_get_contents($api_url, false));
            } else {
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '5');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                $this->db->where('sect_id', '214');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();
                $my_apikey = "NQXJ3HED5LW2XV440HCG";
                $destination = $ga_admin['phone'];
                $message = "*PENGAJUAN PERJALANAN DINAS (Telah di setujui)*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                    "\r\n Nama : *" . $rsv['nama'] . "*" .
                    "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                    "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                    "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                    " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
                $api_url = "http://panel.apiwha.com/send_message.php";
                $api_url .= "?apikey=" . urlencode($my_apikey);
                $api_url .= "&number=" . urlencode($destination);
                $api_url .= "&text=" . urlencode($message);
                json_decode(file_get_contents($api_url, false));
            }
        } elseif ($this->session->userdata['posisi_id'] == '4' or $this->session->userdata['posisi_id'] == '5' or $this->session->userdata['posisi_id'] == '6') {
            $this->db->set('status', '2');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('inisial', $rsv['atasan2']);
            $karyawan = $this->db->get('karyawan')->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN PERJALANAN DINAS (Sebagai Atasan 2)*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                "\r\n Nama : *" . $rsv['nama'] . "*" .
                "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }

        $this->session->set_flashdata('message', 'setujudl');
        redirect('persetujuandl/index');
    }
    public function bataldl()
    {
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($rsv['atasan1'] == $this->session->userdata['inisial'] and $rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->set('atasan2', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan1'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan2', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }

        $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan'));
        $this->db->set('status', '0');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('persetujuandl/index');
    }
}
