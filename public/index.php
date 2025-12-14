<?php
session_start();
require_once __DIR__ . '/../config/database.php';
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Cafe</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<header>
  <h2>Cafe AHMF</h2>
  <nav>
    <a href="../public/menu.php">Menu</a>
    <a href="../public/riwayat_pesanan.php">Riwayat</a>
    <?php if(!isset($_SESSION['customer'])): ?>
      <a href="../public/register.php">Register</a>
      <a href="../public/login.php">Login</a>
    <?php else: ?>
      <a href="../public/logout.php">Logout</a>
    <?php endif; ?>
    <a href="../admin/login.php">Admin</a>
  </nav>
</header>
<main>
  <h1>Selamat datang di Cafe AHMF</h1>
  <p><a href="../public/menu.php">Lihat Menu</a></p>
</main>
</body>
</html>
