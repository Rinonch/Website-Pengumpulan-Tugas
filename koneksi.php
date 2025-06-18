<?php
$conn = mysqli_connect("localhost", "root", "", "pengumpulan_tugas");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>