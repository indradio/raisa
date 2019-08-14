<?php
$pdf = new FPDF('L', 'mm', 'A5');
$pdf->SetMargins(20, 0);
// membuat halaman baru
$pdf->AddPage();
// setting jenis font yang akan digunakan
// mencetak string 
$pdf->Image('assets/img/WINTEQ8.jpg', 15, 5, 50, 0);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(170, 35, 'SURAT TUGAS KELUAR KANTOR', 0, 1, 'C');

//MEMEBERIKAN LINE/GARIS DENGAN MARGIN 20 (210-20) 
$pdf->line(71, 20, 210 - 71, 20);

$pdf->Ln(-9);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(32, 6, 'NO PERJALANAN', 0, 0, 'L');
$pdf->Cell(9, 6, '            : #' . $perjalanan['id'], 0, 1, 'L');

$pdf->Cell(32, 6, 'NAMA PEMOHON', 0, 0);
$pdf->Cell(9, 6, '            : ' . $perjalanan['nama'], 0, 1);

$user = $this->db->get_where('karyawan', ['npk' => $perjalanan['npk']])->row_array();
$dept = $this->db->get_where('karyawan_dept', ['id' => $user['dept_id']])->row_array();
$sect = $this->db->get_where('karyawan_sect', ['id' => $user['sect_id']])->row_array();

$pdf->Cell(32, 6, 'DEPARTEMENT/SEKSI', 0, 0);
$pdf->Cell(9, 6, '            : ' . $dept['nama'] . ' / ' . $sect['nama'], 0, 1);

$pdf->Cell(32, 6, 'TUJUAN', 0, 0);
$pdf->Cell(9, 6, '            : ' . $perjalanan['tujuan'], 0, 1);

$pdf->Cell(32, 6, 'KEPERLUAN', 0, 0);
$pdf->Cell(9, 6, '            : ' . $perjalanan['keperluan'], 0, 1);

$pdf->Cell(32, 6, 'PENUMPANG', 0, 0);
$pdf->Cell(9, 6, '            : ' . $perjalanan['anggota'], 0, 1);

//BERANGKAT
$pdf->Cell(35, 6, 'BERANGKAT*', 0, 0);
$pdf->Cell(9, 6, '' . 'Tgl', 0, 0);
$pdf->Cell(28, 6, ': ' . date('d/m/Y', strtotime($perjalanan['tglberangkat'])), 0, 0);

$pdf->Cell(9, 6, 'Jam', 0, 0);
$pdf->Cell(28, 6, ': ' . date('H:i', strtotime($perjalanan['jamberangkat'])), 0, 0);

$pdf->Cell(9, 6, 'Km', 0, 0);
$pdf->Cell(20, 6, ': ' . $perjalanan['kmberangkat'], 0, 0);

$pdf->Cell(15, 6, 'Security', 0, 0);
$pdf->Cell(25, 6, ': ' . $perjalanan['cekberangkat'], 0, 1);

//KEMBALI
$pdf->Cell(35, 6, 'KEMBALI*', 0, 0);
$pdf->Cell(9, 6, '' . 'Tgl', 0, 0);
$pdf->Cell(28, 6, ': ' . date('d/m/Y', strtotime($perjalanan['tglkembali'])), 0, 0);

$pdf->Cell(9, 6, 'Jam', 0, 0);
$pdf->Cell(28, 6, ': ' . date('H:i', strtotime($perjalanan['jamkembali'])), 0, 0);

$pdf->Cell(9, 6, 'Km', 0, 0);
$pdf->Cell(20, 6, ': ' . $perjalanan['kmkembali'], 0, 0);

$pdf->Cell(15, 6, 'Security', 0, 0);
$pdf->Cell(25, 6, ': ' . $perjalanan['cekkembali'], 0, 1);


$pdf->Ln(3);

$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 7, 'Jenis Kendaraan', 1, 0, 'C', 1);
$pdf->Cell(35, 7, 'No. Polisi', 1, 0, 'C', 1);
$pdf->Cell(44, 7, 'Pengemudi', 1, 0, 'C', 1);
$pdf->Cell(45, 7, 'Bagian Umum', 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 8);
$kend = $this->db->get_where('kendaraan', ['nopol' => $perjalanan['nopol']])->row_array();
$pdf->Cell(45, 15, $kend['nama'] . ' / ' . $perjalanan['kepemilikan'], 1, 0, 'C', 1);
$pdf->Cell(35, 15, $perjalanan['nopol'], 1, 0, 'C', 1);
$pdf->Cell(44, 15, 'BERANGKAT : ' . $perjalanan['supirberangkat'], 1, 0, 'C', 1);
$pdf->Cell(45, 15, $perjalanan['admin_ga'], 1, 1, 'C', 1);

$pdf->Cell(45, -7, '', 0, 0, 'C', 0);
$pdf->Cell(35, -7, '', 0, 0, 'C', 0);
$pdf->Cell(44, -7, 'KEMBALI : ' . $perjalanan['supirkembali'], 0, 0, 'C', 0);
$pdf->Cell(45, -7, '', 0, 0, 'C', 0);

$pdf->Ln(1);
$reservasi = $this->db->get_where('reservasi', ['id' => $perjalanan['reservasi_id']])->row_array();

$pdf->Cell(17, 5, 'Keterangan', 0, 0);
$pdf->Cell(115, 5, ': ' . $perjalanan['catatan_ga'] . ' ' . $perjalanan['catatan_security'], 0, 0);

$pdf->Cell(10, 5, 'Bogor, ', 0, 0);
$pdf->Cell(50, 5, date('d/m/Y', strtotime($reservasi['tglreservasi'])), 0, 1);

$pdf->Ln(1);

$pdf->Cell(90, 5, '', 110, 0);
$pdf->Cell(30, 5, 'KA. DIV / KA DEPT', 110, 0, 'C');
$pdf->Cell(50, 5, 'PEMOHON', 0, 1, 'C');
$pdf->Cell(82, 5, '', 0, 0);
$pdf->Cell(32, 5, 'Disetujui pada ' . date('d/m/Y H:i', strtotime($reservasi['tgl_atasan2'])), 0, 1);
$pdf->Cell(79, 5, '', 0, 0);
$pdf->Cell(32, 5, 'Tidak memerlukan tanda tangan basah', 0, 1);

$pdf->Ln(2);

$pdf->Cell(32, 5, 'FR-GA-01.002', 0, 1);

$pdf->Ln(-5);
$pdf->Cell(90, 5, '', 110, 0);
$pdf->Cell(30, 5, $perjalanan['ka_dept'], 110, 0, 'C');
$pdf->Cell(50, 5, $perjalanan['nama'], 0, 1, 'C');



//$pdf->Output();
//OUTPUT SET FILENAME DOWNLOAD
$pdf->Output('I', 'SURAT_TUGAS_KELUAR_' . $perjalanan['id'] . '.pdf');
