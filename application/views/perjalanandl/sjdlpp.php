<?php
$pdf = new FPDF('L', 'mm', 'A5');
$pdf->SetMargins(20,1,20,-5);

// membuat halaman baru
$pdf->AddFont('arial-monospaced','','arial-monospaced.php');
$pdf->AddPage();
// setting jenis font yang akan digunakan
// mencetak string 

if ($perjalanan['status']== 0){
    $pdf->Image('assets/img/watermark/batal-perjalanan.png', 40, 5, 100, 70);
    $pdf->Image('assets/img/watermark/batal-perjalanan.png', 80, 5, 100, 70);
}elseif($perjalanan['status']== 2){
    $pdf->Image('assets/img/watermark/sedang-perjalanan.png', 40, 5, 100, 70);
    $pdf->Image('assets/img/watermark/sedang-perjalanan.png', 80, 5, 100, 70);
}

$pdf->Image('assets/img/WINTEQ8.jpg', 15, 3, 35, 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(170, 22, 'SURAT TUGAS KELUAR KANTOR', 0, 1, 'C');

//MEMEBERIKAN LINE/GARIS DENGAN MARGIN 20 (210-20) 
$pdf->line(80, 13.5, 210 - 80, 13.5);

$pdf->Ln(-8);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(32, 3, 'NO PERJALANAN', 0, 0, 'L');
$pdf->Cell(9, 3, '            : #' . $perjalanan['id'], 0, 1, 'L');

// $pdf->Cell(32, 3, 'NAMA PEMOHON', 0, 0);
// $pdf->Cell(9, 3, '            : ' . $perjalanan['nama'], 0, 1);

$user = $this->db->get_where('karyawan', ['npk' => $perjalanan['npk']])->row_array();
$dept = $this->db->get_where('karyawan_dept', ['id' => $user['dept_id']])->row_array();
$sect = $this->db->get_where('karyawan_sect', ['id' => $user['sect_id']])->row_array();

$pdf->Cell(32, 3, 'PESERTA PERJALANAN', 0, 0);
$pdf->Cell(9, 3, '            : ' . $perjalanan['anggota'], 0, 1);

$pdf->Cell(32, 3, 'DEPARTEMENT/SEKSI', 0, 0);
$pdf->Cell(9, 3, '            : ' . $dept['nama'] . ' / ' . $sect['nama'], 0, 1);

$pdf->Cell(32, 3, 'TUJUAN', 0, 0);
$pdf->Cell(9, 3, '            : ' . $perjalanan['tujuan'], 0, 1);

$pdf->Cell(32, 3, 'KEPERLUAN', 0, 0);
$pdf->Cell(9, 3, '            : ' . $perjalanan['keperluan'], 0, 1);

//BERANGKAT
$pdf->Cell(34, 3, 'BERANGKAT', 0, 0);
$pdf->Cell(5, 3, '' . 'Tgl', 0, 0);
$pdf->Cell(20, 3, ': ' . date('d/m/Y', strtotime($perjalanan['tglberangkat'])), 0, 0);

$pdf->Cell(6, 3, 'Jam', 0, 0);
$pdf->Cell(20, 3, ': ' . date('H:i', strtotime($perjalanan['jamberangkat'])), 0, 0);

$pdf->Cell(5, 3, 'Km', 0, 0);
$pdf->Cell(15, 3, ': ' . $perjalanan['kmberangkat'], 0, 0);

$pdf->Cell(13, 3, 'Pengemudi', 0, 0);
$pdf->Cell(20, 3, ': ' . $perjalanan['supirberangkat'], 0, 0);

$pdf->Cell(13, 3, 'Security', 0, 0);
$pdf->Cell(25, 3, ': ' . $perjalanan['cekberangkat'], 0, 1);

//KEMBALI
$pdf->Cell(34, 3, 'KEMBALI', 0, 0);
$pdf->Cell(5, 3, '' . 'Tgl', 0, 0);
$pdf->Cell(20, 3, ': ' . date('d/m/Y', strtotime($perjalanan['tglkembali'])), 0, 0);

$pdf->Cell(6, 3, 'Jam', 0, 0);
$pdf->Cell(20, 3, ': ' . date('H:i', strtotime($perjalanan['jamkembali'])), 0, 0);

$pdf->Cell(5, 3, 'Km', 0, 0);
$pdf->Cell(15, 3, ': ' . $perjalanan['kmkembali'], 0, 0);

$pdf->Cell(13, 3, 'Pengemudi', 0, 0);
$pdf->Cell(20, 3, ': ' . $perjalanan['supirkembali'], 0, 0);

$pdf->Cell(13, 3, 'Security', 0, 0);
$pdf->Cell(25, 3, ': ' . $perjalanan['cekkembali'], 0, 1);


$pdf->Ln(3);

$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(56, 4, 'Jenis Kendaraan', 1, 0, 'C', 1);
$pdf->Cell(56, 4, 'No. Polisi', 1, 0, 'C', 1);
$pdf->Cell(57, 4, 'Bagian Umum', 1, 1, 'C', 1);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(56, 7, $perjalanan['kepemilikan'], 1, 0, 'C', 1);
$pdf->Cell(56, 7, $perjalanan['nopol'], 1, 0, 'C', 1);
$pdf->Cell(57, 7, $perjalanan['admin_ga'], 1, 1, 'C', 1);

$pdf->Cell(45, -7, '', 0, 0, 'C', 0);
$pdf->Cell(35, -7, '', 0, 0, 'C', 0);
$pdf->Cell(45, -7, '', 0, 0, 'C', 0);

$pdf->Ln(1);
$reservasi = $this->db->get_where('reservasi', ['id' => $perjalanan['reservasi_id']])->row_array();

$pdf->Cell(17, 5, 'Keterangan', 0, 0);
$pdf->Cell(115, 5, ': ' . $perjalanan['catatan_ga'] . ' ' . $perjalanan['catatan_security'], 0, 0);

// $pdf->Cell(1, 5, '', 0, 1);

$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(170, 5, 'TRANSPORTASI & UANG MAKAN', 0, 1, 'C');

$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(7, 4, 'NO', 1, 0, 'C', 1);
$pdf->Cell(41, 4, 'Nama', 1, 0, 'C', 1);
$pdf->Cell(21, 4, 'Makan Siang', 1, 0, 'C', 1);
$pdf->Cell(21, 4, 'Makan Malam', 1, 0, 'C', 1);
$pdf->Cell(21, 4, 'Insentif Subuh', 1, 0, 'C', 1);
$pdf->Cell(21, 4, 'Biaya Lain', 1, 0, 'C', 1);
$pdf->Cell(37, 4, 'TOTAL', 1, 1, 'C', 1);

$pdf->SetFont('Arial', 'B', 7);

$peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $perjalanan['id']])->result_array();
$no = 1;
foreach ($peserta as $p) :

$pdf->Cell(7, 4, $no, 1, 0, 'C', 1);
$pdf->Cell(41, 4, $p['karyawan_nama'], 1, 0, 'C', 1);
$pdf->Cell(21, 4, $perjalanan['um3'], 1, 0, 'C', 1);
$pdf->Cell(21, 4, $perjalanan['um4'], 1, 0, 'C', 1);
$pdf->Cell(21, 4, $perjalanan['um1'], 1, 0, 'C', 1);
$pdf->Cell(21, 4, '', 1, 0, 'C', 1);
$pdf->Cell(37, 4, '', 1, 1, 'C', 1);

$no = $no + 1;

endforeach;

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(33, 4, 'Taksi*', 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'BBM*', 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'Tol*', 1, 0, 'C', 1);
$pdf->Cell(33, 4, 'Parkir*', 1, 0, 'C', 1);
$pdf->Cell(37, 4, 'TOTAL', 1, 1, 'C', 1);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(33, 5, '', 1, 0, 'C', 1);
$pdf->Cell(33, 5, '', 1, 0, 'C', 1);
$pdf->Cell(33, 5, '', 1, 0, 'C', 1);
$pdf->Cell(33, 5, '', 1, 0, 'C', 1);
$pdf->Cell(37, 5, '', 1, 1, 'C', 1);

$pdf->Ln(3);
$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(85, 3, 'Disetujui Oleh ,', 1, 0, 'C', 1);
$pdf->Cell(42, 3, 'Diperiksa Oleh ,', 1, 0, 'C', 1);
$pdf->Cell(42, 3, 'Dibuat Oleh ,', 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(43, 13, '', 1, 0, 'C', 1);
$pdf->Cell(42, 13, '', 1, 0, 'C', 1);
$pdf->Cell(42, 13, '', 1, 0, 'C', 1);
$pdf->Cell(42, 13, '', 1, 1, 'C', 1);

$pdf->Cell(43, 4, 'Atasan', 1, 0, 'C', 1);
$pdf->Cell(42, 4, 'KA.Dept', 1, 0, 'C', 1);
$pdf->Cell(42, 4, 'GA', 1, 0, 'C', 1);
$pdf->Cell(42, 4, 'Pemohon', 1, 1, 'C', 1);

$pdf->Ln(-16);
$pdf->SetFont('arial-monospaced', '', 5);
$pdf->Cell(77, 3, 'Ini adalah form digital', 0,'C', 0);
$pdf->Cell(6.5, 8, 'Tidak memerlukan tanda tangan basah', 0,'C', 0);

$pdf->Cell(80, 3, 'Ini adalah form digital', 0,'C', 0);
$pdf->Cell(4, 8, 'Tidak memerlukan tanda tangan basah', 0,'C', 0);


$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(55, 5,'',0,0,'C',0);
$pdf->Cell(20, 5, $perjalanan['ka_dept'], 0, 0, 'C',0);
$pdf->Cell(65, 5,'',0,0,'C',0);
$pdf->Cell(20, 5, $perjalanan['nama'], 0, 1, 'C');

$pdf->Ln(-2);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(55, 5, '', 110, 0);
$pdf->Cell(20, 5, 'Disetujui pada ' . date('d/m/Y H:i', strtotime($reservasi['tgl_atasan2'])), 110, 0, 'C');
$pdf->Cell(65, 5,'',0,0,'C',0);
$pdf->Cell(20, 5, 'Dibuat pada ' . date('d/m/Y H:i', strtotime($reservasi['tglreservasi'])), 110, 0, 'C');

$pdf->Ln(8.5);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(32, 2, '(*) Di isi Manual', 0, 1);
$pdf->SetFont('Arial', '', 4);
$pdf->Ln(1);
$pdf->Cell(32, 2, '(*) Di isi Manual', 0, 1);
$pdf->Cell(32, 2, '(*) Di isi Manual', 0, 1);
$pdf->Cell(32, 2, '(*) Di isi Manual', 0, 1);
$pdf->Cell(32, 2, '(*) Di isi Manual', 0, 1);
$pdf->Cell(32, 2, '(*) Di isi Manual', 0, 1);




//$pdf->Output();
//OUTPUT SET FILENAME DOWNLOAD
$pdf->Output('I', 'SURAT_TUGAS_KELUAR_' . $perjalanan['id'] . '.pdf');
