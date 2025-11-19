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
    $password_lama = trim($_POST['password_lama'] ?? '');
    $password_baru = trim($_POST['password_baru'] ?? '');
    $konfirmasi_password_baru = trim($_POST['konfirmasi_password_baru'] ?? '');

    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi_password_baru)) {
        $message = "Semua kolom password harus diisi!";
    } elseif (strlen($password_baru) < 5) {
        $message = "Password baru minimal 5 karakter!";
    } elseif ($password_baru !== $konfirmasi_password_baru) {
        $message = "Konfirmasi password baru tidak cocok!";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username); // 's' untuk string
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {

            if (!password_verify($password_lama, $user['password'])) {
                $message = "Password lama salah!";
            } else {

                $hashed = password_hash($password_baru, PASSWORD_DEFAULT);


                $stmt_update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $stmt_update->bind_param("ss", $hashed, $username); // 'ss' untuk dua string
                $stmt_update->execute();
                $stmt_update->close();

                $message = "Password berhasil diubah!";
            }
        } else {
            $message = "User tidak ditemukan. Harap login ulang.";
        }
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
        <h1>Ubah Password</h1>

        <?php if ($message != "") { ?>
            <p class="alert"><?= htmlspecialchars($message); ?></p>
        <?php } ?>

        <form action="" method="POST">
            <label>Password Lama</label>
            <input type="password" name="password_lama" required>

            <label>Password Baru</label>
            <input type="password" name="password_baru" required>

            <label>Konfirmasi Password Baru</label>
            <input type="password" name="konfirmasi_password_baru" required>

            <button type="submit" name="submit" class="btn-simpanperubahan">Simpan Password</button>
            <button type="button" class="btn-kembali"
                onclick="window.location.href='dashboard.php?page=profile'">Kembali</button>
        </form>
    </div>

</body>

</html>