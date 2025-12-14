<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$err = '';
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'");
    if ($q && mysqli_num_rows($q)) {
        $u = mysqli_fetch_assoc($q);
        if ($pass == $u['password']) {
            $_SESSION['admin'] = $u;
            header('Location: ../admin/dashboard.php');
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
<title>Login Admin</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h2>Login Admin</h2>
<?php if($err) echo '<p style="color:red">'.$err.'</p>'; ?>
<form method="post">
  <label>Email:
    <input type="email" name="email" required>
  </label>
  <label>Password:
    <input type="password" name="password" required>
  </label>
  <button type="submit" name="login">Login</button>
</form>
</body>
</html>
