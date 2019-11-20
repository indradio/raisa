<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->load->view('auth/index');
    }

    public function login()
    {
        $npk = $this->input->post('npk');
        $password = $this->input->post('pwd');
        $karyawan = $this->db->get_where('karyawan', ['npk' => $npk])->row_array();
        //die;

        if ($karyawan) {
            if (password_verify($password, $karyawan['password'])) {
                //cari atasan 1
                if ($karyawan['atasan1'] == 0) {
                    $atasan1 = $atasan1 = $this->db->get_where('karyawan', ['posisi_id' =>  '0'])->row_array();;
                } elseif ($karyawan['atasan1'] == 1) {
                    $atasan1 = $this->db->get_where('karyawan', ['posisi_id' =>  '1'])->row_array();
                } elseif ($karyawan['atasan1'] == 2) {
                    $this->db->where('posisi_id', $karyawan['atasan1']);
                    $this->db->where('div_id', $karyawan['div_id']);
                    $atasan1 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan1'] == 3) {
                    $this->db->where('posisi_id', $karyawan['atasan1']);
                    $this->db->where('dept_id', $karyawan['dept_id']);
                    $atasan1 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan1'] == 4) {
                    $this->db->where('posisi_id', $karyawan['atasan1']);
                    $this->db->where('dept_id', $karyawan['dept_id']);
                    $atasan1 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan1'] == 5) {
                    $this->db->where('posisi_id', $karyawan['atasan1']);
                    $this->db->where('sect_id', $karyawan['sect_id']);
                    $atasan1 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan1'] == 6) {
                    $this->db->where('posisi_id', $karyawan['atasan1']);
                    $this->db->where('sect_id', $karyawan['sect_id']);
                    $atasan1 = $this->db->get('karyawan')->row_array();
                };
                //cari atasan 1
                if ($karyawan['atasan2'] == 0) {
                    $atasan2 = $atasan2 = $this->db->get_where('karyawan', ['posisi_id' =>  '0'])->row_array();
                } elseif ($karyawan['atasan2'] == 1) {
                    $atasan2 = $this->db->get_where('karyawan', ['posisi_id' =>  '1'])->row_array();
                } elseif ($karyawan['atasan2'] == 2) {
                    $this->db->where('posisi_id', $karyawan['atasan2']);
                    $this->db->where('div_id', $karyawan['div_id']);
                    $atasan2 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan2'] == 3) {
                    $this->db->where('posisi_id', $karyawan['atasan2']);
                    $this->db->where('dept_id', $karyawan['dept_id']);
                    $atasan2 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan2'] == 4) {
                    $this->db->where('posisi_id', $karyawan['atasan2']);
                    $this->db->where('dept_id', $karyawan['dept_id']);
                    $atasan2 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan2'] == 5) {
                    $this->db->where('posisi_id', $karyawan['atasan2']);
                    $this->db->where('sect_id', $karyawan['sect_id']);
                    $atasan2 = $this->db->get('karyawan')->row_array();
                } elseif ($karyawan['atasan2'] == 6) {
                    $this->db->where('posisi_id', $karyawan['atasan2']);
                    $this->db->where('sect_id', $karyawan['sect_id']);
                    $atasan2 = $this->db->get('karyawan')->row_array();
                };
                $data = [
                    'npk' => $karyawan['npk'],
                    'inisial' => $karyawan['inisial'],
                    'nama' => $karyawan['nama'],
                    'posisi_id' => $karyawan['posisi_id'],
                    'div_id' => $karyawan['div_id'],
                    'dept_id' => $karyawan['dept_id'],
                    'sect_id' => $karyawan['sect_id'],
                    'atasan1' => $atasan1['npk'],
                    'atasan2' => $atasan2['npk'],
                    'role_id' => $karyawan['role_id']
                ];
                $this->session->set_userdata($data);
                $this->session->set_flashdata('message', 'masuk');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf!</strong> Password kamu SALAH.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf!</strong> NPK Tidak ditemukan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('npk');
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Terima kasih!</strong> Telah menggunakan RAISA.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('auth');
    }

    public function denied()
    {
        $this->load->view('auth/denied');
    }
}
