<?php
$host = "localhost";
$user = "root";
$pass = ""; // Pastikan password MySQL Anda benar
$db = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn == false) {
    die("Koneksi ke server gagal: " . mysqli_connect_error());
}
// Tambahkan ini untuk debugging
// echo "Koneksi berhasil!";
?>