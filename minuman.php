<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = [];
}

/* TAMBAH ITEM */
if(isset($_GET['add'])){
    $id = intval($_GET['add']);
    $nama = htmlspecialchars($_GET['nama']);
    $harga = intval($_GET['harga']);

    if(isset($_SESSION['keranjang'][$id])){
        $_SESSION['keranjang'][$id]['qty']++;
    }else{
        $_SESSION['keranjang'][$id] = [
            'nama'=>$nama,
            'harga'=>$harga,
            'qty'=>1
        ];
    }
    header("Location: minuman.php");
    exit;
}

/* HAPUS ITEM */
if(isset($_GET['hapus'])){
    $id = intval($_GET['hapus']);
    unset($_SESSION['keranjang'][$id]);
    header("Location: minuman.php");
    exit;
}

/* KOSONGKAN */
if(isset($_GET['clear'])){
    $_SESSION['keranjang'] = [];
    header("Location: minuman.php");
    exit;
}

include 'koneksi.php';
$email = mysqli_real_escape_string($koneksi, $_SESSION['email']);
$query = "SELECT * FROM login WHERE email='$email'";
$user  = mysqli_fetch_assoc(mysqli_query($koneksi,$query));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Minuman | Rizqi</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
    
        /* CHAT */
.chat-btn{
    position:fixed;
    bottom:20px;
    right:20px;
    background:#00eaff;
    color:#000;
    padding:12px 18px;
    border-radius:30px;
    cursor:pointer;
    font-weight:600;
    z-index:999;
}

.chat-box{
    position:fixed;
    bottom:80px;
    right:20px;
    width:280px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(15px);
    border-radius:18px;
    display:none;
    flex-direction:column;
    overflow:hidden;
    border:1px solid rgba(255,255,255,.2);
    z-index:999;
}

.chat-header{
    background:#00eaff;
    color:#000;
    padding:10px;
    display:flex;
    justify-content:space-between;
    font-weight:600;
}

.chat-body{
    height:180px;
    padding:10px;
    overflow-y:auto;
    font-size:13px;
}

.user-msg{
    text-align:right;
    margin:6px 0;
}

.chef-msg{
    text-align:left;
    margin:6px 0;
    color:#7adfff;
}

.chat-input{
    display:flex;
    border-top:1px solid rgba(255,255,255,.2);
}

.chat-input input{
    flex:1;
    padding:8px;
    border:none;
    outline:none;
    background:transparent;
    color:#fff;
}

.chat-input button{
    background:#00eaff;
    border:none;
    padding:8px 12px;
    cursor:pointer;
}
   

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:radial-gradient(circle at top,#1b1f3b,#0a0c1b);
    color:#fff;
    padding:20px;
}

.container{
    width:100%;
    max-width:1200px;
    background:rgba(255,255,255,.06);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,.12);
    border-radius:28px;
    padding:40px;
    overflow:hidden;
}

h2{text-align:center;margin-bottom:20px}

.info{
    max-width:400px;
    margin:0 auto 30px;
    background:rgba(255,255,255,.08);
    padding:15px;
    border-radius:16px;
    text-align:center;
}

/* GRID */
.main-layout{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:40px;
}

/* MENU */
.menu{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:22px;
}

.card{
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.12);
    border-radius:20px;
    overflow:hidden;
    text-decoration:none;
    color:#fff;
    transition:.3s;
}
.card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 40px rgba(0,234,255,.35);
}
.menu-img{height:150px}
.menu-img img{width:100%;height:100%;object-fit:cover}
.card h4{margin:12px}
.price{margin:0 12px 16px;font-weight:600;color:#00eaff}

/* DETAIL (TIDAK DIUBAH) */
.detail-box{
    background:rgba(255,255,255,.08);
    padding:25px;
    border-radius:20px;
    border:1px solid rgba(255,255,255,.1);
    position:sticky;
    top:30px;
    height:fit-content;
}

.item-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    font-size:14px;
}

.hapus{
    color:#ff6b6b;
    font-size:12px;
    text-decoration:none;
}
    .clear{
    color:#ff4d4d !important;
}

.clear:hover{
    color:#ff1a1a !important;
}

.clear:visited{
    color:#ff4d4d !important;
}

select{
    width:100%;
    padding:10px;
    border-radius:10px;
    border:none;
    margin-top:8px;
}

.pay-btn{
    width:100%;
    padding:14px;
    border-radius:30px;
    border:none;
    font-weight:600;
    margin-top:20px;
    background:linear-gradient(90deg,#00eaff,#7a5cff);
    cursor:pointer;
}

.btn-group{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-top:40px;
}

.kembali,
.dessert{
    padding:12px 30px;
    border-radius:30px;
    text-decoration:none;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.2);
    color:#00eaff;
}

/* TABLET */
@media (max-width:900px){
    .main-layout{
        grid-template-columns:1fr;
        gap:25px;
    }

    .menu{
        grid-template-columns:repeat(2,1fr);
    }

    .detail-box{
        position:relative;
        top:0;
        margin-top:25px;
    }
}

/* HP */
@media (max-width:600px){
    body{
        align-items:flex-start;
    }

    .container{
        padding:20px;
        border-radius:20px;
    }

    .menu{
        grid-template-columns:1fr;
        gap:16px;
    }

    .menu-img{
        height:130px;
    }

    .card h4{
        font-size:16px;
    }

    .price{
        font-size:14px;
    }

    .btn-group{
        flex-direction:column;
        gap:10px;
        align-items:center;
    }

    .kembali,
    .dessert{
        width:100%;
        text-align:center;
    }
     
}
</style>
</head>

<body>

<div class="container">

<h2>Menu Minuman</h2>

<div class="info">
<p><?= htmlspecialchars($user['email']); ?></p>
<p>Status: Login</p>
</div>

<div class="main-layout">

<!-- MENU -->
<div class="menu">

<a href="?add=8&nama=kopi-aren&harga=15000" class="card">
<div class="menu-img"><img src="images/kopi aren.jpg"></div>
<h4>Kopi Aren</h4>
<p class="price">Rp 15.000</p>
</a>

<a href="?add=9&nama=matcha&harga=18000" class="card">
<div class="menu-img"><img src="images/matcha.jpg"></div>
<h4>Matcha Latte</h4>
<p class="price">Rp 18.000</p>
</a>

<a href="?add=10&nama=es-teh&harga=8000" class="card">
<div class="menu-img"><img src="images/teh manis.jpg"></div>
<h4>Es Teh</h4>
<p class="price">Rp 8.000</p>
</a>

<a href="?add=11&nama=americano&harga=13000" class="card">
<div class="menu-img"><img src="images/americano.jpg"></div>
<h4>americano</h4>
<p class="price">Rp 13.000</p>
</a>

<a href="?add=12&nama=Coffee-Mojito&harga=25000" class="card">
<div class="menu-img"><img src="images/mojito.jpg"></div>
<h4>Coffee Mojito</h4>
<p class="price">Rp 25.000</p>
</a>

<a href="?add=13&nama=Peach-Black-Tea&harga=22000" class="card">
<div class="menu-img"><img src="images/Peach Iced Tea.jpg"></div>
<h4>peach iced tea</h4>
<p class="price">Rp 22.000</p>
</a>

</div>

<!-- DETAIL -->
<div class="detail-box">
<h3>Detail Pesanan</h3>

<?php
$total = 0;
if(!empty($_SESSION['keranjang'])){
    foreach($_SESSION['keranjang'] as $id=>$item){
        $subtotal = $item['harga'] * $item['qty'];
        $total += $subtotal;
        echo "
        <div class='item-row'>
            <span>
                {$item['nama']} (x{$item['qty']})<br>
                <a class='hapus' href='?hapus=$id'>Hapus</a>
            </span>
            <span>Rp ".number_format($subtotal,0,',','.')."</span>
        </div>";
    }
}else{
    echo "<p>Keranjang kosong</p>";
}
?>

<hr style="margin:15px 0;border-color:rgba(255,255,255,.2)">

<h4>Total: Rp <?= number_format($total,0,',','.') ?></h4>

<br>

<a href="?clear=true" class="clear">Kosongkan Keranjang</a>

<br><br>

<form action="struk.php" method="POST" style="margin-top:30px;">

<h3>Metode Pembayaran</h3>
<select name="metode" required>
<option value="">-- Pilih --</option>
<option value="Cash">Cash</option>
<option value="QRIS">QRIS</option>
<option value="Transfer">Transfer</option>
</select>

<h3>Mau Makan Dimana</h3>
<select name="tipe" required>
<option value="">-- Pilih --</option>
<option value="Ditempat">Ditempat</option>
<option value="Take Away">Take Away</option>
</select>

<button type="submit" class="pay-btn">
Bayar Sekarang
</button>

</form>

</div>
</div>

<div class="btn-group">
<a href="dashboard.php" class="kembali">makanan</a>
<a href="dessert.php" class="dessert">dessert</a>
</div>
    </div>

<!-- CHAT BOX -->
<div class="chat-box" id="chatBox">
    <div class="chat-header">
        👨‍🍳 BARISTA
        <span onclick="closeChat()">✖</span>
    </div>

    <div class="chat-body" id="chatBody">
        <div class="chef-msg">Halo, mau pesan apa? 😊</div>
    </div>

    <div class="chat-input">
        <input type="text" id="chatInput" placeholder="Tulis pesan...">
        <button onclick="sendChat()">Kirim</button>
    </div>
</div>

<!-- TOMBOL -->
<div class="chat-btn" onclick="openChat()">💬 Chat</div>
    
<script>
function openChat(){
    document.getElementById("chatBox").style.display="flex";
}

function closeChat(){
    document.getElementById("chatBox").style.display="none";
}

function sendChat(){
    let input = document.getElementById("chatInput");
    let msg = input.value.trim();
    let lower = msg.toLowerCase();
    if(msg === "") return;

    let body = document.getElementById("chatBody");

    body.innerHTML += `<div class="user-msg">${msg}</div>`;
    input.value="";
    body.scrollTop = body.scrollHeight;

    // fungsi random biar ga monoton
    function pick(arr){
        return arr[Math.floor(Math.random()*arr.length)];
    }

    let reply = "Siap, pesanan sedang diproses 👨‍🍳";

    // ===== SAPAAN =====
    if(lower.includes("halo") || lower.includes("hai") || lower.includes("bang")){
        reply = pick([
            "Halo juga! Mau minum apa hari ini? 😄",
            "Hai! Lagi pengen yang dingin atau hangat? ☕",
            "Halo! Menu favorit kamu apa nih? 👀"
        ]);
    }

    // ===== MENU =====
    else if(lower.includes("kopi")){
        reply = pick([
            "Kopi lagi diseduh ☕ sabar ya!",
            "Aroma kopi udah keluar nih 😋",
            "Kopi panas siap bikin melek 🔥"
        ]);
    }

    else if(lower.includes("matcha")){
        reply = pick([
            "Matcha lagi di-mix 🍵",
            "Matcha creamy coming up 😍",
            "Siapin matcha spesial buat kamu 👍"
        ]);
    }

    else if(lower.includes("teh")){
        reply = pick([
            "Teh segar lagi dibuat 🍹",
            "Es teh manis paling mantap 😋",
            "Teh dingin cocok banget hari ini!"
        ]);
    }

    else if(lower.includes("mojito")){
        reply = pick([
            "Mojito fresh lagi disiapkan 🍃",
            "Seger banget ini pilihan kamu 😎",
            "Mojito coming soon!"
        ]);
    }

    // ===== KOMPLAIN =====
    else if(lower.includes("lama") || lower.includes("nunggu")){
        reply = pick([
            "Maaf ya lagi rame 🙏",
            "Sedang dipercepat nih 🔥",
            "Chef lagi ngebut masaknya 💨"
        ]);
    }

    else if(lower.includes("dingin")){
        reply = pick([
            "Minuman dingin lagi disiapkan 🧊",
            "Tenang, pasti segar! 😁",
            "Lagi masukin es nih 👍"
        ]);
    }

    else if(lower.includes("panas")){
        reply = pick([
            "Masih hangat banget ☕",
            "Baru diangkat dari dapur 🔥",
            "Panasnya pas banget!"
        ]);
    }

    // ===== PUJIAN =====
    else if(lower.includes("enak") || lower.includes("mantap")){
        reply = pick([
            "Wah makasih! 😍",
            "Senang kamu suka 🙌",
            "Ditunggu order berikutnya ya 😄"
        ]);
    }

    // ===== TERIMA KASIH =====
    else if(lower.includes("terima kasih") || lower.includes("makasih")){
        reply = pick([
            "Sama-sama 🙏",
            "Siap! kapan-kapan order lagi ya 😁",
            "Dengan senang hati 👨‍🍳"
        ]);
    }

    // ===== DEFAULT =====
    else{
        reply = pick([
            "Siap, langsung diproses 👨‍🍳",
            "Oke noted 👍",
            "Pesanan diterima 😄",
            "Chef lagi siapin ya 🔥"
        ]);
    }

    // delay biar natural
    setTimeout(()=>{
        body.innerHTML += `<div class="chef-msg">${reply}</div>`;
        body.scrollTop = body.scrollHeight;
    },500);
}
</script>
</body>
</html>