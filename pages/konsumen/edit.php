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

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Konsumen</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Edit Konsumen</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="nama_konsumen" value="<?= $data['nama_konsumen']; ?>" required class="w-full p-2 border rounded">
            <input type="text" name="alamat_konsumen" value="<?= $data['alamat_konsumen']; ?>" required class="w-full p-2 border rounded">
            <input type="text" name="kota_konsumen" value="<?= $data['kota_konsumen']; ?>" required class="w-full p-2 border rounded">
            <input type="text" name="telepon_konsumen" value="<?= $data['telepon_konsumen']; ?>" required class="w-full p-2 border rounded">

            <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded hover:bg-blue-700">Update</button>
        </form>
        <a href="index.php" class="block mt-4 text-center text-blue-600 hover:underline">Kembali</a>
    </div>
</body>

</html>