<?php 
include '../config/database.php'; 
$pemberitahuan = '';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_kelas'];
    $tingkat = $_POST['tingkat'];

    $sql = "INSERT INTO kelas (nama_kelas, tingkat) VALUES ('$nama', '$tingkat')";
    if (mysqli_query($conn, $sql)) {
        $pemberitahuan = "Data kelas berhasil disimpan.";
    } else {
        $pemberitahuan = "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kelas</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="container">
    <h2>Tambah Data Kelas</h2>
    <?php if ($pemberitahuan): ?>
        <div class="alert"<?= strpos($pemberitahuan, 'berhasil') ? 'success' : 'error' ?>">
            <?= $pemberitahuan ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <label>Nama Kelas:</label>
        <input type="text" name="nama_kelas" placeholder="Contoh: TKJ 1" required><br>
        <label>Tingkat:</label>
        <input type="text" name="tingkat" placeholder="Contoh: XI" required><br>
        <button type="submit" class="btn-simpanperubahan" name="simpan">Simpan</button>
        <button type="button" class="btn-kembali" onclick="window.location.href='dashboard.php?page=data_kelas'">Kembali</button>
    </form>
</div>
</body>
</html>
