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