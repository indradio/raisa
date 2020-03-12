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
            $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
            $this->db->set('jamkembali', $this->input->post('jamkembali'));
            $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
            $this->db->set('atasan2', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan1'] == $this->session->userdata['inisial']) {
            if ($rsv['status'] > 2) {
                $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
                $this->db->set('jamkembali', $this->input->post('jamkembali'));
                $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
                $this->session->set_flashdata('message', 'setujudl');
                redirect('persetujuandl/index');
            } else {
                $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
                $this->db->set('jamkembali', $this->input->post('jamkembali'));
                $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
            }
        } elseif ($rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
            $this->db->set('jamkembali', $this->input->post('jamkembali'));
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
                $fin_head = $this->db->get('karyawan')->row_array();
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $fin_head['phone'],
                    'message' => "*PENGAJUAN PERJALANAN DINAS TA/TAPP*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                    "\r\n Nama : *" . $rsv['nama'] . "*" .
                    "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                    "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                    "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                    " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                );
                
                $ch = curl_init();
                
                curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $result = curl_exec($ch);
            } else {
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '6');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                $this->db->where('sect_id', '214');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $ga_admin['phone'],
                    'message' => "*PENGAJUAN PERJALANAN DINAS*".
                    "\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                    "\r\n Nama : *" . $rsv['nama'] . "*" .
                    "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                    "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                    "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                    " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                );
                
                $ch = curl_init();
                
                curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $result = curl_exec($ch);
            }
        } elseif ($this->session->userdata['posisi_id'] == '4' or $this->session->userdata['posisi_id'] == '5' or $this->session->userdata['posisi_id'] == '6') {
            $this->db->set('status', '2');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('inisial', $rsv['atasan2']);
            $atsn2 = $this->db->get('karyawan')->row_array();
            $postData = array(
                'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                'number' => $atsn2['phone'],
                'message' => "*PENGAJUAN PERJALANAN DINAS (ATASAN 2)*".
                "\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                "\r\n Nama : *" . $rsv['nama'] . "*" .
                "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "*" .
                " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
            );
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $result = curl_exec($ch);
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
