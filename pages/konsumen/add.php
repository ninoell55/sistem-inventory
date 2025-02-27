<?php
include "../../config/config.php"; // Koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode_konsumen'];
    $nama = $_POST['nama_konsumen'];
    $alamat = $_POST['alamat_konsumen'];
    $kota = $_POST['kota_konsumen'];
    $telepon = $_POST['telepon_konsumen'];

    $query = "INSERT INTO konsumen VALUES ('$kode', '$nama', '$alamat', '$kota', '$telepon')";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else
        echo "<p class='text-center text-red-500'>Gagal menambahkan data!</p>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Konsumen</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Tambah Konsumen</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="kode_konsumen" placeholder="Kode Konsumen" required class="w-full p-2 border rounded">
            <input type="text" name="nama_konsumen" placeholder="Nama Konsumen" required class="w-full p-2 border rounded">
            <input type="text" name="alamat_konsumen" placeholder="Alamat" required class="w-full p-2 border rounded">
            <input type="text" name="kota_konsumen" placeholder="Kota" required class="w-full p-2 border rounded">
            <input type="text" name="telepon_konsumen" placeholder="Telepon" required class="w-full p-2 border rounded">

            <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
        </form>
        <a href="index.php" class="block mt-4 text-center text-blue-600 hover:underline">Kembali</a>
    </div>
</body>

</html>