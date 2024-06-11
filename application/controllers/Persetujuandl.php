<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Persetujuandl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        if ($this->session->userdata('posisi_id') < 7) {
            $data['sidemenu'] = 'Perjalanan Dinas';
            $data['sidesubmenu'] = 'Persetujuan DL';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('persetujuandl/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('auth/denied');
        }
    }

    public function setujudl()
    {
        date_default_timezone_set('asia/jakarta');
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($rsv['atasan1'] == $this->session->userdata['inisial'] and $rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
            $this->db->set('jamkembali', $this->input->post('jamkembali'));
            $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
            $this->db->set('atasan2', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan1'] == $this->session->userdata['inisial']) {
            $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
            $this->db->set('jamkembali', $this->input->post('jamkembali'));
            $this->db->set('atasan1', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
            $this->db->set('jamkembali', $this->input->post('jamkembali'));
            $this->db->set('atasan2', "Disetujui oleh " . $this->session->userdata['inisial']);
            $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }

        $user = $this->db->get_where('karyawan', ['npk' => $rsv['npk']])->row_array();
        if (date('H:i', strtotime($rsv['jamberangkat'])) != date("H:i", strtotime($this->input->post('jamberangkat'))) OR date('H:i', strtotime($rsv['jamkembali'])) != date("H:i", strtotime($this->input->post('jamkembali')))) {
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
                        'message' =>"*PERUBAHAN JAM KEBERANGKATAN PERJALANAN DINAS*" .
                        "\r\n \r\nPerjalanan dinas kamu dengan No. Reservasi : *" . $rsv['id'] . "*" .
                        "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                        "\r\n \r\n*BERUBAH MENJADI*" .
                        "\r\nBerangkat : " . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - *' . date("H:i", strtotime($this->input->post('jamberangkat'))) . "*" .
                        "\r\nKembali : " . date("d M Y", strtotime($rsv['tglkembali'])) . ' - *' . date("H:i", strtotime($this->input->post('jamkembali'))) . "*" .
                        "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();
        }elseif (date('H:i', strtotime($rsv['jamberangkat'])) != date("H:i", strtotime($this->input->post('jamberangkat')))){
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
                            'message' =>"*PERUBAHAN JAM KEBERANGKATAN PERJALANAN DINAS*" .
                            "\r\n \r\nPerjalanan dinas kamu dengan No. Reservasi : *" . $rsv['id'] . "*" .
                            "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                            "\r\n \r\n*BERUBAH MENJADI*" .
                            "\r\nBerangkat : " . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - *' . date("H:i", strtotime($this->input->post('jamberangkat'))) . "*" .
                            "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
        }elseif (date('H:i', strtotime($rsv['jamkembali'])) != date("H:i", strtotime($this->input->post('jamkembali')))) {
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
                        'message' =>"*PERUBAHAN JAM KEMBALI PERJALANAN DINAS*" .
                        "\r\n \r\nPerjalanan dinas kamu dengan No. Reservasi : *" . $rsv['id'] . "*" .
                        "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                        "\r\n \r\n*BERUBAH MENJADI*" .
                        "\r\nKembali : " . date("d M Y", strtotime($rsv['tglkembali'])) . ' - *' . date("H:i", strtotime($rsv['jamkembali'])) . "*" .
                        "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();
        }

        //Ganti status : 1 = Reservasi baru, 2 = Reservasi disetujui seksi/koordinator, 3 = Reservasi disetujui Kadept/kadiv/coo
        if ($this->session->userdata['posisi_id'] == '1' or $this->session->userdata['posisi_id'] == '2' or $this->session->userdata['posisi_id'] == '3') {
            if ($rsv['jenis_perjalanan'] == 'DLPP' or $rsv['jenis_perjalanan'] == 'TAPP') {
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '6');
                $this->db->set('last_notify', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                $this->db->where('sect_id', '214');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();

                //Kirim pesan via Whatsapp
                $curl = curl_init();

                $message = [
                "messageType"   => "text",
                "to"            => $ga_admin['phone'],
                "body"          => "*#" . $rsv['id'] . " - PENGAJUAN PERJALANAN DINAS*" .
                "\r\n \r\nNama : *" . $rsv['nama'] . "*" .
                "\r\nPeserta : *" . $rsv['anggota'] . "*" .
                "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
                "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
                "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
                "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                "\r\nEstimasi Biaya : *" . $rsv['total'] . "*" .
                "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda.",
                "file"          => "",
                "delay"         => 10,
                "schedule"      => 1665408510000
                ];
                
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.starsender.online/api/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($message),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type:application/json',
                    'Authorization: 26e68837-3e49-4692-b389-e2e132de361c'
                ),
                ));
                
                $response = curl_exec($curl);
                curl_close($curl);

                // $client = new \GuzzleHttp\Client();
                // $response = $client->post(
                //     'https://region01.krmpesan.com/api/v2/message/send-text',
                //     [
                //         'headers' => [
                //             'Content-Type' => 'application/json',
                //             'Accept' => 'application/json',
                //             'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                //         ],
                //         'json' => [
                //             'phone' => $ga_admin['phone'],
                //             'message' =>"*PENGAJUAN PERJALANAN DINAS DLPP*" .
                //             "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
                //             "\r\nNama : *" . $rsv['nama'] . "*" .
                //             "\r\nPeserta : *" . $rsv['anggota'] . "*" .
                //             "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
                //             "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
                //             "\r\nCopro : *" . $rsv['copro'] . "*" .
                //             "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
                //             "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
                //             "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
                //             "\r\nEstimasi Biaya : *" . $rsv['total'] . "*" .
                //             "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                //         ],
                //     ]
                // );
                // $body = $response->getBody();

            // } elseif ($rsv['jenis_perjalanan'] == 'TAPP') {
            //     $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
            //     $this->db->set('status', '4');
            //     $this->db->where('id', $this->input->post('id'));
            //     $this->db->update('reservasi');

            //     // $this->db->where('posisi_id', '3');
            //     // $this->db->where('dept_id', '21');
            //     $this->db->where('posisi_id', '2');
            //     $this->db->where('div_id', '1');
            //     $div_head = $this->db->get('karyawan')->row_array();

            //     $client = new \GuzzleHttp\Client();
            //     $response = $client->post(
            //         'https://region01.krmpesan.com/api/v2/message/send-text',
            //         [
            //             'headers' => [
            //                 'Content-Type' => 'application/json',
            //                 'Accept' => 'application/json',
            //                 'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
            //             ],
            //             'json' => [
            //                 'phone' => $div_head['phone'],
            //                 'message' =>"*PENGAJUAN PERJALANAN DINAS TAPP*" .
            //                 "\r\n \r\nNo. Reservasi : *" . $rsv['id'] . "*" .
            //                 "\r\nNama : *" . $rsv['nama'] . "*" .
            //                 "\r\nPeserta : *" . $rsv['anggota'] . "*" .
            //                 "\r\nTujuan : *" . $rsv['tujuan'] . "*" .
            //                 "\r\nKeperluan : *" . $rsv['keperluan'] . "*" .
            //                 "\r\nCopro : *" . $rsv['copro'] . "*" .
            //                 "\r\nBerangkat : *" . date("d M Y", strtotime($rsv['tglberangkat'])) . ' - ' . date("H:i", strtotime($rsv['jamberangkat'])) . "* _estimasi_" .
            //                 "\r\nKembali : *" . date("d M Y", strtotime($rsv['tglkembali'])) . ' - ' . date("H:i", strtotime($rsv['jamkembali'])) . "* _estimasi_" .
            //                 "\r\nKendaraan : *" . $rsv['nopol'] . "* ( *" . $rsv['kepemilikan'] . "* )" .
            //                 "\r\nEstimasi Biaya : *" . $rsv['total'] . "*" .
            //                 "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
            //             ],
            //         ]
            //     );
            //     $body = $response->getBody();
            } elseif ($rsv['jenis_perjalanan'] == 'TA') {
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                // $this->db->where('posisi_id', '3');
                // $this->db->where('dept_id', '21');
                $this->db->where('posisi_id', '2');
                $this->db->where('div_id', '1');
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
            }
        } elseif ($this->session->userdata['posisi_id'] == '4' or $this->session->userdata['posisi_id'] == '5' or $this->session->userdata['posisi_id'] == '6') {
            $this->db->set('status', '2');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
            $this->db->where('inisial', $rsv['atasan2']);
            $atasan2 = $this->db->get('karyawan')->row_array();

            if ($rsv['jenis_perjalanan'] == 'DLPP' or $rsv['jenis_perjalanan'] == 'TAPP') {
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
                            "\r\nEstimasi Biaya : *" . $rsv['total'] . "*" .
                            "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
            }else{
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
            }
        }

        $this->session->set_flashdata('message', 'setujudl');
        redirect('persetujuandl/index');
    }
    public function bataldl()
    {
        $rsv = $this->db->get_where('reservasi', ['id' =>  $this->input->post('id')])->row_array();
        if ($rsv['atasan1'] == $this->session->userdata['inisial'] and $rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->set('atasan2', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan1'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan1', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } elseif ($rsv['atasan2'] == $this->session->userdata['inisial']) {
            $this->db->set('atasan2', "Dibatalkan oleh " . $this->session->userdata['inisial']);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }

        $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan'));
        $this->db->set('status', '0');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('persetujuandl/index');
    }
}
