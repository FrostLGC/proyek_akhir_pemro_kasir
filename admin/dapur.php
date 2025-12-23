<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin']['role'] !== 'dapur') {
    echo "Akses ditolak";
    exit;
}

// update status
if (isset($_GET['id'], $_GET['aksi'])) {
    $id = intval($_GET['id']);

    if ($_GET['aksi'] === 'proses') {
        mysqli_query($conn, "UPDATE pesanan SET status='diproses' WHERE id=$id");
    }
    if ($_GET['aksi'] === 'selesai') {
        mysqli_query($conn, "UPDATE pesanan SET status='selesai' WHERE id=$id");
    }
    header('Location: dapur.php');
    exit;
}

$pesanan = mysqli_query($conn,
    "SELECT * FROM pesanan 
     WHERE status IN ('menunggu','diproses')
     ORDER BY created_at ASC"
);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dapur</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Pesanan Masuk Dapur</h2>
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
    <?php if ($p['status'] === 'menunggu'): ?>
      <a href="?id=<?php echo $p['id']; ?>&aksi=proses">Proses</a>
    <?php elseif ($p['status'] === 'diproses'): ?>
      <a href="?id=<?php echo $p['id']; ?>&aksi=selesai">Selesai</a>
    <?php endif; ?>
  </td>
</tr>
<?php } ?>
</table>

</body>
</html>
