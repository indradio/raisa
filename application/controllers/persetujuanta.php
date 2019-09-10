<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persetujuanta extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Persetujuan TA';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $dataKu = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        if ($dataKu['div_id'] == '2' and $dataKu['posisi_id'] == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('persetujuanta/index', $data);
            $this->load->view('templates/footer');
        } else if ($dataKu['dept_id'] == '21' and $dataKu['posisi_id'] == '3') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('persetujuanta/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('auth/denied');
        }
    }

    public function setujuta()
    {
        date_default_timezone_set('asia/jakarta');
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($this->session->userdata('posisi_id') == '2') {
            $this->db->set('div_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_div', date('Y-m-d H:i:s'));
            $this->db->set('status', '5');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('sect_id', '214');
            $ga_admin = $this->db->get('karyawan_admin')->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $ga_admin['phone'];
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
        } elseif ($this->session->userdata('posisi_id') == '3') {
            $this->db->set('fin_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_fin', date('Y-m-d H:i:s'));
            $this->db->set('status', '4');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('posisi_id', '2');
            $this->db->where('div_id', '2');
            $karyawan = $this->db->get('karyawan')->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN PERJALANAN DINAS TA (Telah disetujui FIN)*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
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
        redirect('persetujuanta/index');
    }

    public function batalta()
    {
        date_default_timezone_set('asia/jakarta');
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($this->session->userdata('posisi_id') == '2') {
            $this->db->set('div_ttd', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_div', date('Y-m-d H:i:s'));
            $this->db->set('catatan', $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('npk', $rsv['npk']);
            $karyawan = $this->db->get('karyawan')->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PERJALANAN DINAS TA ANDA DIBATALKAN*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                "\r\n Nama : *" . $rsv['nama'] . "*" .
                "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                " ) \r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        } elseif ($this->session->userdata('posisi_id') == '3') {
            $this->db->set('fin_ttd', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_fin', date('Y-m-d H:i:s'));
            $this->db->set('catatan', $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('npk', $rsv['npk']);
            $karyawan = $this->db->get('karyawan')->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PERJALANAN DINAS TA ANDA DIBATALKAN*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                "\r\n Nama : *" . $rsv['nama'] . "*" .
                "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                " ) \r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }

        $this->session->set_flashdata('message', 'bataldl');
        redirect('persetujuanta/index');
    }
}
