<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Dashboard';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    public function informasi()
    {
        $data['sidemenu'] = 'Layanan';
        $data['sidesubmenu'] = 'Informasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['informasi'] = $this->db->get('informasi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('layanan/informasi', $data);
        $this->load->view('templates/footer');
    }

    public function buatInformasi()
    {
        date_default_timezone_set('asia/jakarta');
        $tahun = date("Y", strtotime($this->input->post('berlaku')));
        $bulan = date("m", strtotime($this->input->post('berlaku')));
        $queryInformasi = "SELECT COUNT(*)
            FROM `informasi`
            WHERE YEAR(berlaku) = '$tahun' AND MONTH(berlaku) = '$bulan'
            ";
            $informasi = $this->db->query($queryInformasi)->row_array();
            $totalInformasi = $informasi['COUNT(*)'] + 1;
        $data = [
            'id' => date('ym') . $totalInformasi,
            'judul' => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'gambar_banner' => 'gambar_banner.jpg',
            'gambar_konten' => 'gambar_konten.jpg',
            'berlaku' => $this->input->post('berlaku')
        ];
        $this->db->insert('informasi', $data);

        $config['upload_path']          = './assets/img/faces/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('gambar_banner')) {
            $this->db->set('gambar_banner', $this->upload->data('file_name'));
            $this->db->set('gambar_konten', $this->upload->data('file_name'));
            $this->db->where('judul', $this->input->post('judul'));
            $this->db->update('informasi');
        }

        redirect('layanan/informasi');

    }

    public function updateInformasi()
    {
        $config['upload_path']          = './assets/img/faces/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('gambar_banner')) {
            $this->db->set('gambar_banner', $this->upload->data('file_name'));
            $this->db->set('gambar_konten', $this->upload->data('file_name'));
        } else {
            echo $this->upload->display_errors();
        }
            $this->db->set('judul', $this->input->post('judul'));
            $this->db->set('deskripsi', $this->input->post('deskripsi'));
            $this->db->set('berlaku', $this->input->post('berlaku'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('informasi');

            redirect('layanan/informasi');
    }

    public function hapusInformasi($id)
    {
        $this->db->set('informasi');
        $this->db->where('id', $id);
        $this->db->delete('informasi');

        redirect('layanan/informasi');
    }
    
    
}
