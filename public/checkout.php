<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../public/keranjang.php'); exit; }
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (!$cart) { header('Location: ../public/menu.php'); exit; }
$nama = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
$meja = mysqli_real_escape_string($conn, $_POST['meja']);
$customer_id = isset($_SESSION['customer']) ? intval($_SESSION['customer']['id']) : 'NULL';
$total = 0; foreach($cart as $c) $total += $c['subtotal'];
$kode = 'C'.date('ymdHis').rand(10,99);
$cust_sql = ($customer_id==='NULL') ? "NULL" : $customer_id;
$insert = "INSERT INTO pesanan (kode,customer_id,nama_pemesan,meja,total_harga,status) VALUES ('{$kode}',{$cust_sql},'{$nama}','{$meja}',{$total},'menunggu')";
mysqli_query($conn,$insert);
$pesanan_id = mysqli_insert_id($conn);
foreach($cart as $c){
    $menu_id = intval($c['menu_id']);
    $jumlah = intval($c['jumlah']);
    $subtotal = intval($c['subtotal']);
    mysqli_query($conn, "INSERT INTO detail_pesanan (pesanan_id,menu_id,jumlah,subtotal) VALUES ({$pesanan_id},{$menu_id},{$jumlah},{$subtotal})");
}
unset($_SESSION['cart']);
header('Location: ../public/status.php?kode='.$kode);
exit;
?>
