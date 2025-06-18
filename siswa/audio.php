<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../src/index.html");
    exit;
}
include '../koneksi.php';

$username = $_SESSION['username'];

// Adjusted query to match your database table and column names
$query = "SELECT * FROM tugas WHERE nama_siswa = '$username'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Audio - Dashboard Siswa</title>
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
    <h3>Audio Saya</h3>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <?php if (pathinfo($row['file'], PATHINFO_EXTENSION) === 'mp3' || pathinfo($row['file'], PATHINFO_EXTENSION) === 'wav') { ?>
            <div class="col-md-4 mb-3">
                <audio controls>
                    <source src="../uploads/<?= htmlspecialchars($row['file']) ?>" type="audio/mpeg" />
                    Your browser does not support the audio element.
                </audio>
                <form method="POST" action="manage_upload.php" onsubmit="return confirm('Yakin ingin menghapus file ini?');" class="mt-2">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                    <input type="hidden" name="action" value="delete" />
                    <button type="submit" class="btn btn-danger btn-sm w-100">Hapus</button>
                </form>
                <button class="btn btn-secondary btn-sm mt-1 w-100" onclick="showEditForm(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['judul_tugas'])) ?>')">Edit</button>
                <form method="POST" action="manage_upload.php" id="editForm<?= $row['id'] ?>" style="display:none;" class="mt-2">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                    <input type="text" name="judul_tugas" value="<?= htmlspecialchars($row['judul_tugas']) ?>" class="form-control mb-1" required />
                    <button type="submit" class="btn btn-primary btn-sm w-100">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-sm w-100 mt-1" onclick="hideEditForm(<?= $row['id'] ?>)">Batal</button>
                </form>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
</body>
<script>
function showEditForm(id, judul) {
    document.getElementById('editForm' + id).style.display = 'block';
}
function hideEditForm(id) {
    document.getElementById('editForm' + id).style.display = 'none';
}
</script>
</html>
