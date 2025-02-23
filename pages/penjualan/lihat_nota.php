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
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid black;
        }

        .hidden-print {
            margin-top: 20px;
        }

        @media print {
            .hidden-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Nota Penjualan</h2>
        <p><strong>Nota:</strong> <?= $dataPenjualan['nota_jual'] ?></p>
        <p><strong>Tanggal:</strong> <?= $dataPenjualan['tanggal_jual'] ?></p>
        <p><strong>Konsumen:</strong> <?= $dataPenjualan['nama_konsumen'] ?></p>

        <table>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultDetail)) { ?>
                <tr>
                    <td><?= $row['kode_barang'] ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['satuan'] ?></td>
                    <td>Rp<?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                    <td><?= $row['jumlah_jual'] ?></td>
                    <td>Rp<?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3>Total: Rp<?= number_format($dataPenjualan['total_jual'], 0, ',', '.') ?></h3>

        <div class="hidden-print">
            <button onclick="window.print()">Print Nota</button>
            <button onclick="window.close()">Tutup</button>
        </div>
    </div>

    <?php if ($print) {
        echo "<script>window.print();</script>";
    } ?>

</body>

</html>