<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Famday extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        if ($karyawan['status'] == '1') {
            $data['sidemenu'] = 'Family Day';
            $data['sidesubmenu'] = 'Pendaftaran';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['famday'] = $this->db->get_where('famday', ['npk' =>  $this->session->userdata('npk')])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('famday/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('dashboard');
        }
    }

    public function vote()
    {
        $data['sidemenu'] = 'Family Day';
        $data['sidesubmenu'] = 'Hasil Vote';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['famday'] = $this->db->get_where('famday', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $data['kary'] = $this->db->get_where('karyawan', ['status' =>  '1'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('famday/vote', $data);
        $this->load->view('templates/footer');
    }

    public function vote1()
    {
        $data = [
            'npk' => $this->session->userdata('npk'),
            'ocean' => '1'
        ];
        $this->db->insert('famday_vote', $data);

        $this->session->set_flashdata('message', 'vote');
        redirect('dashboard');
    }

    public function vote2()
    {
        $data = [
            'npk' => $this->session->userdata('npk'),
            'safari' => '1'
        ];
        $this->db->insert('famday_vote', $data);

        $this->session->set_flashdata('message', 'vote');
        redirect('dashboard');
    }

    public function daftar()
    {
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->delete('famday');

        $total = $this->input->post('ikut') + $this->input->post('pasangan') + $this->input->post('anak1') + $this->input->post('anak2') + $this->input->post('anak3') + $this->input->post('tambahan');
        $data = [
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->input->post('nama'),
            'ikut' => $this->input->post('ikut'),
            'ukuran' => $this->input->post('baju'),
            'pasangan' => $this->input->post('pasangan'),
            'anak1' => $this->input->post('anak1'),
            'anak2' => $this->input->post('anak2'),
            'anak3' => $this->input->post('anak3'),
            'tambahan' => $this->input->post('tambahan'),
            'akomodasi' => $this->input->post('akomodasi'),
            'balita' => $this->input->post('balita'),
            'total' => $total
        ];
        $this->db->insert('famday', $data);

        $this->session->set_flashdata('message', 'famday');
        redirect('famday');
    }

    public function panitia()
    {
        if ($this->session->userdata('npk') == '1111' or $this->session->userdata('npk') == '0075' or $this->session->userdata('npk') == '0280' or $this->session->userdata('npk') == '0163') {
            $data['sidemenu'] = 'Family Day';
            $data['sidesubmenu'] = 'Panitia';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['famday'] = $this->db->get_where('famday')->result_array();
            $data['ukuran'] = $this->db->get_where('famday_baju')->result_array();
            $data['kary'] = $this->db->get_where('karyawan', ['status' =>  '1'])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('famday/panitia', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('famday');
        }
    }

    public function colek($npk)
    {

        $this->db->where('npk', $npk);
        $karyawan = $this->db->get('karyawan')->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $karyawan['phone'];
        $message = "*PENDAFTARAN FAMILY DAY 2019 Goes to Taman Safari Indonesia*" .
            "\r\n \r\nAcara yang ditunggu-tunggu datang lagi, yuk buruan daftarkan diri kamu dan keluarga supaya gak ketinggalan." .
            "\r\nCaranya gampang kok, kamu cukup login di RAISA dengan masukan NPK (4 digit) dan password (default : winteq) kemudian isi deh formulir digital yang sudah disiapkan oleh tim panitia." .
            "\r\nPendaftaran paling LAMBAT kamis 10 Oktober 2019, ayo cusss! daftarkan diri kamu dan keluarga SEKARANG." .
            "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        redirect('famday/panitia');
    }
}
