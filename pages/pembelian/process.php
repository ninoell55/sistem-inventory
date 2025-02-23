<?php
include "../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nota_beli = $_POST['nota_beli'];
    $kode_pemasok = $_POST['kode_pemasok'];
    $total_beli = $_POST['total_pembelian'];
    $tanggal_beli = date("Y-m-d");

    // Simpan ke tabel pembelian
    $queryPembelian = "INSERT INTO pembelian (nota_beli, tanggal_beli, total_beli, kode_pemasok) 
                       VALUES ('$nota_beli', '$tanggal_beli', '$total_beli', '$kode_pemasok')";
    $resultPembelian = mysqli_query($conn, $queryPembelian);

    if (!$resultPembelian) {
        die("Gagal menyimpan pembelian: " . mysqli_error($conn));
    }

    // Simpan ke tabel detail_pembelian dan update stok
    foreach ($_POST['kode_barang'] as $index => $kode_barang) {
        $jumlah_beli = $_POST['jumlah_beli'][$index];
        $harga_beli = $_POST['harga_beli'][$index];
        $subtotal = $_POST['subtotal'][$index];

        // Cek stok sebelum mengurangi
        // $queryCekStok = "SELECT jumlah_barang FROM gudang WHERE kode_barang = '$kode_barang'";
        // $resultCekStok = mysqli_query($conn, $queryCekStok);
        // $stokData = mysqli_fetch_assoc($resultCekStok);
        // $stokTersedia = $stokData['jumlah_barang'];

        // if ($stokTersedia > $jumlah_beli) {
        //     die("Error: Stok tidak mencukupi untuk barang $kode_barang");
        // }

        // Simpan detail pembelian
        $queryDetail = "INSERT INTO detail_pembelian (nota_beli, kode_barang, jumlah_beli, harga_beli, subtotal) 
                        VALUES ('$nota_beli', '$kode_barang', '$jumlah_beli', '$harga_beli', '$subtotal')";
        if (!mysqli_query($conn, $queryDetail)) {
            die("Gagal menyimpan detail pembelian: " . mysqli_error($conn));
        }

        // Update stok barang di gudang
        $queryUpdateStok = "UPDATE gudang SET jumlah_barang = jumlah_barang + $jumlah_beli WHERE kode_barang = '$kode_barang'";
        if (!mysqli_query($conn, $queryUpdateStok)) {
            die("Gagal memperbarui stok: " . mysqli_error($conn));
        }
    }

    // Redirect ke laporan pembelian setelah berhasil menyimpan
    header("Location: laporan.php?success=1");
    exit();
}
?>