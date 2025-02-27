<?php
include "../config/config.php";

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Query untuk mendapatkan data statistik
$totalBarang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_barang) AS total FROM gudang"))['total'];
$totalPembelian = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_beli) AS total FROM pembelian"))['total'];
$totalPenjualan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_jual) AS total FROM penjualan"))['total'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php' ?>
        
        <!-- Main Content -->
        <div class="flex-1 p-10">
            <h1 class="mb-5 text-3xl font-semibold">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
            <p class="mb-5 text-gray-700">Kelola sistem inventory dengan mudah melalui menu di samping.</p>

            <!-- Card Statistik -->
            <div class="grid grid-cols-3 gap-6">
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Total Barang</h3>
                    <p class="text-2xl font-bold text-blue-600"><?php echo number_format($totalBarang, 0, ',', '.'); ?></p>
                </div>
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Total Pembelian</h3>
                    <p class="text-2xl font-bold text-green-600">Rp <?php echo number_format($totalPembelian, 0, ',', '.'); ?></p>
                </div>
                <div class="p-5 bg-white rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Total Penjualan</h3>
                    <p class="text-2xl font-bold text-yellow-600">Rp <?php echo number_format($totalPenjualan, 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>