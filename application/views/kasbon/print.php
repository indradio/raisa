<?php
$pdf = new FPDF('L', 'mm', 'A5');
$pdf->SetMargins(20, 0);
// membuat halaman baru
$pdf->AddFont('arial-monospaced','','arial-monospaced.php');
$pdf->AddPage();
// setting jenis font yang akan digunakan
// mencetak string 


$pdf->Image('assets/img/WINTEQ8.jpg', 15, 5, 50, 0);

$pdf->Ln(-14);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(170, 55, 'KASBON', 0, 1, 'C');

//MEMEBERIKAN LINE/GARIS DENGAN MARGIN 20 (210-20) 
$pdf->line(80, 18, 215 - 85, 18);

$pdf->Ln(-15);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(32, 6, 'No.', 0, 0, 'L');
$pdf->Cell(100, 6, '  : ', 0, 1, 'L');
// $pdf->Cell(9, 6, 'NPK.  : ', 0, 1, 'L');

$pdf->Cell(32, 6, 'Tanggal', 0, 0);
$pdf->Cell(9, 6, '  : ', 0, 1);

$pdf->Cell(32, 6, 'Nama', 0, 0);
$pdf->Cell(9, 6, '  : ', 0, 1);

$pdf->Cell(32, 6, 'Seksi/Dept', 0, 0);
$pdf->Cell(9, 6, '  : ', 0, 1);

$pdf->Cell(32, 6, 'Nilai', 0, 0);
$pdf->Cell(9, 6, '  : ', 0, 1);

$pdf->Cell(32, 6, 'Terbilang', 0, 0);
$pdf->Cell(9, 6, '  : '.$terbilang, 0, 1);

$pdf->Cell(32, 6, 'Keperluan', 0, 0);
$pdf->Cell(9, 6, '  : ', 0, 1);

$pdf->Ln(7);
$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(66, 4, 'MENGETAHUI', 1, 0, 'C', 1);
$pdf->Cell(100, 4, 'MENYETUJUI', 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 4, 'KA. SIE' , 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'KA. DEPT', 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'KA. DIV/DIREKSI', 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'KA. DEPT FIN', 1, 0, 'C', 1);
$pdf->Cell(34, 4, 'PENERIMA', 1, 1, 'C', 1);

$pdf->Cell(33, 20, '' , 1, 0, 'C', 1);
$pdf->Cell(33, 20, '', 1, 0, 'C', 1);
$pdf->Cell(33, 20, '', 1, 0, 'C', 1);
$pdf->Cell(33, 20, '', 1, 0, 'C', 1);
$pdf->Cell(34, 20, '', 1, 0, 'C', 1);

// $pdf->Cell(33, 20, '', 1, 0, 'C', 0);
// $pdf->Cell(34, 4, 'Keluar', 1, 0, 'C', 0);
// $pdf->Cell(33, 4, 'Kembali', 1, 1, 'C', 0);

$pdf->Cell(99, 4, '', 0, 0, 'C', 0);
// $pdf->Cell(33, 16, '', 1, 0, 'C', 0);
// $pdf->Cell(33, 16, '', 1, 0, 'C', 0);
// $pdf->Cell(33, 16, '', 1, 0, 'C', 0);
// $pdf->Cell(33, 16, '', 1, 0, 'C', 0);

$pdf->Ln(3);
$pdf->SetFont('arial-monospaced', '', 6);
// $pdf->Cell(1, 1, '', 0, 0);
$pdf->Cell(33, 0, 'Ini adalah form digital', 0, 0,'C');
$pdf->Cell(33, 0, 'Ini adalah form digital', 0, 0,'C');
$pdf->Cell(33, 0, 'Ini adalah form digital', 0, 0,'C');
$pdf->Cell(33, 0, 'Ini adalah form digital', 0, 0,'C');
$pdf->Cell(34, 0, 'Ini adalah form digital', 0, 1, 'C');

$pdf->Cell(33, 6, 'Tidak memerlukan', 0, 0,'C');
$pdf->Cell(35, 6, 'Tidak memerlukan', 0, 0,'C');
$pdf->Cell(30, 6, 'Tidak memerlukan', 0, 0,'C');
$pdf->Cell(35, 6, 'Tidak memerlukan', 0, 0,'C');
$pdf->Cell(30, 6, 'Tidak memerlukan', 0, 1, 'C');

$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 0,'C');
$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 0,'C');
$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 0,'C');
$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 0,'C');
$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 9, '', 0, 0,'C');
$pdf->Cell(33, 9, '', 0, 0,'C');
$pdf->Cell(33, 9, '', 0, 0,'C');
$pdf->Cell(33, 9, '', 0, 0,'C');
$pdf->Cell(34, 9, '', 0, 1, 'C');

$pdf->Cell(33, -2, '', 0, 0,'C');
$pdf->Cell(33, -2, '', 0, 0,'C');
$pdf->Cell(33, -2, '', 0, 0,'C');
$pdf->Cell(33, -2, '', 0, 0,'C');
$pdf->Cell(34, -2, '', 0, 1, 'C');

$pdf->Ln(-5);
$pdf->Cell(230, 0, '', 0, 1,'C');
$pdf->Cell(300, 0, '', 0, 1,'C');

$pdf->Cell(230, 8, '', 0, 1,'C');
$pdf->Cell(300, -8, '', 0, 1,'C');

$pdf->Ln(9);

$pdf->Cell(120, 6, '', 0, 0);
$pdf->Cell(9, 6, 'Bogor, ', 0, 1, 'L');

$pdf->Cell(132, 6, '', 0, 0);
$pdf->Cell(9, 6, 'Pemohon', 0, 0);

$pdf->SetFont('arial-monospaced', '', 8);
$pdf->Ln(4);
$pdf->Cell(120, 6, '', 0, 0);
$pdf->Cell(9, 6, 'Ini adalah form digital', 0, 1, 'L');
$pdf->Cell(110, 2, '', 0, 0);
$pdf->Cell(9, 2, 'Tidak memerlukan tanda tangan basah', 0, 0);

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(3);
$pdf->Cell(125, 6, '', 0, 0);
$pdf->Cell(9, 6, '(  )', 0, 0);



//$pdf->Output();
//OUTPUT SET FILENAME DOWNLOAD
$pdf->Output('I', 'IZIN_MENINGGALKAN_PEKERJAAN' . '.pdf');
