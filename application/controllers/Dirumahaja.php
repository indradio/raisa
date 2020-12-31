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
            $a1 = "SEHAT";
        } else {
            $a1 = "SAKIT";
        }
        if ($this->input->post('a2') == 'YA') {
            $a2 = "Demam >37,5° C";
            $nilai_a2 = 1;
        } else {
            $a2 = null;
            $nilai_a2 = 0;
        }
        if ($this->input->post('a3') == 'YA') {
            $a3 = "Badan terasa lemas";
            $nilai_a3 = 1;
        } else {
            $a3 = null;
            $nilai_a3 = 0;
        }
        if ($this->input->post('a4') == 'YA') {
            $a4 = "Batuk";
            $nilai_a4 = 1;
        } else {
            $a4 = null;
            $nilai_a4 = 0;
        }
        if ($this->input->post('a5') == 'YA') {
            $a5 = "Sakit Kepala";
            $nilai_a5 = 1;
        } else {
            $a5 = null;
            $nilai_a5 = 0;
        }
        if ($this->input->post('a6') == 'YA') {
            $a6 = "Nyeri Tenggorokan";
            $nilai_a6 = 1;
        } else {
            $a6 = null;
            $nilai_a6 = 0;
        }
        if ($this->input->post('a7') == 'YA') {
            $a7 = "Diare";
            $nilai_a7 = 1;
        } else {
            $a7 = null;
            $nilai_a7 = 0;
        }
        if ($this->input->post('a8') == 'YA') {
            $a8 = "Sesak Nafas";
            $nilai_a8 = 1;
        } else {
            $a8 = null;
            $nilai_a8 = 0;
        }
        if ($this->input->post('a9') == 'YA') {
            $a9 = "Hilangnya indera perasa atau penciuman";
            $nilai_a9 = 1;
        } else {
            $a9 = null;
            $nilai_a9 = 0;
        }
        if ($this->input->post('b1') == 'YA') {
            $b1 = "Anggota keluarga satu rumah sedang sakit dengan gejala/Positif COVID-19";
            $nilai_b1 = 10;
        } else {
            $b1 = null;
            $nilai_b1 = 0;
        }
        if ($this->input->post('b2') == 'YA') {
            $b2 = "Tetangga ada yang dinyatakan Positif COVID-19";
            $nilai_b2 = 10;
        } else {
            $b2 = null;
            $nilai_b2 = 0;
        }
        $total = $nilai_a2 + $nilai_a3 + $nilai_a4 + $nilai_a5 + $nilai_a6 + $nilai_a7 + $nilai_a8 + $nilai_a9 + $nilai_b1 + $nilai_b2;
        $kondisi = array(
            $a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9,$b1,$b2
        );
        $kondisi = array_filter($kondisi);
        // $data = implode("::", $result);

        // if ($this->input->post('a1') == 'YA' or $this->input->post('a2') == 'YA' or $this->input->post('a3') == 'YA' or $this->input->post('b1') == 'YA' or $this->input->post('b2') == 'YA' or $this->input->post('b3') == 'YA' or $this->input->post('b4') == 'YA' or $this->input->post('b5') == 'YA' or $this->input->post('b6') == 'YA' or $this->input->post('b7') == 'YA') {
        if ($total == 0) {
            $status = 'AMAN';
        } elseif ($total >= 1 and $total <= 5) {
            $status = 'SIAGA';
        } elseif ($total >= 6 and $total <= 10) {
            $status = 'AWAS';
        } elseif ($total > 10) {
            $status = 'BAHAYA';
        }
        $data = [
            'id' => time(),
            'date' => date('Y-m-d'),
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'a1' => $this->input->post('a1'),
            'a2' => $this->input->post('a2'),
            'a3' => $this->input->post('a3'),
            'a4' => $this->input->post('a4'),
            'a5' => $this->input->post('a5'),
            'a6' => $this->input->post('a6'),
            'a7' => $this->input->post('a7'),
            'a8' => $this->input->post('a8'),
            'a9' => $this->input->post('a9'),
            'b1' => $this->input->post('b1'),
            'b2' => $this->input->post('b2'),
            'kondisi' => implode(', ', $kondisi),
            'catatan' => $this->input->post('catatan'),
            'status' => $status,
            'sect_id' => $this->session->userdata('sect_id'),
            'dept_id' => $this->session->userdata('dept_id'),
            'div_id' => $this->session->userdata('div_id'),
            'create_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('kesehatan', $data);

        if (!empty($this->input->post('goldarah'))){
            $this->db->set('gol_darah', $this->input->post('goldarah'));
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->update('karyawan');
        }

        if ($total>0){
            if ($this->session->userdata('posisi_id')==7){
                $this->db->where('npk', $this->session->userdata('atasan1'));
                $atasan1 = $this->db->get('karyawan')->row_array();

                //Notifikasi ke Section
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
                            'phone' => $atasan1['phone'],
                            'message' => "*PERINGATAN KARYAWAN BERISIKO COVID-19*" .
                                "\r\n*STATUS : " . $status . "*" .
                                "\r\n \r\nNama : *" . $this->session->userdata('nama') . "*" .
                                "\r\nKondisi : *" . implode(', ', $kondisi) . "*" .
                                "\r\nCatatan : " . $this->input->post('catatan') .
                                "\r\n \r\n_Dibuat pada tanggal " . date('d-m-Y H:i:s') . "_"
                        ],
                    ]
                );
                $body = $response->getBody();

                $this->db->where('npk', $this->session->userdata('atasan2'));
                $atasan2 = $this->db->get('karyawan')->row_array();

                //Notifikasi ke Depthead
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
                            'phone' => $atasan2['phone'],
                            'message' => "*PERINGATAN KARYAWAN BERISIKO COVID-19*" .
                                "\r\n*STATUS : " . $status . "*" .
                                "\r\n \r\nNama : *" . $this->session->userdata('nama') . "*" .
                                "\r\nKondisi : *" . implode(', ', $kondisi) . "*" .
                                "\r\nCatatan : " . $this->input->post('catatan') .
                                "\r\n \r\n_Dibuat pada tanggal " . date('d-m-Y H:i:s') . "_"
                        ],
                    ]
                );
                $body = $response->getBody();

                //Notifikasi ke Pak Eko
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
                            'phone' => '6281316604848',
                            'message' => "*PERINGATAN KARYAWAN BERISIKO COVID-19*" .
                                "\r\n*STATUS : " . $status . "*" .
                                "\r\n \r\nNama : *" . $this->session->userdata('nama') . "*" .
                                "\r\nKondisi : *" . implode(', ', $kondisi) . "*" .
                                "\r\nCatatan : " . $this->input->post('catatan') .
                                "\r\n \r\n_Dibuat pada tanggal " . date('d-m-Y H:i:s') . "_"
                        ],
                    ]
                );
                $body = $response->getBody();

            }elseif ($this->session->userdata('posisi_id')==5 or $this->session->userdata('posisi_id')==6 or $this->session->userdata('posisi_id')==9 or $this->session->userdata('posisi_id')==10){
                $this->db->where('npk', $this->session->userdata('atasan1'));
                $atasan1 = $this->db->get('karyawan')->row_array();

                //Notifikasi ke Section
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
                            'phone' => $atasan1['phone'],
                            'message' => "*PERINGATAN KARYAWAN BERISIKO COVID-19*" .
                                "\r\n*STATUS : " . $status . "*" .
                                "\r\n \r\nNama : *" . $this->session->userdata('nama') . "*" .
                                "\r\nKondisi : *" . implode(', ', $kondisi) . "*" .
                                "\r\nCatatan : " . $this->input->post('catatan') .
                                "\r\n \r\n_Dibuat pada tanggal " . date('d-m-Y H:i:s') . "_"
                        ],
                    ]
                );
                $body = $response->getBody();

                //Notifikasi ke Pak Eko
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
                            'phone' => '6281316604848',
                            'message' => "*PERINGATAN KARYAWAN BERISIKO COVID-19*" .
                                "\r\n*STATUS : " . $status . "*" .
                                "\r\n \r\nNama : *" . $this->session->userdata('nama') . "*" .
                                "\r\nKondisi : *" . implode(', ', $kondisi) . "*" .
                                "\r\nCatatan : " . $this->input->post('catatan') .
                                "\r\n \r\n_Dibuat pada tanggal " . date('d-m-Y H:i:s') . "_"
                        ],
                    ]
                );
                $body = $response->getBody();

            }else{
                //Notifikasi ke Pak Eko
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
                            'phone' => '6281316604848',
                            'message' => "*PERINGATAN KARYAWAN BERISIKO COVID-19*" .
                                "\r\n*STATUS : " . $status . "*" .
                                "\r\n \r\nNama : *" . $this->session->userdata('nama') . "*" .
                                "\r\nKondisi : *" . implode(', ', $kondisi) . "*" .
                                "\r\nCatatan : " . $this->input->post('catatan') .
                                "\r\n \r\n_Dibuat pada tanggal " . date('d-m-Y H:i:s') . "_"
                        ],
                    ]
                );
                $body = $response->getBody();
            }
            
        }
        redirect('dashboard');
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
