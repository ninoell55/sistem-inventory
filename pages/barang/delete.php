<?php
include "../../config/config.php";

$kode = $_GET['kode'];
$query = "DELETE FROM gudang WHERE kode_barang='$kode'";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Gagal menghapus data!";
}
?>