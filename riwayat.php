<?php
include("koneksi.php");

// Pastikan ada ID pesanan di URL
if (!isset($_GET['id'])) {
  echo "<script>alert('Tidak ada data pesanan.'); window.location='riwayat.html';</script>";
  exit;
}

$id = $_GET['id'];

// Ambil data dari database
$query = "SELECT * FROM pemesanan WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  echo "<script>alert('Data pesanan tidak ditemukan.'); window.location='riwayat.html';</script>";
  exit;
}

$data = mysqli_fetch_assoc($result);

// Kirim data ke halaman tampilan
include("riwayat.html");
?>