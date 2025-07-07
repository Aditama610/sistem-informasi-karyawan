<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Hapus semua data dari tabel karyawan
mysqli_query($koneksi, "DELETE FROM karyawan");

// Redirect kembali ke index.php
header("Location: index.php");
exit;
