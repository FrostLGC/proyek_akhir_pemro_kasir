<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../public/login.php');
    exit;
}
if ($_SESSION['admin']['role'] !== 'admin') {
    echo "Akses ditolak. Hanya admin yang boleh mengelola kategori.";
    exit;
}
if(isset($_POST['add'])){
    $nama = mysqli_real_escape_string($conn,$_POST['nama']);
    mysqli_query($conn, "INSERT INTO kategori (nama) VALUES ('{$nama}')");
    header('Location: ../admin/kategori.php'); exit;
}
$cats = mysqli_query($conn, "SELECT * FROM kategori");
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Kategori</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>Kelola Kategori</h1>
<a href="../admin/dashboard.php">Dashboard</a>
<form method="post">
  <label>Nama: <input type="text" name="nama"></label>
  <button type="submit" name="add">Tambah</button>
</form>
<ul>
  <?php 
  while($c = mysqli_fetch_assoc($cats)) 
    echo '<li>'.htmlspecialchars($c['nama']).'</li>'; 
  ?>
</ul>
</body></html>
