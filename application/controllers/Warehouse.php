<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';
//load Spout Library
require_once APPPATH.'third_party/spout/src/Spout/Autoloader/autoload.php';
 
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Warehouse extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {

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

    public function parts()
    {

            $data['sidemenu'] = 'Warehouse';
            $data['sidesubmenu'] = 'Komponen';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
                    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('warehouse/parts', $data);
            $this->load->view('templates/footer');

    }

    public function stock($access=null)
    {

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
        }elseif ($params=="parts"){
            $parts = $this->db->get_where('wh_parts')->result();
            if (!empty($parts)){
                foreach ($parts as $row) {

                    $output['data'][] = array(
                        "id" => $row->id,
                        "description" => $row->part_description,
                        "loc" => $row->location,
                        "stock" => $row->stock,
                        "unit" => $row->unit,
                        "price" => $row->price,
                        "action" => "<button type='button' class='btn btn-success btn-link btn-just-icon' data-toggle='modal' data-target='#opname' data-id='".$row->id."'><i class='material-icons'>add_a_photo</i></button>"
                    );
                }

            }else{
                $output['data'][] = array(
                    "id" => '',
                    "description" => 'There are no data to display.',
                    "loc" => '',
                    "stock" => '',
                    "unit" => '',
                    "price" => '',
                    "action" => ''
                );
            }
 
            echo json_encode($output);
            exit();
        }
    }

    public function admin_parts()
    {

            $data['sidemenu'] = 'Warehouse';
            $data['sidesubmenu'] = 'Komponen';
            $data['karyawan'] = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();

            $parts = $this->db->get('wh_parts');
            $data['total_part'] = $parts->num_rows();
                    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('warehouse/admin/parts', $data);
            $this->load->view('templates/footer');

    }

    public function admin_parts_upload()
    {

        //  ketika button submit diklik
        //  if ($this->input->post('submit', TRUE) == 'upload') {
            $config['upload_path']      = './assets/temp_excel/'; //siapkan path untuk upload file
            $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
            $config['file_name']        = 'import_' . time(); //rename file yang diupload

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('data')) {
                $this->load->helper('string');

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
                                'id'                => $cells[0],
                                'part_description'  => $cells[1],
                                'location'          => $cells[2],
                                'stock'             => $cells[3],
                                'unit'              => $cells[4],
                                'price'             => $cells[5],
                                'last_updated'      => date('Y-m-d'),
                                'status'            => 'AVAILABLE'
                            );

                                //simpan data ke database
                                $this->db->insert('wh_parts', $data);
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
            redirect('warehouse/admin_parts');

    }

}
