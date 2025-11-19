<?php
include '../config/database.php';

$guru = mysqli_query($conn, "SELECT * FROM guru");
$kelas = mysqli_query($conn, "SELECT * FROM kelas");
$tahun = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY id_tahun_ajaran DESC");

$pemberitahuan = '';

if (isset($_POST['simpan'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $id_guru = $_POST['id_guru'];
    $id_kelas = $_POST['id_kelas'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];

    $sql = "INSERT INTO jadwal (hari, jam_mulai, jam_selesai, id_guru, id_kelas, tahun_ajaran_id)
            VALUES ('$hari', '$jam_mulai', '$jam_selesai', '$id_guru', '$id_kelas', '$tahun_ajaran_id')";

    if (mysqli_query($conn, $sql)) {
        $pemberitahuan = "Jadwal berhasil ditambahkan.";
    } else {
        $pemberitahuan = "Gagal menambahkan jadwal: " . mysqli_error($conn);
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
            <div class="alert <?= strpos($pemberitahuan, 'berhasil') ? 'success' : 'error' ?>">
                <?= $pemberitahuan ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Tahun Ajaran:</label>
            <select name="tahun_ajaran_id" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                <?php while ($t = mysqli_fetch_assoc($tahun)): ?>
                    <option value="<?= $t['id_tahun_ajaran'] ?>">
                        <?= $t['tahun_ajaran'] ?> - <?= $t['semester'] ?>)
                    </option>
                <?php endwhile; ?>
            </select><br>

            <label>Hari:</label>
            <select name="hari" required>
                <option value="">-- Pilih Hari --</option>
                <?php foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h): ?>
                    <option value="<?= $h ?>"><?= $h ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Jam Mulai:</label>
            <input type="time" name="jam_mulai" required><br>

            <label>Jam Selesai:</label>
            <input type="time" name="jam_selesai" required><br>

            <label>Guru:</label>
            <select name="id_guru" required>
                <option value="">-- Pilih Guru --</option>
                <?php while ($g = mysqli_fetch_assoc($guru)): ?>
                    <option value="<?= $g['id'] ?>"><?= $g['nama_guru'] ?> (<?= $g['mapel'] ?>)</option>
                <?php endwhile; ?>
            </select><br>

            <label>Kelas:</label>
            <select name="id_kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <?php while ($k = mysqli_fetch_assoc($kelas)): ?>
                    <option value="<?= $k['id'] ?>"><?= $k['nama_kelas'] ?></option>
                <?php endwhile; ?>
            </select><br>



            <button type="submit" class="btn-simpanperubahan" name="simpan">Simpan</button>
            <button type="button" class="btn-kembali"
                onclick="window.location.href='dashboard.php?page=data_jadwal'">Kembali</button>
        </form>
    </div>
</body>

</html>