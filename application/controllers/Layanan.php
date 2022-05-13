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
        $data['sidemenu'] = 'Layanan';
        $data['sidesubmenu'] = 'Broadcast';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
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
        } elseif ($parameter == 'B') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'B');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'C') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'C');
            // $this->db->where('npk', '0282');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'D') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'D');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'E') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'E');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'F') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'F');
            $karyawan = $this->db->get('karyawan')->result_array();
        } elseif ($parameter == 'Z') {
            $this->db->where('npk', '0282');
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
                        'json' => [
                            'phone' => $row['phone'],
                            'message' => "🕌 *HIMBAUAN PROKES LIBUR LEBARAN 1443 H*" .
                            "\r\n \r\nSemangat pagi *" . $row['nama'] . "*," .
                            "\r\nWaktu cuti bersama telah tiba, saatnya berkumpul dengan sanak keluarga dan handai taulan di kampung halaman. Diperkirakan mobilitas orang akan meningkat drastis, sementara potensi gangguan kesehatan juga masih ada karena status pandemi belum dicabut oleh pemerintah." .
                            "\r\nAtas dasar hal itu, untuk tetap menjaga dan melindungi kesehatan warga WINTEQ pasca musim cuti bersama ini, kami menghimbau bagi seluruh karyawan untuk turut serta dalam upaya menjaga dan melindungi kesehatan warga WlNTEQ, dengan beberapa hal sebagai berikut:" .
                            "\r\n \r\n*1*. Tetap *disiplin* menjalankan *protokol kesehatan* yang selama ini telah dicanangkan (selalu memakai masker, selalu menjaga kebersihan dengan mencuci tangan, Menjaga jarak dan menghindari kerumunan)." .
                            "\r\n \r\n*2*. Segera melakukan *vaksinasi booster* bagi yang telah memenuhi syarat." .
                            "\r\n \r\n*3*. Pada saat akan masuk kerja kembali, harap memperhatikan *ketentuan berikut ini :*" .
                            "\r\nhttps://raisa.winteq-astra.com/assets/pdf/HIMBAUAN%20GUGUS%20TUGAS.pdf" .
                            "\r\n \r\nDemikian himbauan ini disampaikan untuk bisa dilaksanakan dengan sebaik baiknya." .
                            "\r\n \r\nHormat Kami," .
                            "\r\nTim Gugus Tugas Penanganan Covid-19 WINTEQ" .
                            "\r\n \r\n_Selamat Hari Raya Idul Fitri 1443 H_"
                        ],
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
        if($params=='add')
        {
            date_default_timezone_set('asia/jakarta');
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
            $config['max_size']             = 1024;
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
