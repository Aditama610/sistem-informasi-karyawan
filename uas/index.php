<?php
session_start();

// Proteksi jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Ambil search dan filter
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 3;
$offset = ($page - 1) * $limit;

// Perlu join jabatan untuk WHERE yang mencakup nama_jab
$whereCount = "
    WHERE karyawan.no_induk LIKE '%$search%' 
    OR karyawan.nama LIKE '%$search%' 
    OR jabatan.nama_jab LIKE '%$search%'
";

// Total data untuk pagination
$totalDataQuery = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total 
    FROM karyawan 
    JOIN jabatan ON karyawan.id_jab = jabatan.id_jab 
    $whereCount
");
$totalData = mysqli_fetch_assoc($totalDataQuery)['total'];
$totalPages = ceil($totalData / $limit);

// Query data utama
$where = "
    WHERE karyawan.no_induk LIKE '%$search%' 
    OR karyawan.nama LIKE '%$search%' 
    OR jabatan.nama_jab LIKE '%$search%'
";
$sql = "
    SELECT karyawan.*, jabatan.nama_jab 
    FROM karyawan 
    JOIN jabatan ON karyawan.id_jab = jabatan.id_jab 
    $where 
    LIMIT $limit OFFSET $offset
";
$result = mysqli_query($koneksi, $sql);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="file/logo.png" alt="Logo">
        </a>
        <div class="d-flex">
            <span class="text-light me-3 d-none d-sm-block">Welcome, <?= $_SESSION['user'] ?></span>
            <a href="logout.php" class="btn btn-outline-light">
                <i class="bi bi-box-arrow-right"></i>
                <span class="d-none d-sm-inline">Logout</span>
            </a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">
            <i class="bi bi-people me-2"></i>Data Karyawan
        </h2>
        <div class="d-flex">
            <a href="tambah.php" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i>Tambah
            </a>
            <a href="jabatan.php" class="btn btn-secondary me-2">
                <i class="bi bi-diagram-3 me-1"></i>Data Jabatan
            </a>

            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-1"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="export_excel.php">Export CSV</a></li>
                    <li><a class="dropdown-item" href="import_excel.php">Import CSV</a></li>
                </ul>
            </div>

            

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <form class="row g-2" method="get">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan No Induk / Nama / Jabatan..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="index.php" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="karyawan_hapus_semua.php" class="btn btn-outline-danger me-2"
                        onclick="return confirm('Yakin ingin menghapus SEMUA data karyawan? Tindakan ini tidak bisa dibatalkan!')">
                        <i class="bi bi-trash-fill"></i> Hapus Semua
                    </a>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Jabatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $no = $offset + 1; while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['no_induk'] ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><img src="file/<?= $row['foto'] ?>" alt="Foto Karyawan" class="img-thumbnail"></td>
                                <td><span class="badge bg-primary"><?= $row['nama_jab'] ?></span></td>
                                <td class="text-center">
                                    <a href="edit.php?no_induk=<?= $row['no_induk'] ?>" class="btn btn-sm btn-warning action-btn">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                    <a href="hapus.php?no_induk=<?= $row['no_induk'] ?>" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-exclamation-circle fs-1 text-muted"></i>
                                <p class="mt-2">Tidak ada data ditemukan</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= $search ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    
                    <?php 
                    $start = max(1, $page - 2);
                    $end = min($totalPages, $page + 2);
                    
                    if ($start > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1&search='.$search.'">1</a></li>';
                        if ($start > 2) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                    }
                    
                    for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; 
                    
                    if ($end < $totalPages) {
                        if ($end < $totalPages - 1) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        echo '<li class="page-item"><a class="page-link" href="?page='.$totalPages.'&search='.$search.'">'.$totalPages.'</a></li>';
                    }
                    ?>
                    
                    <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= $search ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<footer class="bg-dark text-white py-4 shadow-lg">
    <div class="container">
        <div class="row text-center text-md-start align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="fw-bold mb-2">Sistem Informasi Karyawan</h5>
                <p class="mb-0">&copy; <?= date('Y') ?> All rights reserved.</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-semibold mb-2">Kelompok 9</h6>
                <ul class="list-unstyled mb-0">
                    <li><i class="bi bi-person-fill me-2"></i>Ahmad Izzuddin – <span class="fw-light">2023TI003</span></li>
                    <li><i class="bi bi-person-fill me-2"></i>Habib Yasir Muhyiddin– <span class="fw-light">2023TI013</span></li>
                    <li><i class="bi bi-person-fill me-2"></i>Muhammad Fadillah Aditama – <span class="fw-light">2023TIP04</span></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
