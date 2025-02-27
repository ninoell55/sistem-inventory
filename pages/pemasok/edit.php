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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Edit Pemasok</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="nama_pemasok" class="w-full p-2 border rounded" value="<?= $data['nama_pemasok']; ?>" required><br>
            <input type="text" name="alamat_pemasok" class="w-full p-2 border rounded" value="<?= $data['alamat_pemasok']; ?>" required><br>
            <input type="text" name="kota_pemasok" class="w-full p-2 border rounded" value="<?= $data['kota_pemasok']; ?>" required><br>
            <input type="text" name="telepon_pemasok" class="w-full p-2 border rounded" value="<?= $data['telepon_pemasok']; ?>" required><br>
            <input type="text" name="orang_hubungi" class="w-full p-2 border rounded" value="<?= $data['orang_hubungi']; ?>" required><br>
            <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded hover:bg-blue-700">Update</button>
        </form>
        <a href="index.php" class="block mt-4 text-center text-blue-600 hover:underline">Kembali</a>
    </div>
</body>

</html>