<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sys extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->view('dashboard/info');
    }

    public function active()
    {
        $data['sidemenu'] = 'Lembur';
        $data['sidesubmenu'] = 'LemburKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['user'] = $this->db->get_where('karyawan')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('dashboard/active', $data);
        $this->load->view('templates/footer');
    }

    public function info()
    {
      echo phpinfo();
    }

    public function captcha()
    {
      // Halaman Login
      $this->load->helper('captcha');

      $vals = array(
          'word'          => substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4),
          'img_path'      => './assets/img/captcha/',
          'img_url'       => base_url('assets/img/captcha/'),
          // 'font_path'     => './path/to/fonts/texb.ttf',
          'img_width'     => 125,
          'img_height'    => 40,
          'expiration'    => 7200,
          'word_length'   => 4,
          'font_size'     => 64,
          'img_id'        => 'Imageid',
          'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
  
          // White background and border, black text and red grid
          'colors'        => array(
                  'background'    => array(255, 255, 255),
                  'border'        => array(255, 255, 255),
                  'text'          => array(0, 0, 0),
                  'grid'          => array(255, 40, 40)
                  )
      );
      
      $cap = create_captcha($vals);
   
        echo $cap['image'];
      
    }

    public function menu()
    {
        $data['sidemenu'] = 'System';
        $data['sidesubmenu'] = 'Menu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('sys/menu/index', $data);
        $this->load->view('templates/footer');
    }

    public function submenu($params=null)
    {
        $data['sidemenu'] = 'System';
        $data['sidesubmenu'] = 'Menu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['menu'] = $this->db->get_where('user_sub_menu', ['menu_id' => $params])->row();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('sys/menu/submenu', $data);
        $this->load->view('templates/footer');
    }

    public function get_data($params)
    {    
        if ($params == null){

        }elseif ($params == 'user_menu'){
            $data = $this->db->get('user_menu')->result();

                foreach ($data as $row) {

                    if ($row->is_active == 1)
                    {
                        $status = "<i class='material-icons text-success'>done</i>";
                    }else{
                        $status = "<i class='material-icons text-danger'>close</i>";
                    }
                    $icon = "<i class='material-icons'>".$row->icon."</i>";
                    $action = "<a href='".base_url('sys/submenu/'.$row->id)."' class='btn btn-info btn-link'>View</a>";

                    $output['data'][] = array(
                        "id" => $row->id,
                        "title" => $row->menu,
                        "icon" => $icon,
                        "status" => $status,
                        "action" => $action
                    );
                }

            echo json_encode($output);
            exit();

        }elseif ($params == 'user_submenu'){
            $data = $this->db->get_where('user_sub_menu', ['menu_id' => $this->input->post('menu_id')])->result();

            if ($data)
            {
                foreach ($data as $row) {

                    if ($row->is_active == 1)
                    {
                        $status = "<i class='material-icons text-success'>done</i>";
                    }else{
                        $status = "<i class='material-icons text-danger'>close</i>";
                    }

                    $output['data'][] = array(
                        "id" => $row->id,
                        "title" => $row->title,
                        "url" => $row->url,
                        "status" => $status
                    );
                }
            }else{
                $output['data'][] = array(
                    "id" => null,
                    "title" => null,
                    "url" => null,
                    "status" => null
                );
            }

            echo json_encode($output);
            exit();

        }
    }
}