<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/index', $data);
        $this->load->view('templates/footer');
    }

    public function dl()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl', $data);
        $this->load->view('templates/footer');
    }

    public function dl1a()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl1a', $data);
        $this->load->view('templates/footer');
    }

    public function dl1a_proses()
    {
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data = [
            'npk' => $this->session->userdata['npk'],
            'nama' => $dataku['nama'],
            'tglreservasi' => date("Y-m-d H:i:s"),
            'tglberangkat' => $this->input->post('tglberangkat'),
            'jamberangkat' => $this->input->post('jamberangkat'),
            'tglkembali' => $this->input->post('tglberangkat'),
            'jamkembali' => $this->input->post('jamkembali')
        ];
        $this->db->insert('reservasi_temp', $data);
        redirect('reservasi/dl1b');
    }

    public function dl1b()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl1b', $data);
        $this->load->view('templates/footer');
    }

    public function dl1b_proses($id)
    {
        if ($id == 1) {
            redirect('reservasi/dl1c2');
        } else {
            $data['sidemenu'] = 'Perjalanan Dinas';
            $data['sidesubmenu'] = 'Reservasi';
            $kendaraan = $this->db->get_where('kendaraan', ['id' =>  $id])->row_array();
            $reservasi_temp = $this->db->order_by('id', "DESC");
            $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->db->set('nopol', $kendaraan['nopol']);
            $this->db->set('kepemilikan', 'Operasional');
            $this->db->where('id', $reservasi_temp['id']);
            $this->db->update('reservasi_temp');
            redirect('reservasi/dl1c1');
        };
    }

    public function dl1c1()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl1c1', $data);
        $this->load->view('templates/footer');
    }

    public function dl1c1_proses()
    {
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        //varianel tujuan
        if ($this->input->post('tujuan') == null and $this->input->post('tlainnya') == null) {
            $this->session->set_flashdata('message', '<div class="col-md-12 alert alert-danger" role="alert">Silahkan tentukan tujuan anda</div>');
            redirect('reservasi/dl1c1');
        } elseif ($this->input->post('tujuan') == null) {
            $tujuan = $this->input->post('tlainnya');
        } elseif ($this->input->post('tlainnya') == null) {
            $tujuan = implode(', ', $this->input->post('tujuan'));
        } else {
            $tujuan = implode(', ', $this->input->post('tujuan')) . ', ' .  $this->input->post('tlainnya');
        };
        //variabel anggota
        if ($this->input->post('anggota') == null and $this->input->post('ikut') == null) {
            $this->session->set_flashdata('message', '<div class="col-md-12 alert alert-danger" role="alert">Silahkan pilih anggota perjalanan anda</div>');
            redirect('reservasi/dl1c1');
        } elseif ($this->input->post('anggota') == null) {
            $anggota = $this->input->post('ikut');
        } elseif ($this->input->post('ikut') == null) {
            $anggota = implode(', ', $this->input->post('anggota'));
        } else {
            $anggota = implode(', ', $this->input->post('anggota')) . ', ' .  $this->input->post('ikut');
        }
        $this->db->set('tujuan', $tujuan);
        $this->db->set('keperluan', $this->input->post('keperluan'));
        $this->db->set('anggota', $anggota);
        $this->db->where('id', $reservasi_temp['id']);
        $this->db->update('reservasi_temp');

        // insert kedalam table tujuan perjalanan
        foreach ($this->input->post('tujuan') as $tjn) :
            $tujuan = $this->db->get_where('customer', ['inisial' => $tjn])->row_array();
            $data = [
                'reservasi_id' => $reservasi_temp['id'],
                'inisial' => $tujuan['inisial'],
                'nama' => $tujuan['nama'],
                'kota' => $tujuan['kota'],
                'jarak' => $tujuan['jarak'],
                'status' => '1'
            ];
            $this->db->insert('perjalanan_tujuan', $data);
        endforeach;
        if ($this->input->post('tlainnya') != '') {
            $tlainnya = [
                'reservasi_id' => $reservasi_temp['id'],
                'inisial' => 'LAINNYA',
                'nama' => $this->input->post('tlainnya'),
                'jarak' => '0',
                'status' => '1'
            ];
            $this->db->insert('perjalanan_tujuan', $tlainnya);
        }

        // insert kedalam table anggota perjalanan
        foreach ($this->input->post('anggota') as $ang) :
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $ang])->row_array();
            $data = [
                'reservasi_id' => $reservasi_temp['id'],
                'npk' => $karyawan['npk'],
                'karyawan_inisial' => $karyawan['inisial'],
                'karyawan_nama' => $karyawan['nama'],
                'status' => '1'
            ];
            $this->db->insert('perjalanan_anggota', $data);
        endforeach;
        if ($this->input->post('ikut') != '') {
            $me = [
                'reservasi_id' => $reservasi_temp['id'],
                'npk' => $dataku['npk'],
                'karyawan_inisial' => $dataku['inisial'],
                'karyawan_nama' => $dataku['nama'],
                'status' => '1'
            ];
            $this->db->insert('perjalanan_anggota', $me);
        }
        redirect('reservasi/dl1z');
    }

    // Jika menggunakan kendaraan non operasional
    public function dl1c2()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl1c2', $data);
        $this->load->view('templates/footer');
    }

    public function dl1c2_proses()
    {
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        //varianel tujuan
        if ($this->input->post('tujuan') == null and $this->input->post('tlainnya') == null) {
            $this->session->set_flashdata('message', '<div class="col-md-12 alert alert-danger" role="alert">Silahkan tentukan tujuan anda</div>');
            redirect('reservasi/dl1c1');
        } elseif ($this->input->post('tujuan') == null) {
            $tujuan = $this->input->post('tlainnya');
        } elseif ($this->input->post('tlainnya') == null) {
            $tujuan = implode(', ', $this->input->post('tujuan'));
        } else {
            $tujuan = implode(', ', $this->input->post('tujuan')) . ', ' .  $this->input->post('tlainnya');
        };
        //variabel anggota
        if ($this->input->post('anggota') == null and $this->input->post('ikut') == null) {
            $this->session->set_flashdata('message', '<div class="col-md-12 alert alert-danger" role="alert">Silahkan pilih anggota perjalanan anda</div>');
            redirect('reservasi/dl1c1');
        } elseif ($this->input->post('anggota') == null) {
            $anggota = $this->input->post('ikut');
        } elseif ($this->input->post('ikut') == null) {
            $anggota = implode(', ', $this->input->post('anggota'));
        } else {
            $anggota = implode(', ', $this->input->post('anggota')) . ', ' .  $this->input->post('ikut');
        }
        $this->db->set('tujuan', $tujuan);
        $this->db->set('keperluan', $this->input->post('keperluan'));
        $this->db->set('anggota', $anggota);
        $this->db->set('nopol', $this->input->post('nopol'));
        $this->db->set('kepemilikan', $this->input->post('kepemilikan'));
        $this->db->where('id', $reservasi_temp['id']);
        $this->db->update('reservasi_temp');

        // insert kedalam table tujuan perjalanan
        foreach ($this->input->post('tujuan') as $tjn) :
            $tujuan = $this->db->get_where('customer', ['inisial' => $tjn])->row_array();
            $data = [
                'reservasi_id' => $reservasi_temp['id'],
                'inisial' => $tujuan['inisial'],
                'nama' => $tujuan['nama'],
                'kota' => $tujuan['kota'],
                'jarak' => $tujuan['jarak'],
                'status' => '1'
            ];
            $this->db->insert('perjalanan_tujuan', $data);
        endforeach;
        if ($this->input->post('tlainnya') != '') {
            $tlainnya = [
                'reservasi_id' => $reservasi_temp['id'],
                'inisial' => 'LAINNYA',
                'nama' => $this->input->post('tlainnya'),
                'jarak' => '0',
                'status' => '1'
            ];
            $this->db->insert('perjalanan_tujuan', $tlainnya);
        }

        // insert kedalam table anggota perjalanan
        foreach ($this->input->post('anggota') as $ang) :
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $ang])->row_array();
            $data = [
                'reservasi_id' => $reservasi_temp['id'],
                'npk' => $karyawan['npk'],
                'karyawan_inisial' => $karyawan['inisial'],
                'karyawan_nama' => $karyawan['nama'],
                'status' => '1'
            ];
            $this->db->insert('perjalanan_anggota', $data);
        endforeach;
        if ($this->input->post('ikut') != '') {
            $me = [
                'reservasi_id' => $reservasi_temp['id'],
                'npk' => $dataku['npk'],
                'karyawan_inisial' => $dataku['inisial'],
                'karyawan_nama' => $dataku['nama'],
                'status' => '1'
            ];
            $this->db->insert('perjalanan_anggota', $me);
        }
        redirect('reservasi/dl1z');
    }

    public function dl1z()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl1z', $data);
        $this->load->view('templates/footer');
    }

    public function dl1z_proses()
    {
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();

        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
        $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

        $queryRsv = "SELECT COUNT(*)
        FROM `reservasi`
        WHERE YEAR(tglreservasi) = YEAR(CURDATE())
        ";
        $rsv = $this->db->query($queryRsv)->row_array();
        $totalRsv = $rsv['COUNT(*)'] + 1;
        $data = [
            'id' => 'RSV' . date('y') . $totalRsv,
            'tglreservasi' => date('Y-m-d H:i:s'),
            'npk' => $reservasi_temp['npk'],
            'nama' => $reservasi_temp['nama'],
            'tujuan' => $reservasi_temp['tujuan'],
            'keperluan' => $reservasi_temp['keperluan'],
            'anggota' => $reservasi_temp['anggota'],
            'tglberangkat' => $reservasi_temp['tglberangkat'],
            'jamberangkat' => $reservasi_temp['jamberangkat'],
            'tglkembali' => $reservasi_temp['tglkembali'],
            'jamkembali' => $reservasi_temp['jamkembali'],
            'nopol' => $reservasi_temp['nopol'],
            'kepemilikan' => $reservasi_temp['kepemilikan'],
            'atasan1' => $atasan1['inisial'],
            'atasan2' => $atasan2['inisial'],
            'status' => '1'
        ];
        $this->db->insert('reservasi', $data);

        if ($this->session->userdata('posisi_id') <= 3) {
            $this->db->set('atasan1', null);
            $this->db->set('atasan2', null);
            $this->db->set('status', '3');
            $this->db->where('id', $data['id']);
            $this->db->update('reservasi');

            $this->db->where('sect_id', '214');
            $ga_admin = $this->db->get('karyawan_admin')->row_array();

            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $ga_admin['phone'];
            $message = "*PENGAJUAN PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $data['id'] . "*" .
                "\r\n Nama : *" . $reservasi_temp['nama'] . "*" .
                "\r\n Tujuan : *" . $reservasi_temp['tujuan'] . "*" .
                "\r\n Keperluan : *" . $reservasi_temp['keperluan'] . "*" .
                "\r\n Peserta : *" . $reservasi_temp['anggota'] . "*" .
                "\r\n Berangkat : *" . $reservasi_temp['tglberangkat'] . "* *" . $reservasi_temp['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $reservasi_temp['tglkembali'] . "* *" . $reservasi_temp['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "*" .
                " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        } elseif ($this->session->userdata('posisi_id') >= 4 and $this->session->userdata('posisi_id') <= 6) {
            $this->db->set('atasan2', null);
            $this->db->set('status', '2');
            $this->db->where('id', $data['id']);
            $this->db->update('reservasi');

            $this->db->where('npk', $atasan1['npk']);
            $karyawan = $this->db->get('karyawan')->row_array();

            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $data['id'] . "*" .
                "\r\n Nama : *" . $reservasi_temp['nama'] . "*" .
                "\r\n Tujuan : *" . $reservasi_temp['tujuan'] . "*" .
                "\r\n Keperluan : *" . $reservasi_temp['keperluan'] . "*" .
                "\r\n Peserta : *" . $reservasi_temp['anggota'] . "*" .
                "\r\n Berangkat : *" . $reservasi_temp['tglberangkat'] . "* *" . $reservasi_temp['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $reservasi_temp['tglkembali'] . "* *" . $reservasi_temp['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "*" .
                " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        } elseif ($this->session->userdata('posisi_id') == 7) {

            $this->db->where('npk', $atasan1['npk']);
            $karyawan = $this->db->get('karyawan')->row_array();

            $my_apikey = "NQXJ3HED5LW2XV440HCG";
            $destination = $karyawan['phone'];
            $message = "*PENGAJUAN PERJALANAN DINAS*\r\n \r\n No. Reservasi : *" . $data['id'] . "*" .
                "\r\n Nama : *" . $reservasi_temp['nama'] . "*" .
                "\r\n Tujuan : *" . $reservasi_temp['tujuan'] . "*" .
                "\r\n Keperluan : *" . $reservasi_temp['keperluan'] . "*" .
                "\r\n Peserta : *" . $reservasi_temp['anggota'] . "*" .
                "\r\n Berangkat : *" . $reservasi_temp['tglberangkat'] . "* *" . $reservasi_temp['jamberangkat'] . "* _estimasi_" .
                "\r\n Kembali : *" . $reservasi_temp['tglkembali'] . "* *" . $reservasi_temp['jamkembali'] . "* _estimasi_" .
                "\r\n Kendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "*" .
                " ) \r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com";
            $api_url = "http://panel.apiwha.com/send_message.php";
            $api_url .= "?apikey=" . urlencode($my_apikey);
            $api_url .= "&number=" . urlencode($destination);
            $api_url .= "&text=" . urlencode($message);
            json_decode(file_get_contents($api_url, false));
        }

        // update table anggota perjalanan
        $this->db->set('reservasi_id', $data['id']);
        $this->db->where('reservasi_id', $reservasi_temp['id']);
        $this->db->update('perjalanan_tujuan');

        // update table anggota perjalanan
        $this->db->set('reservasi_id', $data['id']);
        $this->db->where('reservasi_id', $reservasi_temp['id']);
        $this->db->update('perjalanan_anggota');

        $this->session->set_flashdata('message', 'rsvbaru');
        redirect('reservasi');
    }

    public function dl3a()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl3a', $data);
        $this->load->view('templates/footer');
    }

    public function dl3a_proses()
    {
        if ($this->input->post('tglkembali') < $this->input->post('tglberangkat')) {

            $this->session->set_flashdata('message', 'backdate');
            redirect('reservasi/dl3a');
        } else {
            $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data = [
                'npk' => $this->session->userdata['npk'],
                'nama' => $dataku['nama'],
                'tglreservasi' => date("Y-m-d H:i:s"),
                'tglberangkat' => $this->input->post('tglberangkat'),
                'jamberangkat' => $this->input->post('jamberangkat'),
                'tglkembali' => $this->input->post('tglkembali'),
                'jamkembali' => $this->input->post('jamkembali')
            ];
            $this->db->insert('reservasi_temp', $data);
            redirect('reservasi/dl3b');
        }
    }

    public function dl3b()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl3b', $data);
        $this->load->view('templates/footer');
    }
}
