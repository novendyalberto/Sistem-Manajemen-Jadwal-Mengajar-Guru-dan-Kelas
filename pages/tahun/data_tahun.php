<?php
include '../config/database.php';

// Proses hapus data
if (isset($_GET['hapus']) && isset($_GET['id'])) {
  $id = $_GET['id'];

  // Cek apakah tahun ajaran masih digunakan di jadwal
  $cek_jadwal = $conn->prepare("SELECT COUNT(*) as jumlah FROM jadwal WHERE tahun_ajaran_id = ?");
  $cek_jadwal->bind_param("i", $id);
  $cek_jadwal->execute();
  $result_cek = $cek_jadwal->get_result();
  $data_cek = $result_cek->fetch_assoc();
  $cek_jadwal->close();

  if ($data_cek['jumlah'] > 0) {
    echo "<script>
                alert('Gagal menghapus! Tahun ajaran ini masih digunakan di jadwal.');
                window.location.href='dashboard.php?page=data_tahun';
              </script>";
  } else {
    // Hapus data tahun ajaran
    $stmt = $conn->prepare("DELETE FROM tahun_ajaran WHERE id_tahun_ajaran = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      echo "<script>
                    alert('Data tahun ajaran berhasil dihapus.');
                    window.location.href='dashboard.php?page=data_tahun';
                  </script>";
    } else {
      echo "<script>
                    alert('Gagal menghapus data: {$stmt->error}');
                    window.location.href='dashboard.php?page=data_tahun';
                  </script>";
    }
    $stmt->close();
  }
  exit;
}

// Proses aktivasi tahun ajaran
if (isset($_GET['aktivasi']) && isset($_GET['id'])) {
  $id = $_GET['id'];

  // Nonaktifkan semua tahun ajaran
  $conn->query("UPDATE tahun_ajaran SET status='Nonaktif'");

  // Aktifkan tahun ajaran yang dipilih
  $stmt = $conn->prepare("UPDATE tahun_ajaran SET status='Aktif' WHERE id_tahun_ajaran = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo "<script>
                alert('Tahun ajaran berhasil diaktifkan.');
                window.location.href='dashboard.php?page=data_tahun';
              </script>";
  } else {
    echo "<script>
                alert('Gagal mengaktifkan tahun ajaran.');
                window.location.href='dashboard.php?page=data_tahun';
              </script>";
  }
  $stmt->close();
  exit;
}
?>

<div class="data-section">
  <div class="data-header">
    <h2>Data Tahun Ajaran</h2>
    <a href="dashboard.php?page=tambah_tahun" class="btn-tambah">+ Tambah Tahun Ajaran</a>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Tahun Ajaran</th>
        <th>Semester</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $query = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY tahun_ajaran DESC, semester");

      if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
          // Escape output untuk mencegah XSS
          $tahun_ajaran = htmlspecialchars($row['tahun_ajaran'] ?? '');
          $semester = htmlspecialchars($row['semester'] ?? '');
          $status = htmlspecialchars($row['status'] ?? 'Aktif');
          $id = (int) ($row['id_tahun_ajaran'] ?? 0);

          // Badge status
          $badge_class = ($status == 'Aktif') ? 'badge-aktif' : 'badge-nonaktif';

          echo "<tr>
                  <td>{$no}</td>
                  <td>{$tahun_ajaran}</td>
                  <td>{$semester}</td>
                  <td><span class='{$badge_class}'>{$status}</span></td>
                  <td>
                    <a href='dashboard.php?page=edit_tahun&id={$id}' class='btn-edit'>Edit</a>";

          echo "    <a href='dashboard.php?page=data_tahun&hapus=1&id={$id}'
                       class='btn-delete'
                       onclick=\"return confirm('Yakin ingin menghapus tahun ajaran {$tahun_ajaran} {$semester}?')\">Hapus</a>
                  </td>
                </tr>";
          $no++;
        }
      } else {
        echo "<tr><td colspan='5' style='text-align:center;'>Belum ada data tahun ajaran</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>