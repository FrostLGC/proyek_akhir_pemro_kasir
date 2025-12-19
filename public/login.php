<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    $qAdmin = mysqli_query($conn,
        "SELECT * FROM users WHERE email='$email' AND password='$pass' LIMIT 1"
    );
    if ($qAdmin && mysqli_num_rows($qAdmin) === 1) {
        $user = mysqli_fetch_assoc($qAdmin);
        $_SESSION['admin'] = $user;
        header('Location: ../admin/dashboard.php');
        exit;
    }
    $qCust = mysqli_query($conn,
        "SELECT * FROM customers WHERE email='$email' AND password='$pass' LIMIT 1"
    );
    if ($qCust && mysqli_num_rows($qCust) === 1) {
        $cust = mysqli_fetch_assoc($qCust);
        $_SESSION['customer'] = $cust;
        header('Location: menu.php');
        exit;
    }
    $error = 'Email atau password salah';
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h2>Login</h2>
<?php if ($error): ?>
<p style="color:red"><?php echo $error; ?></p>
<?php endif; ?>
<form method="post">
    <label>Email
      <input type="email" name="email" required>
    </label>
    <label>Password
      <input type="password" name="password" required> 
      <button type="submit">Login</button>
    </label>
</form>
<p>
    Belum punya akun?
    <a href="register.php">Daftar Pelanggan</a>
</p>
<p>
  Kembali Ke 
  <a href="index.php">Menu</a>
</p>
</body>
</html>
