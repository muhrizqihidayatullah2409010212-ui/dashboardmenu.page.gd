<?php
session_start();
include 'koneksi.php';

$email    = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM login WHERE email='$email'");

if (mysqli_num_rows($query) == 1) {
    $user = mysqli_fetch_assoc($query);

    if (password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['email'] = $user['email'];

        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>
                alert('Password salah');
                window.location='login.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Email belum terdaftar');
            window.location='login.php';
          </script>";
}
