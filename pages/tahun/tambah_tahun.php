<?php

$pemberitahuan = '';

if (isset($_POST['simpan'])) {
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $semester = $_POST['semester'];
    $status = $_POST['status'];

    // Jika status Aktif, nonaktifkan tahun ajaran lain
    if ($status == 'Aktif') {
        $conn->query("UPDATE tahun_ajaran SET status='Nonaktif'");
    }

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO tahun_ajaran (tahun_ajaran, semester, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tahun_ajaran, $semester, $status);

    if ($stmt->execute()) {
        $pemberitahuan = "Data tahun ajaran berhasil disimpan.";
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
    <title>Tambah Tahun Ajaran</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <div class="container">
        <h2>Tambah Tahun Ajaran</h2>
        <?php if ($pemberitahuan): ?>
            <div class="alert <?= strpos($pemberitahuan, 'berhasil') !== false ? 'success' : 'error' ?>">
                <?= $pemberitahuan ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Tahun Ajaran:</label>
            <input type="text" name="tahun_ajaran" placeholder="contoh: 2025/2026" required><br>

            <label>Semester:</label>
            <select name="semester" required>
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select><br>

            <label>Status:</label>
            <select name="status" required>
                <option value="Nonaktif">Nonaktif</option>
                <option value="Aktif">Aktif</option>
            </select><br>

            <button type="submit" class="btn-simpanperubahan" name="simpan">Simpan</button>
            <button type="button" class="btn-kembali"
                onclick="window.location.href='dashboard.php?page=data_tahun'">Kembali</button>
        </form>
    </div>
</body>

</html>