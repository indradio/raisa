<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';
//load Spout Library
require_once APPPATH.'third_party/spout/src/Spout/Autoloader/autoload.php';
 
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Cuti extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Cuti_model');
        $this->saldo_update();
        $this->approval_coo();
    }

    public function index()
    {
        $data['sidemenu'] = 'Cuti';
        $data['sidesubmenu'] = 'CutiKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->db->select_sum('saldo');
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('status', 'AKTIF');
        $query = $this->db->get('cuti_saldo');
        $data['saldo_total'] = $query->row()->saldo;
        
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('saldo >', 0);
        $this->db->where('status', 'AKTIF');
        $this->db->order_by('expired', 'ASC');
        $saldo = $this->db->get('cuti_saldo');
        $data['saldo'] = $saldo->result_array();

        $data['cuti'] = $this->db->get_where('cuti', ['npk' => $this->session->userdata('npk')])->result_array();
        $data['kategori'] = $this->db->get_where('cuti_kategori', ['is_active' => '1'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cuti/index', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
        date_default_timezone_set('asia/jakarta');
        $this->load->helper('string');
        $this->load->helper('date');

        $id = 'CT'.date('ym').random_string('alnum',3);
        $cuti1 = new DateTime(date('Y-m-d', strtotime($this->input->post('tgl1'))));
        $cuti2 = new DateTime(date('Y-m-d', strtotime($this->input->post('tgl2'))));
        $day2 = date('D', strtotime($this->input->post('tgl2')));
        
        $daterange  = new DatePeriod($cuti1, new DateInterval('P1D'), $cuti2);
        
        //mendapatkan range antara dua tanggal dan di looping

        $i   = 0;
        $x   = 1;
        $end = 1;

        foreach($daterange as $date){
            $daterange = $date->format("Y-m-d");
            $datetime  = DateTime::createFromFormat('Y-m-d', $daterange);

            //Convert tanggal untuk mendapatkan nama hari
            $day         = $datetime->format('D');

            //Check untuk menghitung yang bukan hari sabtu dan minggu
            if($day!="Sun" && $day!="Sat") {
                
                $x += $end-$i;

                $data = [
                    'cuti_id' => $id,
                    'tgl' => $daterange,
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $this->session->userdata('nama'),
                    'keterangan' => $this->input->post('keterangan'),
                    'status' => '1'
                ];
                $this->db->insert('cuti_detail', $data);
            }

            $end++;
            $i++;
        }    

        if($day2!="Sun" && $day2!="Sat") {
                
            $data = [
                'cuti_id' => $id,
                'tgl' => date('Y-m-d', strtotime($this->input->post('tgl2'))),
                'npk' => $this->session->userdata('npk'),
                'nama' => $this->session->userdata('nama'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => '1'
            ];
            $this->db->insert('cuti_detail', $data);
        }

        $saldo = $this->db->get_where('cuti_saldo', ['id' => $this->input->post('kategori')])->row_array();
        if ($saldo){
            if ($saldo['saldo']<$x){

                $this->db->where('cuti_id', $id);
                $this->db->delete('cuti_detail');

                $this->session->set_flashdata('notify', 'overquota');
                redirect('/cuti');
            }else{
                $kategori = $saldo['kategori'];
                $t = $saldo['saldo_digunakan'] + $x;
                $sisa = $saldo['saldo_awal'] - $t;

                $this->db->set('saldo_digunakan', $t);
                $this->db->set('saldo', $sisa);
                $this->db->where('id', $this->input->post('kategori'));
                $this->db->update('cuti_saldo');

                $this->db->set('kategori', $kategori);
                $this->db->where('cuti_id', $id);
                $this->db->update('cuti_detail');
            }
        }else{
            $searchKategori = $this->db->get_where('cuti_kategori', ['saldo_id' => $this->input->post('kategori')])->row_array();
            $kategori =  $searchKategori['kategori'];

            $this->db->set('kategori', $kategori);
            $this->db->where('cuti_id', $id);
            $this->db->update('cuti_detail');
        }

        $data = [
            'id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama'),
            'tgl1' => date('Y-m-d', strtotime($this->input->post('tgl1'))),
            'tgl2' => date('Y-m-d', strtotime($this->input->post('tgl2'))),
            'lama' => $x,
            'kategori' => $kategori,
            'keterangan' => $this->input->post('keterangan'),
            'saldo_id' => $this->input->post('kategori'),
            'atasan1' => $this->session->userdata('atasan1_inisial'),
            'atasan2' => $this->session->userdata('atasan2_inisial'),
            'sect_id' => $this->session->userdata('sect_id'),
            'dept_id' => $this->session->userdata('dept_id'),
            'div_id' => $this->session->userdata('div_id'),
            'gol_id' => $this->session->userdata('gol_id'),
            'posisi_id' => $this->session->userdata('posisi_id'),
            'contract' => $this->session->userdata('contract'),
            'status' => '1'
        ];
        $this->db->insert('cuti', $data);

        $atasan1 = $this->db->get_where('karyawan', ['inisial' => $this->session->userdata('atasan1_inisial')])->row_array();
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
                    'message' => "*[NOTIF] PENGAJUAN CUTI*" .
                    "\r\n \r\nNama    : *" . $data['nama'] . "*" .
                    "\r\nTanggal  : *" . date('d M Y', strtotime($data['tgl1'])) . "*" .
                    "\r\nLama      : *" . $data['lama'] ." Hari* " .
                    "\r\nKeterangan : *" . $data['keterangan'] . "*" .
                    "\r\nHarap segera respon *Setujui/Batalkan*".
                    "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/approval"
                ],
            ]
        );
        $body = $response->getBody();

        $this->session->set_flashdata('notify', 'success');
        redirect('/cuti');
    }

    public function cancel()
    {
        $id = $this->input->post('id');
        $cuti = $this->db->get_where('cuti', ['id' => $id])->row_array();

        $this->db->set('reject_by', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
        $this->db->set('reject_at', date('Y-m-d H:i:s'));
        $this->db->set('reject_reason', $this->input->post('keterangan'));
        $this->db->set('status', '0');
        $this->db->set('reject_status', $cuti['status']);
        $this->db->where('id', $id);
        $this->db->update('cuti');

        $this->db->set('status', '0');
        $this->db->where('cuti_id', $id);
        $this->db->update('cuti_detail');
        
        $saldo = $this->db->get_where('cuti_saldo', ['id' => $cuti['saldo_id']])->row_array();
        if ($saldo)
        {
            $i = $saldo['saldo_digunakan'] - $cuti['lama'];
            $sisa = $saldo['saldo_awal'] - $i;

            $this->db->set('saldo_digunakan', $i);
            $this->db->set('saldo', $sisa);
            $this->db->where('id', $cuti['saldo_id']);
            $this->db->update('cuti_saldo');
        }

        //Notifikasi ke USER
        $user = $this->db->get_where('karyawan', ['npk' => $cuti['npk']])->row_array();
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
                    'message' => "*[NOTIF] PEMBATALAN CUTI*" .
                    "\r\n \r\nNama : *" . $cuti['nama'] . "*" .
                    "\r\nTanggal : *" . date('d-M', strtotime($cuti['tgl1'])) . "*" .
                    "\r\nLama : *" . $cuti['lama'] ." Hari* " .
                    "\r\nAlasan : *" . $this->input->post('keterangan') . "*" .
                    "\r\n \r\nCuti ini telah *DIBATALKAN oleh ". $this->session->userdata('inisial') ."*".
                    "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/"
                ],
            ]
        );
        $body = $response->getBody();
              
        $this->session->set_flashdata('notify', 'cancel');
        redirect('cuti');
    }

    public function approval()
    {
        $data['sidemenu'] = 'Approval';
        $data['sidesubmenu'] = 'Approval Cuti';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        
        $queryCuti = "SELECT *
        FROM `cuti`
        WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '2') ";
        $data['cuti'] = $this->db->query($queryCuti)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cuti/approval', $data);
        $this->load->view('templates/footer');
    }

    public function approve()
    {
        $id = $this->input->post('id');
        $cuti = $this->db->get_where('cuti', ['id' => $id])->row_array();

        if ($this->session->userdata('inisial') == $cuti['atasan1'])
        {
            $this->db->set('acc_atasan1', 'Disetujui oleh '.$this->session->userdata('inisial'));
            $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
            $this->db->set('status', '2');
            $this->db->where('id', $id);
            $this->db->update('cuti');

            //Notifikasi ke ATASAN 2
            if ($this->session->userdata('inisial') != $cuti['atasan2'])
            {
                $atasan2 = $this->db->get_where('karyawan', ['inisial' => $cuti['atasan2']])->row_array();
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
                            'message' => "*[NOTIF] PENGAJUAN CUTI*" .
                            "\r\n \r\nNama    : *" . $cuti['nama'] . "*" .
                            "\r\nTanggal  : *" . date('d M Y', strtotime($cuti['tgl1'])) . "*" .
                            "\r\nLama      : *" . $cuti['lama'] ." Hari* " .
                            "\r\nKeterangan : *" . $cuti['keterangan'] . "*" .
                            "\r\n \r\nCuti ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/approval"
                        ],
                    ]
                );
                $body = $response->getBody();
            }
        }

        if ($this->session->userdata('inisial') == $cuti['atasan2'])
        {
            $this->db->set('acc_atasan2', 'Disetujui oleh '.$this->session->userdata('inisial'));
            $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
            $this->db->set('status', '3');
            $this->db->where('id', $id);
            $this->db->update('cuti');

            $admin_hr = $this->db->get_where('karyawan_admin', ['sect_id' => '215'])->row_array();
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
                        'phone' => $admin_hr['phone'],
                        'message' => "*[NOTIF] PENGAJUAN CUTI*" .
                        "\r\n \r\nNama    : *" . $cuti['nama'] . "*" .
                        "\r\nTanggal  : *" . date('d M Y', strtotime($cuti['tgl1'])) . "*" .
                        "\r\nLama      : *" . $cuti['lama'] ." Hari* " .
                        "\r\nKeterangan : *" . $cuti['keterangan'] . "*" .
                        "\r\n \r\nCuti ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                        "\r\nHarap segera respon *Setujui/Batalkan*".
                        "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/hr_approval"
                    ],
                ]
            );
            $body = $response->getBody();
        }

        $this->session->set_flashdata('notify', 'approve');
        redirect('cuti/approval');

    }

    public function reject()
    {
        $id = $this->input->post('id');
        $cuti = $this->db->get_where('cuti', ['id' => $id])->row_array();

        $this->db->set('reject_by', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
        $this->db->set('reject_at', date('Y-m-d H:i:s'));
        $this->db->set('reject_reason', $this->input->post('keterangan'));
        $this->db->set('status', '0');
        $this->db->set('reject_status', $cuti['status']);
        $this->db->where('id', $id);
        $this->db->update('cuti');

        $this->db->set('status', '0');
        $this->db->where('cuti_id', $id);
        $this->db->update('cuti_detail');
        
        $saldo = $this->db->get_where('cuti_saldo', ['id' => $cuti['saldo_id']])->row_array();
        if ($saldo)
        {
            $i = $saldo['saldo_digunakan'] - $cuti['lama'];
            $sisa = $saldo['saldo_awal'] - $i;

            $this->db->set('saldo_digunakan', $i);
            $this->db->set('saldo', $sisa);
            $this->db->where('id', $cuti['saldo_id']);
            $this->db->update('cuti_saldo');
        }

        //Notifikasi ke USER
        $user = $this->db->get_where('karyawan', ['npk' => $cuti['npk']])->row_array();
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
                    'message' => "*[NOTIF] PEMBATALAN CUTI*" .
                    "\r\n \r\nNama : *" . $cuti['nama'] . "*" .
                    "\r\nTanggal : *" . date('d-M', strtotime($cuti['tgl1'])) . "*" .
                    "\r\nLama : *" . $cuti['lama'] ." Hari* " .
                    "\r\nAlasan : *" . $this->input->post('keterangan') . "*" .
                    "\r\n \r\nCuti ini telah *DIBATALKAN oleh ". $this->session->userdata('inisial') ."*".
                    "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/"
                ],
            ]
        );
        $body = $response->getBody();
              
        $this->session->set_flashdata('notify', 'reject');
        redirect('cuti/approval');
    }

    public function hr_approval()
    {
        $data['sidemenu'] = 'HR Cuti';
        $data['sidesubmenu'] = 'Approval';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        
        $queryCuti = "SELECT * FROM `cuti` WHERE`status`= '3' ";
        $data['cuti'] = $this->db->query($queryCuti)->result_array();
        
        $last31 = date('Y-m-d', strtotime("-31 day", strtotime(date("Y-m-d"))));
        $querylast31 = "SELECT * FROM `cuti` WHERE `tgl1` >= '{$last31}' AND `status` = '9'";
        $data['last31'] = $this->db->query($querylast31)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cuti/hr/approval', $data);
        $this->load->view('templates/footer');
    }

    public function hr_approve()
    {
        $id = $this->input->post('id');
        $cuti = $this->db->get_where('cuti', ['id' => $id])->row_array();

        $this->db->set('acc_hr', 'Disetujui oleh '.$this->session->userdata('inisial'));
        $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
        $this->db->set('status', '9');
        $this->db->where('id', $id);
        $this->db->update('cuti');

        //Notifikasi ke USER
        $user = $this->db->get_where('karyawan', ['npk' => $cuti['npk']])->row_array();
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
                    'message' => "*[NOTIF] CUTI KAMU TELAH DISETUJUI*" .
                    "\r\n \r\nNama    : *" . $cuti['nama'] . "*" .
                    "\r\nTanggal : *" . date('d M Y', strtotime($cuti['tgl1'])) . "*" .
                    "\r\nLama     : *" . $cuti['lama'] ." Hari* " .
                    "\r\n \r\nCuti kamu telah disetujui.".
                    "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti"
                ],
            ]
        );
        $body = $response->getBody();

        $this->session->set_flashdata('notify', 'approve');
        redirect('cuti/hr_approval');
    }

    public function hr_reject()
    {
        $id = $this->input->post('id');
        $cuti = $this->db->get_where('cuti', ['id' => $id])->row_array();

        $this->db->set('reject_by', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
        $this->db->set('reject_at', date('Y-m-d H:i:s'));
        $this->db->set('reject_reason', $this->input->post('keterangan'));
        $this->db->set('status', '0');
        $this->db->set('reject_status', $cuti['status']);
        $this->db->where('id', $id);
        $this->db->update('cuti');

        $this->db->set('status', '0');
        $this->db->where('cuti_id', $id);
        $this->db->update('cuti_detail');

        $saldo = $this->db->get_where('cuti_saldo', ['id' => $cuti['saldo_id']])->row_array();
        if ($saldo)
        {
            $i = $saldo['saldo_digunakan'] - $cuti['lama'];
            $sisa = $saldo['saldo_awal'] - $i;

            $this->db->set('saldo_digunakan', $i);
            $this->db->set('saldo', $sisa);
            $this->db->where('id', $cuti['saldo_id']);
            $this->db->update('cuti_saldo');
        }

        //Notifikasi ke USER
        $user = $this->db->get_where('karyawan', ['npk' => $cuti['npk']])->row_array();
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
                    'message' => "*[NOTIF] PEMBATALAN CUTI*" .
                    "\r\n \r\nNama : *" . $cuti['nama'] . "*" .
                    "\r\nTanggal : *" . date('d-M', strtotime($cuti['tgl1'])) . "*" . 
                    "\r\nLama : *" . $cuti['lama'] ." Hari* " .
                    "\r\nAlasan : *" . $this->input->post('keterangan') . "*" .
                    "\r\n \r\nCuti ini telah *DIBATALKAN oleh ". $this->session->userdata('inisial') ."*".
                    "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/"
                ],
            ]
        );
        $body = $response->getBody();
              
        $this->session->set_flashdata('notify', 'reject');
        redirect('cuti/hr_approval');
    }

    public function hr_saldo($params=null)
    {
        date_default_timezone_set('asia/jakarta');
        
        if (empty($params)){
            
            $this->saldo_update();

            $data['sidemenu'] = 'HR Cuti';
            $data['sidesubmenu'] = 'Saldo';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                                $this->db->where('is_active', '1');
                                $this->db->where('status', '1');
            $data['allkaryawan'] = $this->db->get('karyawan')->result_array();
            $this->db->select_sum('saldo');
            $this->db->where('status', 'AKTIF');
            $query = $this->db->get('cuti_saldo');
            $data['saldo_aktif'] = $query->row()->saldo;

            $data['saldo'] = $this->db->get('cuti_saldo')->result_array();
            $data['kategori'] = $this->db->get_where('cuti_kategori', ['is_active' => NULL])->result_array();
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('cuti/hr/saldo', $data);
            $this->load->view('templates/footer');
        
        }else{
            
            // Tambah Saldo per Karyawan
            if ($params=='add') {

                $this->load->helper('string');
                $id = date('y').$this->input->post('karyawan').random_string('alnum',3);
                $data = [
                    'id' => $id,
                    'npk' => $this->input->post('karyawan'),
                    'kategori' => $this->input->post('kategori'),
                    'saldo_awal' => $this->input->post('saldo'),
                    'saldo_digunakan' => '0',
                    'saldo' => $this->input->post('saldo'),
                    'valid' => date('Y-m-d', strtotime($this->input->post('valid'))),
                    'expired' => date('Y-m-d', strtotime($this->input->post('expired'))),
                    'keterangan' => $this->input->post('keterangan'),
                    'created_by' => $this->session->userdata('inisial'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => 'AKTIF'
                ];
                $this->db->insert('cuti_saldo', $data);

            // Import Batch Saldo
            }elseif ($params=='import') {
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

                    //looping pembacaat sheet dalam file        
                    foreach ($reader->getSheetIterator() as $sheet) {
                        $numRow = 1;

                        //siapkan variabel array kosong untuk menampung variabel array data
                        $save   = array();

                        //looping pembacaan row dalam sheet
                        foreach ($sheet->getRowIterator() as $row) {

                            if ($numRow > 1) {
                                //ambil cell
                                $cells = $row->getCells();
                                
                                $id = date('y').$cells[0].random_string('alnum',3);
                                $valid = date('Y-m-d',strtotime($cells[4]));
                                $expired = date('Y-m-d',strtotime($cells[5]));

                                $data = array(
                                    'id'                => $id,
                                    'npk'               => $cells[0],
                                    'kategori'          => $cells[1],
                                    'saldo_awal'        => $cells[2],
                                    'saldo_digunakan'   => 0,
                                    'saldo'             => $cells[2],
                                    'keterangan'        => $cells[3],
                                    'valid'             => $valid,
                                    'expired'           => $expired,
                                    'created_at'        => date('Y-m-d H:i:s'),
                                    'created_by'        => $this->session->userdata('inisial'),
                                    'status'            => 'AKTIF'
                                );

                                $searchNPK = $this->db->get_where('karyawan', ['npk' => $cells[0]])->row_array();
                                
                                if ($searchNPK){
                                    //simpan data ke database
                                    $this->db->insert('cuti_saldo', $data);
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
                } else {
                    echo "Error :" . $this->upload->display_errors(); //tampilkan pesan error jika file gagal diupload
                }

            // Edit Saldo belum digunakan
            }elseif ($params=='edit') {

                $this->db->set('valid', date('Y-m-d', strtotime($this->input->post('valid'))));
                $this->db->set('expired', date('Y-m-d', strtotime($this->input->post('expired'))));
                $this->db->set('saldo_awal', $this->input->post('saldo'));
                $this->db->set('saldo', $this->input->post('saldo'));
                $this->db->set('keterangan', $this->input->post('keterangan'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('cuti_saldo');

            // Delete Saldo belum digunakan
            }elseif ($params=='del') {

                $this->db->where('id',$this->input->post('id'));
                $this->db->delete('cuti_saldo');

            }
            redirect('cuti/hr_saldo');
        }
    }

    public function saldo_update()
    {
        date_default_timezone_set('asia/jakarta');
        $today = date('Y-m-d');
        
        $this->db->where('valid <=', $today);
        $this->db->where('expired >=', $today);
        $this->db->where('status !=', 'AKTIF');
        $activated = $this->db->get_where('cuti_saldo')->result();
            foreach ($activated as $row) :
                $this->db->set('status', 'AKTIF');
                $this->db->where('id', $row->id);
                $this->db->update('cuti_saldo');
            endforeach;

        $this->db->where('valid >=', $today);
        $this->db->where('status !=', 'WAITING');
        $waiting = $this->db->get_where('cuti_saldo')->result();
            foreach ($waiting as $row) :
                $this->db->set('status', 'WAITING');
                $this->db->where('id', $row->id);
                $this->db->update('cuti_saldo');
            endforeach;

        $this->db->where('expired <=', $today);
        $this->db->where('status !=', 'EXPIRED');
        $expired = $this->db->get_where('cuti_saldo')->result();
            foreach ($expired as $row) :
                $this->db->set('status', 'EXPIRED');
                $this->db->where('id', $row->id);
                $this->db->update('cuti_saldo');
            endforeach;

    }

    public function hr_report()
    {
        date_default_timezone_set('asia/jakarta');
        
        $data['sidemenu'] = 'HR Cuti';
        $data['sidesubmenu'] = 'Laporan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        
        if($this->input->post('bulan')){
            $data['tahun'] = $this->input->post('tahun');
            $data['bulan'] = $this->input->post('bulan');
        }else{
            $data['tahun'] = date('Y');
            $data['bulan'] = date('m');
        }
        
        $this->db->where('year(tgl1)', $data['tahun']);
        $this->db->where('month(tgl1)', $data['bulan']);
        $this->db->where('status >', 0);
        $data['cuti'] = $this->db->get_where('cuti')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cuti/report/lap-index', $data);
        $this->load->view('templates/footer');
    }

    public function qna()
    {       
        $data['sidemenu'] = 'Cuti';
        $data['sidesubmenu'] = 'Q&A';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cuti/qna', $data);
        $this->load->view('templates/footer');
    }

    public function approval_coo()
    {
        date_default_timezone_set('asia/jakarta');
        $today = date('Y-m-d');
        $admin_hr = $this->db->get_where('karyawan_admin', ['sect_id' => '215'])->row_array();
        
        
        $this->db->where('tgl1 >=', $today);
        $this->db->where('atasan1', 'DNO');
        $this->db->where('status', '1');
        $outstanding1 = $this->db->get_where('cuti')->result();
            foreach ($outstanding1 as $row) :
                $this->db->set('acc_atasan1', 'Disetujui oleh DNO');
                $this->db->set('tgl_atasan1', date('Y-m-d H:i:s'));
                $this->db->set('acc_atasan2', 'Disetujui oleh DNO');
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '3');
                $this->db->where('id', $row->id);
                $this->db->update('cuti');

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
                            'phone' => $admin_hr['phone'],
                            'message' => "*[NOTIF] PENGAJUAN CUTI*" .
                            "\r\n \r\nNama    : *" . $row->nama . "*" .
                            "\r\nTanggal  : *" . date('d M Y', strtotime($row->tgl1)) . "*" .
                            "\r\nLama      : *" . $row->lama ." Hari* " .
                            "\r\nKeterangan : *" . $row->keterangan . "*" .
                            "\r\n \r\nCuti ini telah DISETUJUI oleh DNO (by System)".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/hr_approval"
                        ],
                    ]
                );
                $body = $response->getBody();
            endforeach;

        $this->db->where('tgl1 <=', $today);
        $this->db->where('atasan2', 'DNO');
        $this->db->where('status', '2');
        $outstanding1 = $this->db->get_where('cuti')->result();
            foreach ($outstanding1 as $row) :
                $this->db->set('acc_atasan2', 'Disetujui oleh DNO');
                $this->db->set('tgl_atasan2', date('Y-m-d H:i:s'));
                $this->db->set('status', '3');
                $this->db->where('id', $row->id);
                $this->db->update('cuti');

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
                            'phone' => $admin_hr['phone'],
                            'message' => "*[NOTIF] PENGAJUAN CUTI*" .
                            "\r\n \r\nNama    : *" . $row->nama . "*" .
                            "\r\nTanggal  : *" . date('d M Y', strtotime($row->tgl1)) . "*" .
                            "\r\nLama      : *" . $row->lama ." Hari* " .
                            "\r\nKeterangan : *" . $row->keterangan . "*" .
                            "\r\n \r\nCuti ini telah DISETUJUI oleh DNO (by System)".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/cuti/hr_approval"
                        ],
                    ]
                );
                $body = $response->getBody();
                
            endforeach;

    }

}
