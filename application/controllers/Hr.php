<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function karyawan()
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Data Karyawan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['datakaryawan'] = $this->db->where('npk !=', '1111');
        $data['datakaryawan'] = $this->db->where('is_active', '1');
        $data['datakaryawan'] = $this->db->get('karyawan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('karyawan/index', $data);
        $this->load->view('templates/footer');
    }

    public function dept()
    {
        $div_id = $_POST['div'];
        $getDept = $this->db->query("SELECT * FROM karyawan_dept WHERE div_id = '$div_id'")->result_array();

        foreach ($getDept as $a) {
            echo '<option value="' . $a['id'] . '">' . $a['nama'] . '</option>';
        }
    }

    public function sect()
    {
        $dept_id = $_POST['dept'];
        $getSect = $this->db->query("SELECT * FROM karyawan_sect WHERE dept_id = '$dept_id'")->result_array();

        foreach ($getSect as $a) {
            echo '<option value="' . $a['id'] . '">' . $a['nama'] . '</option>';
        }
    }

    public function tambah()
    {
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/img/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $qrcode = $this->input->post('inisial') . $this->input->post('npk');
        $image_name = $qrcode . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = $qrcode; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data = [
            'npk' => $this->input->post('npk'),
            'inisial' => $this->input->post('inisial'),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'foto' => 'user.jpg',
            'posisi_id' => $this->input->post('posisi'),
            'div_id' => $this->input->post('div'),
            'dept_id' => $this->input->post('dept'),
            'sect_id' => $this->input->post('sect'),
            'gol_id' => $this->input->post('gol'),
            'fasilitas_id' => $this->input->post('fasilitas'),
            'atasan1' => $this->input->post('atasan1'),
            'atasan2' => $this->input->post('atasan2'),
            'password' => password_hash("winteq", PASSWORD_DEFAULT),
            'qrcode' => $qrcode,
            'role_id' => $this->input->post('role'),
            'is_active' => 1
        ];
        $this->db->insert('karyawan', $data);

        $config['upload_path']          = './assets/img/faces/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto')) {
            $this->db->set('foto', $this->upload->data('file_name'));
            $this->db->where('npk', $this->input->post('npk'));
            $this->db->update('karyawan');
        }

        redirect('hr/karyawan');
    }

    public function ubah($npk)
    {
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Data Karyawan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['datakaryawan'] = $this->db->get_where('karyawan', ['npk' =>  $npk])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('karyawan/ubah', $data);
        $this->load->view('templates/footer');
    }
    public function ajax()
    {
        $id = $_POST['id'];
        $get_section = $this->db->query("SELECT * FROM karyawan_sect WHERE dept_id='$id'")->result_array();

        foreach ($get_section as $t) {
            echo "<option value=" . $t['id'] . ">" . $t['name'] . "</option>";
        }
    }

    public function ubah_proses()
    {
        $config['upload_path']          = './assets/img/faces/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 1024;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto')) {
            $this->db->set('foto', $this->upload->data('file_name'));
        }
        $this->db->set('npk', $this->input->post('npk'));
        $this->db->set('inisial', $this->input->post('inisial'));
        $this->db->set('nama', $this->input->post('nama'));
        $this->db->set('email', $this->input->post('email'));
        $this->db->set('phone', $this->input->post('phone'));
        $this->db->set('posisi_id', $this->input->post('posisi'));
        $this->db->set('div_id', $this->input->post('div'));
        $this->db->set('dept_id', $this->input->post('dept'));
        $this->db->set('sect_id', $this->input->post('sect'));
        $this->db->set('atasan1', $this->input->post('atasan1'));
        $this->db->set('atasan2', $this->input->post('atasan2'));
        $this->db->set('gol_id', $this->input->post('gol'));
        $this->db->set('fasilitas_id', $this->input->post('fasilitas'));
        $this->db->set('role_id', $this->input->post('role'));
        $this->db->where('npk', $this->input->post('npk'));
        $this->db->update('karyawan');
        redirect('hr/karyawan');
    }

    public function qrc()
    {
        $karyawan = $this->db->get('karyawan')->result_array();
        foreach ($karyawan as $k) :
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/img/qrcode/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
            $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            $qrcode = $k['inisial'] . $k['npk'];
            $image_name = $qrcode . '.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $qrcode; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

            $this->db->set('qrcode', $qrcode);
            $this->db->where('npk', $k['npk']);
            $this->db->update('karyawan');
        endforeach;
        redirect('hr/karyawan');
    }
    public function presensi($menu)
    {
        date_default_timezone_set('asia/jakarta');
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($menu == 'bulan') {

            if (empty($this->input->post('month'))) {
                $data['bulan'] = date('m');
            } else {
                $data['bulan'] = $this->input->post('month');
            }
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Kehadiran';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi', $data);
            $this->load->view('templates/footer');
        } elseif ($menu == 'hari') {
            if (empty($this->input->post('prdate'))) {
                $data['tahun'] = date('Y');
                $data['bulan'] = date('m');
                $data['hari'] = date('d');
            } else {
                $data['tahun'] = date('Y', strtotime($this->input->post('prdate')));
                $data['bulan'] = date('m', strtotime($this->input->post('prdate')));
                $data['hari'] = date('d', strtotime($this->input->post('prdate')));
            }
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Kehadiran';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi_data', $data);
            $this->load->view('templates/footer');
        }
    }

    public function download($menu)
    {
        date_default_timezone_set('asia/jakarta');
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($menu == 'presensi') {
            if (empty($this->input->post('month'))) {
                $data['bulan'] = date('m');
            } else {
                $data['bulan'] = $this->input->post('month');
            }
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Kehadiran';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi_download', $data);
            $this->load->view('templates/footer');
        }
    }

    public function presensi_data()
    {
        date_default_timezone_set('asia/jakarta');
        if (empty($this->input->post('month'))) {
            $data['bulan'] = date('m');
        } else {
            $data['bulan'] = $this->input->post('month');
        }
        $data['tahun'] = date('Y');
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('hr/presensi_data', $data);
        $this->load->view('templates/footer');
    }
}
