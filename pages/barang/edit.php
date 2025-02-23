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

// Ambil data pemasok untuk dropdown
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

    // Ambil data pemasok berdasarkan kode yang dipilih
    $nama_pemasok = $pemasokList[$kode_pemasok]['nama_pemasok'];
    $orang_hubungi = $pemasokList[$kode_pemasok]['orang_hubungi'];
    $telepon_pemasok = $pemasokList[$kode_pemasok]['telepon_pemasok'];

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
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<h2>Edit Barang</h2>
<form method="POST">
    <label>Nama Barang:</label>
    <input type="text" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']); ?>" required><br>

    <label>Satuan:</label>
    <input type="text" name="satuan" value="<?= htmlspecialchars($data['satuan']); ?>" required><br>

    <label>Harga Beli:</label>
    <input type="number" name="harga_beli" value="<?= htmlspecialchars($data['harga_beli']); ?>" required><br>

    <label>Harga Jual:</label>
    <input type="number" name="harga_jual" value="<?= htmlspecialchars($data['harga_jual']); ?>" required><br>

    <label>Jumlah Barang:</label>
    <input type="number" name="jumlah_barang" value="<?= htmlspecialchars($data['jumlah_barang']); ?>" required><br>

    <label>Jumlah Minimum:</label>
    <input type="number" name="jumlah_minimum" value="<?= htmlspecialchars($data['jumlah_minimum']); ?>" required><br>

    <label>Kode Pemasok:</label>
    <select name="kode_pemasok" id="kode_pemasok" required>
        <option value="">-- Pilih Pemasok --</option>
        <?php foreach ($pemasokList as $kode => $pemasok) : ?>
            <option value="<?= $kode; ?>" <?= ($kode == $data['kode_pemasok']) ? 'selected' : ''; ?>>
                <?= $kode; ?> - <?= $pemasok['nama_pemasok']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Nama Pemasok:</label>
    <input type="text" id="nama_pemasok" value="<?= htmlspecialchars($pemasokList[$data['kode_pemasok']]['nama_pemasok']); ?>" readonly><br>

    <label>Orang yang Dihubungi:</label>
    <input type="text" id="orang_hubungi" value="<?= htmlspecialchars($pemasokList[$data['kode_pemasok']]['orang_hubungi']); ?>" readonly><br>

    <label>Telepon Pemasok:</label>
    <input type="text" id="telepon_pemasok" value="<?= htmlspecialchars($pemasokList[$data['kode_pemasok']]['telepon_pemasok']); ?>" readonly><br>

    <button type="submit">Update</button>
</form>

<a href="index.php">Kembali</a>

<script>
    // Simpan data pemasok dalam JavaScript
    let pemasokData = <?= json_encode($pemasokList); ?>;

    document.getElementById("kode_pemasok").addEventListener("change", function() {
        let kodePemasok = this.value;
        if (pemasokData[kodePemasok]) {
            document.getElementById("nama_pemasok").value = pemasokData[kodePemasok].nama_pemasok;
            document.getElementById("orang_hubungi").value = pemasokData[kodePemasok].orang_hubungi;
            document.getElementById("telepon_pemasok").value = pemasokData[kodePemasok].telepon_pemasok;
        } else {
            document.getElementById("nama_pemasok").value = "";
            document.getElementById("orang_hubungi").value = "";
            document.getElementById("telepon_pemasok").value = "";
        }
    });
</script>