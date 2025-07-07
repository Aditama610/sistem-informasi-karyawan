<?php
session_start();

// Proteksi jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
$no_induk = $_GET['no_induk'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM karyawan WHERE no_induk='$no_induk'"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $id_jab = $_POST['id_jab'];

    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "file/" . $foto);
        mysqli_query($koneksi, "UPDATE karyawan SET nama='$nama', foto='$foto', id_jab='$id_jab' WHERE no_induk='$no_induk'");
    } else {
        mysqli_query($koneksi, "UPDATE karyawan SET nama='$nama', id_jab='$id_jab' WHERE no_induk='$no_induk'");
    }

    header("Location: index.php");
}

$jabatan = mysqli_query($koneksi, "SELECT * FROM jabatan");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-4">Edit Data Karyawan</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Baru (jika ingin diubah)</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="id_jab" class="form-label">Jabatan</label>
                    <select name="id_jab" id="id_jab" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php while ($j = mysqli_fetch_assoc($jabatan)): ?>
                            <option value="<?= $j['id_jab'] ?>" <?= ($j['id_jab'] == $data['id_jab']) ? 'selected' : '' ?>><?= $j['nama_jab'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
