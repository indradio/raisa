<?php

      $pdf = new FPDF('L','mm','A5');
      $pdf->SetMargins(5,10);
      $pdf->AddFont('arial-monospaced','','arial-monospaced.php');

      $pdf->AddPage();

      $pdf->Image('assets/img/WINTEQ1.jpg',10,5,30,0);
      $pdf->Image('assets/img/WINTEQ8.jpg',170,5,30,0);
      
      $pdf->Ln(-3);
      
      $user = $this->db->get_where('karyawan', ['npk' =>  $this->session->userdata('npk')])->row_array();

      $pdf->SetFont('Arial','B',8);
      $pdf->Cell(185,15,'RENCANA / LAPORAN LEMBUR',0,1,'C');
      $pdf->line(75,16, 135-15, 16);

      $pdf->Ln(-5);

      $pdf->setTextColor(0,0,0);
      $pdf->setFillColor(255,255,255);

      $dep = $this->db->get_where('karyawan', ['npk' => $this->session->userdata('npk')])->row_array();
      $d = $this->db->get_where('karyawan_dept', ['id' =>  $dep['dept_id']])->row_array();

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(10, 5, 'NO : ' . $lembur['id'], 0, 1,);
      
      $pdf->Cell(44,5,'HARI / TGL              :   '. date('d-m-Y', strtotime($lembur['tglmulai'])),1,0,1);
      $pdf->SetFont('Arial','',5);

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
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglmulai'])),1,0,'C',1);
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglselesai'])),1,0,'C',1);
      $pdf->Cell(14,5, date('H:i', strtotime($lembur['durasi'])),1,0,'C',0);
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglmulai_aktual'])),1,0,'C',1);
      $pdf->Cell(32,5, date('H:i', strtotime($lembur['tglselesai_aktual'])),1,0,'C',1);
      $pdf->Cell(14,5, date('H:i', strtotime($lembur['durasi_aktual'])),1,1,'C',0);
      $pdf->Cell(56,5,'',0,1,0);

      $pdf->SetFont('Arial','',5);
      $no = 1;

      $pdf->Cell(4,5,'NO',1,0,'C',1);
      $pdf->Cell(22,5,' KATEGORI',1,0,'C',1);
      $pdf->Cell(18,5,'COPRO',1,0,'C',1);
      $pdf->Cell(78,5,' AKTIVITAS LEMBUR',1,0,'C',1);
      $pdf->Cell(78,5,'REALISASI HASIL AKTIVITAS LEMBUR',1,1,'C',1);

      $pdf->SetFont('Arial','B',6);

      foreach ($aktivitas as $a) :
            $k = $this->db->get_where('jamkerja_kategori', ['id' =>  $a['kategori']])->row_array();

      $pdf->Cell(4,5,$no++,1,0,'C',1);
      $pdf->Cell(22,5, $k['nama'],1,0,1);
      $pdf->Cell(18,5, $a['copro'],1,0,'C',1);
      $pdf->Cell(78,5, $a['aktivitas'],1,0,'C',1);
      $pdf->Cell(78,5, $a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',1,1,'C',1);

      endforeach;
      
      $nama1 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan1_rencana']])->row_array();
      $n1 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama1['posisi_id']])->row_array();
      $nama1['nama']; 

      $nama2 = $this->db->get_where('karyawan', ['inisial' => $lembur['atasan2_rencana']])->row_array();
      $n2 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama2['posisi_id']])->row_array();
      $nama2['nama'];

      $nama3 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_ga']])->row_array();
      $n3 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama3['posisi_id']])->row_array();
      $nama3['nama']; 

      $nama4 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_hr']])->row_array();
      $n4 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama4['posisi_id']])->row_array();
      $nama4['nama']; 

      $nama5 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_div']])->row_array();
      $n5 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama5['posisi_id']])->row_array();
      $nama5['nama']; 

      $nama6 = $this->db->get_where('karyawan', ['inisial' => $lembur['admin_coo']])->row_array();
      $n6 = $this->db->get_where('karyawan_posisi', ['id' =>  $nama6['posisi_id']])->row_array();
      $nama6['nama']; 
      
      $pdf->Cell(200,5,'',0,1,'C',1);
      $pdf->SetFont('Arial','',5);

            
//22********************************************************************************************************/
if($lembur['posisi_id']=='7' and $lembur['durasi'] <= '03:00:00' and $lembur['durasi_aktual'] <= '03:00:00' and $lembur['tgl_atasan1_rencana']== null)
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
            $pdf->Cell(28,5, 'GA1',1,0,'C',1);
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
else if ($lembur['posisi_id']=='7' and $lembur['durasi'] <= '03:00:00' and $lembur['durasi_aktual'] <= '03:00:00' )
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
            $pdf->Cell(22,5, 'GA2',1,0,'C',1);
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
            $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])),0, 0, 'C');
            $pdf->Cell(78, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-78, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 0, 0, 'C');
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

// 333********************************************************************************************************/
else if ($lembur['posisi_id']=='7' and $lembur['durasi'] <= '03:00:00' and $lembur['durasi_aktual'] > '03:00:00' and $lembur['durasi_aktual'] < '06:00:00' )
{
            //GA & HR
            $pdf->Cell(22,5, 'GA',1,0,'C',1);
            $pdf->Cell(22,5, 'HR',1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(39,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(39,5, $n2['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(25,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(25,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(28,5, $n5['nama'],1,1,'C',1);

            $pdf->SetFont('Arial','B',6);   
            //GA & HR
            $pdf->Cell(22,22, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(22,22, $nama4['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(39,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(39,22, $nama2['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(25,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(25,22, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(28,22, $nama5['nama'],1,1,'C',1);

            $pdf->Ln(-9);
            $pdf->SetFont('Arial', 'B', 5);
            //TGL-GA
            $pdf->Cell(22, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-22, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])),0, 0, 'C');
            //TGL-HR
            $pdf->Cell(67, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-67, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 0, 0, 'C');
            //TGL-sect-rencana
            $pdf->Cell(125, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-125, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])), 110, 0, 'C');
            //TGL-dept-rencana
            $pdf->Cell(205, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-205, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 110, 0, 'C');
            
            //TGL-sect-realisasi
            $pdf->Cell(268, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-268, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            //TGL-dept-realisasi
            $pdf->Cell(320, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-320, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])), 110, 0, 'C');
            // //TGL-div-realisasi
            $pdf->Cell(372, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-372, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_realisasi'])), 110, 0, 'C');

            $pdf->Ln(10);

            $pdf->Ln(-23);
            $pdf->SetFont('arial-monospaced', '', 5);
            $pdf->Cell(17.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(18, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(26.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(35, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(28, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(23, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(21, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
}
// 333********************************************************************************************************/
if($lembur['posisi_id']=='7' and $lembur['durasi'] > '03:00:00' and $lembur['durasi'] < '06:00:00' and $lembur['durasi_aktual'] <= '06:00:00')
{
            //GA & HR
            $pdf->Cell(22,5, 'GA',1,0,'C',1);
            $pdf->Cell(22,5, 'HR',1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(25,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(25,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(28,5, $n5['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(25,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(25,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(28,5, $n5['nama'],1,1,'C',1);

            $pdf->SetFont('Arial','B',5);   
            //GA & HR
            $pdf->Cell(22,22, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(22,22, $nama4['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(25,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(25,22, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(28,22, $nama5['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(25,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(25,22, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(28,22, $nama5['nama'],1,1,'C',1);

            $pdf->Ln(-9);
            $pdf->SetFont('Arial', 'B', 5);
            //TGL-GA
            $pdf->Cell(22, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-22, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])),0, 0, 'C');
            //TGL-HR
            $pdf->Cell(67, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-67, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 0, 0, 'C');
            //TGL-sect-rencana
            $pdf->Cell(112, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-112, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])), 110, 0, 'C');
            //TGL-dept-rencana
            $pdf->Cell(162, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-162, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 110, 0, 'C');
            //TGL-div-rencana
            $pdf->Cell(215, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-215, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_rencana'])), 110, 0, 'C');

            //TGL-sect-realisasi
            $pdf->Cell(268, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-268, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            //TGL-dept-realisasi
            $pdf->Cell(320, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-320, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])), 110, 0, 'C');
            // //TGL-div-realisasi
            $pdf->Cell(370, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-370, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_realisasi'])), 110, 0, 'C');

            $pdf->Ln(10);

            $pdf->Ln(-23);
            $pdf->SetFont('arial-monospaced', '', 5);
            $pdf->Cell(17.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(18, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(19.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(21, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(23, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(21, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(23, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
            }
         

// else if ($lembur['durasi'] >= '03:00:00' and $lembur['durasi_aktual'] >= '06:00:00') 
// {
//       //GA & HR
//       $pdf->Cell(22,5, 'GA',1,0,'C',1);
//       $pdf->Cell(22,5, 'HR',1,0,'C',1);
//       //sect, dept, div, coo
//       $pdf->Cell(25,5, $n1['nama'],1,0,'C',1);
//       $pdf->Cell(25,5, $n2['nama'],1,0,'C',1);
//       $pdf->Cell(25,5, $n5['nama'],1,0,'C',1);
//       //sect, dept, div, coo
//       $pdf->Cell(20,5, $n1['nama'],1,0,'C',1);
//       $pdf->Cell(20,5, $n2['nama'],1,0,'C',1);
//       $pdf->Cell(21,5, $n5['nama'],1,0,'C',1);
//       $pdf->Cell(20,5, $n6['nama'],1,1,'C',1);
      
//       $pdf->SetFont('Arial','B',6);   
//       //GA & HR
//       $pdf->Cell(22,22, $nama3['nama'],1,0,'C',1);
//       $pdf->Cell(22,22, $nama4['nama'],1,0,'C',1);
//       //sect, dept, div, coo
//       $pdf->Cell(25,22, $nama1['nama'],1,0,'C',1);
//       $pdf->Cell(25,22, $nama2['nama'],1,0,'C',1);
//       $pdf->Cell(25,22, $nama5['nama'],1,0,'C',1);

//       //sect, dept, div, coo
//       $pdf->Cell(20,22, $nama1['nama'],1,0,'C',1);
//       $pdf->Cell(20,22, $nama2['nama'],1,0,'C',1);
//       $pdf->Cell(21,22, $nama5['nama'],1,0,'C',1);
//       $pdf->Cell(20,22, $nama6['nama'],1,1,'C',1);

//       $pdf->Ln(-9);
//       $pdf->SetFont('Arial', 'B', 5);
//       //TGL-GA
//       $pdf->Cell(22, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-22, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])),0, 0, 'C');
//       //TGL-HR
//       $pdf->Cell(67, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-67, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 0, 0, 'C');
//       //TGL-sect-rencana
//       $pdf->Cell(115, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-115, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])), 110, 0, 'C');
//       //TGL-dept-rencana
//       $pdf->Cell(163, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-163, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 110, 0, 'C');
//       //TGL-div-rencana
//       $pdf->Cell(213, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-213, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_rencana'])), 110, 0, 'C');
      
//       //TGL-sect-realisasi
//       $pdf->Cell(258, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-258, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
//       //TGL-dept-realisasi
//       $pdf->Cell(300, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-302, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])), 110, 0, 'C');
//       //TGL-div-realisasi
//       $pdf->Cell(345, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-347, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_realisasi'])), 110, 0, 'C');
//       //TGL-coo-realisasi
//       $pdf->Cell(388, 5, 'Disetujui',0, 0, 'C');
//       $pdf->Cell(-388, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_coo_realisasi'])), 110, 0, 'C');
//       $pdf->SetFont('Arial', '', 5);

//       $pdf->Ln(10);

//       $pdf->Ln(-23);
//       $pdf->SetFont('arial-monospaced', '', 5);
//       $pdf->Cell(17.5, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(18, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(20, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(20, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(18, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(16, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(16, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

//       $pdf->Cell(17, 5, 'form digital', 0,'C', 0);
//       $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
//       $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
// }
else if($lembur['posisi_id']=='7' and $lembur['durasi'] > '06:00:00')
{
            //GA & HR
            $pdf->Cell(22,5, 'GA',1,0,'C',1);
            $pdf->Cell(22,5, 'HR',1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(19,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(20,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(20,5, $n5['nama'],1,0,'C',1);
            $pdf->Cell(19,5, $n6['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(19,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(20,5, $n2['nama'],1,0,'C',1);
            $pdf->Cell(20,5, $n5['nama'],1,0,'C',1);
            $pdf->Cell(19,5, $n6['nama'],1,1,'C',1);
            
            $pdf->SetFont('Arial','B',5);   
            //GA & HR
            $pdf->Cell(22,22, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(22,22, $nama4['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(19,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(20,22, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(20,22, $nama5['nama'],1,0,'C',1);
            $pdf->Cell(19,22, $nama6['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(19,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(20,22, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(20,22, $nama5['nama'],1,0,'C',1);
            $pdf->Cell(19,22, $nama6['nama'],1,1,'C',1);

            $pdf->Ln(-9);
            $pdf->SetFont('Arial', 'B', 5);
            //TGL-GA
            $pdf->Cell(22, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-22, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])),0, 0, 'C');
            //TGL-HR
            $pdf->Cell(67, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-67, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 0, 0, 'C');
            //TGL-sect-rencana
            $pdf->Cell(106, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-105, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])), 110, 0, 'C');
            //TGL-dept-rencana
            $pdf->Cell(141, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-138, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_rencana'])), 110, 0, 'C');
            //TGL-div-rencana
            $pdf->Cell(178, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-178, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_rencana'])), 110, 0, 'C');
            //TGL-coo-rencana
            $pdf->Cell(218, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-219, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_coo_rencana'])), 110, 0, 'C');

            //TGL-sect-realisasi
            $pdf->Cell(258, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-259, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            //TGL-dept-realisasi
            $pdf->Cell(298, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-298, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan2_realisasi'])), 110, 0, 'C');
            //TGL-div-realisasi
            $pdf->Cell(338, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-338, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_realisasi'])), 110, 0, 'C');
            //TGL-coo-realisasi
            $pdf->Cell(378, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-379, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_coo_realisasi'])), 110, 0, 'C');
            $pdf->SetFont('Arial', '', 5);

            $pdf->Ln(10);

            $pdf->Ln(-23);
            $pdf->SetFont('arial-monospaced', '', 4.5);
            $pdf->Cell(17, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(18, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(16, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(16, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(16, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(15, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(15, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(15, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(16, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(16, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

}

/********************************************************************************************************/
//22 SECT.HEAD********************************************************************************************************/
else if ($lembur['posisi_id']=='4' or $lembur['posisi_id']=='5' or $lembur['posisi_id']=='6' or $lembur['posisi_id']=='9' or $lembur['posisi_id']=='10' and $lembur['durasi'] <= '03:00:00' and $lembur['durasi_aktual'] <= '03:00:00' )
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
            $pdf->Cell(30,5, 'GA22',1,0,'C',1);

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
            $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])),0, 0, 'C');
            $pdf->Cell(105, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-105, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])), 110, 0, 'C');
            $pdf->Cell(180, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-180, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            $pdf->Cell(260, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-260, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 110, 0, 'C');
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
      
            $pdf->Cell(35, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
}
//22 SECT.HEAD********************************************************************************************************/
else if ($lembur['posisi_id']=='4' or $lembur['posisi_id']=='5' or $lembur['posisi_id']=='6' or $lembur['posisi_id']=='9' or $lembur['posisi_id']=='10' and $lembur['durasi'] > '03:00:00' and $lembur['durasi'] < '06:00:00' and $lembur['durasi_aktual'] > '03:00:00' )
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
            $pdf->Cell(22,5, 'GA23',1,0,'C',1);
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
            $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])),0, 0, 'C');
            $pdf->Cell(78, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-78, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_rencana'])), 0, 0, 'C');
            $pdf->Cell(128, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-128, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])), 110, 0, 'C');
            $pdf->Cell(175, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-175, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            $pdf->Cell(227, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-227, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_realisasi'])), 110, 0, 'C');
            $pdf->Cell(278, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-278, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 110, 0, 'C');
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
/********************************************************************************************************/
else if($lembur['posisi_id']=='4' or $lembur['posisi_id']=='5' or $lembur['posisi_id']=='6' or $lembur['posisi_id']=='9' or $lembur['posisi_id']=='10' and $lembur['durasi'] > '06:00:00')
{
            //GA & HR
            $pdf->Cell(22,5, 'GA24',1,0,'C',1);
            $pdf->Cell(22,5, 'HR',1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(26,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(26,5, $n5['nama'],1,0,'C',1);
            $pdf->Cell(26,5, $n6['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(26,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(26,5, $n5['nama'],1,0,'C',1);
            $pdf->Cell(26,5, $n6['nama'],1,1,'C',1);
            
            $pdf->SetFont('Arial','B',5);   
            //GA & HR
            $pdf->Cell(22,22, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(22,22, $nama4['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(26,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(26,22, $nama5['nama'],1,0,'C',1);
            $pdf->Cell(26,22, $nama6['nama'],1,0,'C',1);
            //sect, dept, div, coo
            $pdf->Cell(26,22, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(26,22, $nama5['nama'],1,0,'C',1);
            $pdf->Cell(26,22, $nama6['nama'],1,1,'C',1);

            $pdf->Ln(-9);
            $pdf->SetFont('Arial', 'B', 5);
            //TGL-GA
            $pdf->Cell(22, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-22, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])),0, 0, 'C');
            //TGL-HR
            $pdf->Cell(67, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-67, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 0, 0, 'C');
            //TGL-dept
            $pdf->Cell(115, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-115, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])), 110, 0, 'C');
            //TGL-div-rencana
            $pdf->Cell(168, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-168, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_rencana'])), 110, 0, 'C');
            //TGL-coo-rencana
            $pdf->Cell(218, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-219, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_coo_rencana'])), 110, 0, 'C');

            //TGL-dept-realisasi
            $pdf->Cell(270, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-270, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            //TGL-div-realisasi
            $pdf->Cell(325, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-325, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_realisasi'])), 110, 0, 'C');
            //TGL-coo-realisasi
            $pdf->Cell(378, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-379, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_coo_realisasi'])), 110, 0, 'C');
            $pdf->SetFont('Arial', '', 5);

            $pdf->Ln(10);

            $pdf->Ln(-23);
            $pdf->SetFont('arial-monospaced', '', 4.5);
            $pdf->Cell(17, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(18, 5, 'form digital', 0,'C', 0);
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

            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);

} 
/********************************************************************************************************/
else if ($lembur['posisi_id']=='4' or $lembur['posisi_id']=='5' or $lembur['posisi_id']=='6' or $lembur['posisi_id']=='9' or $lembur['posisi_id']=='10' and $lembur['durasi'] <= '03:00:00' and $lembur['durasi_aktual'] > '03:00:00' and $lembur['durasi_aktual'] <= '06:00:00'  )
{
      $pdf->SetFont('Arial','',5);

            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(30,5,'DITERIMA',1,0,'C',1);
            
            $pdf->Cell(52,5,'DISETUJUI',1,0,'C',1);
            $pdf->Cell(26,5,'DITERIMA',1,1,'C',1);
            //GA & HR
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(30,5, 'GA25',1,0,'C',1);

           $pdf->Cell(26,5, $n1['nama'],1,0,'C',1);
            $pdf->Cell(26,5, $n5['nama'],1,0,'C',1);
            $pdf->Cell(26,5, 'HR',1,1,'C',1);
            
            $pdf->SetFont('Arial','B',7);
            
            $pdf->Cell(44,5,'',0,0,'C',1);
            $pdf->Cell(48,25, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(30,25, $nama3['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama1['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama2['nama'],1,0,'C',1);
            $pdf->Cell(26,25, $nama4['nama'],1,0,'C',1);
      
            $pdf->Ln(15);
            $pdf->SetFont('Arial', 'B', 5);
            $pdf->Cell(55, 5, '', 0, 0);
            $pdf->Cell(23, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-23, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_rencana'])),0, 0, 'C');
            $pdf->Cell(105, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-105, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_ga'])), 110, 0, 'C');
            $pdf->Cell(160, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-160, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_atasan1_realisasi'])), 110, 0, 'C');
            $pdf->Cell(213, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-213, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_divhead_realisasi'])), 110, 0, 'C');
            $pdf->Cell(265, 5, 'Disetujui',0, 0, 'C');
            $pdf->Cell(-265, 10, 'pada ' . date('d/m/Y H:i', strtotime($lembur['tgl_admin_hr'])), 110, 0, 'C');
            $pdf->SetFont('Arial', '', 5);
      
            $pdf->Ln(7);
      
            $pdf->Ln(-22);
            $pdf->SetFont('arial-monospaced', '', 5);
            $pdf->Cell(74.5, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(35, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(25, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
            $pdf->Cell(22, 5, 'form digital', 0,'C', 0);
            $pdf->Cell(3, 10, 'Tidak memerlukan', 0,'C', 0);
            $pdf->Cell(1, 15, 'tanda tangan basah', 0,'C', 0);
      
}
$pdf->Output('I','SURAT RENCANA / LAPORAN LEMBUR'.RAND().'.pdf');

      ?>