<?php
include "../../config/config.php";

if (!isset($_GET['nota_beli'])) {
    die("Nota tidak ditemukan!");
}

$nota_beli = $_GET['nota_beli'];
$print = isset($_GET['print']) ? true : false;

// Ambil data pembelian berdasarkan nota_beli
$queryPembelian = "SELECT p.*, ps.nama_pemasok 
                   FROM pembelian p
                   JOIN pemasok ps ON p.kode_pemasok = ps.kode_pemasok
                   WHERE p.nota_beli = '$nota_beli'";
$resultPembelian = mysqli_query($conn, $queryPembelian);
$dataPembelian = mysqli_fetch_assoc($resultPembelian);

if (!$dataPembelian) {
    die("Nota tidak ditemukan!");
}

// Ambil detail barang yang dibeli dalam nota ini
$queryDetail = "SELECT d.*, g.nama_barang, g.satuan 
                FROM detail_pembelian d
                JOIN gudang g ON d.kode_barang = g.kode_barang
                WHERE d.nota_beli = '$nota_beli'";
$resultDetail = mysqli_query($conn, $queryDetail);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Nota Pembelian</h2>
        <div class="mb-4">
            <p><strong>Nota:</strong> <?= $dataPembelian['nota_beli'] ?></p>
            <p><strong>Tanggal:</strong> <?= $dataPembelian['tanggal_beli'] ?></p>
            <p><strong>Pemasok:</strong> <?= $dataPembelian['nama_pemasok'] ?></p>
        </div>

        <table class="w-full border border-collapse border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Kode Barang</th>
                    <th class="p-2 border">Nama Barang</th>
                    <th class="p-2 border">Satuan</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultDetail)) { ?>
                    <tr class="hover:bg-gray-100">
                        <td class="p-2 border"><?= $row['kode_barang'] ?></td>
                        <td class="p-2 border"><?= $row['nama_barang'] ?></td>
                        <td class="p-2 border"><?= $row['satuan'] ?></td>
                        <td class="p-2 border">Rp<?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                        <td class="p-2 border"><?= $row['jumlah_beli'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3 class="mt-4 text-xl font-bold">Total: Rp<?= number_format($dataPembelian['total_beli'], 0, ',', '.') ?></h3>

        <div class="mt-4 space-x-2">
            <button onclick="window.print()" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Print Nota</button>
            <button onclick="window.close()" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">Tutup</button>
        </div>
    </div>

    <?php if ($print) {
        echo "<script>window.print();</script>";
    } ?>
</body>

</html>