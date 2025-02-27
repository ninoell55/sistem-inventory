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
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-red-500'>Gagal menambahkan data!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemasok</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Tambah Pemasok</h2>
        <form method="POST" class="space-y-4">  
            <input type="text" name="kode_pemasok" placeholder="Kode Pemasok" required class="w-full p-2 border rounded">
            <input type="text" name="nama_pemasok" placeholder="Nama Pemasok" required class="w-full p-2 border rounded">
            <input type="text" name="alamat_pemasok" placeholder="Alamat" required class="w-full p-2 border rounded">
            <input type="text" name="kota_pemasok" placeholder="Kota" required class="w-full p-2 border rounded">
            <input type="text" name="telepon_pemasok" placeholder="Telepon" required class="w-full p-2 border rounded">
            <input type="text" name="orang_hubungi" placeholder="Orang yang Dihubungi" required class="w-full p-2 border rounded">
            <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
        </form>
        <a href="index.php" class="block mt-4 text-center text-blue-600 hover:underline">Kembali</a>
    </div>
</body>

</html>