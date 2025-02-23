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
</head>

<body>
    <h2>Data Barang</h2>
    <a href="add.php">Tambah Barang</a>
    <table border="1">
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Jumlah</th>
            <th>Minimum Stok</th>
            <th>Kode Pemasok</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>    
                <td><?= $row['kode_barang']; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['satuan']; ?></td>
                <td><?= $row['harga_beli']; ?></td>
                <td><?= $row['harga_jual']; ?></td>
                <td><?= $row['jumlah_barang']; ?></td>
                <td><?= $row['jumlah_minimum']; ?></td>
                <td><?= $row['kode_pemasok']; ?></td>
                <td>
                    <a href="edit.php?kode=<?= $row['kode_barang']; ?>">Edit</a> |
                    <a href="delete.php?kode=<?= $row['kode_barang']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>     