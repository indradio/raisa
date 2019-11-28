<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        $data['sidemenu'] = 'Security';
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
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Keberangkatan / Keluar';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->where('status', '1');
        $data['perjalanan'] = $this->db->or_where('status', '11');
        $data['perjalanan'] = $this->db->get('perjalanan')->result_array();
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
        foreach ($perjalanan as $p) :
            // cari selisih
            $mulai = strtotime($p['jamberangkat']);
            $selesai = time();
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));

            if ($jam >= 2) {
                $this->db->set('status', '0');
                $this->db->set('catatan_ga', "Waktu keberangkatan perjalanan kamu telah selesai. - Dibatalkan oleh RAISA pada " . date('d-m-Y H:i'));
                $this->db->where('id', $p['id']);
                $this->db->update('perjalanan');

                $this->db->set('status', '9');
                $this->db->where('id', $p['reservasi_id']);
                $this->db->update('reservasi');

                $this->db->where('npk', $p['npk']);
                $karyawan = $this->db->get('karyawan')->row_array();
                $my_apikey = "NQXJ3HED5LW2XV440HCG";
                $destination = $karyawan['phone'];
                $message = "*PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. PERJALANAN : *" . $p['id'] . "*" .
                    "\r\n Nama : *" . $p['nama'] . "*" .
                    "\r\n Tujuan : *" . $p['tujuan'] . "*" .
                    "\r\n Keperluan : *" . $p['keperluan'] . "*" .
                    "\r\n Peserta : *" . $p['anggota'] . "*" .
                    "\r\n Berangkat : *" . $p['tglberangkat'] . "* *" . $p['jamberangkat'] . "* _estimasi_" .
                    "\r\n Kembali : *" . $p['tglkembali'] . "* *" . $p['jamkembali'] . "* _estimasi_" .
                    "\r\n Kendaraan : *" . $p['nopol'] . "* ( *" . $p['kepemilikan'] . "* )" .
                    "\r\n Catatan : *" . $p['catatan_ga'] .  "*" .
                    "\r\n \r\nWaktu keberangkatan perjalanan kamu melebihi 2 Jam / batas waktu keberangkatan. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
                $api_url = "http://panel.apiwha.com/send_message.php";
                $api_url .= "?apikey=" . urlencode($my_apikey);
                $api_url .= "&number=" . urlencode($destination);
                $api_url .= "&text=" . urlencode($message);
                json_decode(file_get_contents($api_url, false));
            }
        endforeach;

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

    public function cekberangkat_proses()
    {
        date_default_timezone_set('asia/jakarta');

        $kmberangkat = substr($this->input->post('kmberangkat'), -3);
        $this->db->set('tglberangkat', date("Y-m-d"));
        $this->db->set('jamberangkat', date("H:i:s"));
        $this->db->set('cekberangkat', $this->session->userdata('inisial'));
        $this->db->set('kmberangkat', $kmberangkat);
        $this->db->set('supirberangkat', $this->input->post('supirberangkat'));
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', '2');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um1']) {
            $this->db->set('um1', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um2']) {
            $this->db->set('um2', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };

        $this->session->set_flashdata('message', 'berangkat');
        redirect('cekdl/berangkat');
    }

    public function kembali()
    {
        $data['sidemenu'] = 'Security';
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
        $data['sidemenu'] = 'Security';
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
        $kmkembali = substr($this->input->post('kmkembali'), -3);
        if ($kmkembali < $this->input->post('kmberangkat')){
            $kmkembali = $kmkembali + 1000;
        }
        $kmtotal = $kmkembali - $this->input->post('kmberangkat');
        $this->db->set('tglkembali', date("Y-m-d"));
        $this->db->set('jamkembali', date("H:i:s"));
        $this->db->set('cekkembali', $this->session->userdata('inisial'));
        $this->db->set('kmkembali', $kmkembali);
        $this->db->set('supirkembali', $this->input->post('supirkembali'));
        $this->db->set('kmtotal', $kmtotal);
        $this->db->set('catatan_security', $this->input->post('catatan'));
        $this->db->set('status', '9');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um3'] and $this->input->post('jamkembali') >= $um['um3']) {
            $this->db->set('um3', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamkembali') >= $um['um4']) {
            $this->db->set('um4', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };

        $rsv = $this->db->get_where('perjalanan', ['id' =>  $this->input->post('id')])->row_array();
        $this->db->set('status', '9');
        $this->db->where('id', $rsv['reservasi_id']);
        $this->db->update('reservasi');

        redirect('cekdl/kembali');
    }
    public function tambahpeserta()
    {
        foreach ($this->input->post('anggota') as $a) :
            $dl = $this->db->get_where('perjalanan', ['id' =>  $this->input->post('id')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $a])->row_array();
            $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
            $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
            $peserta = [
                'perjalanan_id' => $dl['id'],
                'reservasi_id' => $dl['reservasi_id'],
                'npk' => $karyawan['npk'],
                'karyawan_inisial' => $karyawan['inisial'],
                'karyawan_nama' => $karyawan['nama'],
                'karyawan_dept' => $dept['nama'],
                'karyawan_posisi' => $posisi['nama'],
                'status' => '1'
            ];
            $this->db->insert('perjalanan_anggota', $peserta);
        endforeach;

        $anggota = $this->db->where('perjalanan_id', $dl['id']);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $dl['id']);
        $this->db->update('perjalanan');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $dl['reservasi_id']);
        $this->db->update('reservasi');

        redirect('cekdl/cekberangkat/' . $dl['id']);
    }

    public function hapus_anggota($dl, $inisial)
    {
        $this->db->where('perjalanan_id', $dl);
        $this->db->where('karyawan_inisial', $inisial);
        $this->db->delete('perjalanan_anggota');

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

        redirect('cekdl/cekberangkat/' . $dl);
    }

    public function revisi()
    {
        $this->db->set('catatan_security', $this->input->post('catatan') . ' - Direvisi oleh ' . $this->session->userdata('inisial') . ' pada ' . date('d-m-Y H:i'));
        $this->db->set('status', '8');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $dl = $this->db->get_where('perjalanan', ['id' =>  $this->input->post('id')])->row_array();
        $this->db->where('sect_id', '214');
        $ga_admin = $this->db->get('karyawan_admin')->row_array();
        $my_apikey = "NQXJ3HED5LW2XV440HCG";
        $destination = $ga_admin['phone'];
        $message = "*REVISI PERJALANAN DINAS*\r\n \r\n No. Perjalanan : *" . $dl['id'] . "*" .
            "\r\n Nama Pemohon: *" . $dl['nama'] . "*" .
            "\r\n Tujuan : *" . $dl['tujuan'] . "*" .
            "\r\n Keperluan : *" . $dl['keperluan'] . "*" .
            "\r\n Peserta : *" . $dl['anggota'] . "*" .
            "\r\n Berangkat : *" . $dl['tglberangkat'] . "* *" . $dl['jamberangkat'] . "* _estimasi_" .
            "\r\n Kembali : *" . $dl['tglkembali'] . "* *" . $dl['jamkembali'] . "* _estimasi_" .
            "\r\n Kendaraan : *" . $dl['nopol'] . "* ( *" . $dl['kepemilikan'] . "*" .
            "\r\n Catatan : *" . $dl['catatan_security'] . "*" .
            "\r\n Direvisi Oleh " . $this->session->userdata('inisial') . ' pada ' . date('d-m-Y H:i') .
            " ) \r\n \r\nPerjalanan ini membutuhkan revisi dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
        $api_url = "http://panel.apiwha.com/send_message.php";
        $api_url .= "?apikey=" . urlencode($my_apikey);
        $api_url .= "&number=" . urlencode($destination);
        $api_url .= "&text=" . urlencode($message);
        json_decode(file_get_contents($api_url, false));

        redirect('cekdl/berangkat');
    }

    public function edit()
    {
        $this->db->set('tglberangkat', $this->input->post('tglberangkat'));
        $this->db->set('jamberangkat', $this->input->post('jamberangkat'));
        $this->db->set('tglkembali', $this->input->post('tglkembali'));
        $this->db->set('jamkembali', $this->input->post('jamkembali'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um1']) {
            $this->db->set('um1', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um2']) {
            $this->db->set('um2', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamberangkat') <= $um['um3'] and $this->input->post('jamkembali') >= $um['um3']) {
            $this->db->set('um3', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };
        if ($this->input->post('jenis') != 'TA' and $this->input->post('jamkembali') >= $um['um4']) {
            $this->db->set('um4', 'YA');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        };

        redirect('cekdl/index');
    }
}
