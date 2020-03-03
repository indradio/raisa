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
        } else if ($this->session->userdata('inisial')=='ABU') {
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
            if ($rsv['jenis_perjalanan']=='TA'){
                $this->db->set('div_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_div', date('Y-m-d H:i:s'));
                $this->db->set('status', '5');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
    
                $this->db->where('sect_id', '215');
                $hr_admin = $this->db->get('karyawan_admin')->row_array();
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $hr_admin['phone'],
                    'message' => "*PENGAJUAN PERJALANAN DINAS TA*".
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
            }elseif ($rsv['jenis_perjalanan']=='TAPP'){
                $this->db->set('div_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_div', date('Y-m-d H:i:s'));
                $this->db->set('status', '6');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
    
                $this->db->where('sect_id', '214');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $ga_admin['phone'],
                    'message' => "*PENGAJUAN PERJALANAN DINAS TAPP*\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
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
        } elseif ($this->session->userdata('posisi_id') == '3') {
            $this->db->set('fin_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_fin', date('Y-m-d H:i:s'));
            $this->db->set('status', '4');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('posisi_id', '2');
            $this->db->where('div_id', '2');
            $div_head = $this->db->get('karyawan')->row_array();
            $postData = array(
                'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                'number' => $div_head['phone'],
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
        }
        $this->session->set_flashdata('message', 'setujudl');
        redirect('persetujuanta/index');
    }

    public function batalta()
    {
        date_default_timezone_set('asia/jakarta');
        $rsv = $this->db->get_where('reservasi', ['id' => $this->input->post('id')])->row_array();
        if ($this->session->userdata('posisi_id') == '2') {
            $this->db->set('div_ttd', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_div', date('Y-m-d H:i:s'));
            $this->db->set('catatan', $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($this->session->userdata('posisi_id') == '3') {
            $this->db->set('fin_ttd', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_fin', date('Y-m-d H:i:s'));
            $this->db->set('catatan', $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }
        
        $user = $this->db->get_where('karyawan', ['npk' => $rsv['npk']])->row_array();
        $postData = array(
            'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
            'number' => $user['phone'],
            'message' => "*PERJALANAN DINAS ANDA DIBATALKAN*" .
            "\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
            "\r\n Nama : *" . $rsv['nama'] . "*" .
            "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
            "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
            "\r\n Peserta : *" . $rsv['anggota'] . "*" .
            "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
            "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
            "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
            "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
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

        $this->session->set_flashdata('message', 'bataldl');
        redirect('persetujuanta/index');
    }

    public function konfirmasita()
    {
        date_default_timezone_set('asia/jakarta');
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        
        if ($rsv['kepemilikan']=='Non Operasional' AND $rsv['kendaraan']=='Non Operasional')
        {
            $this->db->set('admin_hr', $this->session->userdata['inisial']);
            $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
            $this->db->set('status', '9');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('sect_id', '214');
            $ga_admin = $this->db->get('karyawan_admin')->row_array();
            $postData = array(
                'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                'number' => $ga_admin['phone'],
                'message' => "*PENGAJUAN PERJALANAN DINAS TA*".
                "\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                "\r\n Nama : *" . $rsv['nama'] . "*" .
                "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
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
        }else{
            $this->db->set('admin_hr', $this->session->userdata['inisial']);
            $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
            $this->db->set('status', '6');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('sect_id', '214');
            $ga_admin = $this->db->get('karyawan_admin')->row_array();
            $postData = array(
                'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                'number' => $ga_admin['phone'],
                'message' => "*PENGAJUAN PERJALANAN DINAS TA*".
                "\r\n \r\n No. Reservasi : *" . $rsv['id'] . "*" .
                "\r\n Nama : *" . $rsv['nama'] . "*" .
                "\r\n Tujuan : *" . $rsv['tujuan'] . "*" .
                "\r\n Keperluan : *" . $rsv['keperluan'] . "*" .
                "\r\n Peserta : *" . $rsv['anggota'] . "*" .
                "\r\n Berangkat : *" . $rsv['tglberangkat'] . "* *" . $rsv['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $rsv['tglkembali'] . "* *" . $rsv['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
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
        redirect('perjalanandl/adminhr');
    }
}
