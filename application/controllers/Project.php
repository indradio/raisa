<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Spout Library
require_once APPPATH.'third_party/spout/src/Spout/Autoloader/autoload.php';
 
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Project extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('project_model', 'project');
    }

    public function index()
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Project';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $data['liststatus'] = $this->db->get("project_status")->result();
        $data['listcustomer'] = $this->db->get("customer")->result();
        $this->load->helper('url');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('project/index', $data);
        $this->load->view('templates/footer');
    }

    public function schedule()
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'Schedule';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('project/schedule', $data);
        $this->load->view('templates/footer');
    }

    public function project_list()
    {
        $list = $this->project->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $project) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $project->copro;
            $row[] = $project->customer_nama;
            $row[] = $project->deskripsi;
            $row[] = $project->status;
          
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->project->count_all(),
            "recordsFiltered" => $this->project->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function project_list_fa()
    {
        $list = $this->project->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $project) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $project->copro;
            $row[] = $project->customer_nama;
            $row[] = $project->deskripsi;
            if ($project->tglopen)
            {
                $row[] = date("d.m.Y", strtotime($project->tglopen));
            }else{
                $row[] = '';
            }
            if ($project->tglteco)
            {
                $row[] = date("d.m.Y", strtotime($project->tglteco));
            }else{
                $row[] = '';
            }
            if ($project->tglclosed)
            {
                $row[] = date("d.m.Y", strtotime($project->tglclosed));
            }else{
                $row[] = '';
            }
            if ($project->tglblock)
            {
                $row[] = date("d.m.Y", strtotime($project->tglblock));
            }else{
                $row[] = '';
            }
            $row[] = $project->status;
          
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->project->count_all(),
            "recordsFiltered" => $this->project->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function project($sect)
    {
        if ($sect=='fa'){
            $data['sidemenu'] = 'FA';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['liststatus'] = $this->db->get_where("project_status", ['id !=' => '1'])->result();
            $data['listcustomer'] = $this->db->get("customer")->result();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/index_fa', $data);
            $this->load->view('templates/footer');
        }
        elseif ($sect=='se'){
            $data['sidemenu'] = 'Sales Engineering';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['liststatus'] = $this->db->get_where("project_status", ['id !=' => '1'])->result();
            $data['listcustomer'] = $this->db->get("customer")->result();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/index_se', $data);
            $this->load->view('templates/footer');
        }
        elseif ($sect=='eng'){
            $data['sidemenu'] = 'Engineering';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['liststatus'] = $this->db->get_where("project_status", ['id !=' => '1'])->result();
            $data['listcustomer'] = $this->db->get("customer")->result();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/index_eng', $data);
            $this->load->view('templates/footer');
        }
        elseif ($sect=='pch'){
            $data['sidemenu'] = 'Purchase';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['liststatus'] = $this->db->get_where("project_status", ['id !=' => '1'])->result();
            $data['listcustomer'] = $this->db->get("customer")->result();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/index_pch', $data);
            $this->load->view('templates/footer');
        }
    }

    public function budget($copro)
    {
        $project = $this->db->get_where('project', ['copro' => $copro])->row_array();
        if (!empty($project)){
            $data['sidemenu'] = 'Sales Engineering';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['material'] = $this->db->get_where('project_material', ['copro' =>  $copro])->result_array();
            $data['manhour'] = $this->db->get_where('project_manhour', ['copro' =>  $copro])->result_array();
            $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('project/budget', $data);
            $this->load->view('templates/footer');
        }
    }

    public function est($copro)
    {
        $project = $this->db->get_where('project', ['copro' => $copro])->row_array();
        if (!empty($project)){
            $data['sidemenu'] = 'Engineering';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
            $data['material'] = $this->db->get_where('project_material', ['copro' =>  $copro])->result_array();
            $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();
            $data['projectcost'] = $this->db->get_where('project_material_detail', ['copro' => $copro])->result_array();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('projectbudget/est_cost', $data);
            $this->load->view('templates/footer');
        }
    }

    public function act($copro)
    {
        $project = $this->db->get_where('project', ['copro' => $copro])->row_array();
        if (!empty($project)){
            $data['sidemenu'] = 'Engineering';
            $data['sidesubmenu'] = 'Project';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
            $data['material'] = $this->db->get_where('project_material', ['copro' => $copro])->result_array();
            $data['project'] = $this->db->get_where('project', ['copro' => $copro])->row_array();
            $data['projectcost'] = $this->db->get_where('project_material_detail', ['copro' => $copro])->result_array();
            $this->load->helper('url');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('projectbudget/act_cost', $data);
            $this->load->view('templates/footer');
        }
    }

    public function importproject()
    {
        //  ketika button submit diklik
        //  if ($this->input->post('submit', TRUE) == 'upload') {
        $config['upload_path']      = './assets/temp_excel/'; //siapkan path untuk upload file
        $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
        $config['file_name']        = 'import_' . time(); //rename file yang diupload

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('copro')) {
            //fetch data upload
            $file   = $this->upload->data();

            $reader = ReaderEntityFactory::createXLSXReader(); //buat xlsx reader
            $reader->open('./assets/temp_excel/' . $file['file_name']); //open file xlsx yang baru saja diunggah

            //looping pembacaat sheet dalam file        
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;

                //siapkan variabel array kosong untuk menampung variabel array data
                $save   = array();

                //looping pembacaan row dalam sheet
                foreach ($sheet->getRowIterator() as $row) {

                    if ($numRow > 1) {
                        //ambil cell
                        $cells = $row->getCells();

                        $data = array(
                            'copro'             => $cells[0],
                            'customer_inisial'  => $cells[1],
                            'material'          => $cells[2],
                            'deskripsi'         => $cells[3],
                            'status'            => $cells[4]
                        );

                        //tambahkan array $data ke $save
                        // array_push($save, $data);

                        //simpan data ke database
                        $copro = $this->db->get_where('project', ['copro' => $data['copro']])->row_array();
                        if (empty($copro))
                        {
                            $this->db->insert('project', $data);
                        }else{
                            $this->db->set('status', $data['status']);
                            $this->db->where('copro', $data['copro']);
                            $this->db->update('project');
                        }
                    }

                    $numRow++;
                }
                //simpan data ke database all
                // $this->db->insert_batch('project', $save);

                //tutup spout reader
                $reader->close();

                //hapus file yang sudah diupload
                unlink('./assets/temp_excel/' . $file['file_name']);

                //tampilkan pesan success dan redirect ulang ke index controller import
                echo    '<script type="text/javascript">
                          alert(\'Data berhasil disimpan\');
                          window.location.replace("' . base_url() . '");
                      </script>';
            }
        } else {
            echo "Error :" . $this->upload->display_errors(); //tampilkan pesan error jika file gagal diupload
        }
    // }

    redirect('project/project/fa');
    }
    // }
    
    public function addProject()
    {
        date_default_timezone_set('Asia/Jakarta');
        $project = $this->db->get_where('project', ['copro' => $this->input->post('copro')])->row_array();
        $customer = $this->db->get_where('customer', ['inisial' => $this->input->post('customer')])->row_array();
        if (empty($project))
        {
            $data = [
                'copro' => $this->input->post('copro'),
                'customer_inisial' => $this->input->post('customer'),
                'customer_nama' => $customer['nama'],
                'deskripsi' => strtoupper($this->input->post('deskripsi')),
                'mh_budget' => '0',
                'mh_budget_wbs' => '0',
                'mt_budget' => '0',
                'status' => 'OPEN',
                'tglopen' => date("Y-m-d", strtotime($this->input->post('tanggal'))),
                'update_at' => date("Y-m-d"),
                'highlight' => 1
            ];
            $this->db->insert('project', $data);

            $data = [
                'copro' => $this->input->post('copro'),
                'part' => 'MANUFACTURE',
                'budget' => '0',
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_selisih'=> '0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_selisih'=> '0',
                'update_at'=> date("Y-m-d H:i:s")
                ];
            $this->db->insert('project_material', $data);

            $data = [
                'copro' => $this->input->post('copro'),
                'part' => 'STANDARD',
                'budget' => '0',
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_selisih'=> '0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_selisih'=> '0',
                'update_at'=> date("Y-m-d H:i:s")
                ];
            $this->db->insert('project_material', $data);

            $data = [
                'copro' => $this->input->post('copro'),
                'part' => 'ELECTRIC',
                'budget' => '0',
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_selisih'=> '0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_selisih'=> '0',
                'update_at'=> date("Y-m-d H:i:s")
                ];
            $this->db->insert('project_material', $data);

            $data = [
                'copro' => $this->input->post('copro'),
                'part' => 'PNEUMATIC',
                'budget' => '0',
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_selisih'=> '0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_selisih'=> '0',
                'update_at'=> date("Y-m-d H:i:s")
                ];
            $this->db->insert('project_material', $data);

            $data = [
                'copro' => $this->input->post('copro'),
                'part' => 'HYDRAULIC',
                'budget' => '0',
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_selisih'=> '0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_selisih'=> '0',
                'update_at'=> date("Y-m-d H:i:s")
                ];
            $this->db->insert('project_material', $data);

            $data = [
                'copro' => $this->input->post('copro'),
                'part' => 'OTHERS',
                'budget' => '0',
                'est_cost' => '0',
                'est_exprod'=> '0',
                'est_total' =>'0',
                'est_selisih'=> '0',
                'act_cost' => '0',
                'act_exprod'=> '0',
                'act_total' =>'0',
                'act_selisih'=> '0',
                'update_at'=> date("Y-m-d H:i:s")
                ];
            $this->db->insert('project_material', $data);
        }else{
            //sweet-alert
        }
        redirect('project/project/fa');
    }

    public function updateProject()
    {
        if ($this->input->post('status')=='TECO'){
            $this->db->set('deskripsi', strtoupper($this->input->post('deskripsi')));
            $this->db->set('status', 'TECO');
            $this->db->set('tglteco', date("Y-m-d", strtotime($this->input->post('tanggal'))));
            $this->db->where('copro', $this->input->post('copro'));
            $this->db->update('project');
        }elseif ($this->input->post('status')=='CLOSED'){
            $this->db->set('deskripsi', strtoupper($this->input->post('deskripsi')));
            $this->db->set('status', 'CLOSED');
            $this->db->set('tglclosed', date("Y-m-d", strtotime($this->input->post('tanggal'))));
            $this->db->set('highlight', '0');
            $this->db->where('copro', $this->input->post('copro'));
            $this->db->update('project');
        }elseif ($this->input->post('status')=='BLOCK'){
            $this->db->set('deskripsi', strtoupper($this->input->post('deskripsi')));
            $this->db->set('status', 'BLOCK');
            $this->db->set('tglblock', date("Y-m-d", strtotime($this->input->post('tanggal'))));
            $this->db->set('highlight', '0');
            $this->db->where('copro', $this->input->post('copro'));
            $this->db->update('project');
        }
        redirect('project/project/fa');
    }

    public function updateProjectSE()
    {
        $this->db->set('delivery_date', date("Y-m-d", strtotime($this->input->post('delivery_date'))));
        $this->db->set('po_date', date("Y-m-d", strtotime($this->input->post('po_date'))));
        $this->db->set('cost_amount', $this->input->post('cost_amount'));
        $this->db->where('copro', $this->input->post('copro'));
        $this->db->update('project');
       
        redirect('project/budget/'.$this->input->post('copro'));
    }

    public function delProject()
    {
        $this->db->where('copro', $this->input->post('copro'));
        $this->db->delete('project');

        $this->db->where('copro', $this->input->post('copro'));
        $this->db->delete('project_manhour');
        
        $this->db->where('copro', $this->input->post('copro'));
        $this->db->delete('project_material');

        $this->db->where('copro', $this->input->post('copro'));
        $this->db->delete('project_material_detail');
        
        redirect('project');
    }

    public function ajax_list()
    {
        $list = $this->project->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $project) {

            if (!empty($project->mh_budget)){
                $mh_budget = $project->mh_budget;
            }else{
                $mh_budget = 1;
            }

            if (!empty($project->mt_budget)){
                $mt_budget = $project->mt_budget;
            }else{
                $mt_budget = 1;
            }

            $this->db->select_sum('durasi');
            $this->db->where('copro', $project->copro);
            $this->db->where('status', '9'); 
            $mh = $this->db->get('aktivitas');
            $mh_total = $mh->row()->durasi;

            $this->db->select_sum('durasi');
            $this->db->where('copro', $project->copro);
            $this->db->where('jenis_aktivitas', 'JAM KERJA');
            $this->db->where('status', '9');
            $wh = $this->db->get('aktivitas');
            $mh_wh = $wh->row()->durasi;

            $this->db->select_sum('durasi');
            $this->db->where('copro', $project->copro);
            $this->db->where('jenis_aktivitas', 'LEMBUR');
            $this->db->where('status', '9');
            $ot = $this->db->get('aktivitas');
            $mh_ot = $ot->row()->durasi;

            $this->db->select_sum('est_total');
            $this->db->where('copro', $project->copro);
            $est = $this->db->get('project_material');
            $mt_est = $est->row()->est_total;

            $this->db->select_sum('act_total');
            $this->db->where('copro', $project->copro);
            $act = $this->db->get('project_material');
            $mt_act = $act->row()->act_total;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $project->copro;
            $row[] = $project->customer_inisial;
            $row[] = $project->deskripsi;
            $row[] = null;
            $row[] = null;
            $row[] = null;
            $row[] = $project->status;
            $row[] = null;
            $row[] = $project->mh_budget;
            $row[] = $mh_wh;
            $row[] = round($mh_wh / $mh_budget* 100,2).'%';
            $row[] = $mh_ot;
            $row[] = round($mh_ot / $mh_budget* 100,2).'%';
            $row[] = $mh_total;
            $row[] = round($mh_total / $mh_budget* 100,2).'%';
            $row[] = $project->mt_budget;
            $row[] = $mt_est;
            $row[] = round($mt_est / $mt_budget* 100,2).'%';
            $row[] = $mt_act;
            $row[] = round($mt_act / $mt_budget* 100,2).'%';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->project->count_all(),
            "recordsFiltered" => $this->project->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function wbs($copro)
    {
        $data['sidemenu'] = 'Project';
        $data['sidesubmenu'] = 'WBS';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();
        // $data['wbs'] = $this->db->where('level', '2');
        $data['wbs'] = $this->db->get_where('wbs', ['copro' =>  $copro])->result_array();
        $data['project'] = $this->db->get_where('project', ['copro' =>  $copro])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('project/wbs', $data);
        $this->load->view('templates/footer');
    }

    public function tmbahMilestone()
    {
        date_default_timezone_set('asia/jakarta');
        $copro = $this->input->post('copro');      
        $queryCopro = "SELECT COUNT(*)
        FROM `wbs`
        WHERE `copro` = {$copro} AND `level`= '1' ";
        $coproId = $this->db->query($queryCopro)->row_array();
        $totalCopro = $coproId['COUNT(*)'] + 1;

        $data = [
            'id' => $totalCopro,
            'copro' => $this->input->post('copro'),
            'milestone' => $this->input->post('milestone'),
            'tglmulai_wbs' => $this->input->post('tglmulai'),
            'tglselesai_wbs' => $this->input->post('tglselesai'),
            'level' => '1'
            ];
        $this->db->insert('wbs', $data);

     redirect('project/wbs/' . $data['copro']);
            
    }

    public function ubahMilestone()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('id');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        $this->db->set('milestone', $this->input->post('milestone'));
        $this->db->set('tglmulai_wbs', $this->input->post('tglmulai'));
        $this->db->set('tglselesai_wbs', $this->input->post('tglselesai'));
        $this->db->where($array);
        $this->db->update('wbs');

        redirect('project/wbs/'.$copro);

    }

    public function tmbahAkt()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('milestone');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        //query Mailstone
        $queryMailstone = "SELECT *
        FROM `wbs`
        WHERE (`copro` = {$copro}) AND (`id` = {$id} AND `level`= '1') ";
        $mailstone = $this->db->query($queryMailstone)->row_array();
        $totalMailstone = $mailstone['total_aktivitas'] + 1;

        //query Aktivitas Mailstone
        $queryTGL = "SELECT * 
        FROM `wbs` 
        WHERE (`copro` = {$copro}) AND (`id` = {$id} AND `level`= '1')";
        $tgl = $this->db->query($queryTGL)->row_array();

        if(date("Y-m-d", strtotime($this->input->post('tglmulai'))) < date("Y-m-d", strtotime($tgl['tglmulai_wbs'])) OR date("Y-m-d", strtotime($this->input->post('tglmulai'))) > date("Y-m-d", strtotime($tgl['tglselesai_wbs'])) OR date("Y-m-d", strtotime($this->input->post('tglselesai'))) > date("Y-m-d", strtotime($tgl['tglselesai_wbs'])) OR date("Y-m-d", strtotime($this->input->post('tglselesai'))) < date("Y-m-d", strtotime($tgl['tglmulai_wbs'])) ){

            $this->session->set_flashdata('message', 'update');
            redirect('project/wbs/' .$this->input->post('copro'));
        }else
        {
            $data = [
            'id' => $id .'.' .$totalMailstone,
            'copro' => $this->input->post('copro'),
            // 'total_aktivitas' => $this->input->post('milestone'),
            'aktivitas' => $this->input->post('aktivitas'),
            'tglmulai' => $this->input->post('tglmulai'),
            'tglselesai' => $this->input->post('tglselesai'),
            'durasi' => $this->input->post('durasi'),
            'level' => '2'
            ];
            $this->db->insert('wbs', $data);

            $this->db->set('total_aktivitas',$totalMailstone);
            $this->db->where($array);
            $this->db->update('wbs');
            redirect('project/wbs/' .$this->input->post('copro'));
                
        }   
    }

    public function ubahAkt()
    {
        date_default_timezone_set('asia/jakarta');
        $id = $this->input->post('id');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        $this->db->set('aktivitas', $this->input->post('aktivitas'));
        $this->db->set('tglmulai_wbs', $this->input->post('tglmulai'));
        $this->db->set('tglselesai_wbs', $this->input->post('tglselesai'));
        $this->db->set('durasi', $this->input->post('durasi'));
        $this->db->where($array);
        $this->db->update('wbs');

        redirect('project/wbs/' .$copro);
    }
    // public function hapusMailstone($id)
    // {
    //     $wbs = $this->db->get_where('wbs', ['id' => $id])->row_array();
    //     $copro = $wbs['copro'];
    //     $array = array('copro' => $copro, 'id' => $id);

    //     $this->db->set('wbs');
    //     $this->db->where($array);
    //     $this->db->delete('wbs');
    //     $this->session->set_flashdata('message', 'hapus');
    //     redirect('project/wbs/' .$wbs['copro']);    
    // }

    public function hapus()
    {
        $id = $this->input->post('id');
        $copro = $this->input->post('copro');
        $array = array('copro' => $copro, 'id' => $id);

        $this->db->set('wbs');
        $this->db->where($array);
        $this->db->delete('wbs');
        $this->session->set_flashdata('message', 'hapus');
        redirect('project/wbs/' .$copro);  
    }
    public function tambahproject()
    {
         $copro = $this->input->post('copro');
         $this->db->SELECT('nama');
         $this->db->where('inisial', $this->input->post('inisial'));
         $query1 = $this->db->get('customer');
         $nama = $query1->row()->nama;
         $data = [
            'copro' => $this->input->post('copro'),
            'customer_inisial' => $this->input->post('inisial'),
            'customer_nama' =>  $nama,
            'deskripsi' => $this->input->post('deskripsi'),
            'status' => $this->input->post('status'),
            'po_receive' => $this->input->post('po_receive'),
            'delivery_date' => $this->input->post('due_date'),
            'mh_budget' => $this->input->post('jam'),
            'cost_amount' => $this->input->post('cost'),
            'highlight' => $this->input->post('highlight')
            ];
        $this->db->insert('project', $data);
        
        redirect("projectbudget/budget/$copro");

    }

    // public function updateproject()
    // {
    //     $this->db->set('deskripsi', $this->input->post('deskripsi'));
    //     $this->db->set('po_receive', $this->input->post('po_date'));
    //     $this->db->set('delivery_date', $this->input->post('due_date'));
    //     $this->db->set('mh_budget', $this->input->post('mh_total'));
    //     $this->db->set('cost_amount', $this->input->post('amount'));
    //     $this->db->set('status', $this->input->post('status'));
    //     $this->db->set('highlight ', $this->input->post('highlight'));
    //     $this->db->where('copro', $this->input->post('copro'));
    //     $this->db->update('project');
    //     // echo $this->db->last_query();
    //     redirect("projectbudget/index");
    // }
}
