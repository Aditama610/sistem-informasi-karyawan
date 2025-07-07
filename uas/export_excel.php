<?php
session_start();

// Proteksi jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="data_karyawan.csv"');

$output = fopen('php://output', 'w');

// Tulis header kolom
fputcsv($output, ['No Induk', 'Nama', 'Foto', 'Jabatan']);

// Ambil data dari database
$query = mysqli_query($koneksi, "SELECT * FROM karyawan, jabatan
        where karyawan.id_jab = jabatan.id_jab");
while ($row = mysqli_fetch_assoc($query)) {
    fputcsv($output, [$row['no_induk'], $row['nama'], $row['foto'], $row['nama_jab']]);
}

fclose($output);
exit;
?>