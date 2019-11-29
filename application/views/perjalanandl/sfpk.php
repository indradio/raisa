<?php
$pdf = new FPDF('L', 'mm', 'A5');
$pdf->SetMargins(20, 0);
// membuat halaman baru
$pdf->AddFont('arial-monospaced','','arial-monospaced.php');
$pdf->AddPage();
$pdf->line(10, 5, 210 - 10, 5);
$pdf->line(200, 140, 210 - 10, 5);
$pdf->line(10, 140, 20 - 10, 5);
$pdf->line(10, 140, 210 - 10, 140);


$pdf->Image('assets/img/WINTEQ8.jpg', 15, 7, 35, 0);

$pdf->Ln(-10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(174, 45, 'FORMULIR PENYIMPANGAN KEHADIRAN', 0, 1, 'C');

//MEMEBERIKAN LINE/GARIS DENGAN MARGIN 20 (210-20) 
// $pdf->line(63, 15, 212 - 60, 15);

$pdf->Ln(-15);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 5, 'Nama Karyawan', 0, 0, 'L');
$pdf->Cell(100, 5, '            :  $winteq', 0, 1, 'L');

$pdf->Cell(32, 5, 'NPK', 0, 0);
$pdf->Cell(9, 5, '            :  $winteq', 0, 1);

$pdf->Cell(32, 5, 'Dept./Seksi', 0, 0);
$pdf->Cell(100, 5, '            :  $winteq', 0, 1);

$pdf->Cell(32, 5, 'Jabatan', 0, 0);
$pdf->Cell(100, 5, '            :  $winteq', 0, 1);

$pdf->Cell(32, 5, 'Pada hari/ tanggal', 0, 0);
$pdf->Cell(9, 5, '            :  $winteq', 0, 1);

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 5, 'Melakukan penyimpangan kehadiran karena : ', 0, 0, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(5, 4, '', 0, 0);//Spasi
$pdf->Cell(8, 4, '',1, 0, 0);//kotak
$pdf->Cell(2, 4, '', 0, 0);//Spasi
$pdf->Cell(32, 5, 'Terlambat hadir alasan pribadi/ dinas *) ', 0, 0, 'L');
$pdf->Cell(70, 5, '', 0, 0);//Spasi
$pdf->Cell(8, 5, 'jam  :  $winteq', 0, 1);

$pdf->Cell(5, 4, '', 0, 0);//Spasi
$pdf->Cell(8, 4, '',1, 0, 0);//kotak
$pdf->Cell(2, 4, '', 0, 0);//Spasi
$pdf->Cell(32, 5, 'Pulang lebih awal alasan pribadi/ dinas *) ', 0, 0, 'L');
$pdf->Cell(70, 5, '', 0, 0);//Spasi
$pdf->Cell(8, 5, 'jam  :  $winteq', 0, 1);

$pdf->Cell(5, 4, '', 0, 0);//Spasi
$pdf->Cell(8, 4, '',1, 0, 0);//kotak
$pdf->Cell(2, 4, '', 0, 0);//Spasi
$pdf->Cell(32, 5, 'Tidak absen, masuk jam $winteq pulang jam $winteq *) ', 0, 0, 'L');
$pdf->Cell(66, 5, '', 0, 0);//Spasi
$pdf->Cell(8, 5, 'alasan  :  $winteq', 0, 1);


$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32, 5, 'Tidak hadir karena : ', 0, 0, 'L');

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(5, 4, '', 0, 0);//Spasi
$pdf->Cell(8, 4, '',1, 0, 0);//kotak
$pdf->Cell(2, 4, '', 0, 0);//Spasi
$pdf->Cell(32, 5, 'Sakit (lampiran surat keterangan sakit *) ', 0, 1, 'L');

$pdf->Cell(5, 4, '', 0, 0);//Spasi
$pdf->Cell(8, 4, '',1, 0, 0);//kotak
$pdf->Cell(2, 4, '', 0, 0);//Spasi
$pdf->Cell(32, 5, 'Dinas, keterangan ', 0, 0, 'L');
$pdf->Cell(5, 5, ':  $winteq', 0, 1);

$pdf->Cell(5, 4, '', 0, 0);//Spasi
$pdf->Cell(8, 4, '',1, 0, 0);//kotak
$pdf->Cell(2, 4, '', 0, 0);//Spasi
$pdf->Cell(32, 5, 'Keperluan lain, Alasan ', 0, 0, 'L');
$pdf->Cell(5, 5, ':  $winteq', 0, 1);


$pdf->Cell(100, 5, '', 0, 0);
$pdf->Cell(9, 5, 'Cibinong, $winteq 20 $winteq', 0, 0);


$pdf->Ln(5);
$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(112, 4, 'Menyetuji,', 1, 0, 'C', 1);
$pdf->Cell(56, 4, 'Tanda Tangan,', 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(56, 4, 'Kepala Dept.' , 1, 0, 'C', 1);
$pdf->Cell(56, 4, 'Kepala Seksi', 1, 0, 'C', 1);
$pdf->Cell(56, 24, '', 1, 1, 'C', 1);

$pdf->Ln(-20);
$pdf->Cell(56, 20, '' , 1, 0, 'C', 1);
$pdf->Cell(56, 20, '', 1, 0, 'C', 1);

$pdf->Ln(13);
$pdf->Cell(56, 4, '( $winteq )' , 0, 0, 'C', 0);
$pdf->Cell(56, 4, '( $winteq )', 0, 0, 'C', 0);
$pdf->Cell(56, 4, '( $winteq )', 0, 0, 'C', 0);

$pdf->Ln(7);
$pdf->Cell(56, 4, '*) coret yang tidak perlu' , 0, 0,'L', 0);

//$pdf->Output();
//OUTPUT SET FILENAME DOWNLOAD
$pdf->Output('I', 'FORMULIR_PENYIMPANGAN_KEHADIRAN' . '.pdf');
