<?php
include "../config/config.php"; // Koneksi database

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php"); // Redirect ke login jika belum login
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Tambahkan CSS jika ada -->
</head>

<body>
    <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>

    <ul>
        <li><a href="pemasok/index.php">Kelola Data Pemasok</a></li>
        <li><a href="barang/index.php">Kelola Data Barang</a></li>
        <li><a href="gudang/gudang.php">Laporan Data Gudang</a></li>
        <li><a href="pembelian/form.php">Form Pembelian Barang</a></li>
        <li><a href="pembelian/laporan.php">Laporan Pembelian Barang</a></li>
        <li><a href="penjualan/form.php">Form Penjualan Barang</a></li>
        <li><a href="penjualan/laporan.php">Laporan Penjualan Barang</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>
</body>

</html>