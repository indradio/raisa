<?php

      $pdf = new FPDF('L','mm','A5');
      $pdf->SetMargins(5,10,5,5);
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
      $d = $this->db->get_where('karyawan_dept', ['id' =>  $lembur['dept_id']])->row_array();

      $pdf->SetFont('Arial','B',6);
      $pdf->Cell(10, 5, 'NO : ' . $lembur['id'], 0, 1);
      
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
//**************************************************************************************************************************************
 
      $cellWidth  = 78; //lebar sel
      $cellHeight = 4; //tinggi sel satu baris normal
      $textLength = strlen($a['deskripsi_hasil']); //total panjang teks
      $errMargin  = 5;           //margin kesalahan lebar sel, untuk jaga-jaga
      $startChar  = 0;           //posisi awal karakter untuk setiap baris
      $maxChar    = 0;             //karakter maksimum dalam satu baris, yang akan ditambahkan nanti
      $textArray  = array();     //untuk menampung data untuk setiap baris
      $tmpString  = "";          //untuk menampung teks untuk setiap baris (sementara)

      // Text Aktivitas & Deskripsi Sama2 Tidak Melebihi BATAS Cell
      if($pdf->GetStringWidth($a['deskripsi_hasil']) < $cellWidth AND $pdf->GetStringWidth($a['aktivitas']) < $cellWidth)
      {
            $pdf->Cell(4,5,$no++,1,0,'C',1);
            $pdf->Cell(22,5, $k['nama'],1,0,1);
            $pdf->Cell(18,5, $a['copro'],1,0,'C',1);
            $pdf->Cell(78,5, $a['aktivitas'],1);
            $pdf->Cell(78,5, $a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',1,1,'C',1);
      }
      // Text Aktivitas & Deskripsi Sama2 Melibihi BATAS Cell 
      else if ($pdf->GetStringWidth($a['deskripsi_hasil']) > $cellWidth OR $pdf->GetStringWidth($a['aktivitas']) > $cellWidth){
            
            while($startChar < $textLength)//perulangan sampai akhir teks
            { 
            //perulangan sampai karakter maksimum tercapai
                  while ($pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
                        ($startChar + $maxChar) < $textLength ) 
                  {
                         $maxChar++;
                         $tmpString = substr($a['deskripsi_hasil'],$startChar,$maxChar);
                  }
            //pindahkan ke baris berikutnya
            $startChar = $startChar + $maxChar;
            //kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
            array_push($textArray,$tmpString);
            //reset variabel penampung
            $maxChar   = 0;
            $tmpString = '';
                  
            }
             //dapatkan jumlah baris
            $line = count($textArray);
            //**********
            $textLength2 = strlen($a['aktivitas']);
            $textArray2  = array();
            $tmpString2  = ""; 
            while ($startChar < $textLength2) 
            {
                  while ($pdf->GetStringWidth($tmpString2) < ($cellWidth-$errMargin) &&
                        ($startChar + $maxChar) < $textLength2) 
                  {
                         $maxChar++;
                         $tmpString2 = substr($a['aktivitas'],$startChar,$maxChar);
                  }
            $startChar = $startChar + $maxChar;
            array_push($textArray2,$tmpString2);
            $maxChar   = 0;
            $tmpString2 = '';

            }
            //dapatkan jumlah baris
            $line2 = count($textArray2);

            if($line > $line2)
            {
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Cell(4,($line * $cellHeight),$no++,1,0,'C',1); 
                  $pdf->Cell(22,($line * $cellHeight),$k['nama'] .' '. $line .' '.$line2 ,1,0,1); 
                  $pdf->Cell(18,($line * $cellHeight),$a['copro'],1,0,1);

                  $xPos = $pdf->GetX();
                  $yPos = $pdf->GetY();
                  $pdf->MultiCell($cellWidth,($line * $cellHeight),$a['aktivitas'],1,1);
                  
                  $pdf->SetXY($xPos + $cellWidth , $yPos);
                  
                  $pdf->MultiCell($cellWidth,$cellHeight,$a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',1,1); 
            }
            else if ($line2 > $line) 
            {
                  $pdf->SetFillColor(255,255,255);
                  $pdf->Cell(4,($line2 * $cellHeight),$no++,1,0,'C',1); 
                  $pdf->Cell(22,($line2 * $cellHeight),$k['nama'],1,0,1); 
                  $pdf->Cell(18,($line2 * $cellHeight),$a['copro'],1,0,1);

                  $xPos = $pdf->GetX();
                  $yPos = $pdf->GetY();
                  $pdf->MultiCell($cellWidth,$cellHeight,$a['aktivitas'],1,1);
                  
                  $pdf->SetXY($xPos + $cellWidth , $yPos);
                  
                  $pdf->MultiCell($cellWidth,($line2 + $cellHeight),$a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',1,1); 
            }
      }

      // Text Deskripsi Melebihi Batas Cell & Text Aktivitas Kurang Dari Batas Cell 
      // else if($pdf->GetStringWidth($a['deskripsi_hasil']) > $cellWidth AND $pdf->GetStringWidth($a['aktivitas']) < $cellWidth)
      // {
      //       while($startChar < $textLength){ //perulangan sampai akhir teks
      //       //perulangan sampai karakter maksimum tercapai
      //       while( 
      //       $pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
      //       ($startChar + $maxChar) < $textLength ) {
      //             $maxChar++;
      //             $tmpString = substr($a['deskripsi_hasil'],$startChar,$maxChar);
      //       }
      //       //pindahkan ke baris berikutnya
      //       $startChar = $startChar + $maxChar;
      //       //kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
      //       array_push($textArray,$tmpString);
      //       //reset variabel penampung
      //       $maxChar   = 0;
      //       $tmpString = '';
                  
      //       }
      //       //dapatkan jumlah baris
      //       $line = count($textArray);

      //        //tulis selnya
      //       $pdf->SetFillColor(255,255,255);
      //       $pdf->Cell(4,($line * $cellHeight),$no++,1,0,'C',1); //sesuaikan ketinggian dengan jumlah garis
      //       $pdf->Cell(22,($line * $cellHeight),$k['nama'],1,0,1); 
      //       $pdf->Cell(18,($line * $cellHeight),$a['copro'],1,0,1);
      //       //memanfaatkan MultiCell sebagai ganti Cell
      //       //atur posisi xy untuk sel berikutnya menjadi di sebelahnya.
      //       //ingat posisi x dan y sebelum menulis MultiCell
      //       $xPos = $pdf->GetX();
      //       $yPos = $pdf->GetY();
      //       $pdf->Cell(78,($line * $cellHeight),$a['aktivitas'],1,1);
            
      //       //kembalikan posisi untuk sel berikutnya di samping MultiCell 
      //       //dan offset x dengan lebar MultiCell
      //       $pdf->SetXY($xPos + $cellWidth , $yPos);
            
      //       $pdf->MultiCell($cellWidth,$cellHeight,$a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',1,1); //sesuaikan ketinggian dengan jumlah garis

      // }
      // // Text Dekripsi Kurang Dari Batas Cell & Text Aktivitas Melebihi Batas Cell
      // else if($pdf->GetStringWidth($a['deskripsi_hasil']) < $cellWidth AND $pdf->GetStringWidth($a['aktivitas']) > $cellWidth)
      // {
      //       $textLength = strlen($a['aktivitas']);
      //       while($startChar < $textLength){ //perulangan sampai akhir teks
      //       //perulangan sampai karakter maksimum tercapai
      //       while( 
      //       $pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
      //       ($startChar + $maxChar) < $textLength ) {
      //             $maxChar++;
      //             $tmpString = substr($a['aktivitas'],$startChar,$maxChar);
      //       }
      //       //pindahkan ke baris berikutnya
      //       $startChar = $startChar + $maxChar;
      //       //kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
      //       array_push($textArray,$tmpString);
      //       //reset variabel penampung
      //       $maxChar   = 0;
      //       $tmpString = '';
                  
      //       }
      //       //dapatkan jumlah baris
      //       $line = count($textArray);

      //        //tulis selnya
      //       $pdf->SetFillColor(255,255,255);
      //       $pdf->Cell(4,($line * $cellHeight),$no++,1,0,'C',1); //sesuaikan ketinggian dengan jumlah garis
      //       $pdf->Cell(22,($line * $cellHeight),$k['nama'],1,0,1); 
      //       $pdf->Cell(18,($line * $cellHeight),$a['copro'],1,0,1);
      //       //memanfaatkan MultiCell sebagai ganti Cell
      //       //atur posisi xy untuk sel berikutnya menjadi di sebelahnya.
      //       //ingat posisi x dan y sebelum menulis MultiCell
      //       $xPos = $pdf->GetX();
      //       $yPos = $pdf->GetY();
      //       $pdf->MultiCell($cellWidth,$cellHeight,$a['aktivitas'],1,1);
            
      //       //kembalikan posisi untuk sel berikutnya di samping MultiCell 
      //       //dan offset x dengan lebar MultiCell
      //       $pdf->SetXY($xPos + $cellWidth , $yPos);
            
      //       $pdf->Cell(78,($line * $cellHeight),$a['deskripsi_hasil'].', ' .$a['progres_hasil'] .'%',1,1); //sesuaikan ketinggian dengan jumlah garis

      // }

     

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
      
      $pdf->Cell(200,5,'',0,1,'C',1);
      $pdf->SetFont('Arial','',5);
          
//1->2********************************************************************************************************/
if ($lembur['posisi_id']=='7')
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
//22 SECT.HEAD********************************************************************************************************/
else if ( $lembur['posisi_id'] <=6 or $lembur['posisi_id'] >=8)
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
            $pdf->Cell(30,5, 'GA',1,0,'C',1);

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
            $pdf->Cell(1, 15, 'tanda tangan basah', 1,1,'C', 1);

            $pdf->Ln(-22);
            $pdf->SetFont('arial-monospaced', '', 5);
 }

$pdf->Output('I','SURAT RENCANA / LAPORAN LEMBUR'.RAND().'.pdf');
     

      ?>