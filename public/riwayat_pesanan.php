<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['customer'])) { header('Location: ../public/login.php'); exit; }
$cid = intval($_SESSION['customer']['id']);
$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE customer_id={$cid} ORDER BY created_at DESC");
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Riwayat Pesanan</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
<body>
<h1>Riwayat Pesanan</h1>
<a href="../public/menu.php">Kembali</a>
<ul>
<?php 
  while($r = mysqli_fetch_assoc($q)){ 
    echo '<li>'.$r['kode'].' - Rp '.number_format($r['total_harga']).' - '.$r['status'].'</li>'; } 
?>
</ul>
</body>
</html>
