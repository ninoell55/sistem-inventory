<?php
include "../../config/config.php";

$kode = $_GET['kode'];
$query = "DELETE FROM konsumen WHERE kode_konsumen='$kode'";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Gagal menghapus data!";
}
