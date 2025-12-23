<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../public/login.php');
    exit;
}

$role = $_SESSION['admin']['role'];
$id = intval($_GET['id']);

$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE id={$id}");
if (!$q || mysqli_num_rows($q) == 0) {
    echo 'Pesanan tidak ditemukan';
    exit;
}

$pes = mysqli_fetch_assoc($q);
$det = mysqli_query($conn,
    "SELECT dp.*, m.nama_menu 
     FROM detail_pesanan dp 
     JOIN menu m ON dp.menu_id=m.id 
     WHERE dp.pesanan_id={$id}"
);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Detail Pesanan</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h1>Detail Pesanan <?php echo $pes['kode']; ?></h1>

<p>Nama: <?php echo htmlspecialchars($pes['nama_pemesan']); ?></p>
<p>Meja: <?php echo $pes['meja'] ? htmlspecialchars($pes['meja']) : '-'; ?></p>
<p>Status: <b><?php echo ucfirst($pes['status']); ?></b></p>

<?php if ($role === 'kasir' && $pes['status'] === 'diantar'): ?>
    <p>
        <a href="bayar.php?id=<?php echo $pes['id']; ?>">
            Proses Pembayaran
        </a>
    </p>
<?php endif; ?>

<?php if (($role === 'admin' || $role === 'kasir') && $pes['status'] === 'dibayar'): ?>
    <p>
        <a href="print_struk.php?id=<?php echo $pes['id']; ?>" target="_blank">
            Cetak Struk PDF
        </a>
    </p>
<?php endif; ?>



<?php if ($role === 'dapur'): ?>
    <?php if ($pes['status'] === 'menunggu'): ?>
        <a href="dapur.php?id=<?php echo $pes['id']; ?>&aksi=proses">Proses Masak</a>
    <?php elseif ($pes['status'] === 'diproses'): ?>
        <a href="dapur.php?id=<?php echo $pes['id']; ?>&aksi=selesai">Selesai</a>
    <?php endif; ?>
<?php endif; ?>

<?php if ($role === 'waiter' && $pes['status'] === 'selesai'): ?>
    <a href="waiter.php?id=<?php echo $pes['id']; ?>">Pesanan Sudah Diantar</a>
<?php endif; ?>

<hr>

<h3>Detail Item</h3>
<ul>
<?php while($d = mysqli_fetch_assoc($det)){ ?>
  <li>
    <?php echo htmlspecialchars($d['nama_menu']); ?>
    x<?php echo $d['jumlah']; ?>
    – Rp <?php echo number_format($d['subtotal'],0,',','.'); ?>
  </li>
<?php } ?>
</ul>

<p>
  Kembali ke <a href="dashboard.php">Dashboard</a>
</p>

</body>
</html>
