<?php
include "../../config/config.php"; // Koneksi database

// Ambil data konsumen
$result = mysqli_query($conn, "SELECT * FROM konsumen");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Konsumen</title>
</head>

<body>
    <h2>Data Konsumen</h2>
    <a href="add.php">Tambah Konsumen</a>
    <table border="1">
        <tr>
            <th>Kode Konsumen</th>
            <th>Nama Konsumen</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['kode_konsumen']; ?></td>
                <td><?= $row['nama_konsumen']; ?></td>
                <td><?= $row['alamat_konsumen']; ?></td>
                <td><?= $row['kota_konsumen']; ?></td>
                <td><?= $row['telepon_konsumen']; ?></td>
                <td>
                    <a href="edit.php?kode=<?= $row['kode_konsumen']; ?>">Edit</a> |
                    <a href="delete.php?kode=<?= $row['kode_konsumen']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>