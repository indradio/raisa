<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lembur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['npk' =>  $this->session->userdata('npk')])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/index', $data);
        $this->load->view('templates/footer');
    }


    public function rencana()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Rencana';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $npk = $this->session->userdata('npk');
        $queryLembur = "SELECT *
        FROM `lembur`
        WHERE( `status`= '1' OR `status`= '2' OR `status`= '3' OR `status`= '10' OR `status`= '11') and `npk`= '$npk' ";
        $data['lembur'] = $this->db->query($queryLembur)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/rencana', $data);
        $this->load->view('templates/footer');
    }

    public function realisasi()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Realisasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $npk = $this->session->userdata('npk');
        $queryLembur = "SELECT *
        FROM `lembur`
        WHERE( `status`= '4' OR `status`= '5' OR `status`= '6' OR `status`= '12' OR `status`= '13') and `npk`= '$npk' ";
        $data['lembur'] = $this->db->query($queryLembur)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/realisasi', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->db->where('tglmulai', date("Y-m-d 16:30:00"));
        $this->db->where('npk', $this->session->userdata('npk'));
        $ada = $this->db->get("lembur")->row_array();
        if ($ada['id'] == null) {

            if ($this->session->userdata('posisi_id') == 4 or $this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6 or $this->session->userdata('posisi_id') == 9) {
                date_default_timezone_set('asia/jakarta');
                $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
                $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();

                $this->db->where('posisi_id', '3');
                $this->db->where('dept_id', $karyawan['dept_id']);
                $ka_dept = $this->db->get('karyawan')->row_array();


                $queryLembur = "SELECT COUNT(*)
                FROM `lembur`
                WHERE YEAR(tglpengajuan) = YEAR(CURDATE())
                ";
                $lembur = $this->db->query($queryLembur)->row_array();
                $totalLembur = $lembur['COUNT(*)'] + 1;

                $mulai = strtotime($this->input->post('tglmulai'));
                $selesai = strtotime($this->input->post('tglselesai'));
                $durasi = $selesai - $mulai;
                $jam   = floor($durasi / (60 * 60));
                $menit = $durasi - $jam * (60 * 60);
                $menit = floor($menit / 60);

                $data = [
                    'id' => 'OT' . date('y') . date('m') . $totalLembur,
                    'tglpengajuan' => date('Y-m-d   H:i:s'),
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $karyawan['nama'],
                    'tglmulai' => date('Y-m-d 16:30:00'),
                    'tglselesai' => date('Y-m-d 16:30:00'),
                    'tglmulai_aktual' => date('Y-m-d 16:30:00'),
                    'tglselesai_aktual' => date('Y-m-d 16:30:00'),
                    'atasan1_rencana' => $atasan1['inisial'],
                    'atasan2_rencana' => $atasan2['inisial'],
                    'atasan1_realisasi' => $atasan1['inisial'],
                    'atasan2_realisasi' => $atasan2['inisial'],
                    'durasi' => $jam . ':' . $menit . ':00',
                    'status' => '1',
                    'posisi_id' => $karyawan['posisi_id'],
                    'div_id' => $karyawan['div_id'],
                    'dept_id' => $karyawan['dept_id'],
                    'sect_id' => $karyawan['sect_id']
                ];
                $this->db->insert('lembur', $data);

                redirect('lembur/rencana_aktivitas/' . $data['id']);
            } else {
                date_default_timezone_set('asia/jakarta');
                $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();
                $atasan2 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan2')])->row_array();


                $queryLembur = "SELECT COUNT(*)
                FROM `lembur`
                WHERE YEAR(tglpengajuan) = YEAR(CURDATE())
                ";
                $lembur = $this->db->query($queryLembur)->row_array();
                $totalLembur = $lembur['COUNT(*)'] + 1;

                $mulai = strtotime($this->input->post('tglmulai'));
                $selesai = strtotime($this->input->post('tglselesai'));
                $durasi = $selesai - $mulai;
                $jam   = floor($durasi / (60 * 60));
                $menit = $durasi - $jam * (60 * 60);
                $menit = floor($menit / 60);

                $data = [
                    'id' => 'OT' . date('y') . date('m') . $totalLembur,
                    'tglpengajuan' => date('Y-m-d   H:i:s'),
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $karyawan['nama'],
                    'tglmulai' => date('Y-m-d 16:30:00'),
                    'tglselesai' => date('Y-m-d 16:30:00'),
                    'tglmulai_aktual' => date('Y-m-d 16:30:00'),
                    'tglselesai_aktual' => date('Y-m-d 16:30:00'),
                    'atasan1_rencana' => $atasan1['inisial'],
                    'atasan2_rencana' => $atasan2['inisial'],
                    'atasan1_realisasi' => $atasan1['inisial'],
                    'atasan2_realisasi' => $atasan2['inisial'],
                    'durasi' => $jam . ':' . $menit . ':00',
                    'status' => '1',
                    'posisi_id' => $karyawan['posisi_id'],
                    'div_id' => $karyawan['div_id'],
                    'dept_id' => $karyawan['dept_id'],
                    'sect_id' => $karyawan['sect_id']
                ];
                $this->db->insert('lembur', $data);

                redirect('lembur/rencana_aktivitas/' . $data['id']);
            }
        } else {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $ada['id']])->row_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $ada['id']])->result_array();
            $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/rencana_aktivitas', $data);
            $this->load->view('templates/footer');
        }
    }

    public function rencana_aktivitas($id)
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Rencana';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/rencana_aktivitas', $data);
        $this->load->view('templates/footer');
    }

    public function realisasi_aktivitas($id)
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Realisasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/realisasi_aktivitas', $data);
        $this->load->view('templates/footer');
    }

    public function lemburku($id)
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $data['aktivitas_status'] = $this->db->get('aktivitas_status')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/lemburku', $data);
        $this->load->view('templates/footer');
    }


    public function tambah_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();

        $thnlembur = date('Y', strtotime($lembur['tglmulai']));
        $blnlembur = date('m', strtotime($lembur['tglmulai']));

        $copro = $this->input->post('copro');
        $kategori = $this->input->post('kategori');

        $queryLembur = "SELECT COUNT(*) FROM aktivitas WHERE '$copro'";
        $queryKategori = "SELECT COUNT(*) FROM aktivitas WHERE kategori='3'";

        $totalKategori = $this->db->query($queryKategori)->row_array();
        $tA = $totalKategori['COUNT(*)'] + 1;
        $totalLembur = $this->db->query($queryLembur)->row_array();
        $totalAktivitas = $totalLembur['COUNT(*)'] + 1;

        $durasiPost = $this->input->post('durasi');
        $jam = $durasiPost / 60;


        if ($copro == 0) {
            $data = [
                'id' => 'AK-' . date('y') . $tA . date('s'),
                'npk' => $this->session->userdata('npk'),
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => $jam,
                'deskripsi_hasil' => '-',
                'status' => '1'
            ];
            $this->db->insert('aktivitas', $data);
        } else {
            $data = [
                'id' => 'AK-' . $copro . $totalAktivitas . date('s'),
                'npk' => $this->session->userdata('npk'),
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => $jam,
                'deskripsi_hasil' => '-',
                'status' => '1'
            ];
            $this->db->insert('aktivitas', $data);
        }

        $updatejam = date('Y-m-d H:i:s', strtotime($data['durasi_menit'], strtotime($lembur['tglselesai'])));
        $mulai = strtotime($lembur['tglmulai']);
        $selesai = strtotime($updatejam);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        $this->db->set('tglselesai', $updatejam);
        $this->db->set('durasi', $jam . ':' . $menit . ':00');
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        redirect('lembur/rencana_aktivitas/' . $this->input->post('link_aktivitas'));
    }

    public function tambah_aktivitas_realisasi()
    {

        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();

        $thnlembur = date('Y', strtotime($lembur['tglmulai']));
        $blnlembur = date('m', strtotime($lembur['tglmulai']));

        $copro = $this->input->post('copro');
        $kategori = $this->input->post('kategori');

        $queryLembur = "SELECT COUNT(*) FROM aktivitas WHERE '$copro'";
        $queryKategori = "SELECT COUNT(*) FROM aktivitas WHERE kategori='3'";

        $totalKategori = $this->db->query($queryKategori)->row_array();
        $tA = $totalKategori['COUNT(*)'] + 1;
        $totalLembur = $this->db->query($queryLembur)->row_array();
        $totalAktivitas = $totalLembur['COUNT(*)'] + 1;

        $durasiPost = $this->input->post('durasi');
        $jam = $durasiPost / 60;


        if ($copro == 0) {
            $data = [
                'id' => 'AK-' . date('y') . $tA . date('s'),
                'npk' => $this->session->userdata('npk'),
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'durasi' => $jam,
                'durasi_menit' => $this->input->post('durasi'),
                'deskripsi_hasil' => $this->input->post('deskripsi_hasil'),
                'progres_hasil' => $this->input->post('progres_hasil1'),
                'status' => $this->input->post('status2')
            ];
            $this->db->insert('aktivitas', $data);
        } else {
            $data = [
                'id' => 'AK-' . $copro . $totalAktivitas . date('s'),
                'npk' => $this->session->userdata('npk'),
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'durasi' => $jam,
                'durasi_menit' => $this->input->post('durasi'),
                'deskripsi_hasil' => $this->input->post('deskripsi_hasil'),
                'progres_hasil' => $this->input->post('progres_hasil1'),
                'status' => $this->input->post('status2')
            ];
            $this->db->insert('aktivitas', $data);

            $updatejam = date('Y-m-d H:i:s', strtotime($data['durasi_menit'], strtotime($lembur['tglselesai_aktual'])));
            $mulai = strtotime($lembur['tglmulai_aktual']);
            $selesai = strtotime($updatejam);
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));
            $menit = $durasi - $jam * (60 * 60);
            $menit = floor($menit / 60);

            $this->db->set('tglselesai_aktual', $updatejam);
            $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('link_aktivitas'));
            $this->db->update('lembur');

            redirect('lembur/realisasi_aktivitas/' . $this->input->post('link_aktivitas'));
        }
    }

    public function tambah_aktivitas_sect()
    {
        date_default_timezone_set('asia/jakarta');
        $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();

        $thnlembur = date('Y', strtotime($lembur['tglmulai']));
        $blnlembur = date('m', strtotime($lembur['tglmulai']));

        $copro = $this->input->post('copro');
        $kategori = $this->input->post('kategori');

        $queryLembur = "SELECT COUNT(*) FROM aktivitas WHERE '$copro'";
        $queryKategori = "SELECT COUNT(*) FROM aktivitas WHERE kategori='3'";

        $totalKategori = $this->db->query($queryKategori)->row_array();
        $tA = $totalKategori['COUNT(*)'] + 1;
        $totalLembur = $this->db->query($queryLembur)->row_array();
        $totalAktivitas = $totalLembur['COUNT(*)'] + 1;

        $durasiPost = $this->input->post('durasi');
        $jam = $durasiPost / 60;

        if ($copro == 0) {
            $data = [
                'id' => 'AK-' . date('y') . $tA . date('s'),
                'npk' => $this->session->userdata('npk'),
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => $jam,
                'deskripsi_hasil' => '-',
                'status' => '1'
            ];
            $this->db->insert('aktivitas', $data);

        } else {
            $data = [
                'id' => 'AK-' . $copro . $totalAktivitas . date('s'),
                'npk' => $this->session->userdata('npk'),
                'tgl_aktivitas' => $lembur['tglmulai'],
                'jenis_aktivitas' => 'LEMBUR',
                'link_aktivitas' => $this->input->post('link_aktivitas'),
                'kategori' => $this->input->post('kategori'),
                'copro' => $this->input->post('copro'),
                'aktivitas' => $this->input->post('aktivitas'),
                'durasi_menit' => $this->input->post('durasi'),
                'durasi' => $jam,
                'deskripsi_hasil' => '-',
                'status' => '1'
            ];
            $this->db->insert('aktivitas', $data);
        }
            $updatejam = date('Y-m-d H:i:s', strtotime($data['durasi_menit'], strtotime($lembur['tglselesai'])));
            $mulai = strtotime($lembur['tglmulai']);
            $selesai = strtotime($updatejam);
            $durasi = $selesai - $mulai;
            $jam   = floor($durasi / (60 * 60));
            $menit = $durasi - $jam * (60 * 60);
            $menit = floor($menit / 60);

            $this->db->set('tglselesai', $updatejam);
            $this->db->set('durasi', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('link_aktivitas'));
            $this->db->update('lembur');

            redirect('lembur/persetujuan_aktivitas_sect/' . $this->input->post('link_aktivitas'));
    }

    public function tambah_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $durasiPost = $this->input->post('durasi');
        $jam = $durasiPost / 60;

        $this->db->set('deskripsi_hasil', $this->input->post('deskripsi_hasil'));
        $this->db->set('durasi_menit', $this->input->post('durasi'));
        $this->db->set('durasi', $jam);
        $this->db->set('progres_hasil', $this->input->post('progres_hasil'));
        $this->db->set('status', $this->input->post('status1'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('aktivitas');

        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row_array();
        $durasiMenit = $aktivitas['durasi_menit'];
        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $updatejam = date('Y-m-d H:i:s', strtotime('+' . $durasiMenit . ' minute', strtotime($lembur['tglselesai_aktual'])));

        $mulai = strtotime($lembur['tglmulai_aktual']);
        $selesai = strtotime($updatejam);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        $this->db->set('tglselesai_aktual', $updatejam);
        $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');


        redirect('lembur/realisasi_aktivitas/' . $this->input->post('link_aktivitas'));
    }

    public function hapus($id)
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $a = $aktivitas['link_aktivitas'];
        $jam = $aktivitas['durasi_menit'];

        $this->db->set('aktivitas');
        $this->db->where('id', $id);
        $this->db->delete('aktivitas');

        $lembur = $this->db->get_where('lembur', ['id' => $aktivitas['link_aktivitas']])->row_array();
        $updatejam = date('Y-m-d H:i:s', strtotime('-' . $jam . ' minute', strtotime($lembur['tglselesai'])));
        $mulai = strtotime($lembur['tglmulai']);
        $selesai = strtotime($updatejam);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        $this->db->set('tglselesai', $updatejam);
        $this->db->set('durasi', $jam . ':' . $menit . ':00');
        $this->db->where('id', $a);
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'hapus');
        redirect('lembur/rencana_aktivitas/' . $a);
    }

    public function hapus_sect($id)
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $a = $aktivitas['link_aktivitas'];
        $jam = $aktivitas['durasi_menit'];

        $this->db->set('aktivitas');
        $this->db->where('id', $id);
        $this->db->delete('aktivitas');

        $lembur = $this->db->get_where('lembur', ['id' => $aktivitas['link_aktivitas']])->row_array();
        $updatejam = date('Y-m-d H:i:s', strtotime('-' . $jam . ' minute', strtotime($lembur['tglselesai'])));
        $mulai = strtotime($lembur['tglmulai']);
        $selesai = strtotime($updatejam);
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        $this->db->set('tglselesai', $updatejam);
        $this->db->set('durasi', $jam . ':' . $menit . ':00');
        $this->db->where('id', $a);
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'hapus');
        redirect('lembur/persetujuan_aktivitas_sect/' . $a);
    }

    public function ajukan_rencana()
    {
        $atasan1 = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('atasan1')])->row_array();

        $mulai = strtotime($this->input->post('tglmulai'));
        $selesai = strtotime($this->input->post('tglselesai'));
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        if ($this->session->userdata('posisi_id') <= 2) {
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d 00:00:00'));
            $this->db->set('status', '4');
            $this->db->set('durasi', $jam . ':' . $menit . ':00');
            $this->db->set('admin_ga', '-');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 3) {
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d 00:00:00'));
            $this->db->set('status', '2');
            $this->db->set('durasi', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 4 or $this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6 or $this->session->userdata('posisi_id') == 9) {
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d 00:00:00'));
            $this->db->set('status', '2');
            $this->db->set('durasi', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 7 or $this->session->userdata('posisi_id') == 10) {
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d 00:00:00'));
            $this->db->set('status', '2');
            $this->db->set('durasi', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        }
        redirect('lembur/rencana/');
    }

    public function ajukan_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $mulai = strtotime($this->input->post('tglmulai_aktual'));
        $selesai = strtotime($this->input->post('tglselesai_aktual'));
        $durasi = $selesai - $mulai;
        $jam   = floor($durasi / (60 * 60));
        $menit = $durasi - $jam * (60 * 60);
        $menit = floor($menit / 60);

        if ($this->session->userdata('posisi_id') <= 3) {
            $this->db->set('tglpengajuan', date('y-m-d H:i:s'));
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d 00:00:00'));
            $this->db->set('status', '7');
            $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 4 or $this->session->userdata('posisi_id') == 5 or $this->session->userdata('posisi_id') == 6 or $this->session->userdata('posisi_id') == 9) {
            $this->db->set('tglpengajuan', date('y-m-d H:i:s'));
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d 00:00:00'));
            $this->db->set('status', '5');
            $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } elseif ($this->session->userdata('posisi_id') == 7 or $this->session->userdata('posisi_id') == 10) {
            $this->db->set('tglpengajuan', date('y-m-d H:i:s'));
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d 00:00:00'));
            $this->db->set('status', '5');
            $this->db->set('durasi_aktual', $jam . ':' . $menit . ':00');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        }
        redirect('lembur/realisasi/');
    }

    public function persetujuan_lembur()
    {
        if ($this->session->userdata('posisi_id') == 3) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' or `atasan2_rencana` = '{$karyawan['inisial']}') and (`status`= '2' OR `status`= '3') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanakt', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('posisi_id') == 5) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' or `atasan2_rencana` = '{$karyawan['inisial']}') and (`status`= '2') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();
            $data['aktivitas'] = $this->db->get_where('aktivitas')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanakt', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('posisi_id') == 2) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE (`status`= '10') and (`durasi`>= '03:00:00') and (`div_id`= '{$karyawan['div_id']}') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanakt', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('posisi_id') == 1) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Rencana';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE (`status`= '11') and (`durasi`>= '06:00:00') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanakt', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('auth/denied');
        }
    }

    public function persetujuan_lemburga()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Konfirmasi Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $queryLembur = "SELECT *
        FROM `lembur`
        WHERE (`admin_ga`= '-') ";
        $data['lembur'] = $this->db->query($queryLembur)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuanga', $data);
        $this->load->view('templates/footer');
    }

    public function persetujuan_lemburhr()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Konfirmasi Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $queryLembur = "SELECT *
        FROM `lembur`
        WHERE (`status`= '7') ";
        $data['lembur'] = $this->db->query($queryLembur)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuanhr', $data);
        $this->load->view('templates/footer');
    }

    public function persetujuan_aktivitas($id)
    {

        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Persetujuan Rencana';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuan_aktivitas', $data);
        $this->load->view('templates/footer');
    }

    public function persetujuan_aktivitas_sect($id)
    {

        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Persetujuan Rencana';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuan_aktivitassect', $data);
        $this->load->view('templates/footer');
    }

    public function persetujuan_realisasi()
    {
        if ($this->session->userdata('posisi_id') == 3) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Realisasi';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' or `atasan2_rencana` = '{$karyawan['inisial']}') and (`status`= '5' OR `status`= '6') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();

            $id = $this->input->post('id');
            $queryAktivitas = "SELECT * 
            FROM `aktivitas`
            WHERE(`link_aktivitas` = '$id')";
            $data['aktivitas'] = $this->db->query($queryAktivitas)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanrls', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('posisi_id') == 5) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Realisasi';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE(`atasan1_rencana` = '{$karyawan['inisial']}' or `atasan2_rencana` = '{$karyawan['inisial']}') and (`status`= '5') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();

            $id = $this->input->post('id');
            $queryAktivitas = "SELECT * 
            FROM `aktivitas`
            WHERE(`link_aktivitas` = '$id')";
            $data['aktivitas'] = $this->db->query($queryAktivitas)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanrls', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('posisi_id') == 2) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Realisasi';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE (`durasi_aktual`>= '03:00:00') and (`div_id`= '{$karyawan['div_id']}' and (`status`= '12')) ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanrls', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('posisi_id') == 1) {
            $data['sidemenu'] = 'Lembur';
            $data['sidesubmenu'] = 'Persetujuan Realisasi';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $karyawan = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $queryLembur = "SELECT *
            FROM `lembur`
            WHERE (`durasi_aktual`>= '06:00:00') and (`status`= '13') ";
            $data['lembur'] = $this->db->query($queryLembur)->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/persetujuanrls', $data);
            $this->load->view('templates/footer');
        }else{
            $this->load->view('auth/denied');
        }
    }

    public function persetujuan_realisasi_aktivitas($id)
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'Persetujuan Realisasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur'] = $this->db->get_where('lembur', ['id' =>  $id])->row_array();
        $data['aktivitas'] = $this->db->get_where('aktivitas', ['link_aktivitas' =>  $id])->result_array();
        $data['kategori'] = $this->db->get_where('jamkerja_kategori')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/persetujuan_realisasi', $data);
        $this->load->view('templates/footer');
    }

    public function setujui_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $durasi = $this->input->post('durasi');

        if ($this->session->userdata('posisi_id') == 5) {
            $this->db->set('tgl_atasan1_rencana', date('y-m-d H:i:s'));
            $this->db->set('status', '3');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

        } else if ($this->session->userdata('posisi_id') == 3 and $durasi < '03:00:00') {
            // $this->db->set('tgl_atasan1_rencana', date('y-m-d H:i:s'));
            $this->db->set('tgl_atasan2_rencana', date('y-m-d H:i:s'));
            $this->db->set('status', '4');
            $this->db->set('admin_ga', '-');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

        } else if ($this->session->userdata('posisi_id') == 3 and $durasi >= '03:00:00') {
            $this->db->set('tgl_atasan2_rencana', date('y-m-d H:i:s'));
            $this->db->set('status', '10');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

        } else if ($this->session->userdata('posisi_id') == 2 and $durasi < '06:00:00') {
            $this->db->set('tgl_divhead_rencana', date('y-m-d H:i:s'));
            $this->db->set('status', '4');
            $this->db->set('admin_ga', '-');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
            
        } else if ($this->session->userdata('posisi_id') == 2 and $durasi >= '06:00:00') {
            $this->db->set('tgl_divhead_rencana', date('y-m-d H:i:s'));
            $this->db->set('status', '11');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

        } else if ($this->session->userdata('posisi_id') == 1 ) {
            $this->db->set('tgl_coo_rencana', date('y-m-d H:i:s'));
            $this->db->set('status', '4');
            $this->db->set('admin_ga', '-');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        }
        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_lembur/');
    }

    public function setujui_ga()
    {
        date_default_timezone_set('asia/jakarta');
        $admin_ga = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $lembur = $this->db->get_where('lembur')->result_array();
        // $ids = $this->input->post('checkbox');
        // $status['status'] = $this->db->get_where('lembur', ['id' =>  $ids])->result_array();

        $this->db->set('admin_ga', $admin_ga['inisial']);
        $this->db->set('tgl_admin_ga', date('y-m-d  H:i:s'));
        $this->db->where_in('id', $this->input->post('checkbox'));
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('lembur/persetujuan_lemburga/');
    }

    public function setujui_all($id)
    {
        date_default_timezone_set('asia/jakarta');
        $admin_ga = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $id])->result_array();

        $this->db->set('admin_ga', $admin_ga['inisial']);
        $this->db->set('tgl_admin_ga', date('y-m-d  H:i:s'));
        $this->db->where('admin_ga', '-');
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'setujuilbrga');
        redirect('lembur/persetujuan_lemburga/');
    }

    public function setujui_hr($id)
    {
        date_default_timezone_set('asia/jakarta');
        $admin_hr = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $lembur = $this->db->get_where('lembur', ['id' => $id])->row_array();
        $l = $lembur['id'];

        $this->db->set('admin_hr', $admin_hr['inisial']);
        $this->db->set('tgl_admin_hr', date('y-m-d  H:i:s'));
        $this->db->set('status', '9');
        $this->db->where('id', $id);
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_lemburhr/' . $l);
    }

    public function setujui_realisasi()
    {
        date_default_timezone_set('asia/jakarta');
        $durasi = $this->input->post('durasi');

        if ($this->session->userdata('posisi_id') == 5) {
            $this->db->set('tgl_atasan1_realisasi', date('y-m-d H:i:s'));
            $this->db->set('status', '6');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 3 and $durasi <= '03:00:00') {
            $this->db->set('tgl_atasan2_realisasi', date('y-m-d H:i:s'));
            $this->db->set('status', '7');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 3 and $durasi >= '03:00:00') {
            $this->db->set('tgl_atasan2_realisasi', date('y-m-d H:i:s'));
            $this->db->set('status', '12');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 2 and $durasi < '06:00:00') {
            $this->db->set('tgl_divhead_realisasi', date('y-m-d H:i:s'));
            $this->db->set('status', '7');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 2 and $durasi >= '06:00:00') {
            $this->db->set('tgl_divhead_realisasi', date('y-m-d H:i:s'));
            $this->db->set('status', '13');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        } else if ($this->session->userdata('posisi_id') == 1 and $durasi >= '06:00:00') {
            $this->db->set('tgl_coo_realisasi', date('y-m-d H:i:s'));
            $this->db->set('status', '7');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');
        }

        $this->session->set_flashdata('message', 'setujuilbrhr');
        redirect('lembur/persetujuan_realisasi/');
    }

    public function update_aktivitas()
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $this->input->post('id')])->row_array();
        $durasiMenit = $aktivitas['durasi_menit'];

        $durasiPost = $this->input->post('durasi');
        $jam = $durasiPost / 60;
        // $this->db->set('kategori', $this->input->post('kategori'));
        // $this->db->set('copro', $this->input->post('copro'));
        $this->db->set('aktivitas', $this->input->post('aktivitas'));
        $this->db->set('durasi_menit', $this->input->post('durasi'));
        $this->db->set('durasi', $jam);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('aktivitas');

        $link = $this->input->post('link_aktivitas');
        $this->db->select_sum('durasi_menit');
        $this->db->where('link_aktivitas', $link);
        $query = $this->db->get('aktivitas');
        $durasi = $query->row()->durasi_menit;

        $lembur = $this->db->get_where('lembur', ['id' => $this->input->post('link_aktivitas')])->row_array();
        $updatejam = date('Y-m-d H:i:s', strtotime('+' . $durasi . ' minute', strtotime($lembur['tglmulai'])));
        $mulai = strtotime($lembur['tglmulai']);
        $selesai = strtotime($updatejam);
        $durasij = $selesai - $mulai;
        $jamd   = floor($durasi / (60 * 60));
        $menit = $durasij - $jamd * (60 * 60);
        $menit = floor($menit / 60);

        $this->db->set('tglselesai', $updatejam);
        $this->db->set('durasi', $jamd . ':' . $menit . ':00');
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        redirect('lembur/persetujuan_aktivitas_sect/' . $this->input->post('link_aktivitas'));
    }

    public function batal_lembur()
    {
        date_default_timezone_set('asia/jakarta');
        $lbr = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
        if ($lbr['atasan1_rencana'] == $this->session->userdata['inisial']) {
            $this->db->set('catatan', "Dibatalkan oleh : " . $this->session->userdata['inisial'] . ", " . "Alasan Pembatalan : " . $this->input->post('catatan') . ", " . "Tgl" . " : " . date('y-m-d - H:i:s'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->session->set_flashdata('message', 'batalbr');
            redirect('lembur/persetujuan_lembur/');
        } elseif ($lbr['atasan2_rencana'] == $this->session->userdata['inisial']) {
            $this->db->set('catatan', "Dibatalkan oleh : " . $this->session->userdata['inisial'] . ", " . "Alasan Pembatalan : " . $this->input->post('catatan') . ", " . "Tgl" . " : " . date('y-m-d - H:i:s'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->session->set_flashdata('message', 'batalbr');
            redirect('lembur/persetujuan_lembur/');
        } else
            $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan') . ", " . "Tgl" . " : " . date('y-m-d - H:i:s'));
            $this->db->set('status', '0');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

        $this->session->set_flashdata('message', 'batalbr');
        redirect('lembur/rencana/');
    }

    public function batalkan_realiasi()
    {
        date_default_timezone_set('asia/jakarta');
        $lbr = $this->db->get_where('lembur', ['id' =>  $this->input->post('id')])->row_array();
        if ($lbr['atasan1_rencana'] == $this->session->userdata['inisial']) {
            $this->db->set('catatan', " Ralisasi Dibatalkan oleh : " . $this->session->userdata['inisial'] . ", " . "Alasan Pembatalan : " . $this->input->post('catatan') . ", " . "Tgl" . " : " . date('y-m-d - H:i:s'));
            $this->db->set('status', '8');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->session->set_flashdata('message', 'batalbr');
            redirect('lembur/realisasi/');
        } elseif ($lbr['atasan2_rencana'] == $this->session->userdata['inisial']) {
            $this->db->set('catatan', " Ralisasi Dibatalkan oleh : " . $this->session->userdata['inisial'] . ", " . "Alasan Pembatalan : " . $this->input->post('catatan') . ", " . "Tgl" . " : " . date('y-m-d - H:i:s'));
            $this->db->set('status', '8');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('lembur');

            $this->session->set_flashdata('message', 'batalbr');
            redirect('lembur/realisasi/');
        } else
            $this->db->set('catatan', "Alasan pembatalan : " . $this->input->post('catatan') . ", " . "Tgl" . " : " . date('y-m-d - H:i:s'));
        $this->db->set('status', '8');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('lembur');

        $this->session->set_flashdata('message', 'batalbr');
        redirect('lembur/persetujuan_realisasi/');
    }

    public function laporan_lembur($id)
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['lembur']  = $this->db->get_where('lembur', ['id' => $id])->row_array();
        $data['jamkerja_kategori']  = $this->db->get_where('jamkerja_kategori', ['id' => $id])->row_array();
        $data['aktivitas']  = $this->db->get_where('aktivitas', ['link_aktivitas' => $id])->result_array();

        $this->load->view('lembur/reportlbr', $data);
    }

    public function cari_lembur_hr()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $tglmulai = date("Y-m-d 00:00:00", strtotime($this->input->post('tglmulai')));
        $tglselesai = date("Y-m-d 23:59:00", strtotime($this->input->post('tglselesai')));
        $querylembur = "SELECT *
                                    FROM `lembur`
                                    WHERE `tglmulai` >= '$tglmulai' AND `tglselesai` <= '$tglselesai' AND (`status` = '9')
                                ";
        $data['lembur'] = $this->db->query($querylembur)->result_array();
        $data['tglmulai'] = $tglmulai;
        $data['tglselesai'] = $tglselesai;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/laporanhr', $data);
        $this->load->view('templates/footer');
    }

    public function cari_lembur_ga()
    {
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Laporan Lembur';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $tglmulai = date("Y-m-d 00:00:00", strtotime($this->input->post('tglmulai')));
        $tglselesai = date("Y-m-d 23:59:00", strtotime($this->input->post('tglselesai')));
        $querylembur = "SELECT *
                                    FROM `lembur`
                                    WHERE `tglmulai` >= '$tglmulai' AND `tglselesai` <= '$tglselesai'
                                ";
        $data['lembur'] = $this->db->query($querylembur)->result_array();
        $data['tglmulai'] = $tglmulai;
        $data['tglselesai'] = $tglselesai;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('lembur/laporanga', $data);
        $this->load->view('templates/footer');
    }

    public function gantitgl_lembur()
    {
        $this->db->set('tglmulai', $this->input->post('tglmulai'));
        $this->db->set('tglselesai', $this->input->post('tglmulai'));
        $this->db->set('tglmulai_aktual', $this->input->post('tglmulai'));
        $this->db->set('tglselesai_aktual', $this->input->post('tglmulai'));
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        redirect('lembur/rencana_aktivitas/' . $this->input->post('link_aktivitas'));
    }

    public function gantitgl_lembur_sect()
    {
        $this->db->set('tglmulai', $this->input->post('tglmulai'));
        $this->db->set('tglselesai', $this->input->post('tglmulai'));
        $this->db->set('tglmulai_aktual', $this->input->post('tglmulai'));
        $this->db->set('tglselesai_aktual', $this->input->post('tglmulai'));
        $this->db->where('id', $this->input->post('link_aktivitas'));
        $this->db->update('lembur');

        redirect('lembur/persetujuan_aktivitas_sect/' . $this->input->post('link_aktivitas'));
    }

    public function batal_aktivitas($id)
    {
        date_default_timezone_set('asia/jakarta');
        $aktivitas = $this->db->get_where('aktivitas', ['id' => $id])->row_array();
        $jam = $aktivitas['durasi'];
        $a = $aktivitas['link_aktivitas'];

        $this->db->set('status', '2');
        $this->db->set('durasi', '0');
        $this->db->set('durasi_menit', '0');
        $this->db->where('id', $id);
        $this->db->update('aktivitas');

        redirect('lembur/realisasi_aktivitas/' . $a);
    }
}
