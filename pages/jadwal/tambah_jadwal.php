<?php
include '../config/database.php';
$pemberitahuan = '';

$guru = mysqli_query($conn, "SELECT * FROM guru");
$kelas = mysqli_query($conn, "SELECT * FROM kelas");

if (isset($_POST['simpan'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $id_guru = $_POST['id_guru'];
    $id_kelas = $_POST['id_kelas'];

    $sql = "INSERT INTO jadwal (hari, jam_mulai, jam_selesai, id_guru, id_kelas)
            VALUES ('$hari', '$jam_mulai', '$jam_selesai', '$id_guru', '$id_kelas')";
    if (mysqli_query($conn, $sql)) {
        $pemberitahuan = "Jadwal berhasil disimpan.";
    } else {
        $pemberitahuan = "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="container">
    <h2>Tambah Jadwal Mengajar</h2>
    <?php if ($pemberitahuan): ?>
        <div class="alert"<?= strpos($pemberitahuan, 'berhasil') ? 'success' : 'error' ?>">
            <?= $pemberitahuan ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <label>Hari:</label>
        <select name="hari" required>
            <option value="">-- Pilih Hari --</option>
            <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari) echo "<option>$hari</option>"; ?>
        </select><br>

        <label>Jam Mulai:</label>
        <input type="time" name="jam_mulai" required><br>
        <label>Jam Selesai:</label>
        <input type="time" name="jam_selesai" required><br>

        <label>Guru:</label>
        <select name="id_guru" required>
            <option value="">-- Pilih Guru --</option>
            <?php while ($g = mysqli_fetch_assoc($guru)) echo "<option value='{$g['id']}'>{$g['nama_guru']} ({$g['mapel']})</option>"; ?>
        </select><br>

        <label>Kelas:</label>
        <select name="id_kelas" required>
            <option value="">-- Pilih Kelas --</option>
            <?php while ($k = mysqli_fetch_assoc($kelas)) echo "<option value='{$k['id']}'>{$k['nama_kelas']}</option>"; ?>
        </select><br>

        <button type="submit" class="btn-simpanperubahan" name="simpan">Simpan</button>
        <button type="button" class="btn-kembali" onclick="window.location.href='dashboard.php?page=data_jadwal'">Kembali</button>
    </form>
</div>
</body>
</html>
