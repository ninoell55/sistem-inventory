<?php
include "../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode_pemasok'];
    $nama = $_POST['nama_pemasok'];
    $alamat = $_POST['alamat_pemasok'];
    $kota = $_POST['kota_pemasok'];
    $telepon = $_POST['telepon_pemasok'];
    $orang_hubungi = $_POST['orang_hubungi'];

    $query = "INSERT INTO pemasok VALUES ('$kode', '$nama', '$alamat', '$kota', '$telepon', '$orang_hubungi')";
    if (mysqli_query($conn, $query)) {
        echo "Data berhasil ditambahkan!";
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan data!";
    }
}
?>

<h2>Tambah Pemasok</h2>
<form method="POST">
    <input type="text" name="kode_pemasok" placeholder="Kode Pemasok" required><br>
    <input type="text" name="nama_pemasok" placeholder="Nama Pemasok" required><br>
    <input type="text" name="alamat_pemasok" placeholder="Alamat" required><br>
    <input type="text" name="kota_pemasok" placeholder="Kota" required><br>
    <input type="text" name="telepon_pemasok" placeholder="Telepon" required><br>
    <input type="text" name="orang_hubungi" placeholder="Orang yang Dihubungi" required><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>