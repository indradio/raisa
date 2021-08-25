<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Asset extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index($access=null)
    {
        if ($access=='fa' or $this->session->userdata('npk')=='6086'){
         
            $data['sidemenu'] = 'FA';
            $data['sidesubmenu'] = 'Asset';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
            $data['asset'] = $this->db->get('asset')->result_array();
            
            $asset = $this->db->get('asset');
            $data['asset'] = $asset->result_array();
            $data['assetTotal'] = $asset->num_rows();
            
            $this->db->where('verify_by', NULL);
            $verify = $this->db->get('asset_opnamed');
            $data['verify'] = $verify->result_array();
            $data['assetVerify'] = $verify->num_rows();
    
            $this->db->where('verify_by !=', NULL);
            $opnamed = $this->db->get('asset_opnamed');
            $data['opnamed'] = $opnamed->result_array();
            $data['assetOpnamed'] = $opnamed->num_rows();
            
            $data['assetRemains'] = $asset->num_rows() - ($verify->num_rows() + $opnamed->num_rows());
                    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/index-fa', $data);
            $this->load->view('templates/footer');

        }else{

            $data['sidemenu'] = 'Asset';
            $data['sidesubmenu'] = 'AssetKu';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['asset'] = $this->db->get_where('asset', ['npk' => $this->session->userdata('npk')])->result_array();
            
            $this->db->where('npk',$this->session->userdata('npk'));
            $total = $this->db->get('asset');
            $data['assetTotal'] = $total->num_rows();
            
            $this->db->where('ex_npk',$this->session->userdata('npk'));
            $opnamed = $this->db->get('asset_opnamed');
            $data['assetOpnamed'] = $opnamed->num_rows();
            
            $data['assetRemains'] = $total->num_rows() - $opnamed->num_rows();
            
            $data['asset_opnamed'] = $this->db->get_where('asset_opnamed', ['npk' => $this->session->userdata('npk')])->result_array();
                    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/index', $data);
            $this->load->view('templates/footer');
        }

    }

    public function remains()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'Remaining';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->where('npk' , $this->session->userdata('npk'));
        $data['asset'] = $this->db->where('status' , '0');
        $data['asset'] = $this->db->get('asset')->result_array();

        if ($this->session->userdata('npk')=='0282'){
            $data['asset'] = $this->db->where('status' , '0');
            $data['asset'] = $this->db->get('asset')->result_array();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/index', $data);
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

        if ($this->session->userdata('npk')=='0282'){
            $data['asset'] = $this->db->where('status >=' , '1');
            $data['asset'] = $this->db->get('asset')->result_array();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/index', $data);
        $this->load->view('templates/footer');
    }

    public function opname()
    {
        $asset = $this->db->get_where('asset', ['id' => $this->input->post('id')])->row_array();
        if ($this->input->post('status')=='2'){
            $pic = $this->input->post('pic');
            $lokasi = $this->input->post('lokasi');
            // if ($asset['npk']==$this->input->post('pic')){
            //     $changePic = 'Y';
            // }
            $changePic = ($asset['npk']==$this->input->post('pic'))? 'N' : 'Y';
            $changeLoc = ($asset['lokasi']==$this->input->post('lokasi'))? 'N' : 'Y';
        }else{
            $pic = $asset['npk'];
            $lokasi = $asset['lokasi'];
            $changePic = 'N';
            $changeLoc = 'N';
        }
        
        $opnamed = $this->db->get_where('asset_opnamed', ['id' => $this->input->post('id')])->row_array();
        if (empty($opnamed)) {

            $config['file_name']            = $this->input->post('id');
            $config['upload_path']          = './assets/img/asset/';
            $config['allowed_types']        = 'jpg|jpeg|png';
            // $config['max_size']             = '5120';

            if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $data = [
                    'id' => $this->input->post('id'),
                    'asset_foto' => $this->upload->data('file_name'),
                    'npk' => $pic,
                    'ex_npk' => $asset['npk'],
                    'lokasi' => $lokasi,
                    'status' => $this->input->post('status'),
                    'catatan' => $this->input->post('note'),
                    'change_pic' => $changePic,
                    'change_lokasi' => $changeLoc,
                    'catatan' => $this->input->post('note'),
                    'div_id' => $this->session->userdata('div_id'),
                    'dept_id' => $this->session->userdata('dept_id'),
                    'sect_id' => $this->session->userdata('sect_id'),
                    'opnamed_by' => $this->session->userdata('nama'),
                    'opnamed_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('asset_opnamed', $data);
            }
        }
        redirect('asset');
    }

    public function id($id)
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        $data['asset'] = $this->db->get_where('asset', ['id' => $id])->row_array();
        if ($data['asset']['status']=='9'){
            $data['sidemenu'] = 'FA';
            $data['sidesubmenu'] = 'Asset';
            $data['opnamed'] = $this->db->get_where('asset_opnamed', ['id' => $id])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/opnamed', $data);
            $this->load->view('templates/footer');
        }else{    
            redirect('f221/asset');
        }
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

        if ($this->input->post('role')=='fac'){
            redirect('f221/verify');
        }else {
            redirect('asset/opname/'.$this->input->post('id'));
        }
    }

    public function verify($id)
    {
        $asset = $this->db->get_where('asset_opnamed',['id' => $id])->row_array();
        if (!empty($asset)){
            //Updated status opname
            $this->db->set('verify_by', $this->session->userdata('nama'));
            $this->db->set('verify_at', date('Y-m-d H:i:s'));
            $this->db->where('id', $id);
            $this->db->update('asset_opnamed');
        }
        redirect('asset/index/fa');
    }

    public function reopname()
    {
        date_default_timezone_set('asia/jakarta');
        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('asset_opnamed');

        $asset = $this->db->get_where('asset',['id' => $this->input->post('id')])->row_array();
        $this->db->where('npk', $asset['npk']);
        $user = $this->db->get('karyawan',['npk', $asset['npk']])->row_array();
     
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://region01.krmpesan.com/api/v2/message/send-text',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
                ],
                'json' => [
                    'phone' => $user['phone'],
                    'message' => "*TOLONG OPNAME KEMBALI ASSET BERIKUT*" . 
                    "\r\n \r\nNo Asset : *" . $asset['asset_no'] . "-". $asset['asset_sub_no']."*" .
                    "\r\nDeskripsi : *" . $asset['asset_description'] . "*" .
                    "\r\nCatatan FA : *" . $this->input->post('note') . "*" .
                    "\r\n \r\nMohon segera lakukan opname sebelum tanggal 31 Agustus 2021.".
                    "\r\n \r\nMasuk menu asset klik link berikut https://raisa.winteq-astra.com/asset"
                ],
            ]
        );
        $body = $response->getBody();

        redirect('asset/index/fa');
    }

    public function opname_by_fa()
    {
        $asset = $this->db->get_where('asset', ['id' => $this->input->post('id')])->row_array();
        if ($this->input->post('status')=='2'){
            $pic = $this->input->post('pic');
            $lokasi = $this->input->post('lokasi');
            $changePic = ($asset['npk']==$this->input->post('pic'))? 'N' : 'Y';
            $changeLoc = ($asset['lokasi']==$this->input->post('lokasi'))? 'N' : 'Y';
        }else{
            $pic = $asset['npk'];
            $lokasi = $asset['lokasi'];
            $changePic = 'N';
            $changeLoc = 'N';
        }
        
        $opnamed = $this->db->get_where('asset_opnamed', ['id' => $this->input->post('id')])->row_array();
        if (empty($opnamed)) {

            $config['file_name']            = $this->input->post('id');
            $config['upload_path']          = './assets/img/asset/';
            $config['allowed_types']        = 'jpg|jpeg|png';
            // $config['max_size']             = '5120';

            if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $data = [
                    'id' => $this->input->post('id'),
                    'asset_foto' => $this->upload->data('file_name'),
                    'npk' => $pic,
                    'ex_npk' => $asset['npk'],
                    'lokasi' => $lokasi,
                    'status' => $this->input->post('status'),
                    'catatan' => $this->input->post('note'),
                    'change_pic' => $changePic,
                    'change_lokasi' => $changeLoc,
                    'catatan' => $this->input->post('note'),
                    'div_id' => $this->session->userdata('div_id'),
                    'dept_id' => $this->session->userdata('dept_id'),
                    'sect_id' => $this->session->userdata('sect_id'),
                    'opnamed_by' => $this->session->userdata('nama'),
                    'opnamed_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('asset_opnamed', $data);
            }
        }
        redirect('asset/index/fa');
    }
}
