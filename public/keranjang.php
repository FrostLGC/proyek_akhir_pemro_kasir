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
<table class="cart" border="1" cellpadding="8">
<tr>
  <th>Menu</th>
  <th>Harga</th>
  <th>Jumlah</th>
  <th>Aksi</th>
  <th>Subtotal</th>
</tr>

<?php foreach ($cart as $index => $item) { ?>
<tr>
  <td><?php echo htmlspecialchars($item['nama']); ?></td>

  <td>Rp <?php echo number_format($item['harga'],0,',','.'); ?></td>

  <td style="text-align:center;">
    <a href="update_keranjang.php?index=<?php echo $index; ?>&aksi=kurang">−</a>
    <strong><?php echo $item['jumlah']; ?></strong>
    <a href="update_keranjang.php?index=<?php echo $index; ?>&aksi=tambah">+</a>
  </td>

  <td style="text-align:center;">
    <a href="update_keranjang.php?index=<?php echo $index; ?>&aksi=hapus">
       <!-- onclick="return confirm('Hapus item ini?')"> -->
       Hapus
    </a>
  </td>

  <td>Rp <?php echo number_format($item['subtotal'],0,',','.'); ?></td>
</tr>
<?php } ?>

<tr>
  <td colspan="4" style="text-align:right;"><strong>Total</strong></td>
  <td><strong>Rp <?php echo number_format($total,0,',','.'); ?></strong></td>
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
