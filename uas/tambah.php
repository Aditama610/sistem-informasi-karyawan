<?php
session_start();

// Proteksi jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_induk = $_POST['no_induk'];
    $nama = $_POST['nama'];
    $id_jab = $_POST['id_jab'];
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];

    move_uploaded_file($tmp, "file/" . $foto);

    // Cek apakah no_induk sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE no_induk='$no_induk'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($koneksi, "INSERT INTO karyawan (no_induk, nama, foto, id_jab) VALUES ('$no_induk', '$nama', '$foto', '$id_jab')");
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('No Induk sudah ada. Data tidak disimpan.');</script>";
    }
}

// Ambil semua jabatan
$jabatan = mysqli_query($koneksi, "SELECT * FROM jabatan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
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
            <h3 class="mb-4">Tambah Data Karyawan</h3>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="no_induk" class="form-label">No Induk</label>
                    <input type="text" name="no_induk" id="no_induk" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_jab" class="form-label">Jabatan</label>
                    <select name="id_jab" id="id_jab" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        <?php while ($j = mysqli_fetch_assoc($jabatan)): ?>
                            <option value="<?= $j['id_jab'] ?>"><?= $j['nama_jab'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.form.submit();">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
