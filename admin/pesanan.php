<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) { header('Location: ../admin/login.php'); exit; }
if (isset($_POST['update_status'])){
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($conn,$_POST['status']);
    mysqli_query($conn, "UPDATE pesanan SET status='{$status}' WHERE id={$id}");
}
$p = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY created_at DESC");
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pesanan</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>Daftar Pesanan</h1>
<nav>
  <a href="../admin/dashboard.php">Dashboard</a>
</nav>
<table border="1">
  <tr>
    <th>Kode</th>
    <th>Nama</th>
    <th>Total</th>
    <th>Status</th>
    <th>Aksi</th>
  </tr>
<?php 
while($r = mysqli_fetch_assoc($p)){ 
  echo 
  '<tr>
  <td>'.$r['kode'].'</td>
  <td>'.$r['nama_pemesan'].'</td>
  <td>'.number_format($r['total_harga']).'</td>
  <td>'.$r['status'].'</td>
  <td><a href="../admin/detail_pesanan.php?id='.$r['id'].'">Detail</a></td>
  </tr>'; } ?>
</table>
</body>
</html>
