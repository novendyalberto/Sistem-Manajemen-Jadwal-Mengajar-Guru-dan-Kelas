<?php
include '../config/database.php';
?>

<div class="data-section">
  <div class="data-header">
    <h2>Data Guru</h2>
    <a href="dashboard.php?page=tambah_guru" class="btn-tambah">+ Tambah Guru</a>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Guru</th>
        <th>Mata Pelajaran</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $query = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama_guru ASC");

      if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
          echo "
          <tr>
            <td>{$no}</td>
            <td>{$row['nama_guru']}</td>
            <td>{$row['mapel']}</td>
            <td>
              <a href='dashboard.php?page=edit_guru&id={$row['id']}' class='btn-edit'>Edit</a>
              <a href='dashboard.php?page=data_guru&hapus=1&id={$row['id']}'
                 class='btn-delete'
                 onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
            </td>
          </tr>";
          $no++;
        }
      } else {
        echo "<tr><td colspan='4' style='text-align:center;'>Belum ada data guru</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
