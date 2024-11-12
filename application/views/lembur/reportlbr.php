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
      $pdf->Cell(198,15,'RENCANA / LAPORAN LEMBUR',0,1,'C');
      $pdf->line(81,16, 142-15, 16);

      $pdf->Ln(-5);

      $pdf->setTextColor(0,0,0);
      $pdf->setFillColor(255,255,255);

      $dep = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
      $d = $this->db->get_where('karyawan_dept', ['id' =>  $lembur['dept_id']])->row_array();

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(10, 5, 'NO : ' . $lembur['id'], 0, 1);
      
      $pdf->Cell(44,5,'HARI / TGL              :   '. date('d-m-Y', strtotime($lembur['tglmulai'])),1,0,1);
      $pdf->SetFont('Arial','',6);
      $pdf->Cell(78,10,'RENCANA LEMBUR',1,0,'C',1);
      $pdf->Cell(78,10,'LAPORAN LEMBUR',1,0,'C',1);
      $pdf->Cell(0,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,5,'DEPARTEMENT     :   ' . $d['inisial'],1,0,1);
      $pdf->SetFont('Arial','',5);
      $pdf->Cell(64,7,'',0,0,0);
      $pdf->Cell(75,7,'',0,0,0);
      $pdf->Cell(70,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,7,'NAMA                      :   ' . $lembur['nama'],1,0,1);
      $pdf->SetFont('Arial','',5);

      $pdf->Cell(32,7,'MULAI',1,0,'C',1);
      $pdf->Cell(32,7,'SELESAI',1,0,'C',1);
      $pdf->Cell(14,7,'JML.JAM',1,0,'C',1);
      $pdf->Cell(32,7,'MULAI',1,0,'C',1);
      $pdf->Cell(32,7,'SELESAI',1,0,'C',1);
      $pdf->Cell(14,7,'JML.JAM',1,0,'C',1);
      $pdf->Cell(70,7,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,5,'NPK                         :   ' . $lembur['npk'],1,0,1);
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglmulai_rencana'])),1,0,'C',1);
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglselesai_rencana'])),1,0,'C',1);
      $pdf->Cell(14,5, $lembur['durasi_rencana'].' JAM',1,0,'C',0);
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglmulai'])),1,0,'C',1);
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglselesai'])),1,0,'C',1);
      $pdf->Cell(14,5, $lembur['durasi'].' JAM',1,1,'C',0);
      $pdf->Cell(56,5,'',0,1,0);

      // $pdf->Ln(1);
      // $pdf->Cell(93, 5, 'Tanggal Pengajuan Rencana : '.date('d M Y H:i', strtotime($lembur['tglpengajuan_rencana'])), 0,'C', 0);
      // $pdf->Cell(78, 5, 'Tanggal Pengajuan Realisasi : '.date('d M Y H:i', strtotime($lembur['tglpengajuan_realisasi'])), 0,'C', 0);

      $pdf->Ln(4);
      $pdf->SetFont('Arial','B',5);
      $no = 1;
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(200,-5,'* AKTIVITAS LEMBUR *',0,1,'C',1);
      $pdf->line(92,55, 133-15, 55);

      $pdf->Ln(5);
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
      
      $nama1 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1']])->row_array();
      $n1 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama1['posisi_id']])->row_array();
      $nama1['nama']; 

      $nama2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2']])->row_array();
      $n2 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama2['posisi_id']])->row_array();
      $nama2['nama'];

      if (!empty($lembur['admin_ga'])){
            $nama3 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_ga']])->row_array();
            $n3 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama3['posisi_id']])->row_array();
            $nama3['nama']; 
      }else{
            $nama3['nama'] = 'TIDAK ADA';
      }

      $nama4 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_hr']])->row_array();
      $n4 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama4['posisi_id']])->row_array();
      $nama4['nama']; 
      
      $pdf->Cell(200,5,'',0,1,'C',1);
      $pdf->SetFont('Arial','',5);
          

      $pdf->SetFont('Arial','',5);

      $pdf->Cell(35,5,'',0,0,'C',1);
      $pdf->Cell(56,5,'DISETUJUI',1,0,'C',1);
      if (!empty($lembur['admin_ga'])){$pdf->Cell(26,5,'DITERIMA',1,0,'C',1);}
      
      $pdf->Cell(56,5,'DISETUJUI',1,0,'C',1);
      $pdf->Cell(26,5,'DITERIMA',1,1,'C',1);
      //GA & HR
      $pdf->Cell(35,5,'',0,0,'C',1);
      $pdf->Cell(28,5, 'Section Head',1,0,'C',1);
      $pdf->Cell(28,5, 'Department Head',1,0,'C',1);
      // if (!empty($lembur['admin_ga'])){$pdf->Cell(26,5, 'GA',1,0,'C',1);}
      $pdf->Cell(28,5, 'Section Head',1,0,'C',1);
      $pdf->Cell(28,5, 'Department Head',1,0,'C',1);
      $pdf->Cell(26,5, 'HR',1,1,'C',1);
      
      $pdf->SetFont('Arial','B',7);
      
      // $pdf->Ln(7);
      $pdf->Cell(35,5,'',0,0,'C',1);
      $pdf->Cell(28,25, $nama1['nama'],1,0,'C',1);
      $pdf->Cell(28,25, $nama2['nama'],1,0,'C',1);
      // if (!empty($lembur['admin_ga'])){$pdf->Cell(26,25, $nama3['nama'],1,0,'C',1);}
      $pdf->Cell(28,25, $nama1['nama'],1,0,'C',1);
      $pdf->Cell(28,25, $nama2['nama'],1,0,'C',1);
      $pdf->Cell(26,25, $nama4['nama'],1,0,'C',1);
      
      $pdf->Ln(0);
      $pdf->SetFont('arial-monospaced', '', 5);
      
      $pdf->Cell(97, 5, 'form digital',0, 0,'C', 0);
      $pdf->Cell(-97, 10, 'Tidak memerlukan',0, 0,'C', 0);
      $pdf->Cell(97, 15, 'tanda tangan basah',0, 0,'C', 0);
      $pdf->Cell(-97, 35, 'Disetujui',0, 0,'C', 0);
      $pdf->Cell(97, 40, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])),0, 0,'C', 0);

      
      $pdf->Ln(0);
      $pdf->Cell(155, 5, 'form digital',0, 0,'C', 0);
      $pdf->Cell(-155, 10, 'Tidak memerlukan',0, 0,'C', 0);
      $pdf->Cell(155, 15, 'tanda tangan basah',0, 0,'C', 0);
      $pdf->Cell(-155, 35, 'Disetujui',0, 0,'C', 0);
      $pdf->Cell(155, 40, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])),0, 0,'C', 0);
      
      // if (!empty($lembur['admin_ga'])){
      //       $pdf->Ln(0);
      //       $pdf->Cell(25, 5, 'form digital', 0,'C', 0);
      //       $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      //       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
            
      //       $pdf->Cell(23, 5, 'form digital', 0,'C', 0);
      //       $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      //       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      // }
      
      $pdf->Ln(0);
      $pdf->Cell(210, 5, 'form digital',0, 0,'C', 0);
      $pdf->Cell(-210, 10, 'Tidak memerlukan',0, 0,'C', 0);
      $pdf->Cell(210, 15, 'tanda tangan basah',0, 0,'C', 0);
      $pdf->Cell(-210, 35, 'Disetujui',0, 0,'C', 0);
      $pdf->Cell(210, 40, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])),0, 0,'C', 0);

      $pdf->Ln(0);
      $pdf->Cell(265, 5, 'form digital',0, 0,'C', 0);
      $pdf->Cell(-265, 10, 'Tidak memerlukan',0, 0,'C', 0);
      $pdf->Cell(265, 15, 'tanda tangan basah',0, 0,'C', 0);
      $pdf->Cell(-265, 35, 'Disetujui',0, 0,'C', 0);
      $pdf->Cell(265, 40, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])),0, 0,'C', 0);

      $pdf->Ln(0);
      $pdf->Cell(320, 5, 'form digital',0, 0,'C', 0);
      $pdf->Cell(-320, 10, 'Tidak memerlukan',0, 0,'C', 0);
      $pdf->Cell(320, 15, 'tanda tangan basah',0, 0,'C', 0);
      $pdf->Cell(-320, 35, 'Disetujui',0, 0,'C', 0);
      $pdf->Cell(320, 40, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])),0, 0,'C', 0);

$pdf->Output('I','FORM LAPORAN LEMBUR '.$lembur['id'].'.pdf');
     
?>
