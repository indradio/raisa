<?php
$pdf = new FPDF('L', 'mm', 'A5');
$pdf->SetMargins(15, 10, 10, 5);

$pdf->AddPage();
$pdf->line(10, 5, 210 - 10, 5);
$pdf->line(200, 140, 210 - 10, 5);
$pdf->line(10, 140, 20 - 10, 5);
$pdf->line(10, 140, 210 - 10, 140);

$pdf->Image('assets/img/WINTEQ8.jpg', 15, 6, 40, 0);

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(170, 0, 'SURAT TUGAS', 0, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(170, 5, 'NO PERJALANAN : ' . $perjalanan['id'], 0, 1, 'C');

$pdf->Ln(1);
$pdf->setTextColor(0, 0, 0);
$pdf->setFillColor(255, 255, 255);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(8, 6, 'NO', 1, 0, 'C', 1);
$pdf->Cell(45, 6, 'Nama', 1, 0, 'C', 1);
$pdf->Cell(14, 6, 'NRP', 1, 0, 'C', 1);
$pdf->Cell(40, 6, 'Divisi / Departemen', 1, 0, 'C', 1);
$pdf->Cell(30, 6, 'Jabatan', 1, 0, 'C', 1);
$pdf->Cell(43, 6, 'Travel Dokumen', 1, 0, 'C', 1);
$pdf->Cell(0, 6, '', 0, 1, 0);

$pdf->Cell(8, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(45, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(14, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(40, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(30, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(43, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(0, 0.5, '', 0, 1, 0);

$peserta = $this->db->get_where('perjalanan_anggota', ['perjalanan_id' => $perjalanan['id']])->result_array();
$no = 1;
foreach ($peserta as $p) :

    $pdf->Cell(8, 5, $no, 1, 0, 'C', 1);
    $pdf->Cell(45, 5, $p['karyawan_nama'], 1, 0, 'C', 1);
    $pdf->Cell(14, 5, $p['npk'], 1, 0, 'C', 1);
    $user = $this->db->get_where('karyawan', ['npk' => $p['npk']])->row_array();
    $dept = $this->db->get_where('karyawan_dept', ['id' => $user['dept_id']])->row_array();
    $posisi = $this->db->get_where('karyawan_posisi', ['id' => $user['posisi_id']])->row_array();
    $pdf->Cell(40, 5, $dept['nama'], 1, 0, 'C', 1);
    $pdf->Cell(30, 5, $posisi['nama'], 1, 0, 'C', 1);
    $pdf->Cell(43, 5, '', 1, 0, 'C', 1);
    $pdf->Cell(0, 5, '', 0, 1, 0);

    $no = $no + 1;

endforeach;

$pdf->Ln(2);

$pdf->Cell(32, 3, 'Tujuan', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(3, 3, $perjalanan['tujuan'], 0, 1);

$pdf->Cell(32, 3, 'Keperluan', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(3, 3, $perjalanan['keperluan'], 0, 1);


$pdf->Cell(32, 3, 'Tgl. Berangkat', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['tglberangkat'], 0, 0);

$pdf->Cell(9, 3, 'Jam', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['jamberangkat'], 0, 0);

$pdf->Cell(9, 3, 'Km', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['kmberangkat'], 0, 0);

$pdf->Cell(9, 3, 'Security', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['cekberangkat'], 0, 1);

$pdf->Cell(32, 3, 'Tgl. Kembali', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['tglkembali'], 0, 0);

$pdf->Cell(9, 3, 'Jam', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['jamkembali'], 0, 0);

$pdf->Cell(9, 3, 'Km', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['kmkembali'], 0, 0);

$pdf->Cell(9, 3, 'Security', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['cekkembali'], 0, 1);

$pdf->Ln(2);

$pdf->Cell(50, 6, 'Jenis Kendaraan', 1, 0, 'C', 1);
$pdf->Cell(30, 6, 'No Polisi', 1, 0, 'C', 1);
$pdf->Cell(30, 6, 'Pengemudi', 1, 0, 'C', 0);
$pdf->Cell(30, 6, 'Bagian Umum', 1, 0, 'C', 1);
$pdf->Cell(40, 6, 'Keterangan', 1, 0, 'C', 1);
$pdf->Cell(0, 6, '', 0, 1, 0);

$pdf->Cell(50, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(30, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(30, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(30, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(40, 0.5, '', 1, 0, 'C', 1);
$pdf->Cell(0, 0.5, '', 0, 1, 0);

$kend = $this->db->get_where('kendaraan', ['nopol' => $perjalanan['nopol']])->row_array();
$pdf->Cell(50, 12, $kend['nama'] . ' / ' . $perjalanan['kepemilikan'], 1, 0, 'C', 1);
$pdf->Cell(30, 12, $perjalanan['nopol'], 1, 0, 'C', 1);
$pdf->Cell(30, 12, '', 1, 0, 'C', 1);
$pdf->Cell(30, 12, $perjalanan['admin_ga'], 1, 0, 'C', 1);
$pdf->Cell(40, 12, $perjalanan['catatan_ga'], 1, 0, 'C', 1);
$pdf->Cell(0, 12, '', 0, 1, 0);

$pdf->Ln(1);

$pdf->Cell(32, 3, 'Catatan', 0, 0);
$pdf->Cell(3, 3, ':', 0, 0);
$pdf->Cell(25, 3, $perjalanan['catatan_ga'], 0, 1);

$pdf->Ln(2);

$pdf->Cell(80, 5, 'Disetujui Oleh ,', 1, 0, 'C', 1);
$pdf->Cell(50, 5, 'Diketahui ,', 1, 0, 'C', 1);
$pdf->Cell(50, 5, 'Dibuat Oleh ,', 1, 0, 'C', 0);
$pdf->Cell(0, 5, '', 0, 1, 0);

$pdf->Cell(40, 14, '', 1, 0, 'C', 1);
$pdf->Cell(40, 14, '', 1, 0, 'C', 1);
$pdf->Cell(50, 14, '', 1, 0, 'C', 1);
$pdf->Cell(50, 14, '', 1, 1, 'C', 1);


$pdf->Cell(40, -3, '( Eko Juwono )', 0, 0, 'C', 0);
$pdf->Cell(40, -3, '( Dwi Ayu W. )', 0, 0, 'C', 0);
$pdf->Cell(50, -3, '( ' . $perjalanan['ka_dept'] . ' )', 0, 0, 'C', 0);
$pdf->Cell(50, -3, '( ' . $perjalanan['nama'] . ' )', 0, 0, 'C', 0);
$pdf->Cell(50, 0.1, '', 0, 1, 'C', 0);

$pdf->Cell(40, 4, 'Supp & Adm.Div Head', 1, 0, 'C', 1);
$pdf->Cell(40, 4, 'Fin & Adm.Head', 1, 0, 'C', 1);
$pdf->Cell(50, 4, 'Dept.Head', 1, 0, 'C', 1);
$pdf->Cell(50, 4, 'Pemohon', 1, 1, 'C', 1);


$pdf->Output('I', 'SURAT TUGAS TA' . RAND() . '.pdf');
