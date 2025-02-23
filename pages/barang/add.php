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
        echo "Data berhasil ditambahkan!";
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan data!";
    }
}
?>

<?php
$query = "SELECT kode_pemasok, nama_pemasok FROM pemasok";
$result = mysqli_query($conn, $query);
?>

<h2>Tambah Barang</h2>
<form method="POST">
    <label for="kode_barang">Kode Barang:</label>
    <input type="text" name="kode_barang" required><br>

    <label for="nama_barang">Nama Barang:</label>
    <input type="text" name="nama_barang" required><br>

    <label for="satuan">Satuan:</label>
    <input type="text" name="satuan" required><br>

    <label for="harga_beli">Harga Beli:</label>
    <input type="number" name="harga_beli" required><br>

    <label for="harga_jual">Harga Jual:</label>
    <input type="number" name="harga_jual" required><br>

    <label for="jumlah_barang">Jumlah Barang:</label>
    <input type="number" name="jumlah_barang" required><br>

    <label for="jumlah_minimum">Jumlah Minimum:</label>
    <input type="number" name="jumlah_minimum" required><br>

    <label for="kode_pemasok">Kode Pemasok:</label>
    <select name="kode_pemasok" id="kode_pemasok" required onchange="getPemasokData()">
        <option value="">-- Pilih Pemasok --</option>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['kode_pemasok']}'>{$row['kode_pemasok']} - {$row['nama_pemasok']}</option>";
        }
        ?>
    </select><br>

    <label for="nama_pemasok">Nama Pemasok:</label>
    <input type="text" id="nama_pemasok" readonly><br>

    <label for="orang_hubungi">Orang yang Dihubungi:</label>
    <input type="text" id="orang_hubungi" readonly><br>

    <label for="telepon_pemasok">No Telepon:</label>
    <input type="text" id="telepon_pemasok" readonly><br>

    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>

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