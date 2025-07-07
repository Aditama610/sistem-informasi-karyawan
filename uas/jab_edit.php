<?php
include 'koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM jabatan WHERE id_jab = '$id'");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_jab'];
    mysqli_query($koneksi, "UPDATE jabatan SET nama_jab = '$nama' WHERE id_jab = '$id'");
    header("Location: jabatan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Jabatan</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">ID Jabatan</label>
                    <input type="text" name="id_jab" class="form-control" value="<?= $data['id_jab'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="nama_jab" class="form-control" value="<?= $data['nama_jab'] ?>" required>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="jabatan.php" class="btn btn-secondary me-2"><i class="bi bi-arrow-left"></i> Batal</a>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
