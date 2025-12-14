<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$sql = "SELECT m.*, k.nama as kategori FROM menu m LEFT JOIN kategori k ON m.kategori_id=k.id ORDER BY k.nama, m.nama_menu";
$res = mysqli_query($conn, $sql);
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Menu</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
<body>
<header>
  <h1>Menu</h1>
  <nav><a href="../public/index.php">Home</a> | <a href="../public/keranjang.php">Keranjang</a></nav>
</header>
<main>
<div class="cards">
<?php while($row = mysqli_fetch_assoc($res)) { ?>
  <div class="card">
    <!-- <?php if($row['foto']){ ?>
      <img src="../uploads/menu_images/<?php echo htmlspecialchars($row['foto']); ?>" alt="">
    <?php } else { ?>
      <div class="noimg">No Image</div>
    <?php } ?> -->
    <h3><?php echo htmlspecialchars($row['nama_menu']); ?></h3>
    <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
    <p>Rp <?php echo number_format($row['harga'],0,',','.'); ?></p>
    <form method="post" action="../public/tambah_keranjang.php">
      <input type="hidden" name="menu_id" value="<?php echo $row['id']; ?>">
      <input type="number" name="jumlah" value="1" min="1" style="width:60px">
      <button type="submit">Tambah</button>
    </form>
  </div>
<?php } ?>
</div>
</main>
</body>
</html>
