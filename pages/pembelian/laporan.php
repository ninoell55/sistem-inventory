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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <?php include "../../includes/sidebar.php"; ?>

    <div class="flex-1 p-6 bg-white shadow-md">
        <h2 class="mb-4 text-2xl font-bold">Laporan Pembelian</h2>

        <form method="GET" action="" class="flex flex-wrap gap-2 mb-4">
            <input type="date" name="tanggal_mulai" required class="p-2 border rounded">
            <input type="date" name="tanggal_selesai" required class="p-2 border rounded">
            <select name="kode_pemasok" class="p-2 border rounded">
                <option value="">Semua Pemasok</option>
                <?php
                $pemasokQuery = mysqli_query($conn, "SELECT * FROM pemasok");
                while ($p = mysqli_fetch_assoc($pemasokQuery)) {
                    echo "<option value='{$p['kode_pemasok']}'>{$p['nama_pemasok']}</option>";
                }
                ?>
            </select>
            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Tampilkan</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border border-collapse border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Nota</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Pemasok</th>
                        <th class="p-2 border">Total</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="p-2 border"><?= $row['nota_beli'] ?></td>
                            <td class="p-2 border"><?= $row['tanggal_beli'] ?></td>
                            <td class="p-2 border"><?= $row['nama_pemasok'] ?></td>
                            <td class="p-2 border">Rp<?= number_format($row['total_beli'], 0, ',', '.') ?></td>
                            <td class="p-2 border"><a target="_blank" href="lihat_nota.php?nota_beli=<?= $row['nota_beli'] ?>" class="text-blue-500 hover:underline">Lihat Nota</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- <button onclick="window.print()" class="px-4 py-2 mt-4 text-white bg-green-500 rounded hover:bg-green-600">Cetak Laporan</button> -->
    </div>
</body>

</html>