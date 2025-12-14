<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) { header('Location: ../admin/login.php'); exit; }
$res = mysqli_query($conn, "SELECT * FROM menu ORDER BY nama_menu");
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['items'])){
    $items = $_POST['items']; 
    $nama = mysqli_real_escape_string($conn,$_POST['nama_pemesan']);
    $meja = mysqli_real_escape_string($conn,$_POST['meja']);
    $total = 0;
    foreach($items as $mid => $j) {
        $mid = intval($mid); $j = intval($j);
        $r = mysqli_query($conn, "SELECT * FROM menu WHERE id={$mid}");
        if($r && mysqli_num_rows($r)){ $m = mysqli_fetch_assoc($r); $total += $m['harga']*$j; }
    }
    $kode = 'P'.date('ymdHis').rand(10,99);
    mysqli_query($conn, "INSERT INTO pesanan (kode,nama_pemesan,meja,total_harga,status) VALUES ('{$kode}','{$nama}','{$meja}',{$total},'menunggu')");
    $pid = mysqli_insert_id($conn);
    foreach($items as $mid=>$j){
        $mid=intval($mid); $j=intval($j);
        $r = mysqli_query($conn, "SELECT * FROM menu WHERE id={$mid}");
        if($r && mysqli_num_rows($r)){ $m=mysqli_fetch_assoc($r); $sub=$m['harga']*$j; mysqli_query($conn, "INSERT INTO detail_pesanan (pesanan_id,menu_id,jumlah,subtotal) VALUES ({$pid},{$mid},{$j},{$sub})"); }
    }
    header('Location: ../admin/proses_bayar.php?id='.$pid); exit;
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Buat Pesanan</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>POS - Buat Pesanan</h1>
<a href="../admin/dashboard.php">Dashboard</a>
<form method="post">
  <label>Nama Pemesan: <input type="text" name="nama_pemesan" required></label>
  <label>Meja: <input type="text" name="meja"></label>
  <h3>Menu</h3>
  <?php while($m=mysqli_fetch_assoc($res)){ ?>
    <div>
      <strong><?php echo htmlspecialchars($m['nama_menu']); ?></strong> - Rp <?php echo number_format($m['harga']); ?>
      <input type="number" name="items[<?php echo $m['id']; ?>]" min="0" value="0">
    </div>
  <?php } ?>
  <button type="submit">Buat Pesanan</button>
</form>
</body>
</html>
