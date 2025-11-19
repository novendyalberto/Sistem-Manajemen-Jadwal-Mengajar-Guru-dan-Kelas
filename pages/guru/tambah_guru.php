<?php

$pemberitahuan = '';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_guru'];
    $nip = $_POST['nip'];
    $mapel = $_POST['mapel'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO guru (nama_guru, nip, mapel, no_hp, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $nip, $mapel, $no_hp, $email);

    if ($stmt->execute()) {
        $pemberitahuan = "Data guru berhasil disimpan.";
    } else {
        $pemberitahuan = "Gagal menyimpan data: " . $stmt->error;
    }
    $stmt->close();
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
            <div class="alert <?= strpos($pemberitahuan, 'berhasil') !== false ? 'success' : 'error' ?>">
                <?= $pemberitahuan ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Nama Guru:</label>
            <input type="text" name="nama_guru" required><br>

            <label>NIP:</label>
            <input type="text" name="nip"><br>

            <label>Mata Pelajaran:</label>
            <input type="text" name="mapel" required><br>

            <label>No. HP:</label>
            <input type="text" name="no_hp"><br>

            <label>Email:</label>
            <input type="email" name="email"><br>

            <button type="submit" class="btn-simpanperubahan" name="simpan">Simpan</button>
            <button type="button" class="btn-kembali"
                onclick="window.location.href='dashboard.php?page=data_guru'">Kembali</button>
        </form>
    </div>
</body>

</html>