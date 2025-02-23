<?php
include "../../config/config.php";

$kode = $_GET['kode'];
$query = "SELECT * FROM konsumen WHERE kode_konsumen='$kode'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_konsumen'];
    $alamat = $_POST['alamat_konsumen'];
    $kota = $_POST['kota_konsumen'];
    $telepon = $_POST['telepon_konsumen'];

    $update = "UPDATE konsumen SET nama_konsumen='$nama', alamat_konsumen='$alamat', kota_konsumen='$kota', telepon_konsumen='$telepon' WHERE kode_konsumen='$kode'";

    if (mysqli_query($conn, $update)) {
        header("Location: index.php");
    } else {
        echo "Gagal memperbarui data!";
    }
}
?>

<h2>Edit Konsumen</h2>
<form method="POST">
    <input type="text" name="nama_konsumen" value="<?= $data['nama_konsumen']; ?>" required><br>
    <input type="text" name="alamat_konsumen" value="<?= $data['alamat_konsumen']; ?>" required><br>
    <input type="text" name="kota_konsumen" value="<?= $data['kota_konsumen']; ?>" required><br>
    <input type="text" name="telepon_konsumen" value="<?= $data['telepon_konsumen']; ?>" required><br>
    <button type="submit">Update</button>
</form>
<a href="index.php">Kembali</a>