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

// Proses upload video
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_tugas'])) {
    $nama_admin = $_SESSION['admin_username'];
    $judul_tugas = $_POST['judul_tugas'];
    $tanggal_upload = date('Y-m-d');
    $file = $_FILES['file_tugas'];
    $allowed_types = ['video/mp4', 'video/3gpp', 'video/avi'];
    $file_name = time() . '_' . basename($file['name']);
    $target_dir = "../uploads/";
    $target_file = $target_dir . $file_name;

    if (in_array($file['type'], $allowed_types)) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $query = "INSERT INTO tugas (nama_siswa, judul_tugas, file, tanggal_upload) VALUES ('$nama_admin', '$judul_tugas', '$file_name', '$tanggal_upload')";
            mysqli_query($conn, $query);
            $pesan = "<div class='alert alert-success'>Upload berhasil!</div>";
        } else {
            $pesan = "<div class='alert alert-danger'>Upload gagal!</div>";
        }
    } else {
        $pesan = "<div class='alert alert-warning'>Tipe file tidak didukung!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Video - Dashboard Admin</title>
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
                <a class="nav-link" href="audio.php">Audio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="video.php">Video</a>
            </li>
        </ul>
    <div class="card">
        <div class="card-body">
            <h4>Daftar Tugas Video</h4>
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
$q = mysqli_query($conn, "SELECT * FROM tugas WHERE (file LIKE '%.mp4' OR file LIKE '%.3gp' OR file LIKE '%.avi')");
while($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td>{$no}</td>
        <td>{$row['nama_siswa']}</td>
        <td>{$row['judul_tugas']}</td>
        <td><a href='../uploads/{$row['file']}' target='_blank'>Tonton</a></td>
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
