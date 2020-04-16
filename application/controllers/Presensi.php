<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('presensi_model', 'presensi');
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

        if (date('H:i') >= '07:30' and date('H:i') <= '09:00') {
            $data['state'] = 'C/In';
        } elseif (date('H:i') >= '11:30' and date('H:i') <= '13:00') {
            $data['state'] = 'C/Rest';
        } elseif (date('H:i') >= '16:00' and date('H:i') <= '17:30') {
            $data['state'] = 'C/Out';
        } else {
            $data['state'] = 'No State for this time';
        }

        $data['time'] = date('H:i');

        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/index', $data);
        $this->load->view('templates/footer');
    }

    public function submit()
    {
        date_default_timezone_set('asia/jakarta');
        $id = date('ymd') . $this->session->userdata('npk') . '-' . $this->input->post('state');
        if (date('D') == 'Sat' or date('D') == 'Sun') {
            $day = 'DayOff';
        } else {
            $day = 'WorkDay';
        }
        if (date('H:i') >= '07:30' and date('H:i') <= '09:00') {
            $state = 'C/In';
        } elseif (date('H:i') >= '11:30' and date('H:i') <= '13:00') {
            $state = 'C/Rest';
        } elseif (date('H:i') >= '16:00' and date('H:i') <= '17:30') {
            $state = 'C/Out';
        } else {
            $state = 'notime';
        }
        if ($state != 'notime') {
            if ($this->input->post('lat')) {
                $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
                if (empty($presensi)) {
                    $data = [
                        'id' => $id,
                        'npk' => $this->session->userdata('npk'),
                        'nama' => $this->session->userdata('nama'),
                        'time' => date('Y-m-d H:i:s'),
                        'state' => $this->input->post('state'),
                        'new_state' => 'WFH',
                        'loc' => $this->input->post('loc'),
                        'lat' => $this->input->post('lat'),
                        'lng' => $this->input->post('lng'),
                        'platform' => $this->input->post('platform'),
                        'div_id' => $this->session->userdata('div_id'),
                        'dept_id' => $this->session->userdata('dept_id'),
                        'sect_id' => $this->session->userdata('sect_id'),
                        'day_state' => $day
                    ];
                    $this->db->insert('presensi', $data);
                    $this->session->set_flashdata('message', 'clockSuccess');
                } else {
                    $this->session->set_flashdata('message', 'clockSuccess2');
                }
            } else {
                $this->session->set_flashdata('message', 'clockFailed');
            }
        } else {
            $this->session->set_flashdata('message', 'clockFailed');
        }
        redirect('presensi');
    }
    public function pik()
    {
        date_default_timezone_set('asia/jakarta');

        $data = [
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama')
        ];
        $this->db->insert('idcard', $data);
        redirect('presensi');
    }

    public function data()
    {
        date_default_timezone_set('asia/jakarta');
        if (empty($this->input->post('month'))) {
            $data['bulan'] = date('m');
        } else {
            $data['bulan'] = $this->input->post('month');
        }
        $data['tahun'] = date('Y');
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Data';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/data', $data);
        $this->load->view('templates/footer');
    }

    public function notifikasi($menu)
    {
        date_default_timezone_set('asia/jakarta');

        if ($menu == 'index') {
            $data['sidemenu'] = 'Kehadiran';
            $data['sidesubmenu'] = 'Data';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('presensi/notifikasi', $data);
            $this->load->view('templates/footer');
        } elseif ($menu == 'clin') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            // $this->db->where('role_id', '1');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*Semangat Pagi, Hai " . $k['nama'] . "*" .
                        "\r\n \r\n---Harap absen ONLINE sekarang---" .
                        "\r\n \r\nRAISA cuma bakal ingetin kamu sampe *kamis* yah." .
                        "\r\nSetelah kamis kamu harus inget sendiri untuk absen di waktu-waktu ini:" .
                        "\r\n \r\n*1. Check in antara 7.30-9.00*" .
                        "\r\n2. Istirahat antara 11.30-13.00" .
                        "\r\n3. Check out antara 16.00-17.30" .
                        "\r\n \r\nPastikan GPS smartphone kamu aktif dan ijinkan akses saat browser kamu memintanya ya" .
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
            endforeach;
        } elseif ($menu == 'clrest') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            // $this->db->where('role_id', '1');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*Semangat Pagi, Hai " . $k['nama'] . "*" .
                        "\r\n \r\n---Harap absen ONLINE sekarang---" .
                        "\r\n \r\nRAISA cuma bakal ingetin kamu sampe *kamis* yah." .
                        "\r\nSetelah kamis kamu harus inget sendiri untuk absen di waktu-waktu ini:" .
                        "\r\n \r\n1. Check in antara 7.30-9.00" .
                        "\r\n*2. Istirahat antara 11.30-13.00*" .
                        "\r\n3. Check out antara 16.00-17.30" .
                        "\r\n \r\nPastikan GPS smartphone kamu aktif dan ijinkan akses saat browser kamu memintanya ya" .
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
            endforeach;
        } elseif ($menu == 'clout') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            // $this->db->where('role_id', '1');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*Semangat Pagi, Hai " . $k['nama'] . "*" .
                        "\r\n \r\n---Harap absen ONLINE sekarang---" .
                        "\r\n \r\nRAISA cuma bakal ingetin kamu sampe *kamis* yah." .
                        "\r\nSetelah kamis kamu harus inget sendiri untuk absen di waktu-waktu ini:" .
                        "\r\n \r\n1. Check in antara 7.30-9.00" .
                        "\r\n2. Istirahat antara 11.30-13.00" .
                        "\r\n*3. Check out antara 16.00-17.30*" .
                        "\r\n \r\nPastikan GPS smartphone kamu aktif dan ijinkan akses saat browser kamu memintanya ya" .
                        "\r\n \r\n*INFO : Winteq punya IG baru loh! @astra_winteq.*" .
                        "\r\n*Di follow ya! Biar tetep hits dan gak ketinggalan info tentang winteq.*" .
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
            endforeach;
        }
    }
}
