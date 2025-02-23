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
</head>

<body>
    <h2>Data Pemasok</h2>
    <a href="add.php">Tambah Pemasok</a>
    <table border="1">
        <tr>
            <th>Kode Pemasok</th>
            <th>Nama Pemasok</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Telepon</th>
            <th>Orang yang Dihubungi</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['kode_pemasok']; ?></td>
                <td><?= $row['nama_pemasok']; ?></td>
                <td><?= $row['alamat_pemasok']; ?></td>
                <td><?= $row['kota_pemasok']; ?></td>
                <td><?= $row['telepon_pemasok']; ?></td>
                <td><?= $row['orang_hubungi']; ?></td>
                <td>
                    <a href="edit.php?kode=<?= $row['kode_pemasok']; ?>">Edit</a> |
                    <a href="delete.php?kode=<?= $row['kode_pemasok']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>