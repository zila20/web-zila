<?php
include("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $nama = $_POST["nama"];
  $umur = $_POST["umur"];
  $jk = $_POST["jk"];
  $orang = $_POST["orang"];
  $checkin = $_POST["checkin"];
  $checkout = $_POST["checkout"];
  $pembayaran = $_POST["pembayaran"];
  $tipe = $_POST["tipe"];
  $kamar = $_POST["kamar"];
  $harga = $_POST["harga"];

  $lama = (strtotime($checkout) - strtotime($checkin)) / 86400;
  if ($lama <= 0) $lama = 1;

  $total = $harga * $lama;

  $sql = "INSERT INTO pemesanan (nama, umur, jk, orang, checkin, checkout, pembayaran, tipe, kamar, total)
          VALUES ('$nama', '$umur', '$jk', '$orang', '$checkin', '$checkout', '$pembayaran', '$tipe', '$kamar', '$total')";

  if (mysqli_query($conn, $sql)) {
      echo mysqli_insert_id($conn);   // ⬅️ KIRIM ID PESANAN
  } else {
      echo "ERROR";
  }
}
?>