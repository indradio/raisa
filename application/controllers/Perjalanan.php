<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';

class Perjalanan extends CI_Controller
{
    public function __construct()
    {
        date_default_timezone_set('asia/jakarta');
        parent::__construct();
        is_logged_in();
        $this->load->helper('url');
        
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
        date_default_timezone_set('asia/jakarta');
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
                $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
                if (empty($this->input->post('catatan'))){
                    $catatan = '';
                }else{
                    $catatan = $this->input->post('catatan').' - '. $this->session->userdata('inisial');
                }
                $this->db->set('klaim_by', $this->session->userdata('inisial'));
                $this->db->set('klaim_at', date('Y-m-d H:i:s'));
                $this->db->set('tujuan_pic', $this->input->post('tujuan_pic'));
                $this->db->set('catatan', $catatan);
                $this->db->set('status', '4');
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('perjalanan');

                $this->db->where('sect_id', '215');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();

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
                            'phone' => $ga_admin['phone'],
                            'message' =>"*PENGAJUAN PENYELESAIAN PERJALANAN DINAS*" .
                            "\r\n \r\nNo. Reservasi : *" . $perjalanan['id'] . "*" .
                            "\r\nNama : *" . $perjalanan['nama'] . "*" .
                            "\r\nPeserta : *" . $perjalanan['anggota'] . "*" .
                            "\r\nTujuan : *" . $perjalanan['tujuan'] . "*" .
                            "\r\nKeperluan : *" . $perjalanan['keperluan'] . "*" .
                            "\r\nBerangkat : *" . date("d M Y", strtotime($perjalanan['tglberangkat'])) . ' - ' . date("H:i", strtotime($perjalanan['jamberangkat'])) . "* _estimasi_" .
                            "\r\nKembali : *" . date("d M Y", strtotime($perjalanan['tglkembali'])) . ' - ' . date("H:i", strtotime($perjalanan['jamkembali'])) . "* _estimasi_" .
                            "\r\nKendaraan : *" . $perjalanan['nopol'] . "* ( *" . $perjalanan['kepemilikan'] . "* )" .
                            "\r\n \r\nKasbon : *" . $perjalanan['kasbon'] . "*" .
                            "\r\nBiaya : *" . $perjalanan['total'] . "*" .
                            "\r\n \r\nProses sekarang! https://raisa.winteq-astra.com/perjalanandl/penyelesaian/".$perjalanan['id'],
                        ],
                    ]
                );
                $body = $response->getBody();
                redirect('perjalanan/penyelesaian/daftar');
            }else{
                redirect('perjalanan/penyelesaian/daftar');
            }
        } else {
            //Check PIC
            $pic = $this->db->where('karyawan_inisial', $perjalanan['pic_perjalanan']);
            $pic = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $parameter])->row_array();
            if (empty($pic)){ redirect('perjalanan/penyelesaian_pic/'.$parameter); }

            if ($perjalanan['jenis_perjalanan'] != 'TA') {
                $peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $parameter])->result_array();
                foreach ($peserta as $a) :
                    $this->db->where('jenis_perjalanan', $perjalanan['jenis_perjalanan']);
                    $this->db->where('gol_id', $a['karyawan_gol']);
                    $tunjangan = $this->db->get('perjalanan_tunjangan')->row_array();
                    
                    $this->db->set('uang_saku', $tunjangan['uang_saku']);
                    $this->db->set('insentif_pagi', $tunjangan['insentif_pagi']);
                    $this->db->set('um_pagi', $tunjangan['um_pagi']);
                    $this->db->set('um_siang', $tunjangan['um_siang']);
                    $this->db->set('um_malam', $tunjangan['um_malam']);
                    $this->db->where('npk', $a['npk']);
                    $this->db->where('perjalanan_id', $parameter);
                    $this->db->update('perjalanan_anggota');
                    
                endforeach;

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
                }elseif ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] <= $um['um3'] and $perjalanan['tglkembali'] > $perjalanan['tglberangkat']) {
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
                }elseif ($perjalanan['jamkembali'] <= $um['um4'] and $perjalanan['tglkembali'] > $perjalanan['tglberangkat']) {
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
            }else{

                $total = $perjalanan['taksi'] + $perjalanan['bbm'] + $perjalanan['tol'] + $perjalanan['parkir'];
                $this->db->set('total', $total);
                $this->db->where('id', $parameter);
                $this->db->update('perjalanan');

            }

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
    public function penyelesaian_pic($id)
    {
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Penyelesaian';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['perjalanan'] = $this->db->where('npk', $this->session->userdata('npk'));
        $data['perjalanan'] = $this->db->where('status', '3');
        $data['perjalanan'] = $this->db->get_where('perjalanan', ['id' => $id])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanandl/penyelesaian_user_pic', $data);
        $this->load->view('templates/footer');
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

    public function change_pic($id,$inisial)
    {
        $this->db->set('pic_perjalanan', $inisial);
        $this->db->where('id', $id);
        $this->db->update('perjalanan');
     
        redirect('perjalanan/penyelesaian/' . $id);
    }

    public function change_kategori()
    {
        $this->db->set('jenis_perjalanan', 'DLPP');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perjalanan');
     
        redirect('perjalanan/penyelesaian/' . $this->input->post('id'));
    }

    public function change_datetime()
    {
        date_default_timezone_set('asia/jakarta');
        if (date("Y-m-d H:i:s", strtotime($this->input->post('tglberangkat'))) >= date("Y-m-d H:i:s", strtotime($this->input->post('tglkembali')))) {
            $this->session->set_flashdata('message', 'backdate');
            redirect('perjalanandl/penyelesaian/'.$this->input->post('id'));
        } else {
            $this->db->set('tglberangkat', date("Y-m-d", strtotime($this->input->post('tglberangkat'))));
            $this->db->set('jamberangkat', date("H:i:s", strtotime($this->input->post('tglberangkat'))));
            $this->db->set('tglkembali', date("Y-m-d", strtotime($this->input->post('tglkembali'))));
            $this->db->set('jamkembali', date("H:i:s", strtotime($this->input->post('tglkembali'))));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('perjalanan');
        }
        
        $perjalanan = $this->db->get_where('perjalanan', ['id' => $this->input->post('id')])->row_array();
        if ($perjalanan['jenis_perjalanan'] != 'TA') {

            $um = $this->db->get_where('perjalanan_um', ['id' =>  '1'])->row_array();
            //Uang Saku
            if ($perjalanan['jenis_perjalanan'] == 'TAPP') {
                $this->db->select_sum('uang_saku');
                $this->db->where('perjalanan_id', $perjalanan['id']);
                $query = $this->db->get('perjalanan_anggota');
                $uang_saku = $query->row()->uang_saku;
            } else {
                $uang_saku = 0;
            };
            //Insentif pagi
            if ($perjalanan['jamberangkat'] <= $um['um1']) {
                $this->db->select_sum('insentif_pagi');
                $this->db->where('perjalanan_id', $perjalanan['id']);
                $query = $this->db->get('perjalanan_anggota');
                $insentif_pagi = $query->row()->insentif_pagi;
            } else {
                $insentif_pagi = 0;
            };
            //Makan Pagi
            if ($perjalanan['jenis_perjalanan'] == 'TAPP' and $perjalanan['jamberangkat'] <= $um['um2']) {
                $this->db->select_sum('um_pagi');
                $this->db->where('perjalanan_id', $perjalanan['id']);
                $query = $this->db->get('perjalanan_anggota');
                $um_pagi = $query->row()->um_pagi;
            } else {
                $um_pagi = 0;
            };
            //Makan Siang
            if ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] >= $um['um3']) {
                $this->db->select_sum('um_siang');
                $this->db->where('perjalanan_id', $perjalanan['id']);
                $query = $this->db->get('perjalanan_anggota');
                $um_siang = $query->row()->um_siang;
            }elseif ($perjalanan['jamberangkat'] <= $um['um3'] and $perjalanan['jamkembali'] <= $um['um3'] and $perjalanan['tglkembali'] > $perjalanan['tglberangkat']) {
                $this->db->select_sum('um_siang');
                $this->db->where('perjalanan_id', $perjalanan['id']);
                $query = $this->db->get('perjalanan_anggota');
                $um_siang = $query->row()->um_siang;
            } else {
                $um_siang = 0;
            };
            //Makan Malam
            if ($perjalanan['jamkembali'] >= $um['um4']) {
                $this->db->select_sum('um_malam');
                $this->db->where('perjalanan_id', $perjalanan['id']);
                $query = $this->db->get('perjalanan_anggota');
                $um_malam = $query->row()->um_malam;
            }elseif ($perjalanan['jamkembali'] <= $um['um4'] and $perjalanan['tglkembali'] > $perjalanan['tglberangkat']) {
                $this->db->select_sum('um_malam');
                $this->db->where('perjalanan_id', $perjalanan['id']);
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
            $this->db->where('id', $perjalanan['id']);
            $this->db->update('perjalanan');

            $peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $perjalanan['id']])->result_array();
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
                $this->db->where('perjalanan_id', $perjalanan['id']);
                $this->db->update('perjalanan_anggota');
            endforeach;
        }
     
        redirect('perjalanandl/penyelesaian/' . $perjalanan['id']);
    }

    public function reservasi($params=null,$id=null)
    {
        date_default_timezone_set('asia/jakarta');
            //auto batalkan reservasi
            $queryReservasi = "SELECT *
            FROM `reservasi`
            WHERE `tglberangkat` <= CURRENT_DATE() 
            AND ADDTIME(`jamberangkat`, '02:00:00') <= CURRENT_TIME()
            AND (`status` >= '1' AND `status` <= '6')
            ";
            $reservasi = $this->db->query($queryReservasi)->result_array();
            foreach ($reservasi as $r) :
                // cari selisih
                // $mulai = strtotime($r['jamberangkat']);
                // $selesai = time();
                // $durasi = $selesai - $mulai;
                // $jam   = floor($durasi / (60 * 60));

                    $status = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array();
                    if (!empty($r)) {

                        $this->db->set('status', '0');
                        $this->db->set('catatan', "Reservasi perjalanan dibatalkan. - Dibatalkan oleh SYSTEM pada " . date('d-m-Y H:i'));
                        $this->db->where('id', $r['id']);
                        $this->db->update('reservasi');

                        $this->db->where('npk', $r['npk']);
                        $karyawan = $this->db->get('karyawan')->row_array();
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
                                    'phone' => $karyawan['phone'],
                                    'message' => "*RESERVASI PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. Reservasi : *" . $r['id'] . "*" .
                                    "\r\nNama : *" . $r['nama'] . "*" .
                                    "\r\nTujuan : *" . $r['tujuan'] . "*" .
                                    "\r\nKeperluan : *" . $r['keperluan'] . "*" .
                                    "\r\nPeserta : *" . $r['anggota'] . "*" .
                                    "\r\nBerangkat : *" . $r['tglberangkat'] . "* *" . $r['jamberangkat'] . "* _estimasi_" .
                                    "\r\nKembali : *" . $r['tglkembali'] . "* *" . $r['jamkembali'] . "* _estimasi_" .
                                    "\r\nKendaraan : *" . $r['nopol'] . "* ( *" . $r['kepemilikan'] . "* )" .
                                    "\r\nStatus Terakhir : *" . $status['nama'] . "*" .
                                    "\r\n \r\nWaktu reservasi kamu telah selesai. Dibatalkan oleh RAISA pada " . date('d-m-Y H:i') .
                                    "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                                ],
                            ]
                        );
                        $body = $response->getBody();
                    }
            endforeach;
            
        $data['sidemenu'] = 'GA';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->Karyawan_model->getById();

        if (empty($params) and empty($id)){
            $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '6'])->result_array();
                                 $this->db->where('tglberangkat', date('Y-m-d'));
                                 $this->db->where('tgl_atasan2 !=', NULL);
            $data['cancelled'] = $this->db->get_where('reservasi', ['status' => '0'])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalanan/reservasi_list', $data);
            $this->load->view('templates/footer');

        }elseif ($params=='id' and !empty($id)){
            $reservasi = $this->db->where('status', '6');
            $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
            $data['reservasi'] = $reservasi;
            if (!empty($reservasi)){
                if ($reservasi['jenis_perjalanan'] != 'TA'){
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('perjalanan/reservasi_proses_pp', $data);
                    $this->load->view('templates/footer');
                }else{
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('perjalanan/reservasi_proses_ta', $data);
                    $this->load->view('templates/footer');
                }
            }else{
                redirect('perjalanan/reservasi');
            }

        }elseif ($params=='aktivated' and !empty($id)){
            $perjalanan = $this->db->get_where('perjalanan', ['reservasi_id' => $id])->row_array();

            if (empty($perjalanan)){
                $this->db->set('jamberangkat', date('H:i:s'));
                $this->db->set('catatan', '');
                $this->db->set('status', '6');
                $this->db->where('id', $id);
                $this->db->update('reservasi');

                redirect('perjalanan/reservasi/id/'.$id);
            }else{
                redirect('perjalanan/reservasi');
            }

        }elseif ($params=='submit' and empty($id)){
            $id = $this->input->post('id');
            $reservasi = $this->db->where('status', '6');
            $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
            $perjalanan = $this->db->get_where('perjalanan', ['reservasi_id' => $id])->row_array();

            // $this->db->where('year(tglberangkat)', date('Y'));
            // $this->db->where('month(tglberangkat)', date('m'));
            // $this->db->from('perjalanan');
            // $totaldl = $this->db->get()->num_rows() + 1;

            $this->load->helper('string');
            $iddl = 'DL' . date("ym", strtotime($reservasi['tglberangkat'])) . random_string('alnum',3);
            $kasbon = $this->input->post('kasbon') > 0 ? "REQUEST" : "CLOSED";
          
            if (empty($perjalanan)){
                if ($reservasi['jenis_perjalanan'] != 'TA'){
                    
                    $data = [
                        'id' => $iddl,
                        'reservasi_id' => $reservasi['id'],
                        'jenis_perjalanan' => $reservasi['jenis_perjalanan'],
                        'npk' => $reservasi['npk'],
                        'nama' => $reservasi['nama'],
                        'anggota' => $reservasi['anggota'],
                        'pic_perjalanan' => $reservasi['pic_perjalanan'],
                        'tujuan' => $reservasi['tujuan'],
                        'copro' => $reservasi['copro'],
                        'keperluan' => $reservasi['keperluan'],
                        'tglberangkat' => $reservasi['tglberangkat'],
                        'jamberangkat' => $reservasi['jamberangkat'],
                        'kmberangkat' => '0',
                        'cekberangkat' => null,
                        'tglkembali' => $reservasi['tglkembali'],
                        'jamkembali' => $reservasi['jamkembali'],
                        'kmkembali' => '0',
                        'cekkembali' => null,
                        'kepemilikan' => $reservasi['kepemilikan'],
                        'kendaraan' => $reservasi['kendaraan'],
                        'nopol' => $reservasi['nopol'],
                        'admin_ga' => $this->session->userdata('inisial'),
                        'tgl_ga' => date('Y-m-d H:i:s'),
                        'catatan' => $reservasi['catatan'],
                        'kmtotal' => '0',
                        'uang_saku' => $reservasi['uang_saku'],
                        'insentif_pagi' => $reservasi['insentif_pagi'],
                        'um_pagi' => $reservasi['um_pagi'],
                        'um_siang' => $reservasi['um_siang'],
                        'um_malam' => $reservasi['um_malam'],
                        'taksi' => $reservasi['taksi'],
                        'bbm' => 0,
                        'tol' => $reservasi['tol'],
                        'parkir' => $reservasi['parkir'],
                        'total' => $reservasi['total'],
                        'kasbon' => $this->input->post('kasbon'),
                        'kasbon_status' => $kasbon,
                        'div_id' => $reservasi['div_id'],
                        'dept_id' => $reservasi['dept_id'],
                        'sect_id' => $reservasi['sect_id'],
                        'ka_dept' => $reservasi['ka_dept'],
                        'status' => '1'
                    ];
                    $this->db->insert('perjalanan', $data);

                    // update table anggota perjalanan
                    $this->db->set('perjalanan_id', $iddl);
                    $this->db->where('reservasi_id', $this->input->post('id'));
                    $this->db->update('perjalanan_tujuan');

                    // update table anggota perjalanan
                    $this->db->set('perjalanan_id', $iddl);
                    $this->db->where('reservasi_id', $this->input->post('id'));
                    $this->db->update('perjalanan_anggota');

                    $this->db->set('admin_ga', $this->session->userdata('inisial'));
                    $this->db->set('tgl_ga', date('Y-m-d H:i:s'));
                    $this->db->set('status', '9');
                    $this->db->where('id', $this->input->post('id'));
                    $this->db->update('reservasi');

                    //Kirim Notifikasi
                    $user = $this->db->get_where('karyawan', ['npk' => $reservasi['npk']])->row_array();

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
                                'message' => "*PERJALANAN DINAS KAMU SUDAH SIAP" .
                                "*\r\n \r\nNo. Perjalanan : *" . $data['id'] . "*" .
                                "\r\nTujuan : *" . $data['tujuan'] . "*" .
                                "\r\nPeserta : *" . $data['anggota'] . "*" .
                                "\r\nKeperluan : *" . $data['keperluan'] . "*" .
                                "\r\nBerangkat : *" . $data['tglberangkat'] . "* *" . $data['jamberangkat'] . "* _estimasi_" .
                                "\r\nKembali : *" . $data['tglkembali'] . "* *" . $data['jamkembali'] . "* _estimasi_" .
                                "\r\nKendaraan : *" . $data['nopol'] . "* ( *" . $data['kepemilikan'] . "* ) " .
                                "\r\n \r\nSebelum berangkat pastikan semua kelengkapan yang diperlukan tidak tertinggal." .
                                "\r\nHati-hati dalam berkendara, gunakan sabuk keselamatan dan patuhi rambu-rambu lalu lintas."
                            ],
                        ]
                    );
                    $body = $response->getBody();

                    if ($this->input->post('kasbon')>0){

                        $this->db->where('sect_id', '211');
                        $fa_admin = $this->db->get('karyawan_admin')->row_array();
                    
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
                                    'phone' => $fa_admin['phone'],
                                    'message' => "*PENGAJUAN KASBON PERJALANAN DINAS*" . 
                                    "\r\n \r\nNo. Perjalanan : *" . $data['id'] . "*" .
                                    "\r\nNama : *" . $data['nama'] . "*" .
                                    "\r\nPeserta : *" . $data['anggota'] . "*" .
                                    "\r\nTujuan : *" . $data['tujuan'] . "*" .
                                    "\r\nBerangkat : *" . $data['tglberangkat'] . "* *" . $data['jamberangkat'] . "*" .
                                    "\r\nKembali : *" . $data['tglkembali'] . "* *" . $data['jamkembali'] . "*" .
                                    "\r\nEstimasi Total : *" . $data['total'] . "*" .
                                    "\r\n \r\n*Kasbon : " . $this->input->post('kasbon') . "*" .
                                    "\r\n \r\nPERJALANAN INI MENGAJUKAN KASBON.".
                                    "\r\n \r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                                ],
                            ]
                        );
                        $body = $response->getBody();
                    }

                    $this->session->set_flashdata('message', 'barudl');
                    redirect('perjalanan/reservasi');

                }else{
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('perjalanan/reservasi_proses_ta', $data);
                    $this->load->view('templates/footer');
                }
            }else{
                redirect('perjalanan/reservasi');
            }
        }else{
            redirect('perjalanan/reservasi');
        }
    }

    public function ta($params=null,$id=null)
    {
        date_default_timezone_set('asia/jakarta');
            //auto batalkan reservasi
            $queryReservasi = "SELECT *
            FROM `reservasi`
            WHERE `tglberangkat` <= CURRENT_DATE() 
            AND ADDTIME(`jamberangkat`, '02:00:00') <= CURRENT_TIME()
            AND (`status` >= '1' AND `status` <= '6')
            ";
            $reservasi = $this->db->query($queryReservasi)->result_array();
            foreach ($reservasi as $r) :
                // cari selisih
                // $mulai = strtotime($r['jamberangkat']);
                // $selesai = time();
                // $durasi = $selesai - $mulai;
                // $jam   = floor($durasi / (60 * 60));

                    $status = $this->db->get_where('reservasi_status', ['id' => $r['status']])->row_array();
                    if (!empty($r)) {

                        $this->db->set('status', '0');
                        $this->db->set('catatan', "Reservasi perjalanan dibatalkan. - Dibatalkan oleh SYSTEM pada " . date('d-m-Y H:i'));
                        $this->db->where('id', $r['id']);
                        $this->db->update('reservasi');

                        $this->db->where('npk', $r['npk']);
                        $karyawan = $this->db->get('karyawan')->row_array();
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
                                    'phone' => $karyawan['phone'],
                                    'message' => "*RESERVASI PERJALANAN DINAS DIBATALKAN*\r\n \r\n No. Reservasi : *" . $r['id'] . "*" .
                                    "\r\nNama : *" . $r['nama'] . "*" .
                                    "\r\nTujuan : *" . $r['tujuan'] . "*" .
                                    "\r\nKeperluan : *" . $r['keperluan'] . "*" .
                                    "\r\nPeserta : *" . $r['anggota'] . "*" .
                                    "\r\nBerangkat : *" . $r['tglberangkat'] . "* *" . $r['jamberangkat'] . "* _estimasi_" .
                                    "\r\nKembali : *" . $r['tglkembali'] . "* *" . $r['jamkembali'] . "* _estimasi_" .
                                    "\r\nKendaraan : *" . $r['nopol'] . "* ( *" . $r['kepemilikan'] . "* )" .
                                    "\r\nStatus Terakhir : *" . $status['nama'] . "*" .
                                    "\r\n \r\nWaktu reservasi kamu telah selesai. Dibatalkan oleh RAISA pada " . date('d-m-Y H:i') .
                                    "\r\nUntuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                                ],
                            ]
                        );
                        $body = $response->getBody();
                    }
            endforeach;
            
        $data['sidemenu'] = 'HR';
        $data['sidesubmenu'] = 'Konfirmasi Perjalanan Dinas';
        $data['karyawan'] = $this->Karyawan_model->getById();

        if (empty($params) and empty($id)){
            $data['reservasi'] = $this->db->where('jenis_perjalanan', 'TA');
            $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '5'])->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalananta/reservasi_list', $data);
            $this->load->view('templates/footer');
        }elseif ($params=='id' and !empty($id)){
            $reservasi = $this->db->where('jenis_perjalanan', 'TA');
            $reservasi = $this->db->where('status', '5');
            $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
            $data['reservasi'] = $reservasi;
            if (!empty($reservasi)){
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/navbar', $data);
                    $this->load->view('perjalananta/reservasi_proses_ta', $data);
                    $this->load->view('templates/footer');
            }else{
                redirect('perjalanan/ta');
            }
        }elseif ($params=='submit' and empty($id)){
            $id = $this->input->post('id');
            $reservasi = $this->db->where('status', '5');
            $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
            $perjalanan = $this->db->get_where('perjalanan_ta', ['reservasi_id' => $id])->row_array();

            $this->db->where('year(tglberangkat)', date('Y'));
            $this->db->where('month(tglberangkat)', date('m'));
            $this->db->from('perjalanan_ta');

            $totaldl = $this->db->get()->num_rows() + 1;
            $iddl = 'TA' . date("ym", strtotime($reservasi['tglberangkat'])) . sprintf("%04s", $totaldl);
          
            if (empty($perjalanan)){
                $data = [
                    'id' => $iddl,
                    'reservasi_id' => $reservasi['id'],
                    'npk' => $reservasi['npk'],
                    'nama' => $reservasi['nama'],
                    'anggota' => $reservasi['anggota'],
                    'pic_perjalanan' => $reservasi['pic_perjalanan'],
                    'tujuan' => $reservasi['tujuan'],
                    'copro' => $reservasi['copro'],
                    'keperluan' => $reservasi['keperluan'],
                    'tglberangkat' => $reservasi['tglberangkat'],
                    'jamberangkat' => $reservasi['jamberangkat'],
                    'tglkembali' => $reservasi['tglkembali'],
                    'jamkembali' => $reservasi['jamkembali'],
                    'akomodasi' => $reservasi['akomodasi'],
                    'penginapan' => $reservasi['penginapan'],
                    'lama_menginap' => $reservasi['lama_menginap'],
                    'kepemilikan' => $reservasi['kepemilikan'],
                    'kendaraan' => $reservasi['kendaraan'],
                    'nopol' => $reservasi['nopol'],
                    'admin_hr' => $this->session->userdata('inisial'),
                    'tgl_hr' => date('Y-m-d H:i:s'),
                    'catatan' => $reservasi['catatan'],
                    'div_id' => $reservasi['div_id'],
                    'dept_id' => $reservasi['dept_id'],
                    'sect_id' => $reservasi['sect_id'],
                    'ka_dept' => $reservasi['ka_dept'],
                    'status' => '1'
                ];
                $this->db->insert('perjalanan_ta', $data);

                $this->db->set('admin_hr', $this->session->userdata('inisial'));
                $this->db->set('tgl_hr', date('Y-m-d H:i:s'));
                $this->db->set('status', '6');
                $this->db->set('last_notify', date('Y-m-d H:i:s'));
                $this->db->where('id', $this->input->post('id'));
                $this->db->update('reservasi');

                //Kirim Notifikasi
                $this->db->where('sect_id', '214');
                $ga_admin = $this->db->get('karyawan_admin')->row_array();

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
                            'phone' => $ga_admin['phone'],
                            'message' =>"*PENGAJUAN PERJALANAN DINAS TA*" .
                            "\r\n \r\nNo. Reservasi : *" . $reservasi['id'] . "*" .
                            "\r\nNama : *" . $reservasi['nama'] . "*" .
                            "\r\nPeserta : *" . $reservasi['anggota'] . "*" .
                            "\r\nTujuan : *" . $reservasi['tujuan'] . "*" .
                            "\r\nKeperluan : *" . $reservasi['keperluan'] . "*" .
                            "\r\nBerangkat : *" . date("d M Y", strtotime($reservasi['tglberangkat'])) . ' - ' . date("H:i", strtotime($reservasi['jamberangkat'])) . "* _estimasi_" .
                            "\r\nKembali : *" . date("d M Y", strtotime($reservasi['tglkembali'])) . ' - ' . date("H:i", strtotime($reservasi['jamkembali'])) . "* _estimasi_" .
                            "\r\nKendaraan : *" . $reservasi['nopol'] . "* ( *" . $reservasi['kendaraan'] . "* )" .
                            "\r\n \r\nPerjalanan ini membutuhkan persetujuan dari anda. Untuk informasi lebih lengkap silahkan buka portal aplikasi di link berikut https://raisa.winteq-astra.com"
                        ],
                    ]
                );
                $body = $response->getBody();

                $this->session->set_flashdata('message', 'barudl');
                redirect('perjalanan/ta');
            }else{
                redirect('perjalanan/ta');
            }
        }else{
            redirect('perjalanan/ta');
        }
    }

    public function peserta($params, $kategori=null)
    {
        $id = $this->input->post('id');
        $inisial = $this->input->post('inisial');
        

        if ($params=='tambah' and $kategori==null){

        }elseif ($params=='tambah' and $kategori=='ta'){
            foreach ($this->input->post('peserta') as $i) :
                $peserta = $this->db->get_where('karyawan', ['inisial' => $i])->row_array();
                $dept = $this->db->get_where('karyawan_dept', ['id' => $peserta['dept_id']])->row_array();
                $posisi = $this->db->get_where('karyawan_posisi', ['id' => $peserta['posisi_id']])->row_array();

                //Cek Peserta
                $this->db->where('reservasi_id', $id);
                $this->db->where('karyawan_inisial', $i);
                $exist_peserta = $this->db->get('perjalanan_anggota')->row_array();
                if (empty($exist_peserta)) {
                    $data = [
                        'perjalanan_id' => null,
                        'reservasi_id' => $id,
                        'npk' => $peserta['npk'],
                        'karyawan_inisial' => $peserta['inisial'],
                        'karyawan_nama' => $peserta['nama'],
                        'karyawan_dept' => $dept['nama'],
                        'karyawan_posisi' => $posisi['nama'],
                        'karyawan_gol' => $peserta['gol_id'],
                        'uang_saku' => 0,
                        'insentif_pagi' => 0,
                        'um_pagi' => 0,
                        'um_siang' => 0,
                        'um_malam' => 0,
                        'total' => 0,
                        'status_pembayaran' => 'BELUM DIBAYAR',
                        'status' => '1'
                    ];
                    $this->db->insert('perjalanan_anggota', $data);
                }
            endforeach;

            $anggota = $this->db->where('reservasi_id', $id);
            $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
            $anggotabaru = array_column($anggota, 'karyawan_inisial');

            $this->db->set('anggota', implode(', ', $anggotabaru));
            $this->db->where('id', $id);
            $this->db->update('reservasi');

            redirect('perjalanan/ta/id/' . $id);
        }

        if ($params=='hapus' and $kategori==null){

        }elseif ($params=='hapus' and $kategori=='ta'){
            $this->db->where('reservasi_id', $id);
            $this->db->where('karyawan_inisial', $inisial);
            $this->db->delete('perjalanan_anggota');
    
            $anggota = $this->db->where('reservasi_id', $id);
            $anggota = $this->db->get_where('perjalanan_anggota')->result_array();
            $anggotabaru = array_column($anggota, 'karyawan_inisial');
    
            $this->db->set('anggota', implode(', ', $anggotabaru));
            $this->db->where('id', $id);
            $this->db->update('reservasi');
    
            redirect('perjalanan/ta/id/' . $id);
        }

    }

    public function jadwal($params=null)
    {
        $id = $this->input->post('id');
        $jadwal_id = $this->input->post('jadwal_id');

        if ($params=='tambah'){
            date_default_timezone_set('asia/jakarta');
            $reservasi = $this->db->get_where('reservasi', ['id' => $id])->row_array();
            
            $tanggal = date("Y-m-d", strtotime($this->input->post('waktu')));
            $tanggal_berangkat = date("Y-m-d", strtotime($reservasi['tglberangkat']));
            $tanggal_kembali = date("Y-m-d", strtotime($reservasi['tglkembali']));
            
            if ($this->input->post('transportasi') == 'Lainnya') {
                $transportasi = $this->input->post('transportasi_lain');
            } else {
                $transportasi = $this->input->post('transportasi');
            }
    
            if ($tanggal >= $tanggal_berangkat and $tanggal <= $tanggal_kembali) {
                $data = [
                    'reservasi_id' => $id,
                    'berangkat' => $this->input->post('berangkat'),
                    'tujuan' => $this->input->post('tujuan'),
                    'waktu' => $this->input->post('waktu'),
                    'transportasi' => $transportasi,
                    'keterangan' => $this->input->post('keterangan'),
                    'status' => '0'
                ];
                $this->db->insert('perjalanan_jadwal', $data);
    
                 redirect('perjalanan/ta/id/' . $id);
            } else {
                $this->session->set_flashdata('message', 'backjadwal');
                 redirect('perjalanan/ta/id/' . $id);
            }
        }elseif ($params=='hapus'){
            $this->db->where('id', $jadwal_id);
            $this->db->where('reservasi_id', $id);
            $this->db->delete('perjalanan_jadwal');
        }else{
            redirect('perjalanan/ta/id/' . $id);
        }

        redirect('perjalanan/ta/id/' . $id);
    }

    public function rsvgk()
    {
        if ($this->input->post('kendaraan') == 'Taksi' or $this->input->post('kendaraan') == 'Sewa' or $this->input->post('kendaraan') == 'Pribadi') {
            $this->db->set('nopol', $this->input->post('nopol'));
            $this->db->set('kendaraan', $this->input->post('kendaraan'));
            $this->db->set('kepemilikan', 'Non Operasional');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        } else {
            $kendaraan = $this->db->get_where('kendaraan', ['nama' => $this->input->post('kendaraan')])->row_array();
            $this->db->set('nopol', $kendaraan['nopol']);
            $this->db->set('kendaraan', $kendaraan['nama']);
            $this->db->set('kepemilikan', 'Operasional');
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('reservasi');
        }
        redirect('perjalanan/reservasi/id/' . $this->input->post('id'));
    }

    public function laporan($params=null,$id=null)
    {
        date_default_timezone_set('asia/jakarta');

        if (empty($params) and empty($id)){
            $data['sidemenu'] = 'Perjalanan Dinas';
            $data['sidesubmenu'] = 'PerjalananKu';
            $data['karyawan'] = $this->Karyawan_model->getById();

            $data['reservasi'] = $this->db->where('jenis_perjalanan', 'TA');
            $data['reservasi'] = $this->db->get_where('reservasi', ['status' => '5'])->result_array();
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalananta/reservasi_list', $data);
            $this->load->view('templates/footer');
        }elseif ($params=='ta' and empty($id)){
            $data['sidemenu'] = 'HR';
            $data['sidesubmenu'] = 'Laporan Perjalanan';
            $data['karyawan'] = $this->Karyawan_model->getById();

            $data['perjalanan'] = $this->db->limit('100');
            $data['perjalanan'] = $this->db->order_by('id', 'desc');
            $data['perjalanan'] = $this->db->get_where('perjalanan_ta')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('perjalananta/perjalanan_report_list', $data);
            $this->load->view('templates/footer');
        }
    }

    public function pdf($params=null,$id=null)
    {
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        if ($params == 'ta' and $id != null){
        
            $data['perjalanan'] = $this->db->get_where('perjalanan_ta', ['id' => $id])->row_array();
            $this->load->view('perjalananta/pdf_surat_tugas_ta', $data);
        }
    }

    public function today()
    {
        // Halaman dashboard
        $data['sidemenu'] = 'Perjalanan Dinas';
        $data['sidesubmenu'] = 'Hari Ini';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
        // List Kendaraan
        $this->db->where('is_active', '1');
        $this->db->where('id !=', '1');
        $data['kendaraan'] = $this->db->get('kendaraan')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('perjalanan/today', $data);
        $this->load->view('templates/footer');
    }
}
