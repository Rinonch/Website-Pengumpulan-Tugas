<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../src/index.html");
    exit;
}
include '../koneksi.php';

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis = $_POST['jenis'] ?? '';
    $judul_tugas = trim($_POST['judul_tugas'] ?? '');
    $file = $_FILES['file'] ?? null;

    if ($jenis && $judul_tugas && $file && $file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $filename = basename($file['name']);
        $targetFilePath = $uploadDir . $filename;

        // Validate file type based on jenis
        $allowedTypes = [
            'gambar' => ['jpg', 'jpeg', 'png', 'gif'],
            'audio' => ['mp3', 'wav', 'ogg'],
            'video' => ['mp4', 'avi', 'mov', 'wmv']
        ];

        $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($fileExt, $allowedTypes[$jenis])) {
            $_SESSION['upload_error'] = "Tipe file tidak sesuai untuk jenis $jenis.";
            header("Location: siswa_upload.php");
            exit;
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            $tanggal_upload = date('Y-m-d');
            $stmt = $conn->prepare("INSERT INTO tugas (nama_siswa, judul_tugas, file, tanggal_upload) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $judul_tugas, $filename, $tanggal_upload);
            if ($stmt->execute()) {
                $_SESSION['upload_success'] = "File berhasil diupload.";
            } else {
                $_SESSION['upload_error'] = "Gagal menyimpan data ke database.";
            }
            $stmt->close();
        } else {
            $_SESSION['upload_error'] = "Gagal mengupload file.";
        }
    } else {
        $_SESSION['upload_error'] = "Semua field harus diisi dan file harus dipilih.";
    }
    header("Location: siswa_upload.php");
    exit;
}
?>
