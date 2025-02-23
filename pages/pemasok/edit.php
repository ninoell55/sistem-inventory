<?php
include "../../config/config.php";

$kode = $_GET['kode'];
$query = "SELECT * FROM pemasok WHERE kode_pemasok='$kode'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_pemasok'];
    $alamat = $_POST['alamat_pemasok'];
    $kota = $_POST['kota_pemasok'];
    $telepon = $_POST['telepon_pemasok'];
    $orang_hubungi = $_POST['orang_hubungi'];

    $update = "UPDATE pemasok SET nama_pemasok='$nama', alamat_pemasok='$alamat', kota_pemasok='$kota', telepon_pemasok='$telepon', orang_hubungi='$orang_hubungi' WHERE kode_pemasok='$kode'";

    if (mysqli_query($conn, $update)) {
        header("Location: index.php");
    } else {
        echo "Gagal memperbarui data!";
    }
}
?>

<h2>Edit Pemasok</h2>
<form method="POST">
    <input type="text" name="nama_pemasok" value="<?= $data['nama_pemasok']; ?>" required><br>
    <input type="text" name="alamat_pemasok" value="<?= $data['alamat_pemasok']; ?>" required><br>
    <input type="text" name="kota_pemasok" value="<?= $data['kota_pemasok']; ?>" required><br>
    <input type="text" name="telepon_pemasok" value="<?= $data['telepon_pemasok']; ?>" required><br>
    <input type="text" name="orang_hubungi" value="<?= $data['orang_hubungi']; ?>" required><br>
    <button type="submit">Update</button>
</form>
<a href="index.php">Kembali</a>