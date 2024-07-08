<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Cekdl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'DL Security';
        $data['sidesubmenu'] = 'Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/index', $data);
        $this->load->view('templates/footer');
    }

    public function berangkat()
    {
        date_default_timezone_set('asia/jakarta');

        $data['sidemenu'] = 'DL Security';
        $data['sidesubmenu'] = 'Keberangkatan / Keluar';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->where('status', '1');
        $data['perjalanan'] = $this->db->or_where('status', '11');
        $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        
        $data['reservasi'] = $this->db->where('tglberangkat', date('Y-m-d'));
        $data['reservasi'] = $this->db->where('jamberangkat <=', '07:30');
        $data['reservasi'] = $this->db->where('kepemilikan', 'Operasional');
        $data['reservasi'] = $this->db->where('status', '6');
        $data['reservasi'] = $this->db->get('reservasi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/berangkat', $data);
        $this->load->view('templates/footer');
    }

    public function cekberangkat($dl)
    {
        date_default_timezone_set('asia/jakarta');
        //auto batalkan perjalanan
        $queryPerjalanan = "SELECT *
        FROM `perjalanan`
        WHERE `tglberangkat` <= CURDATE() AND `status` = 1
        ";
        $perjalanan = $this->db->query($queryPerjalanan)->result_array();

        $cekperjalanan = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        if ($cekperjalanan['status'] == 0) {
            redirect('cekdl/berangkat');
        } else {
            $data['sidemenu'] = 'Security';
            $data['sidesubmenu'] = 'Keberangkatan / Keluar';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('cekdl/cekberangkat', $data);
            $this->load->view('templates/footer');
        }
    }

    public function corsv($id)
    {
        date_default_timezone_set('asia/jakarta');

        $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
        if ($reservasi['status'] == 6) {
            $data['sidemenu'] = 'DL Security';
            $data['sidesubmenu'] = 'Keberangkatan / Keluar';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['reservasi'] = $this->db->get_where('reservasi', ['id' => $id])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('cekdl/checkout-rsv', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('cekdl/berangkat');
        }
    }

    public function cekberangkat_proses()
    {
        date_default_timezone_set('asia/jakarta');

        $kmberangkat = $this->input->post('kmberangkat');
        $this->db->set('tglberangkat', date("Y-m-d"));
        $this->db->set('jamberangkat', date("H:i:s"));
        $this->db->set('cekberangkat', $this->session->userdata('inisial'));
        $this->db->set('kmberangkat', $kmberangkat);
        $this->db->set('supirberangkat', $this->input->post('supirberangkat'));
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', '2');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $this->session->set_flashdata('message', 'berangkat');
        redirect('cekdl/berangkat');
    }

    public function kembali()
    {
        $data['sidemenu'] = 'DL Security';
        $data['sidesubmenu'] = 'Kembali / Masuk';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '2'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/kembali', $data);
        $this->load->view('templates/footer');
    }

    public function cekkembali($dl)
    {
        $data['sidemenu'] = 'DL Security';
        $data['sidesubmenu'] = 'Kembali / Masuk';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/cekkembali', $data);
        $this->load->view('templates/footer');
    }

    public function cekkembali_proses()
    {
        date_default_timezone_set('asia/jakarta');

        // $kmkembali = substr($this->input->post('kmkembali'), -4);
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        $kmkembali = $this->input->post('kmkembali');
        $kmtotal = $kmkembali - $this->input->post('kmberangkat');

        // if ($perjalanan['jenis_perjalanan'] == 'DLPP' or $perjalanan['jenis_perjalanan'] == 'TAPP') {
        //     $stat = '3';
        // } else {
        //     $stat = '9';
        // }

        $stat = '3';

        // $this->db->set('total', $total);
        $this->db->set('tglkembali', date("Y-m-d"));
        $this->db->set('jamkembali', date("H:i:s"));
        $this->db->set('cekkembali', $this->session->userdata('inisial'));
        $this->db->set('kmkembali', $kmkembali);
        $this->db->set('supirkembali', $this->input->post('supirkembali'));
        $this->db->set('kmtotal', $kmtotal);
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', $stat);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $this->db->set('status', '9');
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        // if ($perjalanan['jenis_perjalanan'] == 'DLPP' or $perjalanan['jenis_perjalanan'] == 'TAPP' or $perjalanan['jenis_perjalanan'] == 'TA') {
            // $user = $this->db->get_where('karyawan', ['npk' => $perjalanan['npk']])->row_array();
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
            //             'phone' => $user['phone'],
            //             'message' => "*PERJALANAN DINAS TELAH KEMBALI*". 
            //             "\r\n \r\n No. Perjalanan : *" . $perjalanan['id'] . "*" .
            //             "\r\n Nama : *" . $perjalanan['nama'] . "*" .
            //             "\r\n Tujuan : *" . $perjalanan['tujuan'] . "*" .
            //             "\r\n Keperluan : *" . $perjalanan['keperluan'] . "*" .
            //             "\r\n Peserta : *" . $perjalanan['anggota'] . "*" .
            //             "\r\n Berangkat : *" . $perjalanan['tglberangkat'] . "* *" . $perjalanan['jamberangkat'] . "*" .
            //             "\r\n Kembali : *" . date("Y-m-d") . "* *" . date("H:i:s") . "*" .
            //             "\r\n Kendaraan : *" . $perjalanan['nopol'] . "* ( *" . $perjalanan['kepemilikan'] . "* )" .
            //             "\r\n \r\nPerjalanan ini telah kembali, JANGAN LUPA UNTUK SEGERA MELAKUKAN PENYELESAIAN.".
            //             "\r\n \r\nPenyelesaian sudah di verifikasi oleh GA pada pukul 07:00-09:00 (dibayarkan hari yang sama).".
            //             "\r\n \r\nPenyelesaian sudah di verifikasi oleh GA pada pukul lewat 09:01 (dibayarkan hari berikutnya).".
            //             "\r\n \r\nklik link berikut : https://raisa.winteq-astra.com/perjalanan/penyelesaian/".$perjalanan['id'].
            //             "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
            //         ],
            //     ]
            // );
            // $body = $response->getBody();
        // }

        redirect('cekdl/kembali');
    }

    public function tambahpeserta()
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        foreach ($this->input->post('anggota') as $a) :
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $a])->row_array();
            $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
            $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
            $this->db->where('jenis_perjalanan', $perjalanan['jenis_perjalanan']);
            $this->db->where('gol_id', $karyawan['gol_id']);
            $tunjangan = $this->db->get('perjalanan_tunjangan')->row_array();
            //Cek Peserta
            $this->db->where('perjalanan_id', $this->input->post('id'));
            $this->db->where('karyawan_inisial', $a);
            $exist_peserta = $this->db->get('perjalanan_anggota')->row_array();
            if (empty($exist_peserta)) {
                $peserta = [
                    'perjalanan_id' => $this->input->post('id'),
                    'reservasi_id' => $perjalanan['reservasi_id'],
                    'npk' => $karyawan['npk'],
                    'karyawan_inisial' => $karyawan['inisial'],
                    'karyawan_nama' => $karyawan['nama'],
                    'karyawan_dept' => $dept['nama'],
                    'karyawan_posisi' => $posisi['nama'],
                    'karyawan_gol' => $karyawan['gol_id'],
                    'uang_saku' => $tunjangan['uang_saku'],
                    'insentif_pagi' => $tunjangan['insentif_pagi'],
                    'um_pagi' => $tunjangan['um_pagi'],
                    'um_siang' => $tunjangan['um_siang'],
                    'um_malam' => $tunjangan['um_malam'],
                    'total' => '0',
                    'status_pembayaran' => 'BELUM DIBAYAR',
                    'status' => '1'
                ];
                $this->db->insert('perjalanan_anggota', $peserta);
            }
        endforeach;

        $anggota = $this->db->where('perjalanan_id', $perjalanan['id']);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        //Uang Saku
        if ($perjalanan['jenis_perjalanan'] == 'TAPP') {
            $this->db->select_sum('uang_saku');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $uang_saku = $query->row()->uang_saku;
        } else {
            $uang_saku = 0;
        }

        //Insentif pagi
        if ($perjalanan['jamberangkat'] <= $um['um1']) {
            $this->db->select_sum('insentif_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $insentif_pagi = $query->row()->insentif_pagi;
        } else {
            $insentif_pagi = 0;
        }

        //Makan Pagi
        if ($perjalanan['jenis_perjalanan'] == 'TAPP' and $perjalanan['jamberangkat'] <= $um['um2']) {
            $this->db->select_sum('um_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_pagi = $query->row()->um_pagi;
        } else {
            $um_pagi = 0;
        }

        //Makan Siang
        if ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] >= $um['um3']) {
            $this->db->select_sum('um_siang');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_siang = $query->row()->um_siang;
        } else {
            $um_siang = 0;
        }

        //Makan Malam
        if ($perjalanan['jamkembali'] >= $um['um4']) {
            $this->db->select_sum('um_malam');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_malam = $query->row()->um_malam;
        } else {
            $um_malam = 0;
        }
        $total = $uang_saku + $insentif_pagi + $um_pagi + $um_siang + $um_malam + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];
        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['id']);
        $this->db->update('perjalanan');

        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        redirect('cekdl/cekberangkat/' . $perjalanan['id']);
    }

    public function hapus_anggota($id, $inisial)
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();

        $this->db->where('perjalanan_id', $id);
        $this->db->where('karyawan_inisial', $inisial);
        $this->db->delete('perjalanan_anggota');

        $anggota = $this->db->where('perjalanan_id', $perjalanan['id']);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        //Uang Saku
        if ($perjalanan['jenis_perjalanan'] == 'TAPP') {
            $this->db->select_sum('uang_saku');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $uang_saku = $query->row()->uang_saku;
        } else {
            $uang_saku = 0;
        }

        //Insentif pagi
        if ($perjalanan['jamberangkat'] <= $um['um1']) {
            $this->db->select_sum('insentif_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $insentif_pagi = $query->row()->insentif_pagi;
        } else {
            $insentif_pagi = 0;
        }

        //Makan Pagi
        if ($perjalanan['jenis_perjalanan'] == 'TAPP' and $perjalanan['jamberangkat'] <= $um['um2']) {
            $this->db->select_sum('um_pagi');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_pagi = $query->row()->um_pagi;
        } else {
            $um_pagi = 0;
        }

        //Makan Siang
        if ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] >= $um['um3']) {
            $this->db->select_sum('um_siang');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_siang = $query->row()->um_siang;
        } else {
            $um_siang = 0;
        }

        //Makan Malam
        if ($perjalanan['jamkembali'] >= $um['um4']) {
            $this->db->select_sum('um_malam');
            $this->db->where('perjalanan_id', $perjalanan['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_malam = $query->row()->um_malam;
        } else {
            $um_malam = 0;
        }
        $total = $uang_saku + $insentif_pagi + $um_pagi + $um_siang + $um_malam + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];
        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['id']);
        $this->db->update('perjalanan');

        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('total', $total);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        redirect('cekdl/cekberangkat/' . $id);
    }

    public function revisi()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('catatan_security', $this->input->post('catatan') . ' - Direvisi oleh ' . $this->session->userdata('inisial') . ' pada ' . date('d-m-Y H:i'));
        $this->db->set('status', '8');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $dl = $this->db->get_where('perjalanan', ['id' =>  $this->input->post('id')])->row_array();
        $ga_admin = $this->db->get_where('karyawan_admin', ['sect_id' => '214'])->row_array();
        $postData = array(
            'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
            'number' => $ga_admin['phone'],
            'message' => "*REVISI PERJALANAN DINAS*\r\n \r\n No. Perjalanan : *" . $dl['id'] . "*" .
                "\r\n Nama Pemohon: *" . $dl['nama'] . "*" .
                "\r\n Tujuan : *" . $dl['tujuan'] . "*" .
                "\r\n Keperluan : *" . $dl['keperluan'] . "*" .
                "\r\n Peserta : *" . $dl['anggota'] . "*" .
                "\r\n Berangkat : *" . $dl['tglberangkat'] . "* *" . $dl['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $dl['tglkembali'] . "* *" . $dl['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $dl['nopol'] . "* ( *" . $dl['kepemilikan'] . "*" .
                "\r\n Catatan : *" . $dl['catatan_security'] . "*" .
                "\r\n Direvisi Oleh " . $this->session->userdata('inisial') . ' pada ' . date('d-m-Y H:i') .
                " ) \r\n \r\nPerjalanan ini membutuhkan revisi dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://ws.premiumfast.net/api/v1/message/send');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer 4495c8929e574477a9167352d529969cded0eb310cd936ecafa011dc48f2921b';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        redirect('cekdl/berangkat');
    }

    // public function edit()
    // {
    //     $this->db->set('tglberangkat', $this->input->post('tglberangkat'));
    //     $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
    //     $this->db->set('tglkembali', $this->input->post('tglkembali'));
    //     $this->db->set('jamkembali', $this->input->post('jamkembali'));
    //     $this->db->where('id', $this->input->post('id'));
    //     $this->db->update('perjalanan');

    //     $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um1']) {
    //         $this->db->set('um1', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um2']) {
    //         $this->db->set('um2', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um3'] and $this->input->post('jamkembali') >= $um['um3']) {
    //         $this->db->set('um3', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };
    //     if ($this->input->post('jenis') != 'TA' and $this->input->post('jamkembali') >= $um['um4']) {
    //         $this->db->set('um4', 'YA');
    //         $this->db->where('id', $this->input->post('id'));
    //         $this->db->update('perjalanan');
    //     };

    //     redirect('cekdl/index');
    // }

    public function addpesertarsv($id,$npk)
    {
        $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' => $npk])->row_array();
        $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
        $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
        $this->db->where('jenis_perjalanan', $reservasi['jenis_perjalanan']);
        $this->db->where('gol_id', $karyawan['gol_id']);
        $tunjangan = $this->db->get('perjalanan_tunjangan')->row_array();
        //Cek Peserta
        $this->db->where('reservasi_id', $id);
        $this->db->where('npk', $npk);
        $existing_peserta = $this->db->get('perjalanan_anggota')->row_array();
        if (empty($existing_peserta)) {
            $peserta = [
                'reservasi_id' => $id,
                'npk' => $npk,
                'karyawan_inisial' => $karyawan['inisial'],
                'karyawan_nama' => $karyawan['nama'],
                'karyawan_dept' => $dept['nama'],
                'karyawan_posisi' => $posisi['nama'],
                'karyawan_gol' => $karyawan['gol_id'],
                'uang_saku' => $tunjangan['uang_saku'],
                'insentif_pagi' => $tunjangan['insentif_pagi'],
                'um_pagi' => $tunjangan['um_pagi'],
                'um_siang' => $tunjangan['um_siang'],
                'um_malam' => $tunjangan['um_malam'],
                'total' => '0',
                'status_pembayaran' => 'BELUM DIBAYAR',
                'status' => '1'
            ];
            $this->db->insert('perjalanan_anggota', $peserta);
        }

        $anggota = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $id])->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $id);
        $this->db->update('reservasi');

        redirect('CEKDL/CORSV/' . $id);
    }

    public function removepesertarsv($id,$npk)
    {
        $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
        $this->db->where('reservasi_id', $id);
        $this->db->where('npk', $npk);
        $this->db->delete('perjalanan_anggota');

        $anggota = $this->db->get_where('perjalanan_anggota', ['reservasi_id' => $id])->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $id);
        $this->db->update('reservasi');

        redirect('CEKDL/CORSV/' . $id);
    }

    public function berangkatrsv()
    {
        date_default_timezone_set('asia/jakarta');

        $reservasi = $this->db->get_where('reservasi', ['id' => $this->input->post('id')])->row_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' => $reservasi['npk']])->row_array();
        $this->db->where('posisi_id', '3');
        $this->db->where('dept_id', $karyawan['dept_id']);
        $ka_dept = $this->db->get('karyawan')->row_array();
        $tahun = date("Y", strtotime($reservasi['tglberangkat']));
        $bulan = date("m", strtotime($reservasi['tglberangkat']));

        $queryDl = "SELECT COUNT(*)
                    FROM `perjalanan`
                    WHERE YEAR(tglberangkat) = '$tahun' AND MONTH(tglberangkat) = '$bulan'
                ";

        $dl = $this->db->query($queryDl)->row_array();
        $totalDl = $dl['COUNT(*)'] + 1;

        $perjalanan = $this->db->get_where('perjalanan', ['reservasi_id' => $this->input->post('id')])->row_array();
        if (empty($perjalanan['id'])) {
            $data = [
                'id' => 'DL' . date("ym", strtotime($reservasi['tglberangkat'])) . sprintf("%04s", $totalDl),
                'npk' => $reservasi['npk'],
                'reservasi_id' => $reservasi['id'],
                'jenis_perjalanan' => $reservasi['jenis_perjalanan'],
                'nama' => $reservasi['nama'],
                'copro' => $reservasi['copro'],
                'tujuan' => $reservasi['tujuan'],
                'keperluan' => $reservasi['keperluan'],
                'anggota' => $reservasi['anggota'],
                'pic_perjalanan' => $reservasi['pic_perjalanan'],
                'tglberangkat' => date("Y-m-d"),
                'jamberangkat' => date("H:i:s"),
                'kmberangkat' => $this->input->post('kmberangkat'),
                'supirberangkat'=> $this->input->post('supirberangkat'),
                'cekberangkat' => $this->session->userdata('inisial'),
                'tglkembali' => $reservasi['tglkembali'],
                'jamkembali' => $reservasi['jamkembali'],
                'kmkembali' => '0',
                'cekkembali' => null,
                'kepemilikan' => $reservasi['kepemilikan'],
                'kendaraan' => $reservasi['kendaraan'],
                'nopol' => $reservasi['nopol'],
                'admin_ga' => $this->session->userdata('inisial'),
                'tgl_ga' => date('Y-m-d H:i:s'),
                'catatan' => $reservasi['catatan'],
                'catatan_security' => $this->input->post('catatan'),
                'ka_dept' => $ka_dept['nama'],
                'kmtotal' => '0',
                // 'uang_saku' => $reservasi['uang_saku'],
                // 'insentif_pagi' => $reservasi['insentif_pagi'],
                // 'um_pagi' => $reservasi['um_pagi'],
                // 'um_siang' => $reservasi['um_siang'],
                // 'um_malam' => $reservasi['um_malam'],
                // 'taksi' => $reservasi['taksi'],
                // 'bbm' => 0,
                // 'tol' => $reservasi['tol'],
                // 'parkir' => $reservasi['parkir'],
                // 'total' => $reservasi['total'],
                // 'kasbon' => $this->input->post('kasbon'),
                'div_id' => $karyawan['div_id'],
                'dept_id' => $karyawan['dept_id'],
                'sect_id' => $karyawan['sect_id'],
                'status' => '2'
            ];

                $this->db->insert('perjalanan', $data);

                // update table anggota perjalanan
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $this->input->post('id'));
                $this->db->update('perjalanan_tujuan');

                // update table anggota perjalanan
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $this->input->post('id'));
                $this->db->update('perjalanan_anggota');

                $this->db->set('admin_ga', $this->session->userdata('inisial'));
                $this->db->set('tgl_ga', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                //Kirim Notifikasi
                // $ga_admin = $this->db->get_where('karyawan_admin', ['sect_id' => '214'])->row_array();

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
                //             'message' => "*Perjalanan Dinas telah diberangkatkan oleh security :" .
                //             "*\r\n \r\nNo. Perjalanan : *" . $data['id'] . "*" .
                //             "\r\nTujuan : *" . $reservasi['tujuan'] . "*" .
                //             "\r\nPeserta : *" . $reservasi['anggota'] . "*" .
                //             "\r\nKeperluan : *" . $reservasi['keperluan'] . "*" .
                //             "\r\nBerangkat : *" . date("d-m-Y H:i") . "*" .
                //             "\r\nKembali : " . $reservasi['tglkembali'] . " " . $reservasi['jamkembali'] . " _estimasi_" .
                //             "\r\nKendaraan : *" . $reservasi['nopol'] . "* ( *" . $reservasi['kepemilikan'] . "* ) " .
                //             "\r\n \r\nTELAH DIBERANGKATKAN OLEH SECURITY"
                //         ],
                //     ]
                // );
                // $body = $response->getBody();

            $this->session->set_flashdata('message', 'berangkat');
            redirect('cekdl/berangkat');
        }
    }
}
