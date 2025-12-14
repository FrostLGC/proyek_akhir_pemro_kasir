<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_id = intval($_POST['menu_id']);
    $jumlah = max(1, intval($_POST['jumlah']));
    $q = mysqli_query($conn, "SELECT * FROM menu WHERE id={$menu_id}");
    if (!$q || mysqli_num_rows($q) == 0) { header('Location: ../public/menu.php'); exit; }
    $m = mysqli_fetch_assoc($q);
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$menu_id])) {
        $_SESSION['cart'][$menu_id]['jumlah'] += $jumlah;
        $_SESSION['cart'][$menu_id]['subtotal'] = $_SESSION['cart'][$menu_id]['jumlah'] * $m['harga'];
    } else {
        $_SESSION['cart'][$menu_id] = [
            'menu_id' => $menu_id,
            'nama' => $m['nama_menu'],
            'harga' => $m['harga'],
            'jumlah' => $jumlah,
            'subtotal' => $jumlah * $m['harga']
        ];
    }
    header('Location: ../public/keranjang.php');
}
?>
