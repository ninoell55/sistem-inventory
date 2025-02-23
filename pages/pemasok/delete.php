<?php
include "../../config/config.php";

$kode = $_GET['kode'];
$query = "DELETE FROM pemasok WHERE kode_pemasok='$kode'";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Gagal menghapus data!";
}
