<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        
        $this->load->model('presensi_model', 'presensi');

        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('date', date('Y-m-d'));
        $complete = $this->db->get('kesehatan')->row_array();

        if (empty($complete)){
            redirect('dashboard/sehat');
        }
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

        // if (date('D') == 'Sat' or date('D') == 'Sun') {
        //     $data['state'] = 'No State for this time';
        // } else {
        //     if (date('H:i') >= '07:00' and date('H:i') <= '08:30') {
        //         $data['state'] = 'C/In';
        //     } elseif (date('H:i') >= '11:30' and date('H:i') <= '13:00') {
        //         $data['state'] = 'C/Rest';
        //     } elseif (date('H:i') >= '16:00' and date('H:i') <= '17:30') {
        //         $data['state'] = 'C/Out';
        //     } else {
        //         $data['state'] = 'No State for this time';
        //     }
        // }

        $data['time'] = date('H:i');

        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/index', $data);
        $this->load->view('templates/footer');
    }

    public function submit()
    {
        date_default_timezone_set('asia/jakarta');
        $id = date('ymd') . $this->session->userdata('npk') . '-' . $this->input->post('state');
        if (date('D') == 'Sat' or date('D') == 'Sun') {
            $day = 'DayOff';
        } else {
            $day = 'WorkDay';
        }
        if (date('H:i') >= '07:00' and date('H:i') <= '08:30') {
            $state = 'C/In';
        } elseif (date('H:i') >= '11:30' and date('H:i') <= '13:00') {
            $state = 'C/Rest';
        } elseif (date('H:i') >= '16:00' and date('H:i') <= '17:30') {
            $state = 'C/Out';
        } else {
            $state = 'notime';
        }

        if ($state != 'notime') {
            if (!empty($this->input->post('loc')) or !empty($this->input->post('lat')) or !empty($this->input->post('lng'))) {
                $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
                if (empty($presensi)) {
                    $data = [
                        'id' => $id,
                        'npk' => $this->session->userdata('npk'),
                        'nama' => $this->session->userdata('nama'),
                        'time' => date('Y-m-d H:i:s'),
                        'state' => $this->input->post('state'),
                        'new_state' => $this->input->post('newstate'),
                        'loc' => $this->input->post('loc'),
                        'lat' => $this->input->post('lat'),
                        'lng' => $this->input->post('lng'),
                        'platform' => $this->input->post('platform'),
                        'div_id' => $this->session->userdata('div_id'),
                        'dept_id' => $this->session->userdata('dept_id'),
                        'sect_id' => $this->session->userdata('sect_id'),
                        'day_state' => $day,
                        'temperature' => $this->input->post('temperature'),
                        'radang' => $this->input->post('radang'),
                        'flu' => $this->input->post('flu'),
                        'sesak' => $this->input->post('sesak'),
                        'condition' => $this->input->post('condition')
                    ];
                    $this->db->insert('presensi', $data);

                    //Work Contract Check
                    if ($this->session->userdata('contract') == 'Direct Labor') {
                        //Presensi 3X Check
                        $tahun = date("Y");
                        $bulan = date("m");
                        $tanggal = date("d");

                        $this->db->where('year(time)', $tahun);
                        $this->db->where('month(time)', $bulan);
                        $this->db->where('day(time)', $tanggal);
                        $this->db->where('npk', $this->session->userdata('npk'));
                        $this->db->where('new_state', 'OFFDAY');
                        $total_presensi = $this->db->get('presensi');
                        if ($total_presensi->num_rows() == 3) {
                            //Jemkerja Check           
                            $this->db->where('year(tglmulai)', $tahun);
                            $this->db->where('month(tglmulai)', $bulan);
                            $this->db->where('day(tglmulai)', $tanggal);
                            $this->db->where('npk', $this->session->userdata('npk'));
                            $jamkerja = $this->db->get('jamkerja')->row_array();
                            if (empty($jamkerja['id'])) {
                                //Insert jamkerja
                                $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

                                $tglmulai = date('Y-m-d 07:30:00');
                                $tglselesai = date('Y-m-d 16:30:00');

                                $this->db->where('year(tglmulai)', $tahun);
                                $this->db->where('month(tglmulai)', $bulan);
                                $hitung_jamkerja = $this->db->get('jamkerja');
                                $total_jamkerja = $hitung_jamkerja->num_rows() + 1;
                                $id_jk = 'WH' . date('ym') . sprintf("%04s", $total_jamkerja);

                                $create = time();
                                $due = strtotime(date('Y-m-d 18:00:00'));
                                $respon = $due - $create;

                                if ($this->session->userdata('posisi_id') == 7) {
                                    $statusjk = '1';
                                } else {
                                    $statusjk = '2';
                                }

                                $data_jk = [
                                    'id' => $id_jk,
                                    'npk' => $this->session->userdata('npk'),
                                    'nama' => $this->session->userdata('nama'),
                                    'tglmulai' => $tglmulai,
                                    'tglselesai' => $tglselesai,
                                    'durasi' => '08:00:00',
                                    'atasan1' => $atasan1['inisial'],
                                    'posisi_id' => $this->session->userdata('posisi_id'),
                                    'div_id' => $this->session->userdata('div_id'),
                                    'dept_id' => $this->session->userdata('dept_id'),
                                    'sect_id' => $this->session->userdata('sect_id'),
                                    'produktifitas' => '0',
                                    'shift' => 'SHIFT2',
                                    'create' => date('Y-m-d H:i:s'),
                                    'respon_create' => $respon,
                                    'status' => $statusjk
                                ];
                                $this->db->insert('jamkerja', $data_jk);

                                //Insert aktivitas
                                $id_akt = date("ymd") . $this->session->userdata('npk') . time();
                                $data_akt = [
                                    'id' => $id_akt,
                                    'npk' => $this->session->userdata('npk'),
                                    'link_aktivitas' => $id_jk,
                                    'jenis_aktivitas' => 'JAM KERJA',
                                    'tgl_aktivitas' => date("Y-m-d"),
                                    'tglmulai' => $tglmulai,
                                    'tglselesai' => $tglselesai,
                                    'kategori' => '3',
                                    'aktivitas' => 'No Loading',
                                    'deskripsi_hasil' => 'Off Day',
                                    'durasi' => 8,
                                    'progres_hasil' => '100',
                                    'dibuat_oleh' => $this->session->userdata('inisial'),
                                    'dept_id' => $this->session->userdata('dept_id'),
                                    'sect_id' => $this->session->userdata('sect_id'),
                                    'contract' => $this->session->userdata('contract'),
                                    'status' => '1'
                                ];
                                $this->db->insert('aktivitas', $data_akt);
                            }
                        }
                    }

                    $this->session->set_flashdata('message', 'clockSuccess');
                } else {
                    $this->session->set_flashdata('message', 'clockSuccess2');
                }
            } else {
                $this->session->set_flashdata('message', 'clockFailed');
            }
        } else {
            $this->session->set_flashdata('message', 'clockFailed');
        }
        redirect('presensi');
    }

    public function clocktime()
    {
        date_default_timezone_set('asia/jakarta');
        
        if (date('D') == 'Sat' or date('D') == 'Sun') {
            $day = 'WEEKEND';
        } else {
            $day = 'WEEKDAY';
        }
        
        if ($this->input->post('state') == 'C/In') {
            $st = '1';
        } elseif ($this->input->post('state') == 'C/Out') {
            $st = '0';
        }
        
        $id = date('ymd') . $this->session->userdata('inisial') . $st;
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

        // if (date('H:i') >= '07:00' and date('H:i') <= '08:30') {
        //     $state = 'C/In';
        // } elseif (date('H:i') >= '11:30' and date('H:i') <= '13:00') {
        //     $state = 'C/Rest';
        // } elseif (date('H:i') >= '16:00' and date('H:i') <= '17:30') {
        //     $state = 'C/Out';
        // } else {
        //     $state = 'notime';
        // }

        // if ($state != 'notime') {
            if (!empty($this->input->post('location')) or !empty($this->input->post('latitude')) or !empty($this->input->post('logitude'))) {
                $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
                if (empty($presensi)) {

                    $config['file_name']            = $id;
                    $config['upload_path']          = './assets/img/presensi/'.date('ym').'/';
                    $config['allowed_types']        = 'jpg|jpeg|png';
                    $config['max_size']             = '5120';

                    if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('foto')) {
                        $data = [
                            'id' => $id,
                            'file_name' => date('ym').'/'.$this->upload->data('file_name'),
                            'npk' => $this->session->userdata('npk'),
                            'nama' => $this->session->userdata('nama'),
                            // 'time' => date('Y-m-d H:i:s'),
                            'state' => $this->input->post('state'),
                            'work_state' => $this->input->post('work_state'),
                            'location' => $this->input->post('location'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude'),
                            'platform' => $this->input->post('platform'),
                            'div_id' => $this->session->userdata('div_id'),
                            'dept_id' => $this->session->userdata('dept_id'),
                            'sect_id' => $this->session->userdata('sect_id'),
                            'atasan1' => $atasan1['inisial'],
                            'day_state' => $day,
                            // 'temperature' => $this->input->post('temperature'),
                            // 'radang' => $this->input->post('radang'),
                            // 'flu' => $this->input->post('flu'),
                            // 'sesak' => $this->input->post('sesak'),
                            'note' => $this->input->post('note')
                        ];
                        $this->db->insert('presensi', $data);

                        $this->session->set_flashdata('message', 'clockSuccess');
                    }else{
                        $this->session->set_flashdata('message', 'clockFailed');
                    }
                    

                    //Work Contract Check
                    // if ($this->session->userdata('contract') == 'Direct Labor') {
                    //     //Presensi 3X Check
                    //     $tahun = date("Y");
                    //     $bulan = date("m");
                    //     $tanggal = date("d");

                    //     $this->db->where('year(time)', $tahun);
                    //     $this->db->where('month(time)', $bulan);
                    //     $this->db->where('day(time)', $tanggal);
                    //     $this->db->where('npk', $this->session->userdata('npk'));
                    //     $this->db->where('new_state', 'OFFDAY');
                    //     $total_presensi = $this->db->get('presensi');
                    //     if ($total_presensi->num_rows() == 3) {
                    //         //Jemkerja Check           
                    //         $this->db->where('year(tglmulai)', $tahun);
                    //         $this->db->where('month(tglmulai)', $bulan);
                    //         $this->db->where('day(tglmulai)', $tanggal);
                    //         $this->db->where('npk', $this->session->userdata('npk'));
                    //         $jamkerja = $this->db->get('jamkerja')->row_array();
                    //         if (empty($jamkerja['id'])) {
                    //             //Insert jamkerja
                    //             $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

                    //             $tglmulai = date('Y-m-d 07:30:00');
                    //             $tglselesai = date('Y-m-d 16:30:00');

                    //             $this->db->where('year(tglmulai)', $tahun);
                    //             $this->db->where('month(tglmulai)', $bulan);
                    //             $hitung_jamkerja = $this->db->get('jamkerja');
                    //             $total_jamkerja = $hitung_jamkerja->num_rows() + 1;
                    //             $id_jk = 'WH' . date('ym') . sprintf("%04s", $total_jamkerja);

                    //             $create = time();
                    //             $due = strtotime(date('Y-m-d 18:00:00'));
                    //             $respon = $due - $create;

                    //             if ($this->session->userdata('posisi_id') == 7) {
                    //                 $statusjk = '1';
                    //             } else {
                    //                 $statusjk = '2';
                    //             }

                    //             $data_jk = [
                    //                 'id' => $id_jk,
                    //                 'npk' => $this->session->userdata('npk'),
                    //                 'nama' => $this->session->userdata('nama'),
                    //                 'tglmulai' => $tglmulai,
                    //                 'tglselesai' => $tglselesai,
                    //                 'durasi' => '08:00:00',
                    //                 'atasan1' => $atasan1['inisial'],
                    //                 'posisi_id' => $this->session->userdata('posisi_id'),
                    //                 'div_id' => $this->session->userdata('div_id'),
                    //                 'dept_id' => $this->session->userdata('dept_id'),
                    //                 'sect_id' => $this->session->userdata('sect_id'),
                    //                 'produktifitas' => '0',
                    //                 'shift' => 'SHIFT2',
                    //                 'create' => date('Y-m-d H:i:s'),
                    //                 'respon_create' => $respon,
                    //                 'status' => $statusjk
                    //             ];
                    //             $this->db->insert('jamkerja', $data_jk);

                    //             //Insert aktivitas
                    //             $id_akt = date("ymd") . $this->session->userdata('npk') . time();
                    //             $data_akt = [
                    //                 'id' => $id_akt,
                    //                 'npk' => $this->session->userdata('npk'),
                    //                 'link_aktivitas' => $id_jk,
                    //                 'jenis_aktivitas' => 'JAM KERJA',
                    //                 'tgl_aktivitas' => date("Y-m-d"),
                    //                 'tglmulai' => $tglmulai,
                    //                 'tglselesai' => $tglselesai,
                    //                 'kategori' => '3',
                    //                 'aktivitas' => 'No Loading',
                    //                 'deskripsi_hasil' => 'Off Day',
                    //                 'durasi' => 8,
                    //                 'progres_hasil' => '100',
                    //                 'dibuat_oleh' => $this->session->userdata('inisial'),
                    //                 'dept_id' => $this->session->userdata('dept_id'),
                    //                 'sect_id' => $this->session->userdata('sect_id'),
                    //                 'contract' => $this->session->userdata('contract'),
                    //                 'status' => '1'
                    //             ];
                    //             $this->db->insert('aktivitas', $data_akt);
                    //         }
                    //     }
                    // }
                } else {
                    $this->session->set_flashdata('message', 'clockSuccess2');
                }
            } else {
                $this->session->set_flashdata('message', 'clockFailed');
            }
        // } else {
        //     $this->session->set_flashdata('message', 'clockFailed');
        // }
        redirect('presensi');
    }

    public function pik()
    {
        date_default_timezone_set('asia/jakarta');

        $data = [
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama')
        ];
        $this->db->insert('idcard', $data);
        redirect('presensi');
    }

    public function data()
    {
        date_default_timezone_set('asia/jakarta');
        if (empty($this->input->post('month'))) {
            $data['bulan'] = date('m');
        } else {
            $data['bulan'] = $this->input->post('month');
        }
        $data['tahun'] = date('Y');
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Data';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/data', $data);
        $this->load->view('templates/footer');
    }

    public function notifikasi($menu)
    {
        date_default_timezone_set('asia/jakarta');

        if ($menu == 'index') {
            $data['sidemenu'] = 'Kehadiran';
            $data['sidesubmenu'] = 'Data';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('presensi/notifikasi', $data);
            $this->load->view('templates/footer');
        } elseif ($menu == 'clin') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'A');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*INFORMASI : REIMBURSE PENGOBATAN MELALUI APLIKASI KESEHATAN ONLINE*" .
                        "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                        "\r\nSelain berkunjung ke klinik atau rumah sakit terdekat, mulai Sekarang kamu bisa melakukan pengobatan (berobat) secara online melalui aplikasi kesehatan seperti halodoc, alodokter, Grab Health dan lainnya." .
                        "\r\n \r\nBiaya akan direimburse oleh *GARDA MEDIKA* dengan prosedur yang mirip seperti berobat di klinik/rs umum." .
                        "\r\nMasih bingung? Syarat dan ketentuan kamu bisa tanyakan langsung ke bagian HR atau pimpinan kerja masing-masing." .
                        "\r\n \r\n*Obat terbaik adalah mencegah sakit*" .
                        "\r\nTetap jaga kesehatan kamu dan keluarga dengan menerapkan pola hidup sehat, selalu menggunakan masker jika keluar rumah, dan rajin mencuci tangan." .
                        "\r\n#DiRumahAja"
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
            endforeach;
            redirect('presensi/notifikasi/index');
        } elseif ($menu == 'clrest') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'B');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*INFORMASI : REIMBURSE PENGOBATAN MELALUI APLIKASI KESEHATAN ONLINE*" .
                        "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                        "\r\nSelain berkunjung ke klinik atau rumah sakit terdekat, mulai Sekarang kamu bisa melakukan pengobatan (berobat) secara online melalui aplikasi kesehatan seperti halodoc, alodokter, Grab Health dan lainnya." .
                        "\r\n \r\nBiaya akan direimburse oleh *GARDA MEDIKA* dengan prosedur yang mirip seperti berobat di klinik/rs umum." .
                        "\r\nMasih bingung? Syarat dan ketentuan kamu bisa tanyakan langsung ke bagian HR atau pimpinan kerja masing-masing." .
                        "\r\n \r\n*Obat terbaik adalah mencegah sakit*" .
                        "\r\nTetap jaga kesehatan kamu dan keluarga dengan menerapkan pola hidup sehat, selalu menggunakan masker jika keluar rumah, dan rajin mencuci tangan." .
                        "\r\n#DiRumahAja"
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
            endforeach;
            redirect('presensi/notifikasi/index');
        } elseif ($menu == 'clout') {
            $this->db->where('is_active', '1');
            $this->db->where('status', '1');
            $this->db->where('group', 'C');
            $karyawan = $this->db->get('karyawan')->result_array();
            foreach ($karyawan as $k) :
                //Notifikasi ke USER
                $postData = array(
                    'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
                    'number' => $k['phone'],
                    'message' => "*INFORMASI : REIMBURSE PENGOBATAN MELALUI APLIKASI KESEHATAN ONLINE*" .
                        "\r\n \r\nSemangat Pagi, Hai *" . $k['nama'] . "*" .
                        "\r\nSelain berkunjung ke klinik atau rumah sakit terdekat, mulai Sekarang kamu bisa melakukan pengobatan (berobat) secara online melalui aplikasi kesehatan seperti halodoc, alodokter, Grab Health dan lainnya." .
                        "\r\n \r\nBiaya akan direimburse oleh *GARDA MEDIKA* dengan prosedur yang mirip seperti berobat di klinik/rs umum." .
                        "\r\nMasih bingung? Syarat dan ketentuan kamu bisa tanyakan langsung ke bagian HR atau pimpinan kerja masing-masing." .
                        "\r\n \r\n*Obat terbaik adalah mencegah sakit*" .
                        "\r\nTetap jaga kesehatan kamu dan keluarga dengan menerapkan pola hidup sehat, selalu menggunakan masker jika keluar rumah, dan rajin mencuci tangan." .
                        "\r\n#DiRumahAja"
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
            endforeach;
            redirect('presensi/notifikasi/index');
        }
    }

    public function peta()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Peta Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/peta', $data);
        $this->load->view('templates/footer');
    }

    public function jsondata()
    {
        date_default_timezone_set('asia/jakarta');

        // $this->db->where('year(time)', date('2020'));
        // $this->db->where('month(time)',date('06'));
        // $this->db->where('day(time)', date('15'));
        $this->db->where('year(time)', date('Y'));
        $this->db->where('month(time)',date('m'));
        $this->db->where('day(time)', date('d'));
        $this->db->where('state', 'C/In');
        $presensi = $this->db->get('presensi')->result_array();
        $output = array();
        foreach ($presensi as $row) {
            $output[] = array(
                $row['nama'].'<br>'.$row['loc'], 
                $row['lat'], 
                $row['lng']
            );
        }

		//output to json format
        echo json_encode($output);
    }

    public function persetujuan($params1=null, $params2=null, $id=null)
    {
        date_default_timezone_set('asia/jakarta');
        if ($params1=='1' and $params2=='list' ){
            $data['sidemenu'] = 'Approval';
            $data['sidesubmenu'] = 'Persetujuan Presensi';
            $data['params1'] = $params1;
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['presensi'] = $this->db->where('status', '1');
            $data['presensi'] = $this->db->get_where('presensi', ['atasan1' => $this->session->userdata('inisial')])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('presensi/persetujuan', $data);
            $this->load->view('templates/footer');
        }elseif ($params1=='1' and $params2=='submit'){
            if (!empty($id)){
                if ($id=='all'){
                    $presensi = $this->db->where('status', '1');
                    $presensi = $this->db->get_where('presensi', ['atasan1' => $this->session->userdata('inisial')])->result_array();

                    foreach ($presensi as $row) :
                        $this->db->set('approved_by', "Disetujui oleh " . $this->session->userdata['inisial']);
                        $this->db->set('approved_at', date('Y-m-d H:i:s'));
                        $this->db->set('status', '2');
                        $this->db->where('id', $row['id']);
                        $this->db->update('presensi');
                    endforeach;
                }else{
                    $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
                    if (!empty($presensi)){
                        $this->db->set('approved_by', "Disetujui oleh " . $this->session->userdata['inisial']);
                        $this->db->set('approved_at', date('Y-m-d H:i:s'));
                        $this->db->set('status', '2');
                        $this->db->where('id', $id);
                        $this->db->update('presensi');
                    }
                }
                $this->session->set_flashdata('message', 'terimakasih');
            }
            redirect('presensi/persetujuan/1/list');
        }elseif ($params1=='2' and $params2=='list' ){
            $data['sidemenu'] = 'HP Presensi';
            $data['sidesubmenu'] = 'Persetujuan Presensi';
            $data['params1'] = $params1;
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['presensi'] = $this->db->get_where('presensi', ['status' => 2])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('presensi/persetujuan', $data);
            $this->load->view('templates/footer');
        }elseif ($params1=='2' and $params2=='submit'){
            if (!empty($id)){
                if ($id=='all'){
                    $presensi = $this->db->get_where('presensi', ['status' => 2])->result_array();

                    foreach ($presensi as $row) :
                        $this->db->set('hr_by', "Disetujui oleh " . $this->session->userdata['inisial']);
                        $this->db->set('hr_at', date('Y-m-d H:i:s'));
                        $this->db->set('status', '9');
                        $this->db->where('id', $row['id']);
                        $this->db->update('presensi');
                    endforeach;
                }else{
                    $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
                    if (!empty($presensi)){
                        $this->db->set('hr_by', "Disetujui oleh " . $this->session->userdata['inisial']);
                        $this->db->set('hr_at', date('Y-m-d H:i:s'));
                        $this->db->set('status', '9');
                        $this->db->where('id', $id);
                        $this->db->update('presensi');
                    }
                }
                $this->session->set_flashdata('message', 'terimakasih');
            }
            redirect('presensi/persetujuan/2/list');
        }else{
            redirect('error404');
        }
    }
}
