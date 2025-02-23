<?php
require '../../config/config.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="laporan_gudang.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Kode Barang', 'Nama Barang', 'Satuan', 'Jumlah Barang', 'Jumlah Minimum', 'Harga Beli', 'Harga Jual', 'Pemasok']);

$query = "SELECT g.*, p.nama_pemasok FROM gudang g 
          JOIN pemasok p ON g.kode_pemasok = p.kode_pemasok";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>