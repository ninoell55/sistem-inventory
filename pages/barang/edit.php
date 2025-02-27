<?php
include "../../config/config.php";

// Validasi apakah kode barang ada di URL
if (!isset($_GET['kode']) || empty($_GET['kode'])) {
    echo "<script>alert('Kode barang tidak valid!'); window.location='index.php';</script>";
    exit;
}

$kode = mysqli_real_escape_string($conn, $_GET['kode']);
$query = "SELECT * FROM gudang WHERE kode_barang='$kode'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Jika barang tidak ditemukan
if (!$data) {
    echo "<script>alert('Barang tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// Ambil data pemasok
$pemasokQuery = "SELECT * FROM pemasok";
$pemasokResult = mysqli_query($conn, $pemasokQuery);
$pemasokList = [];
while ($pemasok = mysqli_fetch_assoc($pemasokResult)) {
    $pemasokList[$pemasok['kode_pemasok']] = $pemasok;
}

// Proses Update Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
    $harga_beli = mysqli_real_escape_string($conn, $_POST['harga_beli']);
    $harga_jual = mysqli_real_escape_string($conn, $_POST['harga_jual']);
    $jumlah_barang = mysqli_real_escape_string($conn, $_POST['jumlah_barang']);
    $jumlah_minimum = mysqli_real_escape_string($conn, $_POST['jumlah_minimum']);
    $kode_pemasok = mysqli_real_escape_string($conn, $_POST['kode_pemasok']);

    $update = "UPDATE gudang SET 
                nama_barang='$nama', 
                satuan='$satuan', 
                harga_beli='$harga_beli', 
                harga_jual='$harga_jual', 
                jumlah_barang='$jumlah_barang', 
                jumlah_minimum='$jumlah_minimum', 
                kode_pemasok='$kode_pemasok' 
                WHERE kode_barang='$kode'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<p class='text-center text-red-500'>Gagal memperbarui data!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-bold text-center">Edit Barang</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']); ?>" required class="w-full p-2 border rounded">
            <input type="text" name="satuan" value="<?= htmlspecialchars($data['satuan']); ?>" required class="w-full p-2 border rounded">
            <input type="number" name="harga_beli" value="<?= htmlspecialchars($data['harga_beli']); ?>" required class="w-full p-2 border rounded">
            <input type="number" name="harga_jual" value="<?= htmlspecialchars($data['harga_jual']); ?>" required class="w-full p-2 border rounded">
            <input type="number" name="jumlah_barang" value="<?= htmlspecialchars($data['jumlah_barang']); ?>" required class="w-full p-2 border rounded">
            <input type="number" name="jumlah_minimum" value="<?= htmlspecialchars($data['jumlah_minimum']); ?>" required class="w-full p-2 border rounded">

            <select name="kode_pemasok" id="kode_pemasok" required class="w-full p-2 border rounded" onchange="getPemasokData()">
                <option value="">-- Pilih Pemasok --</option>
                <?php foreach ($pemasokList as $kode => $pemasok) : ?>
                    <option value="<?= $kode; ?>" <?= ($kode == $data['kode_pemasok']) ? 'selected' : ''; ?>>
                        <?= $kode; ?> - <?= $pemasok['nama_pemasok']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="text" id="nama_pemasok" value="<?= htmlspecialchars($pemasokList[$data['kode_pemasok']]['nama_pemasok']); ?>" readonly class="w-full p-2 bg-gray-200 border rounded">
            <input type="text" id="orang_hubungi" value="<?= htmlspecialchars($pemasokList[$data['kode_pemasok']]['orang_hubungi']); ?>" readonly class="w-full p-2 bg-gray-200 border rounded">
            <input type="text" id="telepon_pemasok" value="<?= htmlspecialchars($pemasokList[$data['kode_pemasok']]['telepon_pemasok']); ?>" readonly class="w-full p-2 bg-gray-200 border rounded">

            <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded hover:bg-blue-700">Update</button>
        </form>
        <a href="index.php" class="block mt-4 text-center text-blue-600 hover:underline">Kembali</a>
    </div>

    <script>
        let pemasokData = <?= json_encode($pemasokList); ?>;

        function getPemasokData() {
            let kodePemasok = document.getElementById("kode_pemasok").value;
            if (pemasokData[kodePemasok]) {
                document.getElementById("nama_pemasok").value = pemasokData[kodePemasok].nama_pemasok;
                document.getElementById("orang_hubungi").value = pemasokData[kodePemasok].orang_hubungi;
                document.getElementById("telepon_pemasok").value = pemasokData[kodePemasok].telepon_pemasok;
            } else {
                document.getElementById("nama_pemasok").value = "";
                document.getElementById("orang_hubungi").value = "";
                document.getElementById("telepon_pemasok").value = "";
            }
        }
    </script>
</body>

</html>