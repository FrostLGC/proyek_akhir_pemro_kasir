<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) { header('Location: ../admin/login.php'); exit; }
$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE id={$id}");
if (!$q || mysqli_num_rows($q)==0) { echo 'Tidak ditemukan'; exit; }
$pes = mysqli_fetch_assoc($q);
$det = mysqli_query($conn, "SELECT dp.*, m.nama_menu FROM detail_pesanan dp JOIN menu m ON dp.menu_id=m.id WHERE dp.pesanan_id={$id}");
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>Detail Pesanan <?php echo $pes['kode']; ?></h1>
<p>Nama: <?php echo htmlspecialchars($pes['nama_pemesan']); ?></p>
<p>Status: <?php echo htmlspecialchars($pes['status']); ?></p>
<p>
  <a href="../admin/print_struk.php?id=<?php echo $pes['id']; ?>" target="_blank">
    Cetak Struk PDF
  </a>
</p>
<form method="post" action="../admin/pesanan.php">
  <input type="hidden" name="id" value="<?php echo $pes['id']; ?>">
  <select name="status">
    <option value="menunggu" <?php if($pes['status']=='menunggu') echo 'selected'; ?>>menunggu</option>
    <option value="diproses" <?php if($pes['status']=='diproses') echo 'selected'; ?>>diproses</option>
    <option value="selesai" <?php if($pes['status']=='selesai') echo 'selected'; ?>>selesai</option>
    <option value="dibayar" <?php if($pes['status']=='dibayar') echo 'selected'; ?>>dibayar</option>
  </select>
  <button type="submit" name="update_status">Update</button>
</form>
<h3>Detail</h3>
<ul>
  <?php 
  while($d = mysqli_fetch_assoc($det)){ 
    echo '<li>'.htmlspecialchars($d['nama_menu']).' x'.$d['jumlah'].' - Rp '.number_format($d['subtotal'],0,',','.').'</li>'; } 
  ?>
</ul>
<p>
  Kembali Ke 
  <a href="dashboard.php">Dashboard</a>
</p>
</body>
</html>
