<?php
defined('BASEPATH') or exit('No direct script access allowed');

class F221 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function asset($kategori = null)
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Asset';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($kategori == 'approved'){
            $data['asset'] = $this->db->get_where('asset', ['status' => '9'])->result_array();
        } elseif($kategori == 'verified'){
            $data['asset'] = $this->db->get_where('asset', ['status' => '2'])->result_array();
        } elseif($kategori == 'opnamed'){
            $data['asset'] = $this->db->get_where('asset', ['status' => '1'])->result_array();
        }else{
            $data['asset'] = $this->db->get('asset')->result_array();
        }

        $total = $this->db->get('asset');
        $data['assetTotal'] = $total->num_rows();

        $this->db->where('status', '1');
        $remains = $this->db->get('asset');
        $data['assetRemains'] = $remains->num_rows();

        $this->db->where('status', '2');
        $verified = $this->db->get('asset');
        $data['assetVerified'] = $verified->num_rows();

        $this->db->where('status', '9');
        $approved = $this->db->get('asset');
        $data['assetApproved'] = $approved->num_rows();
                
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/asset', $data);
        $this->load->view('templates/footer');
    }

    public function verify()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Verifikasi';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->where('status', '1');
        $data['asset'] = $this->db->get('asset')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/asset', $data);
        $this->load->view('templates/footer');
    }

    public function opnamed()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'Opnamed';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->where('npk' , $this->session->userdata('npk'));
        $data['asset'] = $this->db->where('status >=' , '1');
        $data['asset'] = $this->db->get('asset')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/index', $data);
        $this->load->view('templates/footer');
    }

    // public function opname()
    // {
    //     $data['sidemenu'] = 'Asset';
    //     $data['sidesubmenu'] = 'Opname Asset';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $data['asset'] = $this->db->get_where('asset_opname', ['npklama' =>  $this->session->userdata('npk')])->result_array();
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('asset/opname', $data);
    //     $this->load->view('templates/footer');
    // }

    public function opname($id)
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'AssetKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset', ['id' => $id])->row_array();
        if ($data['asset']['status']=='0'){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/opname', $data);
            $this->load->view('templates/footer');
        }else{    
            $data['opnamed'] = $this->db->get_where('asset_opnamed', ['id' => $id])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/opnamed', $data);
            $this->load->view('templates/footer');
        }
    }

    public function opname_proses()
    {
        date_default_timezone_set('asia/jakarta');
        if ($this->input->post('checkpic') == 1){
            $pic = $this->input->post('new_npk');
            $notepic = 'PIC ('.$this->input->post('old_npk').' -> '.$this->input->post('new_npk').'), ';
            $changePic = 1;
        }else{
            $pic = $this->input->post('old_npk');
            $notepic = '';
            $changePic = 0;
        }
        
        if ($this->input->post('checkloc') == 1){
            $notelokasi = 'Lokasi ('.$this->input->post('old_lokasi').' -> '.$this->input->post('new_lokasi').'), ';
            $lokasi = $this->input->post('new_lokasi');
            $changeLokasi = 1;
        }else{
            $notelokasi = '';
            $lokasi = $this->input->post('old_lokasi');
            $changeLokasi = 0;
        }

        $old_pic = $this->db->get_where('karyawan', ['npk' => $this->input->post('old_npk')])->row_array();
        $new_pic = $this->db->get_where('karyawan', ['npk' => $pic])->row_array();
   

        $asset = $this->db->get_where('asset', ['id' => $this->input->post('id')])->row_array();
        $opnamed = $this->db->get_where('asset_opnamed', ['id' => $this->input->post('id')])->row_array();
        if (empty($opnamed)){
            $data = [
                'id' => $this->input->post('id'),
                'asset_no' => $asset['asset_no'],
                'asset_sub_no' => $asset['asset_sub_no'],
                'asset_deskripsi' => $asset['asset_deskripsi'],
                'kategori' => $asset['kategori'],
                'old_npk' => $this->input->post('old_npk'),
                'old_pic' => $old_pic['nama'],
                'new_npk' => $pic,
                'new_pic' => $new_pic['nama'],
                'old_lokasi' => $this->input->post('old_lokasi'),
                'new_lokasi' => $lokasi,
                'status' => $this->input->post('status'),
                'catatan' => $notepic. $notelokasi. $this->input->post('catatan'),
                'opname_at' => date('Y-m-d H:i:s'),
                'opname_by' => $this->session->userdata('nama'),
                'change_pic' => $changePic, 
                'change_lokasi' => $changeLokasi,
                'dept_id' => $this->session->userdata('dept_id'),
            ];
            $this->db->insert('asset_opnamed', $data);

            $config['upload_path']          = './assets/img/asset/';
            $config['allowed_types']        = 'jpg|jpeg|png';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                $this->db->set('asset_foto', $this->upload->data('file_name'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('asset_opnamed');
            }

            //Updated status opname
            $this->db->set('status', '1');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('asset');
        }else{

        }

        redirect('asset/remains');
    }

    public function reopname_proses()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('asset_opnamed');

        //Updated status opname
        $this->db->set('status', '0');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('asset');

        redirect('asset/opname/'.$this->input->post('id'));
    }

    public function verifikasi()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Verifikasi Opname';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset_opname', ['status_opname' =>  '1'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/opname_verifikasi', $data);
        $this->load->view('templates/footer');
    }

    public function verifikasi2()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Verifikasi Opname';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset_opname', ['status_opname' =>  '2'])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/opname_verifikasi', $data);
        $this->load->view('templates/footer');
    }

    public function do_verifikasi($no, $sub)
    {
        $this->db->set('status_opname', '3');
        $this->db->set('catatan', 'Diverifikasi oleh ' . $this->session->userdata('inisial'));
        $this->db->where('asset_no', $no);
        $this->db->where('asset_sub_no', $sub);
        $this->db->update('asset');

        $this->db->set('status_opname', '2');
        $this->db->set('tim_opname', $this->session->userdata('inisial'));
        $this->db->where('asset_no', $no);
        $this->db->where('asset_sub_no', $sub);
        $this->db->update('asset_opname');

        $this->session->set_flashdata('message', 'berhasilverifikasi');
        redirect('asset/verifikasi');
    }

    // public function asset()
    // {
    //     $data['sidemenu'] = 'FA';
    //     $data['sidesubmenu'] = 'Asset Manajemen';
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    //     $data['asset'] = $this->db->get('asset')->result_array();
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/navbar', $data);
    //     $this->load->view('asset/asset', $data);
    //     $this->load->view('templates/footer');
    // }
    public function opname1()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Asset Manajemen';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset', ['status_opname' =>  1])->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/asset', $data);
        $this->load->view('templates/footer');
    }
    public function opname2()
    {
        $data['sidemenu'] = 'FA';
        $data['sidesubmenu'] = 'Asset Manajemen';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->where('status_opname', '2');
        $data['asset'] = $this->db->or_where('status_opname', '3');
        $data['asset'] = $this->db->get('asset')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/asset', $data);
        $this->load->view('templates/footer');
    }

    public function assetku1()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'AssetKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->where('npk', $this->session->userdata('npk'));
        $data['asset'] = $this->db->where('status_opname', '1');
        $data['asset'] = $this->db->get('asset')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/index', $data);
        $this->load->view('templates/footer');
    }

    public function assetku2()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'AssetKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->where('npk', $this->session->userdata('npk'));
        $data['asset'] = $this->db->where('status_opname !=', '1');
        $data['asset'] = $this->db->get('asset')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/index', $data);
        $this->load->view('templates/footer');
    }
}
