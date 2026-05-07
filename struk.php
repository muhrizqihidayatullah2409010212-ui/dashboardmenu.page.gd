<?php
session_start();

if(empty($_SESSION['keranjang'])){
    header("Location: minuman.php");
    exit;
}

date_default_timezone_set("Asia/Jakarta");

$tanggal = date("d M Y - H:i");
$invoice = "RZQ-".rand(10000,99999);

/* AMANKAN DATA POST */
if(isset($_POST['metode']) && isset($_POST['tipe'])){
    $_SESSION['metode'] = $_POST['metode'];
    $_SESSION['tipe']   = $_POST['tipe'];
}

$tipe   = isset($_SESSION['tipe']) ? $_SESSION['tipe'] : "Makan di Tempat";
$metode = isset($_SESSION['metode']) ? $_SESSION['metode'] : "Cash";

require "koneksi.php";

$total_db = 0;
foreach($_SESSION['keranjang'] as $item){
    $total_db += $item['harga'] * $item['qty'];
}

mysqli_query($koneksi, "INSERT INTO transaksi 
(invoice, tanggal, tipe_pesanan, metode_pembayaran, total)
VALUES 
('$invoice', NOW(), '$tipe', '$metode', '$total_db')");

$transaksi_id = mysqli_insert_id($koneksi);

foreach($_SESSION['keranjang'] as $item){
    $nama = $item['nama'];
    $harga = $item['harga'];
    $qty = $item['qty'];
    $subtotal = $harga * $qty;

    mysqli_query($koneksi, "INSERT INTO detail_transaksi 
    (transaksi_id, nama_menu, harga, qty, subtotal)
    VALUES 
    ($transaksi_id, '$nama', $harga, $qty, $subtotal)");
}


/* WARNA BADGE METODE */
$badgeColor = "#f1c40f"; // default Cash

if($metode == "QRIS"){
    $badgeColor = "#2ecc71";
}elseif($metode == "Transfer"){
    $badgeColor = "#3498db";
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk Pembayaran</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:#fff;
}

.receipt{
    width:430px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.2);
    border-radius:25px;
    padding:30px;
    box-shadow:0 15px 40px rgba(0,0,0,0.6);
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.header h2{
    font-weight:700;
    letter-spacing:1px;
}

.header p{
    font-size:13px;
    opacity:.8;
}

.info{
    font-size:14px;
    margin-bottom:10px;
}

.badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    margin-top:5px;
    color:#000;
}

.divider{
    height:1px;
    background:rgba(255,255,255,0.3);
    margin:15px 0;
}

.item{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    font-size:14px;
}

.total{
    display:flex;
    justify-content:space-between;
    font-size:18px;
    font-weight:600;
    margin-top:10px;
}

.footer{
    text-align:center;
    font-size:12px;
    margin-top:20px;
    opacity:.8;
}

.btn-group{
    margin-top:25px;
    display:flex;
    gap:10px;
}

.btn{
    flex:1;
    padding:12px;
    border:none;
    border-radius:30px;
    font-weight:600;
    cursor:pointer;
}

.print-btn{
    background:linear-gradient(90deg,#00eaff,#7a5cff);
    color:#000;
}

.logout-btn{
    background:#fff;
    color:#000;
}

/* PRINT MODE */
@media print{
    body{
        background:#fff !important;
        color:#000 !important;
        display:block !important;
    }

    .receipt{
        background:#fff !important;
        color:#000 !important;
        box-shadow:none !important;
        border:1px solid #000;
        width:100%;
    }

    .btn-group{
        display:none !important;
    }

    .divider{
        background:#000 !important;
    }
}
</style>
</head>

<body>

<div class="receipt">

<div class="header">
    <h2>RIZQI CAFE</h2>
    <p>Invoice: <?= $invoice ?></p>
    <p><?= $tanggal ?></p>
</div>

<div class="info">
    <strong>Tipe Pesanan:</strong> <?= htmlspecialchars($tipe); ?><br>
    <strong>Metode Bayar:</strong><br>
    <span class="badge" style="background:<?= $badgeColor ?>;">
        <?= htmlspecialchars($metode); ?>
    </span>
</div>

<div class="divider"></div>

<?php
foreach($_SESSION['keranjang'] as $item){
    $subtotal = $item['harga'] * $item['qty'];
    $total += $subtotal;
?>
    <div class="item">
        <span><?= htmlspecialchars($item['nama']); ?> (x<?= $item['qty']; ?>)</span>
        <span>Rp <?= number_format($subtotal,0,',','.'); ?></span>
    </div>
<?php } ?>

<div class="divider"></div>

<div class="total">
    <span>Total</span>
    <span>Rp <?= number_format($total,0,',','.'); ?></span>
</div>

<div class="footer">
    Terima kasih telah berbelanja 💙<br>
    Selamat menikmati pesanan Anda
</div>

<div class="btn-group">
    <button class="btn print-btn" onclick="window.print()">Print / Download</button>
    <button class="btn logout-btn" onclick="window.location.href='logout.php'">Logout</button>
</div>

</div>

</body>
</html>

<?php
/* Kosongkan keranjang setelah struk tampil */
$_SESSION['keranjang'] = [];
?>
