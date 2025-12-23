<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) { header('Location: ../admin/login.php'); exit; }
$q = mysqli_query($conn, "SELECT t.*, p.kode FROM transaksi t JOIN pesanan p ON t.pesanan_id=p.id ORDER BY t.created_at DESC");
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Transaksi</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>Transaksi</h1><a href="../admin/dashboard.php">Dashboard</a>
<table border="1">
<tr>
    <th>Kode</th>
    <th>Bayar</th>
    <th>Kembali</th>
    <th>Tanggal</th>
    <th>Aksi</th>
</tr>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
    <td><?php echo $r['kode']; ?></td>
    <td><?php echo number_format($r['bayar']); ?></td>
    <td><?php echo number_format($r['kembali']); ?></td>
    <td><?php echo $r['created_at']; ?></td>
    <td>
        <a href="print_struk.php?id=<?php echo $r['pesanan_id']; ?>" target="_blank">
            Cetak Struk
        </a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
