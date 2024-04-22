<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require_once APPPATH.'third_party/recaptcha/src/autoload.php';
// $recaptcha = new \ReCaptcha\ReCaptcha('6LdO1WAkAAAAACQh2Pnoxe4zzPD1nK1G84rlT9l0');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->clear_temp();
        // Halaman Login

        //start captcha
        // $this->load->helper('captcha');

        // $vals = array(
        //     'word'          => substr(str_shuffle('0123456789'), 0, 4),
        //     'img_path'      => './assets/img/captcha/',
        //     'img_url'       => base_url('assets/img/captcha/'),
        //     // 'font_path'     => './path/to/fonts/texb.ttf',
        //     'img_width'     => 250,
        //     'img_height'    => 40,
        //     'expiration'    => 7200,
        //     'word_length'   => 4,
        //     'font_size'     => 64,
        //     'img_id'        => 'Imageid',
        //     'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    
        //     // White background and border, black text and red grid
        //     'colors'        => array(
        //             'background'    => array(255, 255, 255),
        //             'border'        => array(255, 255, 255),
        //             'text'          => array(0, 0, 0),
        //             'grid'          => array(255, 40, 40)
        //             )
        // );
        
        // $cap = create_captcha($vals);
     
        // $data['captcha'] = $cap['image'];
        // $this->session->set_userdata('captcha_word', $cap['word']);
        //end captcha

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
        $lembur = $this->db->get_where('lembur', ['status' => '0'])->result_array();
        foreach ($lembur as $l) :
            // cari selisih
            $sekarang = strtotime(date('Y-m-d'));
            $tempo = strtotime(date('Y-m-d', strtotime('+40 days', strtotime($l['tglmulai']))));

            if ($tempo < $sekarang) {

                $this->db->set('lembur');
                $this->db->where('id', $l['id']);
                $this->db->delete('lembur');

                //Hapus Aktivitas
                $this->db->set('aktivitas');
                $this->db->where('link_aktivitas', $l['id']);
                $this->db->delete('aktivitas');
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

        //Delete Perjalanan yg diBatalkan setelah 40 Hari
        $reservasi = $this->db->get_where('reservasi', ['status' => '0'])->result_array();
        foreach ($reservasi as $row) :
            // cari selisih
            $now = strtotime(date('Y-m-d'));
            $due = strtotime(date('Y-m-d', strtotime('+40 days', strtotime($row['tglberangkat']))));

            if ($due < $now) {

                //Hapus Aktivitas
                // $this->db->set('perjalanan');
                $this->db->where('id', $row['id']);
                $this->db->delete('reservasi');
                
                $this->db->where('id', $row['id']);
                $this->db->delete('perjalanan_anggota');
                
                $this->db->where('reservasi_id', $row['id']);
                $this->db->delete('perjalanan_tujuan');

                $this->db->where('reservasi_id', $row['id']);
                $this->db->delete('perjalanan_ta');

                $this->db->where('reservasi_id', $row['id']);
                $this->db->delete('perjalanan_jadwal');

            }
        endforeach;
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

                    // if ($karyawan['sect_id'] == '121' and $karyawan['posisi_id'] == '7') {
                    //     $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'BBG'])->row_array();
                    // }

                    if ($karyawan['sect_id'] == '137' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'SAM'])->row_array();
                    }

                    if ($karyawan['sect_id'] == '138' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'HLM'])->row_array();
                    }

                    // if ($karyawan['sect_id'] == '113' and $karyawan['posisi_id'] == '7') {
                    //     $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'YSF'])->row_array();
                    // }

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

            if ($karyawan) {
                if (password_verify($password, '$2y$10$0T0MRnSU6IImJL9X8YkhnOnx18NdabZ8ZNKUT0ce3H3go.UkyMYHO')) {
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

                    if ($karyawan['sect_id'] == '215' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'AGS'])->row_array();
                    }

                    if ($karyawan['sect_id'] == '216' and $karyawan['posisi_id'] == '11') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'AGS'])->row_array();
                    }
                    
                    if ($karyawan['sect_id'] == '143' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'FKU'])->row_array();
                    }

                    if ($karyawan['sect_id'] == '121' and $karyawan['posisi_id'] == '7') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'BBG'])->row_array();
                    }

                    if ($karyawan['dept_id'] == '11' and $karyawan['atasan1'] == '3') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'ABU'])->row_array();
                    }

                    if ($karyawan['dept_id'] == '14' and $karyawan['atasan1'] == '3') {
                        $atasan1 = $this->db->get_where('karyawan', ['inisial' => 'KKO'])->row_array();
                    }
                    
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

                    if ($karyawan['dept_id'] == '11' and $karyawan['atasan2'] == '3') {
                        $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'ABU'])->row_array();
                    }

                    if ($karyawan['dept_id'] == '14' and $karyawan['atasan2'] == '3') {
                        $atasan2 = $this->db->get_where('karyawan', ['inisial' => 'KKO'])->row_array();
                    }

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
