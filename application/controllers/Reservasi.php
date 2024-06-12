<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Reservasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
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
        $temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->result_array();
        foreach ($temp as $t) :
            $this->db->set('perjalanan_anggota');
            $this->db->where('reservasi_id', $t['id']);
            $this->db->delete('perjalanan_anggota');

            $this->db->set('perjalanan_tujuan');
            $this->db->where('reservasi_id', $t['id']);
            $this->db->delete('perjalanan_tujuan');

            $this->db->set('perjalanan_jadwal');
            $this->db->where('reservasi_id', $t['id']);
            $this->db->delete('perjalanan_jadwal');

            $this->db->set('reservasi_temp');
            $this->db->where('id', $t['id']);
            $this->db->delete('reservasi_temp');
        endforeach;

        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
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
        date_default_timezone_set('asia/jakarta');
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        if (date("Y-m-d", strtotime($this->input->post('tglberangkat'))) < date("Y-m-d")) {
            $this->session->set_flashdata('message', 'backdate');
            redirect('reservasi/dl');
        } else {
            $data = [
                'npk' => $this->session->userdata['npk'],
                'nama' => $dataku['nama'],
                'tglreservasi' => date("Y-m-d H:i:s"),
                'tglberangkat' => date("Y-m-d", strtotime($this->input->post('tglberangkat'))),
                'jamberangkat' => $this->input->post('jamberangkat'),
                'tglkembali' => date("Y-m-d", strtotime($this->input->post('tglberangkat'))),
                'jamkembali' => $this->input->post('jamkembali'),
                'jenis_perjalanan' => 'DLPP'
            ];
            $this->db->insert('reservasi_temp', $data);
            redirect('reservasi/dl1b');
        }
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
            redirect('reservasi/dl1c');
        } else {
            $data['sidemenu'] = 'Perjalanan Dinas';
            $data['sidesubmenu'] = 'Reservasi';
            $kendaraan = $this->db->get_where('kendaraan', ['id' =>  $id])->row_array();
            $reservasi_temp = $this->db->order_by('id', "DESC");
            $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->db->set('nopol', $kendaraan['nopol']);
            $this->db->set('kendaraan', $kendaraan['nama']);
            $this->db->set('kepemilikan', 'Operasional');
            $this->db->where('id', $reservasi_temp['id']);
            $this->db->update('reservasi_temp');
            redirect('reservasi/dl1d');
        };
    }

    public function dl1d()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl1d', $data);
        $this->load->view('templates/footer');
    }

    public function dl1d_proses()
    {
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();

        //variabel tujuan

        $this->db->where('reservasi_id', $reservasi_temp['id']);
        $this->db->delete('perjalanan_tujuan');

        if ($this->input->post('tujuan') == null and $this->input->post('tlainnya') == null) {
            $this->session->set_flashdata('message', '<div class="col-md-12 alert alert-danger" role="alert">Silahkan tentukan tujuan perjalanan anda terlebih dahulu.</div>');
            redirect('reservasi/dl1d');
        } elseif ($this->input->post('tlainnya') == null) {
            foreach ($this->input->post('tujuan') as $t) :
                $customer = $this->db->get_where('customer', ['inisial' => $t])->row_array();
                $tujuan = [
                    'reservasi_id' => $reservasi_temp['id'],
                    'inisial' => $customer['inisial'],
                    'nama' => $customer['nama'],
                    'kota' => $customer['kota'],
                    'jarak' => $customer['jarak'],
                    'status' => '0'
                ];
                $this->db->insert('perjalanan_tujuan', $tujuan);
            endforeach;
        } elseif ($this->input->post('tujuan') == null) {
            $tujuan = [
                'reservasi_id' => $reservasi_temp['id'],
                'inisial' => $this->input->post('tlainnya'),
                'nama' => $this->input->post('tlainnya'),
                'jarak' => '0',
                'status' => '0'
            ];
            $this->db->insert('perjalanan_tujuan', $tujuan);
        } else {
            foreach ($this->input->post('tujuan') as $t) :
                $customer = $this->db->get_where('customer', ['inisial' => $t])->row_array();
                $tujuan1 = [
                    'reservasi_id' => $reservasi_temp['id'],
                    'inisial' => $customer['inisial'],
                    'nama' => $customer['nama'],
                    'kota' => $customer['kota'],
                    'jarak' => $customer['jarak'],
                    'status' => '0'
                ];
                $this->db->insert('perjalanan_tujuan', $tujuan1);
            endforeach;

            $tujuan2 = [
                'reservasi_id' => $reservasi_temp['id'],
                'inisial' =>  $this->input->post('tlainnya'),
                'nama' => $this->input->post('tlainnya'),
                'jarak' => '0',
                'status' => '0'
            ];
            $this->db->insert('perjalanan_tujuan', $tujuan2);
        };

        //variabel anggota

        $this->db->where('reservasi_id', $reservasi_temp['id']);
        $this->db->delete('perjalanan_anggota');

        if ($this->input->post('anggota')) {
            foreach ($this->input->post('anggota') as $a) :
                $karyawan = $this->db->get_where('karyawan', ['inisial' => $a])->row_array();
                $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
                $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
                $this->db->where('jenis_perjalanan', $reservasi_temp['jenis_perjalanan']);
                $this->db->where('gol_id', $karyawan['gol_id']);
                $tunjangan = $this->db->get('perjalanan_tunjangan')->row_array();
                $peserta = [
                    'reservasi_id' => $reservasi_temp['id'],
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
                    'status' => '0'
                ];
                $this->db->insert('perjalanan_anggota', $peserta);
            endforeach;
        }else{
            $this->session->set_flashdata('message', '<div class="col-md-12 alert alert-danger" role="alert">Silahkan tentukan peserta perjalanan anda terlebih dahulu.</div>');
            redirect('reservasi/dl1d');
        }

        // if ($this->input->post('anggota') == null and $this->input->post('ikut') == null) {
        //     $this->session->set_flashdata('message', '<div class="col-md-12 alert alert-danger" role="alert">Silahkan tentukan peserta perjalanan anda terlebih dahulu.</div>');
        //     redirect('reservasi/dl1c1');
        // } elseif ($this->input->post('anggota') == null) {
        //     $dept = $this->db->get_where('karyawan_dept', ['id' => $dataku['dept_id']])->row_array();
        //     $posisi = $this->db->get_where('karyawan_posisi', ['id' => $dataku['posisi_id']])->row_array();
        //     $peserta = [
        //         'reservasi_id' => $reservasi_temp['id'],
        //         'npk' => $dataku['npk'],
        //         'karyawan_inisial' => $dataku['inisial'],
        //         'karyawan_nama' => $dataku['nama'],
        //         'karyawan_dept' => $dept['nama'],
        //         'karyawan_posisi' => $posisi['nama'],
        //         'karyawan_gol' => $dataku['gol_id'],
        //         'status' => '0'
        //     ];
        //     $this->db->insert('perjalanan_anggota', $peserta);
        // } elseif ($this->input->post('ikut') == null) {
        //     foreach ($this->input->post('anggota') as $a) :
        //         $karyawan = $this->db->get_where('karyawan', ['inisial' => $a])->row_array();
        //         $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
        //         $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
        //         $this->db->where('jenis_perjalanan', $reservasi_temp['jenis_perjalanan']);
        //         $this->db->where('gol_id', $karyawan['gol_id']);
        //         $tunjangan = $this->db->get('perjalanan_tunjangan')->row_array();
        //         $peserta = [
        //             'reservasi_id' => $reservasi_temp['id'],
        //             'npk' => $karyawan['npk'],
        //             'karyawan_inisial' => $karyawan['inisial'],
        //             'karyawan_nama' => $karyawan['nama'],
        //             'karyawan_dept' => $dept['nama'],
        //             'karyawan_posisi' => $posisi['nama'],
        //             'karyawan_gol' => $karyawan['gol_id'],
        //             'uang_saku' => $tunjangan['uang_saku'],
        //             'insentif_pagi' => $tunjangan['insentif_pagi'],
        //             'um_pagi' => $tunjangan['um_pagi'],
        //             'um_siang' => $tunjangan['um_siang'],
        //             'um_malam' => $tunjangan['um_malam'],
        //             'total' => '0',
        //             'status' => '0'
        //         ];
        //         $this->db->insert('perjalanan_anggota', $peserta);
        //     endforeach;
        // } else {
        //     $dept1 = $this->db->get_where('karyawan_dept', ['id' => $dataku['dept_id']])->row_array();
        //     $posisi1 = $this->db->get_where('karyawan_posisi', ['id' => $dataku['posisi_id']])->row_array();
        //     $peserta1 = [
        //         'reservasi_id' => $reservasi_temp['id'],
        //         'npk' => $dataku['npk'],
        //         'karyawan_inisial' => $dataku['inisial'],
        //         'karyawan_nama' => $dataku['nama'],
        //         'karyawan_dept' => $dept1['nama'],
        //         'karyawan_posisi' => $posisi1['nama'],
        //         'status' => '0'
        //     ];
        //     $this->db->insert('perjalanan_anggota', $peserta1);

        //     foreach ($this->input->post('anggota') as $a) :
        //         $karyawan = $this->db->get_where('karyawan', ['inisial' => $a])->row_array();
        //         $dept2 = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
        //         $posisi2 = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
        //         $peserta2 = [
        //             'reservasi_id' => $reservasi_temp['id'],
        //             'npk' => $karyawan['npk'],
        //             'karyawan_inisial' => $karyawan['inisial'],
        //             'karyawan_nama' => $karyawan['nama'],
        //             'karyawan_dept' => $dept2['nama'],
        //             'karyawan_posisi' => $posisi2['nama'],
        //             'karyawan_gol' => $karyawan['gol_id'],
        //             'status' => '0'
        //         ];
        //         $this->db->insert('perjalanan_anggota', $peserta2);
        //     endforeach;
        // }

        $tujuan = $this->db->where('reservasi_id', $reservasi_temp['id']);
        $tujuan = $this->db->get_where('perjalanan_tujuan')->result_array();
        $listtujuan = array_column($tujuan, 'inisial');

        $peserta = $this->db->where('reservasi_id', $reservasi_temp['id']);
        $peserta = $this->db->get_where('perjalanan_anggota')->result_array();
        $listpeserta = array_column($peserta, 'karyawan_inisial');

        $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
        //Uang Saku
        if ($reservasi_temp['jenis_perjalanan'] == 'TAPP') {
            $this->db->select_sum('uang_saku');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $query = $this->db->get('perjalanan_anggota');
            $uang_saku = $query->row()->uang_saku;
        } else {
            $uang_saku = 0;
        }

        //Insentif pagi
        if ($reservasi_temp['jamberangkat'] <= $um['um1']) {
            $this->db->select_sum('insentif_pagi');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $query = $this->db->get('perjalanan_anggota');
            $insentif_pagi = $query->row()->insentif_pagi;
        } else {
            $insentif_pagi = 0;
        }

        //Makan Pagi
        if ($reservasi_temp['jenis_perjalanan'] == 'TAPP' and $reservasi_temp['jamberangkat'] <= $um['um2']) {
            $this->db->select_sum('um_pagi');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_pagi = $query->row()->um_pagi;
        } else {
            $um_pagi = 0;
        }

        //Makan Siang
        if ($reservasi_temp['jamberangkat'] <= $um['um3'] and $reservasi_temp['jamkembali'] >= $um['um3']) {
            $this->db->select_sum('um_siang');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_siang = $query->row()->um_siang;
        } else {
            $um_siang = 0;
        }

        //Makan Malam
        if ($reservasi_temp['jamkembali'] >= $um['um4']) {
            $this->db->select_sum('um_malam');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $query = $this->db->get('perjalanan_anggota');
            $um_malam = $query->row()->um_malam;
        } else {
            $um_malam = 0;
        }

        $total =  $uang_saku +  $insentif_pagi +  $um_pagi +  $um_siang +  $um_malam + $this->input->post('taksi') + $this->input->post('bbm') + $this->input->post('tol') + $this->input->post('parkir');
        
        $this->db->set('tujuan', implode(', ', $listtujuan));
        $this->db->set('keperluan', $this->input->post('keperluan'));
        $this->db->set('copro', $this->input->post('copro'));
        $this->db->set('anggota', implode(', ', $listpeserta));
        $this->db->set('uang_saku', $uang_saku);
        $this->db->set('insentif_pagi', $insentif_pagi);
        $this->db->set('um_pagi', $um_pagi);
        $this->db->set('um_siang', $um_siang);
        $this->db->set('um_malam', $um_malam);
        $this->db->set('taksi', $this->input->post('taksi'));
        $this->db->set('bbm', $this->input->post('bbm'));
        $this->db->set('tol', $this->input->post('tol'));
        $this->db->set('parkir', $this->input->post('parkir'));
        $this->db->set('total', $total);
        $this->db->set('catatan', $this->input->post('catatan'));
        $this->db->where('id', $reservasi_temp['id']);
        $this->db->update('reservasi_temp');

        redirect('reservasi/dl1z');
    }

    // Jika menggunakan kendaraan non-operasional
    public function dl1c()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl1c', $data);
        $this->load->view('templates/footer');
    }

    public function dl1c_proses()
    {
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();

        $this->db->set('kepemilikan', 'Non Operasional');
        $this->db->set('kendaraan', $this->input->post('kepemilikan'));
        $this->db->set('nopol', $this->input->post('nopol'));
        $this->db->where('id', $reservasi_temp['id']);
        $this->db->update('reservasi_temp');

        redirect('reservasi/dl1d');
    }

    // public function dl1d()
    // {
    //     $data['sidemenu'] = 'Perjalanan Dinas';
    //     $data['sidesubmenu'] = 'Reservasi';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
    //     $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('reservasi/dl1d', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function dl1d_proses()
    // {
    //     $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $reservasi_temp = $this->db->order_by('id', "DESC");
    //     $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
    // $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
    // //Uang Saku
    // if ($reservasi_temp['jenis_perjalanan'] == 'TAPP') {
    //     $this->db->select_sum('uang_saku');
    //     $this->db->where('reservasi_id', $reservasi_temp['id']);
    //     $query = $this->db->get('perjalanan_anggota');
    //     $uang_saku = $query->row()->uang_saku;
    // } else {
    //     $uang_saku = 0;
    // }

    // //Insentif pagi
    // if ($reservasi_temp['jamberangkat'] <= $um['um1']) {
    //     $this->db->select_sum('insentif_pagi');
    //     $this->db->where('reservasi_id', $reservasi_temp['id']);
    //     $query = $this->db->get('perjalanan_anggota');
    //     $insentif_pagi = $query->row()->insentif_pagi;
    // } else {
    //     $insentif_pagi = 0;
    // }

    // //Makan Pagi
    // if ($reservasi_temp['jenis_perjalanan'] == 'TAPP' and $reservasi_temp['jamberangkat'] <= $um['um2']) {
    //     $this->db->select_sum('um_pagi');
    //     $this->db->where('reservasi_id', $reservasi_temp['id']);
    //     $query = $this->db->get('perjalanan_anggota');
    //     $um_pagi = $query->row()->um_pagi;
    // } else {
    //     $um_pagi = 0;
    // }

    // //Makan Siang
    // if ($reservasi_temp['jamberangkat'] <= $um['um3'] and $reservasi_temp['jamkembali'] >= $um['um3']) {
    //     $this->db->select_sum('um_siang');
    //     $this->db->where('reservasi_id', $reservasi_temp['id']);
    //     $query = $this->db->get('perjalanan_anggota');
    //     $um_siang = $query->row()->um_siang;
    // } else {
    //     $um_siang = 0;
    // }

    // //Makan Malam
    // if ($reservasi_temp['jamkembali'] >= $um['um4']) {
    //     $this->db->select_sum('um_malam');
    //     $this->db->where('reservasi_id', $reservasi_temp['id']);
    //     $query = $this->db->get('perjalanan_anggota');
    //     $um_malam = $query->row()->um_malam;
    // } else {
    //     $um_malam = 0;
    // }
    // $total =  $reservasi_temp['uang_saku'] +  $reservasi_temp['insentif_pagi'] +  $reservasi_temp['um_pagi'] +  $reservasi_temp['um_siang'] +  $reservasi_temp['um_malam'] + $this->input->post('taksi') + $this->input->post('bbm') + $this->input->post('tol') + $this->input->post('parkir');
    // $this->db->set('uang_saku', $uang_saku);
    // $this->db->set('insentif_pagi', $insentif_pagi);
    // $this->db->set('um_pagi', $um_pagi);
    // $this->db->set('um_siang', $um_siang);
    // $this->db->set('um_malam', $um_malam);
    // $this->db->set('taksi', $this->input->post('taksi'));
    // $this->db->set('bbm', $this->input->post('bbm'));
    // $this->db->set('tol', $this->input->post('tol'));
    // $this->db->set('parkir', $this->input->post('parkir'));
    // $this->db->set('total', $total);
    // $this->db->set('pic_perjalanan', $this->input->post('pic'));
    // $this->db->where('id', $reservasi_temp['id']);
    // $this->db->update('reservasi_temp');

    // redirect('reservasi/dl1z');
    // }

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
        date_default_timezone_set('asia/jakarta');
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();

        $queryVal = "SELECT COUNT(*)
                      FROM `reservasi`
                      WHERE `nopol` =  '{$reservasi_temp['nopol']}' AND `tglberangkat` <= '{$reservasi_temp['tglberangkat']}'  AND `tglkembali` >= '{$reservasi_temp['tglberangkat']}' AND `status` != 0 AND `status` != 9
                      ";
        $saring1 = $this->db->query($queryVal)->row_array();
        $total = $saring1['COUNT(*)'];
        if ($total == 0) {

            $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
            $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

            if ($this->session->userdata('dept_id')=='11'){
                $ka_dept = $this->db->get_where('karyawan', ['inisial' => 'ABU'])->row_array();
            }elseif ($this->session->userdata('dept_id')=='14'){
                $ka_dept = $this->db->get_where('karyawan', ['inisial' => 'KKO'])->row_array();
            }else{
                $this->db->where('posisi_id', '3');
                $this->db->where('is_active', '1');
                $this->db->where('dept_id', $this->session->userdata('dept_id'));
                $ka_dept = $this->db->get('karyawan')->row_array();
            }

            $tahun = date("Y", strtotime($reservasi_temp['tglberangkat']));
            $bulan = date("m", strtotime($reservasi_temp['tglberangkat']));
            $this->db->where('year(tglberangkat)', $tahun);
            $this->db->where('month(tglberangkat)', $bulan);
            $rsv = $this->db->get('reservasi');
            $total_rsv = $rsv->num_rows() + 1;
            $id = 'RSV' . date('ym', strtotime($reservasi_temp['tglberangkat'])) . sprintf("%04s", $total_rsv);

            $data = [
                'id' => $id,
                'tglreservasi' => date('Y-m-d H:i:s'),
                'jenis_perjalanan' => $reservasi_temp['jenis_perjalanan'],
                'npk' => $reservasi_temp['npk'],
                'nama' => $reservasi_temp['nama'],
                'tujuan' => $reservasi_temp['tujuan'],
                'copro' => $reservasi_temp['copro'],
                'keperluan' => $reservasi_temp['keperluan'],
                'anggota' => $reservasi_temp['anggota'],
                'pic_perjalanan' => $this->input->post('pic'),
                'tglberangkat' => $reservasi_temp['tglberangkat'],
                'jamberangkat' => $reservasi_temp['jamberangkat'],
                'tglkembali' => $reservasi_temp['tglkembali'],
                'jamkembali' => $reservasi_temp['jamkembali'],
                'kepemilikan' => $reservasi_temp['kepemilikan'],
                'kendaraan' => $reservasi_temp['kendaraan'],
                'nopol' => $reservasi_temp['nopol'],
                'atasan1' => $atasan1['inisial'],
                'atasan2' => $atasan2['inisial'],
                'catatan' => $reservasi_temp['catatan'],
                'uang_saku' => $reservasi_temp['uang_saku'],
                'insentif_pagi' => $reservasi_temp['insentif_pagi'],
                'um_pagi' => $reservasi_temp['um_pagi'],
                'um_siang' => $reservasi_temp['um_siang'],
                'um_malam' => $reservasi_temp['um_malam'],
                'taksi' => $reservasi_temp['taksi'],
                'bbm' => $reservasi_temp['bbm'],
                'tol' => $reservasi_temp['tol'],
                'parkir' => $reservasi_temp['parkir'],
                'total' => $reservasi_temp['total'],
                'div_id' => $this->session->userdata('div_id'),
                'dept_id' => $this->session->userdata('dept_id'),
                'sect_id' => $this->session->userdata('sect_id'),
                'ka_dept' => $ka_dept['nama'],
                'status' => '1',
                'last_notify' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reservasi', $data);

            // update table anggota perjalanan
            $this->db->set('reservasi_id', $data['id']);
            $this->db->set('status', '1');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $this->db->update('perjalanan_tujuan');

            // update table anggota perjalanan
            $this->db->set('reservasi_id', $data['id']);
            $this->db->set('status', '1');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $this->db->update('perjalanan_anggota');

            if ($this->session->userdata('posisi_id') <= 3) {
                if ($reservasi_temp['jenis_perjalanan'] != 'TA') {
                    $this->db->set('atasan1', null);
                    $this->db->set('atasan2', null);
                    $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                    $this->db->set('status', '6');
                    $this->db->where('id', $id);
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
                                'message' =>"*PENGAJUAN PERJALANAN DINAS DLPP*" .
                                "\r\n \r\nNo. Reservasi : *" . $id . "*" .
                                "\r\nNama : *" . $reservasi_temp['nama'] . "*" .
                                "\r\nPeserta : *" . $reservasi_temp['anggota'] . "*" .
                                "\r\nTujuan : *" . $reservasi_temp['tujuan'] . "*" .
                                "\r\nKeperluan : *" . $reservasi_temp['keperluan'] . "*" .
                                "\r\nBerangkat : *" . date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])) . "* _estimasi_" .
                                "\r\nKembali : *" . date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])) . "* _estimasi_" .
                                "\r\nKendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "* )" .
                                "\r\nEstimasi Biaya : *" . $reservasi_temp['total'] . "*" .
                                "\r\n \r\nProses sekarang! https://raisa.winteq-astra.com/perjalanandl/prosesdl1/".$id
                            ],
                        ]
                    );
                    $body = $response->getBody();

                } elseif ($reservasi_temp['jenis_perjalanan'] == 'TA') {
                    //bypass to divhead
                    //Stat 3 Fin Dept Head
                    //Stat 4 Div Head
                    $this->db->set('atasan1', null);
                    $this->db->set('atasan2', null);
                    $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                    $this->db->set('status', '4');
                    $this->db->where('id', $id);
                    $this->db->update('reservasi');

                    $this->db->where('posisi_id', '3');
                    $this->db->where('dept_id', '21');
                    $fin_head = $this->db->get('karyawan')->row_array();

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
                                'message' =>"*PENGAJUAN PERJALANAN DINAS TA*" .
                                "\r\n \r\nNo. Reservasi : *" . $id . "*" .
                                "\r\nNama : *" . $reservasi_temp['nama'] . "*" .
                                "\r\nPeserta : *" . $reservasi_temp['anggota'] . "*" .
                                "\r\nTujuan : *" . $reservasi_temp['tujuan'] . "*" .
                                "\r\nKeperluan : *" . $reservasi_temp['keperluan'] . "*" .
                                "\r\nBerangkat : *" . date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])) . "* _estimasi_" .
                                "\r\nKembali : *" . date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])) . "* _estimasi_" .
                                "\r\nKendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "* )" .
                                "\r\nEstimasi Biaya : *" . $reservasi_temp['total'] . "*" .
                                "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                            ],
                        ]
                    );
                    $body = $response->getBody();
                    
                }
            } else {

                //Kirim pesan via Whatsapp
                $curl = curl_init();

                $message = [
                "messageType"   => "text",
                "to"            => $atasan1['phone'],
                "body"          => " . $id . - PERSETUJUAN PERJALANAN DINAS" .
                "\r\n \r\nPeserta : " . $reservasi_temp['anggota'] . "" .
                "\r\nTujuan : " . $reservasi_temp['tujuan'] . "" .
                "\r\nKeperluan : " . $reservasi_temp['keperluan'] . "" .
                "\r\nBerangkat : " . date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])) . " _estimasi_" .
                "\r\nKembali : " . date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])) . " _estimasi_" .
                "\r\nEstimasi Biaya : " . $reservasi_temp['total'] . 
                "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda.",
                "file"          => "",
                "delay"         => 30,
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
                    'Authorization: 610c04c9-a7e1-4b7e-918c-e9847b643e47'
                ),
                ));
                
                $response = curl_exec($curl);
                curl_close($curl);

                //Kirim Notifikasi ke Atasan1
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
                //             'phone' => $atasan1['phone'],
                //             'message' =>"*PENGAJUAN PERJALANAN DINAS ". $reservasi_temp['jenis_perjalanan'] . "*".
                //             "\r\n \r\nNo. Reservasi : *" . $id . "*" .
                //             "\r\nNama : *" . $reservasi_temp['nama'] . "*" .
                //             "\r\nPeserta : *" . $reservasi_temp['anggota'] . "*" .
                //             "\r\nTujuan : *" . $reservasi_temp['tujuan'] . "*" .
                //             "\r\nKeperluan : *" . $reservasi_temp['keperluan'] . "*" .
                //             "\r\nBerangkat : *" . date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])) . "* _estimasi_" .
                //             "\r\nKembali : *" . date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])) . "* _estimasi_" .
                //             "\r\nKendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "* )" .
                //             "\r\nEstimasi Biaya : *" . $reservasi_temp['total'] . "*" .
                //             "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                //         ],
                //     ]
                // );
                // $body = $response->getBody();
            }

            //delete temporary
            $this->db->where('id', $reservasi_temp['id']);
            $this->db->delete('reservasi_temp');

            $this->session->set_flashdata('message', 'rsvbaru');
            redirect('reservasi');
        } else {
            $this->session->set_flashdata('message', 'rsvgagal');
            redirect('reservasi/dl1a');
        }
    }

    public function dl2a()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl2a', $data);
        $this->load->view('templates/footer');
    }

    public function dl2a_proses()
    {
        $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        date_default_timezone_set('asia/jakarta');
        if (date("Y-m-d", strtotime($this->input->post('tglberangkat'))) < date("Y-m-d")) {
            $this->session->set_flashdata('message', 'backdate');
            redirect('reservasi/dl');
        } else {
            $data = [
                'npk' => $this->session->userdata['npk'],
                'nama' => $dataku['nama'],
                'tglreservasi' => date("Y-m-d H:i:s"),
                'tglberangkat' => date("Y-m-d", strtotime($this->input->post('tglberangkat'))),
                'jamberangkat' => $this->input->post('jamberangkat'),
                'tglkembali' => date("Y-m-d", strtotime($this->input->post('tglberangkat'))),
                'jamkembali' => $this->input->post('jamkembali'),
                'jenis_perjalanan' => 'TAPP'
            ];
            $this->db->insert('reservasi_temp', $data);
            redirect('reservasi/dl1b');
        }
    }

    public function dl3_proses()
    {
        date_default_timezone_set('asia/jakarta');
        if (date("Y-m-d", strtotime($this->input->post('tglberangkat'))) < date("Y-m-d") or date("Y-m-d", strtotime($this->input->post('tglkembali'))) < date("Y-m-d", strtotime($this->input->post('tglberangkat')))) {

            $this->session->set_flashdata('message', 'backdate');
            redirect('reservasi/dl');
            // } elseif (date("Y-m-d", strtotime($this->input->post('tglkembali'))) < date("Y-m-d", strtotime($this->input->post('tglberangkat')))) {

            //     $this->session->set_flashdata('message', 'backdate');
            //     redirect('reservasi/dl');
        } else {
            $dataku = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data = [
                'npk' => $this->session->userdata['npk'],
                'nama' => $dataku['nama'],
                'tglreservasi' => date("Y-m-d H:i:s"),
                'tglberangkat' => date("Y-m-d", strtotime($this->input->post('tglberangkat'))),
                'jamberangkat' => date("H:i", strtotime($this->input->post('tglberangkat'))),
                'tglkembali' => date("Y-m-d", strtotime($this->input->post('tglkembali'))),
                'jamkembali' => date("H:i", strtotime($this->input->post('tglkembali'))),
                'jenis_perjalanan' => 'TA'
            ];
            $this->db->insert('reservasi_temp', $data);
            redirect('reservasi/dl3a');
        }
    }

    public function dl3a()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl3a', $data);
        $this->load->view('templates/footer');
    }

    public function dl3a_proses()
    {
        date_default_timezone_set('asia/jakarta');
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();

        $this->db->where('reservasi_id', $reservasi_temp['id']);
        $this->db->delete('perjalanan_anggota');
        foreach ($this->input->post('anggota') as $a) :
            $karyawan = $this->db->get_where('karyawan', ['inisial' => $a])->row_array();
            $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
            $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
            $peserta = [
                'reservasi_id' => $reservasi_temp['id'],
                'npk' => $karyawan['npk'],
                'karyawan_inisial' => $karyawan['inisial'],
                'karyawan_nama' => $karyawan['nama'],
                'karyawan_dept' => $dept['nama'],
                'karyawan_posisi' => $posisi['nama'],
                'karyawan_gol' => $karyawan['gol_id'],
                'uang_saku' => 0,
                'insentif_pagi' => 0,
                'um_pagi' => 0,
                'um_siang' => 0,
                'um_malam' => 0,
                'total' => 0,
                'status_pembayaran' => 'BELUM DIBAYAR',
                'status' => '0'
            ];
            $this->db->insert('perjalanan_anggota', $peserta);
        endforeach;

        $this->db->where('reservasi_id', $reservasi_temp['id']);
        $this->db->delete('perjalanan_tujuan');
        if ($this->input->post('tujuan')) {
            foreach ($this->input->post('tujuan') as $t) :
                $customer = $this->db->get_where('customer', ['inisial' => $t])->row_array();
                $tujuan = [
                    'reservasi_id' => $reservasi_temp['id'],
                    'inisial' => $customer['inisial'],
                    'nama' => $customer['nama'],
                    'kota' => $customer['kota'],
                    'jarak' => $customer['jarak'],
                    'status' => '0'
                ];
                $this->db->insert('perjalanan_tujuan', $tujuan);
            endforeach;
        }

        if ($this->input->post('tujuan_lain')) {
            $tujuan_lain = [
                'reservasi_id' => $reservasi_temp['id'],
                'inisial' =>  $this->input->post('tujuan_lain'),
                'nama' => $this->input->post('tujuan_lain'),
                'jarak' => '0',
                'status' => '0'
            ];
            $this->db->insert('perjalanan_tujuan', $tujuan_lain);
        }

        if ($this->input->post('penginapan') == null) {
            $penginapan = 'TIDAK';
            $menginap = null;
        } else {
            $penginapan = $this->input->post('penginapan');
            $menginap = $this->input->post('lama');
        }

        if ($this->input->post('checkoperasional') == null) {
            $kendaraan = null;
            $nopol = null;
            $kepemilikan = 'Non Operasional';
        } else {
            if ($this->input->post('kendaraan') == 'Taksi' or $this->input->post('kendaraan') == 'Sewa' or $this->input->post('kendaraan') == 'Pribadi') {
                $nopol = null;
                $kendaraan = $this->input->post('kendaraan');
                $kepemilikan = 'Non Operasional';
            } else {
                $kr = $this->db->get_where('kendaraan', ['nama' => $this->input->post('kendaraan')])->row_array();
                $nopol = $kr['nopol'];
                $kendaraan = $kr['nama'];
                $kepemilikan = 'Operasional';
            }
        }

        $peserta = $this->db->where('reservasi_id', $reservasi_temp['id']);
        $peserta = $this->db->get_where('perjalanan_anggota')->result_array();
        $listpeserta = array_column($peserta, 'karyawan_inisial');

        $tujuan = $this->db->where('reservasi_id', $reservasi_temp['id']);
        $tujuan = $this->db->get_where('perjalanan_tujuan')->result_array();
        $listtujuan = array_column($tujuan, 'inisial');

        $this->db->set('keperluan', $this->input->post('keperluan'));
        $this->db->set('copro', $this->input->post('copro'));
        $this->db->set('anggota', implode(', ', $listpeserta));
        $this->db->set('tujuan', implode(', ', $listtujuan));
        $this->db->set('akomodasi', $this->input->post('akomodasi'));
        $this->db->set('penginapan', $penginapan);
        $this->db->set('lama_menginap', $menginap);
        $this->db->set('kendaraan', $kendaraan);
        $this->db->set('nopol', $nopol);
        $this->db->set('kepemilikan', $kepemilikan);
        $this->db->where('id', $reservasi_temp['id']);
        $this->db->update('reservasi_temp');

        redirect('reservasi/dl3b');
    }

    public function dl3b()
    {
        date_default_timezone_set('asia/jakarta');
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

    public function dl3z()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi_temp'] = $this->db->order_by('id', "DESC");
        $data['reservasi_temp'] = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/dl3z', $data);
        $this->load->view('templates/footer');
    }

    public function dl3z_proses()
    {
        date_default_timezone_set('asia/jakarta');
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();

        $queryVal = "SELECT COUNT(*)
                      FROM `reservasi`
                      WHERE `kepemilikan` != 'Non Operasional' AND `nopol` =  '{$reservasi_temp['nopol']}' AND `tglberangkat` <= '{$reservasi_temp['tglberangkat']}'  AND `tglkembali` >= '{$reservasi_temp['tglberangkat']}' AND `status` != 0 AND `status` != 9
                      ";
        $saring1 = $this->db->query($queryVal)->row_array();
        $total = $saring1['COUNT(*)'];
        if ($total == 0) {

            $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
            $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

            $this->db->where('posisi_id', '3');
            $this->db->where('dept_id', $this->session->userdata('dept_id'));
            $ka_dept = $this->db->get('karyawan')->row_array();

            $tahun = date("Y", strtotime($reservasi_temp['tglberangkat']));
            $bulan = date("m", strtotime($reservasi_temp['tglberangkat']));
            $this->db->where('year(tglberangkat)', $tahun);
            $this->db->where('month(tglberangkat)', $bulan);
            $rsv = $this->db->get('reservasi');
            $total_rsv = $rsv->num_rows() + 1;
            $id = 'RSV' . date('ym', strtotime($reservasi_temp['tglberangkat'])) . sprintf("%04s", $total_rsv);

            $data = [
                'id' => $id,
                'tglreservasi' => date('Y-m-d H:i:s'),
                'jenis_perjalanan' => $reservasi_temp['jenis_perjalanan'],
                'npk' => $reservasi_temp['npk'],
                'nama' => $reservasi_temp['nama'],
                'tujuan' => $reservasi_temp['tujuan'],
                'copro' => $reservasi_temp['copro'],
                'keperluan' => $reservasi_temp['keperluan'],
                'anggota' => $reservasi_temp['anggota'],
                'pic_perjalanan' => $this->input->post('pic'),
                'tujuan' => $reservasi_temp['tujuan'],
                'tglberangkat' => $reservasi_temp['tglberangkat'],
                'jamberangkat' => $reservasi_temp['jamberangkat'],
                'tglkembali' => $reservasi_temp['tglkembali'],
                'jamkembali' => $reservasi_temp['jamkembali'],
                'kepemilikan' => $reservasi_temp['kepemilikan'],
                'kendaraan' => $reservasi_temp['kendaraan'],
                'nopol' => $reservasi_temp['nopol'],
                'akomodasi' => $reservasi_temp['akomodasi'],
                'penginapan' => $reservasi_temp['penginapan'],
                'lama_menginap' => $reservasi_temp['lama_menginap'],
                'atasan1' => $atasan1['inisial'],
                'atasan2' => $atasan2['inisial'],
                'catatan' => $this->input->post('catatan'),
                'div_id' => $this->session->userdata('div_id'),
                'dept_id' => $this->session->userdata('dept_id'),
                'sect_id' => $this->session->userdata('sect_id'),
                'ka_dept' => $ka_dept['nama'],
                'status' => '1',
                'last_notify' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reservasi', $data);

            if ($this->session->userdata('posisi_id') <= 3) {

                $this->db->set('atasan1', null);
                $this->db->set('atasan2', null);
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $data['id']);
                $this->db->update('reservasi');

                $this->db->where('posisi_id', '3');
                $this->db->where('dept_id', '21');
                $fin_head = $this->db->get('karyawan')->row_array();

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
                            'message' =>"*PENGAJUAN PERJALANAN DINAS TA*" .
                            "\r\n \r\nNo. Reservasi : *" . $id . "*" .
                            "\r\nNama : *" . $reservasi_temp['nama'] . "*" .
                            "\r\nPeserta : *" . $reservasi_temp['anggota'] . "*" .
                            "\r\nTujuan : *" . $reservasi_temp['tujuan'] . "*" .
                            "\r\nKeperluan : *" . $reservasi_temp['keperluan'] . "*" .
                            "\r\nAkomodasi : *" . $reservasi_temp['akomodasi'] . "*" .
                            "\r\nPenginapan : *" . $reservasi_temp['penginapan'] . "*" .
                            "\r\nLama Menginap : *" . $reservasi_temp['lama_menginap'] . "*" .
                            "\r\nBerangkat : *" . date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])) . "* _estimasi_" .
                            "\r\nKembali : *" . date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])) . "* _estimasi_" .
                            "\r\nKendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "* )" .
                            "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
            } else {
                //Kirim Notifikasi ke Atasan1
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
                            'message' =>"*PENGAJUAN PERJALANAN DINAS TA*" .
                            "\r\n \r\nNo. Reservasi : *" . $id . "*" .
                            "\r\nNama : *" . $reservasi_temp['nama'] . "*" .
                            "\r\nPeserta : *" . $reservasi_temp['anggota'] . "*" .
                            "\r\nTujuan : *" . $reservasi_temp['tujuan'] . "*" .
                            "\r\nKeperluan : *" . $reservasi_temp['keperluan'] . "*" .
                            "\r\nAkomodasi : *" . $reservasi_temp['akomodasi'] . "*" .
                            "\r\nPenginapan : *" . $reservasi_temp['penginapan'] . "*" .
                            "\r\nLama Menginap : *" . $reservasi_temp['lama_menginap'] . "*" .
                            "\r\nBerangkat : *" . date("d M Y", strtotime($reservasi_temp['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamberangkat'])) . "* _estimasi_" .
                            "\r\nKembali : *" . date("d M Y", strtotime($reservasi_temp['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi_temp['jamkembali'])) . "* _estimasi_" .
                            "\r\nKendaraan : *" . $reservasi_temp['nopol'] . "* ( *" . $reservasi_temp['kepemilikan'] . "* )" .
                            "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();
            }

            // update table peserta perjalanan
            $this->db->set('reservasi_id', $data['id']);
            $this->db->set('status', '1');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $this->db->update('perjalanan_anggota');

            // update table tujuan perjalanan
            $this->db->set('reservasi_id', $data['id']);
            $this->db->set('status', '1');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $this->db->update('perjalanan_tujuan');

            // update table perjalanan jadwal
            $this->db->set('reservasi_id', $data['id']);
            $this->db->set('status', '1');
            $this->db->where('reservasi_id', $reservasi_temp['id']);
            $this->db->update('perjalanan_jadwal');

            //delete temporary
            $this->db->where('id', $reservasi_temp['id']);
            $this->db->delete('reservasi_temp');

            $this->session->set_flashdata('message', 'rsvbaru');
            redirect('reservasi');
        } else {
            $this->session->set_flashdata('message', 'rsvgagal');
            redirect('reservasi/dl3a');
        }
    }

    public function tambahjadwal()
    {
        date_default_timezone_set('asia/jakarta');
        $reservasi_temp = $this->db->order_by('id', "DESC");
        $reservasi_temp = $this->db->get_where('reservasi_temp', ['npk' => $this->session->userdata('npk')])->row_array();

        $tanggal = date("Y-m-d", strtotime($this->input->post('waktu')));
        $tanggal_berangkat = date("Y-m-d", strtotime($reservasi_temp['tglberangkat']));
        $tanggal_kembali = date("Y-m-d", strtotime($reservasi_temp['tglkembali']));

        if ($tanggal >= $tanggal_berangkat and $tanggal <= $tanggal_kembali) {
            if ($this->input->post('transportasi') == 'Lainnya') {
                $transportasi = $this->input->post('transportasi_lain');
            } else {
                $transportasi = $this->input->post('transportasi');
            }
            $jadwal = [
                'reservasi_id' => $this->input->post('id'),
                'berangkat' => $this->input->post('berangkat'),
                'tujuan' => $this->input->post('tujuan'),
                'waktu' => $this->input->post('waktu'),
                'transportasi' => $transportasi,
                'keterangan' => $this->input->post('keterangan'),
                'status' => '0'
            ];
            $this->db->insert('perjalanan_jadwal', $jadwal);

            redirect('reservasi/dl3b');
        } else {
            $this->session->set_flashdata('message', 'backjadwal');
            redirect('reservasi/dl3b');
        }
    }

    public function hapusjadwal($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('perjalanan_jadwal');

        redirect('reservasi/dl3b');
    }

    // public function tambahpeserta()
    // {
    //     $peserta = [
    //         'reservasi_id' => $this->input->post('id'),
    //         'npk' => null,
    //         'karyawan_inisial' => 'MGG',
    //         'karyawan_nama' => $this->input->post('nama'),
    //         'karyawan_dept' => $this->input->post('dept'),
    //         'karyawan_posisi' => 'Magang',
    //         'status' => '0'
    //     ];
    //     $this->db->insert('perjalanan_anggota', $peserta);

    //     $anggota = $this->db->where('reservasi_id', $this->input->post('id'));
    //     $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
    //     $anggotabaru = array_column($anggota, 'karyawan_inisial');

    //     $this->db->set('anggota', implode(', ', $anggotabaru));
    //     $this->db->where('id', $this->input->post('id'));
    //     $this->db->update('reservasi_temp');

    //     redirect('reservasi/dl1z');
    // }

    // public function tambahanggota()
    // {
    //     foreach ($this->input->post('anggota') as $k) :
    //         $karyawan = $this->db->get_where('karyawan', ['npk' => $k])->row_array();
    //         $dept = $this->db->get_where('karyawan_dept', ['id' => $karyawan['dept_id']])->row_array();
    //         $posisi = $this->db->get_where('karyawan_posisi', ['id' => $karyawan['posisi_id']])->row_array();
    //         $data = [
    //             'reservasi_id' => $this->input->post('id'),
    //             'npk' => $k,
    //             'karyawan_inisial' => $karyawan['inisial'],
    //             'karyawan_nama' =>  $karyawan['nama'],
    //             'karyawan_dept' =>  $dept['nama'],
    //             'karyawan_posisi' => $posisi['nama'],
    //             'status' => '0'
    //         ];
    //         $this->db->insert('perjalanan_anggota', $data);
    //     endforeach;

    //     $anggota = $this->db->where('reservasi_id', $this->input->post('id'));
    //     $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
    //     $anggotabaru = array_column($anggota, 'karyawan_inisial');

    //     $this->db->set('anggota', implode(', ', $anggotabaru));
    //     $this->db->where('id', $this->input->post('id'));
    //     $this->db->update('reservasi');

    //     redirect('perjalanandl/prosesta1/' . $this->input->post('id'));
    // }

    public function hapusanggota($id, $inisial)
    {
        $this->db->where('reservasi_id', $id);
        $this->db->where('karyawan_inisial', $inisial);
        $this->db->delete('perjalanan_anggota');

        $anggota = $this->db->where('reservasi_id', $id);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $id);
        $this->db->update('reservasi');

        redirect('perjalanandl/prosesta1/' . $id);
    }

    public function hapuspeserta($id, $inisial)
    {
        $this->db->where('reservasi_id', $id);
        $this->db->where('karyawan_inisial', $inisial);
        $this->db->delete('perjalanan_anggota');

        $anggota = $this->db->where('reservasi_id', $id);
        $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
        $anggotabaru = array_column($anggota, 'karyawan_inisial');

        $this->db->set('anggota', implode(', ', $anggotabaru));
        $this->db->where('id', $id);
        $this->db->update('reservasi_temp');

        $reservasi = $this->db->get_where('reservasi_temp', ['id' => $id])->row_array();
        if ($reservasi['jenis_perjalanan'] == 'TA') {
            redirect('reservasi/dl3z');
        } else {
            redirect('reservasi/dl1d');
        }
    }

    public function batalrsv()
    {
        $this->db->set('status', '0');
        $this->db->set('catatan', $this->input->post('catatan') . " - Dibatalkan oleh " . $this->session->userdata('inisial'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('reservasi');

        $this->session->set_flashdata('message', 'bataldl');
        redirect('reservasi');
    }

    public function status($id)
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Reservasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['id' =>  $id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('reservasi/status', $data);
        $this->load->view('templates/footer');
    }

    public function ta($id)
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['reservasi'] = $this->db->get_where('reservasi', ['id' => $id])->row_array();

        $this->load->view('reservasi/stta', $data);
    }
}
