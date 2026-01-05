<?php
include "koneksi.php"; // koneksi ke database

header("Content-Type: application/json");

// Tangkap data JSON dari fetch()
$data = json_decode(file_get_contents("php://input"), true);

$nama = $data["nama"];
$email = $data["email"];
$password = $data["password"];

// Enkripsi password (lebih aman)
$hash = password_hash($password, PASSWORD_DEFAULT);

// Query simpan data
$sql = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$hash')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
}
?>
