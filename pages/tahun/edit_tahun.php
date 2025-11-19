<?php
include '../config/database.php';

$id = $_GET['id'];

// Gunakan prepared statement untuk mengambil data
$stmt = $conn->prepare("SELECT * FROM tahun_ajaran WHERE id_tahun_ajaran = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

$pemberitahuan = '';

if (isset($_POST['update'])) {
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $semester = $_POST['semester'];
    $status = $_POST['status'];

    // Jika status diubah menjadi Aktif, nonaktifkan tahun ajaran lain
    if ($status == 'Aktif') {
        $conn->query("UPDATE tahun_ajaran SET status='Nonaktif' WHERE id_tahun_ajaran != $id");
    }

    // Gunakan prepared statement untuk update
    $stmt = $conn->prepare("UPDATE tahun_ajaran SET tahun_ajaran=?, semester=?, status=? WHERE id_tahun_ajaran=?");
    $stmt->bind_param("sssi", $tahun_ajaran, $semester, $status, $id);

    if ($stmt->execute()) {
        $pemberitahuan = "Data tahun ajaran berhasil diperbarui.";
        // Refresh data setelah update
        $stmt2 = $conn->prepare("SELECT * FROM tahun_ajaran WHERE id_tahun_ajaran = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $data = $result2->fetch_assoc();
        $stmt2->close();
    } else {
        $pemberitahuan = "Gagal memperbarui data: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Tahun Ajaran</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <div class="container">
        <h2>Edit Tahun Ajaran</h2>
        <?php if ($pemberitahuan): ?>
            <div class="alert <?= strpos($pemberitahuan, 'berhasil') !== false ? 'success' : 'error' ?>">
                <?= $pemberitahuan ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <label>Tahun Ajaran:</label>
            <input type="text" name="tahun_ajaran" value="<?= htmlspecialchars($data['tahun_ajaran']) ?>"
                placeholder="contoh: 2025/2026" required><br>

            <label>Semester:</label>
            <select name="semester" required>
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil" <?= $data['semester'] == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                <option value="Genap" <?= $data['semester'] == 'Genap' ? 'selected' : '' ?>>Genap</option>
            </select><br>

            <label>Status:</label>
            <select name="status" required>
                <option value="Nonaktif">Nonaktif</option>
                <option value="Aktif">Aktif</option>
            </select><br>


            <button type="submit" class="btn-simpanperubahan" name="update">Perbarui</button>
            <button type="button" class="btn-kembali"
                onclick="window.location.href='dashboard.php?page=data_tahun'">Kembali</button>
        </form>
    </div>
</body>

</html>