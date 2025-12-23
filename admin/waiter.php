<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin']['role'] !== 'waiter') {
    echo "Akses ditolak";
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn,
        "UPDATE pesanan SET status='diantar' WHERE id=$id"
    );
    header('Location: waiter.php');
    exit;
}

$pesanan = mysqli_query($conn,
    "SELECT * FROM pesanan 
     WHERE status='selesai'
     ORDER BY created_at ASC"
);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Waiter</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Pesanan Siap Diantar</h2>
<a href="dashboard.php">Dashboard</a>

<table border="1" cellpadding="8">
<tr>
  <th>Kode</th>
  <th>Nama</th>
  <th>Meja</th>
  <th>Status</th>
  <th>Detail</th>
  <th>Aksi</th>
</tr>

<?php while($p = mysqli_fetch_assoc($pesanan)){ ?>
<tr>
  <td><?php echo $p['kode']; ?></td>
  <td><?php echo htmlspecialchars($p['nama_pemesan']); ?></td>
  <td><?php echo $p['meja']; ?></td>
  <td><?php echo ucfirst($p['status']); ?></td>
  <td><a href="detail_pesanan.php?id=<?php echo $p['id']; ?>"> Lihat</a></td>
  <td>
    <a href="?id=<?php echo $p['id']; ?>">Antar</a>
  </td>
</tr>
<?php } ?>
</table>

</body>
</html>
