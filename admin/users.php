<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) { header('Location: ../admin/login.php'); exit; }
if (isset($_POST['add'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    mysqli_query($conn,
        "INSERT INTO users (nama,email,password,role)
          VALUES ('{$nama}','{$email}','{$pass}','admin')"
    );
    header('Location: ../admin/users.php');
    exit;
}
$users = mysqli_query($conn, "SELECT * FROM users");
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Users</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>Kelola Users</h1><a href="../admin/dashboard.php">Dashboard</a>
<h3>Tambah User</h3>
<form method="post">
  <label>Nama: <input type="text" name="nama"></label>
  <label>Email: <input type="email" name="email"></label>
  <label>Password: <input type="password" name="password"></label>
  <button type="submit" name="add">Tambah</button>
</form>
<h3>Daftar Admin</h3>
<ul>
  <?php 
  while($u = mysqli_fetch_assoc($users)) echo '<li>'.htmlspecialchars($u['nama']).' - '.htmlspecialchars($u['email']).'</li>'; 
  ?>
</ul>
</body>
</html>
