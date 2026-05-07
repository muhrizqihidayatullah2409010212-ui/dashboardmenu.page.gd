<?php

$db_host = "sql312.infinityfree.com";
$db_user = "if0_41307711";
$db_pass = "dimaas1515";
$db_name = "if0_41307711_appslipgaji";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


?>