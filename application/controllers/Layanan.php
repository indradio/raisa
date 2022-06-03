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
                            'message' => "🍛 *JADWAL MEDICAL CHECK UP*" .
                            "\r\n \r\nSemangat pagi *" . $row['nama'] . "*," .
                            "\r\nMakin dini suatu penyakit terdeteksi, maka makin cepat pertolongan yang dapat diberikan." .
                            "\r\nMaka kepada seluruh Karyawan Tetap diwajibkan untuk mengikuti Medical Check Up yang akan dilaksanakannya pada" .
                            "\r\n \r\n*Hari / Tanggal : Selasa /07 Juni 2022*" .
                            "\r\n*Waktu :08.00- 13.00 MB*" .
                            "\r\n*Tempat : Ruang Serbaguna*" .
                            "\r\n \r\n*PENTING!*" .
                            "\r\nl. Seluruh peserta MCU dianjurkan puasa terlebih dahulu selama 09 - 10 jam (hanya boleh minum air putih saja) sebelum melaksanakan MCU" .
                            "\r\n2. Karyawan/karyawati diharapkan untuk menggunakan kaos pada saat pemeriksaan Thorax" .
                            "\r\n3. Bagi karyawan yang berusia >40 tahun dimohon untuk membawa sepatu olahraga" .
                            "\r\n4. Bagi karyawan berhalangan hadir, maka dapat melakukan MCU susulan dengan datang langsung ke RS FMC dengan melakukan konfimasi H-l ke HR" .
                            "\r\n5. Bagi karyawan yang tidak mengikuti MCU yang sudah ditentukan dan ternyata dikemudian hari terdeteksi panyakit yang berakibat fatal, maka Perusahaan tidak akan bertanggung jawab atas biaya pengobatan tersebut" .
                            "\r\nDemikian informasi ini disampaikan untuk bisa dilaksanakan dengan sebaik baiknya." .
                            "\r\n \r\nHormat Kami," .
                            "\r\nHuman Capital" .
                            "\r\n \r\n_Sehat-sehat ya semuanya!_"
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
