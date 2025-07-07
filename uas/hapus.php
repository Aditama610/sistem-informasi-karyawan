<?php
session_start();

// Proteksi jika belum login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
$no_induk = $_GET['no_induk'];
mysqli_query($koneksi, "DELETE FROM karyawan WHERE no_induk='$no_induk'");
header("Location: index.php");
?>