<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Profil';
        $data['sidesubmenu'] = 'Profil';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('profil/index', $data);
        $this->load->view('templates/footer');
    }

    public function ubahpwd()
    {
        $data['sidemenu'] = 'Profil';
        $data['sidesubmenu'] = 'Ubah Password';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('profil/ubahpwd', $data);
        $this->load->view('templates/footer');
    }
    public function ubahpwd_proses()
    {
        $npk = $this->session->userdata('npk');
        $passlama = $this->input->post('passlama');
        $passbaru1 = $this->input->post('passbaru1');
        $passbaru2 = $this->input->post('passbaru2');

        $karyawan = $this->db->get_where('karyawan', ['npk' => $npk])->row_array();
        if ($karyawan) {
            if ($passbaru1 == $passbaru2) {
                if(password_verify($passlama,$karyawan['password'])) {
                    $this->db->set('password', password_hash($passbaru2, PASSWORD_DEFAULT));
                    $this->db->where('npk', $npk);
                    $this->db->update('karyawan');

                    $this->session->set_flashdata('message', 'passok');
                    redirect('profil/index');
                }else{
                    $this->session->set_flashdata('message', 'passng');
                    redirect('profil/ubahpwd');
                }
            }else{
                $this->session->set_flashdata('message', 'passng');
                redirect('profil/ubahpwd');
            }
        }
    }

    public function update($parameter)
    {
        if ($parameter=='e-wallet')
        {
            $data['sidemenu'] = 'Profil';
            $data['sidesubmenu'] = 'Profil';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('profil/update_ewallet', $data);
            $this->load->view('templates/footer');
        }
    }

    public function submit($parameter)
    {
        if ($parameter=='e-wallet')
        {
            $this->db->set('ewallet_1', $this->input->post('utama').' - '.$this->input->post('utama_rek'));
            $this->db->set('ewallet_2', $this->input->post('cadangan').' - '.$this->input->post('cadangan_rek'));
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->update('karyawan');

            redirect('profil');
        }
    }

}
