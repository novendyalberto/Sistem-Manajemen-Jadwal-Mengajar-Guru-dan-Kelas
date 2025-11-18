<?php
include '../config/database.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['user'];
$message = "";

// Proses update password
if (isset($_POST['submit'])) {

    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];

    // Ambil data user
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    // Verifikasi password lama
    if (!password_verify($password_lama, $user['password'])) {
        $message = "Password lama salah!";
    } elseif (strlen($password_baru) < 5) {
        $message = "Password baru minimal 5 karakter!";
    } else {
        // Hash password baru
        $hashed = password_hash($password_baru, PASSWORD_DEFAULT);

        // Update ke database
        mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE username='$username'");

        $message = "Password berhasil diubah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="container">
    <h1 >Ubah Password</h1>

    <?php if ($message != "") { ?>
        <p class="alert1"><?= $message; ?></p>
    <?php } ?>

    <form action="" method="POST">
        <label>Password Lama</label>
        <input type="password" name="password_lama" required>

        <label>Password Baru</label>
        <input type="password" name="password_baru" required>

        <button type="submit" name="submit" class="btn-simpanperubahan">Simpan Password</button>
        <button type="button" class="btn-kembali" onclick="window.location.href='dashboard.php?page=profile'">Kembali</button>
    </form>
</div>

</body>
</html>
