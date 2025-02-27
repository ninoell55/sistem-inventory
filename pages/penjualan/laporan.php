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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <?php include "../../includes/sidebar.php"; ?>

    <div class="flex-1 p-6 bg-white shadow-md">
        <h2 class="mb-4 text-2xl font-bold">Laporan Penjualan</h2>

        <form method="GET" action="" class="flex flex-wrap gap-2 mb-4">
            <input type="date" name="tanggal_mulai" required class="p-2 border rounded">
            <input type="date" name="tanggal_selesai" required class="p-2 border rounded">
            <select name="kode_konsumen" class="p-2 border rounded">
                <option value="">Semua Konsumen</option>
                <?php
                $konsumenQuery = mysqli_query($conn, "SELECT * FROM konsumen");
                while ($k = mysqli_fetch_assoc($konsumenQuery)) {
                    echo "<option value='{$k['kode_konsumen']}'>{$k['nama_konsumen']}</option>";
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
                        <th class="p-2 border">Konsumen</th>
                        <th class="p-2 border">Total</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPendapatan = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $totalPendapatan += $row['total_jual'];
                    ?>
                        <tr class="hover:bg-gray-100">
                            <td class="p-2 border"><?= $row['nota_jual'] ?></td>
                            <td class="p-2 border"><?= $row['tanggal_jual'] ?></td>
                            <td class="p-2 border"><?= $row['nama_konsumen'] ?></td>
                            <td class="p-2 border">Rp<?= number_format($row['total_jual'], 0, ',', '.') ?></td>
                            <td class="p-2 border"><a target="_blank" href="lihat_nota.php?nota_jual=<?= $row['nota_jual'] ?>" class="text-blue-500 hover:underline">Lihat Nota</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h3 class="mt-4 text-lg font-bold">Total Pendapatan: Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></h3>
        <!-- <button onclick="window.print()" class="px-4 py-2 mt-4 text-white bg-green-500 rounded hover:bg-green-600">Cetak Laporan</button> -->
    </div>
</body>

</html>