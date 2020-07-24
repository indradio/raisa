<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Layanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    public function informasi()
    {
        $data['sidemenu'] = 'Layanan';
        $data['sidesubmenu'] = 'Informasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['informasi'] = $this->db->get('informasi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/informasi', $data);
        $this->load->view('templates/footer');
    }

    public function buatInformasi()
    {
        date_default_timezone_set('asia/jakarta');

        $data = [
            'id' => time(),
            'judul' => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'gambar_banner' => 'default.jpg',
            'gambar_konten' => 'default.jpg',
            'berlaku' => date('Y-m-d', strtotime($this->input->post('berlaku')))
        ];
        $this->db->insert('informasi', $data);

        $config['upload_path']          = './assets/img/info/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('gambar_banner')) {
            $this->db->set('gambar_banner', $this->upload->data('file_name'));
            $this->db->set('gambar_konten', $this->upload->data('file_name'));
            $this->db->where('judul', $this->input->post('judul'));
            $this->db->update('informasi');
        }

        redirect('layanan/informasi');
    }

    public function updateInformasi()
    {
        date_default_timezone_set('asia/jakarta');

        $this->db->set('judul', $this->input->post('judul'));
        $this->db->set('deskripsi', $this->input->post('deskripsi'));
        $this->db->set('berlaku', date('Y-m-d', strtotime($this->input->post('berlaku'))));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('informasi');

        $config['upload_path']          = './assets/img/info/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('gambar_banner')) {
            $this->db->set('gambar_banner', $this->upload->data('file_name'));
            $this->db->set('gambar_konten', $this->upload->data('file_name'));
        }

        redirect('layanan/informasi');
    }

    public function hapusInformasi($id)
    {
        $this->db->set('informasi');
        $this->db->where('id', $id);
        $this->db->delete('informasi');

        redirect('layanan/informasi');
    }

    public function messages()
    {
        $data['sidemenu'] = 'Layanan';
        $data['sidesubmenu'] = 'Kirim Pesan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['pesan'] = $this->db->get('layanan_pesan')->result_array();
        $data['notifikasi'] = $this->db->get('layanan_notifikasi')->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/messages', $data);
        $this->load->view('templates/footer');
    }

    public function messages_send()
    {
        foreach ($this->input->post('penerima') as $to) :
            date_default_timezone_set('asia/jakarta');
            
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
                        'phone' => $to,
                        'message' => $this->input->post('pesan'),
                    ],
                ]
            );
            $body = $response->getBody();

            // Record History
            $penerima = $this->db->get_where('karyawan', ['phone' => $to])->row_array();

            $data = [
                'create_at' => date('Y-m-d H:i:s'),
                'pengirim' => $this->session->userdata('nama'),
                'penerima' => $penerima['nama'],
                'pesan' => $this->input->post('pesan')
            ];
            $this->db->insert('layanan_pesan', $data);

        endforeach;

        redirect('layanan/messages');
    }

    public function notifikasi()
    {
        $this->db->set('pesan', $this->input->post('notifikasi'));
        $this->db->where('id', '1');
        $this->db->update('layanan_notifikasi');

        redirect('layanan/messages');
    }

    public function broadcast()
    {
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Data';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/broadcast', $data);
        $this->load->view('templates/footer');
    }
    public function broadcast_send($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        if ($parameter == 'A') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'A');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
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
                             'phone' => $k['phone'],
                             'message' => "*UPDATE LINK WEBINAR : MENGHADAPI NEW NORMAL*" .
                             "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                             "\r\n \r\nYuk gabung di webinar, sebentar lagi akan segera mulai." .
                             "\r\n \r\nKlik link dibahaw ini ya" .
                             "\r\n \r\n*https://teams.microsoft.com/dl/launcher/launcher.html?type=meetup-join&deeplinkId=2f81ece6-58cf-4b19-b57b-1b94bbcd5be2&directDl=true&msLaunch=true&enableMobilePage=true&url=%2F_%23%2Fl%2Fmeetup-join%2F19%253ameeting_MzI1ZWIzYWQtMDgyNi00ZWRiLWIxZGYtYTc5OTcxYmIxNjA0%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522f5332409-fcd5-4d5d-aaf7-b5189010d0d0%2522%252c%2522Oid%2522%253a%25223509aa3d-d95b-4588-824e-a17f86b4063e%2522%252c%2522IsBroadcastMeeting%2522%253atrue%257d%26anon%3Dtrue&suppressPrompt=true*" .
                             "\r\n \r\n \r\n*INGAT! Buat kamu yang nobar, Tetap menjaga jarak, Gunakan masker dan menjalankan protokol kesehatan selama webinar berlangsung.*"
                         ],
                     ]
                 );
                 $body = $response->getBody();
            endforeach;
            redirect('layanan/broadcast');
        } elseif ($parameter == 'B') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'B');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
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
                            'phone' => $k['phone'],
                            'message' => "*UPDATE LINK WEBINAR : MENGHADAPI NEW NORMAL*" .
                            "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                            "\r\n \r\nYuk gabung di webinar, sebentar lagi akan segera mulai." .
                            "\r\n \r\nKlik link dibahaw ini ya" .
                            "\r\n \r\n*https://teams.microsoft.com/dl/launcher/launcher.html?type=meetup-join&deeplinkId=2f81ece6-58cf-4b19-b57b-1b94bbcd5be2&directDl=true&msLaunch=true&enableMobilePage=true&url=%2F_%23%2Fl%2Fmeetup-join%2F19%253ameeting_MzI1ZWIzYWQtMDgyNi00ZWRiLWIxZGYtYTc5OTcxYmIxNjA0%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522f5332409-fcd5-4d5d-aaf7-b5189010d0d0%2522%252c%2522Oid%2522%253a%25223509aa3d-d95b-4588-824e-a17f86b4063e%2522%252c%2522IsBroadcastMeeting%2522%253atrue%257d%26anon%3Dtrue&suppressPrompt=true*" .
                            "\r\n \r\n \r\n*INGAT! Buat kamu yang nobar, Tetap menjaga jarak, Gunakan masker dan menjalankan protokol kesehatan selama webinar berlangsung.*"
                        ],
                    ]
                );
                $body = $response->getBody();
            endforeach;
            redirect('layanan/broadcast');
        } elseif ($parameter == 'C') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'C');
            // $this->db->where('npk', '0282');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
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
                            'phone' => $k['phone'],
                            'message' => "*UPDATE LINK WEBINAR : MENGHADAPI NEW NORMAL*" .
                            "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                            "\r\n \r\nYuk gabung di webinar, sebentar lagi akan segera mulai." .
                            "\r\n \r\nKlik link dibahaw ini ya" .
                            "\r\n \r\n*https://teams.microsoft.com/dl/launcher/launcher.html?type=meetup-join&deeplinkId=2f81ece6-58cf-4b19-b57b-1b94bbcd5be2&directDl=true&msLaunch=true&enableMobilePage=true&url=%2F_%23%2Fl%2Fmeetup-join%2F19%253ameeting_MzI1ZWIzYWQtMDgyNi00ZWRiLWIxZGYtYTc5OTcxYmIxNjA0%2540thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522f5332409-fcd5-4d5d-aaf7-b5189010d0d0%2522%252c%2522Oid%2522%253a%25223509aa3d-d95b-4588-824e-a17f86b4063e%2522%252c%2522IsBroadcastMeeting%2522%253atrue%257d%26anon%3Dtrue&suppressPrompt=true*" .
                            "\r\n \r\n \r\n*INGAT! Buat kamu yang nobar, Tetap menjaga jarak, Gunakan masker dan menjalankan protokol kesehatan selama webinar berlangsung.*"
                        ],
                    ]
                );
                $body = $response->getBody();
            endforeach;
            redirect('layanan/broadcast');
        }
    }
}
