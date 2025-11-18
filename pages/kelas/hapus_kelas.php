<?php
include '../config/database.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM jadwal WHERE id='$id'");
echo "<script>alert('Data kelas berhasil dihapus'); window.location='dashboard.php';</script>";
?>
