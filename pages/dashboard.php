<?php
session_start();
include '../config/database.php';

// Cek login
if (!isset($_SESSION['user'])) {
  header("Location: ../auth/login.php");
  exit;
}

// Mendapatkan halaman
$page = $_GET['page'] ?? 'home';

// Statistik
$total_guru  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM guru"))['total'];
$total_kelas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kelas"))['total'];
$total_jadwal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jadwal"))['total'];

// Mapping halaman ke folder
$pages_map = [
    'data_guru'     => 'guru/data_guru.php',
    'tambah_guru'   => 'guru/tambah_guru.php',
    'edit_guru'     => 'guru/edit_guru.php',

    'data_kelas'    => 'kelas/data_kelas.php',
    'tambah_kelas'  => 'kelas/tambah_kelas.php',
    'edit_kelas'    => 'kelas/edit_kelas.php',

    'data_jadwal'   => 'jadwal/data_jadwal.php',
    'tambah_jadwal' => 'jadwal/tambah_jadwal.php',
    'edit_jadwal'   => 'jadwal/edit_jadwal.php',

    'profile'       => 'user/profile.php',
    'edit_profile'  => 'user/edit_profile.php',
    'ubah_password' => 'user/ubah_password.php'
];


// Hapus data (umum)
if (isset($_GET['hapus']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $table_map = [
        'data_guru'   => 'guru',
        'data_kelas'  => 'kelas',
        'data_jadwal' => 'jadwal'
    ];

    if (isset($table_map[$page])) {
        $table = $table_map[$page];
        mysqli_query($conn, "DELETE FROM $table WHERE id = $id");

        echo "<script>
                alert('Data berhasil dihapus!');
                window.location='dashboard.php?page=$page';
              </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistem Jadwal Mengajar</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="sidebar" id="sidebar">
    <h2>Sistem Jadwal Mengajar</h2>
    <ul>
        <li><a href="dashboard.php" <?= ($page == 'home') ? 'class="active"' : '' ?>>Dashboard</a></li>
        <li><a href="?page=data_guru" <?= ($page == 'data_guru') ? 'class="active"' : '' ?>>Data Guru</a></li>
        <li><a href="?page=data_kelas" <?= ($page == 'data_kelas') ? 'class="active"' : '' ?>>Data Kelas</a></li>
        <li><a href="?page=data_jadwal" <?= ($page == 'data_jadwal') ? 'class="active"' : '' ?>>Data Jadwal</a></li>
        <li><a href="?page=profile" <?= ($page == 'profile') ? 'class="active"' : '' ?>>Profil Saya</a></li>
    </ul>
</div>

<div class="main-content">
    <header>
        <button id="toggle-btn">☰</button>
        <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['user']) ?></h1>
        <a href="../auth/logout.php" class="logout-btn">Logout</a>
    </header>

    <section class="dashboard-content">
        <?php if ($page == 'home') { ?>
            <div class="card">
                <h3>Data Guru</h3>
                <p>Total: <strong><?= $total_guru ?></strong> guru terdaftar</p>
                <a href="?page=data_guru" class="btn">Lihat Data</a>
            </div>
            <div class="card">
                <h3>Data Kelas</h3>
                <p>Total: <strong><?= $total_kelas ?></strong> kelas tersedia</p>
                <a href="?page=data_kelas" class="btn">Lihat Data</a>
            </div>
            <div class="card">
                <h3>Jadwal Mengajar</h3>
                <p>Total: <strong><?= $total_jadwal ?></strong> jadwal tersimpan</p>
                <a href="?page=data_jadwal" class="btn">Lihat Data</a>
            </div>
        <?php
        } else {
            // cek apakah halaman valid
            if (array_key_exists($page, $pages_map)) {
                include $pages_map[$page];
            } else {
                echo "<p style='text-align:center; margin-top:50px;'>Halaman tidak ditemukan!</p>";
            }
        }
        ?>
    </section>
</div>

<script>
document.getElementById('toggle-btn').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('collapsed');
});
</script>

</body>
</html>
