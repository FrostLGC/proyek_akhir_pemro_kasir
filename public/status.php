<?php
require_once __DIR__ . '/../config/database.php';
$kode = isset($_GET['kode']) ? mysqli_real_escape_string($conn, $_GET['kode']) : '';
$pesanan = null; $details = [];
if ($kode) {
    $q = mysqli_query($conn, "SELECT * FROM pesanan WHERE kode='{$kode}'");
    if ($q && mysqli_num_rows($q)) {
        $pesanan = mysqli_fetch_assoc($q);
        $dq = mysqli_query($conn, "SELECT dp.*, m.nama_menu FROM detail_pesanan dp JOIN menu m ON dp.menu_id=m.id WHERE dp.pesanan_id={$pesanan['id']}");
        while($r = mysqli_fetch_assoc($dq)) $details[] = $r;
    }
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Status Pesanan</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
<body>
<header>
  <h1>Status Pesanan</h1>
</header>
<main>
<form method="get" action="../public/status.php">
  <label>Masukkan Kode Pesanan: <input type="text" name="kode"></label>
  <button type="submit">Cek</button>
</form>
<?php if ($pesanan) { ?>
  <h3>Pesanan: <?php echo htmlspecialchars($pesanan['kode']); ?></h3>
  <p>Nama: <?php echo htmlspecialchars($pesanan['nama_pemesan']); ?></p>
  <p>Meja: <?php echo htmlspecialchars($pesanan['meja']); ?></p>
  <p>Status: <?php echo htmlspecialchars($pesanan['status']); ?></p>
  <p>Total: Rp <?php echo number_format($pesanan['total_harga'],0,',','.'); ?></p>
  <h4>Detail</h4><ul>
    <?php 
    foreach($details as $d){ echo '<li>'.htmlspecialchars($d['nama_menu']).' x'.$d['jumlah'].' - Rp '.number_format($d['subtotal'],0,',','.').'</li>'; } 
    ?>
  </ul>
<?php } ?>
</main>
</body>
</html>
