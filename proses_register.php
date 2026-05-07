<?php
include 'koneksi.php';

$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$cek = mysqli_query($koneksi, "SELECT * FROM login WHERE email='$email'");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar');window.location='register.php';</script>";
} else {
    mysqli_query($koneksi,
        "INSERT INTO login (email, password) VALUES ('$email','$password')"
    );
    echo "<script>alert('Registrasi berhasil');window.location='login.php';</script>";
}
?>

