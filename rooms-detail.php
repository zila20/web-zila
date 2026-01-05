<?php
include "koneksi.php";

$type = $_GET['type'] ?? '';

if (!$type) {
    die("Tipe kamar tidak ditentukan.");
}

$query = mysqli_query($conn, "
    SELECT * FROM kamar 
    WHERE LOWER(type) = LOWER('$type')
    ORDER BY nomor
") or die("Query error: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Kamar</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="navbar">
  <div class="logo-container">
    <img src="image/logo-grandhotel.png" class="logo-img">
    <div class="logo-text">
      <h1>GRAND HOTEL</h1>
      <p>Luxury & Comfort</p>
    </div>
  </div>
  <nav>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="index.html#about">About Us</a></li>
      <li><a href="index.html#contact">Contact</a></li>
      <li><a href="rooms.html" class="active">Rooms</a></li>
      <li><a href="laporan.html">Laporan</a></li>
      <li><a href="penilaian.php">Penilaian</a></li>
      <li><a href="akun.html" class="akun-icon"><i class="fa-solid fa-user"></i></a></li>
    </ul>
  </nav>
</header>

<section class="room-details">
  <h2>Daftar Kamar: <?= ucfirst($type) ?></h2>

  <div class="room-list-detail">
    <?php while($row = mysqli_fetch_assoc($query)) { ?>
      <div class="room-box">
        <h3><?= $row['nomor'] ?></h3>
        <p>Lantai: <?= $row['floor'] ?></p>
        <p>Harga: Rp<?= number_format($row['price'],0,',','.') ?></p>
        <p>Status: <?= $row['status'] ?></p>
        <?php if($row['status']=='Tersedia'){ ?>
          <button onclick="window.location.href='booking.html?nomor=<?= $row['nomor'] ?>'">
            Pesan Sekarang
          </button>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
</section>
</body>
</html>
