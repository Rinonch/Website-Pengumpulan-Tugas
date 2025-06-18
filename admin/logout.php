<?php
session_start();
session_unset();
session_destroy();

// Hapus cache agar tidak bisa kembali dengan tombol back
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect ke halaman login
header("Location: ../src/index.html");
exit;
?>