<?php
include '../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kelas WHERE id='$id'"));
$pemberitahuan = '';

if (isset($_POST['update'])) {
    $nama = $_POST['nama_kelas'];
    $tingkat = $_POST['tingkat'];

    $sql = "UPDATE kelas SET nama_kelas='$nama', tingkat='$tingkat' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $pemberitahuan = "Data kelas berhasil diperbarui.";
    } else {
        $pemberitahuan = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kelas</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="container">
    <h2>Edit Data Kelas</h2>
    <?php if ($pemberitahuan): ?>
        <div class="alert"<?= strpos($pemberitahuan, 'berhasil') ? 'success' : 'error' ?>">
            <?= $pemberitahuan ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <label>Nama Kelas:</label>
        <input type="text" name="nama_kelas" value="<?= $data['nama_kelas'] ?>" required><br>
        <label>Tingkat:</label>
        <input type="text" name="tingkat" value="<?= $data['tingkat'] ?>" required><br>
        <button type="submit" class="btn-simpanperubahan" name="update">Perbarui</button>
        <button type="button" class="btn-kembali" onclick="window.location.href='dashboard.php?page=data_kelas'">Kembali</button>
    </form>
</div>
</body>
</html>
