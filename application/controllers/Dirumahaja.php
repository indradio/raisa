<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Dirumahaja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = '#DiRumahAja';
        $data['sidesubmenu'] = 'Form Peduli Kesehatan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $kesehatan = $this->db->get_where('kesehatan', ['npk' => $this->session->userdata('npk')])->row_array();
        if (empty($kesehatan)) {
            $this->session->set_flashdata('message', 'dirumahaja');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dirumahaja/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data['kesehatan'] = $this->db->get_where('kesehatan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dirumahaja/hasil', $data);
            $this->load->view('templates/footer');
        }
    }

    public function submit()
    {
        date_default_timezone_set('asia/jakarta');
        if ($this->input->post('a1') == 'YA') {
            $a1 = 1;
        } else {
            $a1 = 0;
        }
        if ($this->input->post('a2') == 'YA') {
            $a2 = 1;
        } else {
            $a2 = 0;
        }
        if ($this->input->post('a3') == 'YA') {
            $a3 = 1;
        } else {
            $a3 = 0;
        }
        if ($this->input->post('b1') == 'YA') {
            $b1 = 4;
        } else {
            $b1 = 0;
        }
        if ($this->input->post('b2') == 'YA') {
            $b2 = 2;
        } else {
            $b2 = 0;
        }
        if ($this->input->post('b3') == 'YA') {
            $b3 = 4;
        } else {
            $b3 = 0;
        }
        if ($this->input->post('b4') == 'YA') {
            $b4 = 7;
        } else {
            $b4 = 0;
        }
        if ($this->input->post('b5') == 'YA') {
            $b5 = 3;
        } else {
            $b5 = 0;
        }
        if ($this->input->post('b6') == 'YA') {
            $b6 = 1;
        } else {
            $b6 = 0;
        }
        if ($this->input->post('b7') == 'YA') {
            $b7 = 1;
        } else {
            $b7 = 0;
        }
        $total = $a1 + $a2 + $a3 + $b1 + $b2 + $b4 + $b4 + $b5 + $b6 + $b7;

        // if ($this->input->post('a1') == 'YA' or $this->input->post('a2') == 'YA' or $this->input->post('a3') == 'YA' or $this->input->post('b1') == 'YA' or $this->input->post('b2') == 'YA' or $this->input->post('b3') == 'YA' or $this->input->post('b4') == 'YA' or $this->input->post('b5') == 'YA' or $this->input->post('b6') == 'YA' or $this->input->post('b7') == 'YA') {
        if ($total == 0) {
            $status = 'AMAN';
        } elseif ($total >= 1 and $total <= 3) {
            $status = 'SIAGA';
        } elseif ($total >= 4 and $total <= 6) {
            $status = 'AWAS';
        } elseif ($total >= 7) {
            $status = 'BAHAYA';
        }
        $data = [
            'id' => time(),
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'a1' => $this->input->post('a1'),
            'a2' => $this->input->post('a2'),
            'a3' => $this->input->post('a3'),
            'b1' => $this->input->post('b1'),
            'b2' => $this->input->post('b2'),
            'b3' => $this->input->post('b3'),
            'b4' => $this->input->post('b4'),
            'b5' => $this->input->post('b5'),
            'b6' => $this->input->post('b6'),
            'b7' => $this->input->post('b7'),
            'catatan' => $this->input->post('catatan'),
            'status' => $status,
            'sect_id' => $this->session->userdata('sect_id'),
            'dept_id' => $this->session->userdata('dept_id'),
            'create_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('kesehatan', $data);

        if ($this->session->userdata('posisi_id')==7){
            $this->db->where('npk', $this->session->userdata('atasan2'));
            $atasan = $this->db->get('karyawan')->row_array();
        }else{
            $this->db->where('npk', $this->session->userdata('atasan1'));
            $atasan = $this->db->get('karyawan')->row_array();
        }
        //Notifikasi ke DeptHead
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
                    'phone' => $atasan['phone'],
                    'message' => "*PENGISIAN FORM PEDULI KESEHATAN KARYAWAN*" .
                        "\r\n*STATUS : " . $status . "*" .
                        "\r\n \r\nNama : *" . $this->session->userdata('nama') . "*" .
                        "\r\n \r\nA1. Kondisi kesehatan selama libur lebaran (Demam/Pilek/Influenza) : *" . $this->input->post('a1') . "*" .
                        "\r\n \r\nA2. Kondisi kesehatan selama libur lebaran (Batuk/Suara serak/Demam) : *" . $this->input->post('a2') . "*" .
                        "\r\n \r\nA3. Kondisi kesehatan selama libur lebaran (Sesak nafas/Nafas pendek) : *" . $this->input->post('a3') . "*" .
                        "\r\n \r\nB1. Pernah berinteraksi dengan Pasien Positif, PDP, ODP ataupun Orang yang sedang menjalani Isolasi Mandiri COVID-19 : *" . $this->input->post('b1') . "*" .
                        "\r\n \r\nB2. Pernah berkunjung ke rumah keluarga Pasien Positif, PDP, ODP ataupun Orang yang sedang menjalani Isolasi Mandiri COVID-19 : *" . $this->input->post('b2') . "*" .
                        "\r\n \r\nB3. Penghuni satu rumah ada yang dinyatakan Pasien Positif, PDP, ODP ataupun Orang yang sedang menjalani Isolasi Mandiri COVID-19 : *" . $this->input->post('b3') . "*" .
                        "\r\n \r\nB4. Kamu masuk dalam status Pasien Positif, PDP, ODP ataupun Orang yang sedang menjalani Isolasi Mandiri COVID-19 : *" . $this->input->post('b4') . "*" .
                        "\r\n \r\nB5. Mengikuti pemerikasaan Rapid Test, PCR, ataupun Tes Kesehatan lainnya dengan hasil kemungkinan terinfeksi COVID-19 : *" . $this->input->post('b5') . "*" .
                        "\r\n \r\nB6. Pergi dan kembali dari luar kota / Kab : *" . $this->input->post('b6') . "*" .
                        "\r\n \r\nB7. Beraktivitas jauh (lebih dari 20KM) dari rumah kediaman : *" . $this->input->post('b7') . "*" .
                        "\r\n \r\nCatatan : " . $this->input->post('catatan') .
                        "\r\n \r\n_Dibuat pada tanggal " . date('d-m-Y H:i:s') . "_"
                ],
            ]
        );
        $body = $response->getBody();
        redirect('dirumahaja');
    }

    public function izin()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'Izin Operasional';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/suratizin', $data);
        $this->load->view('templates/footer');
    }

    public function uptodate()
    {
        $data['sidemenu'] = 'DiRumahAja';
        $data['sidesubmenu'] = 'Informasi Terbaru';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/informasi', $data);
        $this->load->view('templates/footer');
    }

    public function medcare()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'E-Claim Medcare';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/medcare', $data);
        $this->load->view('templates/footer');
    }

    public function protokol()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'Protokol';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/protokol', $data);
        $this->load->view('templates/footer');
    }

    public function tamu()
    {
        $data['sidemenu'] = 'COVID-19';
        $data['sidesubmenu'] = 'Daftar Tamu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('corona/tamu', $data);
        $this->load->view('templates/footer');
    }
}
