<?php
include "../../config/config.php"; // Koneksi database

// Ambil data pemasok
$result = mysqli_query($conn, "SELECT * FROM pemasok");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Pemasok</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include '../../includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="flex-1 p-10">
            <h2 class="mb-5 text-3xl font-semibold">Data Pemasok</h2>
            <a href="add.php" class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">Tambah Pemasok</a>
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 border">Kode Pemasok</th>
                            <th class="px-4 py-2 border">Nama Pemasok</th>
                            <th class="px-4 py-2 border">Alamat</th>
                            <th class="px-4 py-2 border">Kota</th>
                            <th class="px-4 py-2 border">Telepon</th>
                            <th class="px-4 py-2 border">Orang yang Dihubungi</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-2 text-center border"><?= $row['kode_pemasok']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['nama_pemasok']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['alamat_pemasok']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['kota_pemasok']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['telepon_pemasok']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['orang_hubungi']; ?></td>
                                <td class="px-4 py-2 text-center border">
                                    <a href="edit.php?kode=<?= $row['kode_pemasok']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                                    <a href="delete.php?kode=<?= $row['kode_pemasok']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>