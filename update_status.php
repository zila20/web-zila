<?php
include "../koneksi.php";

// Ambil data dari form
$nomor = $_POST['nomor'];  // gunakan nama_kamar sebagai identifier
$status = $_POST['status'];

// Update status berdasarkan nama_kamar
mysqli_query($conn, "UPDATE kamar SET status='$status' WHERE nomor='$nomor'");

// Kembali ke halaman kamar
header("Location: admin_dashboard.php");
exit;
?>
