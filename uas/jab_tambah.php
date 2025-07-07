<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_jab'];
    $nama = $_POST['nama_jab'];

    mysqli_query($koneksi, "INSERT INTO jabatan (id_jab, nama_jab) VALUES ('$id', '$nama')");
    header("Location: jabatan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Jabatan</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">ID Jabatan</label>
                    <input type="text" name="id_jab" class="form-control" placeholder="Contoh: JB001" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="nama_jab" class="form-control" placeholder="Contoh: Manager" required>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="jabatan.php" class="btn btn-secondary me-2"><i class="bi bi-arrow-left"></i> Batal</a>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
