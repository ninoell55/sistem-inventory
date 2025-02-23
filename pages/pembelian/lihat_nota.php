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
        <h2>Nota Pembelian</h2>
        <p><strong>Nota:</strong> <?= $dataPembelian['nota_beli'] ?></p>
        <p><strong>Tanggal:</strong> <?= $dataPembelian['tanggal_beli'] ?></p>
        <p><strong>Pemasok:</strong> <?= $dataPembelian['nama_pemasok'] ?></p>

        <table>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultDetail)) { ?>
                <tr>
                    <td><?= $row['kode_barang'] ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['satuan'] ?></td>
                    <td>Rp<?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                    <td><?= $row['jumlah_beli'] ?></td>
                    <td>Rp<?= number_format($row['total_beli'], 0, ',', '.') ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3>Total: Rp<?= number_format($dataPembelian['total_beli'], 0, ',', '.') ?></h3>

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