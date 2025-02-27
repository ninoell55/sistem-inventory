<?php
session_start(); // Memulai sesi
$base_url = "/sistem_inventory/"; // Ganti sesuai dengan path proyek Anda

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "sistem_inventory");
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>