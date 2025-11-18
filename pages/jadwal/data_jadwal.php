<?php
include '../config/database.php';

// Inisialisasi variabel filter
$filter_hari = isset($_GET['hari']) ? $_GET['hari'] : '';
$filter_guru = isset($_GET['guru']) ? $_GET['guru'] : '';
$filter_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Query filter dasar
$query = "
    SELECT j.*, g.nama_guru, g.mapel, k.nama_kelas
    FROM jadwal j
    LEFT JOIN guru g ON j.id_guru = g.id
    LEFT JOIN kelas k ON j.id_kelas = k.id
    WHERE 1=1
";

// Tambahkan kondisi filter
if ($filter_hari != '') {
    $query .= " AND j.hari = '$filter_hari'";
}
if ($filter_guru != '') {
    $query .= " AND g.id = '$filter_guru'";
}
if ($filter_kelas != '') {
    $query .= " AND k.id = '$filter_kelas'";
}
if ($cari != '') {
    $query .= " AND (g.nama_guru LIKE '%$cari%' OR g.mapel LIKE '%$cari%')";
}

$query .= "
    ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), j.jam_mulai
";
$result = mysqli_query($conn, $query);
?>

<div class="data-section">
  <div class="data-header">
    <h2>Data Jadwal Mengajar</h2>
   <a href="dashboard.php?page=tambah_jadwal" class="btn-tambah">+ Tambah Jadwal</a>
  </div>

  <!-- Filter dan Pencarian -->
  <form method="GET" class="filter-form">
    <input type="hidden" name="page" value="data_jadwal">
    
    <label>Hari:</label>
    <select name="hari">
      <option value="">Semua</option>
      <?php 
        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        foreach ($hariList as $hari) {
            $selected = ($filter_hari == $hari) ? 'selected' : '';
            echo "<option value='$hari' $selected>$hari</option>";
        }
      ?>
    </select>

    <label>Guru:</label>
    <select name="guru">
      <option value="">Semua</option>
      <?php
        $guruList = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama_guru");
        while ($g = mysqli_fetch_assoc($guruList)) {
            $selected = ($filter_guru == $g['id']) ? 'selected' : '';
            echo "<option value='{$g['id']}' $selected>{$g['nama_guru']}</option>";
        }
      ?>
    </select>

    <label>Kelas:</label>
    <select name="kelas">
      <option value="">Semua</option>
      <?php
        $kelasList = mysqli_query($conn, "SELECT * FROM kelas ORDER BY nama_kelas");
        while ($k = mysqli_fetch_assoc($kelasList)) {
            $selected = ($filter_kelas == $k['id']) ? 'selected' : '';
            echo "<option value='{$k['id']}' $selected>{$k['nama_kelas']}</option>";
        }
      ?>
    </select>

    <input type="text" name="cari" placeholder="Cari guru / mapel..." value="<?= htmlspecialchars($cari) ?>">

    <button type="submit" class="btn-filter">Terapkan</button>
    <a href="dashboard.php?page=data_jadwal" class="btn-reset">Reset</a>
  </form>

  <!-- Tabel Data Jadwal -->
  <table class="data-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Hari</th>
        <th>Jam</th>
        <th>Guru</th>
        <th>Mata Pelajaran</th>
        <th>Kelas</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$no}</td>
                  <td>{$row['hari']}</td>
                  <td>{$row['jam_mulai']} - {$row['jam_selesai']}</td>
                  <td>{$row['nama_guru']}</td>
                  <td>{$row['mapel']}</td>
                  <td>{$row['nama_kelas']}</td>
                  <td>
                    <a href='dashboard.php?page=edit_jadwal&id={$row['id']}' class='btn-edit'>Edit</a>
                    <a href='dashboard.php?page=data_jadwal&hapus=1&id={$row['id']}' class='btn-delete' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                  </td>
                </tr>";
          $no++;
        }
      } else {
        echo "<tr><td colspan='7' style='text-align:center;'>Data tidak ditemukan</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>