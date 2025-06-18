<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../src/index.html");
    exit;
}
include '../koneksi.php';

$username = $_SESSION['username'];

$action = $_POST['action'] ?? '';
$id = intval($_POST['id'] ?? 0);

if ($action === 'delete' && $id > 0) {
    // Delete file record and physical file
    $result = mysqli_query($conn, "SELECT file FROM tugas WHERE id=$id AND nama_siswa='$username'");
    if ($row = mysqli_fetch_assoc($result)) {
        $filePath = '../uploads/' . $row['file'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $deleteQuery = "DELETE FROM tugas WHERE id=$id AND nama_siswa='$username'";
        if (mysqli_query($conn, $deleteQuery)) {
            $_SESSION['upload_success'] = "File berhasil dihapus.";
        } else {
            $_SESSION['upload_error'] = "Gagal menghapus file dari database.";
        }
    } else {
        $_SESSION['upload_error'] = "File tidak ditemukan atau tidak memiliki izin.";
    }
    header("Location: ../siswa/siswa_upload.php");
    exit;
} elseif ($action === 'edit' && $id > 0) {
    $judul_tugas = trim($_POST['judul_tugas'] ?? '');
    if ($judul_tugas) {
        $updateQuery = "UPDATE tugas SET judul_tugas=? WHERE id=? AND nama_siswa=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sis", $judul_tugas, $id, $username);
        if ($stmt->execute()) {
            $_SESSION['upload_success'] = "File berhasil diperbarui.";
        } else {
            $_SESSION['upload_error'] = "Gagal memperbarui file.";
        }
        $stmt->close();
    } else {
        $_SESSION['upload_error'] = "Judul tugas tidak boleh kosong.";
    }
    header("Location: ../siswa/siswa_upload.php");
    exit;
} else {
    $_SESSION['upload_error'] = "Aksi tidak valid.";
    header("Location: ../siswa/siswa_upload.php");
    exit;
}
?>
