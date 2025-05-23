<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('asia/jakarta');
        
        $this->load->model("Karyawan_model");
    }

    public function karyawan($params=null)
    {
        if($params=='add')
        {

        }elseif($params=='edit')
        {   
            $data['sidemenu'] = 'HR Karyawan';
            $data['sidesubmenu'] = 'Data Karyawan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['data'] = $this->db->get_where('karyawan', ['npk' => $this->input->post('npk')])->row();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/karyawan/edit', $data);
            $this->load->view('templates/footer');
        }elseif($params=='lengkap')
        {   
            $data['sidemenu'] = 'HR Karyawan';
            $data['sidesubmenu'] = 'Data Karyawan Lengkap';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['data'] = $this->db->get_where('karyawan', ['npk' => $this->input->post('npk')])->row();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/karyawan/details', $data);
            $this->load->view('templates/footer');
        }else 
        {
            $data['sidemenu'] = 'HR Karyawan';
            $data['sidesubmenu'] = 'Data Karyawan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['datakaryawan'] = $this->db->where('npk !=', '1111');
            $data['datakaryawan'] = $this->db->where('is_active', '1');
            $data['datakaryawan'] = $this->db->get('karyawan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/karyawan/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function modify_karyawan($params=null)
    {
        if($params=='add')
        {

        }elseif($params=='profile')
        {   
            $this->db->set('nama', $this->input->post('nama'));
            $this->db->set('inisial', $this->input->post('inisial'));
            $this->db->set('email', $this->input->post('email'));
            $this->db->set('phone', $this->input->post('phone'));
            $this->db->where('npk', $this->input->post('npk'));
            $this->db->update('karyawan');
        }elseif($params=='structure')
        {   
            $this->db->set('posisi_id', $this->input->post('posisi_id'));
            $this->db->set('div_id', $this->input->post('div_id'));
            $this->db->set('dept_id', $this->input->post('dept_id'));
            $this->db->set('sect_id', $this->input->post('sect_id'));
            $this->db->set('gol_id', $this->input->post('gol_id'));
            $this->db->set('fasilitas_id', $this->input->post('fasilitas_id'));
            $this->db->set('work_contract', $this->input->post('work_contract'));
            $this->db->set('cost_center', $this->input->post('cost_center'));
            $this->db->set('atasan1', $this->input->post('atasan1'));
            $this->db->set('atasan2', $this->input->post('atasan2'));
            $this->db->where('npk', $this->input->post('npk'));
            $this->db->update('karyawan');
        }else 
        {
            $data['sidemenu'] = 'HR Karyawan';
            $data['sidesubmenu'] = 'Data Karyawan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/karyawan/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function addKaryawan($param=null)
    {
        $data['sidemenu'] = 'HR Karyawan';
        $data['sidesubmenu'] = 'Data Karyawan';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('hr/karyawan/add', $data);
        $this->load->view('templates/footer');
    }

    public function getKaryawan()
    {
        
        $result = $this->Karyawan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];

            foreach ($result as $r) :
                $posisi = $this->db->get_where('karyawan_posisi', ['id' => $r->posisi_id])->row();
                $div = $this->db->get_where('karyawan_div', ['id' =>  $r->div_id])->row();
                $dept = $this->db->get_where('karyawan_dept', ['id' =>  $r->dept_id])->row();
                $sect = $this->db->get_where('karyawan_sect', ['id' =>  $r->sect_id])->row();
                $is_active = ($r->is_active == '1') ? 'AKTIF' : 'NON AKTIF';
                $status = ($r->status == '1') ? 'KARYAWAN' : 'NON KARYAWAN';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $r->npk;
                $row[] = $r->inisial;
                $row[] = $r->nama;
                $row[] = $r->email;
                $row[] = $r->phone;
                $row[] = $posisi->nama;
                $row[] = $div->nama;
                $row[] = $dept->nama;
                $row[] = $sect->nama;
                $row[] = $status;
                $row[] = $is_active;
            
                $data[] = $row;
            endforeach;
            
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Karyawan_model->count_all(),
                "recordsFiltered" => $this->Karyawan_model->count_filtered(),
                "data" => $data,
            );

            //output to json format
            echo json_encode($output);
    }

    public function getData()
    {
        
            $result = $this->Karyawan_model->getActive();

            foreach ($result as $r) :
                $div = $this->db->get_where('karyawan_div', ['id' =>  $r->div_id])->row();
                $dept = $this->db->get_where('karyawan_dept', ['id' =>  $r->dept_id])->row();
                $sect = $this->db->get_where('karyawan_sect', ['id' =>  $r->sect_id])->row();
                $posisi = $this->db->get_where('karyawan_posisi', ['id' => $r->posisi_id])->row();
                $gol = $this->db->get_where('karyawan_gol', ['id' => $r->gol_id])->row();
                $fasilitas = $this->db->get_where('karyawan_fasilitas', ['id' => $r->fasilitas_id])->row();
                $is_active = ($r->is_active == '1') ? 'AKTIF' : 'NON AKTIF';
                $status = ($r->status == '1') ? 'KARYAWAN' : 'NON KARYAWAN';
                $row = array();
                $row['npk'] = $r->npk;
                $row['inisial'] = $r->inisial;
                $row['nama'] = $r->nama;
                $row['email'] = $r->email;
                $row['phone'] = $r->phone;
                $row['div'] = $div->nama;
                $row['dept'] = $dept->nama;
                $row['sect'] = $sect->nama;
                $row['posisi'] = $posisi->nama;
                $row['gol'] = $gol->nama;
                $row['fasilitas'] = $fasilitas->nama;
                $row['cost_center'] = $r->cost_center;
                $row['work_contract'] = $r->work_contract;
                $row['status'] = $status;
                $row['is_active'] = $is_active;
            
                $data[] = $row;
            endforeach;
            
            $output = array(
                "data" => $data
            );

            //output to json format
            echo json_encode($output);
    }

    public function getDetails()
    {
            $result = $this->Karyawan_model->getOrganic();

            foreach ($result as $row) :
                $details = $this->db->get_where('karyawan_details', ['npk' =>  $row->npk])->row();
                //          $this->db->where('hubungan', 'istri');
                // $istri = $this->db->get_where('karyawan_keluarga', ['npk' =>  $row->npk])->row();
                //          $this->db->where('hubungan', 'anak1');
                // $anak1 = $this->db->get_where('karyawan_keluarga', ['npk' =>  $row->npk])->row();
                //          $this->db->where('hubungan', 'anak2');
                // $anak2 = $this->db->get_where('karyawan_keluarga', ['npk' =>  $row->npk])->row();
                //          $this->db->where('hubungan', 'anak3');
                // $anak3 = $this->db->get_where('karyawan_keluarga', ['npk' =>  $row->npk])->row();
              
                if ($details){
                    $output['data'][] = array(
                        "npk" => $row->npk,
                        "inisial" => $row->inisial,
                        "nama" =>  $row->nama,
                        "nik" =>  $details->nik,
                        "tmp_lahir" =>  $details->lahir_tempat,
                        "tgl_lahir" =>  $details->lahir_tanggal,
                        "kontak" =>  $row->phone,
                        "alamat_ktp" =>  $details->alamat_ktp,
                        "provinsi_ktp" =>  $details->provinsi_ktp,
                        "kabupaten_ktp" =>  $details->kabupaten_ktp,
                        "kecamatan_ktp" =>  $details->kecamatan_ktp,
                        "desa_ktp" =>  $details->desa_ktp,
                        "alamat" =>  $details->alamat,
                        "provinsi" =>  $details->provinsi,
                        "kabupaten" =>  $details->kabupaten,
                        "kecamatan" =>  $details->kecamatan,
                        "desa" =>  $details->desa,
                    );
                }else{
                    $output['data'][] = array(
                        "npk" => $row->npk,
                        "inisial" => $row->inisial,
                        "nama" => $row->nama,
                        "nik" => '',
                        "tmp_lahir" => '',
                        "tgl_lahir" => '',
                        "kontak" => $row->phone,
                        "alamat_ktp" => '',
                        "provinsi_ktp" => '',
                        "kabupaten_ktp" => '',
                        "kecamatan_ktp" => '',
                        "desa_ktp" => '',
                        "alamat" => '',
                        "provinsi" => '',
                        "kabupaten" => '',
                        "kecamatan" => '',
                        "desa" => '',
                    );
                }

            endforeach;
           
            //output to json format
            echo json_encode($output);
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
        // $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        // $config['cacheable']    = true; //boolean, the default is true
        // $config['cachedir']     = './assets/'; //string, the default is application/cache/
        // $config['errorlog']     = './assets/'; //string, the default is application/logs/
        // $config['imagedir']     = './assets/img/qrcode/'; //direktori penyimpanan qr code
        // $config['quality']      = true; //boolean, the default is true
        // $config['size']         = '1024'; //interger, the default is 1024
        // $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        // $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        // $this->ciqrcode->initialize($config);

        // $qrcode = $this->input->post('inisial') . $this->input->post('npk');
        // $image_name = $qrcode . '.png'; //buat name dari qr code sesuai dengan nim

        // $params['data'] = $qrcode; //data yang akan di jadikan QR CODE
        // $params['level'] = 'H'; //H=High
        // $params['size'] = 10;
        // $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        // $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data = [
            'npk' => $this->input->post('npk'),
            'inisial' => $this->input->post('inisial'),
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'foto' => 'user.jpg',
            'div_id' => $this->input->post('div'),
            'dept_id' => $this->input->post('dept'),
            'sect_id' => $this->input->post('sect'),
            'posisi_id' => $this->input->post('posisi'),
            'gol_id' => $this->input->post('gol'),
            'fasilitas_id' => $this->input->post('fasilitas'),
            'cost_center' => $this->input->post('cost_center'),
            'work_contract' => $this->input->post('work_contract'),
            'atasan1' => $this->input->post('atasan1'),
            'atasan2' => $this->input->post('atasan2'),
            'password' => password_hash("winteq", PASSWORD_DEFAULT),
            'status' => $this->input->post('status'),
            'role_id' => $this->input->post('role'),
            'is_active' => 1
        ];
        $this->db->insert('karyawan', $data);

        $config['upload_path']          = './assets/img/faces/';
        $config['allowed_types']        = 'jpg|jpeg|png';
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
        $data['sidemenu'] = 'Data Karyawan';
        $data['sidesubmenu'] = 'Data';
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
        redirect('karyawan');
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
        redirect('karyawan');
    }
    public function presensi($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($parameter == 'bulan') {

            if (empty($this->input->post('month'))) {
                $data['bulan'] = date('m');
            } else {
                $data['bulan'] = $this->input->post('month');
            }
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Kehadiran perbulan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi', $data);
            $this->load->view('templates/footer');
        } elseif ($parameter == 'tanggal') {
            if (empty($this->input->post('prdate'))) {
                $data['tahun'] = date('Y');
                $data['bulan'] = date('m');
                $data['tanggal'] = date('d');
            } else {
                $data['tahun'] = date('Y', strtotime($this->input->post('prdate')));
                $data['bulan'] = date('m', strtotime($this->input->post('prdate')));
                $data['tanggal'] = date('d', strtotime($this->input->post('prdate')));
            }
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Kehadiran perhari';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi_date', $data);
            $this->load->view('templates/footer');
        } elseif ($parameter == 'pivot') {
            if (empty($this->input->post('start_date'))) {
                $data['tahun'] = date('Y');
                $data['bulan'] = date('m');
                $data['tanggal'] = date('d');
            } else {
                $data['tahun'] = date('Y', strtotime($this->input->post('start_date')));
                $data['bulan'] = date('m', strtotime($this->input->post('start_date')));
                $data['tanggal'] = date('d', strtotime($this->input->post('start_date')));
            }
            if (empty($this->input->post('end_date'))) {
                $data['tahun'] = date('Y');
                $data['bulan'] = date('m');
                $data['tanggal'] = date('d');
            } else {
                $data['tahun'] = date('Y', strtotime($this->input->post('end_date')));
                $data['bulan'] = date('m', strtotime($this->input->post('end_date')));
                $data['tanggal'] = date('d', strtotime($this->input->post('end_date')));
            }
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Kehadiran perhari';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi_pivot', $data);
            $this->load->view('templates/footer');
        } elseif ($parameter == 'karyawan') {
            $user = $this->db->get_where('karyawan', ['npk' => $this->input->post('npk')])->row_array();
            $data['npk'] = $user['npk'];
            $data['nama'] = $user['nama'];
            $data['bulan'] = date('m');
            $data['tahun'] = date('Y');
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Kehadiran';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi_users', $data);
            $this->load->view('templates/footer');
        } else {
            $user = $this->db->get_where('karyawan', ['inisial' => $parameter])->row_array();
            if (!empty($user)) {
                $data['npk'] = $user['npk'];
                $data['nama'] = $user['nama'];
                $data['bulan'] = date('m');
                $data['tahun'] = date('Y');
                $data['sidemenu'] = 'HR';
                $data['sidesubmenu'] = 'Laporan Kehadiran';
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('hr/presensi_users', $data);
                $this->load->view('templates/footer');
            } else {
                redirect('hr/presensi/tanggal');
            }
        }
    }

    public function get_presensi_by_date()
    {
        if (!empty($this->input->post('date')))
        {
   
            $date = date('Y-m-d', strtotime($this->input->post('date')));
            // $date = date('Y-m-d', strtotime('2025-04-20'));
                
                // Ambil karyawan yang aktif
                $this->db->select("
                    karyawan.nama, 
                    karyawan.npk,
                    p_in.time AS in_time,
                    p_in.work_state AS in_state,
                    p_in.location AS in_location,
                    p_in.latitude AS in_lat,
                    p_in.longitude AS in_long,
                    p_out.time AS out_time,
                    p_out.work_state AS out_state,
                    p_out.location AS out_location,
                    p_out.latitude AS out_lat,
                    p_out.longitude AS out_long
                ");

                $this->db->from('karyawan');
                $this->db->where('karyawan.is_active', '1');
                $this->db->where('karyawan.status', '1');
                $this->db->join('presensi as p_in', "p_in.npk = karyawan.npk AND p_in.date = '$date' AND p_in.state = 'In'", 'left');
                $this->db->join('presensi as p_out', "p_out.npk = karyawan.npk AND p_out.date = '$date' AND p_out.state = 'Out'", 'left');
                $presensi = $this->db->get()->result();
                
                foreach ($presensi as $row) {
                    
                    $work_state = !empty($row->in_state) ? $row->in_state :
                    (!empty($row->out_state) ? $row->out_state : '');

                    $in_time = !empty($row->in_time) ? date('H:i:s', strtotime($row->in_time)) : '';
                    $out_time = !empty($row->out_time) ? date('H:i:s', strtotime($row->out_time)) : '';

                    $output['data'][] = array(
                        "tanggal" => date('d-m-Y', strtotime($date)),
                        "nama" => $row->nama,
                        "work_state" => $work_state, 
                        "in_time" => $in_time,
                        "out_time" => $out_time,
                        "in_location" => $row->in_location,
                        "out_location" => $row->out_location,
                        
                    );
                }
            }else{
                $output['data'][] = array(
                    "tanggal" => '',
                    "nama" => '',
                    "work_state" => '', 
                    "in_time" => 'Tidak ada data',
                    "out_time" => '',
                    "in_location" => '',
                    "out_location" => '',
                );
            }
            
            echo json_encode($output);
        
    }

    public function get_presensi_by_pivot()
    {
        $start = new DateTime($this->input->post('start_date'));
        $end = new DateTime($this->input->post('end_date'));
        $dates = [];
        while ($start <= $end) {
            $dates[] = $start->format('Y-m-d');
            $start->modify('+1 day');
        }
        
        // Ambil semua presensi
        $this->db->select('karyawan.nama, karyawan.npk, presensi.date, presensi.state, presensi.time');
        $this->db->from('karyawan');
        $this->db->join('presensi', 'presensi.npk = karyawan.npk', 'left');
        $this->db->where('karyawan.is_active', '1');
        $this->db->where('karyawan.status', '1');
        $this->db->where_in('presensi.date', $dates);
        $query = $this->db->get()->result();
        
        // Kelompokkan data
        $data = [];
        foreach ($query as $row) {
            $nama = $row->nama;
            $date = $row->date;
            $state = $row->state;
            $time = $row->time;

            if (!isset($data[$nama])) {
                $data[$nama] = ['nama' => $nama];
                foreach ($dates as $d) {
                    $data[$nama][$d] = ['in' => null, 'out' => null];
                }
            }

            if ($state == 'In') {
                $data[$nama][$date]['in'] = date('H:i', strtotime($time));
            }
            if ($state == 'Out') {
                $data[$nama][$date]['out'] = date('H:i', strtotime($time));
            }
        }

        // Gabungkan in dan out menjadi satu string
        $final = [];
        foreach ($data as $nama => $info) {
            $row = ['nama' => $info['nama']];
            foreach ($dates as $d) {
                $in = $info[$d]['in'] ?? '<i class="fa fa-times text-danger"></i>';
                $out = $info[$d]['out'] ?? '<i class="fa fa-times text-danger"></i>';
                if ($info[$d]['in'] || $info[$d]['out']) {
                    $row[$d] = trim("$in - $out", " -");
                } else {
                    $row[$d] = '';
                }
            }
            $final[] = $row;
        }

        // Output JSON
        echo json_encode([
            'dates' => $dates,
            'data' => $final
        ]);
        
    }

    public function get_presensi_by_raw()
    {
        // Ambil karyawan yang aktif
        $this->db->select('
            presensi.*, 
            presensi.nama AS karyawan_nama,
            karyawan_dept.nama AS dept_nama, 
            karyawan_sect.nama AS sect_nama
        ');
        $this->db->from('presensi');
        $this->db->join('karyawan_dept', 'karyawan_dept.id = presensi.dept_id', 'left');
        $this->db->join('karyawan_sect', 'karyawan_sect.id = presensi.sect_id', 'left');
        $this->db->where('YEAR(presensi.time)', $this->input->post('year'));
        $this->db->where('MONTH(presensi.time)',$this->input->post('month'));
        $presensi = $this->db->get()->result();

        $output = ['data' => []];
                        
        foreach ($presensi as $row) {

            $approved = !empty($row->approved_by) ? $row->approved_by.' - '.date('d-m-Y H:i', strtotime($row->approved_at)) : '<i class="fa fa-times text-danger"></i>';
            $hr = !empty($row->hr_by) ? $row->hr_by.' - '.date('d-m-Y H:i', strtotime($row->hr_at)) : '<i class="fa fa-times text-danger"></i>';

            $output['data'][] = array(
                "date" => date('d-m-Y', strtotime($row->time)),
                "time" => date('H:i:s', strtotime($row->time)),
                "nama" => $row->karyawan_nama,
                "npk" => $row->npk,
                "work_state" => $row->work_state, 
                "direct_state" => $row->state,
                "description" => $row->description,
                "location" => $row->location,
                "approved" => $approved,
                "hr" => $hr
            );

        }

        echo json_encode($output);
    }
    
    public function download($menu)
    {
        date_default_timezone_set('asia/jakarta');
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($menu == 'presensi') {
            if (empty($this->input->post('month'))) {
                $data['bulan'] = date('m');
                $data['tahun'] = date('Y');
            } else {
                $data['bulan'] = $this->input->post('month');
                $data['tahun'] = $this->input->post('year');
            }
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Kehadiran';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/presensi_download', $data);
            $this->load->view('templates/footer');
        }
    }

    public function laporan($parameter)
    {
        date_default_timezone_set('asia/jakarta');
        if ($parameter == 'kesehatan') {
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Kesehatan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['kesehatan'] = $this->db->get_where('kesehatan')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('dirumahaja/data_kesehatan', $data);
            $this->load->view('templates/footer');
        } elseif ($parameter == 'lembur') {
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Lembur';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            if ($this->input->post('select_by')=='1'){
                $date = date('Y-m-d', strtotime($this->input->post('select_date'))); 
                $data['at_week'] = date("W", strtotime($date));
                $data['at_month'] = date("m", strtotime($date));
                $data['tglawal'] = date("Y-m-d", strtotime('monday this week', strtotime($date)));
                $data['tglakhir'] = date("Y-m-d", strtotime('sunday this week', strtotime($date)));
            }elseif ($this->input->post('select_by')=='2'){
                $data['at_week'] = date("W", strtotime($this->input->post('from_date')));
                $data['at_month'] = date("m", strtotime($this->input->post('from_date')));
                $data['tglawal'] = date("Y-m-d", strtotime($this->input->post('from_date')));
                $data['tglakhir'] = date("Y-m-d", strtotime($this->input->post('to_date')));
            }else{
                $date = date('Y-m-d'); 
                $data['at_week'] = date("W", strtotime($date));
                $data['at_month'] = date("m", strtotime($date));
                $data['tglawal'] = date("Y-m-d", strtotime('monday this week', strtotime($date)));
                $data['tglakhir'] = date("Y-m-d", strtotime('sunday this week', strtotime($date)));
            }
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/lp_lembur_week', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('dashboard');
        }
    }
    public function laporan_lembur($npk)
    {
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Kesehatan';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->db->where('npk', $npk);
            $this->db->where('week(tglmulai)','0');
            $this->db->where('year(tglmulai)','2020');
            $this->db->where('status', '9');
            $data['lembur'] = $this->db->get('lembur')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('lembur/lp_lembur_week_karyawan', $data);
            $this->load->view('templates/footer');
    }

    public function info($params)
    {
            $data['sidemenu'] = 'Info HR';
            $data['sidesubmenu'] = 'Panduan '.$params;
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('hr/info/'.$params, $data);
            $this->load->view('templates/footer');
    }
}
