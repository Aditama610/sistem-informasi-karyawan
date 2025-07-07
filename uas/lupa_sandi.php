<?php
include 'koneksi.php';
session_start();

if (isset($_POST['reset'])) {
    $user  = $_POST['user'];
    $email = $_POST['email'];
    $newpass =($_POST['newpass']);

    // Cek apakah user dan email cocok
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE user = '$user' AND email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        // Update password
        mysqli_query($koneksi, "UPDATE users SET pass = '$newpass' WHERE user = '$user'");
        echo "<script>alert('Password berhasil diubah! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Data tidak cocok. Username atau email salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/style.css">
    
</head>
<body>
<div class="container">
    <div class="form-box login">
        <form method="post">
            <h1>Reset Password</h1>
            <div class="input-box">
                <input type="text" name="user" placeholder="Username" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email yang terdaftar" required>
            </div>
            <div class="input-box">
                <input type="password" name="newpass" placeholder="Password Baru" required>
            </div>
            <button type="submit" class="btn" name="reset">Reset Password</button>
            <div class="input-box text-center">
                <a href="login.php">Kembali ke Login</a>
            </div>
        </form>
    </div>

    <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Please, Enter <br> New Password!</h1>
            </div>
        </div>
</div>
</body>
</html>
