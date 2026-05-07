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
    $id = $_GET['add'];
    $nama = $_GET['nama'];
    $harga = $_GET['harga'];

    if(isset($_SESSION['keranjang'][$id])){
        $_SESSION['keranjang'][$id]['qty']++;
    }else{
        $_SESSION['keranjang'][$id] = [
            'nama'=>$nama,
            'harga'=>$harga,
            'qty'=>1
        ];
    }
    header("Location: dashboard.php");
    exit;
}

/* KURANGI ITEM */
if(isset($_GET['min'])){
    $id = $_GET['min'];
    if(isset($_SESSION['keranjang'][$id])){
        $_SESSION['keranjang'][$id]['qty']--;
        if($_SESSION['keranjang'][$id]['qty'] <= 0){
            unset($_SESSION['keranjang'][$id]);
        }
    }
    header("Location: dashboard.php");
    exit;
}

include 'koneksi.php';
$email = $_SESSION['email'];
$user  = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM login WHERE email='$email'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Rizqi</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}

body{
    min-height:100vh;
    background:radial-gradient(circle at top,#1b1f3b,#0a0c1b);
    color:#fff;
    padding:40px 20px;
    overflow-x:hidden;
}

/* GLOW */
.bg{
    position:fixed;
    width:520px;
    height:520px;
    background:linear-gradient(45deg,#7a5cff,#00eaff);
    filter:blur(160px);
    opacity:.5;
    animation:float 12s ease-in-out infinite alternate;
    z-index:0;
    pointer-events:none;
}
@keyframes float{
    from{transform:translate(-50px,-50px)}
    to{transform:translate(50px,50px)}
}

/* CONTAINER */
.container{
    position:relative;
    z-index:2;
    max-width:1100px;
    margin:auto;
    background:rgba(255,255,255,.06);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,.12);
    border-radius:28px;
    padding:35px;
    animation:fadeUp 1s ease;
}
@keyframes fadeUp{
    from{opacity:0;transform:translateY(30px)}
    to{opacity:1;transform:translateY(0)}
}

h2,h3{text-align:center;margin-bottom:20px}

/* INFO */
.info{
    max-width:420px;
    margin:0 auto 30px;
    background:rgba(255,255,255,.08);
    padding:18px;
    border-radius:16px;
    text-align:center;
}
.info p{opacity:.8;font-size:14px}

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
    transition:.35s;
}
.card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 40px rgba(0,234,255,.35);
}
.menu-img{height:150px}
.menu-img img{width:100%;height:100%;object-fit:cover}
.card h4{margin:12px}
.price{margin:0 12px 16px;font-weight:600;color:#00eaff}

/* CART ICON */
.cart-icon{
	position:fixed;
	top:25px;
	right:30px;
	background:#fff;
	color:#000;
	padding:12px 16px;
	border-radius:50%;
	cursor:pointer;
	font-size:22px;
	z-index:30000;
	}
    
.cart-count{
    position:absolute;
    top:-6px;
    right:-6px;
    background:red;
    color:white;
    font-size:12px;
    padding:2px 6px;
    border-radius:50%;
}

/* CART POPUP */
.cart-popup{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.6);
    z-index:10000;
}
.cart-box{
    background:#fff;
    color:#000;
    width:380px;
    margin:100px auto;
    padding:22px;
    border-radius:18px;
}
.close-cart{float:right;font-size:22px;cursor:pointer}
.qty-btn{
    padding:2px 8px;
    background:#ddd;
    border-radius:6px;
    text-decoration:none;
    color:#000;
}

/* PROMO MODAL */
.promo-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.65);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:10001;
}
.promo-content{
    position:relative;
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(20px);
    border-radius:22px;
    padding:18px;
}
.promo-content img{
    width:320px;
    border-radius:16px;
}
.close-promo{
    position:absolute;
    top:8px;
    right:10px;
    background:#fff;
    color:#000;
    width:32px;
    height:32px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    cursor:pointer;
}
.promo-modal{
position:fixed;
inset:0;
background:rgba(0,0,0,.7);
display:none;
align-items:center;
justify-content:center;
z-index:20000;
animation:fadeIn .5s ease;
}

.promo-box{
width:380px;
background:#0f172a;
border-radius:20px;
overflow:hidden;
text-align:center;
box-shadow:0 20px 60px rgba(0,0,0,.6);
animation:zoomIn .5s ease;
}

.promo-box video{
width:100%;
display:block;
}

.promo-text{
padding:18px;
}

.promo-text h2{
margin-bottom:8px;
}

.promo-text p{
opacity:.8;
margin-bottom:15px;
}

.promo-text button{
padding:10px 20px;
border:none;
border-radius:20px;
background:#00eaff;
cursor:pointer;
font-weight:600;
}

.close-promo{
position:absolute;
top:10px;
right:15px;
background:#fff;
color:#000;
width:30px;
height:30px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
z-index:10;
}

.promo-modal{
position:fixed;
inset:0;
background:rgba(0,0,0,.7);
display:none;
align-items:center;
justify-content:center;
z-index:20000;
animation:fadeIn .5s ease;
}

.promo-box{
width:380px;
background:#0f172a;
border-radius:20px;
overflow:hidden;
text-align:center;
box-shadow:0 20px 60px rgba(0,0,0,.6);
animation:zoomIn .5s ease;
}

.promo-box video{
width:100%;
display:block;
}

.promo-text{
padding:18px;
}

.promo-text h2{
margin-bottom:8px;
}

.promo-text p{
opacity:.8;
margin-bottom:15px;
}

.promo-text button{
padding:10px 20px;
border:none;
border-radius:20px;
background:#00eaff;
cursor:pointer;
font-weight:600;
}

.close-promo{
position:absolute;
top:10px;
right:15px;
background:#fff;
color:#000;
width:30px;
height:30px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
}

@keyframes zoomIn{
from{transform:scale(.6);opacity:0}
to{transform:scale(1);opacity:1}
}

@keyframes fadeIn{
from{opacity:0}
to{opacity:1}
}    
@keyframes zoomIn{
from{transform:scale(.6);opacity:0}
to{transform:scale(1);opacity:1}
}

@keyframes fadeIn{
from{opacity:0}
to{opacity:1}
}
/* WRAPPER TOMBOL */
.btn-group{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-top:35px;
}

/* STYLE TOMBOL */
.logout,
.selanjutnya,
.dessert{    
    width:200px;
    text-align:center;
    padding:14px;
    border-radius:30px;
    font-weight:600;
    text-decoration:none;
    transition:.3s;
    border:1px solid rgba(255,255,255,.2);
    background:rgba(255,255,255,.08);
    color:#00eaff;
    backdrop-filter:blur(10px);
}
    

/* HOVER EFFECT */
.logout:hover,
.selanjutnya:hover,
.dessert:hover{    
    background:linear-gradient(90deg,#00eaff,#7a5cff);
    color:#000;
    box-shadow:0 10px 30px rgba(0,234,255,.4);
    transform:translateY(-3px);
}

</style>
</head>

<body>

<div class="bg"></div>

<!-- PROMO -->
<div id="promoModal" class="promo-modal">
<div class="promo-box">

<span class="close-promo" onclick="closePromo()">✕</span>

<video autoplay muted loop>
<source src="images/iklan.mp4" type="video/mp4">
</video>

<div class="promo-text">
<h2>🔥 Promo Spesial Hari Ini</h2>
<p>Diskon 30% untuk menu tertentu</p>
<button onclick="closePromo()">Klaim Promo</button>
</div>

</div>
</div>
    
<!-- CART ICON -->
<div class="cart-icon" onclick="openCart()">
🛒
<span class="cart-count">
<?= array_sum(array_column($_SESSION['keranjang'],'qty')) ?>
</span>
</div>

<!-- CART POPUP -->
<div id="cartPopup" class="cart-popup" onclick="closeCart()">
<div class="cart-box" onclick="event.stopPropagation()">
<span class="close-cart" onclick="closeCart()">×</span>
<h3>Keranjang</h3>

<?php
$total=0;
if(!empty($_SESSION['keranjang'])){
    foreach($_SESSION['keranjang'] as $id=>$item){
        $subtotal=$item['harga']*$item['qty'];
        $total+=$subtotal;
        echo "<p>{$item['nama']}
        <a class='qty-btn' href='?min=$id'>−</a>
        {$item['qty']}
        <a class='qty-btn' href='?add=$id&nama={$item['nama']}&harga={$item['harga']}'>+</a><br>
        <small>Rp ".number_format($subtotal,0,',','.')."</small></p>";
    }
}else{
    echo "<p>Keranjang kosong</p>";
}
?>
<hr>
<b>Total: Rp <?= number_format($total,0,',','.') ?></b>
</div>
</div>

<div class="container">
<h2>Dashboard Food & Beverage</h2>

<div class="info">
<p><?= htmlspecialchars($user['email']); ?></p>
<p>Status: Login</p>
</div>

<h3>Katalog Menu Makanan</h3>

<div class="menu">

<a href="?add=1&nama=Nasi-Goreng&harga=18000" class="card">
    <div class="menu-img">
        <img src="https://images.unsplash.com/photo-1603133872878-684f208fb84b">
    </div>
    <h4>Nasi Goreng</h4>
    <p class="price">Rp 18.000</p>
</a>

<a href="?add=2&nama=Mie-Ayam&harga=15000" class="card">
    <div class="menu-img">
        <img src="images/mie ayam.jpg">
    </div>
    <h4>Mie Ayam</h4>
    <p class="price">Rp 15.000</p>
</a>

<a href="?add=3&nama= freash-burger&harga=25000" class="card">
    <div class="menu-img">
        <img src="images/burgers.jpg">
    </div>
    <h4>Freash Burger</h4>
    <p class="price">Rp 25.000</p>
</a>

<a href="?add=4&nama=Crispy-Garlic-Chili-Tofu&harga=19000" class="card">
<div class="menu-img">
<img src="images/Crispy Garlic Chili Tofu.jpg">
</div>
<h4>Crispy Garlic Chili Tofu</h4>
<p class="price">Rp 19.000</p>
</a>

<a href="?add=5&nama=onion-rings&harga=23000" class="card">
    <div class="menu-img">
        <img src="images/onion rings.jpg">
    </div>
    <h4>onion rings</h4>
    <p class="price">Rp 23.000</p>
</a>

<a href="?add=6&nama=french-fries&harga=22000" class="card">
    <div class="menu-img">
        <img src="images/french fries.jpg">
    </div>
    <h4>french fries</h4>
    <p class="price">Rp 22.000</p>
</a>

<a href="?add=7&nama=chicken-wings&harga=27000" class="card">
    <div class="menu-img">
        <img src="images/chicken wings.jpg">
    </div>
    <h4>chicken wings</h4>
    <p class="price">Rp 27.000</p>
 </a>
    
<a href="?add=14&nama=Ayam-Geprek-Sambal-Ijo&harga=18000" class="card">
    <div class="menu-img">
        <img src="images/Ayam Geprek Sambal Ijo.jpg">
    </div>
    <h4>Ayam Geprek Sambal Ijo</h4>
    <p class="price">Rp 18.000</p>
 </a> 
    
<a href="?add=15&nama=Bebek-Goreng-Kremes&harga=25000" class="card">
    <div class="menu-img">
        <img src="images/Bebek Goreng Kremes.jpg">
    </div>
    <h4>Bebek Goreng Kremes</h4>
    <p class="price">Rp 25.000</p>
 </a>        

<a href="?add=16&nama=Ayam-Penyet-Sambal-Terasi&harga=15000" class="card">
    <div class="menu-img">
        <img src="images/Ayam Penyet Sambal Terasi.jpg">
    </div>
    <h4>Ayam Penyet Sambal Terasi</h4>
    <p class="price">Rp 15.000</p>
 </a>        
     
<a href="?add=17&nama=Gurame-Asam-Manis&harga=15000" class="card">
    <div class="menu-img">
        <img src="images/Gurame Asam Manis.jpg">
    </div>
    <h4>Gurame Asam Manis</h4>
    <p class="price">Rp 32.000</p>
 </a>     

</div>


<div class="btn-group">
    <a href="logout.php" class="logout">Logout</a>
    <a href="minuman.php" class="selanjutnya">Minuman</a>
    <a href="dessert.php" class="dessert">dessert</a>
</div>


<script>
window.addEventListener("load",function(){

if(!localStorage.getItem("promoDilihat")){

setTimeout(function(){
let promo = document.getElementById("promoModal")
if(promo){
promo.style.display="flex"
}
},1500)

}

})

function closePromo(){
document.getElementById("promoModal").style.display="none"
localStorage.setItem("promoDilihat","ya")
}

function openCart(){
document.getElementById("cartPopup").style.display="block"
}

function closeCart(){
document.getElementById("cartPopup").style.display="none"
}
</script>

</body>
</html>

