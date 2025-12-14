<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0; foreach($cart as $c) $total += $c['subtotal'];
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Keranjang</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<header>
  <h1>Keranjang</h1>
  <nav><a href="../public/menu.php">Lanjutkan Belanja</a></nav>
</header>
<main>
<?php if (!$cart) { echo '<p>Keranjang kosong</p>'; } else { ?>
  <table class="cart">
    <tr><th>Menu</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
    <?php foreach($cart as $item){ ?>
      <tr>
        <td><?php echo htmlspecialchars($item['nama']); ?></td>
        <td>Rp <?php echo number_format($item['harga'],0,',','.'); ?></td>
        <td><?php echo $item['jumlah']; ?></td>
        <td>Rp <?php echo number_format($item['subtotal'],0,',','.'); ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="3">Total</td>
      <td>Rp <?php echo number_format($total,0,',','.'); ?>
    </td>
  </tr>
  </table>
  <h3>Checkout</h3>
  <form method="post" action="../public/checkout.php">
    <label>Nama Pemesan: <input type="text" name="nama_pemesan" required value="<?php echo isset($_SESSION['customer'])?htmlspecialchars($_SESSION['customer']['nama']):''; ?>"></label>
    <label>Meja (optional): <input type="text" name="meja"></label>
    <button type="submit">Buat Pesanan</button>
  </form>
<?php } ?>
</main>
</body>
</html>
