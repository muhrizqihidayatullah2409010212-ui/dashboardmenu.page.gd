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

    header("Location: dessert.php");
    exit;
}

/* HAPUS ITEM */
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    unset($_SESSION['keranjang'][$id]);
    header("Location: dessert.php");
    exit;
}

/* KOSONGKAN */
if(isset($_GET['clear'])){
    $_SESSION['keranjang'] = [];
    header("Location: dessert.php");
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
<title>Dessert | Rizqi</title>

<style>

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Inter',sans-serif
}

body{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:radial-gradient(circle at top,#1b1f3b,#0a0c1b);
color:#fff;
}

.container{
width:100%;
max-width:1200px;
background:rgba(255,255,255,.06);
backdrop-filter:blur(20px);
border:1px solid rgba(255,255,255,.12);
border-radius:28px;
padding:40px;
}

h2{
text-align:center;
margin-bottom:20px
}

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

.menu-img{
height:150px
}

.menu-img img{
width:100%;
height:100%;
object-fit:cover
}

.card h4{
margin:12px
}

.price{
margin:0 12px 16px;
font-weight:600;
color:#00eaff
}

/* DETAIL */
.detail-box{
background:rgba(255,255,255,.08);
padding:25px;
border-radius:20px;
border:1px solid rgba(255,255,255,.1);
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
transition:.3s;
}

.pay-btn:hover{
transform:translateY(-3px);
box-shadow:0 10px 25px rgba(0,234,255,.4);
}

.btn-group{
display:flex;
justify-content:center;
gap:20px;
margin-top:40px;
}

.kembali{
padding:12px 30px;
border-radius:30px;
text-decoration:none;
background:rgba(255,255,255,.08);
border:1px solid rgba(255,255,255,.2);
color:#00eaff;
}

.kembali:hover{
background:linear-gradient(90deg,#00eaff,#7a5cff);
color:#000;
}

.clear{
color:#ff6b6b;
font-size:13px;
text-decoration:none;
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
margin-top:20px;
}

}

/* HP */
@media (max-width:600px){

body{
padding:15px;
align-items:flex-start;
}

.container{
padding:20px;
border-radius:20px;
}

.menu{
grid-template-columns:1fr;
gap:15px;
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

.detail-box{
margin-top:20px;
padding:20px;
}

.item-row{
font-size:13px;
}

.btn-group{
flex-direction:column;
gap:10px;
}

.kembali{
width:100%;
text-align:center;
}

.pay-btn{
width:100%;
}

}
</style>
</head>

<body>

<div class="container">

<h2>Menu Dessert</h2>

<div class="info">
<p><?= htmlspecialchars($user['email']); ?></p>
<p>Status: Login</p>
</div>

<div class="main-layout">

<!-- MENU -->
<div class="menu">

<a href="?add=20&nama=Banana-Split&harga=20000" class="card">
<div class="menu-img">
<img src="images/Banana Split.jpg">
</div>
<h4>Banana Split</h4>
<p class="price">Rp 20.000</p>
</a>

<a href="?add=21&nama=Strawberry-Cheesecake&harga=23000" class="card">
<div class="menu-img">
<img src="images/kue berry.jpg">
</div>
<h4>strawberry cheesecake</h4>
<p class="price">Rp 23.000</p>
</a>

<a href="?add=22&nama=Ice-Cream-vanilla&harga=15000" class="card">
<div class="menu-img">
<img src="images/Ice Cream Vanilla.jpg">
</div>
<h4>Ice Cream Vanilla</h4>
<p class="price">Rp 15.000</p>
</a>

<a href="?add=23&nama=Brownies-Ice-Cream&harga=28000" class="card">
<div class="menu-img">
<img src="images/Brownies Ice Cream.jpg">
</div>
<h4>Brownies Ice Cream</h4>
<p class="price">Rp 28.000</p>
</a>

<a href="?add=24&nama=Pancake-Maple-Syrup&harga=23000" class="card">
<div class="menu-img">
<img src="images/Pancake Maple Syrup.jpg">
</div>
<h4>Pancake Maple Syrup</h4>
<p class="price">Rp 23.000</p>
</a>

<a href="?add=25&nama=Tiramisu&harga=25000" class="card">
<div class="menu-img">
<img src="images/Tiramisu.jpg">
</div>
<h4>Tiramisu</h4>
<p class="price">Rp 25.000</p>
</a>

</div>

<!-- DETAIL -->
<div class="detail-box">

<h3>Detail Pesanan</h3>

<?php
$total=0;

if(!empty($_SESSION['keranjang'])){
foreach($_SESSION['keranjang'] as $id=>$item){

$subtotal=$item['harga']*$item['qty'];
$total+=$subtotal;

echo "
<div class='item-row'>
<span>
{$item['nama']} (x{$item['qty']})<br>
<a class='hapus' href='?hapus=$id'>Hapus</a>
</span>
<span>Rp ".number_format($subtotal,0,',','.')."</span>
</div>
";
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

<form action="struk.php" method="POST">

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
<a href="minuman.php" class="kembali">minuman</a>
</div>

</div>

</body>
</html>