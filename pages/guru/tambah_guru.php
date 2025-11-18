<?php 

$pemberitahuan = '';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_guru'];
    $mapel = $_POST['mapel'];

    $sql = "INSERT INTO guru (nama_guru, mapel) VALUES ('$nama', '$mapel')";
    if (mysqli_query($conn, $sql)) {
        $pemberitahuan = "Data guru berhasil disimpan.";
    } else {
        $pemberitahuan = "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Guru</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="container">
    <h2>Tambah Data Guru</h2>
    <?php if ($pemberitahuan): ?>
        <div class="alert"<?= strpos($pemberitahuan, 'berhasil') ? 'success' : 'error' ?>">
            <?= $pemberitahuan ?>
        </div>
    <?php endif; ?>
        
    <form method="POST">
        <label>Nama Guru:</label>
        <input type="text" name="nama_guru" required><br>
        <label>Mata Pelajaran:</label>
        <input type="text" name="mapel" required><br>
        <button type="submit" class="btn-simpanperubahan" name="simpan">Simpan</button>
        <button type="button" class="btn-kembali" onclick="window.location.href='dashboard.php?page=data_guru'">Kembali</button>
    </form>
</div>
</body>
</html>
