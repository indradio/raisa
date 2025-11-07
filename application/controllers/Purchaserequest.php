<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Guzzle Library
require_once APPPATH.'third_party/guzzle/autoload.php';
require_once APPPATH.'third_party/spout/src/Spout/Autoloader/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
 
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Purchaserequest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Zmpu_model', 'zmpu');
    }

    public function index()
    {
        $data['sidemenu'] = 'Info PCH';
        $data['sidesubmenu'] = 'PR Update';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $counts = $this->db
        ->select('pr_release, COUNT(*) as total')
        ->group_by('pr_release')
        ->get('zmpu')
        ->result();

        $data['counts'] = [];

        foreach ($counts as $row) {
            $key = $row->pr_release ?? 'null'; // jika null, simpan sebagai 'null' string
            $data['counts'][$key] = $row->total;
        }

        $query = $this->db->query("
            SELECT 
                CASE 
                    WHEN pr_no IS NULL AND gr_doc IS NULL THEN 'CREATE_PO'
                    WHEN pr_no IS NOT NULL AND gr_doc IS NULL THEN 'PO_RELEASE'
                    WHEN pr_no IS NOT NULL AND gr_doc IS NOT NULL THEN 'ARRIVED'
                END AS kategori,
                COUNT(*) AS total
            FROM zmpu
            WHERE pr_release IS NOT NULL
            GROUP BY 
                CASE 
                    WHEN pr_no IS NULL AND gr_doc IS NULL THEN 'CREATE_PO'
                    WHEN pr_no IS NOT NULL AND gr_doc IS NULL THEN 'PO_RELEASE'
                    WHEN pr_no IS NOT NULL AND gr_doc IS NOT NULL THEN 'ARRIVED'
            END
        ");

        $rows = $query->result();

        $data['counts_po'] = [
            'CREATE_PO'   => 0,
            'PO_RELEASE' => 0,
            'ARRIVED'  => 0
        ];

        foreach ($rows as $row) {
            $data['counts_po'][$row->kategori] = (int) $row->total;
        }


        $data['last'] = date("d M Y H:i:s", strtotime($this->db->select('created_at')->get('zmpu')->row('created_at')));
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pr/index', $data);
        $this->load->view('templates/footer');
    }

    public function zmpu()
    {
        $data['sidemenu'] = 'Purchase Request';
        $data['sidesubmenu'] = '';
        $data['karyawan'] = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pr/index', $data);
        $this->load->view('templates/footer');
    }

    public function getDataZmpu()
    {
        $query = $this->zmpu->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($query as $zmpu) {

            if ($zmpu->pr_release == 'XXXXX') {
                if (empty($zmpu->gr_doc) && empty($zmpu->po_no)) {
                    $status = '<a href="#" class="btn btn-sm btn-linkedin" style="pointer-events: none; cursor: default;">CREATE PO</a>';
                } elseif (empty($zmpu->godoc) && !empty($zmpu->po_no)) {
                    $status = '<a href="#" class="btn btn-sm btn-twitter" style="pointer-events: none; cursor: default;">PO RELEASE</a>';
                } else {
                    $status = '<a href="#" class="btn btn-sm btn-success" style="pointer-events: none; cursor: default;">ARRIVED</a>';
                }
            } elseif ($zmpu->pr_release == 'XXXX') {
                $status = '<a href="#" class="btn btn-sm btn-twitter" style="pointer-events: none; cursor: default;">PR RELEASE</a>';
            } elseif ($zmpu->pr_release == 'XXX') {
                $status = '<a href="#" class="btn btn-sm btn-warning" style="pointer-events: none; cursor: default;">APPROVAL PR PCH</a>';
            } elseif ($zmpu->pr_release == 'XX' ) {
                $status = '<a href="#" class="btn btn-sm btn-dribbble" style="pointer-events: none; cursor: default;">BUYER</a>';
            } elseif ($zmpu->pr_release == 'X') {
                $status = '<a href="#" class="btn btn-sm btn-youtube" style="pointer-events: none; cursor: default;">ADMIN PCH</a>';
            } else {
                $status = '<a href="#" class="btn btn-sm btn-warning" style="pointer-events: none; cursor: default;">APPROVAL DEPT. USER</a>';
            }
            

            $row = array();
            $row[] = $zmpu->pr_no;
            $row[] = date("d.m.Y", strtotime($zmpu->pr_date));
            if($zmpu->po_no){
                $row[] = $zmpu->po_no;
                $row[] = date("d.m.Y", strtotime($zmpu->po_date));
            }else{
                $row[] = '';
                $row[] = '';
            }
            $row[] = $zmpu->pr_desc;
            $row[] = $zmpu->pr_qty;
            $row[] = $zmpu->pr_uom;
            $row[] = $zmpu->copro;
            $row[] = $zmpu->requestor;
            $row[] = $zmpu->pic_pch;
            $row[] = $status;
          
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->zmpu->count_all(),
            "recordsFiltered" => $this->zmpu->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ImportData()
    {
        //  Delete semua data
        $this->db->truncate('zmpu');

        //  if ($this->input->post('submit', TRUE) == 'upload') {
        $config['upload_path']      = './assets/temp_excel/'; //siapkan path untuk upload file
        $config['allowed_types']    = 'xlsx|csv'; //siapkan format file
        $config['file_name']        = 'import_' . time(); //rename file yang diupload

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('zmpu')) {
            //fetch data upload
            $file   = $this->upload->data();

            // Pilih reader berdasarkan ekstensi
            $extension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
            if ($extension === 'xlsx') {
                $reader = \Box\Spout\Reader\Common\Creator\ReaderEntityFactory::createXLSXReader();
            } elseif ($extension === 'csv') {
                $reader = \Box\Spout\Reader\Common\Creator\ReaderEntityFactory::createCSVReader();
            } else {
                exit('❌ Format file tidak dikenali.');
            }
            $reader->open('./assets/temp_excel/' . $file['file_name']); //open file xlsx yang baru saja diunggah

            //looping pembacaat sheet dalam file        
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;

                //siapkan variabel array kosong untuk menampung variabel array data
                $save   = array();

                function getCellValue($cell, $format = 'Y-m-d') {
                    $value = $cell->getValue();
                
                    if ($value instanceof \DateTime) {
                        return $value->format($format); // Format tanggal jadi string
                    }
                
                    return trim((string)$value) === '' ? null : $value; // Ubah kosong jadi null
                }

                //looping pembacaan row dalam sheet
                foreach ($sheet->getRowIterator() as $row) {

                    if ($numRow > 1) {
                        //ambil cell
                        $cells = $row->getCells();
         
                        $this->load->helper('string');

                        $data = array(
                            'id'            => random_string('alnum', 16),
                            'copro'         => getCellValue($cells[0]),
                            'requestor'     => getCellValue($cells[1]),
                            'pic_pch'       => getCellValue($cells[2]),
                            'pr_date'       => getCellValue($cells[3], 'Y-m-d'),
                            'pr_no'         => getCellValue($cells[4]),
                            'pr_desc'       => getCellValue($cells[5]),
                            'pr_qty'        => getCellValue($cells[6]),
                            'pr_uom'        => getCellValue($cells[7]),
                            'pr_release'    => getCellValue($cells[8]),
                            'po_date'       => isset($cells[9]) ? getCellValue($cells[9], 'Y-m-d') : null,
                            'po_no'         => isset($cells[10]) ? getCellValue($cells[10]) : null,
                            'vendor_name'   => isset($cells[11]) ? getCellValue($cells[11]) : null,
                            'est_delivery'  => isset($cells[12]) ? getCellValue($cells[12], 'Y-m-d') : null,
                            'gr_block'      => isset($cells[13]) ? getCellValue($cells[13]) : null,
                            'qc_date'       => isset($cells[14]) ? getCellValue($cells[14], 'Y-m-d') : null,
                            'gr_doc'        => isset($cells[15]) ? getCellValue($cells[15]) : null,
                            'act_delivery'  => isset($cells[16]) ? getCellValue($cells[16], 'Y-m-d') : null,
                            'gr_qty'        => isset($cells[17]) ? getCellValue($cells[17]) : null,
                            'gr_uom'        => isset($cells[18]) ? getCellValue($cells[18]) : null,
                        );
                        

                        //tambahkan array $data ke $save
                        // array_push($save, $data);

                        //simpan data ke database
                        $this->db->insert('zmpu', $data);
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

        redirect('purchase-request');

    }


}
