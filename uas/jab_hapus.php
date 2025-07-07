<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM jabatan WHERE id_jab = '$id'");
header("Location: jabatan.php");
exit;
