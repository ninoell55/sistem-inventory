<?php
include "../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nota_jual = $_POST['nota_jual'];
    $kode_konsumen = $_POST['kode_konsumen'];
    $total_jual = $_POST['total_penjualan'];
    $tanggal_jual = date("Y-m-d");

    // Simpan ke tabel penjualan
    $queryPenjualan = "INSERT INTO penjualan (nota_jual, tanggal_jual, total_jual, kode_konsumen) 
                       VALUES ('$nota_jual', '$tanggal_jual', '$total_jual', '$kode_konsumen')";
    $resultPenjualan = mysqli_query($conn, $queryPenjualan);

    if (!$resultPenjualan) {
        die("Gagal menyimpan penjualan: " . mysqli_error($conn));
    }

    // Simpan ke tabel detail_penjualan dan update stok
    foreach ($_POST['kode_barang'] as $index => $kode_barang) {
        $jumlah_jual = $_POST['jumlah_jual'][$index];
        $harga_jual = $_POST['harga_jual'][$index];
        $subtotal = $_POST['subtotal'][$index];

        // Cek stok sebelum mengurangi
        $queryCekStok = "SELECT jumlah_barang FROM gudang WHERE kode_barang = '$kode_barang'";
        $resultCekStok = mysqli_query($conn, $queryCekStok);
        $stokData = mysqli_fetch_assoc($resultCekStok);
        $stokTersedia = $stokData['jumlah_barang'];

        if ($stokTersedia < $jumlah_jual) {
            die("Error: Stok tidak mencukupi untuk barang $kode_barang");
        }

        // Simpan detail penjualan
        $queryDetail = "INSERT INTO detail_penjualan (nota_jual, kode_barang, jumlah_jual, harga_jual, subtotal) 
                        VALUES ('$nota_jual', '$kode_barang', '$jumlah_jual', '$harga_jual', '$subtotal')";
        if (!mysqli_query($conn, $queryDetail)) {
            die("Gagal menyimpan detail penjualan: " . mysqli_error($conn));
        }

        // Update stok barang di gudang
        $queryUpdateStok = "UPDATE gudang SET jumlah_barang = jumlah_barang - $jumlah_jual WHERE kode_barang = '$kode_barang'";
        if (!mysqli_query($conn, $queryUpdateStok)) {
            die("Gagal memperbarui stok: " . mysqli_error($conn));
        }
    }

    // Redirect ke laporan penjualan setelah berhasil menyimpan
    header("Location: laporan.php?success=1");
    exit();
}
?>