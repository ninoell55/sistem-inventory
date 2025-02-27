<?php
include "../../config/config.php";

if (!isset($_GET['nota_jual'])) {
    die("Nota tidak ditemukan!");
}

$nota_jual = $_GET['nota_jual'];
$print = isset($_GET['print']) ? true : false;

// Ambil data penjualan berdasarkan nota_jual
$queryPenjualan = "SELECT p.*, k.nama_konsumen 
                   FROM penjualan p
                   JOIN konsumen k ON p.kode_konsumen = k.kode_konsumen
                   WHERE p.nota_jual = '$nota_jual'";
$resultPenjualan = mysqli_query($conn, $queryPenjualan);
$dataPenjualan = mysqli_fetch_assoc($resultPenjualan);

if (!$dataPenjualan) {
    die("Nota tidak ditemukan!");
}

// Ambil detail barang yang dijual dalam nota ini
$queryDetail = "SELECT d.*, g.nama_barang, g.satuan 
                FROM detail_penjualan d
                JOIN gudang g ON d.kode_barang = g.kode_barang
                WHERE d.nota_jual = '$nota_jual'";
$resultDetail = mysqli_query($conn, $queryDetail);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Nota Penjualan</h2>
        <div class="mb-4">
            <p><strong>Nota:</strong> <?= $dataPenjualan['nota_jual'] ?></p>
            <p><strong>Tanggal:</strong> <?= $dataPenjualan['tanggal_jual'] ?></p>
            <p><strong>Konsumen:</strong> <?= $dataPenjualan['nama_konsumen'] ?></p>
        </div>

        <table class="w-full border border-collapse border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Kode Barang</th>
                    <th class="p-2 border">Nama Barang</th>
                    <th class="p-2 border">Satuan</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultDetail)) { ?>
                    <tr class="hover:bg-gray-100">
                        <td class="p-2 border"><?= $row['kode_barang'] ?></td>
                        <td class="p-2 border"><?= $row['nama_barang'] ?></td>
                        <td class="p-2 border"><?= $row['satuan'] ?></td>
                        <td class="p-2 border">Rp<?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                        <td class="p-2 border"><?= $row['jumlah_jual'] ?></td>
                        <td class="p-2 border">Rp<?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3 class="mt-4 text-xl font-bold">Total: Rp<?= number_format($dataPenjualan['total_jual'], 0, ',', '.') ?></h3>

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