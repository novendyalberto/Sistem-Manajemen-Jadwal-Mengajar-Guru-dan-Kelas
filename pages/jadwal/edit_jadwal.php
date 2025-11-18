<?php
include '../config/database.php';
$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM jadwal WHERE id='$id'"));
$guru = mysqli_query($conn, "SELECT * FROM guru");
$kelas = mysqli_query($conn, "SELECT * FROM kelas");
$pemberitahuan = '';

if (isset($_POST['update'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $id_guru = $_POST['id_guru'];
    $id_kelas = $_POST['id_kelas'];

    $sql = "UPDATE jadwal SET hari='$hari', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai',
            id_guru='$id_guru', id_kelas='$id_kelas' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $pemberitahuan = "Jadwal berhasil diperbarui.";
    } else {
        $pemberitahuan = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jadwal</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
<div class="container">
    <h2>Edit Jadwal Mengajar</h2>
    <?php if ($pemberitahuan): ?>
        <div class="alert"<?= strpos($pemberitahuan, 'berhasil') ? 'success' : 'error' ?>">
            <?= $pemberitahuan ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <label>Hari:</label>
        <select name="hari" required>
            <?php
            foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h) {
                $selected = ($data['hari'] == $h) ? 'selected' : '';
                echo "<option $selected>$h</option>";
            }
            ?>
        </select><br>

        <label>Jam Mulai:</label>
        <input type="time" name="jam_mulai" value="<?= $data['jam_mulai'] ?>" required><br>
        <label>Jam Selesai:</label>
        <input type="time" name="jam_selesai" value="<?= $data['jam_selesai'] ?>" required><br>

        <label>Guru:</label>
        <select name="id_guru" required>
            <?php while ($g = mysqli_fetch_assoc($guru)) {
                $sel = ($data['id_guru'] == $g['id']) ? 'selected' : '';
                echo "<option value='{$g['id']}' $sel>{$g['nama_guru']} ({$g['mapel']})</option>";
            } ?>
        </select><br>

        <label>Kelas:</label>
        <select name="id_kelas" required>
            <?php while ($k = mysqli_fetch_assoc($kelas)) {
                $sel = ($data['id_kelas'] == $k['id']) ? 'selected' : '';
                echo "<option value='{$k['id']}' $sel>{$k['nama_kelas']}</option>";
            } ?>
        </select><br>

        <button type="submit" class="btn-simpanperubahan" name="update">Perbarui</button>
        <button type="button" class="btn-kembali" onclick="window.location.href='dashboard.php?page=data_jadwal'">Kembali</button>
    </form>
</div>
</body>
</html>
