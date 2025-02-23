<?php
session_start(); // Memulai sesi

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "sistem_inventory");

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>