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
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex bg-gray-100">
    <!-- Sidebar -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- Konten Utama -->
    <div class="flex-1 p-6">
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-2xl font-bold">Laporan Data Gudang</h2>

            <form method="GET" class="flex flex-wrap gap-4 mb-4">
                <input type="text" name="search" placeholder="Cari Kode/Nama Barang" value="<?= htmlspecialchars($search); ?>" class="w-full p-2 border rounded md:w-1/3">
                <input type="date" name="start_date" value="<?= htmlspecialchars($dateFrom); ?>" class="w-full p-2 border rounded md:w-1/4">
                <input type="date" name="end_date" value="<?= htmlspecialchars($dateTo); ?>" class="w-full p-2 border rounded md:w-1/4">
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Cari</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full border border-collapse border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Kode Barang</th>
                            <th class="p-2 border">Nama Barang</th>
                            <th class="p-2 border">Satuan</th>
                            <th class="p-2 border">Jumlah Barang</th>
                            <th class="p-2 border">Jumlah Minimum</th>
                            <th class="p-2 border">Harga Beli</th>
                            <th class="p-2 border">Harga Jual</th>
                            <th class="p-2 border">Pemasok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="border">
                                <td class="p-2 border"><?= $row['kode_barang']; ?></td>
                                <td class="p-2 border"><?= $row['nama_barang']; ?></td>
                                <td class="p-2 border"><?= $row['satuan']; ?></td>
                                <td class="p-2 border"><?= $row['jumlah_barang']; ?></td>
                                <td class="p-2 border"><?= $row['jumlah_minimum']; ?></td>
                                <td class="p-2 border">Rp <?= number_format($row['harga_beli'], 2); ?></td>
                                <td class="p-2 border">Rp <?= number_format($row['harga_jual'], 2); ?></td>
                                <td class="p-2 border"><?= $row['nama_pemasok']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <!-- <a href="export_pdf.php" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Export PDF</a>
                <a href="export_csv.php" class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">Export CSV</a> -->
            </div>
        </div>
    </div>
</body>

</html>