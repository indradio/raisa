<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perjalanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Karyawan_model");
    }

    public function index()
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'PerjalananKu';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/index', $data);
        $this->load->view('templates/footer');
    }

    public function penyelesaian($parameter)
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
        if (empty($perjalanan)) {
            if ($parameter == 'daftar') {
                $data['sidemenu'] = 'Perjalanan Dinas';
                $data['sidesubmenu'] = 'Penyelesaian';
                $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
                $data['perjalanan'] = $this->db->where('npk', $this->session->userdata('npk'));
                $data['perjalanan'] = $this->db->get_where('perjalanan', ['status' => '3'])->result_array();
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/navbar', $data);
                $this->load->view('perjalanandl/penyelesaian_user_daftar', $data);
                $this->load->view('templates/footer');
            } elseif ($parameter == 'submit') {
                $this->db->set('klaim_by', $this->session->userdata('inisial'));
                $this->db->set('klaim_at', date('Y-m-d H:i:s'));
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('perjalanan');

                redirect('perjalanan/penyelesaian/daftar');
            }
        } else {
            $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
            //Uang Saku
            if ($perjalanan['jenis_perjalanan'] == 'TAPP') {
                $this->db->select_sum('uang_saku');
                $this->db->where('perjalanan_id', $parameter);
                $query = $this->db->get('perjalanan_anggota');
                $uang_saku = $query->row()->uang_saku;
            } else {
                $uang_saku = 0;
            };
            //Insentif pagi
            if ($perjalanan['jamberangkat'] <= $um['um1']) {
                $this->db->select_sum('insentif_pagi');
                $this->db->where('perjalanan_id', $parameter);
                $query = $this->db->get('perjalanan_anggota');
                $insentif_pagi = $query->row()->insentif_pagi;
            } else {
                $insentif_pagi = 0;
            };
            //Makan Pagi
            if ($perjalanan['jenis_perjalanan'] == 'TAPP' and $perjalanan['jamberangkat'] <= $um['um2']) {
                $this->db->select_sum('um_pagi');
                $this->db->where('perjalanan_id', $parameter);
                $query = $this->db->get('perjalanan_anggota');
                $um_pagi = $query->row()->um_pagi;
            } else {
                $um_pagi = 0;
            };
            //Makan Siang
            if ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] >= $um['um3']) {
                $this->db->select_sum('um_siang');
                $this->db->where('perjalanan_id', $parameter);
                $query = $this->db->get('perjalanan_anggota');
                $um_siang = $query->row()->um_siang;
            } else {
                $um_siang = 0;
            };
            //Makan Malam
            if ($perjalanan['jamkembali'] >= $um['um4']) {
                $this->db->select_sum('um_malam');
                $this->db->where('perjalanan_id', $parameter);
                $query = $this->db->get('perjalanan_anggota');
                $um_malam = $query->row()->um_malam;
            } else {
                $um_malam = 0;
            };
            $total = $uang_saku + $insentif_pagi + $um_pagi + $um_siang + $um_malam + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];
            $this->db->set('uang_saku', $uang_saku);
            $this->db->set('insentif_pagi', $insentif_pagi);
            $this->db->set('um_pagi', $um_pagi);
            $this->db->set('um_siang', $um_siang);
            $this->db->set('um_malam', $um_malam);
            $this->db->set('total', $total);
            $this->db->where('id', $parameter);
            $this->db->update('perjalanan');

            $peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $parameter])->result_array();
            foreach ($peserta as $p) :
                if ($uang_saku > 0) {
                    $peserta_uang_saku = $p['uang_saku'];
                } else {
                    $peserta_uang_saku = 0;
                }
                if ($insentif_pagi > 0) {
                    $peserta_insentif_pagi = $p['insentif_pagi'];
                } else {
                    $peserta_insentif_pagi = 0;
                }
                if ($um_pagi > 0) {
                    $peserta_um_pagi = $p['um_pagi'];
                } else {
                    $peserta_um_pagi = 0;
                }
                if ($um_siang > 0) {
                    $peserta_um_siang = $p['um_siang'];
                } else {
                    $peserta_um_siang = 0;
                }
                if ($um_malam > 0) {
                    $peserta_um_malam = $p['um_malam'];
                } else {
                    $peserta_um_malam = 0;
                }

                $total = $peserta_uang_saku + $peserta_insentif_pagi + $peserta_um_pagi + $peserta_um_siang + $peserta_um_malam;
                $this->db->set('total', $total);
                $this->db->where('npk', $p['npk']);
                $this->db->where('perjalanan_id', $parameter);
                $this->db->update('perjalanan_anggota');
            endforeach;

            $data['sidemenu'] = 'Perjalanan Dinas';
            $data['sidesubmenu'] = 'Penyelesaian';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $parameter])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanandl/penyelesaian_user_proses', $data);
            $this->load->view('templates/footer');
        }
    }
    public function penyelesaian_edit($parameter)
    {
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        if ($parameter == 'taksi') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $this->input->post('taksi') + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];

            $this->db->set('taksi', $this->input->post('taksi'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        } elseif ($parameter == 'tol') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $this->input->post('tol') + $perjalanan['parkir'];

            $this->db->set('tol', $this->input->post('tol'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        } elseif ($parameter == 'parkir') {
            $total = $perjalanan['uang_saku'] + $perjalanan['insentif_pagi'] + $perjalanan['um_pagi'] + $perjalanan['um_siang'] + $perjalanan['um_malam'] + $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $this->input->post('parkir');

            $this->db->set('parkir', $this->input->post('parkir'));
            $this->db->set('total', $total);
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }
        redirect('perjalanan/penyelesaian/' . $this->input->post('id'));
    }
}
