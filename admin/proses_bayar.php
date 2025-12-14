<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) { header('Location: ../admin/login.php'); exit; }
$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE id={$id}");
if(!$q || mysqli_num_rows($q)==0){ echo 'Tidak ditemukan'; exit; }
$pes = mysqli_fetch_assoc($q);
$det = mysqli_query($conn, "SELECT dp.*, m.nama_menu FROM detail_pesanan dp JOIN menu m ON dp.menu_id=m.id WHERE dp.pesanan_id={$id}");
if($_SERVER['REQUEST_METHOD']=='POST'){
    $bayar   = intval($_POST['bayar']);
    $kembali = $bayar - intval($pes['total_harga']);
    mysqli_query($conn, "INSERT INTO transaksi (pesanan_id,bayar,kembali,metode) 
                          VALUES ({$id},{$bayar},{$kembali},'tunai')");
    mysqli_query($conn, "UPDATE pesanan SET status='dibayar' WHERE id={$id}");
    $done = true;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proses Bayar</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h1>Proses Bayar <?php echo htmlspecialchars($pes['kode']); ?></h1>
<a href="../admin/dashboard.php">Dashboard</a>
<ul>
<?php while($d=mysqli_fetch_assoc($det)){ ?>
    <li><?php echo htmlspecialchars($d['nama_menu']) . ' x' . $d['jumlah'] . ' - Rp ' . number_format($d['subtotal']); ?></li>
<?php } ?>
</ul>
<p>Total: Rp <?php echo number_format($pes['total_harga']); ?></p>
<?php if (!isset($done)) { ?>
    <form method="post">
      <label>Bayar: 
        <input type="number" name="bayar" required>
      </label>
      <button type="submit">Bayar & Cetak</button>
    </form>
<?php } ?>
<?php if (isset($done)) { ?>
    <h2>Pembayaran Berhasil!</h2>
    <p>
      <a href="../admin/print_struk.php?id=<?php echo $id; ?>" target="_blank">
        Cetak Struk PDF
      </a>
    </p>
    <p>
      <a href="../admin/dashboard.php">Kembali ke Dashboard</a>
    </p>
<?php exit; } ?>
</body>
</html>
