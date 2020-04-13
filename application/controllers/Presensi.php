<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('presensi_model', 'presensi');
    }

    public function index()
    {
        date_default_timezone_set('asia/jakarta');
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Kehadiran';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

        if (date('H:i') >= '07:30' and date('H:i') <= '09:00') {
            $data['state'] = 'C/In';
        } elseif (date('H:i') >= '11:30' and date('H:i') <= '13:00') {
            $data['state'] = 'C/Rest';
        } elseif (date('H:i') >= '16:00' and date('H:i') <= '17:30') {
            $data['state'] = 'C/Out';
        } else {
            $data['state'] = 'No State for this time';
        }

        $data['time'] = date('H:i');

        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/index', $data);
        $this->load->view('templates/footer');
    }

    public function submit()
    {
        date_default_timezone_set('asia/jakarta');
        $id = date('ymd') . $this->session->userdata('npk') . '-' . $this->input->post('state');
        if (date('D') == 'Sat' or date('D') == 'Sun') {
            $day = 'DayOff';
        } else {
            $day = 'WorkDay';
        }
        if ($this->input->post('lat')) {
            $presensi = $this->db->get_where('presensi', ['id' => $id])->row_array();
            if (empty($presensi)) {
                $data = [
                    'id' => $id,
                    'npk' => $this->session->userdata('npk'),
                    'nama' => $this->session->userdata('nama'),
                    'time' => date('Y-m-d H:i:s'),
                    'state' => $this->input->post('state'),
                    'new_state' => 'WFH',
                    'loc' => $this->input->post('loc'),
                    'lat' => $this->input->post('lat'),
                    'lng' => $this->input->post('lng'),
                    'platform' => $this->input->post('platform'),
                    'div_id' => $this->session->userdata('div_id'),
                    'dept_id' => $this->session->userdata('dept_id'),
                    'sect_id' => $this->session->userdata('sect_id'),
                    'day_state' => $day
                ];
                $this->db->insert('presensi', $data);
                $this->session->set_flashdata('message', 'clockSuccess');
            } else {
                $this->session->set_flashdata('message', 'clockSuccess2');
            }
        } else {
            $this->session->set_flashdata('message', 'clockFailed');
        }
        redirect('presensi');
    }
    public function pik()
    {
        date_default_timezone_set('asia/jakarta');

        $data = [
            'npk' => $this->session->userdata('npk'),
            'nama' => $this->session->userdata('nama')
        ];
        $this->db->insert('idcard', $data);
        redirect('presensi');
    }

    public function data()
    {
        date_default_timezone_set('asia/jakarta');
        if (empty($this->input->post('month'))) {
            $data['bulan'] = date('m');
        } else {
            $data['bulan'] = $this->input->post('month');
        }
        $data['tahun'] = date('Y');
        $data['sidemenu'] = 'Kehadiran';
        $data['sidesubmenu'] = 'Data';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('presensi/data', $data);
        $this->load->view('templates/footer');
    }
}
