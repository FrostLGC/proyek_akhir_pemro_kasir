<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) { header('Location: ../admin/login.php'); exit; }
$pes = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY created_at DESC LIMIT 20");
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>Halo, <?php echo htmlspecialchars($_SESSION['admin']['nama']); ?></h1>
<nav>
  <a href="../admin/menu.php">Kelola Menu</a> |
  <a href="../admin/kategori.php">Kategori</a> |
  <a href="../admin/users.php">Users</a> |
  <a href="../admin/pesanan.php">Pesanan</a> |
  <a href="../admin/transaksi.php">Transaksi</a> |
  <a href="../admin/pos.php">Buat Pesanan</a> |
  <a href="../admin/logout.php">Logout</a>
</nav>
<h3>Pesanan Terbaru</h3>
<table border="1">
  <tr>
    <th>Kode</th>
    <th>Nama</th>
    <th>Total</th>
    <th>Status</th>
    <th>Tgl</th>
  </tr>
<?php 
while($r = mysqli_fetch_assoc($pes)){ 
  echo '<tr>
  <td>'.$r['kode'].'</td>
  <td>'.$r['nama_pemesan'].'</td>
  <td>'.number_format($r['total_harga']).'</td>
  <td>'.$r['status'].'</td>
  <td>'.$r['created_at'].'</td>
  </tr>'; } 
?>
</table>
</body>
</html>
