<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Reservasi Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '5'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/admindl', $data);
        $this->load->view('templates/footer');
    }

    public function prosesdl1($rsv_id)
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Reservasi Perjalanan';
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
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->input->post('npk')])->row_array();

        $this->db->where('posisi_id', '3');
        $this->db->where('dept_id', $karyawan['dept_id']);
        $ka_dept = $this->db->get('karyawan')->row_array();

        $queryDl = "SELECT COUNT(*)
        FROM `perjalanan`
        WHERE YEAR(tglberangkat) = YEAR(CURDATE())
        ";
        $dl = $this->db->query($queryDl)->row_array();
        $totalDl = $dl['COUNT(*)'] + 1;

        $data = [
            'id' => 'DL' . date('y') . $totalDl,
            'npk' => $this->input->post('npk'),
            'nama' => $this->input->post('nama'),
            'copro' => $this->input->post('copro'),
            'tujuan' => $this->input->post('tujuan'),
            'keperluan' => $this->input->post('keperluan'),
            'anggota' => $this->input->post('anggota'),
            'tglberangkat' => $this->input->post('tglberangkat'),
            'jamberangkat' => $this->input->post('jamberangkat'),
            'kmberangkat' => '0',
            'cekberangkat' => null,
            'tglkembali' => $this->input->post('tglkembali'),
            'jamkembali' => $this->input->post('jamkembali'),
            'kmkembali' => '0',
            'cekkembali' => null,
            'nopol' => $this->input->post('nopol'),
            'kepemilikan' => $this->input->post('kepemilikan'),
            'admin_ga' => $this->session->userdata('inisial'),
            'catatan_ga' => $this->input->post('catatan'),
            'ka_dept' => $ka_dept['nama'],
            'kmtotal' => '0',
            'jenis_perjalanan' => $this->input->post('jperjalanan'),
            'reservasi_id' => $this->input->post('id'),
            'div_id' => $karyawan['div_id'],
            'dept_id' => $karyawan['dept_id'],
            'sect_id' => $karyawan['sect_id'],
            'status' => '1'
        ];

        $rsv_id = $this->input->post('id');
        $queryCek = "SELECT COUNT(*)
                      FROM `perjalanan`
                      WHERE `reservasi_id` =  '$rsv_id'
                      ";
        $cek = $this->db->query($queryCek)->row_array();
        $total = $cek['COUNT(*)'];
        if ($total == 0) {

            $this->db->insert('perjalanan', $data);

            // update uangsaku
            if ($this->input->post('jperjalanan') == 'TAPP' or $this->input->post('jperjalanan') == 'TA') {
                $this->db->set('uangsaku', 'YA');
                $this->db->where('id', $data['id']);
                $this->db->update('perjalanan');
            }
            // update table anggota perjalanan
            $this->db->set('perjalanan_id', $data['id']);
            $this->db->where('reservasi_id', $this->input->post('id'));
            $this->db->update('perjalanan_tujuan');

            // update table anggota perjalanan
            $this->db->set('perjalanan_id', $data['id']);
            $this->db->where('reservasi_id', $this->input->post('id'));
            $this->db->update('perjalanan_anggota');

            $this->db->set('admin_ga', $this->session->userdata('inisial'));
            $this->db->set('status', '6');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('npk', $this->input->post('npk'));
            $karyawan = $this->db->get('karyawan')->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*Perjalanan Dinas kamu dengan detail berikut :*\r\n \r\n No. Perjalanan : *" . $data['id'] . "*" .
                "\r\n Tujuan : *" . $this->input->post('tujuan') . "*" .
                "\r\n Peserta : *" . $this->input->post('anggota') . "*" .
                "\r\n Keperluan : *" . $this->input->post('keperluan') . "*" .
                "\r\n Berangkat : *" . $this->input->post('tglberangkat') . "* *" . $this->input->post('jamberangkat') . "* _estimasi_" .
                "\r\n Kembali : *" . $this->input->post('tglkembali') . "* *" . $this->input->post('jamkembali') . "* _estimasi_" .
                "\r\n Kendaraan : *" . $this->input->post('nopol') . "* ( *" . $this->input->post('kepemilikan') . "*" .
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
                $this->db->set('nopol', $this->input->post('nopol'));
                $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
                $this->db->where('id', $rsv_id);
                $this->db->update('reservasi');
                redirect('perjalanandl/prosesdl1/' . $rsv_id);
            }
        } else {
            $this->db->set('nopol', $this->input->post('nopol'));
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

    public function perjalanan()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Laporan Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->limit('100');
        $data['perjalanan'] = $this->db->order_by('tglberangkat', 'desc');
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
        $statusperjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $jenis = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        if ($jenis['jenis_perjalanan'] == 'DLPP' or $jenis['jenis_perjalanan'] == 'TA') {
            $this->load->view('perjalanandl/sjdlpp', $data);
        } else ($jenis['jenis_perjalanan'] == 'TAPP'){
            $this->load->view('perjalanandl/sjtapp', $data)};
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
        $this->db->set('catatan_ga', "Alasan pembatalan : " . $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial') . " pada " . date('d-m-Y H:i'));
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
        $this->db->set('catatan_ga',  $this->input->post('catatan'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $this->session->set_flashdata('message', 'setujudl');
        redirect('perjalanandl/revisi');
    }

    public function tambahwaktudl($id)
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $updatejam = date('H:i:s', strtotime('+2 hour', strtotime($perjalanan['jamberangkat'])));
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
        $this->db->set('catatan_ga', "");
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
        $this->db->set('admin_ga' , $this->session->userdata('inisial'));
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
        $this->db->set('admin_ga' , $this->session->userdata('inisial'));
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

    public function konfirmasihr()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '5'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/adminhr', $data);
        $this->load->view('templates/footer');
    }

    public function laporanjarak_kr()
    {
        $data['sidemenu'] = 'Kepala Departemen';
        $data['sidesubmenu'] = 'Laporan Perjalanan Dinas';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $queryPerjalanan = "SELECT *
                            FROM `perjalanan`
                            WHERE month(tglberangkat)='11' ";
        $data['perjalanan'] = $this->db->query($queryPerjalanan)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/laporan-jarak-kr', $data);
        $this->load->view('templates/footer');
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
}
