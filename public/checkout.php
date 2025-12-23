<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: keranjang.php');
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: menu.php');
    exit;
}

$cart = $_SESSION['cart'];

$nama = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);

$meja = isset($_POST['meja']) && $_POST['meja'] !== ''
    ? mysqli_real_escape_string($conn, $_POST['meja'])
    : null;

$customer_id = isset($_SESSION['customer'])
    ? intval($_SESSION['customer']['id'])
    : null;

// hitung total
$total = 0;
foreach ($cart as $c) {
    $total += $c['subtotal'];
}

// kode pesanan
$kode = 'C' . date('ymdHis') . rand(10,99);

$cust_sql = $customer_id === null ? "NULL" : $customer_id;
$meja_sql = $meja === null ? "NULL" : "'$meja'";

// insert pesanan
mysqli_query($conn,
    "INSERT INTO pesanan
     (kode, customer_id, nama_pemesan, meja, total_harga, status)
     VALUES
     ('$kode', $cust_sql, '$nama', $meja_sql, $total, 'menunggu')"
);

$pesanan_id = mysqli_insert_id($conn);

// insert detail pesanan
foreach ($cart as $c) {
    mysqli_query($conn,
        "INSERT INTO detail_pesanan
         (pesanan_id, menu_id, jumlah, subtotal)
         VALUES
         ($pesanan_id, {$c['menu_id']}, {$c['jumlah']}, {$c['subtotal']})"
    );
}

// kosongkan keranjang
unset($_SESSION['cart']);

// ke status
header("Location: status.php?kode=$kode");
exit;
