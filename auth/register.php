<?php
require_once("../config/database.php");

if (isset($_POST['register'])) {

  $nama_lengkap = trim($_POST['nama_lengkap']);
  $email = trim($_POST['email']);
  $username = trim($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Validasi email sudah terdaftar
  $cek_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($cek_email) > 0) {
    echo "<script>alert('Email sudah digunakan!');</script>";
    return;
  }

  // Validasi username sudah terdaftar
  $cek_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
  if (mysqli_num_rows($cek_username) > 0) {
    echo "<script>alert('Username sudah digunakan!');</script>";
    return;
  }

  // Insert data user
  $query = "INSERT INTO users (nama_lengkap, email, username, password)
              VALUES ('$nama_lengkap', '$email', '$username', '$password')";

  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Pendaftaran berhasil! Silakan login.');window.location='login.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat menyimpan data.');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Register Akun</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
  <div class="container">
    <h2>Form Register</h2>
    <form method="POST">

      <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required><br>

      <input type="email" name="email" placeholder="Email" required><br>

      <input type="text" name="username" placeholder="Username" required><br>

      <input type="password" name="password" placeholder="Password" required><br>

      <button type="submit" name="register">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
  </div>
</body>

</html>