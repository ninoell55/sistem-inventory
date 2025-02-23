<?php
include "../../config/config.php";

// Ambil data pemasok
$pemasokQuery = "SELECT * FROM pemasok";
$pemasokResult = mysqli_query($conn, $pemasokQuery);
    
// Ambil data barang dari gudang
$barangQuery = "SELECT * FROM gudang WHERE jumlah_barang > 0"; // Hanya tampilkan barang yang tersedia
$barangResult = mysqli_query($conn, $barangQuery);

// Ambil nota terakhir dengan format yang benar
$query = "SELECT nota_beli FROM pembelian WHERE nota_beli LIKE 'NB-%' ORDER BY CAST(SUBSTRING(nota_beli, 4, 3) AS UNSIGNED) DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {   
    // Ambil angka dari nota terakhir dan tambah 1
    $lastNotaNumber = intval(substr($row['nota_beli'], 3)) + 1;
} else {
    // Jika belum ada transaksi, mulai dari 1
    $lastNotaNumber = 1;
}

// Format nota baru dengan padding 3 digit
$nota_beli = "NB-" . str_pad($lastNotaNumber, 3, "0", STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian Barang</title>
</head>

<body>

    <h2>Form Pembelian Barang</h2>
    <form method="POST" action="process.php">
        <label>Pilih Pemasok:</label>
        <select name="kode_pemasok" required>
            <option value="">-- Pilih Pemasok --</option>
            <?php while ($pemasok = mysqli_fetch_assoc($pemasokResult)) { ?>
                <option value="<?= $pemasok['kode_pemasok']; ?>"><?= $pemasok['nama_pemasok']; ?></option>
            <?php } ?>
        </select><br>

        <label>Nota Pembelian:</label>
        <input type="text" name="nota_beli" value="<?php echo $nota_beli; ?>" readonly><br>

        <table id="table-barang">
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
            <tr>
                <td>
                    <select name="kode_barang[]" class="kode_barang" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php while ($barang = mysqli_fetch_assoc($barangResult)) { ?>
                            <option value="<?= $barang['kode_barang']; ?>"
                                data-nama="<?= $barang['nama_barang']; ?>"
                                data-satuan="<?= $barang['satuan']; ?>"
                                data-harga="<?= $barang['harga_beli']; ?>"
                                data-stok="<?= $barang['jumlah_barang']; ?>">
                                <?= $barang['kode_barang']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="text" name="nama_barang[]" class="nama_barang" readonly></td>
                <td><input type="text" name="satuan[]" class="satuan" readonly></td>
                <td><input type="number" name="stok[]" class="stok" readonly></td>
                <td><input type="number" name="harga_beli[]" class="harga_beli" readonly></td>
                <td><input type="number" name="jumlah_beli[]" class="jumlah_beli" required></td>
                <td><input type="number" name="subtotal[]" class="subtotal" readonly></td>
                <td><button type="button" class="hapus">Hapus</button></td>
            </tr>
        </table>

        <button type="button" id="tambah-barang">Tambah Barang</button><br>

        <p>Total pembelian: <span id="total_display">0</span></p>
        <input type="hidden" name="total_pembelian" id="total_pembelian" value="0">

        <label>Bayar:</label>
        <input type="number" id="bayar" name="bayar" required><br>

        <label>Kembalian:</label>
        <input type="number" id="kembalian" name="kembalian" readonly><br>

        <button type="submit">Simpan pembelian</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Event untuk mengisi otomatis nama barang, harga, stok saat memilih barang
            document.querySelector("#table-barang").addEventListener("change", function(e) {
                if (e.target.classList.contains("kode_barang")) {
                    let selectedOption = e.target.selectedOptions[0];
                    let row = e.target.closest("tr");
                    row.querySelector(".nama_barang").value = selectedOption.dataset.nama;
                    row.querySelector(".satuan").value = selectedOption.dataset.satuan;
                    row.querySelector(".harga_beli").value = selectedOption.dataset.harga;
                    row.querySelector(".stok").value = selectedOption.dataset.stok;
                    hitungSubtotal(row);
                }
            });

            // Event untuk menghitung subtotal saat jumlah barang diubah
            document.querySelector("#table-barang").addEventListener("input", function(e) {
                if (e.target.classList.contains("jumlah_beli")) {
                    let row = e.target.closest("tr");
                    let stok = parseInt(row.querySelector(".stok").value) || 0;
                    let jumlah = parseInt(e.target.value) || 0;

                    hitungSubtotal(row);
                }
            });

            // Fungsi menghitung subtotal per baris
            function hitungSubtotal(row) {
                let harga = parseFloat(row.querySelector(".harga_beli").value) || 0;
                let jumlah = parseInt(row.querySelector(".jumlah_beli").value) || 0;
                let subtotal = harga * jumlah;
                row.querySelector(".subtotal").value = subtotal;

                hitungTotal();
            }

            // Fungsi menghitung total pembelian
            function hitungTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(function(input) {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('total_pembelian').value = total;
                document.getElementById('total_display').textContent = total;
            }

            // Event untuk menghitung kembalian
            document.getElementById("bayar").addEventListener("input", function() {
                let total = parseFloat(document.getElementById('total_pembelian').value) || 0;
                let bayar = parseFloat(this.value) || 0;
                let kembalian = bayar - total;
                document.getElementById("kembalian").value = kembalian < 0 ? 0 : kembalian;
            });

            // Tombol tambah barang (menambah baris baru)
            document.getElementById("tambah-barang").addEventListener("click", function() {
                let row = document.querySelector("#table-barang tr:last-child").cloneNode(true);
                document.querySelector("#table-barang").appendChild(row);
            });

            // Tombol hapus barang (jangan hapus jika hanya tersisa satu baris)
            document.querySelector("#table-barang").addEventListener("click", function(e) {
                if (e.target.classList.contains("hapus")) {
                    let rows = document.querySelectorAll("#table-barang tr").length;
                    if (rows > 2) { // Minimal harus ada satu baris selain header
                        e.target.closest("tr").remove();
                        hitungTotal();
                    } else {
                        alert("Minimal harus ada satu barang!");
                    }
                }
            });
        });
    </script>

</body>

</html>