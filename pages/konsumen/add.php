<?php
include "../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode_konsumen'];
    $nama = $_POST['nama_konsumen'];
    $alamat = $_POST['alamat_konsumen'];
    $kota = $_POST['kota_konsumen'];
    $telepon = $_POST['telepon_konsumen'];

    $query = "INSERT INTO konsumen VALUES ('$kode', '$nama', '$alamat', '$kota', '$telepon')";
    if (mysqli_query($conn, $query)) {
        echo "Data berhasil ditambahkan!";
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan data!";
    }
}
?>

<h2>Tambah Konsumen</h2>
<form method="POST">
    <input type="text" name="kode_konsumen" placeholder="Kode Konsumen" required><br>
    <input type="text" name="nama_konsumen" placeholder="Nama Konsumen" required><br>
    <input type="text" name="alamat_konsumen" placeholder="Alamat" required><br>
    <input type="text" name="kota_konsumen" placeholder="Kota" required><br>
    <input type="text" name="telepon_konsumen" placeholder="Telepon" required><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>