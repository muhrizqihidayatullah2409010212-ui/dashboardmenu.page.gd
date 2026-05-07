<?php
require "koneksi.php";

$pesan = "";
$status = "";

if(isset($_POST['kirim'])){
    $email = $_POST['email'];

    $cek = mysqli_query($koneksi, "SELECT * FROM login WHERE email='$email'");

    if(mysqli_num_rows($cek) > 0){

        $otp = rand(100000,999999);
        $expire = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        mysqli_query($koneksi, "UPDATE login 
        SET otp_code='$otp', otp_expire='$expire' 
        WHERE email='$email'");

        // SIMULASI EMAIL (nanti bisa pakai PHPMailer)
        $pesan = "
        <div class='link-box'>
            <p>Kode OTP kamu:</p>
            <h2>$otp</h2>
            <small>Berlaku 5 menit</small>
        </div>
        ";

        $status = "success";
        echo "<script>
setTimeout(function(){
    window.location='reset_password.php?email=$email';
}, 1500);
</script>";

    } else {
        $status = "error";
        $pesan = "<div class='link-box'>Email tidak ditemukan!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password</title>

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
}

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
    font-weight:600;
    cursor:pointer;
}

/* box */
.link-box{
    margin-top:15px;
    padding:15px;
    background:rgba(0,0,0,0.4);
    border-radius:12px;
}

/* loading */
#loading{display:none;margin-top:20px;}
.spinner{
    width:50px;height:50px;border:4px solid rgba(255,255,255,0.2);
    border-top:4px solid #00eaff;border-radius:50%;
    animation:spin 1s linear infinite;margin:0 auto;
}
@keyframes spin{100%{transform:rotate(360deg);}}

/* success */
#success{display:none;margin-top:20px;}
.checkmark{
    width:60px;height:60px;border-radius:50%;
    background:#2ecc71;display:flex;justify-content:center;align-items:center;
    font-size:30px;margin:0 auto 10px;color:#000;
}

/* error */
#error{display:none;margin-top:20px;}
.error-mark{
    width:60px;height:60px;border-radius:50%;
    background:#e74c3c;display:flex;justify-content:center;align-items:center;
    font-size:30px;margin:0 auto 10px;color:#fff;
    animation:shake 0.4s;
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
    <h2>Lupa Password</h2>

    <form method="POST" id="form">
        <input type="email" name="email" placeholder="Masukkan email" required>
        <button type="submit" name="kirim">Kirim OTP</button>
    </form>

    <div id="loading">
        <div class="spinner"></div>
        <p>Memproses...</p>
    </div>

    <div id="success">
        <div class="checkmark">✓</div>
        <p>OTP berhasil dikirim</p>
    </div>

    <div id="error">
        <div class="error-mark">✕</div>
        <p>Email tidak ditemukan</p>
    </div>

    <?= $pesan ?>
</div>

<!-- SOUND -->
<audio id="successSound">
    <source src="https://assets.mixkit.co/sfx/preview/mixkit-correct-answer-tone-2870.mp3">
</audio>

<audio id="errorSound">
    <source src="https://assets.mixkit.co/sfx/preview/mixkit-wrong-answer-buzz-950.mp3">
</audio>

<script>
// loading
document.getElementById("form").addEventListener("submit", function(){
    document.getElementById("loading").style.display = "block";
});

<?php if($pesan): ?>
document.getElementById("loading").style.display = "none";

<?php if($status == "success"): ?>
    document.getElementById("success").style.display = "block";
    document.getElementById("successSound").play();
<?php else: ?>
    document.getElementById("error").style.display = "block";
    document.getElementById("errorSound").play();
    navigator.vibrate?.(200);
<?php endif; ?>

<?php endif; ?>
</script>

</body>
</html>
