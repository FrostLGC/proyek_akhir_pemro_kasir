<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['admin'])) {
    header('Location: ../admin/dashboard.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cafe AHMF</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header>
    <h2>Cafe AHMF</h2>
    <nav>
        <a href="menu.php">Menu</a>
        <?php if (isset($_SESSION['customer'])): ?>
            <a href="riwayat_pesanan.php">Riwayat</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <h1>Selamat Datang di Cafe AHMF</h1>
    <p>Nikmati berbagai menu makanan dan minuman favorit kami.</p>
    <p>
        <a href="menu.php" class="btn btn-primary">Lihat Menu</a>
    </p>
</main>

</body>
</html>
