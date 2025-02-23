<?php
include "../../config/config.php";

// Filter berdasarkan tanggal atau pemasok
$where = "";
if (isset($_GET['tanggal_mulai']) && isset($_GET['tanggal_selesai'])) {
    $tanggal_mulai = $_GET['tanggal_mulai'];
    $tanggal_selesai = $_GET['tanggal_selesai'];
    $where .= " AND p.tanggal_beli BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}
if (isset($_GET['kode_pemasok']) && $_GET['kode_pemasok'] != '') {
    $kode_pemasok = $_GET['kode_pemasok'];
    $where .= " AND p.kode_pemasok = '$kode_pemasok'";
}

$query = "SELECT p.nota_beli, p.tanggal_beli, ps.nama_pemasok, p.total_beli 
          FROM pembelian p
          JOIN pemasok ps ON p.kode_pemasok = ps.kode_pemasok
          WHERE 1=1 $where 
          ORDER BY p.tanggal_beli DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pembelian</title>
</head>

<body>
    <h2>Laporan Pembelian</h2>
    <form method="GET" action="">
        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" required>
        <label>Tanggal Selesai:</label>
        <input type="date" name="tanggal_selesai" required>
        <label>Pilih Pemasok:</label>
        <select name="kode_pemasok">
            <option value="">Semua Pemasok</option>
            <?php
            $pemasokQuery = mysqli_query($conn, "SELECT * FROM pemasok");
            while ($p = mysqli_fetch_assoc($pemasokQuery)) {
                echo "<option value='{$p['kode_pemasok']}'>{$p['nama_pemasok']}</option>";
            }
            ?>
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <table border="1">
        <tr>
            <th>Nota</th>
            <th>Tanggal</th>
            <th>Pemasok</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['nota_beli'] ?></td>
                <td><?= $row['tanggal_beli'] ?></td>
                <td><?= $row['nama_pemasok'] ?></td>
                <td>Rp<?= number_format($row['total_beli'], 0, ',', '.') ?></td>
                <td><a target="_blank" href="lihat_nota.php?nota_beli=<?= $row['nota_beli'] ?>">Lihat Nota</a></td>
            </tr>
        <?php } ?>
    </table>

    <button onclick="window.print()">Cetak Laporan</button>
</body>

</html>