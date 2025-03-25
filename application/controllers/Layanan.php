<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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
        $data['lastA'] = $this->db->get_where('log_broadcast', ['batch' => 'A'])->row_array();
        $data['lastB'] = $this->db->get_where('log_broadcast', ['batch' => 'B'])->row_array();
        $data['lastC'] = $this->db->get_where('log_broadcast', ['batch' => 'C'])->row_array();
        $data['lastD'] = $this->db->get_where('log_broadcast', ['batch' => 'D'])->row_array();
        $data['lastE'] = $this->db->get_where('log_broadcast', ['batch' => 'E'])->row_array();
        $data['lastF'] = $this->db->get_where('log_broadcast', ['batch' => 'F'])->row_array();
      
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/broadcast', $data);
        $this->load->view('templates/footer');
    }

    public function broadcast_wa()
    {

        $this->db->where('is_active', '1');
        $this->db->where('status', '1');
        $karyawan = $this->db->get('karyawan')->result_array();

        foreach ($karyawan as $row) :

            $client = new \GuzzleHttp\Client();
            $options = [
            'form_params' => [
            'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
            'number' => $row['phone'],
            'message' => "*VOTE KETUA BIPARTIT*". 
                        "\r\n \r\nSiapakah yang akan menjadi ketua bipartit periode 2024-2027?".
                        "\r\nKamulah penentunya!! Pilih sekarnag melalui RAISA" .
                        "\r\nUntuk informasi lebih lengkap dapat menghubungi pak suparmo.",
            'date' => date('Y-m-d'),
            'time' => date(' H:i:s')
            ]];
            $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
            $res = $client->sendAsync($request, $options)->wait();
            echo $res->getBody();

        endforeach;
        redirect('dashboard');

    }
    public function broadcast_send($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        if ($parameter == 'A') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('batch', 'A');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('batch', 'A');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'B') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('batch', 'B');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('batch', 'B');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'C') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('batch', 'C');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('batch', 'C');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'D') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('batch', 'D');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('batch', 'D');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'E') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('batch', 'E');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('batch', 'E');
            $this->db->update('log_broadcast');

        } elseif ($parameter == 'F') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('batch', 'F');
            $karyawan = $this->db->get('karyawan')->result_array();

            $this->db->set('last_sent', date('Y-m-d H:i:s'));
            $this->db->where('batch', 'F');
            $this->db->update('log_broadcast');
            
        } elseif ($parameter == 'Z') {
            $this->db->where('npk', '0282');
            // $this->db->or_where('npk', '');
            $karyawan = $this->db->get('karyawan')->result_array();
        }

        $client = new \GuzzleHttp\Client();
        $nowtime = time(); // Waktu awal saat ini

        foreach ($karyawan as $row) :

                //Notifikasi ke USER

                // $options = [
                // 'form_params' => [
                //     'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
                //     'number' => $row['phone'],
                //     'file' => 'https://raisa.winteq-astra.com/assets/img/wa/Kajian.jpg',
                //     'caption' => "🕌 *DKM WINTEQ Present* 🕌 *Kajian Islami Ramadan*". 
                //                 "\r\n \r\nAssalamu’alaikum warahmatullahi wabarakatuh".
                //                 "\r\nSemangat Pagi ".$row['nama'].
                //                 "\r\nDi Bulan Ramadan yang penuh berkah ini DKM Winteq akan menyelenggarakan kultum Ramadan yg akan dilaksanakan pada:".
                //                 "\r\n \r\n📅Hari: Kamis, 6 Maret 2025".
                //                 "\r\n 🕔Jam : *Ba'da Dzuhur* ".
                //                 "\r\n 🏡Lokasi : *Masjid Winteq*".
                //                 "\r\n 📝Tema :  *Keutamaan puasa Ramadan*".
                //                 "\r\n 🔊Narasumber : *Ust. Rudi Safaat*".
                //                 "\r\n \r\nMari maksimalkan Ramadan kali ini dengan menambah wawasan bersama. Ditunggu kehadirannya warga Winteq.".
                //                 "\r\nDKM Masjid Winteq ".
                //                 "\r\n \r\nFollow R A I S A x WINTEQ channel on WhatsApp: https://whatsapp.com/channel/0029Vah2IkLDzgT9vSSZfR40 ",
                //     'date' => date('Y-m-d'),
                //     'time' => date('H:i:s', $nowtime)
                // ]];
                // $request = new Request('POST', 'https://app.ruangwa.id/api/send_image');
                // $res = $client->sendAsync($request, $options)->wait();
                // echo $res->getBody();

                $options = [
                    'form_params' => [
                    'token' => 'LcoQVK5S35r43GNN6JH6bYyhKepVct9mQLHfy5B6hsK9E2Boaj',
                    'number' => $row['phone'],
                    'message' => "🕌 *DKM WINTEQ Present* 🕌 *Kajian Islami Ramadan*". 
                            "\r\n \r\nAssalamu’alaikum warahmatullahi wabarakatuh".
                            "\r\nSemangat Pagi ".$row['nama'].
                            "\r\nDi Bulan Ramadan yang penuh berkah ini DKM Winteq akan menyelenggarakan kultum Ramadan yg akan dilaksanakan pada:".
                            "\r\n \r\n📅Hari: *Selasa, 25 Maret 2025*".
                            "\r\n 🕔Jam : *Ba'da Dzuhur* ".
                            "\r\n 🏡Lokasi : *Masjid Winteq*".
                            "\r\n 🔊Narasumber : *Ust. Nanang*".
                            "\r\n \r\nMari maksimalkan Ramadan kali ini dengan menambah wawasan bersama. Ditunggu kehadirannya warga Winteq.".
                            "\r\nDKM Masjid Winteq ".
                            "\r\n \r\nFollow R A I S A x WINTEQ channel on WhatsApp: https://whatsapp.com/channel/0029Vah2IkLDzgT9vSSZfR40 ",
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s', $nowtime)
                ]];
                $request = new Request('POST', 'https://app.ruangwa.id/api/send_message');
                $res = $client->sendAsync($request, $options)->wait();
                echo $res->getBody();

                        
            $nowtime = strtotime('+5 second', $nowtime);

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

    public function send_mail()
    {
        $this->load->library('email'); // Memuat pustaka email
        $this->load->config('email'); // Memuat konfigurasi email

        // Konfigurasi email
        $this->email->from('raisa.winteq@gmail.com', 'Your Name'); // Ganti dengan email dan nama Anda
        $this->email->to('indra.dio@winteq.component.astra.co.id'); // Email tujuan
        $this->email->subject('Test Email from CodeIgniter');
        $this->email->message('This is a test email sent from CodeIgniter.');

        // Mengirim email
        if ($this->email->send()) {
            echo 'Email sent successfully!';
        } else {
            echo 'Failed to send email.';
            echo $this->email->print_debugger(); // Untuk debug
        }
        
    }
}
