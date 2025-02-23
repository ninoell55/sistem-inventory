<?php
include '../../config/config.php'; // Koneksi database

if (isset($_GET['kode_pemasok'])) {
    $kode_pemasok = $_GET['kode_pemasok'];

    // Ambil data pemasok berdasarkan kode
    $query = "SELECT nama_pemasok, orang_hubungi, telepon_pemasok FROM pemasok WHERE kode_pemasok = '$kode_pemasok'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    // Konversi ke JSON
    echo json_encode($data);
}
?>