<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';
//load Spout Library
require_once APPPATH.'third_party/spout/src/Spout/Autoloader/autoload.php';
 
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        
        $this->load->model('Presensi_model');
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

        $tahun      = date("Y");
        $bulan      = date("m");
        $tanggal    = date("d");

        $this->load->helper('url');

        // if (date('H:i') >= '06:00' and date('H:i') <= '08:00') {
        //     $flag = 'Check In';
        // } elseif (date('H:i') >= '11:00' and date('H:i') <= '14:00') {
        //     $flag = 'Rest Time';
        // } elseif (date('H:i') >= '17:00' and date('H:i') <= '19:00') {
        //     $flag = 'Check Out';
        // } else {
        //     $flag = 'notime';
        // }
        // $data['flag'] = $flag;

        $this->db->where('year(time)',$tahun);
        $this->db->where('month(time)',$bulan);
        $this->db->where('day(time)',$tanggal);
        $this->db->where('npk',$this->session->userdata('npk'));
        $this->db->where('state','C/In');
        $presensi = $this->db->get('presensi')->row_array();
        
        if (!empty($presensi)) {
            $data['workstate'] = $presensi['work_state'];
        } else {
            $data['workstate'] = 'not found';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/index', $data);
        $this->load->view('templates/footer');
    }

    public function submit()
    {
        date_default_timezone_set('asia/jakarta');
        $tahun      = date("Y");
        $bulan      = date("m");
        $tanggal    = date("d");

        // Day Check
        if (date('D') == 'Sat' or date('D') == 'Sun') {
            $day = 'LIBUR';
        } else {
            $day = 'KERJA';
        }
        
        //State convert to Decimal
        ($this->input->post('state') == 'In') ? $state = '1' : $state = '0';
        
        $id = date('ymd') . $this->session->userdata('inisial') . $state;
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

        if (!empty($this->input->post('location')) or !empty($this->input->post('latitude')) or !empty($this->input->post('longitude'))) {
            $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
            if (empty($presensi)) {
                $data = [
                    // 'id'            => $id,
                    'date'          => date('Y-m-d'),
                    'npk'           => $this->session->userdata('npk'),
                    'nama'          => $this->session->userdata('nama'),
                    'state'         => $this->input->post('state'),
                    'work_state'    => $this->input->post('workstate'),
                    'location'      => $this->input->post('location'),
                    'latitude'      => $this->input->post('latitude'),
                    'longitude'     => $this->input->post('longitude'),
                    'platform'      => $this->input->post('platform'),
                    'div_id'        => $this->session->userdata('div_id'),
                    'dept_id'       => $this->session->userdata('dept_id'),
                    'sect_id'       => $this->session->userdata('sect_id'),
                    'atasan1'       => $atasan1['inisial'],
                    'day_state'     => $day,
                    'status'        => '1',
                    'description'   => $this->input->post('description')
                ];

                $this->db->insert('presensi', $data);

                //Notifikasi ke USER
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
                            'message' => "*ABSENSI ONLINE*" .
                            "\r\n \r\n*" . $this->session->userdata('nama') . "* membutuhkan approval anda untuk absensinya sebagai berikut :" .
                            "\r\nWaktu : *" . date('d M Y H:i') . "*" .
                            "\r\nShift : *" . $this->input->post('workstate') . "*" .
                            "\r\nStatus : *" . $this->input->post('state') . "*" .
                            "\r\nLokasi : *" . $this->input->post('location') . "*" .
                            "\r\n \r\nSegera APPROVE/REJECT agar dapat diproses oleh HR." .
                            "\r\n#Comeback Stronger!"
                        ],
                    ]
                );
                $body = $response->getBody();

                $this->session->set_flashdata('message', 'clockSuccess');
            } else {
                $this->session->set_flashdata('message', 'clockSuccess2');
            }
        } else {
            $this->session->set_flashdata('message', 'clockFailed');
        }
        
        redirect('presensi');
    }

    public function clockin()
    {
        date_default_timezone_set('asia/jakarta');
        $tahun      = date("Y");
        $bulan      = date("m");
        $tanggal    = date("d");
        
        if (date('D') == 'Sat' or date('D') == 'Sun') {
            $day = 'WEEKEND';
        } else {
            $day = 'WEEKDAY';
        }
        
        if ($this->input->post('workstate') == 'SHIFT') {
            $ws = $this->input->post('shift');
        } else {
            $ws = $this->input->post('workstate');
        }
        
        $id = date('ymd') . $this->session->userdata('inisial') . 'I';
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

            if (!empty($this->input->post('location')) or !empty($this->input->post('latitude')) or !empty($this->input->post('logitude'))) {
                $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
                if (empty($presensi)) {

                $data = [
                    // 'id' => $id,
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $this->session->userdata('nama'),
                    'state' => "C/In",
                    'work_state' => $ws,
                    'location' => $this->input->post('location'),
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'platform' => $this->input->post('platform'),
                    'div_id' => $this->session->userdata('div_id'),
                    'dept_id' => $this->session->userdata('dept_id'),
                    'sect_id' => $this->session->userdata('sect_id'),
                    'atasan1' => $atasan1['inisial'],
                    'day_state' => $day,
                    'description' => $this->input->post('description')
                ];
                $this->db->insert('presensi', $data);

                $this->session->set_flashdata('message', 'clockSuccess');

            }else{
                $this->session->set_flashdata('message', 'clockFailed');
            }
        } else {
            $this->session->set_flashdata('message', 'clockSuccess2');
        }

        redirect('presensi');
    }

    public function clocktime()
    {
        date_default_timezone_set('asia/jakarta');
        $tahun      = date("Y");
        $bulan      = date("m");
        $tanggal    = date("d");
        
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

            if (!empty($this->input->post('location')) or !empty($this->input->post('latitude')) or !empty($this->input->post('logitude'))) {
                $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
                if (empty($presensi)) {

                    $config['file_name']            = $id;
                    $config['upload_path']          = './assets/img/presensi/'.date('ym').'/';
                    $config['allowed_types']        = 'jpg|jpeg|png';
                    // $config['max_size']             = '5120';

                    if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('foto')) {
                        $data = [
                            // 'id' => $id,
                            'file_name' => date('ym').'/'.$this->upload->data('file_name'),
                            'npk' => $this->session->userdata('npk'),
                            'nama' => $this->session->userdata('nama'),
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
                            'note' => $this->input->post('note')
                        ];
                        $this->db->insert('presensi', $data);

                        $this->session->set_flashdata('message', 'clockSuccess');

                        // Work Contract Check for Off
                        if ($this->session->userdata('contract') == 'Direct Labor' and $this->input->post('state') == 'C/Out' and $this->input->post('work_state')=='OFF') {
                
                            $this->db->where('year(time)', $tahun);
                            $this->db->where('month(time)', $bulan);
                            $this->db->where('day(time)', $tanggal);
                            $this->db->where('npk', $this->session->userdata('npk'));
                            $this->db->where('state', 'C/In');
                            $this->db->where('work_state', 'OFF');
                            $presensiOff = $this->db->get('presensi')->row_array();
                            if ($presensiOff) {
                                //Jemkerja Check           
                                $this->db->where('year(tglmulai)', $tahun);
                                $this->db->where('month(tglmulai)', $bulan);
                                $this->db->where('day(tglmulai)', $tanggal);
                                $this->db->where('npk', $this->session->userdata('npk'));
                                $jamkerja = $this->db->get('jamkerja')->row_array();
                                if (empty($jamkerja)) {
                                    
                                    //Insert jamkerja
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

                        // Work Contract Check for Isoman
                        if ($this->session->userdata('contract') == 'Direct Labor' and $this->input->post('state') == 'C/Out' and $this->input->post('work_state')=='ISOMAN') {

                            $this->db->where('year(time)', $tahun);
                            $this->db->where('month(time)', $bulan);
                            $this->db->where('day(time)', $tanggal);
                            $this->db->where('npk', $this->session->userdata('npk'));
                            $this->db->where('state', 'C/In');
                            $this->db->where('work_state', 'ISOMAN');
                            $presensiOff = $this->db->get('presensi')->row_array();
                            if ($presensiOff) {
                                //Jemkerja Check           
                                $this->db->where('year(tglmulai)', $tahun);
                                $this->db->where('month(tglmulai)', $bulan);
                                $this->db->where('day(tglmulai)', $tanggal);
                                $this->db->where('npk', $this->session->userdata('npk'));
                                $jamkerja = $this->db->get('jamkerja')->row_array();
                                if (empty($jamkerja)) {
                                    
                                    //Insert jamkerja
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
                                        'aktivitas' => 'Sakit',
                                        'deskripsi_hasil' => 'Isolasi Mandiri Covid-19',
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

                    }else{
                        $this->session->set_flashdata('message', 'clockFailed');
                    }
                } else {
                    $this->session->set_flashdata('message', 'clockSuccess2');
                }
            } else {
                $this->session->set_flashdata('message', 'clockFailed');
            }
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
                $row['nama'].'<br>'.$row['location'], 
                $row['latitude'], 
                $row['longitude']
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
                if ($this->input->post('id')=='all'){
                        $this->db->set('approved_by', "Disetujui oleh " . $this->session->userdata['inisial']);
                        $this->db->set('approved_at', date('Y-m-d H:i:s'));
                        $this->db->set('status', '9');
                        $this->db->where('atasan1', $this->session->userdata['inisial']);
                        $this->db->where('status', '1');
                        $this->db->update('presensi');
                }else{
                    // $presensi = $this->db->get_where('presensi', ['id' => $this->input->post('id')])->row_array();
                    // if (!empty($presensi)){
                        $this->db->set('approved_by', "Disetujui oleh " . $this->session->userdata['inisial']);
                        $this->db->set('approved_at', date('Y-m-d H:i:s'));
                        $this->db->set('status', '9');
                        $this->db->where('id', $this->input->post('id'));
                        $this->db->update('presensi');
                    // }
                }
                // $this->session->set_flashdata('message', 'terimakasih');
                // redirect('presensi/persetujuan/1/list');
        // }elseif ($params1=='2' and $params2=='list' ){
        //     $data['sidemenu'] = 'HP Presensi';
        //     $data['sidesubmenu'] = 'Persetujuan Presensi';
        //     $data['params1'] = $params1;
        //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        //     $data['presensi'] = $this->db->get_where('presensi', ['status' => 2])->result_array();
        //     $this->load->view('templates/header', $data);
        //     $this->load->view('templates/sidebar', $data);
        //     $this->load->view('templates/navbar', $data);
        //     $this->load->view('presensi/persetujuan', $data);
        //     $this->load->view('templates/footer');
        // }elseif ($params1=='2' and $params2=='submit'){
        //     if (!empty($id)){
        //         if ($id=='all'){
        //             $presensi = $this->db->get_where('presensi', ['status' => 2])->result_array();

        //             foreach ($presensi as $row) :
        //                 $this->db->set('hr_by', "Disetujui oleh " . $this->session->userdata['inisial']);
        //                 $this->db->set('hr_at', date('Y-m-d H:i:s'));
        //                 $this->db->set('status', '9');
        //                 $this->db->where('id', $row['id']);
        //                 $this->db->update('presensi');
        //             endforeach;
        //         }else{
        //             $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
        //             if (!empty($presensi)){
        //                 $this->db->set('hr_by', "Disetujui oleh " . $this->session->userdata['inisial']);
        //                 $this->db->set('hr_at', date('Y-m-d H:i:s'));
        //                 $this->db->set('status', '9');
        //                 $this->db->where('id', $id);
        //                 $this->db->update('presensi');
        //             }
        //         }
        //         $this->session->set_flashdata('message', 'terimakasih');
        //     }
        //     redirect('presensi/persetujuan/2/list');
        }else{
            redirect('error404');
        }
    }

    public function GET_MY_IN()
    {
        // Our Start and End Dates
        $events = $this->Presensi_model->GET_MY_IN();
        $data_events = array();

        foreach ($events->result() as $r) {
            $out = $this->Presensi_model->GET_MY_OUT($r->date)->row();
            if (empty($out)){
                $end = $r->time;
            }else{
                $end = $out->time;
            }

            $data_events[] = array(
                "id" => $r->id,
                "title" => $r->work_state,
                "start" => $r->time,
                "end" => $end
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
    }

    public function upload($params=null)
    {
        date_default_timezone_set('asia/jakarta');
        if ($params==null){
            $data['sidemenu'] = 'HR Presensi';
            $data['sidesubmenu'] = 'Upload Data';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('presensi/upload', $data);
            $this->load->view('templates/footer');
        }elseif ($params=='import'){
            //  ketika button submit diklik
            //  if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './assets/temp_excel/'; //siapkan path untuk upload file
            $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
            $config['file_name']        = 'import_' . time(); //rename file yang diupload

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('data')) {
                $this->load->helper('string');

                //fetch data upload
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader(); //buat xlsx reader
                $reader->open('./assets/temp_excel/' . $file['file_name']); //open file xlsx yang baru saja diunggah

                //looping pembaca sheet dalam file        
                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;

                    //siapkan variabel array kosong untuk menampung variabel array data
                    $save   = array();

                    //looping pembacaan row dalam sheet
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {
                            //ambil cell
                            $cells = $row->getCells();

                            $person = $this->db->get_where('karyawan', ['npk' => $cells[0]])->row();
                            $id = date('ymd').$cells[0].random_string('alnum',3);
                            $date = date('Y-m-d',strtotime($cells[1]));
                            $time = date('Y-m-d H:i:s',strtotime($cells[1]));
                            
                            if (date('D', strtotime($this->input->post('tglmulai'))) == 'Sat' OR date('D', strtotime($this->input->post('tglmulai'))) == 'Sun') 
                            {
                                $hari = 'LIBUR';
                            }else{
                                $event = $this->db->get_where('calendar_event_details', ['date' => date('Y-m-d', strtotime($this->input->post('tglmulai')))])->row_array();
                                if (empty($event))
                                {
                                    $hari = 'KERJA';
                                }else{
                                    $hari = $event['category'];
                                }
                            }

                            if ($person)
                            {

                                $data = array(
                                    'id'            => $id,
                                    'date'          => $date,
                                    'time'          => $time,
                                    'npk'           => $cells[0],
                                    'nama'          => $person->nama,
                                    'state'         => $cells[2],
                                    'work_state'    => $cells[3],
                                    'div_id'        => $person->div_id,
                                    'dept_id'       => $person->dept_id,
                                    'sect_id'       => $person->sect_id,
                                    'approved_at'   => date('Y-m-d H:i:s'),
                                    'approved_by'   => $this->session->userdata('inisial'),
                                    'hr_at'         => date('Y-m-d H:i:s'),
                                    'hr_by'         => $this->session->userdata('inisial'),
                                    'status'        => '1'
                                );
                         
                                //simpan data ke database
                                $this->db->insert('presensi', $data);
                            }
                        }

                        $numRow++;
                    }
                    //simpan data ke database all
                    // $this->db->insert_batch('project', $save);

                    //tutup spout reader
                    $reader->close();

                    //hapus file yang sudah diupload
                    unlink('./assets/temp_excel/' . $file['file_name']);

                    //tampilkan pesan success dan redirect ulang ke index controller import
                    echo    '<script type="text/javascript">
                            alert(\'Data berhasil disimpan\');
                            window.location.replace("' . base_url() . '");
                        </script>';
                }
            }
            redirect('presensi/upload');
        }
    }

    public function get_data($params=null)
    {
        if ($params=='today')
        {
            if ($this->session->userdata('posisi_id') == 1){
                $this->db->where('date', date('Y-m-d'));
                $this->db->order_by('time', 'DESC');
                $presensi = $this->db->get('presensi')->result();
            }elseif ($this->session->userdata('posisi_id') == 2) {
                $this->db->where('date', date('Y-m-d'));
                $this->db->where('div_id', $this->session->userdata('div_id'));
                $this->db->order_by('time', 'DESC');
                $presensi = $this->db->get('presensi')->result();
            }elseif ($this->session->userdata('posisi_id') == 3 or $this->session->userdata('posisi_id') == 4) {
                $this->db->where('date', date('Y-m-d'));
                $this->db->where('dept_id', $this->session->userdata('dept_id'));
                $this->db->order_by('time', 'DESC');
                $presensi = $this->db->get('presensi')->result();
            }elseif ($this->session->userdata('posisi_id') == 7) {
                $this->db->where('date', date('Y-m-d'));
                $this->db->where('sect_id', $this->session->userdata('sect_id'));
                $this->db->order_by('time', 'DESC');
                $presensi = $this->db->get('presensi')->result();
            }else {
                $this->db->where('date', date('Y-m-d'));
                $this->db->where('atasan1', $this->session->userdata('inisial'));
                $this->db->order_by('time', 'DESC');
                $presensi = $this->db->get('presensi')->result();
            }
            
            if (!empty($presensi))
            {
                foreach ($presensi as $row) {

                if ($row->state == "In"){
                    $state = "<button class='btn btn-link btn-success'><i class='fa fa-sign-in'></i> Masuk<div class='ripple-container'></div></button>";
                }else{
                    $state = "<button class='btn btn-link btn-danger'><i class='fa fa-sign-out'></i> Pulang<div class='ripple-container'></div></button>";
                }
                    $output['data'][] = array(
                        "name" => $row->nama,
                        "time" => date('H:i', strtotime($row->time)),
                        "shift" => $row->work_state,
                        "status" => $state
                    );
                }
            }else{
                $output['data'][] = array(
                    "name" => '',
                    "time" => 'There are no data to display.',
                    "shift" => '',
                    "status" => ''
                );
            }

            echo json_encode($output);
            exit();

        } elseif ($params=='monthly')
        {
            $this->db->where('year(time)', $this->input->post('tahun'));
            $this->db->where('month(time)', $this->input->post('bulan'));
            $this->db->order_by('time', 'DESC');
            $presensi = $this->db->get('presensi')->result();
    
            foreach ($presensi as $row) {
                $output['data'][] = array(
                    "id" => $row->id,
                    "npk" => $row->npk,
                    "name" => $row->nama,
                    "date" => date('d-m-Y', strtotime($row->time)),
                    "time" => date('H:i', strtotime($row->time)),
                    "shift" => $row->work_state,
                    "status" => $row->state
                );
            }
            
            echo json_encode($output);
            exit();
        }elseif ($params=='persetujuan')
        {
            // if ($this->session->userdata('posisi_id')=='2')
            // {
            //     $this->db->where('div_id', $this->session->userdata('div_id'));
            //     $this->db->where('status', '1');
            //     $this->db->order_by('time', 'ASC');
            // } elseif ($this->session->userdata('posisi_id')=='3')
            // {
            //     $this->db->where('dept_id', $this->session->userdata('dept_id'));
            //     $this->db->where('status', '1');
            //     $this->db->order_by('time', 'ASC');
            // } elseif ($this->session->userdata('posisi_id')=='5' or $this->session->userdata('posisi_id')=='6')
            // {
            //     $this->db->where('sect_id', $this->session->userdata('sect_id'));
            //     $this->db->where('status', '1');
            //     $this->db->order_by('time', 'ASC');
            // } else {
                $this->db->where('status', '1');
                $this->db->where('atasan1', $this->session->userdata('inisial'));
                $this->db->order_by('time', 'ASC');
            // }

            $presensi = $this->db->get('presensi')->result();

            if (!empty($presensi)){
    
                foreach ($presensi as $row) {
                    $output['data'][] = array(
                        "nama" => $row->nama,
                        "date" => date('d-m-Y', strtotime($row->time)),
                        "time" => date('H:i', strtotime($row->time)),
                        "flag" => $row->state,
                        "shift" => $row->work_state,
                        "catatan" => $row->description,
                        "action" => "<button type='button' class='btn btn-success btn-link btn-just-icon' data-toggle='modal' data-target='#approveAbsen' data-id='".$row->id."'><i class='material-icons'>check</i></button>
                                     <button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#rejectAbsen' data-id='".$row->id."'><i class='material-icons'>clear</i></button>"
                    );
                }

            } else {
                $output['data'][] = array(
                    "nama" => "",
                    "date" => "",
                    "time" => "",
                    "flag" => "Empty",
                    "shift" => "",
                    "catatan" => "",
                    "action" => ""
                );
            }
            
            echo json_encode($output);
            exit();
        }
        
    }
}
