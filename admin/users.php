<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['admin']['role'] !== 'admin') {
    echo 'Akses ditolak';
    exit;
}
if (isset($_POST['add'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    $role  = $_POST['role'];
    mysqli_query($conn,
        "INSERT INTO users (nama, email, password, role)
          VALUES ('$nama', '$email', '$pass', '$role')"
    );
    header('Location: users.php');
    exit;
}
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY role, nama");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Manajemen User</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header>
    <h2>Manajemen User</h2>
</header>
<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="menu.php">Menu</a>
    <a href="kategori.php">Kategori</a>
    <a href="pesanan.php">Pesanan</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="logout.php">Logout</a>
</nav>
<!-- <div class="container"> -->
    <!-- <div class="card"> -->
        <h3>Tambah User</h3>
        <form method="post">
            <label>Nama</label>
            <input type="text" name="nama" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <label>Role</label>
            <select name="role" required>
                <option value="kasir">Kasir</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="add" class="btn btn-primary">
                Tambah User
            </button>
        </form>
    <!-- </div> -->
    <!-- <div class="card"> -->
        <h3>Daftar User</h3>
        <table border="1" cellpadding="0" cellspacing="0">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['nama']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo htmlspecialchars($u['role']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <!-- </div> -->
<!-- </div> -->
</body>
</html>
