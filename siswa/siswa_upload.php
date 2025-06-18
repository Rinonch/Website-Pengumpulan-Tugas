<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../src/index.html");
    exit;
}
include '../koneksi.php';

$username = $_SESSION['username'];

$uploadSuccess = $_SESSION['upload_success'] ?? '';
$uploadError = $_SESSION['upload_error'] ?? '';
unset($_SESSION['upload_success'], $_SESSION['upload_error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background:#1e3a8a;">
    <div class="container">
        <a class="navbar-brand text-white" href="siswa_upload.php">Dashboard Siswa</a>
        <div class="ml-auto">
            <a href="logout.php" class="nav-link d-inline text-white">Logout</a>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <?php if ($uploadSuccess): ?>
        <div class="alert alert-success" role="alert"><?= htmlspecialchars($uploadSuccess) ?></div>
    <?php endif; ?>
    <?php if ($uploadError): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($uploadError) ?></div>
    <?php endif; ?>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='gambar.php') echo ' active'; ?>" href="gambar.php">Gambar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='audio.php') echo ' active'; ?>" href="audio.php">Audio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='video.php') echo ' active'; ?>" href="video.php">Video</a>
        </li>
    </ul>

    <div class="card mb-4">
        <div class="card-body">
            <h4>Upload File</h4>
            <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="judul_tugas">Judul Tugas</label>
                    <input type="text" name="judul_tugas" id="judul_tugas" class="form-control" required />
                </div>
                <div class="form-group mb-3">
                    <label for="jenis">Jenis File</label>
                    <select name="jenis" id="jenis" class="form-control" required>
                        <option value="">Pilih Jenis</option>
                        <option value="gambar">Gambar</option>
                        <option value="audio">Audio</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="file">Pilih File</label>
                    <input type="file" name="file" id="file" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <p>Pilih tab di atas untuk melihat file yang sudah diupload.</p>
</div>
</body>
</html>
