<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../src/index.html");
    exit;
}
include '../koneksi.php';

$pesan = '';

// Proses hapus file & data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $q = mysqli_query($conn, "SELECT file FROM tugas WHERE id='$id'");
    $d = mysqli_fetch_assoc($q);
    if ($d) {
        $file_path = "../uploads/" . $d['file'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        mysqli_query($conn, "DELETE FROM tugas WHERE id='$id'");
        $pesan = "<div class='alert alert-danger'>Data dan file berhasil dihapus!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Audio - Dashboard Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background:#1e3a8a;">
    <div class="container">
        <a class="navbar-brand text-white" href="index.php">Dashboard Admin</a>
        <div class="ml-auto d-flex align-items-center">
            <a href="user_add.php" class="btn d-inline text-white m-0">Tambah User</a>
            <a href="user_list.php" class="btn d-inline text-white m-0">Daftar User</a>
            <a href="logout.php" class="nav-link d-inline text-white">Logout</a>
        </div>
    </div>
</nav>
    <div class="container mt-4">
        <?php if($pesan) echo $pesan; ?>
        <script>
            setTimeout(function() {
                var alert = document.querySelector('.alert');
                if(alert) {
                    alert.style.display = 'none';
                }
            }, 3000); // 3 seconds
        </script>
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link" href="gambar.php">Gambar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="audio.php">Audio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="video.php">Video</a>
            </li>
        </ul>
    <div class="card">
        <div class="card-body">
            <h4>Daftar Tugas Audio</h4>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Judul Tugas</th>
                        <th>File</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $q = mysqli_query($conn, "SELECT * FROM tugas WHERE (file LIKE '%.mp3' OR file LIKE '%.wav' OR file LIKE '%.m4a' OR file LIKE '%.aac')");
                while($row = mysqli_fetch_assoc($q)) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_siswa']}</td>
                        <td>{$row['judul_tugas']}</td>
                        <td><a href='../uploads/{$row['file']}' target='_blank'>Dengar</a></td>
                        <td>{$row['tanggal_upload']}</td>
                        <td>
                            <a href='?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus data dan file ini?')\">Hapus</a>
                        </td>
                    </tr>";
                    $no++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
