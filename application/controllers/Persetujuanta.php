<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Persetujuanta extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        
        $this->load->model("Karyawan_model");

        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('date', date('Y-m-d'));
        $complete = $this->db->get('kesehatan')->row_array();

        if (empty($complete)){
            redirect('dashboard/sehat');
        }
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
                $this->db->set('fin_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_fin', date('Y-m-d H:i:s'));
                $this->db->set('div_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_div', date('Y-m-d H:i:s'));
                $this->db->set('status', '5');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
    
                $this->db->where('sect_id', '215');
                $hr_admin = $this->db->get('karyawan_admin')->row_array();
                
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
                            'phone' => $hr_admin['phone'],
                            'message' =>"*PENGAJUAN PERJALANAN DINAS TA*" .
                            "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
                            "\r\nNama : *" . $rsv['nama'] . "*" .
                            "\r\nPeserta : *" . $rsv['anggota'] . "*" .
                            "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                            "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
                            "\r\nAkomodasi : *" . $rsv['akomodasi'] . "*" .
                            "\r\nPenginapan : *" . $rsv['penginapan'] . "*" .
                            "\r\nLama Menginap : *" . $rsv['lama_menginap'] . "*" .
                            "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
                            "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
                            "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                            "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
            }elseif ($rsv['jenis_perjalanan']=='TAPP'){
                $this->db->set('fin_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_fin', date('Y-m-d H:i:s'));
                $this->db->set('div_ttd', "Disetujui oleh " . $this->session->userdata['inisial']);
                $this->db->set('tgl_div', date('Y-m-d H:i:s'));
                $this->db->set('status', '6');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');
    
                $this->db->where('sect_id', '214');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();
                
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
                            'phone' => $ga_admin['phone'],
                            'message' =>"*PENGAJUAN PERJALANAN DINAS " . $rsv['jenis_perjalanan'] . "*" .
                            "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
                            "\r\nNama : *" . $rsv['nama'] . "*" .
                            "\r\nPeserta : *" . $rsv['anggota'] . "*" .
                            "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                            "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
                            "\r\nCopro : *" . $rsv['copro'] . "*" .
                            "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
                            "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
                            "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                            "\r\Estimasi Biaya : *" . $rsv['total'] . "*" .
                            "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
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
                        'phone' => $div_head['phone'],
                        'message' =>"*PENGAJUAN PERJALANAN DINAS " . $rsv['jenis_perjalanan'] . "*" .
                        "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
                        "\r\nNama : *" . $rsv['nama'] . "*" .
                        "\r\nPeserta : *" . $rsv['anggota'] . "*" .
                        "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                        "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
                        "\r\nCopro : *" . $rsv['copro'] . "*" .
                        "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
                        "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
                        "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                        "\r\Estimasi Biaya : *" . $rsv['total'] . "*" .
                        "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();
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
                    'phone' => $user['phone'],
                    'message' =>"*[DIBATALKAN] PENGAJUAN PERJALANAN DINAS " . $rsv['jenis_perjalanan'] . "*" .
                    "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
                    "\r\nNama : *" . $rsv['nama'] . "*" .
                    "\r\nPeserta : *" . $rsv['anggota'] . "*" .
                    "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                    "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
                    "\r\nCopro : *" . $rsv['copro'] . "*" .
                    "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
                    "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
                    "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                    "\r\Estimasi Biaya : *" . $rsv['total'] . "*" .
                    "\r\n \r\nPerjalanan kamu *DIBATALKAN* oleh " . $this->session->userdata('nama') . " pada " . date("d M Y H:i") .
                    "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                ],
            ]
        );
        $body = $response->getBody();

        $this->session->set_flashdata('message', 'bataldl');
        redirect('persetujuanta/index');
    }

    // public function konfirmasita()
    // {
    //     date_default_timezone_set('asia/jakarta');
    //     $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        
    //     if ($rsv['kepemilikan']=='Non Operasional' AND $rsv['kendaraan']=='Non Operasional')
    //     {
    //         $this->db->set('admin_hr', $this->session->userdata['inisial']);
    //         $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
    //         $this->db->set('status', '9');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('reservasi');

    //         $this->db->where('sect_id', '214');
    //         $ga_admin = $this->db->get('karyawan_admin')->row_array();
            
    //         $client = new \GuzzleHttp\Client();
    //         $response = $client->post(
    //             'https://region01.krmpesan.com/api/v2/message/send-text',
    //             [
    //                 'headers' => [
    //                     'Content-Type' => 'application/json',
    //                     'Accept' => 'application/json',
    //                     'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
    //                 ],
    //                 'json' => [
    //                     'phone' => $ga_admin['phone'],
    //                     'message' =>"*PENGAJUAN PERJALANAN DINAS TA*" .
    //                     "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
    //                     "\r\nNama : *" . $rsv['nama'] . "*" .
    //                     "\r\nPeserta : *" . $rsv['anggota'] . "*" .
    //                     "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
    //                     "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
    //                     "\r\nAkomodasi : *" . $rsv['akomodasi'] . "*" .
    //                     "\r\nPenginapan : *" . $rsv['penginapan'] . "*" .
    //                     "\r\nLama Menginap : *" . $rsv['lama_menginap'] . "*" .
    //                     "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
    //                     "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
    //                     "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
    //                     "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
    //                 ],
    //             ]
    //         );
    //         $body = $response->getBody();
    //     }else{
    //         $this->db->set('admin_hr', $this->session->userdata['inisial']);
    //         $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
    //         $this->db->set('status', '6');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('reservasi');

    //         $this->db->where('sect_id', '214');
    //         $ga_admin = $this->db->get('karyawan_admin')->row_array();
            
    //         $client = new \GuzzleHttp\Client();
    //         $response = $client->post(
    //             'https://region01.krmpesan.com/api/v2/message/send-text',
    //             [
    //                 'headers' => [
    //                     'Content-Type' => 'application/json',
    //                     'Accept' => 'application/json',
    //                     'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
    //                 ],
    //                 'json' => [
    //                     'phone' => $ga_admin['phone'],
    //                     'message' =>"*PENGAJUAN PERJALANAN DINAS TA*" .
    //                     "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
    //                     "\r\nNama : *" . $rsv['nama'] . "*" .
    //                     "\r\nPeserta : *" . $rsv['anggota'] . "*" .
    //                     "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
    //                     "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
    //                     "\r\nAkomodasi : *" . $rsv['akomodasi'] . "*" .
    //                     "\r\nPenginapan : *" . $rsv['penginapan'] . "*" .
    //                     "\r\nLama Menginap : *" . $rsv['lama_menginap'] . "*" .
    //                     "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
    //                     "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
    //                     "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
    //                     "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
    //                 ],
    //             ]
    //         );
    //         $body = $response->getBody();
    //     }

    //     $this->session->set_flashdata('message', 'setujudl');
    //     redirect('perjalanandl/adminhr');
    // }
}
