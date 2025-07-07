<?php
session_start();

// Proteksi jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simpan file ke folder sementara
    $filename = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $targetPath = "uploads/" . basename($filename);

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($temp, $targetPath)) {

        // Pemetaan jabatan ke angka
        $jabatanMap = [
            'Staf HRD' => 1,
            'Staf Finance' => 2,
            'Kepala Bagian' => 3,
            'Supervisor' => 4,
            'Direktur' => 5
        ];

        if (($handle = fopen($targetPath, 'r')) !== false) {
            $row = 0;

            while (($line = fgets($handle)) !== false) {
                $line = trim($line, "\" \n\r\t");

                // Skip header
                if ($row === 0) {
                    $row++;
                    continue;
                }

                // Gunakan str_getcsv agar tetap bisa parsing format aneh
                $fields = str_getcsv($line);

                if (count($fields) < 4) continue;

                $no_induk = mysqli_real_escape_string($koneksi, trim($fields[0]));
                $nama     = mysqli_real_escape_string($koneksi, trim($fields[1]));
                $foto     = mysqli_real_escape_string($koneksi, trim($fields[2]));
                $jabatan  = trim($fields[3]);

                $id_jab = $jabatanMap[$jabatan] ?? 0;

                // Cek apakah sudah ada data
                $cek = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE no_induk = '$no_induk'");
                if (mysqli_num_rows($cek) > 0) {
                    mysqli_query($koneksi, "UPDATE karyawan SET nama='$nama', foto='$foto', id_jab='$id_jab' WHERE no_induk='$no_induk'");
                } else {
                    mysqli_query($koneksi, "INSERT INTO karyawan (no_induk, nama, foto, id_jab) VALUES ('$no_induk', '$nama', '$foto', '$id_jab')");
                }

                $row++;
            }

            fclose($handle);
        }

        header("Location: index.php");
        exit;

    } else {
        echo "Gagal upload file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h4>Import Data Karyawan (.csv)</h4>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>File CSV</label>
                    <input type="file" name="file" class="form-control" required accept=".csv">
                </div>
                <button type="submit" class="btn btn-warning">Import</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
