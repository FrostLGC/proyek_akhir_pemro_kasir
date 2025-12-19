<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    $q = mysqli_query($conn,
        "INSERT INTO customers (nama, email, password)
          VALUES ('{$nama}', '{$email}', '{$pass}')"
    );
    if ($q) {
        header('Location: ../public/login.php');
        exit;
    } else {
        $err = 'Gagal register! Email mungkin sudah terdaftar.';
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h2>Register</h2>
<?php if($err) echo '<p style="color:red">'.$err.'</p>'; ?>
<form method="post">
  <label>Nama:
    <input type="text" name="nama" required>
  </label>
  <label>Email:
    <input type="email" name="email" required>
  </label>
  <label>Password:
    <input type="password" name="password" required>
      <button type="submit">Daftar</button>
  </label>
</form>
<p>
  Sudah punya akun?
  <a href="login.php">Login</a>
</p>
<p>
  Kembali Ke 
  <a href="index.php">Menu</a>
</p>
</body>
</html>
