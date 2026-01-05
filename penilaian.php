<?php
include("koneksi.php");
session_start();

// PROSES INSERT DATA REVIEW
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kirim'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $bintang = mysqli_real_escape_string($conn, $_POST['bintang']);

    $sql = "INSERT INTO penilaian (nama, keterangan, bintang) 
            VALUES ('$nama', '$keterangan', '$bintang')";

    if (mysqli_query($conn, $sql)) {
        header("Location: penilaian.php?status=sukses");
        exit();
    } else {
        header("Location: penilaian.php?status=gagal");
        exit();
    }
}

// AMBIL SEMUA REVIEW DARI DB
$review = mysqli_query($conn, "SELECT * FROM penilaian ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penilaian - Grand Hotel</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <header class="navbar">
    <div class="logo-container">
      <img src="image/logo-grandhotel.png" alt="Logo Grand Hotel" class="logo-img">
      <div class="logo-text">
        <h1>GRAND HOTEL</h1>
        <p>Luxury & Comfort</p>
      </div>
    </div>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="rooms.html">Rooms</a></li>
      <li><a href="laporan.html">Laporan</a></li>
      <li><a href="penilaian.php" class="active">Penilaian</a></li>
      <li><a href="akun.html" class="akun-icon"><i class="fa-solid fa-user"></i></a></li>
    </ul>
  </header>

  <section class="penilaian-intro">
    <div class="intro-container">
      <h2>💙 Beri Penilaian untuk Grand Hotel</h2>
      <p>
        Pendapat Anda sangat berharga bagi kami!  
        Jika Anda merasa puas, beri kami bintang terbaik.  
        Jika ada yang perlu ditingkatkan, tuliskan saran Anda agar kami bisa menjadi lebih baik ✨
      </p>
    </div>
  </section>

  <section class="booking-form">
    <form id="ratingForm" method="POST" action="penilaian.php">
      <label>Nama</label>
      <input type="text" name="nama" required placeholder="Masukkan nama anda">

      <label>Keterangan</label>
      <textarea name="keterangan" placeholder="Tulis pengalaman Anda di Grand Hotel..." rows="5" required></textarea>

      <label>Bintang</label>
      <select name="bintang" required>
        <option value="1">⭐ 1</option>
        <option value="2">⭐⭐ 2</option>
        <option value="3">⭐⭐⭐ 3</option>
        <option value="4">⭐⭐⭐⭐ 4</option>
        <option value="5">⭐⭐⭐⭐⭐ 5</option>
      </select>

      <button type="submit" name="kirim">Kirim Penilaian</button>
    </form>

    <p id="thanksMsg" style="display:none" class="success">Terima kasih atas penilaian Anda! 😊</p>
  </section>

  <!-- LIST REVIEW CUSTOMER -->
  <section class="review-section">
    <h2 class="review-title">Review Customer</h2>

    <?php while ($row = mysqli_fetch_assoc($review)) { ?>
      <div class="review-box">
          <i class="fa-solid fa-user review-icon"></i>

          <div class="review-detail">
              <div class="nama"><?= $row['nama']; ?></div>

              <div class="bintang">
                  <?php for ($i = 1; $i <= $row['bintang']; $i++) { ?>
                      <i class="fa-solid fa-star"></i>
                  <?php } ?>
              </div>

              <div class="keterangan"><?= $row['keterangan']; ?></div>
          </div>
      </div>
    <?php } ?>
  </section>

  <footer>
    <p>&copy; 2025 Grand Hotel | All Rights Reserved.</p>
  </footer>

  <!-- ========= JS ========== -->
  <script>
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('status') === 'sukses') {
      document.getElementById("thanksMsg").style.display = "block";

      setTimeout(function() {
          window.location.href = "penilaian.php";
      }, 2000);
    }
  </script>

</body>
</html>
