<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Survei extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        // $data['visit'] = $this->db->get('visit')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/survei/catering', $data);
        $this->load->view('templates/footer');
    }

    public function catering($params=null)
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->where('year(tanggal)', date('Y'));
        $this->db->where('npk', $this->session->userdata('npk'));
        $data = $this->db->get('survei_catering')->row();
        if ($data){ redirect('dashboard'); }

        if($params=='submit')
        {
                $data = [
                    'tanggal' => date('Y-m-d'),
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $this->session->userdata('nama'),
                    'p1' => $this->input->post('pertanyaan1'),
                    'p2' => $this->input->post('pertanyaan2'),
                    'p3' => $this->input->post('pertanyaan3'),
                    'p4' => $this->input->post('pertanyaan4'),
                    'p5' => $this->input->post('pertanyaan5'),
                    'p6' => $this->input->post('pertanyaan6'),
                    'p7' => $this->input->post('pertanyaan7'),
                    'p8' => $this->input->post('pertanyaan8'),
                    'p9' => $this->input->post('pertanyaan9'),
                    'komentar' => $this->input->post('komentar'),
                    'rekomendasi' => $this->input->post('rekomendasi')
                ];
                $this->db->insert('survei_catering', $data);
    
            redirect('dashboard');
        }else{
            $data['sidemenu'] = 'Dashboard';
            $data['sidesubmenu'] = '';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('layanan/survei/catering', $data);
            $this->load->view('templates/footer');
        } 
    }

    public function hasil($params=null)
    {
        date_default_timezone_set('asia/jakarta');
        if($params=='catering')
        {
            $data['sidemenu'] = 'GA';
            $data['sidesubmenu'] = 'Survei Catering';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('layanan/survei/catering_hasil', $data);
            $this->load->view('templates/footer');

        }elseif($params=='get_catering')
        {
            $catering = $this->db->get('survei_catering')->result();
                
            foreach ($catering as $row) {
                $output['data'][] = array(
                    "nama" => $row->nama,
                    "p1" => $row->p1,
                    "p2" => $row->p2,
                    "p3" => $row->p3,
                    "p4" => $row->p4,
                    "p5" => $row->p5,
                    "p6" => $row->p6,
                    "p7" => $row->p7,
                    "p8" => $row->p8,
                    "p9" => $row->p9,
                    "komentar" => $row->komentar,
                    "rekomendasi" => $row->rekomendasi
                );
            }
    
            echo json_encode($output);
            exit();
        }else{
            redirect('dashboard');
        } 
    }

    public function check()
    {
        date_default_timezone_set('asia/jakarta');
        if ($this->input->post('kategori') == 'LAINNYA') {
            $kategori = $this->input->post('kategori_lain');
        } else {
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

        $this->session->set_flashdata('message', 'terimakasih');
        redirect('visit/guest');
    }

    public function batal($id)
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->set('hasil', 'DIBATALKAN');
        $this->db->set('catatan', 'TIDAK ADA KUNJUNGAN');
        $this->db->set('check_by', $this->session->userdata('inisial'));
        $this->db->set('check_at', date("Y-m-d H:i:s"));
        $this->db->set('status', '0');
        $this->db->where('id', $id);
        $this->db->update('visit');

        redirect('visit/guest');
    }
}
