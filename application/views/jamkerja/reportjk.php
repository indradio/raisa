<?php

      $pdf = new FPDF('P','mm','A4');
      $pdf->SetMargins(5,10,5,5);
      $pdf->AddFont('arial-monospaced','','arial-monospaced.php');

      $pdf->AddPage();

      $pdf->Image('assets/img/WINTEQ1.jpg',10,5,30,0);
      $pdf->Image('assets/img/WINTEQ8.jpg',170,5,30,0);
      
      $pdf->Ln(-3);
      
      $user = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(198,15,'LAPORAN JAM KERJA HARIAN',0,1,'C');
      $pdf->line(81,16, 142-15, 16);

      $pdf->Ln(-5);

      $pdf->setTextColor(0,0,0);
      $pdf->setFillColor(255,255,255);

      $dep = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
      $d = $this->db->get_where('karyawan_dept', ['id' =>  $jamkerja['dept_id']])->row_array();

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(10, 5, 'NO : ' . $jamkerja['id'], 0, 1);
      
      $pdf->Cell(44,5,'HARI / TGL              :   '. date('d-m-Y', strtotime($jamkerja['tglmulai'])),1,0,1);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(156,10,'PORSI KE COPRO ' . $jamkerja['produktifitas'].'%',1,0,'C',1);
      // $pdf->Cell(78,10,'LAPORAN LEMBUR',1,0,'C',1);
      $pdf->Cell(0,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,5,'DEPARTEMENT     :   ' . $d['inisial'],1,0,1);
      $pdf->SetFont('Arial','',5);
      $pdf->Cell(64,7,'',0,0,0);
      $pdf->Cell(75,7,'',0,0,0);
      $pdf->Cell(70,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,7,'NAMA                      :   ' . $jamkerja['nama'],1,0,1);
      $pdf->SetFont('Arial','',5);

      $pdf->Cell(53,7,'MULAI',1,0,'C',1);
      $pdf->Cell(53,7,'SELESAI',1,0,'C',1);
      $pdf->Cell(25,7,'JML.JAM',1,0,'C',1);
      $pdf->Cell(25,7,'SHIFT',1,0,'C',1);
      $pdf->Cell(70,7,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,5,'NPK                         :   ' . $jamkerja['npk'],1,0,1);
      $pdf->Cell(53,5, date('H:i', strtotime($jamkerja['tglmulai'])),1,0,'C',1);
      $pdf->Cell(53,5, date('H:i', strtotime($jamkerja['tglselesai'])),1,0,'C',1);
      $pdf->Cell(25,5, $jamkerja['durasi'].' JAM',1,0,'C',0);
      $pdf->Cell(25,5, $jamkerja['shift'],1,0,'C',1);
      $pdf->Cell(56,5,'',0,1,0);

      $pdf->Ln(-16);
      // $pdf->Cell(93, 5, date('d M Y H:i', strtotime($jamkerja['tglpengajuan_rencana'])), 0,'C', 0);
      // $pdf->Cell(78, 5, date('d M Y H:i', strtotime($jamkerja['tglpengajuan_realisasi'])), 0,'C', 0);

      $pdf->Ln(18);
      $pdf->SetFont('Arial','B',5);
      $no = 1;
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(200,5,'* AKTIVITAS *',0,1,'C',1);
      $pdf->line(92,50, 133-15, 50);

      $pdf->Ln(1);
      foreach ($aktivitas as $a) :
            $k = $this->db->get_where('jamkerja_kategori', ['id' =>  $a['kategori']])->row_array();     

      $pdf->Ln(4);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(1,4, $no++.'.',0,0,'C',0);
      $pdf->Cell(5,4,'',0,0,'C',0);
      
      $pdf->SetFont('Arial','',7);
      $pdf->Cell(10,5,'Kategori',0,0,'L',0);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(38,4,':',0,1,'C',0);

      $pdf->Ln(-4);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(43,4,'',0,0,'C',0);
      $pdf->MultiCell(156,4,  $k['nama'].'  ('.$a['copro'].')',0,'L');  //aktivitas

      $pdf->Ln(1);
      $pdf->SetFont('Arial','',7);
      $pdf->Cell(6,4,'',0,0,'C',0);
      $pdf->Cell(10,5,'Aktivitas',0,0,'L',0);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(38,4,':',0,1,'C',0);

      $pdf->Ln(-4);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(43,4,'',0,0,'C',0);
      $pdf->MultiCell(156,4, $a['aktivitas'] ,0,'L');  //Realisasi
      
      $pdf->Ln(1);
      $pdf->SetFont('Arial','',7);
      $pdf->Cell(6,4,'',0,0,'C',0);
      $pdf->Cell(10,5,'Deskripsi',0,0,'L',0);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(38,4,':',0,1,'C',0);

      $pdf->Ln(-4);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(43,4,'',0,0,'C',0);
      $pdf->MultiCell(156,4, $a['deskripsi_hasil'] ,0,'L');  //Realisasi

      $pdf->Ln(1);
      $pdf->SetFont('Arial','',7);
      $pdf->Cell(6,4,'',0,0,'C',0);
      $pdf->Cell(10,5,'Durasi & Hasil',0,0,'L',0);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(38,4,':',0,1,'C',0);

      $pdf->Ln(-4);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(43,4,'',0,0,'C',0);
      $pdf->MultiCell(156,4, $a['durasi'].' JAM  ('.$a['progres_hasil'].'%)' ,0,'L');  //Realisasi

      endforeach;
      
      $atasan1 = $this->db->get_where('karyawan', ['inisial' => $jamkerja['atasan1']])->row_array();
      // $n1 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama1['posisi_id']])->row_array();
      $atasan1['nama']; 
      
      $ppic = $this->db->get_where('karyawan', ['inisial' => $jamkerja['ppic']])->row_array();
      // $n1 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama1['posisi_id']])->row_array();
      $ppic['nama']; 

      // $nama2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2']])->row_array();
      // $n2 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama2['posisi_id']])->row_array();
      // $nama2['nama'];

      // if (!empty($lembur['admin_ga'])){
      //       $nama3 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_ga']])->row_array();
      //       $n3 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama3['posisi_id']])->row_array();
      //       $nama3['nama']; 
      // }else{
      //       $nama3['nama'] = 'TIDAK ADA';
      // }

      // $nama4 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_hr']])->row_array();
      // $n4 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama4['posisi_id']])->row_array();
      // $nama4['nama']; 
      
      $pdf->Cell(200,5,'',0,1,'C',1);
      $pdf->SetFont('Arial','',5);
          
//1->2********************************************************************************************************/
if($jamkerja['posisi_id']=='7')
{
            $pdf->SetFont('Arial','',5);

            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(50,5,'DIBUAT',1,0,'C',1);
            $pdf->Cell(50,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(50,5,'DITERIMA',1,1,'C',1);
            //GA & HR
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(50,5, 'Karyawan',1,0,'C',1);
            $pdf->Cell(50,5, 'Koordinator / RDA',1,0,'C',1);
            $pdf->Cell(50,5, 'PPIC',1,1,'C',1);
            
            $pdf->SetFont('Arial','B',7);
            
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(50,25, $jamkerja['nama'],1,0,'C',1);
            $pdf->Cell(50,25, $atasan1['nama'],1,0,'C',1);
            $pdf->Cell(50,25, $ppic['nama'],1,0,'C',1);
      
            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 5);
            $pdf->Cell(47, 5, '', 0, 0);
            $pdf->Cell(43, 5, 'Dibuat',0, 0, 'C');
            $pdf->Cell(-43, 10, 'pada ' . date('d/m/Y H:i', strtotime($jamkerja['create'])), 0, 0, 'C');
            $pdf->Cell(145, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-145, 10, 'pada ' . date('d/m/Y H:i', strtotime($jamkerja['tgl_atasan1'])), 110, 0, 'C');
            $pdf->Cell(245, 5, 'Diterima',0, 0, 'C');
            $pdf->Cell(-245, 10, 'pada ' . date('d/m/Y H:i', strtotime($jamkerja['tgl_ppic'])), 110, 0, 'C');
            $pdf->SetFont('Arial', '', 5);
      
            $pdf->Ln(7);
      
            $pdf->Ln(-22);
            $pdf->SetFont('arial-monospaced', '', 5);
            $pdf->Cell(75.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(47, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(46, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
}
// //2->2********************************************************************************************************/
else if ($jamkerja['posisi_id']== '6')
{
      $pdf->SetFont('Arial','',5);

      $pdf->Cell(44,5,'',0,0,'C',1);
      $pdf->Cell(50,5,'DIBUAT',1,0,'C',1);
      // $pdf->Cell(50,5,'DISETUJUI',1,0,'C',1);
      $pdf->Cell(50,5,'DITERIMA',1,1,'C',1);
      //GA & HR
      $pdf->Cell(44,5,'',0,0,'C',1);
      $pdf->Cell(50,5, 'Karyawan',1,0,'C',1);
      // $pdf->Cell(50,5, 'Koordinator / RDA',1,0,'C',1);
      $pdf->Cell(50,5, 'PPIC',1,1,'C',1);
      
      $pdf->SetFont('Arial','B',7);
      
      $pdf->Cell(44,5,'',0,0,'C',1);
      $pdf->Cell(50,25, $jamkerja['nama'],1,0,'C',1);
      // $pdf->Cell(50,25, $atasan1['nama'],1,0,'C',1);
      $pdf->Cell(50,25, $ppic['nama'],1,0,'C',1);

      $pdf->Ln(15);
      $pdf->SetFont('Arial', 'B', 5);
      $pdf->Cell(47, 5, '', 0, 0);
      $pdf->Cell(43, 5, 'Dibuat',0, 0, 'C');
      $pdf->Cell(-43, 10, 'pada ' . date('d/m/Y H:i', strtotime($jamkerja['create'])), 0, 0, 'C');
      $pdf->Cell(145, 5, 'Diterima',0, 0, 'C');
      $pdf->Cell(-145, 10, 'pada ' . date('d/m/Y H:i', strtotime($jamkerja['tgl_ppic'])), 110, 0, 'C');
      // $pdf->Cell(245, 5, 'Diterima',0, 0, 'C');
      // $pdf->Cell(-245, 10, 'pada ' . date('d/m/Y H:i', strtotime($jamkerja['tgl_ppic'])), 110, 0, 'C');
      $pdf->SetFont('Arial', '', 5);

      $pdf->Ln(7);

      $pdf->Ln(-22);
      $pdf->SetFont('arial-monospaced', '', 5);
      $pdf->Cell(75.5, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      // $pdf->Cell(47, 5, 'form digital', 0,'C', 0);
      // $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      // $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(46, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
}

$pdf->Output('I','FORM LAPORAN JAM KERJA '.$jamkerja['id'].'.pdf');
     
?>
