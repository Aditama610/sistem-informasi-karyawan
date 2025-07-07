<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$result = mysqli_query($koneksi, "SELECT * FROM jabatan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-diagram-3-fill me-2"></i>Data Jabatan
        </a>
        <span class="text-white">Login sebagai: <?= $_SESSION['user'] ?></span>
    </div>
</nav>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><i class="bi bi-list-check me-2"></i>Daftar Jabatan</h3>
        <div>
            <a href="jab_tambah.php" class="btn btn-success me-2">
                <i class="bi bi-plus-circle"></i> Tambah Jabatan
            </a>
            <a href="index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Jabatan</th>
                        <th scope="col">Nama Jabatan</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['id_jab']) ?></td>
                            <td><?= htmlspecialchars($row['nama_jab']) ?></td>
                            <td class="text-center">
                                <a href="jab_edit.php?id=<?= $row['id_jab'] ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="jab_hapus.php?id=<?= $row['id_jab'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="bi bi-exclamation-circle fs-4"></i>
                                <p class="mt-2 mb-0">Belum ada data jabatan.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="bg-light py-3 mt-5 border-top">
    <div class="container text-center small text-muted">
        &copy; <?= date('Y') ?> Sistem Informasi Karyawan - Kelompok 9
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
