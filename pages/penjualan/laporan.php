<?php
include "../../config/config.php";

// Filter berdasarkan tanggal atau konsumen
$where = "";
if (isset($_GET['tanggal_mulai']) && isset($_GET['tanggal_selesai'])) {
    $tanggal_mulai = $_GET['tanggal_mulai'];
    $tanggal_selesai = $_GET['tanggal_selesai'];
    $where .= " AND p.tanggal_jual BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}
if (isset($_GET['kode_konsumen']) && $_GET['kode_konsumen'] != '') {
    $kode_konsumen = $_GET['kode_konsumen'];
    $where .= " AND p.kode_konsumen = '$kode_konsumen'";
}

$query = "SELECT p.nota_jual, p.tanggal_jual, k.nama_konsumen, p.total_jual 
          FROM penjualan p
          JOIN konsumen k ON p.kode_konsumen = k.kode_konsumen
          WHERE 1=1 $where 
          ORDER BY p.tanggal_jual DESC";
$result = mysqli_query($conn, $query);

$totalPendapatan = 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
</head>

<body>
    <h2>Laporan Penjualan</h2>
    <form method="GET" action="">
        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" required>
        <label>Tanggal Selesai:</label>
        <input type="date" name="tanggal_selesai" required>
        <label>Pilih Konsumen:</label>
        <select name="kode_konsumen">
            <option value="">Semua Konsumen</option>
            <?php
            $konsumenQuery = mysqli_query($conn, "SELECT * FROM konsumen");
            while ($k = mysqli_fetch_assoc($konsumenQuery)) {
                echo "<option value='{$k['kode_konsumen']}'>{$k['nama_konsumen']}</option>";
            }
            ?>
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <table border="1">
        <tr>
            <th>Nota</th>
            <th>Tanggal</th>
            <th>Konsumen</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['nota_jual'] ?></td>
                <td><?= $row['tanggal_jual'] ?></td>
                <td><?= $row['nama_konsumen'] ?></td>
                <td>Rp<?= number_format($row['total_jual'], 0, ',', '.') ?></td>
                <td><a target="_blank" href="lihat_nota.php?nota_jual=<?= $row['nota_jual'] ?>">Lihat Nota</a></td>
            </tr>
            <?php $totalPendapatan += $row['total_jual']; ?>
        <?php } ?>
    </table>

    <h3>Total Pendapatan: Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></h3>
    <button onclick="window.print()">Cetak Laporan</button>
</body>

</html>