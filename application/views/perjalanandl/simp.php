<?php
$pdf = new FPDF('L', 'mm', 'A5');
$pdf->SetMargins(20, 0);
// membuat halaman baru
$pdf->AddFont('arial-monospaced','','arial-monospaced.php');
$pdf->AddPage();
// setting jenis font yang akan digunakan
// mencetak string 


$pdf->Image('assets/img/WINTEQ8.jpg', 15, 5, 50, 0);

 $pdf->Ln(-2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(170, 45, 'IZIN MENINGGALKAN PEKERJAAN', 0, 1, 'C');

//MEMEBERIKAN LINE/GARIS DENGAN MARGIN 20 (210-20) 
$pdf->line(67, 23, 215 - 71, 23);

$pdf->Ln(-10);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(32, 6, 'Nama', 0, 0, 'L');
$pdf->Cell(100, 6, '            : $winteq', 0, 0, 'L');
$pdf->Cell(9, 6, 'NRP.  : $winteq', 0, 1, 'L');

$pdf->Cell(32, 6, 'Bagian', 0, 0);
$pdf->Cell(9, 6, '            : $winteq ', 0, 1);

$pdf->Cell(32, 6, 'Berangkat Tanggal', 0, 0);
$pdf->Cell(100, 6, '            : $winteq', 0, 0);
$pdf->Cell(9, 6, 'Jam.  : $winteq', 0, 1, 'L');

$pdf->Cell(32, 6, 'Rencana Kembali Tanggal', 0, 0);
$pdf->Cell(100, 6, '            : $winteq', 0, 0);
$pdf->Cell(9, 6, 'Jam.  : $winteq', 0, 1, 'L');

$pdf->Cell(32, 6, 'Keperluan Alasan', 0, 0);
$pdf->Cell(9, 6, '            : $winteq', 0, 1);

$pdf->Ln(4);

$pdf->Cell(70, 6, '', 0, 0);
$pdf->Cell(72, 6, 'Bogor, $winteq', 0, 0);
$pdf->Cell(2, 6, '$winteq', 0, 1, 'L');

$pdf->Cell(132, 6, '', 0, 0);
$pdf->Cell(9, 6, 'Pemohon', 0, 0);

$pdf->Ln(20);
$pdf->Cell(132, 6, '', 0, 0);
$pdf->Cell(9, 6, '( $winteq )', 0, 0);

$pdf->Ln(6);
$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(99, 4, 'Disetujui', 1, 0, 'C', 1);
$pdf->Cell(67, 4, 'Diketahui', 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 4, 'KA. SIE' , 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'KA. DEPT', 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'PERSONALIA', 1, 0, 'C', 1);
$pdf->Cell(67, 4, 'Keamanan', 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 20, '' , 1, 0, 'C', 1);
$pdf->Cell(33, 20, '', 1, 0, 'C', 1);
$pdf->Cell(33, 20, '', 1, 0, 'C', 1);

$pdf->Cell(33, 20, '', 1, 0, 'C', 0);
$pdf->Cell(17, 4, 'Keluar', 1, 0, 'C', 0);
$pdf->Cell(17, 4, 'Kembali', 1, 1, 'C', 0);

$pdf->Cell(132, 4, '', 0, 0, 'C', 0);
$pdf->Cell(17, 16, '$winteq', 1, 0, 'C', 0);
$pdf->Cell(17, 16, '$winteq', 1, 0, 'C', 0);

//$pdf->Output();
//OUTPUT SET FILENAME DOWNLOAD
$pdf->Output('I', 'IZIN_MENINGGALKAN_PEKERJAAN' . '.pdf');
