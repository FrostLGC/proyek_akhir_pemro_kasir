<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    $q = mysqli_query($conn, "SELECT * FROM customers WHERE email='{$email}'");
    if ($q && mysqli_num_rows($q)) {
        $u = mysqli_fetch_assoc($q);
        if ($pass == $u['password']) {
            $_SESSION['customer'] = $u;
            header('Location: ../public/menu.php');
            exit;
        }
    }
    $err = 'Email atau password salah';
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
<h2>Login Pelanggan</h2>
<?php if($err) echo '<p style="color:red">'.$err.'</p>'; ?>
<form method="post">
  <label>Email:
    <input type="email" name="email" required>
  </label>
  <label>Password:
    <input type="password" name="password" required>
  </label>
  <button type="submit">Login</button>
</form>
</body>
</html>
