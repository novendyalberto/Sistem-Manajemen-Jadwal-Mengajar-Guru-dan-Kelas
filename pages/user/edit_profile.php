<?php
include '../config/database.php';

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$username = $_SESSION['user'];

// Ambil data user
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

$pemberitahuan = "";

// Jika submit form
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_baru = mysqli_real_escape_string($conn, $_POST['username']);
    $foto = $user['foto']; // Default foto lama

    // Upload foto jika ada
    if (!empty($_FILES['foto']['name'])) {
        $file_name = time() . "_" . basename($_FILES["foto"]["name"]);
        $target = "../uploads/" . $file_name;

        // Validasi tipe file
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target)) {
                
                // Hapus foto lama jika ada
                if (!empty($user['foto']) && file_exists("../uploads/" . $user['foto'])) {
                    unlink("../uploads/" . $user['foto']);
                }

                $foto = $file_name;
            } else {
                $pemberitahuan = "Gagal mengupload foto.";
            }
        } else {
            $pemberitahuan = "Format foto harus JPG atau PNG.";
        }
    }

    // Update database
    if ($pemberitahuan == "") {
        $sql = "UPDATE users 
                SET nama_lengkap='$nama', email='$email', username='$user_baru', foto='$foto'
                WHERE username='$username'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['user'] = $user_baru; // update session
            $pemberitahuan = "Profil berhasil diperbarui!";
            
            // Refresh data
            $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$user_baru'");
            $user = mysqli_fetch_assoc($query);

        } else {
            $pemberitahuan = "Gagal memperbarui data.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>

<div class="profile-container">
    <h1 class="profil-akun">Edit Profil</h1>

    <div class="profile-card">

        <?php if (!empty($user['foto'])): ?>
            <img class="profile-photo" src="../uploads/<?= htmlspecialchars($user['foto']) ?>">
        <?php endif; ?>

        <?php if ($pemberitahuan): ?>
        <div class="alert2"><?= $pemberitahuan ?></div>
    <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label>Foto Profil</label>
            <input type="file" name="foto" accept="image/*">

            <button type="submit" name="update" class="btn-simpanperubahan">Simpan Perubahan</button>
            <button type="button" class="btn-kembali" onclick="window.location.href='dashboard.php?page=profile'">Kembali</button>

        </form>
    </div>
</div>

</body>
</html>