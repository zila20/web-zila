<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit;
}
include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="admin.css"> 
</head>
<body>
<section class="admin-dashboard"> 
<h1>Dashboard Admin</h1>

<h2>Data Pemesanan</h2>
<!-- FORM PENCARIAN TAHUN + BULAN -->
<form method="GET" action="" class="search-box" style="display:flex; justify-content:center; gap:15px; margin:20px 0; flex-wrap:wrap;">
    <input type="number" name="tahun" placeholder="Masukkan Tahun (yyyy)" 
           min="2025" max="2100" required
           style="padding:10px;
            width:220px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:15px;
            outline:none;
            transition:0.2s;" onfocus="this.style.borderColor= #007bff" onblur="this.style.borderColor= #ccc">

    <select name="bulan" required style="padding:10px;
            width:220px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:15px;
            outline:none;
            transition:0.2s;" onfocus="this.style.borderColor= #007bff" onblur="this.style.borderColor= #ccc">
        <option value="">-- Pilih Bulan --</option>
        <option value="01">Januari</option>
        <option value="02">Februari</option>
        <option value="03">Maret</option>
        <option value="04">April</option>
        <option value="05">Mei</option>
        <option value="06">Juni</option>
        <option value="07">Juli</option>
        <option value="08">Agustus</option>
        <option value="09">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>
    </select>

    <button type="submit" style="
            padding:9px 20px;
            width:130px;
            background: #007bff;
            color:white;
            border:none;
            border-radius:8px;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;" onmouseover="this.style.background= #457ebbff" onmouseout="this.style.background= #007bff">
        🔍 Cari
    </button>
</form>

<?php
// LOGIKA PENCARIAN
if (isset($_GET['tahun']) && isset($_GET['bulan'])) {
    $tahun = mysqli_real_escape_string($conn, $_GET['tahun']);
    $bulan = mysqli_real_escape_string($conn, $_GET['bulan']);

    // Query menggunakan filter tahun dan bulan
    $q = mysqli_query($conn, "
        SELECT * FROM pemesanan 
        WHERE YEAR(tanggal_pesan) = '$tahun'
        AND MONTH(tanggal_pesan) = '$bulan'
        ORDER BY id DESC
    ");

    echo "<p style='color:blue; font-weight:bold;'>Menampilkan data bulan $bulan tahun $tahun</p>";

} else {
    // Jika tidak menggunakan filter, tampilkan semua
    $q = mysqli_query($conn, "SELECT * FROM pemesanan ORDER BY id DESC");
}
?>

<table border="1">
<tr>
  <th>ID</th><th>Nama</th><th>Umur</th><th>JK</th><th>Jumlah_Orang</th>
  <th>Checkin</th><th>Checkout</th><th>Pembayaran</th><th>Tipe</th>
  <th>Kamar</th><th>Total</th><th>Tanggal_pesanan</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['umur']}</td>
            <td>{$row['jk']}</td>
            <td>{$row['orang']}</td>
            <td>{$row['checkin']}</td>
            <td>{$row['checkout']}</td>
            <td>{$row['pembayaran']}</td>
            <td>{$row['tipe']}</td>
            <td>{$row['kamar']}</td>
            <td>Rp " . number_format($row['total'],0,',','.') . "</td>
            <td>{$row['tanggal_pesan']}</td>
          </tr>";
}
?>
</table>

<h2>Penilaian Pengguna</h2>
<table border="1">
<tr>
  <th>ID</th><th>Nama</th><th>Keterangan</th><th>Bintang</th>
</tr>

<?php
$q2 = mysqli_query($conn, "SELECT * FROM penilaian");
while ($km = mysqli_fetch_assoc($q2)) {
    echo "<tr>
            <td>{$km['id']}</td>
            <td>{$km['nama']}</td>
            <td>{$km['keterangan']}</td>
            <td>{$km['bintang']}</td>
          </tr>";
}
?>
</table>

<h2>Akun Login</h2>
<table border="1">
<tr>
  <th>ID</th><th>Nama</th><th>Email</th><th>Password</th>
</tr>

<?php
$q2 = mysqli_query($conn, "SELECT * FROM users");
while ($km = mysqli_fetch_assoc($q2)) {
    echo "<tr>
            <td>{$km['id']}</td>
            <td>{$km['nama']}</td>
            <td>{$km['email']}</td>
            <td>{$km['password']}</td>
          </tr>";
}
?>
</table>

<h2>Kelola Kamar</h2>
<table border="1">
<tr>
  <th>Tipe</th><th>Nomor</th><th>Lantai</th><th>Harga</th><th>Status</th><th>Ubah</th>
</tr>

<?php
$q2 = mysqli_query($conn, "SELECT * FROM kamar");
while ($km = mysqli_fetch_assoc($q2)) {
    echo "<tr>
  <td>{$km['type']}</td>
  <td>{$km['nomor']}</td>
  <td>{$km['floor']}</td>
  <td>Rp " . number_format($km['price'],0,',','.'). "</td>
  <td>
     <form method='POST' action='update_status.php'>
       <input type='hidden' name='nomor' value='{$km['nomor']}'>
                <select name='status' onchange='this.form.submit()'>
                    <option value='Tersedia' " . ($km['status']=='Tersedia' ? 'selected' : '') . ">Tersedia</option>
                    <option value='Dipesan' " . ($km['status']=='Dipesan' ? 'selected' : '') . ">Dipesan</option>
                </select>
     </form>
  </td>
  <td>
    <a href='edit-kamar.php?nomorr={$km['nomor']}'>Edit</a> | 
    <a href='hapus-kamar.php?nomorr={$km['nomor']}' onclick=\"return confirm('Yakin?')\">Hapus</a>
  </td>
</tr>";
}
?>
</table>

</section>
</body>
</html>
