<?php
require "koneksi.php";

$status = "";

if(isset($_POST['reset'])){
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if($password !== $confirm){
        $status = "error";
        $pesan = "Password tidak sama!";
    } else {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $cek = mysqli_query($koneksi, "SELECT * FROM login 
        WHERE email='$email' 
        AND otp_code='$otp' 
        AND otp_expire > NOW()");

        if(mysqli_num_rows($cek) > 0){

            mysqli_query($koneksi, "UPDATE login 
            SET password='$hash', otp_code=NULL, otp_expire=NULL 
            WHERE email='$email'");

            $status = "success";
            $pesan = "Password berhasil diubah";

        } else {
            $status = "error";
            $pesan = "OTP salah atau expired";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: radial-gradient(circle at top,#1b1f3b,#0a0c1b);
    color:#fff;
}

.bg{
    position:absolute;
    width:420px;
    height:420px;
    background:linear-gradient(45deg,#7a5cff,#00eaff);
    filter:blur(140px);
    opacity:.6;
}

.card{
    position:relative;
    z-index:2;
    width:100%;
    max-width:420px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    backdrop-filter:blur(20px);
    border-radius:22px;
    padding:40px;
    text-align:center;
    animation:fadeUp .8s ease;
}

@keyframes fadeUp{
    from{opacity:0;transform:translateY(30px);}
    to{opacity:1;transform:translateY(0);}
}

h2{margin-bottom:15px;}

input{
    width:100%;
    padding:14px;
    margin-bottom:12px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,.15);
    background:rgba(255,255,255,.08);
    color:#fff;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:30px;
    background:linear-gradient(90deg,#7a5cff,#00eaff);
    color:#000;
    font-weight:600;
    cursor:pointer;
}

/* SUCCESS */
.success{
    margin-top:15px;
    color:#2ecc71;
    font-weight:600;
}

/* ERROR */
.error{
    margin-top:15px;
    color:#e74c3c;
    font-weight:600;
    animation:shake .4s;
}

@keyframes shake{
    0%{transform:translateX(0);}
    25%{transform:translateX(-5px);}
    50%{transform:translateX(5px);}
    75%{transform:translateX(-5px);}
    100%{transform:translateX(0);}
}
</style>
</head>

<body>

<div class="bg"></div>

<div class="card">
    <h2>Reset Password</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="otp" placeholder="Kode OTP" required>
        <input type="password" name="password" placeholder="Password baru" required>
        <input type="password" name="confirm" placeholder="Ulangi password" required>
        <button type="submit" name="reset">Reset Password</button>
    </form>

    <?php if(isset($status)): ?>
        <div class="<?= $status == 'success' ? 'success' : 'error' ?>">
            <?= $pesan ?>
        </div>
    <?php endif; ?>

    <a href="login.php" style="color:#00eaff;margin-top:15px;display:block;">Kembali ke login</a>
</div>

</body>
</html>