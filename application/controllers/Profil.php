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

    public function update_ewallet()
    {
        if ($this->input->post('ewallet')=='GOPAY')
        {
            $this->db->set('ewallet_1', $this->input->post('rek'));
            $this->db->set('ewallet_utama', 'GOPAY');
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->update('karyawan');

            redirect('profil');
        }elseif ($this->input->post('ewallet')=='DANA')
        {
            $this->db->set('ewallet_2', $this->input->post('rek'));
            $this->db->set('ewallet_utama', 'DANA');
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->update('karyawan');

            redirect('profil');
        }elseif ($this->input->post('ewallet')=='ASTRAPAY')
        {
            $this->db->set('ewallet_3', $this->input->post('rek'));
            $this->db->set('ewallet_utama', 'ASTRAPAY');
            $this->db->where('npk', $this->session->userdata('npk'));
            $this->db->update('karyawan');

            redirect('profil');
        }
    }

    public function ewallet_utama($parameter)
    {
        $this->db->set('ewallet_utama', $parameter);
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->update('karyawan');

        redirect('profil');
    }

    public function data()
    {
        $details = $this->db->get_where('karyawan_details', ['npk' => $this->session->userdata('npk')])->row();
        
        if (empty($details)){

            $data = [
                'npk' => $this->session->userdata('npk'),
                'nama' => $this->session->userdata('nama')
            ];
            $this->db->insert('karyawan_details', $data);
        }

        $data['sidemenu'] = 'Info HR';
        $data['sidesubmenu'] = 'Update Data';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['details'] = $this->db->get_where('karyawan_details', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['keluarga'] = $this->db->get_where('karyawan_keluarga', ['npk' =>  $this->session->userdata('npk')])->result();
        $data['provinsi'] = $this->db->get('wilayah_provinsi')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('profil/data', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {

        $details = $this->db->get_where('karyawan_details', ['npk' => $this->session->userdata('npk')])->row();
        
        //Alamat
        if ($this->input->post('checkdomisili') == '1'){
            $alamat = $this->input->post('alamat_ktp');
            $provinsi = $this->db->get_where('wilayah_provinsi', ['id' => $this->input->post('prov_ktp')])->row();
            $kabupaten = $this->db->get_where('wilayah_kabupaten', ['id' => $this->input->post('kab_ktp')])->row();
            $kecamatan = $this->db->get_where('wilayah_kecamatan', ['id' => $this->input->post('kec_ktp')])->row();
            $desa = $this->db->get_where('wilayah_desa', ['id' => $this->input->post('desa_ktp')])->row();
        }else{
            $alamat = $this->input->post('alamat');
            $provinsi = $this->db->get_where('wilayah_provinsi', ['id' => $this->input->post('prov')])->row();
            $kabupaten = $this->db->get_where('wilayah_kabupaten', ['id' => $this->input->post('kab')])->row();
            $kecamatan = $this->db->get_where('wilayah_kecamatan', ['id' => $this->input->post('kec')])->row();
            $desa = $this->db->get_where('wilayah_desa', ['id' => $this->input->post('desa')])->row();
        };

        $alamat_ktp = $this->input->post('alamat_ktp');
        $provinsi_ktp = $this->db->get_where('wilayah_provinsi', ['id' => $this->input->post('prov_ktp')])->row();
        $kabupaten_ktp = $this->db->get_where('wilayah_kabupaten', ['id' => $this->input->post('kab_ktp')])->row();
        $kecamatan_ktp = $this->db->get_where('wilayah_kecamatan', ['id' => $this->input->post('kec_ktp')])->row();
        $desa_ktp = $this->db->get_where('wilayah_desa', ['id' => $this->input->post('desa_ktp')])->row();

        $this->db->set('nik', $this->input->post('nik'));
        $this->db->set('email', $this->input->post('email'));
        $this->db->set('kontak', $this->input->post('kontak'));
        $this->db->set('lahir_tempat', $this->input->post('lahir_tempat'));
        $this->db->set('lahir_tanggal', date('Y-m-d', strtotime($this->input->post('lahir_tanggal'))));
        $this->db->set('pendidikan_institusi', $this->input->post('pend_institusi'));
        $this->db->set('pendidikan_jenjang', $this->input->post('pend_jenjang'));
        $this->db->set('pendidikan_tahun', $this->input->post('pend_tahun'));
        $this->db->set('status_pernikahan', $this->input->post('status_pernikahan'));
        $this->db->set('status_tanggungan', $this->input->post('status_tanggungan'));
        $this->db->set('alamat_ktp', $alamat_ktp);
        $this->db->set('provinsi_ktp', $provinsi_ktp->nama);
        $this->db->set('kabupaten_ktp', $kabupaten_ktp->nama);
        $this->db->set('kecamatan_ktp', $kecamatan_ktp->nama);
        $this->db->set('desa_ktp', $desa_ktp->nama);
        $this->db->set('alamat', $alamat);
        $this->db->set('provinsi', $provinsi->nama);
        $this->db->set('kabupaten', $kabupaten->nama);
        $this->db->set('kecamatan', $kecamatan->nama);
        $this->db->set('desa', $desa->nama);
        // $this->db->set('vaksin_nama', $this->input->post('vaksin_nama'));
        // $this->db->set('vaksin_dosis', $this->input->post('vaksin_dosis'));
        // $this->db->set('vaksin_tanggal', date('Y-m-d', strtotime($this->input->post('vaksin_tanggal'))));
        $this->db->set('kerabat_nama', $this->input->post('kerabat_nama'));
        $this->db->set('kerabat_hubungan', $this->input->post('kerabat_hubungan'));
        $this->db->set('kerabat_kontak', $this->input->post('kerabat_kontak'));
        $this->db->set('kerabat_alamat', $this->input->post('kerabat_alamat'));
        $this->db->set('domisili_ktp', $this->input->post('checkdomisili'));
        $this->db->set('updated_by', $this->session->userdata('inisial'));
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->update('karyawan_details');

        //Vaksin
        // $vaksin = $this->db->get_where('vaksin_data', ['id' => $this->session->userdata('npk')])->row();
        // if ($vaksin){
        //     $this->db->set('vaksin_nama', $this->input->post('vaksin_nama'));
        //     $this->db->set('vaksin_dosis', $this->input->post('vaksin_dosis'));
        //     $this->db->set('vaksin_tanggal', date('Y-m-d', strtotime($this->input->post('vaksin_tanggal'))));
        //     $this->db->where('id', $this->session->userdata('npk'));
        //     $this->db->update('vaksin_data');
        // }else{
        //     $data = [
        //         'id' => $this->session->userdata('npk'),
        //         'npk' => $this->session->userdata('npk'),
        //         'status_keluarga' => 'KARYAWAN',
        //         'vaksin_nama' => $this->input->post('vaksin_nama'),
        //         'vaksin_dosis' => $this->input->post('vaksin_dosis'),
        //         'vaksin_tanggal' => $this->input->post('vaksin_tanggal'),
        //         'vaksin_booster' => $this->input->post('vaksin_booster'),
               
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'updated_by' => $this->session->userdata('inisial')
        //     ];
        //     $this->db->insert('karyawan_keluarga', $data);
        // }
        $this->session->set_flashdata('notify', 'success');
        redirect('profil/data');
    }

    public function keluarga($var = null)
    {
        if ($var=='get'){
            $keluarga = $this->db->get_where('karyawan_keluarga', ['npk' => $this->session->userdata('npk')])->result();
            
            // $i = 1;
            // foreach ($vendor as $row) :
            //     $totalServing = $this->MenuModel->countServingbyVendorDate($row->date,$row->vendor,$row->canteen)->get()->getRow('serving');
            //     $totalUsed = $this->LunchModel->getLunchbyVendorDate($row->date,$row->vendor,$row->canteen)->countAllResults();

            //     $output['data'][] = array(
            //         'no' => $i,
            //         'date' => $row->date,
            //         'canteen' => $row->canteen,
            //         'serving' => $totalServing,
            //         'total' => $totalUsed,
            //         // 'person_card' => $row['person_card'],
            //         // 'canteen' => $row['canteen'],
            //         // 'vendor' => $row['vendor']
            //     );
            //     $i++;
            // endforeach;

            $output = array(
                'data' => $keluarga
            );
            
            // var_dump($output);

            //output to json format
            echo json_encode($output);

        }elseif($var=='add'){

            $id = $this->session->userdata('npk').$this->input->post('hubungan');
            $data = [
                'id' => $id,
                'npk' => $this->session->userdata('npk'),
                'nik' => $this->input->post('nik'),
                'nama' => $this->input->post('nama'),
                'lahir_tempat' => $this->input->post('lahir_tempat'),
                'lahir_tanggal' => date('Y-m-d', strtotime($this->input->post('lahir_tanggal'))),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'hubungan' => $this->input->post('hubungan'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('inisial')
            ];
            $this->db->insert('karyawan_keluarga', $data);

        }elseif($var=='delete'){

            $this->db->where('nik', $this->input->post('nik'));
            $this->db->where('nama', $this->input->post('nama'));
            $this->db->delete('karyawan_keluarga');

        }
    }

}
