<?php
include 'koneksi.php';
session_start();

// REGISTER
if (isset($_POST['register'])) {
    $user = $_POST['user'];
    $email = $_POST['email'];
    $pass = $_POST['pass']; // DISIMPAN TANPA HASH
    mysqli_query($koneksi, "INSERT INTO users (user, email, pass) VALUES ('$user', '$email', '$pass')");
    echo "<script>alert('Registrasi berhasil! Silakan login.');</script>";
}

// LOGIN
if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $result   = mysqli_query($koneksi, "SELECT * FROM users WHERE user = '$user'");
    $user     = mysqli_fetch_assoc($result);
    if ($user && $pass == $user['pass']) {
        $_SESSION['user'] = $user['user'];
        header("Location: index.php"); exit;
    } else {
        echo "<script>alert('Login gagal. Cek kembali username atau password.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login/Register</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
        <div class="form-box login" id="login">
            <form method="post">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" name="user" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" name="pass" required>
                    <i class='bx bxs-lock-alt' ></i>
                </div>
                <div class="forgot-link">
                    <a href="lupa_sandi.php">Forgot Password?</a>
                </div>
                <button type="submit" class="btn" name="login">Login</button>
                
            </form>
        </div>

        <div class="form-box register" id="register">
            <form method="post">
                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" name="user" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" placeholder="Email" name="email" required>
                    <i class='bx bxs-envelope' ></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" name="pass" required>
                    <i class='bx bxs-lock-alt' ></i>
                </div>
                <button type="submit" class="btn" name="register">Register</button>
                
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>
<script src="assets/script.js"></script>
</body>
</html>
