<?php
include '../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM guru WHERE id='$id'"));
$pemberitahuan = '';

if (isset($_POST['update'])) {
    $nama = $_POST['nama_guru'];
    $nip = $_POST['nip'];
    $mapel = $_POST['mapel'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    $sql = "UPDATE guru SET nama_guru='$nama', nip='$nip', mapel='$mapel', no_hp='$no_hp', email='$email' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        $pemberitahuan = "Data guru berhasil diperbarui.";
    } else {
        $pemberitahuan = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Guru</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <div class="container">
        <h2>Edit Data Guru</h2>
        <?php if ($pemberitahuan): ?>
            <div class="alert <?= strpos($pemberitahuan, 'berhasil') !== false ? 'success' : 'error' ?>">
                <?= $pemberitahuan ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <label>Nama Guru:</label>
            <input type="text" name="nama_guru" value="<?= $data['nama_guru'] ?>" required><br>

            <label>NIP:</label>
            <input type="text" name="nip" value="<?= $data['nip'] ?>" required><br>

            <label>Mata Pelajaran:</label>
            <input type="text" name="mapel" value="<?= $data['mapel'] ?>" required><br>

            <label>No. HP:</label>
            <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" required><br>

            <label>Email:</label>
            <input type="text" name="email" value="<?= $data['email'] ?>" required><br>


            <button type="submit" class="btn-simpanperubahan" name="update">Perbarui</button>
            <button type="button" class="btn-kembali"
                onclick="window.location.href='dashboard.php?page=data_guru'">Kembali</button>
        </form>
    </div>
</body>

</html>