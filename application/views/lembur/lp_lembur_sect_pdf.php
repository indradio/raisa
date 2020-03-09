<?php

      $pdf = new FPDF('P','mm','A4');
      $pdf->SetMargins(5,10);
      $pdf->AddFont('arial-monospaced','','arial-monospaced.php');

      $pdf->AddPage();

      $pdf->Image('assets/img/WINTEQ1.jpg',10,5,30,0);
      $pdf->Image('assets/img/WINTEQ8.jpg',170,5,30,0);
      
      $pdf->Ln(-3);

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(185,15,'RENCANA / LAPORAN LEMBUR',0,1,'C');
      $pdf->line(75,16, 135-15, 16);

      $pdf->Ln(2);

      $pdf->setTextColor(0,0,0);
      $pdf->setFillColor(255,255,255);


      //Section
      // $nama1 = $this->db->get_where('karyawan_sect', ['id' => $sect_id])->row_array();
      // $nama1['nama']; 

      // $sect = $this->db->get_where('karyawan', ['sect_id' => $sect_id])->row_array();
      // $sect['nama'];
      // //Dept
      // $nama2 = $this->db->get_where('karyawan_dept', ['id' => $dept_id])->row_array();
      // $nama2['nama']; 

      // $dep = $this->db->get_where('karyawan', ['dept_id' => $dept_id])->row_array();
      // $dep['nama'];


      $pdf->SetFont('Arial','',6);
      $pdf->Cell(55,5,'Tanggal : '.date("d M Y", strtotime($this->input->post('tglawal'))).' - '.date("d M Y", strtotime($this->input->post('tglakhir'))),1,0,1);

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(72,10,'RENCANA LEMBUR',1,0,'C',1);
      $pdf->Cell(72,10,'LAPORAN LEMBUR',1,0,'C',1);
      $pdf->Cell(0,5,'',0,1,0);  

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(55,5,'SEKSI : '.$section. ' ('.$department.')',1,0,1);
      $pdf->SetFont('Arial','',5);
      $pdf->Cell(64,7,'',0,0,0);
      $pdf->Cell(75,7,'',0,0,0);
      $pdf->Cell(70,5,'',0,1,0);

      $pdf->SetFont('Arial','',6);
      $no = 1;

      $pdf->Cell(4,6,'No',1,0,'C',1);
      $pdf->Cell(14,6,'ID Lembur',1,0,'C',1);
      $pdf->Cell(30,6,'NAMA',1,0,'C',1);
      $pdf->Cell(7,6,'NPK',1,0,'C',1);
      $pdf->Cell(30,6,'TGL & JAM MULAI',1,0,'C',1);
      $pdf->Cell(30,6,'TGL & JAM SELESAI',1,0,'C',1);
      $pdf->Cell(12,6,'JML.JAM',1,0,'C',1);
      $pdf->Cell(30,6,'TGL & JAM MULAI',1,0,'C',1);
      $pdf->Cell(30,6,'TGL & JAM SELESAI',1,0,'C',1);
      $pdf->Cell(12,6,'JML.JAM',1,1,'C',1);

      foreach ($lembur as $l) :
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(4,5,$no++,1,0,'C',1);
      $pdf->Cell(14,5, $l['id'],1,0,'C',1);
      $pdf->Cell(30,5, $l['nama'],1,0,1);
      $pdf->Cell(7,5, $l['npk'],1,0,'C',1);
      $pdf->Cell(20,5, date('d-M-Y', strtotime($l['tglmulai_rencana'])),1,0,'C',1);
      $pdf->Cell(10,5, date('H:i', strtotime($l['tglmulai_rencana'])),1,0,'C',1);
      $pdf->Cell(20,5, date('d-M-Y', strtotime($l['tglselesai_rencana'])),1,0,'C',1);
      $pdf->Cell(10,5, date('H:i', strtotime($l['tglselesai_rencana'])),1,0,'C',1);
      $pdf->Cell(12,5, $l['durasi_rencana'],1,0,'C',0);
      $pdf->Cell(20,5, date('d-M-Y', strtotime($l['tglmulai'])),1,0,'C',1);
      $pdf->Cell(10,5, date('H:i', strtotime($l['tglmulai'])),1,0,'C',1);
      $pdf->Cell(20,5, date('d-M-Y', strtotime($l['tglselesai'])),1,0,'C',1);
      $pdf->Cell(10,5, date('H:i', strtotime($l['tglselesai'])),1,0,'C',1);
      $pdf->Cell(12,5, $l['durasi'],1,1,'C',0);

      endforeach;

      $pdf->Ln(6);
      $pdf->SetFont('Arial','',5);

      
      $pdf->Cell(127,5,'',0,0,'C',1);
      $pdf->Cell(36,5,'Kepala Seksi / RDA',1,0,'C',1);
      $pdf->Cell(36,5,'Kepala Departemen',1,1,'C',1);
      

      $pdf->Cell(127,5, '',0,0,'C',1);
      $pdf->Cell(36,20, '',1,0,'C',1);
      $pdf->Cell(36,20, '',1,1,'C',1);

      $pdf->Ln(-6);
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(127,5, '',0,0,'C',0);
      $pdf->Cell(36,5, ''.$secthead,0,0,'C',0);
      $pdf->Cell(36,5, ''.$depthead,0,0,'C',0);
      

      $pdf->Ln(-12);
      $pdf->SetFont('arial-monospaced', '', 6);
      $pdf->Cell(153, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(32, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

$pdf->Output('I','SURAT RENCANA / LAPORAN LEMBUR'.RAND().'.pdf');

      ?>