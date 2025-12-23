<?php
session_start();

if (!isset($_SESSION['cart'])) {
    header('Location: keranjang.php');
    exit;
}

$aksi = $_GET['aksi'] ?? '';
$index = isset($_GET['index']) ? intval($_GET['index']) : -1;

if (!isset($_SESSION['cart'][$index])) {
    header('Location: keranjang.php');
    exit;
}

// ===================
// TAMBAH JUMLAH
// ===================
if ($aksi === 'tambah') {
    $_SESSION['cart'][$index]['jumlah']++;
}

// ===================
// KURANGI JUMLAH
// ===================
elseif ($aksi === 'kurang') {
    $_SESSION['cart'][$index]['jumlah']--;

    if ($_SESSION['cart'][$index]['jumlah'] <= 0) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        header('Location: keranjang.php');
        exit;
    }
}

// ===================
// HAPUS ITEM
// ===================
elseif ($aksi === 'hapus') {
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: keranjang.php');
    exit;
}

// ===================
// UPDATE SUBTOTAL
// ===================
$_SESSION['cart'][$index]['subtotal'] =
    $_SESSION['cart'][$index]['jumlah'] *
    $_SESSION['cart'][$index]['harga'];

header('Location: keranjang.php');
exit;
