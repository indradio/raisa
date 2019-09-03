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
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Reservasi Perjalanan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '3'])->result_array();
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
            $this->db->set('status', '4');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');

            $this->db->where('npk', $this->input->post('npk'));
            $karyawan = $this->db->get('karyawan')->row_array();
            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*Perjalanan anda dengan detail berikut :*\r\n \r\n No. Perjalanan : *" . $data['id'] . "*" .
                "\r\n Tujuan : *" . $this->input->post('tujuan') . "*" .
                "\r\n Keperluan : *" . $this->input->post('keperluan') . "*" .
                "\r\n Peserta : *" . $this->input->post('anggota') . "*" .
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
        $data['perjalanan'] = $this->db->get_where('perjalanan')->result_array();
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

        if ($this->session->userdata('posisi_id') >= 4) {
            $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $atasan1['phone'];
            $message = "*INFO PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $dl . "*" .
                "\r\n \r\n" . $dataku['nama'] . " Ikut dalam Perjalanan ini. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }
        if ($this->session->userdata('posisi_id') >= 7) {
            $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $atasan2['phone'];
            $message = "*INFO PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $dl . "*" .
                "\r\n \r\n" . $dataku['nama'] . " Ikut dalam Perjalanan ini. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }

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

    public function bataldladmin($id)
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('status', '0');
        $this->db->set('catatan_ga', "Waktu keberangkatan perjalanan kamu telah habis. - Dibatalkan oleh " . $this->session->userdata('inisial') . " pada " . date('d-m-Y H:i'));
        $this->db->where('id', $id);
        $this->db->update('perjalanan');

        $perjalanan = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $this->db->set('status', '9');
        $this->db->where('id', $perjalanan['reservasi_id']);
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('dashboard/index');
    }

    public function konfirmasi($id)
    {
        $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $reservasi['npk']])->row_array();

        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $karyawan['phone'];
        $message = "*Perjalanan anda dengan detail berikut :*\r\n \r\n No. Reservasi : *" . $id . "*" .
            "\r\n Tujuan : *" . $reservasi['tujuan'] . "*" .
            "\r\n Keperluan : *" . $reservasi['keperluan'] . "*" .
            "\r\n Peserta : *" . $reservasi['anggota'] . "*" .
            "\r\n Berangkat : *" . $reservasi['tglberangkat'] . "* *" . $reservasi['jamberangkat'] . "* _estimasi_" .
            "\r\n Kembali : *" . $reservasi['tglkembali'] . "* *" . $reservasi['jamkembali'] . "* _estimasi_" .
            "\r\n Kendaraan : *" . $reservasi['nopol'] . "* ( *" . $reservasi['kepemilikan'] . "*" .
            " ) \r\n \r\nAkan dibatalkan secara otomatis dalam 15 menit. 
                    \r\nSilahkan lakukan konfirmasi ke bagian GA jika ingin melanjutkan perjalanan ini.";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        $this->session->set_flashdata('message', 'barudl');
        redirect('perjalanandl/admindl');
    }
}
