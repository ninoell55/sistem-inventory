<?php
require '../../vendor/autoload.php'; // Pastikan TCPDF diinstal melalui Composer
require '../../config/config.php';

// Inisialisasi PDF
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Header
$pdf->Cell(0, 10, 'Laporan Data Gudang', 0, 1, 'C');
$pdf->Ln(5);

// Ambil data dari database
$query = "SELECT g.*, p.nama_pemasok FROM gudang g JOIN pemasok p ON g.kode_pemasok = p.kode_pemasok";
$result = mysqli_query($conn, $query);

// Tabel Header
$html = '<table border="1" cellpadding="5">
    <tr>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Satuan</th>
        <th>Jumlah Barang</th>
        <th>Jumlah Minimum</th>
        <th>Harga Beli</th>
        <th>Harga Jual</th>
        <th>Pemasok</th>
    </tr>';

// Isi data ke dalam tabel
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
        <td>' . $row['kode_barang'] . '</td>
        <td>' . $row['nama_barang'] . '</td>
        <td>' . $row['satuan'] . '</td>
        <td>' . $row['jumlah_barang'] . '</td>
        <td>' . $row['jumlah_minimum'] . '</td>
        <td>' . number_format($row['harga_beli'], 2) . '</td>
        <td>' . number_format($row['harga_jual'], 2) . '</td>
        <td>' . $row['nama_pemasok'] . '</td>
    </tr>';
}
$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('laporan_gudang.pdf', 'D');
exit();