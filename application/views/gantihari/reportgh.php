<?php

      $pdf = new FPDF('P','mm','A4');
      $pdf->SetMargins(5,10,5,5);
      $pdf->AddFont('arial-monospaced','','arial-monospaced.php');

      $pdf->AddPage();

      $pdf->Image('assets/img/WINTEQ1.jpg',10,5,33,0);
      $pdf->Image('assets/img/WINTEQ8.jpg',170,5,35,0);
      
      $pdf->Ln(-3);
      
      $user = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(198,15,'RENCANA GANTI HARI / LAPORAN GANTI HARI',0,1,'C');
      $pdf->line(62,16, 161-15, 16);

      $pdf->Ln(-5);

      $pdf->setTextColor(0,0,0);
      $pdf->setFillColor(255,255,255);

      $dep = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
      $d = $this->db->get_where('karyawan_dept', ['id' =>  $gantihari['dept_id']])->row_array();

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(10, 5, 'NO : ' . $gantihari['id'], 0, 1);
      
      $pdf->Cell(44,5,'HARI / TGL              :   '. date('d-m-Y', strtotime($gantihari['tglmulai'])),1,0,1);
      $pdf->SetFont('Arial','',6);
      $pdf->Cell(78,10,'RENCANA GANTI HARI',1,0,'C',1);
      $pdf->Cell(78,10,'LAPORAN GANTI HARI',1,0,'C',1);
      $pdf->Cell(0,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,5,'DEPARTEMENT     :   ' . $d['inisial'],1,0,1);
      $pdf->SetFont('Arial','',5);
      $pdf->Cell(64,7,'',0,0,0);
      $pdf->Cell(75,7,'',0,0,0);
      $pdf->Cell(70,5,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,7,'NAMA                      :   ' . $gantihari['nama'],1,0,1);
      $pdf->SetFont('Arial','',5);

      $pdf->Cell(32,7,'MULAI',1,0,'C',1);
      $pdf->Cell(32,7,'SELESAI',1,0,'C',1);
      $pdf->Cell(14,7,'JML.JAM',1,0,'C',1);
      $pdf->Cell(32,7,'MULAI',1,0,'C',1);
      $pdf->Cell(32,7,'SELESAI',1,0,'C',1);
      $pdf->Cell(14,7,'JML.JAM',1,0,'C',1);
      $pdf->Cell(70,7,'',0,1,0);

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(44,5,'NPK                         :   ' . $gantihari['npk'],1,0,1);
      $pdf->Cell(32,5, date('H:i', strtotime($gantihari['tglmulai'])),1,0,'C',1);
      $pdf->Cell(32,5, date('H:i', strtotime($gantihari['tglselesai'])),1,0,'C',1);
      $pdf->Cell(14,5, date('H:i', strtotime($gantihari['durasi'])),1,0,'C',0);
      $pdf->Cell(32,5, date('H:i', strtotime($gantihari['tglmulai_aktual'])),1,0,'C',1);
      $pdf->Cell(32,5, date('H:i', strtotime($gantihari['tglselesai_aktual'])),1,0,'C',1);
      $pdf->Cell(14,5, date('H:i', strtotime($gantihari['durasi_aktual'])),1,1,'C',0);
      $pdf->Cell(56,5,'',0,1,0);

      $pdf->Ln(-3);
      $pdf->SetFont('Arial','B',5);
      $no = 1;
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(200,5,'* AKTIVITAS GANTI HARI *',0,1,'C',1);
      $pdf->line(92,50, 133-15, 50);

      $pdf->Ln(1);
      foreach ($aktivitas_gantihari as $a) :
            $k = $this->db->get_where('jamkerja_kategori', ['id' =>  $a['kategori']])->row_array();     

      $pdf->Ln(3); 
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(1,4, $no++,0,0,'C',0);
       $pdf->Cell(5,4,'.',0,0,'C',0);

      $pdf->Cell(1,4,'',0,0,'C',0);
      $pdf->SetFont('Arial','',7);
      $pdf->Cell(10,4,'Kategori ',0,0,'C',0);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(36,4,':',0,0,'C',0);
      $pdf->Cell(-10,4,'',0,0,'C',0);
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(10,4, $k['nama'].'  ('.$a['copro'].')',0,0,1);

      $pdf->Ln(4);
      $pdf->SetFont('Arial','',7);
      $pdf->Cell(6,4,'',0,0,'C',0);
      $pdf->Cell(10,5,'Rencana aktivitas',0,0,'L',0);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(38,4,':',0,1,'C',0);

      $pdf->Ln(-4);
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(43,4,'',0,0,'C',0);
      $pdf->MultiCell(156,4, $a['aktivitas'],0,'L');  //aktivitas


      $pdf->Ln(1);
      $pdf->SetFont('Arial','',7);
      $pdf->Cell(6,4,'',0,0,'C',0);
      $pdf->Cell(10,5,'Realisasi Ganti Hari',0,0,'L',0);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(38,4,':',0,1,'C',0);

      $pdf->Ln(-4);
      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(43,4,'',0,0,'C',0);
      $pdf->MultiCell(156,4, $a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',0,'L');  //Realisasi

      endforeach;
      
      $nama1 = $this->db->get_where('karyawan', ['inisial' => $gantihari['atasan1_rencana']])->row_array();
      $n1 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama1['posisi_id']])->row_array();
      $nama1['nama']; 

      $nama2 = $this->db->get_where('karyawan', ['inisial' => $gantihari['atasan2_rencana']])->row_array();
      $n2 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama2['posisi_id']])->row_array();
      $nama2['nama'];

      $nama3 = $this->db->get_where('karyawan', ['inisial' => $gantihari['admin_ga']])->row_array();
      $n3 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama3['posisi_id']])->row_array();
      $nama3['nama']; 

      $nama4 = $this->db->get_where('karyawan', ['inisial' => $gantihari['admin_hr']])->row_array();
      $n4 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama4['posisi_id']])->row_array();
      $nama4['nama']; 
      
      $pdf->Cell(200,5,'',0,1,'C',1);
      $pdf->SetFont('Arial','',5);
          
//1->2********************************************************************************************************/
if($gantihari['posisi_id']=='7' and $gantihari['tgl_atasan1_rencana']== null)
{
            $pdf->SetFont('Arial','',5);

            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(50,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(28,5,'DITERIMA',1,0,'C',1);
            
            $pdf->Cell(52,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(26,5,'DITERIMA',1,1,'C',1);
            //GA & HR
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(50,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(28,5, 'GA',1,0,'C',1);
            $pdf->Cell(26,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(26,5, $n2['nama'],1,0,'C',1);
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
            $pdf->Cell(-45, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan2_rencana'])), 0, 0, 'C');
            $pdf->Cell(128, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-128, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_admin_ga'])), 110, 0, 'C');
            $pdf->Cell(175, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-175, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan1_realisasi'])), 110, 0, 'C');
            $pdf->Cell(227, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-227, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan2_realisasi'])), 110, 0, 'C');
            $pdf->Cell(278, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-278, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_admin_hr'])), 110, 0, 'C');
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
else if ($gantihari['posisi_id']=='7')
{
      $pdf->SetFont('Arial','',5);

            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(56,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(22,5,'DITERIMA',1,0,'C',1);
            
            $pdf->Cell(52,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(26,5,'DITERIMA',1,1,'C',1);
            //GA & HR
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(28,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(28,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(22,5, 'GA',1,0,'C',1);
            $pdf->Cell(26,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(26,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(26,5, 'HR',1,1,'C',1);
            
            $pdf->SetFont('Arial','B',7);
            
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(28,25, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(28,25, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(22,25, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama4['nama'],1,0,'C',1);
      
            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 5);
            $pdf->Cell(47, 5, '', 0, 0);
            $pdf->Cell(23, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan1_rencana'])),0, 0, 'C');
            $pdf->Cell(78, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-78, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan2_rencana'])), 0, 0, 'C');
            $pdf->Cell(128, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-128, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_admin_ga'])), 110, 0, 'C');
            $pdf->Cell(175, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-175, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan1_realisasi'])), 110, 0, 'C');
            $pdf->Cell(227, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-227, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan2_realisasi'])), 110, 0, 'C');
            $pdf->Cell(278, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-278, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_admin_hr'])), 110, 0, 'C');
            $pdf->SetFont('Arial', '', 5);
      
            $pdf->Ln(7);
      
            $pdf->Ln(-22);
            $pdf->SetFont('arial-monospaced', '', 5);
            $pdf->Cell(64.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(24, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(21, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(20, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
}
//22 SECT.HEAD********************************************************************************************************/
else if ( $gantihari['posisi_id'] != 7)
{
      $pdf->SetFont('Arial','',5);

            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(30,5,'DITERIMA',1,0,'C',1);
            
            $pdf->Cell(48,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(30,5,'DITERIMA',1,1,'C',1);
            //GA & HR
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(30,5, 'GA1',1,0,'C',1);

            $pdf->Cell(48,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(30,5, 'HR',1,1,'C',1);
            
            $pdf->SetFont('Arial','B',7);
            
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,25, $nama1['nama'],1,0,'C',1);
            
            $pdf->Cell(30,25, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(48,25, $nama1['nama'],1,0,'C',1);
           
            $pdf->Cell(30,25, $nama4['nama'],1,0,'C',1);
      
            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 5);
            $pdf->Cell(56, 5, '', 0, 0);
            $pdf->Cell(23, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan1_rencana'])),0, 0, 'C');
            $pdf->Cell(105, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-105, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_admin_ga'])), 110, 0, 'C');
            $pdf->Cell(180, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-180, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_atasan1_realisasi'])), 110, 0, 'C');
            $pdf->Cell(260, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-260, 10, 'pada ' . date('d/m/Y H:i', strtotime($gantihari['tgl_admin_hr'])), 110, 0, 'C');
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
      
            $pdf->Cell(35, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(34, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

 }

$pdf->Output('I','SURAT RENCANA GANTI HARI/ LAPORAN GANTI HARI'.RAND().'.pdf');
     

      ?>
