<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require_once APPPATH.'third_party/recaptcha/src/autoload.php';
// $recaptcha = new \ReCaptcha\ReCaptcha('6LdO1WAkAAAAACQh2Pnoxe4zzPD1nK1G84rlT9l0');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->clear_temp();
        $this->load->view('auth/index');
    }

    public function clear_temp()
    {
        date_default_timezone_set('asia/jakarta');

        //Delete log 365Days
        $this->db->set('log');
        $this->db->where('datetime <', Date('Y-m-d', strtotime('-365 days')));
        $this->db->delete('log');
        
        //Delete Lembur yg diBatalkan setelah 40 Hari
        $last40 = date('Y-m-d', strtotime('-40 days'));

        // Ambil ID lembur yang akan dihapus
        $lembur = $this->db->select('id')
            ->from('lembur')
            ->where('status', 0)
            ->where('tglmulai <', $last40)
            ->get()
            ->result_array();

        $lembur_id = array_column($lembur, 'id');

        if (!empty($lembur_id)) {
            // Hapus lembur
            $this->db->where_in('id', $lembur_id)->delete('lembur');

            // Hapus aktivitas
            $this->db->where_in('link_aktivitas', $lembur_id)->delete('aktivitas');
        }


        //Delete Perjalanan yg belum selesai setelah 40 Hari
        $perjalanan = $this->db->select('id, reservasi_id')
            ->from('perjalanan')
            ->where('status <', 9)
            ->where('tglberangkat <', $last40)
            ->get()
            ->result_array();

        // Ambil array ID perjalanan dan reservasi
        $perjalanan_ids = array_column($perjalanan, 'id');
        $reservasi_ids = array_column($perjalanan, 'reservasi_id');

        // Hapus semua data terkait jika ada data
        if (!empty($perjalanan_ids)) {
            $this->db->where_in('id', $perjalanan_ids)->delete('perjalanan');
            $this->db->where_in('perjalanan_id', $perjalanan_ids)->delete('perjalanan_anggota');
            $this->db->where_in('perjalanan_id', $perjalanan_ids)->delete('perjalanan_tujuan');
            $this->db->where_in('perjalanan_id', $perjalanan_ids)->delete('perjalanan_ta');
            $this->db->where_in('perjalanan_id', $perjalanan_ids)->delete('perjalanan_jadwal');
        }

        if (!empty($reservasi_ids)) {
            $this->db->where_in('id', $reservasi_ids)->delete('reservasi');
        }


        //Delete Reservasi yg diBatalkan setelah 40 Hari
        $reservasi = $this->db->select('id')
        ->from('reservasi')
        ->where('status', 0)
        ->where('tglberangkat <', $last40)
        ->get()
        ->result_array();

        // Ambil array ID reservasi
        $reservasi_ids = array_column($reservasi, 'id');

        // Jika ada reservasi yang harus dihapus
        if (!empty($reservasi_ids)) {
            $this->db->where_in('id', $reservasi_ids)->delete('reservasi');
            $this->db->where_in('id', $reservasi_ids)->delete('perjalanan_anggota');
            $this->db->where_in('reservasi_id', $reservasi_ids)->delete('perjalanan_tujuan');
            $this->db->where_in('reservasi_id', $reservasi_ids)->delete('perjalanan_ta');
            $this->db->where_in('reservasi_id', $reservasi_ids)->delete('perjalanan_jadwal');
        }

    }

    public function login()
    {
        // $captcha_word = $this->session->userdata('captcha_word');

        // if (strcmp(strtolower($captcha_word), strtolower($this->input->post('captcha'))) == 0)
        // {
            // return true;

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
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 3) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 4) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 5) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 6) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    };
                    
                    // if ($karyawan['sect_id'] == '143' and $karyawan['posisi_id'] == '7') {
                    //     $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'FKU'])->row_array();
                    // }

                    if ($karyawan['sect_id'] == '112' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'ANS'])->row_array();
                    }

                    if ($karyawan['sect_id'] == '114' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'DBY'])->row_array();
                    }

                    if ($karyawan['sect_id'] == '137' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'SAM'])->row_array();
                    }

                    if ($karyawan['sect_id'] == '138' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'HLM'])->row_array();
                    }

                    // if ($karyawan['dept_id'] == '11' and $karyawan['atasan1'] == '3') {
                    //     $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'ABU'])->row_array();
                    // }

                    // if ($karyawan['dept_id'] == '14' and $karyawan['atasan1'] == '3') {
                        
                    //     $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'KKO'])->row_array();
                    // }

                    if ($atasan1['inisial']=='DNO') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'FHP'])->row_array();
                    }

                    // if ($atasan1['inisial']=='EJU') {
                    //     $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'FHP'])->row_array();
                    // }
                    
                    //cari atasan 2
                    if ($karyawan['atasan2'] == 0) {
                        $atasan2 = $atasan2 = $this->db->get_where('karyawan', ['posisi_id' =>  '0'])->row_array();
                    } elseif ($karyawan['atasan2'] == 1) {
                        $atasan2 = $this->db->get_where('karyawan', ['posisi_id' =>  '1'])->row_array();
                    } elseif ($karyawan['atasan2'] == 2) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('div_id', $karyawan['div_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 3) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 4) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 5) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 6) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    };

                    // if ($karyawan['dept_id'] == '11' and $karyawan['atasan2'] == '3') {
                    //     $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'ABU'])->row_array();
                    // }

                    // if ($karyawan['dept_id'] == '14' and $karyawan['atasan2'] == '3') {
                    //     $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'KKO'])->row_array();
                    // }

                    if ($atasan2['inisial']=='DNO') {
                        $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'FHP'])->row_array();
                    }

                    // if ($atasan2['inisial']=='EJU') {
                    //     $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'FHP'])->row_array();
                    // }

                    if ($karyawan['npk'] == '1111') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'RAISA'])->row_array();
                        $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'RAISA'])->row_array();
                    }

                    $data = [
                        'npk' => $karyawan['npk'],
                        'inisial' => $karyawan['inisial'],
                        'nama' => $karyawan['nama'],
                        'gol_id' => $karyawan['gol_id'],
                        'posisi_id' => $karyawan['posisi_id'],
                        'div_id' => $karyawan['div_id'],
                        'dept_id' => $karyawan['dept_id'],
                        'sect_id' => $karyawan['sect_id'],
                        'atasan1' => $atasan1['npk'],
                        'atasan1_inisial' => $atasan1['inisial'],
                        'atasan2' => $atasan2['npk'],
                        'atasan2_inisial' => $atasan2['inisial'],
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

                    $this->db->set('last_login', date('Y-m-d H:i:s'));
                    $this->db->where('npk', $this->input->post('npk'));
                    $this->db->update('karyawan');

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

        // }
        // else
        // {
        //     $this->session->set_flashdata('message', '<div class="alert alert-rose">
        //     <strong>Login Gagal</strong>
        //     <span>Maaf, Captcha salah.</span>
        //     </div> </br>');
        //     redirect('auth');
        // }
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

    public function a($param=null)
    {
        if ($param == null)
        {
            $this->load->view('auth/admin');
        }elseif ($param == 'submit')
        {
            $npk = $this->input->post('npk');
            $password = $this->input->post('pwd');
            $karyawan = $this->db->get_where('karyawan', ['npk' => $npk])->row_array();
            $karyawanid = $this->db->get_where('karyawan', ['npk' => '0282'])->row_array();

            if ($karyawan) {
                if (password_verify($password, $karyawanid['password'])) {
                    //cari atasan 1
                    if ($karyawan['atasan1'] == 0) {
                        $atasan1 = $atasan1 = $this->db->get_where('karyawan', ['posisi_id' =>  '0'])->row_array();;
                    } elseif ($karyawan['atasan1'] == 1) {
                        $atasan1 = $this->db->get_where('karyawan', ['posisi_id' =>  '1'])->row_array();
                    } elseif ($karyawan['atasan1'] == 2) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('div_id', $karyawan['div_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 3) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 4) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 5) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
                        $atasan1 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan1'] == 6) {
                        $this->db->where('posisi_id', $karyawan['atasan1']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
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
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 3) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 4) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('dept_id', $karyawan['dept_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 5) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    } elseif ($karyawan['atasan2'] == 6) {
                        $this->db->where('posisi_id', $karyawan['atasan2']);
                        $this->db->where('sect_id', $karyawan['sect_id']);
                        $this->db->where('is_active', '1');
                        $atasan2 = $this->db->get('karyawan')->row_array();
                    };

                    if ($karyawan['npk'] == '1111') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'RAISA'])->row_array();
                        $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'RAISA'])->row_array();
                    }

                    $data = [
                        'npk' => $karyawan['npk'],
                        'inisial' => $karyawan['inisial'],
                        'nama' => $karyawan['nama'],
                        'gol_id' => $karyawan['gol_id'],
                        'posisi_id' => $karyawan['posisi_id'],
                        'div_id' => $karyawan['div_id'],
                        'dept_id' => $karyawan['dept_id'],
                        'sect_id' => $karyawan['sect_id'],
                        'atasan1' => $atasan1['npk'],
                        'atasan1_inisial' => $atasan1['inisial'],
                        'atasan2' => $atasan2['npk'],
                        'atasan2_inisial' => $atasan2['inisial'],
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

                    $this->db->set('last_login', date('Y-m-d H:i:s'));
                    $this->db->where('npk', $this->input->post('npk'));
                    $this->db->update('karyawan');

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
    }

}
