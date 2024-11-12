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

      // $pdf->Ln(-21.5);
      // $pdf->Cell(93, 5, date('d M Y H:i', strtotime($lembur['tglpengajuan_rencana'])), 0,'C', 0);
      // $pdf->Cell(78, 5, date('d M Y H:i', strtotime($lembur['tglpengajuan_realisasi'])), 0,'C', 0);

      $pdf->Ln(18);
      $pdf->SetFont('Arial','B',5);
      $no = 1;
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(200,5,'* AKTIVITAS LEMBUR *',0,1,'C',1);
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
          
//1->2********************************************************************************************************/
if($lembur['posisi_id']==7 and $lembur['tgl_atasan1_rencana']== null)
{
            $pdf->SetFont('Arial','',5);

            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(50,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(28,5,'DITERIMA',1,0,'C',1);
            
            $pdf->Cell(52,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(26,5,'DITERIMA',1,1,'C',1);
            //GA & HR
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(28,5, 'Section Head',1,0,'C',1);
            $pdf->Cell(28,5, 'Department Head',1,0,'C',1);
            if (!empty($lembur['admin_ga'])){$pdf->Cell(22,5, 'GA',1,0,'C',1);}
            $pdf->Cell(26,5, 'Section Head',1,0,'C',1);
            $pdf->Cell(26,5, 'Department Head',1,0,'C',1);
            $pdf->Cell(26,5, 'HR',1,1,'C',1);
            
            $pdf->SetFont('Arial','B',7);
            
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(50,25, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(28,25, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama4['nama'],1,0,'C',1);
      
            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 5);
            $pdf->Cell(47, 5, '', 0, 0);
            $pdf->Cell(45, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-45, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 0, 0, 'C');
            $pdf->Cell(128, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-128, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])), 110, 0, 'C');
            $pdf->Cell(175, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-175, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            $pdf->Cell(227, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-227, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])), 110, 0, 'C');
            $pdf->Cell(278, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-278, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 110, 0, 'C');
            $pdf->SetFont('Arial', '', 5);
      
            $pdf->Ln(7);
      
            $pdf->Ln(-22);
            $pdf->SetFont('arial-monospaced', '', 5);
            $pdf->Cell(75.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(35, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(23, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
}
//22********************************************************************************************************/
else if ($lembur['posisi_id']==7 OR $lembur['posisi_id']==10)
{
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
      if (!empty($lembur['admin_ga'])){$pdf->Cell(26,5, 'GA',1,0,'C',1);}
      $pdf->Cell(28,5, 'Section Head',1,0,'C',1);
      $pdf->Cell(28,5, 'Department Head',1,0,'C',1);
      $pdf->Cell(26,5, 'HR',1,1,'C',1);
      
      $pdf->SetFont('Arial','B',7);
      
      // $pdf->Ln(7);
      $pdf->Cell(35,5,'',0,0,'C',1);
      $pdf->Cell(28,25, $nama1['nama'],1,0,'C',1);
      $pdf->Cell(28,25, $nama2['nama'],1,0,'C',1);
      if (!empty($lembur['admin_ga'])){$pdf->Cell(26,25, $nama3['nama'],1,0,'C',1);}
      $pdf->Cell(28,25, $nama1['nama'],1,0,'C',1);
      $pdf->Cell(28,25, $nama2['nama'],1,0,'C',1);
      $pdf->Cell(26,25, $nama4['nama'],1,0,'C',1);
      
      $pdf->Ln(0);
      $pdf->SetFont('arial-monospaced', '', 5);

      $pdf->Cell(56.5, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(25, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      if (!empty($lembur['admin_ga'])){
      $pdf->Cell(25, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
      $pdf->Cell(23, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      }else{
      $pdf->Cell(25, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      }

      $pdf->Cell(25, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Cell(25, 5, 'form digital', 0,'C', 0);
      $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
      $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

      $pdf->Ln(15);
      $pdf->SetFont('Arial', 'B', 5);
      $pdf->Cell(54, 5, 'Disetujui', 0,'C', 0);
      $pdf->Cell(5.5, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])), 0,'C', 0);

      $pdf->Cell(22, 5, 'Disetujui', 0,'C', 0);
      $pdf->Cell(5.5, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 0,'C', 0);

      if (!empty($lembur['admin_ga'])){
      $pdf->Cell(22, 5, 'Disetujui', 0,'C', 0);
      $pdf->Cell(5.5, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])), 0,'C', 0);
      }
      
      $pdf->Cell(22, 5, 'Disetujui', 0,'C', 0);
      $pdf->Cell(5.5, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 0,'C', 0);

      $pdf->Cell(22, 5, 'Disetujui', 0,'C', 0);
      $pdf->Cell(5.5, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])), 0,'C', 0);

      $pdf->Cell(22, 5, 'Disetujui', 0,'C', 0);
      $pdf->Cell(5.5, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 0,'C', 0);
}
//22 SECT.HEAD********************************************************************************************************/
else if ( $lembur['posisi_id'] == 5 OR $lembur['posisi_id']== 6 OR $lembur['posisi_id']== 9)
{
      $pdf->SetFont('Arial','',5);

            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,5,'DISETUJUI',1,0,'C',1);
            if (!empty($lembur['admin_ga'])){$pdf->Cell(30,5,'DITERIMA',1,0,'C',1);}
            
            $pdf->Cell(48,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(30,5,'DITERIMA',1,1,'C',1);
            //GA & HR
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,5, 'Department Head',1,0,'C',1);
            if (!empty($lembur['admin_ga'])){$pdf->Cell(30,5, 'GA',1,0,'C',1);}

            $pdf->Cell(48,5, 'Department Head',1,0,'C',1);
            $pdf->Cell(30,5, 'HR',1,1,'C',1);
            
            $pdf->SetFont('Arial','B',7);
            
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,25, $nama1['nama'],1,0,'C',1);
            
            if (!empty($lembur['admin_ga'])){$pdf->Cell(30,25, $nama3['nama'],1,0,'C',1);}
            $pdf->Cell(48,25, $nama1['nama'],1,0,'C',1);
           
            $pdf->Cell(30,25, $nama4['nama'],1,0,'C',1);

            $pdf->Ln(0);
            $pdf->SetFont('arial-monospaced', '', 5);
            $pdf->Cell(75.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            if (!empty($lembur['admin_ga'])){
            $pdf->Cell(36, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
            
            $pdf->Cell(36, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(36, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
            }else{
            $pdf->Cell(45, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(36, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(2, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
            }

            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 5);
            $pdf->Cell(56, 5, '', 0, 0);
            $pdf->Cell(23, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])),0, 0, 'C');
            if (!empty($lembur['admin_ga'])){
                  $pdf->Cell(105, 5, 'Disetujui',0, 0, 'C');
                  $pdf->Cell(-105, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])), 110, 0, 'C');
                  $pdf->Cell(180, 5, 'Disetujui',0, 0, 'C');
                  $pdf->Cell(-180, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
                  $pdf->Cell(260, 5, 'Disetujui',0, 0, 'C');
                  $pdf->Cell(-260, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 110, 0, 'C');
            }else{
                  $pdf->Cell(120, 5, 'Disetujui',0, 0, 'C');
                  $pdf->Cell(-120, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
                  $pdf->Cell(198, 5, 'Disetujui',0, 0, 'C');
                  $pdf->Cell(-198, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 110, 0, 'C');
            }
 }

$pdf->Output('I','FORM LAPORAN LEMBUR '.$lembur['id'].'.pdf');
     
?>
