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
        $data['informasi'] = $this->db->where('berlaku >', date('Y-m-d'));
        $data['informasi'] = $this->db->where('status', 'PUBLISHED');
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
        $config['max_size']             = 2048;
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
        $config['max_size']             = 2048;
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
        $data['sidemenu'] = 'Layanan';
        $data['sidesubmenu'] = 'Broadcast';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $data['lastA'] = $this->db->get_where('log_broadcast', ['group' => 'A'])->row_array();
        $data['lastB'] = $this->db->get_where('log_broadcast', ['group' => 'B'])->row_array();
        $data['lastC'] = $this->db->get_where('log_broadcast', ['group' => 'C'])->row_array();
        $data['lastD'] = $this->db->get_where('log_broadcast', ['group' => 'D'])->row_array();
        $data['lastE'] = $this->db->get_where('log_broadcast', ['group' => 'E'])->row_array();
        $data['lastF'] = $this->db->get_where('log_broadcast', ['group' => 'F'])->row_array();
      
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

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('group', 'A');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'B') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'B');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('group', 'B');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'C') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'C');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('group', 'C');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'D') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'D');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('group', 'D');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'E') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'E');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('group', 'E');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'F') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'F');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('group', 'F');
            $this->db->update('log_broadcast');
            
        } elseif ($parameter == 'Z') {
            $this->db->where('npk', '0282');
            $this->db->or_where('npk', '0198');
            $karyawan = $this->db->get('karyawan')->result_array();
        }

        foreach ($karyawan as $row) :

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
                        // 'json' => [
                        //     'phone' => $row['phone'],
                        //     'message' => "*AOP CORE VALUE*" .
                        //     "\r\n \r\n*KERJASAMA*" .
                        //     "\r\n*Menghormati dan mensukseskan keputusan yang telah diambil*" .
                        //     "\r\n \r\n#AkuPrima #" . $row['inisial']."PastiBisa"
                        // ],
                        'json' => [
                            'phone' => $row['phone'],
                            'message' => "*SURVEY KEPUASAN EVENT EMPLOYEE DAY WINTEQ 2023*" .
                            "\r\n \r\nDear *" . $row['nama'] . "*," .
                            "\r\nTerima kasih atas antusiasme yang luar biasa dalam acara Employee Day Winteq 2023." .
                            "\r\nMewakili panitia, kami menyadari bahwa ada beberapa hal yg mungkin tidak anda sukai selama acara berlangsung." .
                            "\r\nBeri tahu kami agar acara berikutnya jadi lebih lagi dengan cara mengisi form survey berikut :." .
                            "\r\n \r\nhttps://forms.office.com/r/SYVEaLZrua" .
                            "\r\n \r\nPetir bukan sembarang petir, Petir menyambar negara kenya" .
                            "\r\nTerima kasih yg udah hadir, sampai jumpa di employee day berikutnya." .
                            "\r\n \r\n#EDWinteq2023"
                        ],
                        // 'json' => [
                        //     'phone' => $row['phone'],
                        //     'message' => "*Akses Internet Sudah NORMAL Kembali*" .
                        //     "\r\n \r\nSaat ini Akses Internet sudah normal kembali dan bisa kamu gunakan." .
                        //     "\r\nHubungi IT Care jika kamu masih mengalami kendala." .
                        //     "\r\n \r\nMohon maaf atas ketidaknyamanan yang terjadi." .
                        //     "\r\nHormat kami," .
                        //     "\r\nIT" .
                        //     "\r\n#Winteq #". $row['inisial']
                        // ],
                    ]
                );
                $body = $response->getBody();

        endforeach;
        redirect('layanan/broadcast');
    }

    public function broadcast_send_up($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        if ($parameter == 'A') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('gol_id >', '1');
            $this->db->where('group', 'A');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'B') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('gol_id >', '1');
            $this->db->where('group', 'B');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'C') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('gol_id >', '1');
            $this->db->where('group', 'C');
            // $this->db->where('npk', '0282');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'D') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('gol_id >', '1');
            $this->db->where('group', 'D');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'E') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('gol_id >', '1');
            $this->db->where('group', 'E');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'F') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('gol_id >', '1');
            $this->db->where('group', 'F');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'Z') {
            $this->db->where('npk', '0282');
            $karyawan = $this->db->get('karyawan')->result_array();
        }

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
                            'message' => "📢*PEMBAYARAN PERJALANAN DINAS VIA ASTRAPAY*" .
                            "\r\n \r\nSemangat pagi *" . $k['nama'] . "*," .
                            "\r\nSegera Download dan Daftar akun ASTRAPAY-mu sekarang!" .
                            "\r\nMulai *10 November 2021* untuk Gol 4 dan Gol 4up diutamakan untuk menggunakan *ASTRAPAY* Sebagai dompet digital di RAISA." .
                            "\r\n \r\nAktifkan ASTRAPAY di RAISA dengan mendaftarkan nomor ASTRAPAY-mu dan jadikan sebagai ewallet UTAMA." .
                            "\r\n \r\n_Informasi lebik lengkap klik : https://www.astrapay.com/_"
                        ],
                    ]
                );
                $body = $response->getBody();
        endforeach;
        redirect('layanan/broadcast');
    }

    public function contest($params=null)
    {
        date_default_timezone_set('asia/jakarta');
        if($params=='add')
        {
            $this->load->helper('string');
            $data = [
                'id' => random_string('alnum',8),
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'gambar_banner' => 'default.jpg',
                'gambar_konten' => 'default.jpg',
                'berlaku' => date('Y-m-d', strtotime("-1 day")),
                'status' => 'NEED A REVIEW',
                'created_by' => $this->session->userdata('inisial'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('informasi', $data);

            $config['upload_path']          = './assets/img/info/';
            $config['allowed_types']        = 'jpg|jpeg|png';
            $config['max_size']             = 2048;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('gambar_banner')) {
                $this->db->set('gambar_banner', $this->upload->data('file_name'));
                $this->db->set('gambar_konten', $this->upload->data('file_name'));
                $this->db->where('judul', $this->input->post('judul'));
                $this->db->update('informasi');
            }

            redirect('layanan/contest');
        } elseif($params=='delete')
        {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('informasi');
        
        } elseif($params=='review')
        {
            $data['sidemenu'] = 'Layanan';
            $data['sidesubmenu'] = 'Banner ';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['banner'] = $this->db->get_where('informasi', ['status' => 'NEED A REVIEW'])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('layanan/contest/review', $data);
            $this->load->view('templates/footer');
        
        } elseif($params=='approve')
        {
                $this->db->set('berlaku', date('Y-m-d', strtotime($this->input->post('berlaku'))));
                $this->db->set('status', 'PUBLISHED');
                $this->db->set('approved_by', $this->session->userdata('inisial'));
                $this->db->set('approved_at', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('informasi');

                redirect('layanan/contest/review');

        } elseif($params=='reject')
        {
                $this->db->set('status', 'REJECTED');
                $this->db->set('deskripsi', $this->input->post('deskripsi'));
                $this->db->set('approved_by', $this->session->userdata('inisial'));
                $this->db->set('approved_at', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('informasi');

                redirect('layanan/contest/review');
        }else
        {
            $data['sidemenu'] = 'Dashboard';
            $data['sidesubmenu'] = '';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['banner'] = $this->db->get_where('informasi', ['created_by' =>  $this->session->userdata('inisial')])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('layanan/contest/index', $data);
            $this->load->view('templates/footer');
        }
    }
}
