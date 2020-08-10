<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Perjalanandl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'PerjalananKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/index', $data);
        $this->load->view('templates/footer');
    }
    public function admindl()
    {
        date_default_timezone_set('asia/jakarta');
        //auto batalkan reservasi
        $queryReservasi = "SELECT *
        FROM `reservasi`
        WHERE `tglberangkat` <= CURDATE() AND (`status` = '1' OR `status` = '2' OR `status` = '3' OR `status` = '4' OR `status` = '5' OR `status` = '6')
        ";
        $reservasi = $this->db->query($queryReservasi)->result_array();
        foreach ($reservasi as $r) :
            // cari selisih
            $mulai = strtotime($r['jamberangkat']);
            $selesai = time();
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));

            if ($jam >= 2) {
                $perjalanan = $this->db->get_where('perjalanan', ['reservasi_id' => $r['id']])->row_array();
                $status = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array();
                if ($perjalanan['id'] == null) {

                    $this->db->set('status', '0');
                    $this->db->set('catatan', "Waktu reservasi perjalanan kamu telah selesai. - Dibatalkan oleh RAISA pada " . date('d-m-Y H:i'));
                    $this->db->where('id', $r['id']);
                    $this->db->update('reservasi');

                    $this->db->where('npk', $r['npk']);
                    $karyawan = $this->db->get('karyawan')->row_array();
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
                                'phone' => $karyawan['phone'],
                                'message' => "*RESERVASI PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. Reservasi : *" . $r['id'] . "*" .
                                "\r\nNama : *" . $r['nama'] . "*" .
                                "\r\nTujuan : *" . $r['tujuan'] . "*" .
                                "\r\nKeperluan : *" . $r['keperluan'] . "*" .
                                "\r\nPeserta : *" . $r['anggota'] . "*" .
                                "\r\nBerangkat : *" . $r['tglberangkat'] . "* *" . $r['jamberangkat'] . "* _estimasi_" .
                                "\r\nKembali : *" . $r['tglkembali'] . "* *" . $r['jamkembali'] . "* _estimasi_" .
                                "\r\nKendaraan : *" . $r['nopol'] . "* ( *" . $r['kepemilikan'] . "* )" .
                                "\r\nStatus Terakhir : *" . $status['nama'] . "*" .
                                "\r\n \r\nWaktu reservasi kamu telah selesai. Dibatalkan oleh RAISA pada " . date('d-m-Y H:i') .
                                "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                            ],
                        ]
                    );
                    $body = $response->getBody();
                }
            }
        endforeach;

        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '6'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/admindl', $data);
        $this->load->view('templates/footer');
    }

    public function prosesdl1($rsv_id)
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['id' =>  $rsv_id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/prosesdl', $data);
        $this->load->view('templates/footer');
    }

    public function prosesdl2()
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
            if ($reservasi['jenis_perjalanan'] == 'DLPP' or $reservasi['jenis_perjalanan'] == 'TAPP') {
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
                    'tglberangkat' => $reservasi['tglberangkat'],
                    'jamberangkat' => $reservasi['jamberangkat'],
                    'kmberangkat' => '0',
                    'cekberangkat' => null,
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
                    'ka_dept' => $ka_dept['nama'],
                    'kmtotal' => '0',
                    'uang_saku' => $reservasi['uang_saku'],
                    'insentif_pagi' => $reservasi['insentif_pagi'],
                    'um_pagi' => $reservasi['um_pagi'],
                    'um_siang' => $reservasi['um_siang'],
                    'um_malam' => $reservasi['um_malam'],
                    'taksi' => $reservasi['taksi'],
                    'bbm' => 0,
                    'tol' => $reservasi['tol'],
                    'parkir' => $reservasi['parkir'],
                    'total' => $reservasi['total'],
                    'kasbon' => $this->input->post('kasbon'),
                    'div_id' => $karyawan['div_id'],
                    'dept_id' => $karyawan['dept_id'],
                    'sect_id' => $karyawan['sect_id'],
                    'status' => '1'
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
                            'phone' => $karyawan['phone'],
                            'message' => "*Perjalanan Dinas kamu dengan detail berikut :" .
                            "*\r\n \r\nNo. Perjalanan : *" . $data['id'] . "*" .
                            "\r\nTujuan : *" . $reservasi['tujuan'] . "*" .
                            "\r\nPeserta : *" . $reservasi['anggota'] . "*" .
                            "\r\nKeperluan : *" . $reservasi['keperluan'] . "*" .
                            "\r\nBerangkat : *" . $reservasi['tglberangkat'] . "* *" . $reservasi['jamberangkat'] . "* _estimasi_" .
                            "\r\nKembali : *" . $reservasi['tglkembali'] . "* *" . $reservasi['jamkembali'] . "* _estimasi_" .
                            "\r\nKendaraan : *" . $reservasi['nopol'] . "* ( *" . $reservasi['kepemilikan'] . "* ) " .
                            "\r\n \r\nTELAH SIAP UNTUK DIBERANGKATKAN" .
                            "\r\nSebelum berangkat pastikan semua kelengkapan yang diperlukan tidak tertinggal." .
                            "\r\nHati-hati dalam berkendara, gunakan sabuk keselamatan dan patuhi rambu-rambu lalu lintas."
                        ],
                    ]
                );
                $body = $response->getBody();

                if ($this->input->post('kasbon')>0){

                    $this->db->set('kasbon_status', 'REQUEST');
                    $this->db->where('id', $data['id']);
                    $this->db->update('perjalanan');

                    $this->db->where('sect_id', '211');
                    $fa_admin = $this->db->get('karyawan_admin')->row_array();
                
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
                                'phone' => $fa_admin['phone'],
                                'message' => "*PENGAJUAN KASBON PERJALANAN DINAS*" . 
                                "\r\n \r\nNo. Perjalanan : *" . $data['id'] . "*" .
                                "\r\nNama : *" . $reservasi['nama'] . "*" .
                                "\r\nPeserta : *" . $reservasi['anggota'] . "*" .
                                "\r\nTujuan : *" . $reservasi['tujuan'] . "*" .
                                "\r\nBerangkat : *" . $reservasi['tglberangkat'] . "* *" . $reservasi['jamberangkat'] . "*" .
                                "\r\nKembali : *" . $reservasi['tglkembali'] . "* *" . $reservasi['jamkembali'] . "*" .
                                "\r\nEstimasi Total : *" . $reservasi['total'] . "*" .
                                "\r\n \r\n*Kasbon : " . $this->input->post('kasbon') . "*" .
                                "\r\n \r\nPERJALANAN INI MENGAJUKAN KASBON.".
                                "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                            ],
                        ]
                    );
                    $body = $response->getBody();
                }

                $this->session->set_flashdata('message', 'barudl');
                redirect('perjalanandl/admindl');
            } else {
                $data = [
                    'id' => 'DL' . date("ym", strtotime($reservasi['tglberangkat'])) . sprintf("%04s", $totalDl),
                    'npk' => $reservasi['npk'],
                    'nama' => $reservasi['nama'],
                    'anggota' => $reservasi['anggota'],
                    'tujuan' => $reservasi['tujuan'],
                    'keperluan' => $reservasi['keperluan'],
                    'copro' => $reservasi['copro'],
                    'tglberangkat' => $reservasi['tglberangkat'],
                    'jamberangkat' => $reservasi['jamberangkat'],
                    'kmberangkat' => '0',
                    'cekberangkat' => null,
                    'tglkembali' => $reservasi['tglkembali'],
                    'jamkembali' => $reservasi['jamkembali'],
                    'kmkembali' => '0',
                    'cekkembali' => null,
                    'nopol' => $reservasi['nopol'],
                    'kepemilikan' => $reservasi['kepemilikan'],
                    'kendaraan' => $reservasi['kendaraan'],
                    'akomodasi' => $reservasi['akomodasi'],
                    'penginapan' => $reservasi['penginapan'],
                    'lama_menginap' => $reservasi['lama_menginap'],
                    'admin_ga' => $this->session->userdata('inisial'),
                    'tgl_ga' => date('Y-m-d H:i:s'),
                    'catatan' => $this->input->post('catatan'),
                    'admin_hr' => $reservasi['admin_hr'],
                    'tgl_hr' => $reservasi['tgl_hr'],
                    'ka_dept' => $ka_dept['nama'],
                    'kmtotal' => '0',
                    'jenis_perjalanan' => $reservasi['jenis_perjalanan'],
                    'reservasi_id' => $reservasi['id'],
                    'div_id' => $karyawan['div_id'],
                    'dept_id' => $karyawan['dept_id'],
                    'sect_id' => $karyawan['sect_id'],
                    'status' => '1'
                ];
                $this->db->insert('perjalanan', $data);

                // update table anggota perjalanan
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $reservasi['id']);
                $this->db->update('perjalanan_tujuan');

                // update table anggota perjalanan
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $reservasi['id']);
                $this->db->update('perjalanan_anggota');

                // update table anggota jadwal
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $reservasi['id']);
                $this->db->update('perjalanan_jadwal');

                $this->db->set('admin_ga', $this->session->userdata('inisial'));
                $this->db->set('tgl_ga', date('Y-m-d H:i:s'));
                $this->db->set('status', '7');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                $this->db->where($reservasi['npk']);
                $karyawan = $this->db->get('karyawan')->row_array();
                $my_apikey = "NQXJ3HED5LW2XV440HCG";
                $destination = $karyawan['phone'];
                $message = "*Perjalanan Dinas kamu dengan detail berikut :*\r\n \r\n No. Perjalanan : *" . $data['id'] . "*" .
                    "\r\n Tujuan : *" . $data['tujuan'] . "*" .
                    "\r\n Peserta : *" . $data['anggota'] . "*" .
                    "\r\n Keperluan : *" . $data['keperluan'] . "*" .
                    "\r\n Berangkat : *" . $data['tglberangkat'] . "* *" . $data['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $data['tglkembali'] . "* *" . $data['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $data['nopol'] . "* ( *" . $data['kepemilikan'] . "*" .
                    " ) \r\n \r\nTelah siap untuk berangkat. 
                        \r\nSebelum berangkat pastikan semua kelengkapan yang diperlukan tidak tertinggal.
                        \r\nHati-hati dalam berkendara, gunakan sabuk keselamatan dan patuhi rambu-rambu lalu lintas.";
                $api_url = "http://panel.apiwha.com/send_message.php";
                $api_url .= "?apikey=" . urlencode($my_apikey);
                $api_url .= "&number=" . urlencode($destination);
                $api_url .= "&text=" . urlencode($message);
                json_decode(file_get_contents($api_url, false));

                $this->session->set_flashdata('message', 'barudl');
                redirect('perjalanandl/admindl');
            }
        }
    }

    public function gantikend($rsv_id)
    {
        if ($this->input->post('kepemilikan') == 'Operasional') {
            $queryCarinopol = "SELECT COUNT(*)
                FROM `kendaraan`
                WHERE `nopol` =  '{$this->input->post('nopol')}'
                ";
            $carinopol = $this->db->query($queryCarinopol)->row_array();
            $total = $carinopol['COUNT(*)'];
            if ($total == 0) {
                $this->session->set_flashdata('message', 'nopolsalah');
                redirect('perjalanandl/prosesdl1/' . $rsv_id);
            } else {
                $kend = $this->db->get_where('kendaraan', ['nopol' => $this->input->post('nopol')])->row_array();
                $this->db->set('nopol', $this->input->post('nopol'));
                $this->db->set('kendaraan', $kend['nama']);
                $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
                $this->db->where('id', $rsv_id);
                $this->db->update('reservasi');
                redirect('perjalanandl/prosesdl1/' . $rsv_id);
            }
        } else {
            $this->db->set('nopol', $this->input->post('nopol'));
            $this->db->set('kendaraan', 'Non Operasional');
            $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
            $this->db->where('id', $rsv_id);
            $this->db->update('reservasi');
            redirect('perjalanandl/prosesdl1/' . $rsv_id);
        }
    }

    public function batalrsv()
    {
        $this->db->set('status', '0');
        $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial') . " pada " . date('d-m-Y H:i'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('perjalanandl/admindl');
    }

    public function perjalanan($parameter="")
    {
        date_default_timezone_set('asia/jakarta');
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
        if (empty($perjalanan)) {
            $data['sidemenu'] = 'GA';
            $data['sidesubmenu'] = 'Laporan Perjalanan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['perjalanan'] = $this->db->limit('100');
            $data['perjalanan'] = $this->db->order_by('id', 'desc');
            $data['perjalanan'] = $this->db->get_where('perjalanan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/perjalanan', $data);
            $this->load->view('templates/footer');
        }else{
            $data['sidemenu'] = 'GA';
            $data['sidesubmenu'] = 'Laporan Perjalanan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/perjalanan_detail', $data);
            $this->load->view('templates/footer');
        }
    }

    public function perjalanan_ta()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Laporan Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->where('jenis_perjalanan', 'TA');
        $data['perjalanan'] = $this->db->limit('100');
        $data['perjalanan'] = $this->db->order_by('id', 'desc');
        $data['perjalanan'] = $this->db->get_where('perjalanan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/perjalanan', $data);
        $this->load->view('templates/footer');
    }

    public function cariperjalanan()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Laporan Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $tglawal = date("Y-m-d", strtotime($this->input->post('tglawal')));
        $tglakhir = date("Y-m-d", strtotime($this->input->post('tglakhir')));
        $queryPerjalanan = "SELECT *
                                    FROM `perjalanan`
                                    WHERE `tglberangkat` >= '$tglawal' AND `tglberangkat` <= '$tglakhir'
                                ";
        $data['perjalanan'] = $this->db->query($queryPerjalanan)->result_array();
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/perjalanan', $data);
        $this->load->view('templates/footer');
    }

    public function cariperjalanan_ta()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Laporan Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $tglawal = date("Y-m-d", strtotime($this->input->post('tglawal')));
        $tglakhir = date("Y-m-d", strtotime($this->input->post('tglakhir')));
        $queryPerjalanan = "SELECT *
                                    FROM `perjalanan`
                                    WHERE `tglberangkat` >= '{$tglawal}' AND `tglberangkat` <= '{$tglakhir}' AND `jenis_perjalanan` = 'TA'
                                ";
        $data['perjalanan'] = $this->db->query($queryPerjalanan)->result_array();
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/perjalanan', $data);
        $this->load->view('templates/footer');
    }

    public function perjalanan_peserta()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Laporan Perjalanan Peserta';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/perjalanan_peserta', $data);
        $this->load->view('templates/footer');
    }

    public function suratjalan($id)
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Laporan Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        if($perjalanan['status']>4){
            if ($perjalanan['jenis_perjalanan'] == 'DLPP') {
                $this->load->view('perjalanandl/sjdlpp', $data);
            } elseif ($perjalanan['jenis_perjalanan'] == 'TAPP') {
                $this->load->view('perjalanandl/sjtapp', $data);
            } elseif ($perjalanan['jenis_perjalanan'] == 'TA') {
                $this->load->view('perjalanandl/sjta', $data);
                // $this->load->view('perjalanandl/sjta', $data);
            }
        }else{
            redirect('perjalanandl/perjalanan');
        }
    }

    public function surattugas($id)
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $id])->row_array();

        $this->load->view('perjalanandl/stta', $data);
    }

    public function ikut()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Ikut Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' =>  '1'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/ikut', $data);
        $this->load->view('templates/footer');
    }

    public function ikut_proses($dl)
    {
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $dept = $this->db->get_where('karyawan_dept', ['id' => $dataku['dept_id']])->row_array();
        $posisi = $this->db->get_where('karyawan_posisi', ['id' => $dataku['posisi_id']])->row_array();
        $me = [
            'perjalanan_id' => $dl,
            'npk' => $dataku['npk'],
            'karyawan_inisial' => $dataku['inisial'],
            'karyawan_nama' => $dataku['nama'],
            'karyawan_dept' => $dept['nama'],
            'karyawan_posisi' => $posisi['nama'],
            'status' => '1'
        ];
        $this->db->insert('perjalanan_anggota', $me);

        $anggota = $this->db->where('perjalanan_id', $dl);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $dl);
        $this->db->update('perjalanan');

        $perjalanan = $this->db->get_where('perjalanan', ['id' => $dl])->row_array();
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        $this->db->where('sect_id', '214');
        $ga_admin = $this->db->get('karyawan_admin')->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $ga_admin['phone'];
        $message = "*INFO PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $dl . "*" .
            "\r\n \r\n" . $dataku['nama'] . " Ikut dalam Perjalanan ini. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        // if ($this->session->userdata('posisi_id') >= 4) {
        //     $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

        //     $my_apikey = "NQXJ3HED5LW2XV440HCG";
        //     $destination = $atasan1['phone'];
        //     $message = "*INFO PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $dl . "*" .
        //         "\r\n \r\n" . $dataku['nama'] . " Ikut dalam Perjalanan ini. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        //     $api_url = "http://panel.apiwha.com/send_message.php";
        //     $api_url .= "?apikey=" . urlencode($my_apikey);
        //     $api_url .= "&number=" . urlencode($destination);
        //     $api_url .= "&text=" . urlencode($message);
        //     json_decode(file_get_contents($api_url, false));
        // }
        // if ($this->session->userdata('posisi_id') >= 7) {
        //     $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

        //     $my_apikey = "NQXJ3HED5LW2XV440HCG";
        //     $destination = $atasan2['phone'];
        //     $message = "*INFO PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $dl . "*" .
        //         "\r\n \r\n" . $dataku['nama'] . " Ikut dalam Perjalanan ini. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        //     $api_url = "http://panel.apiwha.com/send_message.php";
        //     $api_url .= "?apikey=" . urlencode($my_apikey);
        //     $api_url .= "&number=" . urlencode($destination);
        //     $api_url .= "&text=" . urlencode($message);
        //     json_decode(file_get_contents($api_url, false));
        // }

        redirect('perjalanandl/index');
    }

    public function revisi()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Revisi Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '8'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/revisidl', $data);
        $this->load->view('templates/footer');
    }

    public function do_revisi($id)
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Revisi Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/do_revisi', $data);
        $this->load->view('templates/footer');
    }

    public function bataldl()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('status', '0');
        $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial') . " pada " . date('d-m-Y H:i'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        $this->db->set('status', '9');
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('perjalanandl/admindl');
    }

    public function gantikend2($id)
    {
        if ($this->input->post('kepemilikan') == 'Operasional') {
            $queryCarinopol = "SELECT COUNT(*)
                FROM `kendaraan`
                WHERE `nopol` =  '{$this->input->post('nopol')}'
                ";
            $carinopol = $this->db->query($queryCarinopol)->row_array();
            $total = $carinopol['COUNT(*)'];
            if ($total == 0) {
                $this->session->set_flashdata('message', 'nopolsalah');
                redirect('perjalanandl/do_revisi/' . $id);
            } else {

                $this->db->set('nopol', $this->input->post('nopol'));
                $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
                $this->db->where('id', $id);
                $this->db->update('perjalanan');

                $perjalanan = $this->db->get_where('perjalanan', ['id' =>  $id])->row_array();
                $this->db->set('nopol', $this->input->post('nopol'));
                $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
                $this->db->where('id',  $perjalanan['reservasi_id']);
                $this->db->update('reservasi');
                redirect('perjalanandl/do_revisi/' . $id);
            }
        } else {
            $this->db->set('nopol', $this->input->post('nopol'));
            $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
            $this->db->where('id', $id);
            $this->db->update('perjalanan');

            $perjalanan = $this->db->get_where('perjalanan', ['id' =>  $id])->row_array();
            $this->db->set('nopol', $this->input->post('nopol'));
            $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
            $this->db->where('id',  $perjalanan['reservasi_id']);
            $this->db->update('reservasi');
            redirect('perjalanandl/do_revisi/' . $id);
        }
    }

    public function revisi_proses()
    {
        $this->db->set('status', '1');
        $this->db->set('catatan',  $this->input->post('catatan'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $this->session->set_flashdata('message', 'setujudl');
        redirect('perjalanandl/revisi');
    }

    public function tambahwaktudl($id)
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $updatejam = date('H:i:s', strtotime('+1 hour', strtotime($perjalanan['jamberangkat'])));
        $this->db->set('jamberangkat', $updatejam);
        $this->db->where('id', $id);
        $this->db->update('perjalanan');

        $this->session->set_flashdata('message', 'tambahwaktudl');
        redirect('perjalanandl/index');
    }

    public function aktifkan($id)
    {
        date_default_timezone_set('asia/jakarta');
        $sekarang = date('H:i:s');
        $this->db->set('status', '1');
        $this->db->set('jamberangkat', $sekarang);
        $this->db->set('catatan', '');
        $this->db->where('id', $id);
        $this->db->update('perjalanan');

        $perjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $this->db->set('status', '6');
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        $this->db->where('npk', $perjalanan['npk']);
        $karyawan = $this->db->get('karyawan')->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $karyawan['phone'];
        $message = "*PERJALANAN DINAS DIAKTIFKAN KEMBALI*\r\n \r\n No. Perjalanan : *" . $perjalanan['id'] . "*" .
            "\r\n Nama : *" . $perjalanan['nama'] . "*" .
            "\r\n Tujuan : *" . $perjalanan['tujuan'] . "*" .
            "\r\n Keperluan : *" . $perjalanan['keperluan'] . "*" .
            "\r\n Peserta : *" . $perjalanan['anggota'] . "*" .
            "\r\n Berangkat : *" . $perjalanan['tglberangkat'] . "* *" . $perjalanan['jamberangkat'] . "* _estimasi_" .
            "\r\n Kembali : *" . $perjalanan['tglkembali'] . "* *" . $perjalanan['jamkembali'] . "* _estimasi_" .
            "\r\n Kendaraan : *" . $perjalanan['nopol'] . "* ( *" . $perjalanan['kepemilikan'] . "*" .
            " ) \r\n \r\nPerjalanan kamu telah *DIAKTIFKAN* kembali untuk *2 JAM* berikutnya. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        $this->session->set_flashdata('message', 'barudl');
        redirect('perjalanandl/perjalanan');
    }

    public function gabung($rsvid)
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Reservasi Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['rsvid'] = $rsvid;
        $queryReservasi = "SELECT *
        FROM `reservasi`
        WHERE `status` = '5'
        ";
        $data['reservasi'] = $this->db->query($queryReservasi)->result_array();
        $queryPerjalanan = "SELECT *
        FROM `perjalanan`
        WHERE `status` = '1'OR `status` = '8' OR `status` = '11'
        ";
        $data['perjalanan'] = $this->db->query($queryPerjalanan)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/gabung', $data);
        $this->load->view('templates/footer');
    }

    public function gabungrsv($rsvid1, $rsvid2)
    {
        $rsv1 =  $this->db->get_where('reservasi', ['id' => $rsvid1])->row_array();
        $rsv2 =  $this->db->get_where('reservasi', ['id' => $rsvid2])->row_array();

        // update table anggota perjalanan
        $this->db->set('reservasi_id', $rsvid2);
        $this->db->where('reservasi_id', $rsvid1);
        $this->db->update('perjalanan_tujuan');
        $tujuan = $this->db->where('reservasi_id', $rsvid2);
        $tujuan = $this->db->get_where('perjalanan_tujuan')->result_array();
        $tujuanbaru = array_column($tujuan, 'inisial');

        // update table anggota perjalanan
        $this->db->set('reservasi_id', $rsvid2);
        $this->db->where('reservasi_id', $rsvid1);
        $this->db->update('perjalanan_anggota');
        $anggota = $this->db->where('reservasi_id', $rsvid2);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        // Update reservasi
        $this->db->set('tujuan', implode(', ', $tujuanbaru));
        $this->db->set('keperluan', $rsv1['keperluan'] . ",\r\n" . $rsv2['keperluan']);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $rsvid2);
        $this->db->update('reservasi');

        // batalkan reservasi
        $this->db->set('status', '9');
        $this->db->set('catatan', 'Digabungkan dengan RESERVASI ' . $rsvid2);
        $this->db->set('admin_ga', $this->session->userdata('inisial'));
        $this->db->where('id', $rsvid1);
        $this->db->update('reservasi');

        $this->db->where('npk', $rsv2['npk']);
        $karyawan = $this->db->get('karyawan')->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $karyawan['phone'];
        $message = "*PERJALANAN DINAS DIGABUNGKAN*\r\n \r\n No. Reservasi : *" . $rsv2['id'] . "*" .
            "\r\n Nama : *" . $rsv2['nama'] . "*" .
            "\r\n Tujuan : *" . $rsv2['tujuan'] . "*" .
            "\r\n Keperluan : *" . $rsv2['keperluan'] . "*" .
            "\r\n Peserta : *" . $rsv2['anggota'] . "*" .
            "\r\n Berangkat : *" . $rsv2['tglberangkat'] . "* *" . $rsv2['jamberangkat'] . "* _estimasi_" .
            "\r\n Kembali : *" . $rsv2['tglkembali'] . "* *" . $rsv2['jamkembali'] . "* _estimasi_" .
            "\r\n Kendaraan : *" . $rsv2['nopol'] . "* ( *" . $rsv2['kepemilikan'] . "*" .
            " ) \r\n \r\nReservasi Perjalanan kamu telah digabungkan dengan *" . $rsv2['id'] . "*. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        $this->session->set_flashdata('message', 'barudl');
        redirect('perjalanandl/admindl');
    }

    public function gabungdl($rsvid, $dlid)
    {
        $rsv =  $this->db->get_where('reservasi', ['id' => $rsvid])->row_array();
        $dl =  $this->db->get_where('perjalanan', ['id' => $dlid])->row_array();

        // update table anggota perjalanan
        $this->db->set('perjalanan_id', $dlid);
        $this->db->where('reservasi_id', $rsvid);
        $this->db->update('perjalanan_tujuan');
        $tujuan = $this->db->where('perjalanan_id', $dlid);
        $tujuan = $this->db->get_where('perjalanan_tujuan')->result_array();
        $tujuanbaru = array_column($tujuan, 'inisial');

        // update table anggota perjalanan
        $this->db->set('perjalanan_id', $dlid);
        $this->db->where('reservasi_id', $rsvid);
        $this->db->update('perjalanan_anggota');
        $anggota = $this->db->where('perjalanan_id', $dlid);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        // Update reservasi
        $this->db->set('tujuan', implode(', ', $tujuanbaru));
        $this->db->set('keperluan', $dl['keperluan'] . ",\r\n" . $rsv['keperluan']);
        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $dlid);
        $this->db->update('perjalanan');

        // batalkan reservasi
        $this->db->set('status', '9');
        $this->db->set('catatan', 'Digabungkan dengan PERJALANAN ' . $dlid);
        $this->db->set('admin_ga', $this->session->userdata('inisial'));
        $this->db->where('id', $rsvid);
        $this->db->update('reservasi');

        $this->db->where('npk', $dl['npk']);
        $karyawan = $this->db->get('karyawan')->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $karyawan['phone'];
        $message = "*PERJALANAN DINAS DIGABUNGKAN*\r\n \r\n No. Perjalanan : *" . $dl['id'] . "*" .
            "\r\n Nama : *" . $dl['nama'] . "*" .
            "\r\n Tujuan : *" . $dl['tujuan'] . "*" .
            "\r\n Keperluan : *" . $dl['keperluan'] . "*" .
            "\r\n Peserta : *" . $dl['anggota'] . "*" .
            "\r\n Berangkat : *" . $dl['tglberangkat'] . "* *" . $dl['jamberangkat'] . "* _estimasi_" .
            "\r\n Kembali : *" . $dl['tglkembali'] . "* *" . $dl['jamkembali'] . "* _estimasi_" .
            "\r\n Kendaraan : *" . $dl['nopol'] . "* ( *" . $dl['kepemilikan'] . "*" .
            " ) \r\n \r\nReservasi Perjalanan kamu telah digabungkan dengan *" . $dl['id'] . "*. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        $this->session->set_flashdata('message', 'barudl');
        redirect('perjalanandl/admindl');
    }

    public function laporan()
    {
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['tahun'] = $this->input->post('tahun');
        $data['bulan'] = $this->input->post('bulan');
        if ($this->input->post('laporan') == 1) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/lp_perjalanan_1', $data);
            $this->load->view('templates/footer');
        } elseif ($this->input->post('laporan') == 2) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/lp_perjalanan_2', $data);
            $this->load->view('templates/footer');
        } elseif ($this->input->post('laporan') == 3) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/lp_perjalanan_3', $data);
            $this->load->view('templates/footer');
        } elseif ($this->input->post('laporan') == 4) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/lp_perjalanan_4', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/lp_perjalanan', $data);
            $this->load->view('templates/footer');
        }
    }

    public function gps()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '5'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/gps', $data);
        $this->load->view('templates/footer');

        // $api_url = "http://gps.intellitrac.co.id/apis/tracking/devices.php";
        // // Parameter “data” value after urldecoded :
        // $api_url .= "?username=" . urlencode('winteq');
        // $api_url .= "&password=" . urlencode('winteq123');
        // $api_url .= "&filter=" . urlencode('device_id');
        // json_decode(file_get_contents($api_url, false));

    }

    public function adminhr()
    {
        date_default_timezone_set('asia/jakarta');
        //auto batalkan reservasi
        $queryReservasi = "SELECT *
        FROM `reservasi`
        WHERE `tglberangkat` <= CURDATE() AND (`status` = '1' OR `status` = '2' OR `status` = '3' OR `status` = '4' OR `status` = '5')
        ";
        $reservasi = $this->db->query($queryReservasi)->result_array();
        foreach ($reservasi as $r) :
            // cari selisih
            $mulai = strtotime($r['jamberangkat']);
            $selesai = time();
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));

            if ($jam >= 2) {
                $perjalanan = $this->db->get_where('perjalanan', ['reservasi_id' => $r['id']])->row_array();
                $status = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array();
                if ($perjalanan['id'] == null) {

                    $this->db->set('status', '0');
                    $this->db->set('catatan', "Waktu reservasi perjalanan kamu telah selesai. - Dibatalkan oleh RAISA pada " . date('d-m-Y H:i'));
                    $this->db->where('id', $r['id']);
                    $this->db->update('reservasi');

                    $this->db->where('npk', $r['npk']);
                    $karyawan = $this->db->get('karyawan')->row_array();
                    $my_apikey = "NQXJ3HED5LW2XV440HCG";
                    $destination = $karyawan['phone'];
                    $message = "*RESERVASI PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. Reservasi : *" . $r['id'] . "*" .
                        "\r\n Nama : *" . $r['nama'] . "*" .
                        "\r\n Tujuan : *" . $r['tujuan'] . "*" .
                        "\r\n Keperluan : *" . $r['keperluan'] . "*" .
                        "\r\n Peserta : *" . $r['anggota'] . "*" .
                        "\r\n Berangkat : *" . $r['tglberangkat'] . "* *" . $r['jamberangkat'] . "* _estimasi_" .
                        "\r\n Kembali : *" . $r['tglkembali'] . "* *" . $r['jamkembali'] . "* _estimasi_" .
                        "\r\n Kendaraan : *" . $r['nopol'] . "* ( *" . $r['kepemilikan'] . "* )" .
                        "\r\n Status Terakhir : *" . $status['nama'] . "*" .
                        "\r\n \r\nWaktu reservasi kamu telah selesai. Dibatalkan oleh RAISA pada " . date('d-m-Y H:i') .
                        "\r\n Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
                    $api_url = "http://panel.apiwha.com/send_message.php";
                    $api_url .= "?apikey=" . urlencode($my_apikey);
                    $api_url .= "&number=" . urlencode($destination);
                    $api_url .= "&text=" . urlencode($message);
                    json_decode(file_get_contents($api_url, false));
                }
            }
        endforeach;

        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->where('jenis_perjalanan', "TA");
        $data['reservasi'] = $this->db->where('status', "5");
        $data['reservasi'] = $this->db->get('reservasi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/adminhr', $data);
        $this->load->view('templates/footer');
    }

    public function prosesta1($rsv_id)
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['id' =>  $rsv_id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/prosesta', $data);
        $this->load->view('templates/footer');
    }

    public function prosesta2()
    {
        date_default_timezone_set('asia/jakarta');
        $perjalanan = $this->db->get_where('perjalanan', ['reservasi_id' => $this->input->post('id')])->row_array();
        $reservasi = $this->db->get_where('reservasi', ['id' => $this->input->post('id')])->row_array();
        if (empty($perjalanan['id'])) {
            if ($reservasi['kendaraan'] == 'Non Operasional') {
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

                $data = [
                    'id' => 'DL' . date("ym", strtotime($reservasi['tglberangkat'])) . sprintf("%04s", $totalDl),
                    'npk' => $reservasi['npk'],
                    'nama' => $reservasi['nama'],
                    'anggota' => $reservasi['anggota'],
                    'tujuan' => $reservasi['tujuan'],
                    'keperluan' => $reservasi['keperluan'],
                    'copro' => $reservasi['copro'],
                    'tglberangkat' => $reservasi['tglberangkat'],
                    'jamberangkat' => $reservasi['jamberangkat'],
                    'kmberangkat' => '0',
                    'cekberangkat' => null,
                    'tglkembali' => $reservasi['tglkembali'],
                    'jamkembali' => $reservasi['jamkembali'],
                    'kmkembali' => '0',
                    'cekkembali' => null,
                    'nopol' => $reservasi['nopol'],
                    'kepemilikan' => $reservasi['kepemilikan'],
                    'kendaraan' => $reservasi['kendaraan'],
                    'akomodasi' => $reservasi['akomodasi'],
                    'penginapan' => $reservasi['penginapan'],
                    'lama_menginap' => $reservasi['lama_menginap'],
                    'admin_hr' => $this->session->userdata('inisial'),
                    'tgl_hr' => date('Y-m-d H:i:s'),
                    'catatan' => $this->input->post('catatan'),
                    'ka_dept' => $ka_dept['nama'],
                    'kmtotal' => '0',
                    'jenis_perjalanan' => $reservasi['jenis_perjalanan'],
                    'reservasi_id' => $reservasi['id'],
                    'div_id' => $karyawan['div_id'],
                    'dept_id' => $karyawan['dept_id'],
                    'sect_id' => $karyawan['sect_id'],
                    'status' => '9'
                ];
                $this->db->insert('perjalanan', $data);

                // update table anggota perjalanan
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $reservasi['id']);
                $this->db->update('perjalanan_tujuan');

                // update table anggota perjalanan
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $reservasi['id']);
                $this->db->update('perjalanan_anggota');

                // update table anggota jadwal
                $this->db->set('perjalanan_id', $data['id']);
                $this->db->where('reservasi_id', $reservasi['id']);
                $this->db->update('perjalanan_jadwal');

                $this->db->set('admin_hr', $this->session->userdata('inisial'));
                $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
                $this->db->set('status', '9');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                $notifikasi = $this->db->get_where('layanan_notifikasi', ['id' => '1'])->row_array();
                $user = $this->db->get_where('karyawan', ['npk' => $reservasi['npk']])->row_array();
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $user['phone'],
                    'message' => "*PERJALANAN DINAS TA SUDAH SIAP*" .
                        "\r\n \r\n No. Perjalanan : *" . $data['id'] . "*" .
                        "\r\n Tujuan : *" . $data['tujuan'] . "*" .
                        "\r\n Peserta : *" . $data['anggota'] . "*" .
                        "\r\n Keperluan : *" . $data['keperluan'] . "*" .
                        "\r\n Berangkat : *" . $data['tglberangkat'] . "* *" . $data['jamberangkat'] . "* _estimasi_" .
                        "\r\n Kembali : *" . $data['tglkembali'] . "* *" . $data['jamkembali'] . "* _estimasi_" .
                        "\r\n Kendaraan : *" . $data['nopol'] . "* ( *" . $data['kepemilikan'] . "* )" .
                        "\r\n \r\nTelah siap untuk berangkat." .
                        "\r\nSebelum berangkat pastikan semua kelengkapan yang diperlukan tidak tertinggal." .
                        "\r\nHati-hati dalam berkendara, gunakan sabuk keselamatan dan patuhi rambu-rambu lalu lintas." .
                        "\r\n \r\n" . $notifikasi['pesan']
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

                $this->session->set_flashdata('message', 'barudl');
                redirect('perjalanandl/adminhr');
            } else {
                $this->db->set('admin_hr', $this->session->userdata('inisial'));
                $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
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
                            'message' => "*PENGAJUAN PERJALANAN DINAS TA*" .
                        "\r\n \r\n No. Reservasi : *" . $reservasi['id'] . "*" .
                        "\r\n Nama : *" . $reservasi['nama'] . "*" .
                        "\r\n Tujuan : *" . $reservasi['tujuan'] . "*" .
                        "\r\n Keperluan : *" . $reservasi['keperluan'] . "*" .
                        "\r\n Peserta : *" . $reservasi['anggota'] . "*" .
                        "\r\n Berangkat : *" . $reservasi['tglberangkat'] . "* *" . $reservasi['jamberangkat'] . "* _estimasi_" .
                        "\r\n Kembali : *" . $reservasi['tglkembali'] . "* *" . $reservasi['jamkembali'] . "* _estimasi_" .
                        "\r\n Kendaraan : *" . $reservasi['nopol'] . "* ( *" . $reservasi['kepemilikan'] . "* )" .
                        "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();

                $this->session->set_flashdata('message', 'barudl');
                redirect('perjalanandl/adminhr');
            }
        }
    }

    public function penyelesaian($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
        if (empty($perjalanan)) {
            if ($parameter == 'daftar') {
                $data['sidemenu'] = 'GA';
                $data['sidesubmenu'] = 'Penyelesaian';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '4'])->result_array();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('perjalanandl/penyelesaian_ga_daftar', $data);
                $this->load->view('templates/footer');
            } elseif ($parameter == 'submit') {
                $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
                $this->db->set('penyelesaian_by', $this->session->userdata('inisial'));
                $this->db->set('penyelesaian_at', date('Y-m-d H:i:s'));
                $this->db->set('bayar', $perjalanan['kasbon']);
                $this->db->set('selisih', $perjalanan['total']-$perjalanan['kasbon']);
                $this->db->set('kasbon_status', 'CLOSED');
                $this->db->set('status', '5');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('perjalanan');

                $this->db->where('sect_id', '211');
                $fa_admin = $this->db->get('karyawan_admin')->row_array();
                $selisih = $perjalanan['total']-$perjalanan['kasbon'];
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
                            'phone' => $fa_admin['phone'],
                            'message' => "*PENYELESAIAN PERJALANAN DINAS TELAH DIVERIFIKASI*" . 
                            "\r\n \r\nNo. Perjalanan : *" . $perjalanan['id'] . "*" .
                            "\r\nNama : *" . $perjalanan['nama'] . "*" .
                            "\r\nTujuan : *" . $perjalanan['tujuan'] . "*" .
                            "\r\nPeserta : *" . $perjalanan['anggota'] . "*" .
                            "\r\nBerangkat : *" . $perjalanan['tglberangkat'] . "* *" . $perjalanan['jamberangkat'] . "*" .
                            "\r\nKembali : *" . $perjalanan['tglkembali'] . "* *" . $perjalanan['jamkembali'] . "*" .
                            "\r\nTotal : *" . $perjalanan['total'] . "*" .
                            "\r\nKasbon/Sudah Dibayar : *" . $perjalanan['kasbon'] . "*" .
                            "\r\nSelisih : *" . $selisih . "*" .
                            "\r\n \r\nPenyelesaian Perjalanan ini telah diverifikasi, JANGAN LUPA UNTUK SEGERA MELAKUKAN PEMBAYARAN.".
                            "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();

                redirect('perjalanandl/penyelesaian/daftar');
            } elseif ($parameter == 'revisi') {
                $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
                $this->db->set('catatan', $this->input->post('catatan'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('perjalanan');

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
                            'message' => "*PERMINTAAN REVISI PENYELESAIAN PERJALANAN DINAS*" . 
                            "\r\n \r\nNo. Perjalanan : *" . $perjalanan['id'] . "*" .
                            "\r\nNama : *" . $perjalanan['nama'] . "*" .
                            "\r\nTujuan : *" . $perjalanan['tujuan'] . "*" .
                            "\r\nPeserta : *" . $perjalanan['anggota'] . "*" .
                            "\r\nBerangkat : *" . $perjalanan['tglberangkat'] . "* *" . $perjalanan['jamberangkat'] . "*" .
                            "\r\nKembali : *" . $perjalanan['tglkembali'] . "* *" . $perjalanan['jamkembali'] . "*" .
                            "\r\n \r\n*Catatan : " . $this->input->post('catatan') . "*" .
                            "\r\n \r\nPenyelesaian Perjalanan ini membutuhkan revisi.".
                            "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();

                redirect('perjalanandl/payment/daftar');
            }
        } else {
            if (($this->session->userdata('sect_id')=='214' or $this->session->userdata('npk')=='1111') and $perjalanan['status']=='4'){
                $data['sidemenu'] = 'GA';
                $data['sidesubmenu'] = 'Penyelesaian';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('perjalanandl/penyelesaian_ga_proses', $data);
                $this->load->view('templates/footer');
            }else{
                redirect('perjalanandl/penyelesaian/daftar');
            }
        }
    }
    public function penyelesaian_edit($parameter)
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        if ($parameter == 'uangsaku') {
            $total = $this->input->post('uangsaku') + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('uang_saku', $this->input->post('uangsaku'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }elseif ($parameter == 'insentif') {
            $total = $perjalanan['uang_saku'] + $this->input->post('insentif') + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('insentif_pagi', $this->input->post('insentif'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }elseif ($parameter == 'umpagi') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $this->input->post('umpagi') + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('um_pagi', $this->input->post('umpagi'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }elseif ($parameter == 'umsiang') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $this->input->post('umsiang') +  $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('um_siang', $this->input->post('umsiang'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }elseif ($parameter == 'ummalam') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $this->input->post('ummalam') + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('um_malam', $this->input->post('ummalam'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }elseif ($parameter == 'taksi') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $this->input->post('taksi') + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('taksi', $this->input->post('taksi'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }elseif ($parameter == 'bbm') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $this->input->post('bbm') + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('bbm', $this->input->post('bbm'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        } elseif ($parameter == 'tol') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $this->input->post('tol') + $perjalanan['parkir'];

            $this->db->set('tol', $this->input->post('tol'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        } elseif ($parameter == 'parkir') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $this->input->post('parkir');

            $this->db->set('parkir', $this->input->post('parkir'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }
        redirect('perjalanandl/penyelesaian/' . $this->input->post('id'));
    }

    public function update_kasbon($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        if ($parameter == 'tambah') {
            $this->db->set('kasbon', $this->input->post('kasbon')+$this->input->post('tambah_kasbon'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');

            redirect('perjalanandl/penyelesaian/' . $this->input->post('id'));
        } elseif ($parameter == 'kurang') {
            $this->db->set('kasbon', $this->input->post('kasbon')-$this->input->post('kurang_kasbon'));
            $this->db->set('kasbon_in', $perjalanan['kasbon_in']+$this->input->post('kurang_kasbon'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');

            $kasbon = $this->input->post('kasbon')-$this->input->post('kurang_kasbon');

            $this->db->where('sect_id', '211');
            $fa_admin = $this->db->get('karyawan_admin')->row_array();
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
                        'phone' => $fa_admin['phone'],
                        'message' => "*PENGEMBALIAN KASBON PERJALANAN DINAS*" . 
                        "\r\n \r\nNo. Perjalanan : *" . $this->input->post('id') . "*" .
                        "\r\nKasbon Sebelumnya : *" . $this->input->post('kasbon') . "*" .
                        "\r\n \r\nKasbon Dikembalikan : *" . $this->input->post('kurang_kasbon') . "*" .
                        "\r\nTotal Kasbon : *" . $kasbon . "*" .
                        "\r\n \r\nPastikan transfer kasbon yg dikembalikan sudah masuk/diterima.".
                        "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();

            redirect('perjalanandl/penyelesaian/' . $this->input->post('id'));
        }
    }
    
    public function payment($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
        if (empty($perjalanan)) {
            if ($parameter == 'daftar') {
                $data['sidemenu'] = 'FA';
                $data['sidesubmenu'] = 'Penyelesaian';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '5'])->result_array();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('perjalanandl/penyelesaian_fa_daftar', $data);
                $this->load->view('templates/footer');
            } elseif ($parameter == 'submit') {
                $this->db->set('payment_by', $this->session->userdata('inisial'));
                $this->db->set('payment_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '9');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('perjalanan');

                redirect('perjalanandl/payment/daftar');
            }
        } else {
            if (($this->session->userdata('sect_id')=='211' or $this->session->userdata('npk')=='1111') and $perjalanan['status']=='5'){
                $data['sidemenu'] = 'FA';
                $data['sidesubmenu'] = 'Penyelesaian';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('perjalanandl/penyelesaian_fa_proses', $data);
                $this->load->view('templates/footer');
            }else{
                redirect('perjalanandl/penyelesaian/daftar');
            }
        }
    }

    public function bayar()
    {
        date_default_timezone_set('asia/jakarta');
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        
        $this->db->where('perjalanan_id', $this->input->post('id'));
        $this->db->where('npk', $this->input->post('npk'));
        $p_peserta = $this->db->get('perjalanan_anggota')->row_array();
     
        if ($perjalanan['uang_saku']>0){
            $us = $p_peserta['uang_saku'];
        }else{
            $us = '0';
        }
        if ($perjalanan['insentif_pagi']>0){
            $ip = $p_peserta['insentif_pagi'];
        }else{
            $ip = '0';
        }
        if ($perjalanan['um_pagi']>0){
            $ump = $p_peserta['um_pagi'];
        }else{
            $ump = '0';
        }
        if ($perjalanan['um_siang']>0){
            $ums = $p_peserta['um_siang'];
        }else{
            $ums = '0';
        }
        if ($perjalanan['um_malam']>0){
            $umm = $p_peserta['um_malam'];
        }else{
            $umm = '0';
        }
        if ($perjalanan['pic_perjalanan']==$p_peserta['karyawan_inisial']){
            $kas = $perjalanan['kasbon'];
            $bp = $perjalanan['taksi']+$perjalanan['bbm']+$perjalanan['tol']+$perjalanan['parkir'];
            $tp = $p_peserta['total']+$bp;
            $tb = ($p_peserta['total']+$bp)-$perjalanan['kasbon'];
        }else{
            $kas = '0';
            $bp = '0';
            $tp = $p_peserta['total'];
            $tb = $p_peserta['total'];
        }
        
        if ($this->input->post('ewallet')=="gopay"){
            $ewallet = "GO-PAY - ".$this->input->post('ewallet1');
        }elseif ($this->input->post('ewallet')=="dana"){
            $ewallet = "DANA - ".$this->input->post('ewallet2');
        }

        $this->db->set('bayar', $tp);
        $this->db->set('payment_by', $this->session->userdata('inisial'));
        $this->db->set('payment_at', date('Y-m-d H:i:s'));
        $this->db->set('ewallet', $ewallet);
        $this->db->set('status_pembayaran','SUDAH DIBAYAR');
        $this->db->set('status', '9');
        $this->db->where('perjalanan_id', $this->input->post('id'));
        $this->db->where('npk', $this->input->post('npk'));
        $this->db->update('perjalanan_anggota');

        $this->db->select_sum('bayar');
        $this->db->where('perjalanan_id', $this->input->post('id'));
        $this->db->where('status_pembayaran', 'SUDAH DIBAYAR');
        $bayar = $this->db->get('perjalanan_anggota');
        $total_bayar = $bayar->row()->bayar;

        $selisih = $perjalanan['total']-$total_bayar;

        $this->db->set('bayar', $total_bayar);
        $this->db->set('selisih',$selisih);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $user = $this->db->get_where('karyawan', ['npk' => $this->input->post('npk')])->row_array();
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
                    'message' => "*PEMBAYARAN PERJALANAN DINAS*". 
                    "\r\n \r\nKamu mendapat pembayaran dari perjalanan dinas berikut :".
                    "\r\n \r\nNo. Perjalanan : *" . $perjalanan['id'] . "*" .
                    "\r\nTgl Perjalanan : *" .date("Y-m-d", strtotime($perjalanan['tglberangkat'])). "*" .
                    "\r\nTujuan : *" .$perjalanan['tujuan']. "*" .
                    "\r\nNama: *" . $p_peserta['karyawan_nama'] . "*" .
                    "\r\nUang Saku : *" . number_format($us, 0, ',', '.') . "*" .
                    "\r\nInsentif Pagi : *" . number_format($ip, 0, ',', '.') . "*" .
                    "\r\nMakan Pagi : *" . number_format($ump, 0, ',', '.') . "*" .
                    "\r\nMakan Siang : *" . number_format($ums, 0, ',', '.') . "*" .
                    "\r\nMakan Malam : *" . number_format($umm, 0, ',', '.') . "*" .
                    "\r\nBiaya Perjalanan : *" . number_format($bp, 0, ',', '.') . "*" .
                    "\r\nKasbon : *(" . number_format($kas, 0, ',', '.') . ")*" .
                    "\r\n________________" .
                    "\r\nTotal yang dibayarkan : *" . number_format($tb, 0, ',', '.') . "*" .
                    "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                ],
            ]
        );
        $body = $response->getBody();

        redirect('perjalanandl/payment/'.$this->input->post('id'));
    }

    public function laporan_payment_fa()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Laporan Perjalanan Payment';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if (empty($this->input->post('tglawal')))
        {
            $tglawal = date('Y-m-d 00:00:00');
            $tglakhir = date('Y-m-d 23:59:59');
            $this->db->where('payment_at',$tglawal);
            $this->db->where('jenis_perjalanan !=','TA');
            $this->db->where('status', '9');
            $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        }else{
            $tglawal = date('Y-m-d 00:00:00', strtotime($this->input->post('tglawal')));
            $tglakhir = date('Y-m-d 23:59:59', strtotime($this->input->post('tglakhir')));
            $this->db->where('payment_at >=',$tglawal);
            $this->db->where('payment_at <=',$tglakhir);
            $this->db->where('jenis_perjalanan !=','TA');
            $this->db->where('status', '9');
            $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        }
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/lp_fa_payment', $data);
        $this->load->view('templates/footer');
    }

    public function laporan_perjalanan_fa()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Laporan Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if (empty($this->input->post('tglawal')))
        {
            $tglawal = date('Y-m-d');
            $tglakhir = date('Y-m-d');
            $this->db->where('tglberangkat',$tglawal);
            $this->db->where('jenis_perjalanan !=','TA');
            $this->db->where('status', '9');
            $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        }else{
            $tglawal = date('Y-m-d', strtotime($this->input->post('tglawal')));
            $tglakhir = date('Y-m-d', strtotime($this->input->post('tglakhir')));
            $this->db->where('tglberangkat >=',$tglawal);
            $this->db->where('tglkembali <=',$tglakhir);
            $this->db->where('jenis_perjalanan !=','TA');
            $this->db->where('status', '9');
            $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
        }
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/lp_fa_perjalanan', $data);
        $this->load->view('templates/footer');
    }

    public function kasbon($parameter="")
    {
        date_default_timezone_set('asia/jakarta');
        if ($parameter == '') {
            $data['sidemenu'] = 'FA';
            $data['sidesubmenu'] = 'Permintaan Kasbon';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['perjalanan'] = $this->db->order_by('id', 'DESC');
            $data['perjalanan'] = $this->db->limit('20');
            $data['perjalanan'] = $this->db->where('kasbon_out >', 0);
            $data['perjalanan'] = $this->db->or_where('kasbon >', 0);
            $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/kasbon_fa_daftar', $data);
            $this->load->view('templates/footer');

        } elseif ($parameter == 'submit') {

            if ($this->input->post('ewallet')=="gopay"){
                $ewallet = "GO-PAY - ".$this->input->post('ewallet1');
            }elseif ($this->input->post('ewallet')=="dana"){
                $ewallet = "DANA - ".$this->input->post('ewallet2');
            }
            $this->db->set('kasbon_by', $this->session->userdata('inisial'));
            $this->db->set('kasbon_at', date('Y-m-d H:i:s'));
            $this->db->set('kasbon_out', $this->input->post('kasbon'));
            $this->db->set('kasbon_in', 0);
            $this->db->set('kasbon', $this->input->post('kasbon'));
            $this->db->set('kasbon_ewallet', $ewallet);
            $this->db->set('kasbon_status', 'OUTSTANDING');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');

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
                        'phone' => $this->input->post('phone'),
                        'message' => "*TRANSFER KASBON PERJALANAN DINAS*". 
                        "\r\n \r\nKamu mendapat kasbon dari perjalanan dinas berikut :".
                        "\r\n \r\nNo. Perjalanan : *" . $this->input->post('id') . "*" .
                        "\r\nKasbon : *" . number_format($this->input->post('kasbon'), 0, ',', '.') . "*" .
                        "\r\n \r\n*INGAT : KASBON ini hanya untuk biaya perjalanan seperti taksi, tol, dan parkir.*" .
                        "\r\n \r\n*Untuk tunjangan peserta seperti uang saku, insentif dan uang makan, akan dibayarkan setelah perjalanan selesai oleh bagian FA.*" .
                        "\r\n \r\n*Kelebihan KASBON harus dikembalikan saat penyelesaian ke bagian FA serta menunjukan bukti transfernya ke bagian GA untuk verifikasi*" .
                        "\r\n \r\nUntuk informasi lebih lengkap silahkan buka aplikasi di link berikut https://raisa.winteq-astra.com"
                    ],
                ]
            );
            $body = $response->getBody();

            redirect('perjalanandl/kasbon');
        }
    }
}
