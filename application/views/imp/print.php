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
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(170, 55, 'IZIN MENINGGALKAN PEKERJAAN', 0, 1, 'C');

//MEMEBERIKAN LINE/GARIS DENGAN MARGIN 20 (210-20) 
$pdf->line(60, 28, 215 - 65, 28);

$pdf->Ln(-15);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(32, 6, 'Nama', 0, 0, 'L');
$pdf->Cell(100, 6, '            : '.$imp->name, 0, 0, 'L');
$pdf->Cell(9, 6, 'NPK.  : '.$imp->npk, 0, 1, 'L');

$pdf->Cell(32, 6, 'Bagian', 0, 0);
$pdf->Cell(9, 6, '            : '.$section->nama, 0, 1);

$pdf->Cell(32, 6, 'Berangkat Tanggal', 0, 0);
$pdf->Cell(100, 6, '            : '.date('d/m/Y', strtotime($imp->date)), 0, 0);
$pdf->Cell(9, 6, 'Jam.  : '.date('H:i', strtotime($imp->start_time)), 0, 1, 'L');

$pdf->Cell(32, 6, 'Rencana Kembali Tanggal', 0, 0);
$pdf->Cell(100, 6, '            : '.date('d/m/Y', strtotime($imp->date)), 0, 0);
$pdf->Cell(9, 6, 'Jam.  : '.date('H:i', strtotime($imp->end_time)), 0, 1, 'L');

$pdf->Cell(32, 6, 'Keperluan Alasan', 0, 0);
$pdf->Cell(9, 6, '            : '.$imp->remarks, 0, 1);

$pdf->Ln(4);

$pdf->Cell(120, 6, '', 0, 0);
$pdf->Cell(9, 6, 'Bogor, '.date('d M Y H:i', strtotime($imp->created_at)), 0, 1, 'L');

$pdf->Cell(132, 6, '', 0, 0);
$pdf->Cell(9, 6, 'Pemohon', 0, 0);

$pdf->SetFont('arial-monospaced', '', 8);
$pdf->Ln(5);
$pdf->Cell(120, 6, '', 0, 0);
$pdf->Cell(9, 6, 'Ini adalah form digital', 0, 1, 'L');
$pdf->Cell(110, 2, '', 0, 0);
$pdf->Cell(9, 2, 'Tidak memerlukan tanda tangan basah', 0, 0);

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(5);
$pdf->Cell(125, 6, '', 0, 0);
$pdf->Cell(9, 6, '( '.$imp->name.' )', 0, 0);

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

// $pdf->Cell(33, 20, '', 1, 0, 'C', 0);
$pdf->Cell(34, 4, 'Keluar', 1, 0, 'C', 0);
$pdf->Cell(33, 4, 'Kembali', 1, 1, 'C', 0);

$pdf->Cell(99, 4, '', 0, 0, 'C', 0);
$pdf->Cell(34, 16, '', 1, 0, 'C', 0);
$pdf->Cell(33, 16, '', 1, 0, 'C', 0);

$pdf->Ln(-1);
$pdf->SetFont('arial-monospaced', '', 6);
// $pdf->Cell(1, 1, '', 0, 0);
$pdf->Cell(33, 0, 'Ini adalah form digital', 0, 0,'C');
$pdf->Cell(33, 0, 'Ini adalah form digital', 0, 0,'C');
$pdf->Cell(33, 0, 'Ini adalah form digital', 0, 1, 'C');

$pdf->Cell(33, 6, 'Tidak memerlukan', 0, 0,'C');
$pdf->Cell(35, 6, 'Tidak memerlukan', 0, 0,'C');
$pdf->Cell(30, 6, 'Tidak memerlukan', 0, 1, 'C');

$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 0,'C');
$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 0,'C');
$pdf->Cell(33, 0, 'Tanda tangan basah', 0, 1, 'C');

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(33, 9, $imp->atasan1_by, 0, 0,'C');
$pdf->Cell(33, 9, $imp->atasan2_by, 0, 0,'C');
$pdf->Cell(34, 9, $imp->hr_by, 0, 1, 'C');

$pdf->Cell(33, -2, date('d M Y H:i', strtotime($imp->atasan1_at)), 0, 0,'C');
$pdf->Cell(33, -2, date('d M Y H:i', strtotime($imp->atasan2_at)), 0, 0,'C');
$pdf->Cell(34, -2, date('d M Y H:i', strtotime($imp->hr_at)), 0, 1, 'C');

$pdf->Ln(-5);
$pdf->Cell(230, 0, $imp->security_start_by, 0, 1,'C');
$pdf->Cell(300, 0, $imp->security_end_by, 0, 1,'C');

$pdf->Cell(230, 8, date('d M Y H:i', strtotime($imp->security_start_at)), 0, 1,'C');
$pdf->Cell(300, -8, date('d M Y H:i', strtotime($imp->security_end_at)), 0, 1,'C');



//$pdf->Output();
//OUTPUT SET FILENAME DOWNLOAD
$pdf->Output('I', 'IZIN_MENINGGALKAN_PEKERJAAN' . '.pdf');
