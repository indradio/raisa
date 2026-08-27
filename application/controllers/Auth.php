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
            $this->db->where_in('reservasi_id', $reservasi_ids)->delete('perjalanan_anggota');
            $this->db->where_in('reservasi_id', $reservasi_ids)->delete('perjalanan_tujuan');
            $this->db->where_in('reservasi_id', $reservasi_ids)->delete('perjalanan_ta');
            $this->db->where_in('reservasi_id', $reservasi_ids)->delete('perjalanan_jadwal');
        }

    }

    public function login()
    {
        // Login hanya boleh melalui POST.
        if (strtoupper($this->input->method()) !== 'POST') {
            show_error('Method Not Allowed', 405);
            return;
        }

        /*
         * Basic brute-force protection.
         *
         * Catatan:
         * - Counter disimpan di session sehingga tidak membutuhkan tabel baru.
         * - Untuk production/public internet, sebaiknya ditambah rate limiting
         *   berbasis IP/NPK di Redis/database/WAF.
         */
        $max_attempts = 5;
        $lock_seconds = 300; // 5 menit

        $attempts = (int) $this->session->userdata('login_attempts');
        $locked_until = (int) $this->session->userdata('login_locked_until');

        if ($locked_until > time()) {
            $remaining = ceil(($locked_until - time()) / 60);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-rose">
                    <strong>Login ditolak</strong>
                    <span>Terlalu banyak percobaan login. Silakan coba lagi sekitar ' .
                    (int) $remaining . ' menit.</span>
                </div><br>'
            );

            redirect('auth');
            return;
        }

        // Reset lock yang sudah expired.
        if ($locked_until > 0 && $locked_until <= time()) {
            $this->session->unset_userdata('login_locked_until');
            $attempts = 0;
            $this->session->set_userdata('login_attempts', 0);
        }

        // Ambil input sebagai string dan trim hanya NPK.
        $npk = trim((string) $this->input->post('npk', TRUE));
        $password = (string) $this->input->post('pwd', FALSE);

        // Validasi input dasar.
        if ($npk === '' || $password === '') {
            $this->record_login_failure($attempts, $max_attempts, $lock_seconds);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-rose">
                    <strong>Login Gagal</strong>
                    <span>NPK dan password wajib diisi.</span>
                </div><br>'
            );
            redirect('auth');
            return;
        }

        // NPK RAISA saat ini 4 digit. Validasi di server, bukan hanya di HTML.
        if (!preg_match('/^\d{4}$/', $npk)) {
            $this->record_login_failure($attempts, $max_attempts, $lock_seconds);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-rose">
                    <strong>Login Gagal</strong>
                    <span>Format NPK tidak valid.</span>
                </div><br>'
            );
            redirect('auth');
            return;
        }

        // Gunakan Query Builder untuk menghindari SQL Injection.
        $karyawan = $this->db
            ->where('npk', $npk)
            ->where('is_active', '1')
            ->limit(1)
            ->get('karyawan')
            ->row_array();

        /*
         * Gunakan pesan yang sama untuk NPK/password salah.
         * Ini mencegah user enumeration (attacker tidak bisa membedakan
         * NPK yang ada dan yang tidak ada hanya dari response).
         */
        if (!$karyawan || empty($karyawan['password']) ||
            !password_verify($password, $karyawan['password'])) {

            $this->record_login_failure($attempts, $max_attempts, $lock_seconds);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-rose">
                    <strong>Login Gagal</strong>
                    <span>NPK atau password yang kamu masukkan salah.</span>
                </div><br>'
            );

            redirect('auth');
            return;
        }

        /*
         * Jika algoritma/cost password berubah di masa depan, password akan
         * di-upgrade otomatis setelah login berhasil.
         */
        if (password_needs_rehash($karyawan['password'], PASSWORD_DEFAULT)) {
            $new_hash = password_hash($password, PASSWORD_DEFAULT);

            if ($new_hash !== false) {
                $this->db
                    ->where('npk', $karyawan['npk'])
                    ->update('karyawan', ['password' => $new_hash]);
            }
        }

        /*
         * Reset brute-force counter setelah login sukses.
         */
        $this->session->unset_userdata([
            'login_attempts',
            'login_locked_until'
        ]);

        /*
         * Cari atasan 1.
         * Logic bisnis existing dipertahankan.
         */
        $atasan1 = $this->get_atasan($karyawan, 'atasan1');

        /*
         * Override bisnis existing.
         */
        if ($karyawan['sect_id'] == '112' && $karyawan['posisi_id'] == '7') {
            $atasan1 = $this->db
                ->where('inisial', 'ANS')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if ($karyawan['sect_id'] == '114' && $karyawan['posisi_id'] == '7') {
            $atasan1 = $this->db
                ->where('inisial', 'DBY')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if ($karyawan['sect_id'] == '137' && $karyawan['posisi_id'] == '7') {
            $atasan1 = $this->db
                ->where('inisial', 'SAM')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if ($karyawan['sect_id'] == '138' && $karyawan['posisi_id'] == '7') {
            $atasan1 = $this->db
                ->where('inisial', 'HLM')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if (!empty($atasan1) && $atasan1['inisial'] == 'DBY') {
            $atasan1 = $this->db
                ->where('inisial', 'WHS')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if (!empty($atasan1) && $atasan1['inisial'] == 'DNO') {
            $atasan1 = $this->db
                ->where('inisial', 'FHP')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        /*
         * Cari atasan 2.
         */
        $atasan2 = $this->get_atasan($karyawan, 'atasan2');

        if (!empty($atasan2) && $atasan2['inisial'] == 'DNO') {
            $atasan2 = $this->db
                ->where('inisial', 'FHP')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        /*
         * Special account existing.
         */
        if ($karyawan['npk'] == '1111') {
            $raisa = $this->db
                ->where('inisial', 'RAISA')
                ->limit(1)
                ->get('karyawan')
                ->row_array();

            if ($raisa) {
                $atasan1 = $raisa;
                $atasan2 = $raisa;
            }
        }

        /*
         * Pastikan data atasan tersedia sebelum mengakses array.
         * Ini mencegah warning/error ketika master atasan tidak ditemukan.
         */
        if (empty($atasan1) || empty($atasan2)) {
            log_message(
                'error',
                'Login berhasil tetapi master atasan tidak ditemukan untuk NPK: ' .
                $karyawan['npk']
            );

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-rose">
                    <strong>Login tidak dapat diproses</strong>
                    <span>Data organisasi akun belum lengkap. Hubungi administrator.</span>
                </div><br>'
            );

            redirect('auth');
            return;
        }

        /*
         * CRITICAL:
         * Regenerasi session ID setelah autentikasi berhasil untuk mencegah
         * session fixation.
         */
        $this->session->sess_regenerate(TRUE);

        $data = [
            'npk'             => $karyawan['npk'],
            'inisial'         => $karyawan['inisial'],
            'nama'            => $karyawan['nama'],
            'gol_id'          => $karyawan['gol_id'],
            'posisi_id'       => $karyawan['posisi_id'],
            'div_id'          => $karyawan['div_id'],
            'dept_id'         => $karyawan['dept_id'],
            'sect_id'         => $karyawan['sect_id'],
            'atasan1'         => $atasan1['npk'],
            'atasan1_inisial' => $atasan1['inisial'],
            'atasan2'         => $atasan2['npk'],
            'atasan2_inisial' => $atasan2['inisial'],
            'contract'        => $karyawan['work_contract'],
            'role_id'         => $karyawan['role_id']
        ];

        $this->session->set_userdata($data);
        $this->session->set_flashdata('message', 'masuk');

        // Audit login.
        $this->db->insert('log', [
            'npk'      => $karyawan['npk'],
            'activity' => 'Login to RAISA'
        ]);

        // Update last login berdasarkan NPK hasil query, bukan input mentah.
        $this->db
            ->where('npk', $karyawan['npk'])
            ->update('karyawan', [
                'last_login' => date('Y-m-d H:i:s')
            ]);

        redirect('dashboard');
    }

    /**
     * Mengambil atasan berdasarkan aturan organisasi existing.
     */
    private function get_atasan($karyawan, $field)
    {
        $atasan_id = isset($karyawan[$field]) ? $karyawan[$field] : null;

        if ($atasan_id === '0' || $atasan_id === 0) {
            return $this->db
                ->where('posisi_id', '0')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if ($atasan_id === '1' || $atasan_id === 1) {
            return $this->db
                ->where('posisi_id', '1')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if (in_array((string) $atasan_id, ['2'], TRUE)) {
            return $this->db
                ->where('posisi_id', $atasan_id)
                ->where('div_id', $karyawan['div_id'])
                ->where('is_active', '1')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if (in_array((string) $atasan_id, ['3', '4'], TRUE)) {
            return $this->db
                ->where('posisi_id', $atasan_id)
                ->where('dept_id', $karyawan['dept_id'])
                ->where('is_active', '1')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        if (in_array((string) $atasan_id, ['5', '6'], TRUE)) {
            return $this->db
                ->where('posisi_id', $atasan_id)
                ->where('sect_id', $karyawan['sect_id'])
                ->where('is_active', '1')
                ->limit(1)
                ->get('karyawan')
                ->row_array();
        }

        return [];
    }

    /**
     * Catat kegagalan login dan lock session jika melewati batas.
     */
    private function record_login_failure($attempts, $max_attempts, $lock_seconds)
    {
        $attempts++;

        $this->session->set_userdata('login_attempts', $attempts);

        if ($attempts >= $max_attempts) {
            $this->session->set_userdata(
                'login_locked_until',
                time() + $lock_seconds
            );
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

    public function admin($param=null)
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
