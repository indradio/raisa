<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Kasbon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('asia/jakarta');
        is_logged_in();
    }

    public function index()
    {    
        $data['sidemenu'] = 'Kasbon';
        $data['sidesubmenu'] = 'KasbonKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $data['access'] = $this->db->get_where('kasbon_user', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('kasbon/index', $data);
        $this->load->view('templates/footer');
    }

    public function request()
    {    
        $data['sidemenu'] = 'Kasbon';
        $data['sidesubmenu'] = 'Pengajuan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $data['access'] = $this->db->get_where('kasbon_user', ['npk' => $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('kasbon/index', $data);
        $this->load->view('templates/footer');
    }

    public function outstanding()
    {    
        $data['sidemenu'] = 'Kasbon';
        $data['sidesubmenu'] = 'Penyelesaian';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
     
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('kasbon/outstanding', $data);
        $this->load->view('templates/footer');
    }

    public function report()
    {    
        $data['sidemenu'] = 'Kasbon';
        $data['sidesubmenu'] = 'Riwayat';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
     
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('kasbon/report', $data);
        $this->load->view('templates/footer');
    }

    public function submit($params)
    {
        date_default_timezone_set('asia/jakarta');
        $this->load->helper('string');
        $this->load->helper('date');
        if ($params=='add')
        {
            //Validasi
            if($this->input->post('advance')!='' || $this->input->post('remarks') !='' || $this->input->post('settlement_date')!='') 
                {

                // if(date('Y-m-d H:i:s', strtotime($this->input->post('date').' '.$this->input->post('start_time'))) < date('Y-m-d H:i:s')){
                //     $this->session->set_flashdata('notify', 'range');
                //     redirect('/imp');
                // }        

                // if($this->input->post('start_time') > $this->input->post('end_time')){
                //     $this->session->set_flashdata('notify', 'over');
                //     redirect('/imp');
                // }        

                $id = 'KAS'.date('ym').random_string('alnum',2);
                $kas = $this->db->get_where('kasbon', ['id' => $id])->row();
                if ($kas){
                    $id = 'KAS'.date('ym').random_string('alnum',3);
                }

                $data = [
                    'id' => $id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'npk' => $this->session->userdata('npk'),
                    'name' => $this->session->userdata('nama'),
                    'advance' => $this->input->post('advance'),
                    'advance_req' => $this->input->post('advance'),
                    'remarks' => $this->input->post('remarks'),
                    'settlement_date' => date('Y-m-d', strtotime($this->input->post('settlement_date'))),
                    'advance_date' => date('Y-m-d'),
                    'atasan1' => $this->session->userdata('atasan1_inisial'),
                    'atasan2' => $this->session->userdata('atasan2_inisial'),
                    'sect_id' => $this->session->userdata('sect_id'),
                    'dept_id' => $this->session->userdata('dept_id'),
                    'div_id' => $this->session->userdata('div_id'),
                    'status' => '1'
                ];
                $this->db->insert('kasbon', $data);


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
                                'phone' => $atasan1->phone,
                                'message' => "*[NEED APPROVAL] PENGAJUAN KASBON*" .
                                "\r\n \r\nNama    : *" . $this->session->userdata('nama') . "*" .
                                "\r\nKasbon     : *" . number_format($this->input->post('advance'), 0, '.', ',') ."*" .
                                "\r\nKeterangan : *" . $this->input->post('remarks') . "*" .
                                "\r\nHarap segera respon *Setujui/Batalkan*".
                                "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon/approval/outstanding"
                            ],
                        ]
                    );
                    $body = $response->getBody();

                    $output['data'] = array(
                        'result' => 'success'
                    );
        
                    //output to json format
                    echo json_encode($output);
                }
            
        }elseif ($params=='cancel'){

            //Validasi
            if($this->input->post('id')!='' || $this->input->post('remarks') !='' || $this->input->post('status')!='') 
                {

                    $this->db->set('reject_by', 'Dibatalkan oleh '.$this->session->userdata('inisial'));
                    $this->db->set('reject_at', date('Y-m-d H:i:s'));
                    $this->db->set('reject_reason', $this->input->post('remarks'));
                    $this->db->set('status', '0');
                    $this->db->set('reject_status', $this->input->post('status'));
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('kasbon');

                    $output['data'] = array(
                        'result' => 'success'
                    );

                    //output to json format
                    echo json_encode($output);
                }
        }elseif ($params=='settlement'){

            //Validasi
            if($this->input->post('id')!='' || $this->input->post('settlement') !='' || $this->input->post('status')=='6') 
                {

                    $this->db->set('settlement_by', $this->session->userdata('inisial'));
                    $this->db->set('settlement_date', date('Y-m-d H:i:s'));
                    $this->db->set('settlement', $this->input->post('settlement'));
                    $this->db->set('status', '7');
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('kasbon');

                    $output['data'] = array(
                        'result' => 'success'
                    );

                    //output to json format
                    echo json_encode($output);
                }
        }
    }

    public function approval($params)
    {
        if ($params == 'outstanding')
        {
            $data['sidemenu'] = 'Approval';
            $data['sidesubmenu'] = 'Approval Kasbon';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('kasbon/approval', $data);
            $this->load->view('templates/footer');

        }elseif ($params == 'outstanding_div'){
            
            $data['sidemenu'] = 'Approval Div';
            $data['sidesubmenu'] = 'Approval Kasbon';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('kasbon/approval_div', $data);
            $this->load->view('templates/footer');

        }elseif ($params == 'outstanding_dept_fa'){
            
            $data['sidemenu'] = 'Approval Dept FA';
            $data['sidesubmenu'] = 'Approval Kasbon';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('kasbon/approval_dept_fa', $data);
            $this->load->view('templates/footer');

        }elseif ($params == 'approve'){

            $id = $this->input->post('id');
            $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
    
            if ($this->session->userdata('inisial') == $kasbon->atasan1)
            {
                $this->db->set('approval1_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval1_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '2');
                $this->db->where('id', $id);
                $this->db->update('kasbon');
    
                //Notifikasi ke ATASAN 2
                if ($this->session->userdata('inisial') != $kasbon->atasan2)
                {
                    $atasan2 = $this->db->get_where('karyawan', ['inisial' => $kasbon->atasan2])->row();
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
                                'message' => "*[NEED APPROVAL] PENGAJUAN KASBON*" .
                                "\r\n \r\nNama    : *" . $kasbon->name . "*" .
                                "\r\nTanggal    : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                                "\r\nKasbon     : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                                "\r\nKeterangan : *" . $kasbon->remarks . "*" .
                                "\r\n \r\nKasbon ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                                "\r\nHarap segera respon *Setujui/Batalkan*".
                                "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon/approval/outstanding"
                            ],
                        ]
                    );
                    $body = $response->getBody();
                }
            }
    
            if ($this->session->userdata('inisial') == $kasbon->atasan2)
            {
                $this->db->set('approval2_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval2_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '3');
                $this->db->where('id', $id);
                $this->db->update('kasbon');
    
                $this->db->where('posisi_id', '2');
                $this->db->where('div_id', '2');
                $this->db->where('is_active', '1');
                $div_sa = $this->db->get('karyawan')->row();

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
                            'phone' => $div_sa->phone,
                            'message' => "*[NEED APPROVAL] PENGAJUAN KASBON*" .
                            "\r\n \r\nNama    : *" . $kasbon->name . "*" .
                            "\r\nTanggal     : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                            "\r\nKasbon      : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                            "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                            "\r\n \r\nKasbon ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon/fa_approval"
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

        }elseif ($params == 'approve_div'){

            $id = $this->input->post('id');
            $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
    
                $this->db->set('approval3_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval3_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $id);
                $this->db->update('kasbon');
    
                $this->db->where('posisi_id', '3');
                $this->db->where('dept_id', '21');
                $this->db->where('is_active', '1');
                $dept_fa = $this->db->get('karyawan')->row();

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
                            'phone' => $dept_fa->phone,
                            'message' => "*[NEED APPROVAL] PENGAJUAN KASBON*" .
                            "\r\n \r\nNama    : *" . $kasbon->name . "*" .
                            "\r\nTanggal     : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                            "\r\nKasbon      : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                            "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                            "\r\n \r\nKasbon ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon/fa_approval"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }elseif ($params == 'approve_dept_fa'){

            $id = $this->input->post('id');
            $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
    
                $this->db->set('approval4_by', 'Disetujui oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval4_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '5');
                $this->db->where('id', $id);
                $this->db->update('kasbon');
    
                $admin_fa = $this->db->get_where('karyawan_admin', ['sect_id' => '211'])->row();

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
                            'phone' => $admin_fa->phone,
                            'message' => "*[NEED APPROVAL] PENGAJUAN KASBON*" .
                            "\r\n \r\nNama    : *" . $kasbon->name . "*" .
                            "\r\nTanggal     : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                            "\r\nKasbon      : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                            "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                            "\r\n \r\nKasbon ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nHarap segera respon *Setujui/Batalkan*".
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon/fa_approval"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();

        }elseif ($params == 'approve_admin_fa'){

            if ($this->input->post('id'))
            {
                $id = $this->input->post('id');
                $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
        
                    $this->db->set('advance', $this->input->post('advance'));
                    $this->db->set('advance_by', 'Diberikan oleh '.$this->session->userdata('inisial'));
                    $this->db->set('advance_date', date('Y-m-d H:i:s'));
                    $this->db->set('status', '6');
                    $this->db->where('id', $id);
                    $this->db->update('kasbon');
        
                    $user = $this->db->get_where('karyawan', ['npk' => $kasbon->npk])->row();

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
                                'message' => "*[NEED APPROVAL] PENGAJUAN KASBON*" .
                                "\r\n \r\nNama    : *" . $kasbon->name . "*" .
                                "\r\nTanggal     : *" . date('d M Y') . "*" .
                                "\r\nKasbon      : *" . number_format($this->input->post('advance'), 0, '.', ',') ."*" .
                                "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                                "\r\n \r\nKasbon ini telah DISETUJUI oleh *". $this->session->userdata('inisial') ."*".
                                "\r\nHarap segera menghubungi bagain kasir untuk pencairan dana.".
                                "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com"
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
        }elseif ($params == 'reject'){

            $id = $this->input->post('id');
            $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
    
            if ($this->session->userdata('inisial') == $kasbon->atasan1)
            {
                $this->db->set('approval1_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval1_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $kasbon->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('kasbon');
            }

            if ($this->session->userdata('inisial') == $kasbon->atasan2)
            {
                $this->db->set('approval2_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval2_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $kasbon->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('kasbon');
            }

            // Notifikasi ke USER
                $user = $this->db->get_where('karyawan', ['npk' => $kasbon->npk])->row();
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
                            'message' => "*[REJECTED] PENGAJUAN KASBON KAMU DITOLAK*" .
                            "\r\n \r\n*#" . $kasbon->id . "*" .
                            "\r\nNama    : *" . $kasbon->name . "*" .
                            "\r\nTanggal     : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                            "\r\nKasbon      : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                            "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                            "\r\n \r\nKasbon ini telah DITOLAK oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nAlasan : *" . $this->input->post('reason') . "*" .
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }elseif ($params == 'reject_div'){

            $id = $this->input->post('id');
            $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
    
                $this->db->set('approval3_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval3_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $kasbon->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('kasbon');

            // Notifikasi ke USER
                $user = $this->db->get_where('karyawan', ['npk' => $kasbon->npk])->row();
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
                            'message' => "*[REJECTED] PENGAJUAN KASBON KAMU DITOLAK*" .
                            "\r\n \r\n*#" . $kasbon->id . "*" .
                            "\r\nNama    : *" . $kasbon->name . "*" .
                            "\r\nTanggal     : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                            "\r\nKasbon      : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                            "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                            "\r\n \r\nKasbon ini telah DITOLAK oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nAlasan : *" . $this->input->post('reason') . "*" .
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }elseif ($params == 'reject_dept_fa'){

            $id = $this->input->post('id');
            $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
    
                $this->db->set('approval4_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('approval4_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $kasbon->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('kasbon');

            // Notifikasi ke USER
                $user = $this->db->get_where('karyawan', ['npk' => $kasbon->npk])->row();
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
                            'message' => "*[REJECTED] PENGAJUAN KASBON KAMU DITOLAK*" .
                            "\r\n \r\n*#" . $kasbon->id . "*" .
                            "\r\nNama    : *" . $kasbon->name . "*" .
                            "\r\nTanggal     : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                            "\r\nKasbon      : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                            "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                            "\r\n \r\nKasbon ini telah DITOLAK oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nAlasan : *" . $this->input->post('reason') . "*" .
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon"
                        ],
                    ]
                );
                $body = $response->getBody();
            

            $output['data'] = array(
                'result' => 'success'
            );

            echo json_encode($output);
            exit();
        }elseif ($params == 'reject_admin_fa'){

            $id = $this->input->post('id');
            $kasbon = $this->db->get_where('kasbon', ['id' => $id])->row();
    
                $this->db->set('reject_by', 'Ditolak oleh '.$this->session->userdata('inisial'));
                $this->db->set('reject_at', date('Y-m-d H:i:s'));
                $this->db->set('reject_reason', $this->input->post('reason'));
                $this->db->set('reject_status', $kasbon->status);
                $this->db->set('status', '0');
                $this->db->where('id', $id);
                $this->db->update('kasbon');

            // Notifikasi ke USER
                $user = $this->db->get_where('karyawan', ['npk' => $kasbon->npk])->row();
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
                            'message' => "*[REJECTED] PENGAJUAN KASBON KAMU DITOLAK*" .
                            "\r\n \r\n*#" . $kasbon->id . "*" .
                            "\r\nNama    : *" . $kasbon->name . "*" .
                            "\r\nTanggal     : *" . date('d M Y', strtotime($kasbon->advance_date)) . "*" .
                            "\r\nKasbon      : *" . number_format($kasbon->advance, 0, '.', ',') ."*" .
                            "\r\nKeterangan  : *" . $kasbon->remarks . "*" .
                            "\r\n \r\nKasbon ini telah DITOLAK oleh *". $this->session->userdata('inisial') ."*".
                            "\r\nAlasan : *" . $this->input->post('reason') . "*" .
                            "\r\n \r\nCek sekarang! https://raisa.winteq-astra.com/kasbon"
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

    public function fa($params=null)
    {
        if (empty($params))
        {
            redirect('/kasbon/fa/request');
        }elseif ($params == 'request'){
            $data['sidemenu'] = 'FA Kasbon';
            $data['sidesubmenu'] = 'Request';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            // Pages
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('kasbon/fa/request', $data);
            $this->load->view('templates/footer');
        }elseif ($params == 'outstanding'){
            $data['sidemenu'] = 'FA Kasbon';
            $data['sidesubmenu'] = 'Outstanding';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            // Pages
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('kasbon/fa/outstanding', $data);
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
            $this->db->order_by('advance_date', 'desc');
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
                        "advance_date" => date('d M Y', strtotime($row->advance_date)),
                        "time" => date('H:i', strtotime($row->start_time)).' - '.date('H:i', strtotime($row->end_time)),
                        "remarks" => $row->remarks,
                        "status" => $status->title,
                        "action" => $action
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => null,
                    "advance_date" => null,
                    "time" => 'There are no data to display.',
                    "remarks" => null,
                    "status" => null,
                    "action" => null
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'requestUser'){
            $this->db->where('npk',$this->session->userdata('npk'));
            $this->db->where('status >',0);
            $this->db->where('status <',6);
            $this->db->order_by('advance_date','desc');
            $data = $this->db->get('kasbon')->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $status = $this->db->get_where('kasbon_status', ['id' => $row->status])->row();
                    if ($row->status > 0 && $row->status < 6)
                    {
                        $action = "<button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#cancelKasbon' data-id='".$row->id."' data-status='".$row->status."'><i class='material-icons'>clear</i></button>
                                    <button type='button' class='btn btn-info btn-link btn-just-icon disabled' data-toggle='modal' data-target='#hapusAktivitas' data-id_aktivitas='".$row->id."'><i class='material-icons'>description</i></button>";
                    }else{
                        $action = "<button type='button' class='btn btn-info btn-link btn-just-icon disabled' data-toggle='modal' data-target='#updateAktivitas' data-id_aktivitas='".$row->id."'><i class='material-icons'>description</i></button>";
                    }

                    $output['data'][] = array(
                        "id"                => $row->id,
                        "advance_date"      => date('d M Y', strtotime($row->advance_date)),
                        "advance"           => number_format($row->advance, 0, '.', ','),
                        "remarks"           => $row->remarks,
                        "settlement_date"   => date('d M Y', strtotime($row->settlement_date)),
                        "status"            => $status->title,
                        "action"            => $action
                    );
                }
            }else{
                $output['data'][] = array(
                    "id"                => null,
                    "advance_date"      => null,
                    "advance"           => null,
                    "remarks"           => 'There are no data to display.',
                    "settlement_date"   => null,
                    "status"            => null,
                    "action"            => null
                );
            }

            echo json_encode($output);
            exit();
        }elseif ($params == 'outstandingUser'){
            $this->db->where('npk',$this->session->userdata('npk'));
            $this->db->where('status',6);
            $this->db->order_by('advance_date','desc');
            $data = $this->db->get('kasbon')->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $status = $this->db->get_where('kasbon_status', ['id' => $row->status])->row();
                    if ($row->status > 0 && $row->status < 6)
                    {
                        $action = "<button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#cancelKasbon' data-id='".$row->id."' data-status='".$row->status."'><i class='material-icons'>clear</i></button>
                                    <button type='button' class='btn btn-info btn-link btn-just-icon disabled' data-toggle='modal' data-target='#hapusAktivitas' data-id_aktivitas='".$row->id."'><i class='material-icons'>description</i></button>";
                    }else{
                        $action = "<button type='button' class='btn btn-info btn-link btn-just-icon disabled' data-toggle='modal' data-target='#updateAktivitas' data-id_aktivitas='".$row->id."'><i class='material-icons'>description</i></button>";
                    }

                    $output['data'][] = array(
                        "id"                => $row->id,
                        "advance_date"      => date('d M Y', strtotime($row->advance_date)),
                        "advance"           => number_format($row->advance, 0, '.', ','),
                        "remarks"           => $row->remarks,
                        "settlement_date"   => date('d M Y', strtotime($row->settlement_date)),
                        "status"            => $status->title,
                        "action"            => $action
                    );
                }
            }else{
                $output['data'][] = array(
                    "id"                => null,
                    "advance_date"      => null,
                    "advance"           => null,
                    "remarks"           => 'There are no data to display.',
                    "settlement_date"   => null,
                    "status"            => null,
                    "action"            => null
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'approval'){
            $queryKasbon = "SELECT *
            FROM `kasbon`
            WHERE(`atasan1` = '{$this->session->userdata('inisial')}' AND `status`= '1') OR (`atasan2` = '{$this->session->userdata('inisial')}' AND `status`= '2') ";
            $data = $this->db->query($queryKasbon)->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $output['data'][] = array(
                        "id" => $row->id,
                        "name" => $row->name,
                        "advance_date"      => date('d M Y', strtotime($row->advance_date)),
                        "advance"           => number_format($row->advance, 0, '.', ','),
                        "remarks" => $row->remarks
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => '',
                    "name" => 'Yeay! you all approved.',
                    "advance_date"      => '',
                    "advance"           => '',
                    "remarks" => ''
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'approval_div'){
            $queryKasbon = "SELECT *
            FROM `kasbon`
            WHERE `status`= '3' ";
            $data = $this->db->query($queryKasbon)->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $output['data'][] = array(
                        "id" => $row->id,
                        "name" => $row->name,
                        "advance_date"      => date('d M Y', strtotime($row->advance_date)),
                        "advance"           => number_format($row->advance, 0, '.', ','),
                        "remarks" => $row->remarks
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => '',
                    "name" => 'Yeay! you all approved.',
                    "advance_date"      => '',
                    "advance"           => '',
                    "remarks" => ''
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'approval_dept_fa'){
            $queryKasbon = "SELECT *
            FROM `kasbon`
            WHERE `status`= '4' ";
            $data = $this->db->query($queryKasbon)->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $output['data'][] = array(
                        "id" => $row->id,
                        "name" => $row->name,
                        "advance_date"      => date('d M Y', strtotime($row->advance_date)),
                        "advance"           => number_format($row->advance, 0, '.', ','),
                        "remarks" => $row->remarks
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => '',
                    "name" => 'Yeay! you all approved.',
                    "advance_date"      => '',
                    "advance"           => '',
                    "remarks" => ''
                );
            }

            echo json_encode($output);
            exit();

        }elseif ($params == 'fa_request'){
            $queryKasbon = "SELECT *
            FROM `kasbon`
            WHERE `status`= '5' ";
            $data = $this->db->query($queryKasbon)->result();

            if ($data)
            {
                foreach ($data as $row) {

                    $output['data'][] = array(
                        "id" => $row->id,
                        "name" => $row->name,
                        "advance_date"      => date('d M Y', strtotime($row->advance_date)),
                        "advance"           => number_format($row->advance, 0, '.', ','),
                        "remarks" => $row->remarks,
                        "approval1" => '<small>'.$row->approval1_by.' pada '.date('d M Y H:i', strtotime($row->approval1_at)).'</small>',
                        "approval2" => '<small>'.$row->approval2_by.' pada '.date('d M Y H:i', strtotime($row->approval2_at)).'</small>',
                        "approval3" => '<small>'.$row->approval3_by.' pada '.date('d M Y H:i', strtotime($row->approval3_at)).'</small>',
                        "approval4" => '<small>'.$row->approval4_by.' pada '.date('d M Y H:i', strtotime($row->approval4_at)).'</small>'
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => '',
                    "name" => '',
                    "advance_date"      => '',
                    "advance"           => '',
                    "remarks" => 'Yeay! you all approved.',
                    "approval1" => '',
                    "approval2" => '',
                    "approval3" => '',
                    "approval4" => '',
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

        }elseif ($params == 'approvalView'){
            $data = $this->db->get_where('kasbon', ['id' => $this->input->post('id')])->row();
        
            $output['data'] = array(
                "id"            => $data->id,
                "name"          => $data->name,
                "advance_date"  => date('d M Y', strtotime($data->advance_date)),
                "advance"       => number_format($data->advance, 0, '.', ','),
                "remarks"       => $data->remarks
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

    // public function print($id)
    // {   
    //     $data['imp'] = $this->db->get_where('imp', ['id' => $id])->row();
    //     $data['section'] = $this->db->get_where('karyawan_sect', ['id' => $data['imp']->sect_id])->row();
    //     $this->load->view('kasbon/print', $data);
    // }

    public function print($id)
    {   
        $data['row'] = $this->db->get_where('kasbon', ['id' => $id])->row();
        $this->load->view('kasbon/print', $data);
    }

}
