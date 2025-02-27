<?php
include "../../config/config.php";

// Ambil data barang
$result = mysqli_query($conn, "SELECT * FROM gudang");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Barang</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include '../../includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="flex-1 p-10">
            <h2 class="mb-5 text-3xl font-semibold">Data Barang</h2>
            <a href="add.php" class="inline-block px-4 py-2 mb-4 text-white bg-green-500 rounded hover:bg-green-600">Tambah Barang</a>
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <table border="1" class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 border">Kode Barang</th>
                            <th class="px-4 py-2 border">Nama Barang</th>
                            <th class="px-4 py-2 border">Satuan</th>
                            <th class="px-4 py-2 border">Harga Beli</th>
                            <th class="px-4 py-2 border">Harga Jual</th>
                            <th class="px-4 py-2 border">Jumlah</th>
                            <th class="px-4 py-2 border">Minimum Stok</th>
                            <th class="px-4 py-2 border">Kode Pemasok</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-2 text-center border"><?= $row['kode_barang']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['nama_barang']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['satuan']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['harga_beli']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['harga_jual']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['jumlah_barang']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['jumlah_minimum']; ?></td>
                                <td class="px-4 py-2 text-center border"><?= $row['kode_pemasok']; ?></td>
                                <td class="px-4 py-2 text-center border">
                                    <a class="text-blue-500 hover:underline" href="edit.php?kode=<?= $row['kode_barang']; ?>">Edit</a> |
                                    <a class="text-red-500 hover:underline" href="delete.php?kode=<?= $row['kode_barang']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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