<?php   
include '../config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$username = $_SESSION['user'];

// Ambil data user
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

// Foto profil: jika kosong pakai default
$foto = (!empty($user['foto'])) 
        ? "../uploads/" . $user['foto'] 
        : "../assets/img/default-profile.png";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil User</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>

<div class="profile-container">
    <h1 class="profil-akun">Profil Akun</h1>

    <div class="profile-card">
        <img src="<?= $foto ?>" class="profile-photo" alt="">
         
        <div class="profile-info">
            <p><strong>Nama Lengkap</strong>: <?= htmlspecialchars($user['nama_lengkap']); ?></p>
            <p><strong>Email</strong>: <?= htmlspecialchars($user['email']); ?></p>
            <p><strong>Username</strong>: <?= htmlspecialchars($user['username']); ?></p>
        </div>

        <div class="profile-actions">
            <a href="dashboard.php?page=edit_profile&id={$row['id']}" class="btn-editprofil">Edit Profil</a>
            <a href="dashboard.php?page=ubah_password&id={$row['id']}" class="btn-ubahpassword">Ubah Password</a>
        </div>
    </div>
</div>

</body>
</html>
