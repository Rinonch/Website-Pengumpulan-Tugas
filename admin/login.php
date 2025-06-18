<?php
session_start();
include '../koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: index.php");
    } else {
        header("Location: ../siswa/siswa_upload.php");
    }
    exit;
} else {
    echo "<script>alert('Username atau password salah!');window.location='../src/index.html';</script>";
}
?>