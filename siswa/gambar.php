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
    <title>Gambar - Dashboard Siswa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            background: #f4f6fb;
            font-family: 'Inter', sans-serif;
        }
        body {
            scroll-snap-type: y mandatory;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
        }
        .snap-section {
            scroll-snap-align: start;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: white;
            position: relative;
            box-shadow: 0 8px 40px rgba(30,58,138,0.10);
            margin: 3rem auto;
            max-width: 480px;
            border-radius: 2rem;
            padding: 2.5rem 2.5rem 3.5rem 2.5rem;
        }
        .snap-section img {
            max-height: 70vh;
            max-width: 100%;
            border-radius: 1.2rem;
            object-fit: contain;
            box-shadow: 0 4px 24px rgba(30,58,138,0.10);
            transition: transform 0.3s ease;
        }
        .snap-section img:hover {
            transform: scale(1.05);
        }
        .btn-group {
            position: absolute;
            bottom: 20px;
            width: calc(100% - 40px);
            display: flex;
            justify-content: space-between;
        }
        .btn-group form, .btn-group button {
            flex: 1;
            margin: 0 5px;
            border-radius: 1rem;
            border: none;
            padding: 0.75rem 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-group form button {
            background-color: #f44336;
            color: white;
        }
        .btn-group form button:hover {
            background-color: #c62828;
        }
        .btn-group button {
            background-color: #6c757d;
            color: white;
        }
        .btn-group button:hover {
            background-color: #5a6268;
        }
        .btn-back {
            position: fixed;
            top: 1rem;
            left: 1rem;
            background-color: #1e3a8a;
            color: white;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 2rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 40px rgba(30,58,138,0.10);
            transition: background-color 0.3s ease;
            z-index: 1100;
        }
        .btn-back:hover {
            background-color: #0b2566;
        }
    </style>
</head>
<body>
<button class="btn-back" onclick="window.location.href='siswa_upload.php'">← Dashboard</button>
<div>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <?php if (pathinfo($row['file'], PATHINFO_EXTENSION) === 'jpg' || pathinfo($row['file'], PATHINFO_EXTENSION) === 'png' || pathinfo($row['file'], PATHINFO_EXTENSION) === 'jpeg') { ?>
        <section class="snap-section">
            <img src="../uploads/<?= htmlspecialchars($row['file']) ?>" alt="Gambar" />
            <div style="margin-top: 10px; text-align: center;">
                <h3><?= htmlspecialchars($row['judul_tugas']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['deskripsi'] ?? '')) ?></p>
            </div>
        <div class="btn-group" style="position: static; margin-top: 15px; justify-content: center; gap: 10px;">
            <form method="POST" action="manage_upload.php" onsubmit="return confirm('Yakin ingin menghapus file ini?');" style="margin: 0;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                <input type="hidden" name="action" value="delete" />
                <button type="submit" class="btn btn-danger btn-sm px-4 py-2 rounded font-weight-bold" style="min-width: 120px;">Hapus</button>
            </form>
            <button class="btn btn-secondary btn-sm px-4 py-2 rounded font-weight-bold" style="min-width: 120px; height: 38px; line-height: 1.5; font-size: 1rem; display: flex; justify-content: center; align-items: center; white-space: nowrap; box-shadow: 0 2px 6px rgba(0,0,0,0.15); transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#5a6268'" onmouseout="this.style.backgroundColor='#6c757d'" onclick="showEditForm(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['judul_tugas'])) ?>')">Edit</button>
        </div>
            <form method="POST" action="manage_upload.php" id="editForm<?= $row['id'] ?>" style="display:none; margin-top: 10px; display: flex; gap: 10px; align-items: center;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                <input type="hidden" name="action" value="edit" />
                <input type="text" name="judul_tugas" value="<?= htmlspecialchars($row['judul_tugas']) ?>" class="form-control flex-grow-1" required style="padding: 8px 12px; font-size: 1rem; border-radius: 0.375rem; border: 1px solid #ced4da;" />
                <button type="submit" class="btn btn-primary btn-sm px-4 py-1 rounded font-weight-bold" style="min-width: 120px;">Simpan</button>
                <button type="button" class="btn btn-secondary btn-sm px-4 py-1 rounded font-weight-bold" style="min-width: 120px;" onclick="hideEditForm(<?= $row['id'] ?>)">Batal</button>
            </form>
        </section>
        <?php } ?>
    <?php } ?>
</div>

<script>
function showEditForm(id, judul) {
    document.getElementById('editForm' + id).style.display = 'block';
}

function hideEditForm(id) {
    document.getElementById('editForm' + id).style.display = 'none';
}
</script>

</body>
</html>
