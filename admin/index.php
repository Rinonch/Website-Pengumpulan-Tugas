<?php
session_start();
// Cek jika belum login, redirect ke halaman login utama
if (!isset($_SESSION['username'])) {
    header("Location: ../src/index.html");
    exit;
}
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<!-- Navbar Admin -->
<nav class="navbar navbar-expand-lg" style="background:#1e3a8a;">
    <div class="container">
        <a class="navbar-brand text-white" href="index.php">Dashboard Admin</a>
        <div class="ml-auto d-flex align-items-center">
            <a href="user_add.php" class="btn d-inline text-white m-0">Tambah User</a>
            <a href="user_list.php" class="btn d-inline text-white m-0">Daftar User</a>
            <a href="logout.php" class="nav-link d-inline text-white m-0">Logout</a>
        </div>
    </div>
</nav>
<div class="container mt-4">
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
    <div class="card">
        <div class="card-body">
            <h4>Selamat datang di Dashboard Admin!</h4>
            <p>Pilih menu di atas untuk mengelola dan mengupload file sesuai tipe.</p>
        </div>
    </div>
</div>
</body>
</html>