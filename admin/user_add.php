<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../src/index.html");
    exit;
}
include '../koneksi.php';

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $level = $_POST['level'];

    if ($nama_lengkap && $username && $password && $level) {
        // Check if username already exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $pesan = "<div class='alert alert-danger'>Username sudah digunakan.</div>";
        } else {
            //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (nama_lengkap, username, password, role) VALUES ('$nama_lengkap', '$username', '$password', '$level')";
            if (mysqli_query($conn, $query)) {
                $pesan = "<div class='alert alert-success'>User berhasil ditambahkan.</div>";
            } else {
                $pesan = "<div class='alert alert-danger'>Gagal menambahkan user.</div>";
            }
        }
    } else {
        $pesan = "<div class='alert alert-warning'>Semua field harus diisi.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah User - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background:#1e3a8a;">
    <div class="container">
        <a class="navbar-brand text-white" href="index.php">Dashboard Admin</a>
        <div class="ml-auto d-flex align-items-center">
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
        }, 3000);
    </script>
    <h3>Tambah User Baru</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Level</label>
            <select name="level" class="form-control" required>
                <option value="">Pilih Level</option>
                <option value="admin">Admin</option>
                <option value="siswa">Siswa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah User</button>
    </form>
</div>
</body>
</html>
