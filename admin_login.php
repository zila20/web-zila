<?php
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // DEBUG: tampilkan hash
    echo "Hash dari password input: " . $pass;

    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");

    if (mysqli_num_rows($cek) == 1) {
        $_SESSION['admin'] = $user;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "<script>alert('Login salah');</script>";
    }
    } else {
    header("Location: admin_login.html");
    exit;
}
?>
