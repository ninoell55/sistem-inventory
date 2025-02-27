<?php
include "../../config/config.php";

// Ambil data konsumen
$konsumenQuery = "SELECT * FROM konsumen";
$konsumenResult = mysqli_query($conn, $konsumenQuery);

// Ambil data barang dari gudang
$barangQuery = "SELECT * FROM gudang WHERE jumlah_barang > 0";
$barangResult = mysqli_query($conn, $barangQuery);

// Ambil nota terakhir dengan format yang benar
$query = "SELECT nota_jual FROM penjualan WHERE nota_jual LIKE 'NJ-%' ORDER BY CAST(SUBSTRING(nota_jual, 4, 3) AS UNSIGNED) DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $lastNotaNumber = intval(substr($row['nota_jual'], 3)) + 1;
} else {
    $lastNotaNumber = 1;
}

$nota_jual = "NJ-" . str_pad($lastNotaNumber, 3, "0", STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penjualan Barang</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/output.css">
</head>

<body class="flex bg-gray-100">

    <!-- Sidebar -->
    <?php include '../../includes/sidebar.php'; ?>

    <!-- Konten Utama -->
    <div class="flex-1 p-6">
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-2xl font-bold">Form Penjualan Barang</h2>
            <form method="POST" action="process.php" class="space-y-4">
                <div>
                    <label class="block font-medium">Pilih Konsumen:</label>
                    <select name="kode_konsumen" required class="w-full p-2 border rounded">
                        <option value="">-- Pilih Konsumen --</option>
                        <?php while ($konsumen = mysqli_fetch_assoc($konsumenResult)) { ?>
                            <option value="<?= $konsumen['kode_konsumen']; ?>">
                                <?= $konsumen['nama_konsumen']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div>
                    <label class="block font-medium">Nota Penjualan:</label>
                    <input type="text" name="nota_jual" value="<?php echo $nota_jual; ?>" readonly class="w-full p-2 border rounded">
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-collapse border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2 border">Kode Barang</th>
                                <th class="p-2 border">Nama Barang</th>
                                <th class="p-2 border">Satuan</th>
                                <th class="p-2 border">Stok</th>
                                <th class="p-2 border">Harga Jual</th>
                                <th class="p-2 border">Jumlah</th>
                                <th class="p-2 border">Subtotal</th>
                                <th class="p-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-barang">
                            <tr>
                                <td>
                                    <select name="kode_barang[]" class="w-full p-2 border rounded kode_barang" required>
                                        <option value=""> Pilih Barang </option>
                                        <?php while ($barang = mysqli_fetch_assoc($barangResult)) { ?>
                                            <option value="<?= $barang['kode_barang']; ?>"
                                                data-nama="<?= $barang['nama_barang']; ?>"
                                                data-satuan="<?= $barang['satuan']; ?>"
                                                data-harga="<?= $barang['harga_jual']; ?>"
                                                data-stok="<?= $barang['jumlah_barang']; ?>">
                                                <?= $barang['kode_barang']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><input type="text" name="nama_barang[]" class="w-full p-2 border rounded nama_barang" readonly></td>
                                <td><input type="text" name="satuan[]" class="w-full p-2 border rounded satuan" readonly></td>
                                <td><input type="number" name="stok[]" class="w-full p-2 border rounded stok" readonly></td>
                                <td><input type="number" name="harga_jual[]" class="w-full p-2 border rounded harga_jual" readonly></td>
                                <td><input type="number" name="jumlah_jual[]" class="w-full p-2 border rounded jumlah_jual" required></td>
                                <td><input type="number" name="subtotal[]" class="w-full p-2 border rounded subtotal" readonly></td>
                                <td><button type="button" class="p-2 text-white bg-red-500 rounded hapus">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="button" id="tambah-barang" class="px-4 py-2 text-white bg-blue-500 rounded">Tambah Barang</button>
                <div class="mt-4">
                    <p class="font-semibold">Total Penjualan: <span id="total_display">0</span></p>
                    <input type="hidden" name="total_penjualan" id="total_penjualan" value="0">
                </div>
                <div>
                    <label class="block font-medium">Bayar:</label>
                    <input type="number" id="bayar" name="bayar" required class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block font-medium">Kembalian:</label>
                    <input type="number" id="kembalian" name="kembalian" readonly class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Simpan Penjualan</button>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Event untuk mengisi otomatis nama barang, harga, stok saat memilih barang
            document.querySelector("#table-barang").addEventListener("change", function(e) {
                if (e.target.classList.contains("kode_barang")) {
                    let selectedOption = e.target.selectedOptions[0];
                    let row = e.target.closest("tr");
                    row.querySelector(".nama_barang").value = selectedOption.dataset.nama;
                    row.querySelector(".satuan").value = selectedOption.dataset.satuan;
                    row.querySelector(".harga_jual").value = selectedOption.dataset.harga;
                    row.querySelector(".stok").value = selectedOption.dataset.stok;
                    hitungSubtotal(row);
                }
            });

            // Event untuk menghitung subtotal saat jumlah barang diubah
            document.querySelector("#table-barang").addEventListener("input", function(e) {
                if (e.target.classList.contains("jumlah_jual")) {
                    let row = e.target.closest("tr");
                    let stok = parseInt(row.querySelector(".stok").value) || 0;
                    let jumlah = parseInt(e.target.value) || 0;

                    // Validasi jumlah barang tidak boleh lebih dari stok
                    if (jumlah > stok) {
                        alert("Jumlah melebihi stok yang tersedia!");
                        e.target.value = stok;
                        jumlah = stok;
                    }

                    hitungSubtotal(row);
                }
            });

            // Fungsi menghitung subtotal per baris
            function hitungSubtotal(row) {
                let harga = parseFloat(row.querySelector(".harga_jual").value) || 0;
                let jumlah = parseInt(row.querySelector(".jumlah_jual").value) || 0;
                let subtotal = harga * jumlah;
                row.querySelector(".subtotal").value = subtotal;

                hitungTotal();
            }

            // Fungsi menghitung total penjualan
            function hitungTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(function(input) {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('total_penjualan').value = total;
                document.getElementById('total_display').textContent = total;
            }

            // Event untuk menghitung kembalian
            document.getElementById("bayar").addEventListener("input", function() {
                let total = parseFloat(document.getElementById('total_penjualan').value) || 0;
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