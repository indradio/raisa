<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visit extends CI_Controller
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

    public function guest()
    {
        $data['sidemenu'] = 'Security';
        $data['sidesubmenu'] = 'Tamu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['visit'] = $this->db->where('status', '1');
        $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('cekdl/visit', $data);
        $this->load->view('templates/footer');
        
    }

    public function check()
    {
        date_default_timezone_set('asia/jakarta');
        if ($this->input->post('kategori')=='LAINNYA'){
            $kategori = $this->input->post('kategori_lain');
        }else{
            $kategori = $this->input->post('kategori');
        }
        $this->db->set('pic', $this->input->post('pic'));
        $this->db->set('kategori', $kategori);
        $this->db->set('suhu', $this->input->post('suhu'));
        $this->db->set('hasil', $this->input->post('hasil'));
        $this->db->set('check_by', $this->session->userdata('inisial'));
        $this->db->set('check_at', date("Y-m-d H:i:s"));
        $this->db->set('status', '2');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('visit');

        $pic = $this->db->get_where('karyawan', ['inisial' => $this->input->post('pic')])->row_array(); 
        $postData = array(
            'deviceid' => 'ed59bffb-7ffd-4ac2-b039-b4725fdd4010',
            'number' => $pic['phone'],
            'message' => "*TAMU KAMU SUDAH TIBA DI WINTEQ*" .
            "\r\n \r\nNama: *" . $this->input->post('nama') . "*" .
            "\r\nPerusahaan : *" . $this->input->post('perusahaan') . "*" .
            "\r\nKeperluan : *" . $this->input->post('keperluan') . "*" .
            "\r\nHasil Permeriksaan" . 
            "\r\nSuhu Tubuh: *" . $this->input->post('suhu') . "°C*" .
            "\r\nHasil : *DI" . $this->input->post('hasil') . "*" .
            "\r\n \r\nTetap jaga kesehatan kamu ya!"
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

        $this->session->set_flashdata('message', 'terimakasih');
        redirect('visit/guest');
    }
}
