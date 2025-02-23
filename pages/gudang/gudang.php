<?php
include '../../config/config.php';

// Pencarian
$search = "";
$dateFrom = "";
$dateTo = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $dateFrom = $_GET['start_date'];
    $dateTo = $_GET['end_date'];
}

// Query SQL dengan filter pencarian dan tanggal
$query = "SELECT g.*, p.nama_pemasok FROM gudang g 
          JOIN pemasok p ON g.kode_pemasok = p.kode_pemasok
          WHERE (g.kode_barang LIKE '%$search%' OR g.nama_barang LIKE '%$search%')";

if (!empty($dateFrom) && !empty($dateTo)) {
    $query .= " AND g.tanggal_data BETWEEN '$dateFrom' AND '$dateTo'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Gudang</title>
</head>

<body>
    <h2>Laporan Data Gudang</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Cari Kode/Nama Barang" value="<?= htmlspecialchars($search); ?>"><br><br>

        <label for="start_date">Tanggal Mulai:</label>
        <input type="date" name="start_date" value="<?= htmlspecialchars($dateFrom); ?>"><br><br>

        <label for="end_date">Tanggal Selesai:</label>
        <input type="date" name="end_date" value="<?= htmlspecialchars($dateTo); ?>"><br><br>

        <button type="submit">Cari</button>
    </form>

    <table border="1">
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Jumlah Barang</th>
            <th>Jumlah Minimum</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Pemasok</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['kode_barang']; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['satuan']; ?></td>
                <td><?= $row['jumlah_barang']; ?></td>
                <td><?= $row['jumlah_minimum']; ?></td>
                <td><?= number_format($row['harga_beli'], 2); ?></td>
                <td><?= number_format($row['harga_jual'], 2); ?></td>
                <td><?= $row['nama_pemasok']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <a href="export_pdf.php">Export PDF</a> |
    <a href="export_csv.php">Export CSV</a>
</body>

</html>