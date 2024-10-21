<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Asset extends CI_Controller
{
    public function __construct()
    {
        date_default_timezone_set('asia/jakarta');
        parent::__construct();
        is_logged_in();
    }

    public function scan()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'Outstanding';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/scan', $data);
        $this->load->view('templates/footer');
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

    public function id($id)
    {
        if ($id == $this->session->userdata('npk'))
        {
            $data['sidemenu'] = 'Asset';

            $data['sidesubmenu'] = 'Asset';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/index-id', $data);
            $this->load->view('templates/footer');
        }else{
            redirect('asset/id/'.$this->session->userdata('npk'));
        }
    }

    public function fa($params)
    {

        if ($params=='remaining'){
            $data['sidemenu'] = 'FA Asset';
            $data['sidesubmenu'] = 'Remaining';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/fa/remaining', $data);
            $this->load->view('templates/footer');
        }elseif ($params=='verification'){
            $data['sidemenu'] = 'FA Asset';
            $data['sidesubmenu'] = 'Verification';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/fa/verification', $data);
            $this->load->view('templates/footer');
        }elseif ($params=='opnamed'){
            $data['sidemenu'] = 'FA Asset';
            $data['sidesubmenu'] = 'Opnamed';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/fa/opnamed', $data);
            $this->load->view('templates/footer');

        }else{
            $data['sidemenu'] = 'FA Asset';
            $data['sidesubmenu'] = 'Asset';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/fa/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function outstanding()
    {
        $data['sidemenu'] = 'Asset';
        $data['sidesubmenu'] = 'Outstanding';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        
        $this->db->where('npk', $this->session->userdata('npk'));
        $this->db->where('opname_status', 0);
        $assetRemaining = $this->db->get('asset');
        $data['assetRemaining'] = $assetRemaining->num_rows();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('asset/outstanding', $data);
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

    public function opname($params1,$params2)
    {
        $this->db->where('asset_no', $params1);
        $this->db->where('asset_sub_no', $params2);
        $asset = $this->db->get('asset')->row_array();

        if ($asset){
            
            if ($asset['opname_status'] == 0)
            {
                $data['sidemenu'] = 'Asset';
                $data['sidesubmenu'] = 'Outstanding';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                
                $data['asset'] = $asset;
        
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('asset/opname1', $data);
                $this->load->view('templates/footer');
            }elseif ($asset['opname_status'] == 1)
            {
                $data['sidemenu'] = 'Asset';
                $data['sidesubmenu'] = 'Outstanding';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                
                $data['asset'] = $asset;
                $data['opnamed'] = $this->db->get_where('asset_opnamed', ['id' => $asset['id']])->row_array();;
        
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('asset/opname2', $data);
                $this->load->view('templates/footer');
            }

        }else{
            redirect('asset/outstanding');
        }
        
        // if ($params=='proses'){
        //     $changePic = ($this->input->post('old_npk')==$this->input->post('new_npk'))? 'N' : 'Y';
        //     $changeRoom = ($this->input->post('old_lokasi')==$this->input->post('new_lokasi'))? 'N' : 'Y';

        //     if ($changePic=='N' AND $changeRoom=='N' AND $this->input->post('status')=='2'){
        //         $status = '1';
        //     }elseif ($changePic=='Y' AND $this->input->post('status')=='1'){
        //         $status = '2';
        //     }elseif ($changeRoom=='Y' AND $this->input->post('status')=='1'){
        //         $status = '2';    
        //     }else{
        //         $status = $this->input->post('status');
        //     }

        //     $this->db->set('new_npk', $this->input->post('new_npk'));
        //     $this->db->set('new_room', $this->input->post('new_lokasi'));
        //     $this->db->set('catatan', $this->input->post('catatan'));
        //     $this->db->set('status', $status);
        //     $this->db->set('change_pic', $changePic);
        //     $this->db->set('change_room', $changeRoom);
        //     $this->db->set('opnamed_by', $this->session->userdata('nama'));
        //     $this->db->set('opnamed_at', date('Y-m-d H:i:s'));
        //     $this->db->where('id', $this->input->post('id'));
        //     $this->db->update('asset_opnamed');

        //     $this->db->set('opname_status', 2);
        //     $this->db->where('id', $this->input->post('id'));
        //     $this->db->update('asset');

        //     redirect('asset/remaining');
        // }else{
            
        // }
    }

    public function opname_image($params)
    {
   
        $asset = $this->db->get_where('asset', ['id' => $params])->row_array();
        if ($asset) {
        
            $data['sidemenu'] = 'Asset';
            $data['sidesubmenu'] = 'Outstanding';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['asset'] = $asset;
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/opname3', $data);
            $this->load->view('templates/footer');
        }else{
            redirect('asset/opname/'.$asset->asset_no.'/'.$asset->asset_sub_no);
        }
         
    }

    public function opname_proses($params)
    {        
        $asset = $this->db->get_where('asset', ['id' => $this->input->post('id')])->row();
        if ($params == 1)
        {
            $user = $this->db->get_where('karyawan', ['npk' => $asset->npk])->row();
            $opnamed = $this->db->get_where('asset_opnamed', ['id' => $this->input->post('id')])->row_array();
            if (empty($opnamed)) {
    
                $config['file_name']            = $this->input->post('id');
                $config['upload_path']          = './assets/img/asset/2024/';
                $config['allowed_types']        = 'jpg|JPG|jpeg|png';
                // $config['max_size']             = '5120';
    
                if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
                $this->load->library('upload', $config);
    
                    if ($this->upload->do_upload('foto')) {

                        $data = [
                            'id' => $this->input->post('id'),
                            'asset_image' => $this->upload->data('file_name'),
                            'active' => 'active',
                            'uuid' => vsprintf('%s-%s-%s-%s-%s', str_split(bin2hex(random_bytes(16)), 4))
                        ];
                        $this->db->insert('asset_images', $data);
        
                        $this->db->set('opname_status', 1);
                        $this->db->where('id', $this->input->post('id'));
                        $this->db->update('asset');
        
                        redirect('asset/opname/'.$asset->asset_no.'/'.$asset->asset_sub_no);
                    }else{
                        redirect('asset/outstanding');
                    }
                }else{
                    redirect('asset/outstanding');
                }

            }elseif ($params == 2)
            {
                $changePic = ($asset->npk==$this->input->post('new_npk'))? 'N' : 'Y';
                $changeRoom = ($asset->room==$this->input->post('new_lokasi'))? 'N' : 'Y';

                if ($changePic=='N' AND $changeRoom=='N' AND $this->input->post('status')=='2'){
                    $status = '1';
                }elseif ($changePic=='Y' AND $this->input->post('status')=='1'){
                    $status = '2';
                }elseif ($changeRoom=='Y' AND $this->input->post('status')=='1'){
                    $status = '2';
                }else{
                    $status = $this->input->post('status');
                }

                $data = [
                        'id' => $this->input->post('id'),
                        'npk' => $asset->npk,
                        'new_npk' => $this->input->post('new_npk'),
                        'asset_no' => $asset->asset_no,
                        'asset_sub_no' => $asset->asset_sub_no,
                        'asset_description' => $asset->asset_description,
                        'category' => $asset->category,
                        'room' => $asset->room,
                        'new_room' => $this->input->post('new_lokasi'),
                        'first_acq' => $asset->first_acq,
                        'cost_center' => $asset->cost_center,
                        'status' => $status,
                        'change_pic' => $changePic,
                        'change_room' => $changeRoom,
                        'catatan' => $this->input->post('catatan'),
                        'div_id' => $user->div_id,
                        'dept_id' => $user->dept_id,
                        'sect_id' => $user->sect_id,
                        'opnamed_by' => $this->session->userdata('nama'),
                        'opnamed_at' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('asset_opnamed', $data);

                $this->db->set('opname_status', 2);
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('asset');

                redirect('asset/outstanding');

            }elseif ($params == 3)
            {
                $config['file_name']            = $this->input->post('id');
                $config['upload_path']          = './assets/img/asset/2024/';
                $config['allowed_types']        = 'jpg|JPG|jpeg|png';
                // $config['max_size']             = '5120';
    
                if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);
                $this->load->library('upload', $config);
    
                    if ($this->upload->do_upload('foto')) {

                        $data = [
                            'id' => $this->input->post('id'),
                            'asset_image' => $this->upload->data('file_name'),
                            'uuid' => vsprintf('%s-%s-%s-%s-%s', str_split(bin2hex(random_bytes(16)), 4))
                        ];
                        $this->db->insert('asset_images', $data);
        
                        $this->db->set('opname_status', 1);
                        $this->db->where('id', $this->input->post('id'));
                        $this->db->update('asset');
        
                        redirect('asset/opname/'.$asset->asset_no.'/'.$asset->asset_sub_no);
                    }
            }

    }

    public function verification($params)
    {
        
        if ($params=='proses'){

            $this->db->set('verify_by', $this->session->userdata('nama'));
            $this->db->set('verify_at', date('Y-m-d H:i:s'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('asset_opnamed');

            $this->db->set('opname_status', 3);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('asset');

            redirect('asset/fa/verification');
        }else{
            $asset = $this->db->get_where('asset_opnamed', ['id' => $params])->row_array();
            if ($asset){
                $data['sidemenu'] = 'FA Asset';
                $data['sidesubmenu'] = 'Verification';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                
                $data['asset'] = $asset;
        
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('asset/fa/opname_verification', $data);
                $this->load->view('templates/footer');
            }else{
                redirect('asset/fa/verification');
            }
        }
    }

    // public function id($id)
    // {
    //     $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
    //     $data['asset'] = $this->db->get_where('asset', ['id' => $id])->row_array();
    //     if ($data['asset']['status']=='9'){
    //         $data['sidemenu'] = 'FA';
    //         $data['sidesubmenu'] = 'Asset';
    //         $data['opnamed'] = $this->db->get_where('asset_opnamed', ['id' => $id])->row_array();
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/sidebar', $data);
    //         $this->load->view('templates/navbar', $data);
    //         $this->load->view('asset/opnamed', $data);
    //         $this->load->view('templates/footer');
    //     }else{    
    //         redirect('f221/asset');
    //     }
    // }

    public function laporan()
    {
         
            $data['sidemenu'] = 'FA';
            $data['sidesubmenu'] = 'Laporan Asset';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
    
            $data['asset'] = $this->db->get('asset')->result_array();
                    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('asset/asset-report', $data);
            $this->load->view('templates/footer');

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

        $this->db->set('opname_status', 0);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('asset');

        $this->db->where('id', $this->input->post('id'));
        $this->db->delete('asset_opnamed');

        // $asset = $this->db->get_where('asset',['id' => $this->input->post('id')])->row_array();
        // $this->db->where('npk', $asset['npk']);
        // $user = $this->db->get('karyawan',['npk', $asset['npk']])->row_array();
     
        // $client = new \GuzzleHttp\Client();
        // $response = $client->post(
        //     'https://region01.krmpesan.com/api/v2/message/send-text',
        //     [
        //         'headers' => [
        //             'Content-Type' => 'application/json',
        //             'Accept' => 'application/json',
        //             'Authorization' => 'Bearer zrIchFm6ewt2f18SbXRcNzSVXJrQBEsD1zrbjtxuZCyi6JfOAcRIQkrL6wEmChqVWwl0De3yxAhJAuKS',
        //         ],
        //         'json' => [
        //             'phone' => $user['phone'],
        //             'message' => "*TOLONG OPNAME KEMBALI ASSET BERIKUT*" . 
        //             "\r\n \r\nNo Asset : *" . $asset['asset_no'] . "-". $asset['asset_sub_no']."*" .
        //             "\r\nDeskripsi : *" . $asset['asset_description'] . "*" .
        //             "\r\nCatatan FA : *" . $this->input->post('note') . "*" .
        //             "\r\n \r\nMohon segera lakukan opname sebelum tanggal 28 September 2023.".
        //             "\r\n \r\nMasuk menu asset klik link berikut https://raisa.winteq-astra.com/asset/remaining"
        //         ],
        //     ]
        // );
        // $body = $response->getBody();

        redirect('asset/fa/verification');
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

    public function get($params=null)
    {
        if ($params==null){
            $asset = $this->db->get_where('asset', ['npk' => $this->session->userdata('npk')])->result();
            if (!empty($asset)){
                foreach ($asset as $row) {

                    $output['data'][] = array(
                        "no" => $row->asset_no,
                        "deskripsi" => $row->asset_description,
                        "action" => "<button type='button' class='btn btn-success btn-link btn-just-icon' data-toggle='modal' data-target='#opname' data-id='".$row->id."' data-asset_no='".$row->asset_no."'><i class='material-icons'>add_a_photo</i></button>"
                    );
                }
            }else{
                $output['data'][] = array(
                    "no" => '',
                    "deskripsi" => 'There are no data to display.',
                    "action" => ''
                );
            }
 
            echo json_encode($output);
            exit();

        }elseif ($params=='id'){
            $asset = $this->db->get_where('asset', ['npk' => $this->session->userdata('npk')])->result();
            if (!empty($asset)){
                foreach ($asset as $row) {

                    $output['data'][] = array(
                        "no" => $row->asset_no.'-'.$row->asset_sub_no,
                        "description" => $row->asset_description,
                        "category" => $row->category,
                        "room" => $row->room,
                        "action" => "<button type='button' class='btn btn-success btn-link btn-just-icon disabled' data-toggle='modal' data-target='#opname' data-id='".$row->id."' data-asset_no='".$row->asset_no."'><i class='material-icons'>add_a_photo</i></button>"
                    );
                }
            }else{
                $output['data'][] = array(
                    "no" => '',
                    "description" => 'There are no data to display.',
                    "category" => '',
                    "room" => '',
                    "action" => ''
                );
            }
 
            echo json_encode($output);
            exit();

        }elseif ($params=='outstanding') {

            if ($this->session->userdata('inisial')=='MRS' OR $this->session->userdata('inisial')=='IDA'){
                            $this->db->where('opname_status <', 2);
                            $this->db->where('npk', '0282');
                $asset =    $this->db->get('asset')->result();

            }elseif ($this->session->userdata('inisial')=='DWS'){
                            $this->db->where('opname_status <', 2);
                $asset =    $this->db->get('asset')->result();

            }else{
                            $this->db->where('opname_status <', 2);
                            $this->db->where('npk', $this->session->userdata('npk'));
                $asset =    $this->db->get('asset')->result();

            }

            
            if (!empty($asset)){
                foreach ($asset as $row) {
                    $user =  $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
                    $output['data'][] = array(
                        "no" => "<a href='".base_url('asset/opname/'.$row->asset_no.'/'.$row->asset_sub_no)."' class='btn btn-primary btn-sm active' role='button' aria-pressed='true'>Opname</a>",
                        "deskripsi" => $row->asset_no.'</br>'.$row->asset_description
                    );


                }
            }else{
                $output['data'][] = array(
                    "no" => '',
                    "deskripsi" => 'There are no data to display.',
                    "action" => ''
                );
            }
 
            echo json_encode($output);
            exit();
        }elseif ($params=='fa') {

            $asset =    $this->db->get('asset')->result();

            if (!empty($asset)){
                foreach ($asset as $row) {

                    $user =  $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
                    // $status =  $this->db->get_where('asset_status', ['id' => $row->npk])->row();
                    $listroom =  $this->db->get_where('asset_lokasi', ['id' => $row->room])->row();
                    if (empty($room)){
                        $room = $listroom->nama;
                    }else{
                        $room = 'Unknown';
                    }


                        
                    $output['data'][] = array(
                            "no" => $row->asset_no,
                            "sub" => $row->asset_sub_no,
                            "description" => $row->asset_description,
                            "category" => $row->category,
                            "user" => $row->npk,
                            "user_nama" => $user->nama,
                            "room" => $row->room,
                            "room_nama" => $room,
                            // "status" => $status->nama,
                            "details" => "<button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' data-target='#photo' data-id='".$row->id."' data-asset_no='".$row->asset_no."'><i class='material-icons'>image_search</i></button>
                                            <button type='button' class='btn btn-danger btn-link btn-just-icon' data-toggle='modal' disabled><i class='material-icons'>person_search</i></button>"
                        );

                    // <th>NO</th>
                    //                     <th>SUB</th>
                    //                     <th>DESCRIPTION</th>
                    //                     <th>CATEGORY</th>
                    //                     <th>PIC</th>
                    //                     <th>ROOM</th>
                    //                     <th>STATUS</th>
                    //                     <th>CHANGE PIC</th>
                    //                     <th>NEW PIC</th>
                    //                     <th>CHANGE ROOM</th>
                    //                     <th>NEW ROOM</th>
                    //                     <th>OPNAME BY</th>
                    //                     <th>VERIFICATION BY</th>
                    //                     <th>DETAILS</th>

                }
            }else{
                $output['data'][] = array(
                    "no" => '',
                    "deskripsi" => 'There are no data to display.',
                    "action" => ''
                );
            }
 
            echo json_encode($output);
            exit();
        }elseif ($params=='opname_remaining') {

                        $this->db->where('opname_status', 0);
            $asset =    $this->db->get('asset')->result();

            if (!empty($asset)){

                foreach ($asset as $row) {

                    $user =  $this->db->get_where('karyawan', ['npk' => $row->npk])->row();

                    $output['data'][] = array(
                            "no" => $row->asset_no,
                            "sub" => $row->asset_sub_no,
                            "description" => $row->asset_description,
                            "category" => $row->category,
                            "user" => $row->npk,
                            "user_nama" => $user->nama,
                            "room" => $row->room,
                            "details" => "<a href='".base_url('asset/opname/'.$row->asset_no.'/'.$row->asset_sub_no)."' class='btn btn-primary btn-sm active' role='button' aria-pressed='true'>Opname Now</a>"
                        );
                }

            }else{
                $output['data'][] = array(
                    "no" => '',
                    "sub" => '',
                    "description" => 'There are no data to display.',
                    "category" => '',
                    "user" => '',
                    "user_nama" => '',
                    "room" => '',
                    "details" => ''
                );
            }
 
            echo json_encode($output);
            exit();
        }elseif ($params=='opname_verification') {

            $this->db->where('verify_by', NULL);
            $asset =    $this->db->get('asset_opnamed')->result();

            if (!empty($asset)){
                foreach ($asset as $row) {

                    $user =  $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
                    $status =  $this->db->get_where('asset_status', ['id' => $row->status])->row();
                    
                    if ($row->change_pic=='Y'){
                        $change_pic = "<button type='button' class='btn btn-success btn-link btn-just-icon' disabled><i class='material-icons'>done</i></button>";
                    }else{
                        $change_pic = "<button type='button' class='btn btn-danger btn-link btn-just-icon' disabled><i class='material-icons'>close</i></button>";
                    }

                    if ($row->change_room=='Y'){
                        $change_room = "<button type='button' class='btn btn-success btn-link btn-just-icon' disabled><i class='material-icons'>done</i></button>";
                    }else{
                        $change_room = "<button type='button' class='btn btn-danger btn-link btn-just-icon' disabled><i class='material-icons'>close</i></button>";
                    }
                        
                    $output['data'][] = array(
                            "no" => $row->asset_no,
                            "sub" => $row->asset_sub_no,
                            "description" => $row->asset_description,
                            "category" => $row->category,
                            "user" => $row->npk,
                            "user_nama" => $user->nama,
                            "room" => $row->room,
                            "status" => $status->name,
                            "change_pic" => $change_pic,
                            "change_room" => $change_room,
                            "opnamed_by" => $row->opnamed_by,
                            "opnamed_at" => date('d-m-Y H:i', strtotime($row->opnamed_at)),
                            "catatan" => $row->catatan,
                            "actions" => "<a href='". base_url('asset/verification/'.$row->id)."' type='button' class='btn btn-success btn-link btn-just-icon'><i class='material-icons'>task_alt</i></a>"
                        );
                }
            }else{
                $output['data'][] = array(
                    "no" => '',
                    "deskripsi" => 'There are no data to display.',
                    "action" => ''
                );
            }
 
            echo json_encode($output);
            exit();
        }elseif ($params=='opname_opnamed') {

            $this->db->where('verify_by !=', NULL);
            $asset =    $this->db->get('asset_opnamed')->result();

            if (!empty($asset)){
                foreach ($asset as $row) {

                    $user =  $this->db->get_where('karyawan', ['npk' => $row->npk])->row();
                    $new_user =  $this->db->get_where('karyawan', ['npk' => $row->new_npk])->row();
                    $status =  $this->db->get_where('asset_status', ['id' => $row->status])->row();
                    
                    if ($row->change_pic=='Y'){
                        $change_pic = "YA";
                        $new_user   =  $this->db->get_where('karyawan', ['npk' => $row->new_npk])->row();
                        $new_npk    =$new_user->npk;
                        $new_nama   =$new_user->nama;
                    }else{
                        $change_pic = "TIDAK";
                        $new_npk    ="";
                        $new_nama   ="";
                    }

                    $change_room = ($row->change_room=='Y')? 'YA' : 'TIDAK';
                    $new_room = ($row->change_room=='Y')? $row->new_room : '';
                        
                    $output['data'][] = array(
                            "no" => $row->asset_no,
                            "sub" => $row->asset_sub_no,
                            "description" => $row->asset_description,
                            "category" => $row->category,
                            "change_pic" => $change_pic,
                            "user" => $row->npk,
                            "user_nama" => $user->nama,
                            "new_user" => $new_npk,
                            "new_user_nama" => $new_nama,
                            "change_room" => $change_room,
                            "room" => $row->room,
                            "new_room" => $new_room,
                            "status" => $status->name,
                            "catatan" => $row->catatan,
                            "opnamed_by" => $row->opnamed_by,
                            "opnamed_at" => date('d-m-Y H:i', strtotime($row->opnamed_at)),
                            "verify_by" => $row->verify_by,
                            "verify_at" => date('d-m-Y H:i', strtotime($row->verify_at)),
                            "catatan" => $row->catatan
                        );
                }
            }else{
                $output['data'][] = array(
                    "no" => '',
                    "deskripsi" => 'There are no data to display.',
                    "action" => ''
                );
            }
 
            echo json_encode($output);
            exit();
        }
    }
}
