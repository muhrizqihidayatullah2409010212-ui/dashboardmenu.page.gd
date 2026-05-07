<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM login");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
    <style>
        body{
            font-family: Arial;
            background:#f2f2f2;
            padding:30px;
        }
        table{
            border-collapse: collapse;
            width: 60%;
            background:#fff;
        }
        th, td{
            border:1px solid #ccc;
            padding:10px;
            text-align:left;
        }
        th{
            background:#007bff;
            color:white;
        }
        h2{
            margin-bottom:15px;
        }
        a{
            display:inline-block;
            margin-top:15px;
            text-decoration:none;
            color:#007bff;
        }
    </style>
</head>
<body>

<h2>Data User</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Password</th>
    </tr>

    <?php while($data = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $data['id']; ?></td>
        <td><?= $data['email']; ?></td>
        <td><?= $data['password']; ?></td>
    </tr>
    <?php } ?>

</table>

<a href="login.php">← Kembali ke Login</a>

</body>
</html>
