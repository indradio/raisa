<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
//load Spout Library
require_once APPPATH.'third_party/Spout/Autoloader/autoload.php';
 
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
 
class Import extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('app');
    }
 
    public function index()
    {
        //ketika button submit diklik
        if ($this->input->post('submit', TRUE) == 'upload')
        {
            $config['upload_path']      = './temp_doc/'; //siapkan path untuk upload file
            $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
            $config['file_name']        = 'doc'.time(); //rename file yang diupload
       
            $this->load->library('upload', $config);
       
            if ($this->upload->do_upload('excel'))
            {
                //fetch data upload
                $file   = $this->upload->data();
       
                $reader = ReaderFactory::create(Type::XLSX); //set Type file xlsx
                $reader->open('temp_doc/'.$file['file_name']); //open file xlsx
 
                //looping pembacaat sheet dalam file        
                foreach ($reader->getSheetIterator() as $sheet)
                {
                    $numRow = 1;
 
                    //siapkan variabel array kosong untuk menampung variabel array data
                    $save   = array();
 
                    //looping pembacaan row dalam sheet
                    foreach ($sheet->getRowIterator() as $row)
                    {
                        if ($numRow > 1)
                        {
                            $data = array(
                                'nopol' => $row[0],
                                'start_time' => $row[1],
                                'end_time' => $row[2],
                                'distance' => $row[3],
                                'duration' => $row[4],
                                'departed_from' => $row[5],
                                'arrived_at' => $row[6]
                            );
 
                            //tambahkan array $data ke $save
                            array_push($save, $data);
                        }
                       
                        $numRow++;
                    }
                    //simpan data ke database
                    $this->app->simpan($save);
 
                    //tutup spout reader
                    $reader->close();
 
                    //hapus file yang sudah diupload
                    unlink('temp_doc/'.$file['file_name']);
 
                    //tampilkan pesan success dan redirect ulang ke index controller import
                    echo    '<script type="text/javascript">
                               alert(\'Data berhasil disimpan\');
                               window.location.replace("'.base_url().'");
                           </script>';
                }
            }
            else
            {
                echo "Error :".$this->upload->display_errors(); //tampilkan pesan error jika file gagal diupload
            }
        }
 
        $this->load->view('import');
    }
 
}