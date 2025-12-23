<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['customer'])) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer']['id'];

$pesanan = mysqli_query($conn,
    "SELECT * FROM pesanan 
     WHERE customer_id = $customer_id 
     ORDER BY created_at DESC"
);

function label($s){
    return match($s){
        'menunggu' => 'Menunggu',
        'diproses' => 'Sedang dimasak',
        'selesai'  => 'Siap diantar',
        'diantar'  => 'Sudah diantar',
        'dibayar'  => 'Sudah dibayar',
        default    => ucfirst($s)
    };
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Riwayat Pesanan</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>Riwayat Pesanan</h2>
<a href="menu.php">Kembali ke Menu</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
<tr>
  <th>Kode</th>
  <th>Detail Pesanan</th>
  <th>Total</th>
  <th>Status</th>
  <th>Tanggal</th>
</tr>

<?php while($p = mysqli_fetch_assoc($pesanan)){ ?>

<?php
  // ambil detail item per pesanan
  $detail = mysqli_query($conn,
      "SELECT dp.jumlah, m.nama_menu
       FROM detail_pesanan dp
       JOIN menu m ON dp.menu_id = m.id
       WHERE dp.pesanan_id = {$p['id']}"
  );
?>

<tr>
  <td><?php echo $p['kode']; ?></td>

  <td>
    <ul style="margin:0; padding-left:18px;">
      <?php while($d = mysqli_fetch_assoc($detail)){ ?>
        <li>
          <?php echo htmlspecialchars($d['nama_menu']); ?>
          x<?php echo $d['jumlah']; ?>
        </li>
      <?php } ?>
    </ul>
  </td>

  <td>Rp <?php echo number_format($p['total_harga'],0,',','.'); ?></td>
  <td><?php echo label($p['status']); ?></td>
  <td><?php echo $p['created_at']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>
