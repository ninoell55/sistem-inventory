<?php
include "../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $jumlah_minimum = $_POST['jumlah_minimum'];
    $kode_pemasok = $_POST['kode_pemasok'];

    $query = "INSERT INTO gudang VALUES ('$kode', '$nama', '$satuan', '$harga_beli', '$harga_jual', '$jumlah_barang', '$jumlah_minimum', '$kode_pemasok', NOW())";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-center text-red-500'>Gagal menambahkan data!</p>";
    }
}

$query = "SELECT kode_pemasok, nama_pemasok FROM pemasok";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Tambah Barang</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="kode_barang" placeholder="Kode Barang" required class="w-full p-2 border rounded">
            <input type="text" name="nama_barang" placeholder="Nama Barang" required class="w-full p-2 border rounded">
            <input type="text" name="satuan" placeholder="Satuan" required class="w-full p-2 border rounded">
            <input type="number" name="harga_beli" placeholder="Harga Beli" required class="w-full p-2 border rounded">
            <input type="number" name="harga_jual" placeholder="Harga Jual" required class="w-full p-2 border rounded">
            <input type="number" name="jumlah_barang" placeholder="Jumlah Barang" required class="w-full p-2 border rounded">
            <input type="number" name="jumlah_minimum" placeholder="Jumlah Minimum" required class="w-full p-2 border rounded">

            <select name="kode_pemasok" id="kode_pemasok" required class="w-full p-2 border rounded" onchange="getPemasokData()">
                <option value="">-- Pilih Pemasok --</option>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <option value="<?= $row['kode_pemasok']; ?>">
                        <?= $row['kode_pemasok']; ?> - <?= $row['nama_pemasok']; ?>
                    </option>
                <?php } ?>
            </select>

            <input type="text" id="nama_pemasok" placeholder="Nama Pemasok" readonly class="w-full p-2 bg-gray-200 border rounded">
            <input type="text" id="orang_hubungi" placeholder="Orang yang Dihubungi" readonly class="w-full p-2 bg-gray-200 border rounded">
            <input type="text" id="telepon_pemasok" placeholder="No Telepon" readonly class="w-full p-2 bg-gray-200 border rounded">

            <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
        </form>
        <a href="index.php" class="block mt-4 text-center text-blue-600 hover:underline">Kembali</a>
    </div>

    <script>
        function getPemasokData() {
            var kodePemasok = document.getElementById("kode_pemasok").value;

            if (kodePemasok) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "get_pemasok.php?kode_pemasok=" + kodePemasok, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var data = JSON.parse(xhr.responseText);
                        document.getElementById("nama_pemasok").value = data.nama_pemasok;
                        document.getElementById("orang_hubungi").value = data.orang_hubungi;
                        document.getElementById("telepon_pemasok").value = data.telepon_pemasok;
                    }
                };
                xhr.send();
            } else {
                document.getElementById("nama_pemasok").value = "";
                document.getElementById("orang_hubungi").value = "";
                document.getElementById("telepon_pemasok").value = "";
            }
        }
    </script>
</body>

</html>