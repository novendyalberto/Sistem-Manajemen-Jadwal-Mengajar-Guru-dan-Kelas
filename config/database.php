<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_jadwal_guruu";

// Koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
