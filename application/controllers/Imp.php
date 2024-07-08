<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Imp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('asia/jakarta');
        is_logged_in();
    }

    public function index()
    {    
        // Halaman dashboard
        $data['sidemenu'] = 'IMP';
        $data['sidesubmenu'] = 'IMPKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $data['kategori'] = $this->db->get('imp_kategori')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('imp/index', $data);
        $this->load->view('templates/footer');
    }

    public function submit($params)
    {
        date_default_timezone_set('asia/jakarta');
        $this->load->helper('string');
        $this->load->helper('date');
        if ($params=='add')
        {
            // validasi
            $day = date('D', strtotime($this->input->post('date')));
            if($day=='Sun' || $day =='Sat') {
                $this->session->set_flashdata('notify', 'weekend');
                redirect('/imp');
            }

            if(date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$this->input->post('start_time'))) < date('Y-m-d H:i:s')){
                $this->session->set_flashdata('notify', 'range');
                redirect('/imp');
            }        

            if($this->input->post('start_time') > $this->input->post('end_time')){
                $this->session->set_flashdata('notify', 'over');
                redirect('/imp');
            }   

            if($this->input->post('category') =='IMP2' && date('H:i:s', strtotime($this->input->post('end_time'))) > date('11:30:00')){
                $this->session->set_flashdata('notify', 'maxi');
                redirect('/imp');
            }

            if($this->input->post('category') =='IMP3' && date('H:i:s', strtotime($this->input->post('start_time'))) < date('11:00:00')){
                $this->session->set_flashdata('notify', 'maxi');
                redirect('/imp');
            }

            $id = 'IMP'.date('ym').random_string('alnum',2);
            $imp = $this->db->get_where('imp', ['id' => $id])->row();
            if ($imp){
                $id = 'IMP'.date('y').random_string('alnum',4);
            }

            $start_time = strtotime(date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$this->input->post('start_time'))));
            $end_time = strtotime(date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$this->input->post('end_time'))));
            
            //Jika hari jumat masuk jam 07:00
            if($day=='Fri' && $this->input->post('category') =='IMP2') {
                $start_time = strtotime(date('Y-m-d 07:00:00', strtotime($this->input->post('date'))));
            }

            $loss_time = $end_time - $start_time;

            if($this->input->post('category') =='IMP1' && $loss_time > 12600){
                $this->session->set_flashdata('notify', 'maxi');
                redirect('/imp');
            }

            $data = [
                'id' => $id,
                'created_at' => date('Y-m-d H:i:s'),
                'npk' => $this->session->userdata('npk'),
                'name' => $this->session->userdata('nama'),
                'category' => $this->input->post('category'),
                'date' => date('Y-m-d', strtotime($this->input->post('date'))),
                'start_time' => date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$this->input->post('start_time'))),
                'end_time' => date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$this->input->post('end_time'))),
                'loss_time' => $loss_time,
                'remarks' => $this->input->post('remarks'),
                'atasan1' => $this->session->userdata('atasan1_inisial'),
                'atasan2' => $this->session->userdata('atasan2_inisial'),
                'sect_id' => $this->session->userdata('sect_id'),
                'dept_id' => $this->session->userdata('dept_id'),
                'div_id' => $this->session->userdata('div_id'),
                'gol_id' => $this->session->userdata('gol_id'),
                'posisi_id' => $this->session->userdata('posisi_id'),
                'status' => '1'
            ];
            $this->db->insert('imp', $data);

            if ($this->session->userdata('posisi_id') <= 3){

                $this->db->set('atasan1_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('atasan1_at', date('Y-m-d H:i:s'));
                $this->db->set('atasan2_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('atasan2_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '3');
                $this->db->where('id', $id);
                $this->db->update('imp');
    
                // $admin_hr = $this->db->get_where('karyawan_admin', ['sect_id' => '215'])->row();
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
                //             'phone' => $admin_hr->phone,
                //             'message' => "*[NEED APPROVAL] PENGAJUAN IMP*" .
                //             "\r\n \r\nNama    : *" .  $this->session->userdata('nama') . "*" .
                //             "\r\nTanggal  : *" . date('d M Y', strtotime($this->input->post('date'))) . "*" .
                //             "\r\nJam      : *" . date('H:i', strtotime($this->input->post('start_time'))).' - '.date('H:i', strtotime($this->input->post('end_time'))) ."*" .
                //             "\r\nKeterangan : *" . $this->input->post('remarks') . "*" .
                //             "\r\n \r\nIMP ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                //             "\r\nHarap segera respon *Setujui/Batalkan*".
                //             "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/imp/hr_approval"
                //         ],
                //     ]
                // );
                // $body = $response->getBody();
        
            }else{

                // $atasan1 = $this->db->get_where('karyawan', ['inisial' => $this->session->userdata('atasan1_inisial')])->row_array();
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
                //             'message' => "*[NEED APPROVAL] PENGAJUAN IMP*" .
                //             "\r\n \r\nNama    : *" .  $this->session->userdata('nama') . "*" .
                //             "\r\nTanggal  : *" . date('d M Y', strtotime($this->input->post('date'))) . "*" .
                //             "\r\nJam      : *" . date('H:i', strtotime($this->input->post('start_time'))).' - '.date('H:i', strtotime($this->input->post('end_time'))) ."*" .
                //             "\r\nKeterangan : *" . $this->input->post('remarks') . "*" .
                //             "\r\nHarap segera respon *Setujui/Batalkan*".
                //             "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/imp/approval"
                //         ],
                //     ]
                // );
                // $body = $response->getBody();
            }

            $this->session->set_flashdata('notify', 'success');
            redirect('/imp');
        }elseif ($params=='cancel'){

            $this->db->set('reject_by', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
            $this->db->set('reject_at', date('Y-m-d H:i:s'));
            $this->db->set('reject_reason', $this->input->post('cl_remarks'));
            $this->db->set('status', '0');
            $this->db->set('reject_status', $this->input->post('cl_status'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('imp');

            $this->session->set_flashdata('notify', 'cancel');
            redirect('/imp');
        }
    }

    public function approval($params)
    {
        if ($params == 'outstanding')
        {

            $data['sidemenu'] = 'Approval';
            $data['sidesubmenu'] = 'Approval IMP';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('imp/approval', $data);
            $this->load->view('templates/footer');
        }elseif ($params == 'approve'){

            $id = $this->input->post('id');
            $imp = $this->db->get_where('imp', ['id' => $id])->row();
    
            if ($this->session->userdata('inisial') == $imp->atasan1)
            {
                $this->db->set('atasan1_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('atasan1_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '2');
                $this->db->where('id', $id);
                $this->db->update('imp');
    
                //Notifikasi ke ATASAN 2
                if ($this->session->userdata('inisial') != $imp->atasan2)
                {
                    $atasan2 = $this->db->get_where('karyawan', ['inisial' => $imp->atasan2])->row();
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
                                'phone' => $atasan2->phone,
                                'message' => "*[NEED APPROVAL] PENGAJUAN IMP*" .
                                "\r\n \r\nNama    : *" . $imp->name . "*" .
                                "\r\nTanggal  : *" . date('d M Y', strtotime($imp->date)) . "*" .
                                "\r\nJam      : *" . date('H:i', strtotime($imp->start_time)).' - '.date('H:i', strtotime($imp->end_time)) ."*" .
                                "\r\nKeterangan : *" . $imp->remarks . "*" .
                                "\r\n \r\nIMP ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                                "\r\nHarap segera respon *Setujui/Batalkan*".
                                "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/imp/approval"
                            ],
                        ]
                    );
                    $body = $response->getBody();
                }
            }
    
            if ($this->session->userdata('inisial') == $imp->atasan2 or $this->session->userdata('posisi_id') <= 3)
            {
                $this->db->set('atasan2_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('atasan2_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '3');
                $this->db->where('id', $id);
                $this->db->update('imp');
    
                $admin_hr = $this->db->get_where('karyawan_admin', ['sect_id' => '215'])->row();
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
                            'phone' => $admin_hr->phone,
                            'message' => "*[NEED APPROVAL] PENGAJUAN IMP*" .
                            "\r\n \r\nNama    : *" . $imp->name . "*" .
                            "\r\nTanggal  : *" . date('d M Y', strtotime($imp->date)) . "*" .
                            "\r\nJam      : *" . date('H:i', strtotime($imp->start_time)).' - '.date('H:i', strtotime($imp->end_time)) ."*" .
                            "\r\nKeterangan : *" . $imp->remarks . "*" .
                            "\r\n \r\nIMP ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/imp/hr_approval"
                        ],
                    ]
                );
                $body = $response->getBody();
            }

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }elseif ($params == 'reject'){

            $id = $this->input->post('id');
            $imp = $this->db->get_where('imp', ['id' => $id])->row();
    
            if ($this->session->userdata('inisial') == $imp->atasan1)
            {
                $this->db->set('atasan1_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('atasan1_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $imp->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('imp');
            }

            if ($this->session->userdata('inisial') == $imp->atasan2)
            {
                $this->db->set('atasan2_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('atasan2_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $imp->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('imp');
            }

            // Notifikasi ke USER
                $user = $this->db->get_where('karyawan', ['npk' => $imp->npk])->row();
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
                            'phone' => $user->phone,
                            'message' => "*[REJECTED] PENGAJUAN IMP KAMU DITOLAK*" .
                            "\r\n \r\n#  : *" . $imp->id . "*" .
                            "\r\nTanggal  : *" . date('d M Y', strtotime($imp->date)) . "*" .
                            "\r\nJam      : *" . date('H:i', strtotime($imp->start_time)).' - '.date('H:i', strtotime($imp->end_time)) ."*" .
                            "\r\nKeterangan : *" . $imp->remarks . "*" .
                            "\r\n \r\nIMP ini telah DITOLAK oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nAlasan : *" . $this->input->post('reason') . "*" .
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/imp"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }
    }

    public function hr_approval($params=null)
    {
        if (empty($params))
        {
            redirect('/imp/hr_approval/outstanding');
        }elseif ($params == 'outstanding'){
            $data['sidemenu'] = 'HR IMP';
            $data['sidesubmenu'] = 'Approval';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            // Pages
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('imp/hr/approval', $data);
            $this->load->view('templates/footer');
        }elseif ($params == 'approve'){

            $id = $this->input->post('id');
            $imp = $this->db->get_where('imp', ['id' => $id])->row();

            if ($imp->category == 'IMP1' || $imp->category == 'IMP2'){
                $this->db->set('hr_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('hr_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $id);
                $this->db->update('imp');
            }elseif ($imp->category == 'IMP3') {
                $this->db->set('hr_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('hr_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '5');
                $this->db->where('id', $id);
                $this->db->update('imp');
            }



            //Notifikasi ke USER
            $user = $this->db->get_where('karyawan', ['npk' => $imp->npk])->row();
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
                        'phone' => $user->phone,
                        'message' => "*[APPROVED] IMP KAMU TELAH DISETUJUI*" .
                        "\r\n#  : *" . $imp->id . "*" .
                        "\r\nTanggal  : *" . date('d M Y', strtotime($imp->date)) . "*" .
                        "\r\nJam      : *" . date('H:i', strtotime($imp->start_time)).' - '.date('H:i', strtotime($imp->end_time)) ."*" .
                        "\r\nKeterangan : *" . $imp->remarks . "*" .
                        "\r\n \r\nIMP ini telah *DISETUJUI*".
                        "\r\nJangan lupa untuk absen dan lapor ke SECURITY saat meninggalkan area kerja.".
                        "\r\n \r\nInfo lebih lengkap cek! https://raisa.winteq-astra.com/imp"
                    ],
                ]
            );
            $body = $response->getBody();
              

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }elseif ($params == 'reject'){

            $id = $this->input->post('id');
            $imp = $this->db->get_where('imp', ['id' => $id])->row();
    
                $this->db->set('hr_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('hr_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $imp->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('imp');

            // Notifikasi ke USER
            
                $user = $this->db->get_where('karyawan', ['npk' => $imp->npk])->row();
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
                            'phone' => $user->phone,
                            'message' => "*[REJECTED] PENGAJUAN IMP KAMU DITOLAK*" .
                            "\r\n \r\n#  : *" . $imp->id . "*" .
                            "\r\nTanggal  : *" . date('d M Y', strtotime($imp->date)) . "*" .
                            "\r\nJam      : *" . date('H:i', strtotime($imp->start_time)).' - '.date('H:i', strtotime($imp->end_time)) ."*" .
                            "\r\nKeterangan : *" . $imp->remarks . "*" .
                            "\r\n \r\nCuti ini telah DITOLAK oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nAlasan : *" . $this->input->post('reason') . "*" .
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/imp"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }
    }

    public function sec_approval($params=null)
    {
        if (empty($params))
        {
            redirect('/imp/hr_approval/outstanding');
        }elseif ($params == 'outstanding'){
            $data['sidemenu'] = 'IMP Security';
            $data['sidesubmenu'] = 'Approval';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            // Pages
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('imp/security/approval', $data);
            $this->load->view('templates/footer');
        }elseif ($params == 'approve'){

            $id = $this->input->post('id');
            $imp = $this->db->get_where('imp', ['id' => $id])->row();
            
            if ($imp->status == 4 && $imp->category == 'IMP1'){
                $this->db->set('security_start_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('security_start_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '5');
                $this->db->where('id', $id);
                $this->db->update('imp'); 
            }elseif ($imp->status == 5 && $imp->category == 'IMP1'){
                $this->db->set('security_end_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('security_end_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '9');
                $this->db->where('id', $id);
                $this->db->update('imp');
            }else{
                $this->db->set('security_start_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('security_start_at', date('Y-m-d H:i:s'));
                $this->db->set('security_end_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('security_end_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '9');
                $this->db->where('id', $id);
                $this->db->update('imp');
            } 

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();

        }elseif ($params == 'reject'){

            $id = $this->input->post('id');
            $imp = $this->db->get_where('imp', ['id' => $id])->row();
    
                $this->db->set('hr_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('hr_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $imp->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('imp');

            // Notifikasi ke USER
            
                $user = $this->db->get_where('karyawan', ['npk' => $imp->npk])->row();
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
                            'phone' => $user->phone,
                            'message' => "*[REJECTED] PENGAJUAN IMP KAMU DITOLAK*" .
                            "\r\n \r\n#  : *" . $imp->id . "*" .
                            "\r\nTanggal  : *" . date('d M Y', strtotime($imp->date)) . "*" .
                            "\r\nJam      : *" . date('H:i', strtotime($imp->start_time)).' - '.date('H:i', strtotime($imp->end_time)) ."*" .
                            "\r\nKeterangan : *" . $imp->remarks . "*" .
                            "\r\n \r\nCuti ini telah DITOLAK oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nAlasan : *" . $this->input->post('reason') . "*" .
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/imp"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }
    }

    public function hr_report($params)
    {
        if ($params=='search_date'){
        
            if($this->input->post('start')){
                $start  = date('d-m-Y', strtotime($this->input->post('start')));
                $end = date('d-m-Y', strtotime($this->input->post('end')));
            }else{
                $start  = date('d-m-Y');
                $end = date('d-m-Y');
            }
            
            $data['periode'] = [
                'start' => $start,
                'end' => $end
            ];

            $data['sidemenu'] = 'HR IMP';
            $data['sidesubmenu'] = 'Laporan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('imp/laporan/search_date', $data);
            $this->load->view('templates/footer');
        }
    }

    public function get_data($params)
    {    
        if ($params == null){

        }elseif ($params == 'index'){
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->order_by('date', 'desc');
            $data = $this->db->get('imp')->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $status = $this->db->get_where('imp_status', ['id' => $row->status])->row();
                    if ($row->status > 0 && $row->status < 9)
                    {
                        $action = "<button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#cancelImp' data-id='".$row->id."' data-status='".$row->status."'><i class='material-icons'>clear</i></button>
                                    <button type='button' class='btn btn-info btn-link btn-just-icon disabled' data-toggle='modal' data-target='#hapusAktivitas' data-id_aktivitas='".$row->id."'><i class='material-icons'>description</i></button>";
                    }else{
                        $action = "<button type='button' class='btn btn-info btn-link btn-just-icon disabled' data-toggle='modal' data-target='#updateAktivitas' data-id_aktivitas='".$row->id."'><i class='material-icons'>description</i></button>";
                    }

                    $output['data'][] = array(
                        "id" => $row->id,
                        "date" => date('d M Y', strtotime($row->date)),
                        "time" => date('H:i', strtotime($row->start_time)).' - '.date('H:i', strtotime($row->end_time)),
                        "remarks" => $row->remarks,
                        "status" => $status->title,
                        "action" => $action
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => null,
                    "date" => null,
                    "time" => 'There are no data to display.',
                    "remarks" => null,
                    "status" => null,
                    "action" => null
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'approval'){
            $queryIMP = "SELECT *
            FROM `imp`
            WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '2') ";
            $data = $this->db->query($queryIMP)->result();

            if ($data)
            {
                foreach ($data as $row) {

                     //membagi detik menjadi jam
                    $h    =floor($row->loss_time / (60 * 60));
                    
                    //membagi sisa detik setelah dikurangi $jam menjadi menit
                    $m    =floor(($row->loss_time - $h * (60 * 60))/ 60 );

                    $output['data'][] = array(
                        "id" => $row->id,
                        "name" => $row->name,
                        "date" => date('d M Y', strtotime($row->date)).' '.date('H:i', strtotime($row->start_time)).' - '.date('H:i', strtotime($row->end_time)),
                        "time" => $h .' Jam '.$m.' Menit'
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => '',
                    "name" => 'Yeay! you all approved.',
                    "date" => '',
                    "time" => ''
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'hr_approval'){
            $data = $this->db->get_where('imp', ['status' => '3'])->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $output['data'][] = array(
                        "id" => $row->id,
                        "name" => $row->name,
                        "date" => date('d M Y', strtotime($row->date)),
                        "time" => date('H:i', strtotime($row->start_time)).' - '.date('H:i', strtotime($row->end_time)),
                        "remarks" => $row->remarks
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => '',
                    "name" => 'Yeay! you all approved.',
                    "date" => '',
                    "time" => '',
                    "remarks" => ''
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'sec_approval'){
            $this->db->where('status','4');
            $this->db->or_where('status','5');
            $data = $this->db->get('imp')->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $status = $this->db->get_where('imp_status', ['id' => $row->status])->row();
                    if ($row->status == 4){
                        $status = "<button class='btn btn-link btn-danger'><i class='fa fa-sign-out'></i> Keluar/Pulang<div class='ripple-container'></div></button>";
                    }else{
                        $status = "<button class='btn btn-link btn-success'><i class='fa fa-sign-in'></i> Masuk/Kembali<div class='ripple-container'></div></button>";
                    }

                    $output['data'][] = array(
                        "status" => $status,
                        "id" => $row->id,
                        "name" => $row->name,
                        "date" => date('d M Y', strtotime($row->date)),
                        "time" => date('H:i', strtotime($row->start_time)).' - '.date('H:i', strtotime($row->end_time)),
                        "remarks" => $row->remarks
                    );
                }
            }else{
                $output['data'][] = array(
                    "status" => '',
                    "id" => '',
                    "name" => 'Yeay! you all approved.',
                    "date" => '',
                    "time" => '',
                    "remarks" => ''
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'details'){
            $data = $this->db->get_where('imp', ['id' => $this->input->post('id')])->row();
            $category = $this->db->get_where('imp_kategori', ['kategori' => $data->category])->row();


            $output['data'] = array(
                "id" => $data->id,
                "name" => $data->name,
                "remarks" => $data->remarks,
                "date" => date('d M Y', strtotime($data->date)),
                "time" => date('H:i', strtotime($data->start_time)).' - '.date('H:i', strtotime($data->end_time)),
                "category" => $category->deskripsi
            );

            echo json_encode($output);
            exit();

        }elseif ($params == 'search_date'){
            $this->db->where('date >=', date('Y-m-d', strtotime($this->input->post('start'))));
            $this->db->where('date <=', date('Y-m-d', strtotime($this->input->post('end'))));
            $data = $this->db->get_where('imp', ['status >' => '0'])->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $category = $this->db->get_where('imp_kategori', ['kategori' => $row->category])->row();
                    $status = $this->db->get_where('imp_status', ['id' => $row->status])->row();

                     //membagi detik menjadi jam
                     $h    =floor($row->loss_time / (60 * 60));
                    
                     //membagi sisa detik setelah dikurangi $jam menjadi menit
                     $m    =floor(($row->loss_time - $h * (60 * 60))/ 60 );

                     if ($row->status < 9)
                    {
                        $action = $status->title;
                    }else{
                        $action = "<a href='".base_url('imp/print/'.$row->id)."' class='btn btn-info btn-link btn-just-icon' target='_blank'><i class='material-icons'>description</i></a>";
                    }

                    $output['data'][] = array(
                        "id" => $row->id,
                        "category" => $category->deskripsi,
                        "npk" => $row->npk,
                        "name" => $row->name,
                        "date" => date('d/m/Y', strtotime($row->date)),
                        "time" => date('H:i', strtotime($row->start_time)).' - '.date('H:i', strtotime($row->end_time)),
                        "loss" => $h .' Jam '.$m.' Menit',
                        "remarks" => $row->remarks,
                        "action" => $action,
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => '',
                    "category" => '',
                    "npk" => '',
                    "name" => 'Sepi nih bos!',
                    "date" => '',
                    "time" => '',
                    "loss" => '',
                    "remarks" => '',
                    "action" => ''
                );
            }

            echo json_encode($output);
            exit();

        }
    
    }

    public function print($id)
    {   
        $data['imp'] = $this->db->get_where('imp', ['id' => $id])->row();
        $data['section'] = $this->db->get_where('karyawan_sect', ['id' => $data['imp']->sect_id])->row();
        $this->load->view('imp/print', $data);
    }

}
